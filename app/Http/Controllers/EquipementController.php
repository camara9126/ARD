<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use Illuminate\Http\Request;

class EquipementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipements= Equipement::where('unite_id', request()->user()->unite_id)->latest()->get();

        return view('dashboard.equipements.index', compact('equipements'));
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
            'nom' => 'required',
            'valeur_achat' => 'required|numeric|min:0',
            'duree_vie_annees' => 'required|numeric',
            'date_mise_service' => 'required|date',
        ]);

        Equipement::create([
            'nom' => $request->nom,
            'valeur_achat' => $request->valeur_achat,
            'duree_vie_annees' => $request->duree_vie_annees,
            'date_mise_service' => $request->date_mise_service ?? now(),
            'unite_id' => $request->user()->unite_id
        ]);

        return redirect()->back()->with('success', 'Equipement enregistré avec success !');
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
        $equipement= Equipement::findOrFail($id);

         $request->validate([
            'nom',
            'valeur_achat' ,
            'duree_vie_annees' ,
            'date_mise_service' ,
        ]);

        $equipement->update([
            'nom' => $request->nom ?? $equipement->nom,
            'valeur_achat' => $request->valeur_achat ?? $equipement->valeur_achat,
            'duree_vie_annees' => $request->duree_vie_annees ?? $equipement->duree_vie_annees,
            'date_mise_service' => $request->date_mise_service ?? $equipement->date_mise_service
        ]);

        return redirect()->back()->with('success', 'Equipement modifié avec success !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipement= Equipement::findOrFail($id);
        $equipement->delete();

        return redirect()->back()->with('success', 'Equipement supprimé !');
    }
}
