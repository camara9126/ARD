<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\AchatDetail;
use App\Models\Depense;
use App\Models\Fournisseur;
use App\Models\MouvementStock;
use App\Models\Produit;
use App\Models\Service;
use App\Models\ProduitIntrant;
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
            'designation' ,
            'designation.*.nom',
            'designation.*.prix',
            'designation.*.quantite',
            'produits' => 'array',
            'produits.*.nom' ,
            'produits.*.quantite' => 'numeric|min:1',
            'produits.*.prix_achat' => 'numeric|min:0',
            'note' => 'nullable',
        ]);

         DB::beginTransaction();
        // dd($request);
        try {

            // Création du bon de commande
            $achat = Achat::create([
                'unite_id' => request()->user()->unite_id,
                'reference' => 'FAC-ACT-' . strtoupper(Str::random(6)),
                'fournisseur_id' => $request->fournisseur_id,
                'total' => 0,
                'note' => $request->note ?? 'null',
                'statut' => 'recu'
            ]);

            $total = 0;


            // Enregistrement du nouveau produit (designation) dans le AchatDetails
            if(!empty($request->designation)) {

                foreach ($request->designation as $item) {

                    // Récupération de l'unite
                    $unite= Unite::Where('id', request()->user()->unite_id)->first(); 

                    $ligneTotal = $item['quantite'] * $item['prix'];

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
                
                    if($unite->categorie->nom == 'Transformation') {

                        // Création du produit intrant si l'unité est de type transformation
                        ProduitIntrant::create([
                            'unite_id' => $unite->id,
                            'designation' => $item['nom'],
                            'quantite' => $item['quantite'],
                        ]);
                    } elseif($unite->categorie->nom == 'Service') {

                        // Création du service intrant si l'unité est de type service
                        $service= service::where('id', $item['nom'])->lockForUpdate()->first();
dd($service);
                        ServiceIntrant::create([
                            'unite_id' => $unite->id,
                            'service_id' => $service->id,
                            'prix_unitaire' => $item['prix'],
                            'total' => $ligneTotal,
                            'designation' => $item['nom'],
                            'quantite' => $item['quantite'],
                        ]);
                    }

                    // Mise a jour du stock
                    MouvementStock::create([
                        'unite_id' => $unite->id,
                        'user_id' => request()->user()->id,
                        'produit_id' => null,
                        'designation' => $item['nom'],
                        'type' => 'entree',
                        'quantite' => $item['quantite'],
                        'reference' => 'MVT-ACT-' . now()->timestamp,
                    ]);

                }
                
            } elseif(!empty($request->produits)) {
                
                foreach ($request->produits as $item) {

                    // Récupération de l'unite
                    $unite= Unite::Where('id', request()->user()->unite_id)->first(); 

                    $ligneTotal = $item['quantite'] * $item['prix_achat'];

                    $total += $ligneTotal;


                    // Récupération du produit original rechercher
                    $produit = produit::where('id', $item['nom'])->lockForUpdate()->first();
                    // dd($produit);

                    // Verification si le produit existe
                    if(!empty($produit)) {

                        // Creation achat detail
                        AchatDetail::create([
                            'unite_id' => $unite->id,
                            'achat_id' => $achat->id,
                            'produit_id' => $item['nom'],
                            'quantite' => $item['quantite'],
                            'prix_unitaire' => $item['prix_achat'],
                            'total' => $ligneTotal,
                        ]);

                        // Ajouter la quantité au stock existant
                        $ancienStock = $produit->stock;
                        $nouvelleQuantite = $ancienStock + $item['quantite'];

                        $produit->update([
                            'stock' => $nouvelleQuantite,
                            'prix_achat' => $detail->prix_achat ?? $produit->prix_achat,
                            'prix_vente' => $produit->prix_vente, 
                            'fournisseur_id' => $request->fournisseur_id ?? $achat->fournisseur_id, 
                        ]);

                        // Enregistrement d'un historique de mouvement
                        MouvementStock::create([
                            'unite_id' => $request->user()->unite_id,
                            'produit_id' => $produit->id,
                            'type' => 'entree',
                            'quantite' => $item['quantite'],
                            'reference' => 'MVT/PRD-' . now()->timestamp,
                            'user_id' => $request->user()->id,
                        ]);

                    } else {

                        // Creation achat detail
                        AchatDetail::create([
                            'unite_id' => $unite->id,
                            'achat_id' => $achat->id,
                            'designation' => $item['nom'],
                            'quantite' => $item['quantite'],
                            'prix_unitaire' => $item['prix_achat'],
                            'total' => $ligneTotal,
                        ]);

                        // Creation nouveau produit
                        $produit= Produit::create([
                            'unite_id' => $request->user()->unite_id,
                            'fournisseur_id' => $request->fournisseur_id ?? null,
                            'categorie_id' => null,
                            'nom' => $item['nom'],
                            'code' => $this->generateCode($request->user()->unite_id),
                            'prix_achat' => $item['prix_achat'],
                            'prix_vente' => 0,
                            'stock_min' => 5,
                            'stock' => $item['quantite'],
                        ]);

                            
                        // Enregistrement d'un historique de mouvement
                        MouvementStock::create([
                            'unite_id' => $request->user()->unite_id,
                            'designation' => $item['nom'],
                            'type' => 'entree',
                            'quantite' => $item['quantite'],
                            'reference' => 'MVT/PRD-' . now()->timestamp,
                            'user_id' => $request->user()->id,
                        ]);
                    }
      
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
            return redirect()->back()->with('danger', 'Erreur : ' . $e->getMessage());
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
