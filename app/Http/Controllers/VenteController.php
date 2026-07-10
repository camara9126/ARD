<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\MouvementStock;
use App\Models\Paiement;
use App\Models\Produit;
use App\Models\Recette;
use App\Models\Unite;
use App\Models\Vente;
use App\Models\VenteItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class VenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ventes = Vente::with('client')->where('unite_id', request()->user()->unite_id)->latest()->simplePaginate(10); 

        return view('dashboard.ventes.index', compact('ventes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::where('unite_id', request()->user()->unite_id)->latest()->get();
        $unite= request()->user()->unite;
        $produits = Produit::where( 'unite_id', request()->user()->unite_id)->where('statut', true)->latest()->get();

        return view('dashboard.ventes.create', compact('clients', 'produits', 'unite'));
    }

    // Recherche caisse
    public function caisseSearch(Request $request)
    {
        $query = $request->q;

        $produits = Produit::where('unite_id', request()->user()->unite_id)->where('nom', 'LIKE', "%{$query}%")->limit(50)->get();

        return response()->json($produits);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'nullable|exists:clients,id',
            'produits' => 'required|array|min:1',
            'produits.*.produit_id' => 'required',
            'produits.*.quantite' => 'required|numeric|min:1',
            'produits.*.prix_vente' => 'required|numeric|min:0',
            'montant' => 'numeric|min:0'
        ]);

        DB::beginTransaction();
    
        try {

            // Creation vente item
            $unite= Unite::Where('id', request()->user()->unite_id)->first(); // Recuperation de la TVA de l'unite

                //dd($request->montant);
                $vente = Vente::create([
                    'client_id' =>  $request->client_id ?? null,
                    'reference' => 'VNT-' . time(),
                    'date' => now(),
                    'total' => 0,
                    'total_tva' => 0,
                    'total_ttc' => 0,
                    'statut' => 'impayee',
                    'user_id' => request()->user()->id,
                    'unite_id' => $unite->id,
                ]);

                $total = 0;
                $total_tva = 0;
                $total_ttc = 0;
            //dd($request->all());
            foreach ($request->produits as $item) {
            
                if (empty($item['produit_id'])) {
                    continue;
                }

                $produit = Produit::where('id', $item['produit_id'])->lockForUpdate()->first(); // verrou stock

                // Verification stock mouvement
                if ($produit->stock == 0) {

                    return redirect()->back()->with('danger','Vous devez enregister un mouvement d"abord');
                }

                // Alert stock minimum depasse
                if ($produit->stock <= $produit->stock_min) {
                    return redirect()->back()->with('danger','Votre stock minimum est depasse');
                }


                // Verification quantite de stock
                if ($produit->stock < $item['quantite']) {
                    
                    return redirect()->back()->with('danger','Stock insuffisant pour cette produit ');
                }
        
                VenteItem::create([
                    'unite_id' => $request->user()->unite_id,
                    'vente_id' => $vente->id,
                    'produit_id' => $item['produit_id'],
                    'quantite' => $item['quantite'],
                    'prix_unitaire' => $item['prix_vente'],
                    'taux_tva' => $unite->taux_tva,
                    'montant_tva' => ($item['quantite'] * $item['prix_vente']) * ($unite->taux_tva /100 ),
                    'total_ttc' => ($item['quantite'] * $item['prix_vente']) + (($item['quantite'] * $item['prix_vente']) * ($unite->taux_tva /100 )),
                    'total' => $item['quantite'] * $item['prix_vente'],
                ]);

                // Mise a jour stock
                $produit->decrement('stock', $item['quantite']);

                // Enregistrememt historique stock
                    MouvementStock::create([
                        'produit_id' => $produit->id,
                        'type' => 'sortie',
                        'quantite' => $item['quantite'],
                        'reference' => 'MVT-' . now()->timestamp,
                        'unite_id' => request()->user()->unite_id,
                        'user_id' => request()->user()->id,
                    ]);

                // Calcule total + total_tva + total_ttc
                $total += $item['quantite'] *  $item['prix_vente'];
                $total_tva += ($item['quantite'] * $item['prix_vente']) * ($unite->taux_tva /100 );
                $total_ttc += ($item['quantite'] * $item['prix_vente']) + (($item['quantite'] * $item['prix_vente']) * ($unite->taux_tva /100 ));
                
                // Mise a jour total + total_tva + total_ttc
                $vente->update([
                    'total' => $total,
                    'total_tva' => $total_tva,
                    'total_ttc' => $total_ttc,
                ]);
                
            }
            
                // creation paiement
                $paiement = $vente;

                $totalPaye = $paiement->paiements()->where('statut','valide')->sum('montant');

                $paiements= Paiement::create([
                    'vente_id' => $vente->id,
                    'unite_id' => request()->user()->unite_id,
                    'user_id' => request()->user()->id,
                    'montant' => $vente->total_ttc,
                    'mode_paiement' => 'cash',
                    'date_paiement' => now(),
                    'statut' => 'valide',
                    'reference' => 'PAY-' . time()
                ]);


                // Mise à jour du statut de la vente
                $vente = $paiements->vente;

                $totalPaye = $vente->paiements()->where('statut','valide')->sum('montant');

                $vente->statut = $totalPaye == 0 ? 'impayee' : ($totalPaye < $vente->total_ttc ? 'partielle' : 'payee');

                $vente->save();


                // 2. Création automatique de la recette
                if($vente->statut == 'payee') {
                    Recette::create([
                        'user_id' => $request->user()->id,
                        'unite_id' => request()->user()->unite_id,
                        'paiement_id' => $paiements->id,
                        'reference' => 'REC-' . now()->timestamp,
                        'libelle' => 'Paiement vente ' . $vente->reference,
                        'montant' => $vente->total_ttc,
                        'date_recette' => now(),
                        'mode_paiement' => 'cash',
                        'statut' => 'recu',
                    ]);
                }
           
                DB::commit();
                return redirect()->route('vente.index')->with('success', 'Vente effectuée avec succès');

            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('danger', 'Erreur lors de la conversion: ' . $e->getMessage());
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unite= Unite::Where('id', request()->user()->unite_id)->first();
        
        $vente= Vente::with('client', 'items', 'paiements')->findOrFail($id);
//dd($vente);
        $vente->load(['client', 'items', 'paiements']);

        $pdf = Pdf::loadView('dashboard.ventes.PDF', compact('vente', 'unite'));

        return $pdf->stream('Facture-' . $vente->reference . '.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // Liste de factures
    public function facture()
    {
        $factures = Vente::where('unite_id', request()->user()->unite_id)->with('client')->latest()->simplePaginate(10); 

        return view('dashboard.ventes.factures', compact('factures'));
    }
}
