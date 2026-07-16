<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\AchatDetail;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Models\MouvementStock;
use Illuminate\Support\Str;
use App\Models\Produit;
use App\Models\Unite;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits= Produit::with('fournisseur')->where('unite_id', request()->user()->unite_id)->latest()->simplePaginate(10);
        $categorie= Categorie::where('unite_id', request()->user()->unite_id)->latest()->get();
        $fournisseur = Fournisseur::where('unite_id', request()->user()->unite_id)->with('produit')->latest()->paginate(10);
        return view('dashboard.produits.index', compact('produits', 'categorie','fournisseur'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'fournisseur_id',
            'categorie_id',
            'prix_achat',
            'prix_vente' => 'required|numeric|min:0',
            'stock_min' => 'integer|min:0',
            'stock' => 'integer|min:1',
            'categorie',
            'fournisseur',
        ]);

        // Creation de categorie et ou fournisseur
        if($request->categorie) {
            
            $categorie= Categorie::create([
                'nom' => $request->categorie
            ]);

        }

        //Creation de fournisseur
        if($request->fournisseur) {
            
            $fournisseur= Fournisseur::create([
                'nom' => $request->fournisseur
            ]);
        }

        $produit= Produit::create([
            'unite_id' => $request->user()->unite_id,
            'fournisseur_id' => $request->fournisseur_id ?? $fournisseur->id ?? null,
            'categorie_id' => $request->categorie_id ?? $categorie->id ?? null,
            'nom' => $request->nom,
            'code' => $this->generateCode($request->user()->unite_id),
            'prix_achat' => $request->prix_achat ?? 0,
            'prix_vente' => $request->prix_vente,
            'stock_min' => $request->stock_min ?? 0,
            'stock' => $request->stock ?? 0,
        ]);

        IF($request->prix_achat) {
            // Création du bon de commande
            $achat = Achat::create([
                'unite_id' => request()->user()->unite_id,
                'reference' => 'FAC/ACT-' . strtoupper(Str::random(6)),
                'fournisseur_id' => $request->fournisseur_id,
                'total' => 0,
                'note' => $request->note ?? 'null',
                'statut' => 'recu'
            ]);

            $total = 0;       

            // Récupération de l'unite
            $unite= Unite::Where('id', request()->user()->unite_id)->first(); 

            $ligneTotal = $produit->stock * $produit->prix_vente;

            AchatDetail::create([
                'unite_id' => $unite->id,
                'achat_id' => $achat->id,
                'produit_id' => $produit->id,
                'quantite' => $produit->stock,
                'prix_unitaire' => $produit->prix_vente,
                'total' => $ligneTotal,
            ]);

            $total += $ligneTotal;
    
        }

        // Enregistrement d'un historique de mouvement
        MouvementStock::create([
            'unite_id' => $request->user()->unite_id,
            'produit_id' => $produit->id,
            'type' => 'entree',
            'quantite' => $request->stock ?? 100,
            'reference' => 'MVT/PRD-' . now()->timestamp,
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('produit.index')->with('success', 'Produit ajouté avec succès');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produit= Produit::findorFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'prix_vente' => 'numeric|min:0',
            'stock' => 'integer|min:0',
            'categorie_id',
            'fournisseur_id' ,
        ]);

        $produit->update([
            'nom' => $request->nom,
            'prix_vente' => $request->prix_vente,
            'stock' => $request->stock  ?? $produit->stock,
            'categorie_id' => $request->categorie_id ?? $produit->categorie_id,
            'fournisseur_id' => $request->fournisseur_id ?? $produit->fournisseur_id,
        ]);

        return redirect()->route('produit.index')->with('success', 'Produit modifié');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produit= Produit::findorFail($id);

        if($produit->statut == true) {
             $produit->update(['statut' => false]);

             return redirect()->route('produit.index')->with('success', 'Produit désactivé');
        } else
            $produit->update(['statut' => true]);

        return redirect()->route('produit.index')->with('success', 'Produit activé');
    }


    private function generateCode(int $uniteId): string
    {
        $lastProduit = Produit::where('unite_id', $uniteId)->orderBy('id', 'desc')->first();

        $number = $lastProduit ? intval(substr($lastProduit->code, -5)) + 1 : 1;

        return 'PRD-' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }
}
