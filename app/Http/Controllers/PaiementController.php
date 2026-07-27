<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Recette;
use App\Models\Vente;
use App\Models\Abonne;
use App\Models\Paiement_abonne;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paiements = Paiement::where('unite_id', request()->user()->unite_id)->with('vente.client')->latest()->paginate(10); 

        return view('dashboard.paiements.index', compact('paiements'));
    }


    // paiement abonne
    public function paiementAbonne(Request $request)
    {
        $request->validate([
            'abonne_id' => 'required|exists:abonnes,id',
            'montant' => 'required|numeric|min:1',
            'mode_paiement' => 'required',
        ]);

        $abonne = Abonne::findOrFail($request->abonne_id);

        $abonne->paiements()->update([
            'abonne_id' => $abonne->id,
            'statut' => 'payé',
            'montant' => $request->montant,
            'mode_paiement' => $request->mode_paiement,
            'date_paiement' => now(),
            'valide_par' => request()->user()->id,
            'reference_paiement' => 'PAY-' . time()
        ]);
        

         // 2. Création automatique de la recette
        Recette::create([
            'user_id' => $request->user()->id,
            'unite_id' => request()->user()->unite_id,
            'paiement_id' => null, // Pas de paiement lié pour les abonnés
            'reference' => 'REC-' . now()->timestamp,
            'libelle' => 'Recette abonnement ' . $abonne->nom_complet,
            'montant' => $abonne->paiements()->latest()->first()->montant,
            'date_recette' => now(),
            'mode_paiement' => $abonne->paiements()->latest()->first()->mode_paiement,
            'statut' => 'recu',
        ]);

        return back()->with('success', 'Paiement enregistré avec succès');
    
    
    
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
            'vente_id' => 'required|exists:ventes,id',
            'montant' => 'required|numeric|min:1',
            'mode_paiement' => 'required',
        ]);
        //dd($request);

        $vente = Vente::findOrFail($request->vente_id);

        
        $totalPaye = $vente->paiements()->where('statut','valide')->sum('montant');
        $reste = $vente->total_ttc - $totalPaye;

        if ($request->montant > $reste) {
            return back()->withErrors([
                'montant' => 'Le montant dépasse le reste à payer.'
            ]);
        }


        $paiement= Paiement::create([
            'unite_id' => request()->user()->unite_id,
            'user_id' => request()->user()->id,
            'vente_id' => $vente->id,
            'montant' => $request->montant,
            'mode_paiement' => $request->mode_paiement,
            'date_paiement' => now(),
            'reference' => 'PAY-' . time()
        ]);


        // Mise à jour du statut de la vente
        $vente = $paiement->vente;

        $totalPaye = $vente->paiements()->where('statut','valide')->sum('montant');

        $vente->statut = $totalPaye == 0 ? 'impayee' : ($totalPaye < $vente->total_ttc ? 'partielle' : 'payee');

        $vente->save();

        // 2. Création automatique de la recette
        Recette::create([
            'user_id' => $request->user()->id,
            'unite_id' => request()->user()->unite_id,
            'paiement_id' => $paiement->id,
            'reference' => 'REC-' . now()->timestamp,
            'libelle' => 'Recette vente ' . $paiement->vente->reference,
            'montant' => $paiement->montant,
            'date_recette' => now(),
            'mode_paiement' => 'cash',
            'statut' => 'recu',
        ]);


        return back()->with('success', 'Paiement enregistré avec succès');
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
