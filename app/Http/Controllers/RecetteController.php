<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Recette;
use Illuminate\Http\Request;

class RecetteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recettes = Recette::where('unite_id', request()->user()->unite_id)->latest()->paginate(10);

        $paiements = Paiement::where('unite_id', request()->user()->unite_id)->where('statut', 'valide')->with('vente.client')->orderBy('created_at', 'desc')->get();

        return view('dashboard.recettes.index', compact('recettes','paiements'));
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
            'libelle' => 'required',
            'montant' => 'required|numeric|min:0',
            'date_recette' => 'required|date',
            'mode_paiement' => 'required',
        ]);

        Recette::create([
            'user_id' => $request->user()->id,
            'unite_id' => $request->user()->unite_id,
            'reference' => 'REC-' . now()->timestamp,
            'libelle' => $request->libelle,
            'description' => $request->description,
            'montant' => $request->montant,
            'date_recette' => $request->date_recette,
            'paiement_id' => $request->paiement_id,
            'mode_paiement' => $request->mode_paiement,
        ]);

        return back()->with('success', 'Recette enregistrée avec succès');
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
