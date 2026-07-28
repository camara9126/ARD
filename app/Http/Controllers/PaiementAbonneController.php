<?php

namespace App\Http\Controllers;
use App\Models\Recette;
use App\Models\Abonne;
use App\Models\Paiement_abonne;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class PaiementAbonneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'abonne_id' => 'required|exists:abonnes,id',
            'montant' => 'required|numeric|min:1',
            'mode_paiement' => 'required',
            'mois' => 'required|integer|between:1,12',
            'annee' => 'required|integer',
        ]);

         DB::beginTransaction();
        // dd($request);
        try {

            $abonne = Abonne::findOrFail($request->abonne_id);


            $abonne->paiements()->create([
                'abonne_id' => $abonne->id,
                'mois' => $request->mois,
                'annee' => $request->annee,
                'statut' => 'payé',
                'montant' => $request->montant,
                'mode_paiement' => $request->mode_paiement,
                'date_paiement' => now(),
                'valide_par' => request()->user()->id,
                'reference_paiement' => 'PAY-' . now()->format('YmdHis')
            ]);
            
            // 2. Création automatique de la recette
            Recette::create([
                'user_id' => $request->user()->id,
                'unite_id' => request()->user()->unite_id,
                'paiement_id' => null, // Pas de paiement lié pour les abonnés
                'reference' => 'REC-' . now()->timestamp,
                'libelle' => 'Recette paiement ' . $abonne->nom_complet,
                'montant' => $abonne->paiements()->latest()->first()->montant,
                'date_recette' => now(),
                'mode_paiement' => $abonne->paiements()->latest()->first()->mode_paiement,
                'statut' => 'recu',
            ]);

            DB::commit();

        return back()->with('success', 'Paiement enregistré avec succès');

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
