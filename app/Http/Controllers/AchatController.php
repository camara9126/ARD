<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\AchatDetail;
use App\Models\Depense;
use App\Models\Fournisseur;
use App\Models\MouvementStock;
use App\Models\Produit;
use App\Models\Unite;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class AchatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $achats = Achat::where('unite_id', request()->user()->unite_id)->with('fournisseur')->latest()->paginate(30);

        return view('dashboard.achats.index', compact('achats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fournisseurs = Fournisseur::where('unite_id', request()->user()->unite_id)->latest()->get();
        $produits = Produit::where('unite_id', request()->user()->unite_id)->latest()->get();

        return view('dashboard.achats.create', compact('fournisseurs', 'produits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fournisseur_id' => 'exists:fournisseurs,id',
            'produits' ,
            'designation' ,
            'designation.*.nom',
            'designation.*.prix',
            'designation.*.quantite',
            'produits.*.produit_id' ,
            'produits.*.quantite' => 'nullable|numeric|min:1',
            'produits.*.prix_vente' => 'nullable|numeric|min:0',
            'note' => 'nullable',
        ]);

         DB::beginTransaction();
    //dd($request);
        try {

            // Création du bon de commande
            $achat = Achat::create([
                'unite_id' => request()->user()->unite_id,
                'reference' => 'FAC-' . strtoupper(Str::random(6)),
                'fournisseur_id' => $request->fournisseur_id,
                'total' => 0,
                'note' => $request->note ?? 'null',
                'statut' => 'recu'
            ]);

            $total = 0;


            // Enregistrement du nouveau produit (designation) dans le AchatDetails
            if($request->designation) {

                foreach ($request->designation as $item) {

                    // Récupération de l'unite
                    $unite= Unite::Where('id', request()->user()->unite_id)->first(); 

                    $ligneTotal = $request->quantite * $request->prix;

                    AchatDetail::create([
                        'unite_id' => $unite->id,
                        'achat_id' => $achat->id,
                        'produit_id' => null,
                        'designation' => $item['nom'],
                        'quantite' => $item['quantite'],
                        'prix_unitaire' => $item['prix'],
                        'total' => $ligneTotal,
                    ]);

                    $total += $ligneTotal;

                    // Mise a jour du stock
                    MouvementStock::create([
                        'unite_id' => $unite->id,
                        'user_id' => request()->user()->id,
                        'produit_id' => null,
                        'designation' => $item['nom'],
                        'type' => 'entree',
                        'quantite' => $item['quantite'],
                        'reference' => 'MVT-' . now()->timestamp,
                    ]);

                }
                
            }

            if($request->produits) {
                foreach ($request->produits as $item) {

                    // Récupération de l'produit original 
                    $produit = produit::where('id', $item['produit_id'])->lockForUpdate()->first();

                    // Récupération de l'unite
                    $unite= Unite::Where('id', request()->user()->unite_id)->first(); 

                    $ligneTotal = $item['quantite'] * $item['prix_vente'];

                    AchatDetail::create([
                        'unite_id' => $unite->id,
                        'achat_id' => $achat->id,
                        'produit_id' => $item['produit_id'],
                        'quantite' => $item['quantite'],
                        'prix_unitaire' => $item['prix_vente'],
                        'total' => $ligneTotal,
                    ]);

                    $total += $ligneTotal;

                    // Ajouter la quantité au stock existant
                    $ancienStock = $produit->stock;
                    $nouvelleQuantite = $ancienStock + $item['quantite'];
            
                    $produit->update([
                        'stock' => $nouvelleQuantite,
                        'prix_achat' => $detail->prix_achat ?? $produit->prix_achat,
                        'prix_vente' => $detail->prix_vente ?? $produit->prix_vente, 
                        'fournisseur_id' => $achat->fournisseur_id, 
                    ]);


                    // Mise a jour du stock
                    MouvementStock::create([
                        'unite_id' => $unite->id,
                        'user_id' => request()->user()->id,
                        'produit_id' => $item['produit_id'],
                        'type' => 'entree',
                        'quantite' => $item['quantite'],
                        'reference' => 'MVT-' . now()->timestamp,
                    ]);
                    
                }
            }

            // Mise à jour du total
            $achat->update([
                'total' => $total
            ]);

            Depense::create([
                'unite_id' => $unite->id,
                'user_id' => request()->user()->id,
                'reference' => 'DEP-' . now()->timestamp,
                'libelle' => 'Achat - '. $achat->reference,
                'description' => 'Achat produit',
                'montant' => $achat->total,
                'date_depense' => now(),
                'mode_paiement' => 'cash',
            ]);

        DB::commit();

        return redirect()->route('achat.index')->with('success', 'Achat créé avec succès');

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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $unite= Unite::Where('id', request()->user()->unite_id)->first(); 

        //dd($id);
        $achat = Achat::with('fournisseur', 'details')->findOrFail($id);

        $achat->load(['fournisseur', 'details']);
        //dd($achat);
        $pdf = Pdf::loadView('dashboard.achats.factures', compact('achat', 'unite'));

        return $pdf->stream ('Facture-' . $achat->reference . '.pdf');
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
        $achat = Achat::findOrFail($id);
        $achat->delete();

        return back()->with('success', 'Achat supprimé');
    }

    private function generateCode(int $uniteId): string
    {
        $lastProduit = Produit::where('unite_id', $uniteId)->orderBy('id', 'desc')->first();

        $number = $lastProduit ? intval(substr($lastProduit->code, -5)) + 1 : 1;

        return 'PRD-' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }
}
