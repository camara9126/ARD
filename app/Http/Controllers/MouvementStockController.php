<?php

namespace App\Http\Controllers;

use App\Models\MouvementStock;
use App\Models\Produit;
use Illuminate\Http\Request;

class MouvementStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mouvements= MouvementStock::where('unite_id', request()->user()->unite_id)->with('produit')->latest()->get();

        $produits= Produit::where('unite_id', request()->user()->unite_id)->latest()->get();

        return view('dashboard.mouvementStocks.index', compact('mouvements','produits'));
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
            'produit_id' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1',
            'type' => 'required',
        ]);

        $produit = Produit::findOrFail($request->produit_id);

        MouvementStock::create([
            'unite_id' => $request->user()->unite_id,
            'produit_id' => $produit->id,
            'type' => $request->type,
            'quantite' => $request->quantite,
            'reference' => 'MVT-TCK-' . now()->timestamp,
            'user_id' => $request->user()->id,
        ]);

        if($request->type == 'entree') {


            $produit->increment('stock', $request->quantite);
            
            return back()->with('success', 'Entrée de stock enregistrée');
        } else {

            $produit->decrement('stock', $request->quantite);

            return back()->with('success', 'Sortie de stock enregistrée');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
