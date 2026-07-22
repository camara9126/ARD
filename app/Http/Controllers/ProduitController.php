<?php

namespace App\Http\Controllers;

use App\Models\Achat;
use App\Models\AchatDetail;
use App\Models\Categorie;
use App\Models\Depense;
use App\Models\Fournisseur;
use App\Models\MouvementStock;
use Illuminate\Support\Str;
use App\Models\Produit;
use App\Models\ProduitIntrant;
use App\Models\Unite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produits= Produit::with('fournisseur')->where('unite_id', request()->user()->unite_id)->latest()->paginate(10);
        $categorie= Categorie::where('unite_id', request()->user()->unite_id)->latest()->get();
        $fournisseur = Fournisseur::where('unite_id', request()->user()->unite_id)->with('produit')->latest()->get();
        $intrants= ProduitIntrant::where('unite_id', request()->user()->unite_id)->latest()->get();
        return view('dashboard.produits.index', compact('produits', 'categorie','fournisseur', 'intrants'));
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
            'intrants' => 'array|min:1',
            'intrants.*.id',
            'intrants.*.quantite',
        ]);
// dd($request);

        DB::beginTransaction();
    
        try {

            //Creation de fournisseur
            if($request->fournisseur) {
                
                $fournisseur= Fournisseur::create([
                    'nom' => $request->fournisseur,
                    'unite_id' => $request->user()->unite_id,
                ]);
            }


            $unite= Unite::Where('id', request()->user()->unite_id)->first(); 

            if($unite->categorie_id == 1) {

                $produit= Produit::create([
                    'unite_id' => $request->user()->unite_id,
                    'fournisseur_id' => $request->fournisseur_id ?? $fournisseur->id ?? null,
                    'categorie_id' => $request->categorie_id ?? $categorie->id ?? null,
                    'nom' => $request->nom,
                    'code' => $this->generateCode($request->user()->unite_id),
                    'prix_vente' => $request->prix_vente,
                    'stock_min' => $request->stock_min ?? 0,
                    'stock' => $request->stock ?? 0,
                ]);

                foreach ($request->intrants as $item) {

                    $intrant = ProduitIntrant::where('id', $item['id'])->lockForUpdate()->first(); // verrou stock
// dd($intrant);
                    if ($intrant->quantite < $item['quantite']) {
                        dd('Quantite insuffisant dans ce dépôt');
                    }

                    // Mise a jour quantite Intrant
                    $intrant->decrement('quantite', $item['quantite']);

                    // Enregistrememt historique stock
                    MouvementStock::create([
                        'unite_id' => $request->user()->unite_id,
                        'designation' => $intrant->designation,
                        'type' => 'sortie',
                        'quantite' => $item['quantite'],
                        'reference' => 'MVT/SRT-' . now()->timestamp,
                        'user_id' => $request->user()->id,
                    ]);

                }

                // Enregistrement d'un historique de mouvement
                MouvementStock::create([
                    'unite_id' => $request->user()->unite_id,
                    'produit_id' => $produit->id,
                    'type' => 'entree',
                    'quantite' => $request->stock ?? 100,
                    'reference' => 'MVT-PRD-' . now()->timestamp,
                    'user_id' => $request->user()->id,
                ]);
            } 

            DB::commit();
            return redirect()->route('produit.index')->with('success', 'Produit ajouté avec succès');

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
        $produit->delete();

        // if($produit->statut == true) {
        //      $produit->update(['statut' => false]);

        //      return redirect()->route('produit.index')->with('success', 'Produit désactivé');
        // } else
        //     $produit->update(['statut' => true]);

        return redirect()->route('produit.index')->with('success', 'Produit suprimé');
    }


    private function generateCode(int $uniteId): string
    {
        $lastProduit = Produit::where('unite_id', $uniteId)->orderBy('id', 'desc')->first();

        $number = $lastProduit ? intval(substr($lastProduit->code, -5)) + 1 : 1;

        return 'PRD-' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }
}
