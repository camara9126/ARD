<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paiements = Paiement::with('vente.client')->latest()->simplePaginate(50); 

        return view('dashboard.paiements.index', compact('paiements'));
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
        //
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
         $paiement = Paiement::findOrFail($id);
        

        $paiement->update([
            'statut' => 'annule',
            'motif' => $request->motif ?? 'Annulation manuelle',
            'annule_par' => request()->user()->id,
            'annule_le' => now(),
        ]);


        if($paiement->recette) {
            $paiement->recette->update(['statut' => 'annule']);
        }
          

        $vente = $paiement->vente;

        // Recalcul statut vente
        $totalPaye = $vente->paiements()->where('statut', 'valide')->sum('montant');

        $vente->statut = $totalPaye == 0 ? 'impayee' : ($totalPaye < $vente->total_ttc ? 'partielle' : 'payee');

        $vente->save();

        return back()->with('success', 'Paiement annulé avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       
    }
}
