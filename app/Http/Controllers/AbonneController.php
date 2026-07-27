<?php

namespace App\Http\Controllers;
use App\Models\Abonne;
use App\Models\Paiement_abonne;
use Illuminate\Http\Request;

class AbonneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $abonnes = Abonne::where('unite_id', request()->user()->unite_id)->latest()->paginate(50);

        return view('dashboard.abonnes.index', compact('abonnes'));
    }


    // recherche abonne par nom ou telephone
    public function abonneSearch(Request $request)
    {
        $search = $request->input('search');

        $abonnes = Abonne::where('unite_id', request()->user()->unite_id)->where(function ($query) use ($search) {
                $query->where('nom_complet', 'like', '%' . $search . '%')->orWhere('telephone', 'like', '%' . $search . '%');
                })->latest()->paginate(50)->withQueryString();

        return view('dashboard.abonnes.index', compact('abonnes'));
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
            'nom_complet' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
        ]);


        //creation de l'abonne avec le statut non payé
        $abonne = Abonne::create([
            'unite_id' => request()->user()->unite_id,
            'reference' => 'ABN-' . strtoupper(uniqid()),
            'nom_complet' => $request->nom_complet,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'date_abonnement' => now(),
        ]);

        // creation du paiement de l'abonne avec le statut non payé
        $abonne->paiements()->create([
            'mois' => now()->format('m'),
            'annee' => now()->format('Y'),
            'date_paiement' => now(),
            'abonne_id' => $abonne->id,
            'montant' => 0,
            'statut' => 'non payé',
            'valide_par' => request()->user()->name,
            'reference_paiement' => 'PAY-' . strtoupper(uniqid()),
            'mode_paiement' => 'cash',
        ]);



        return redirect()->back()->with('success', 'Abonné ajouté avec succès.');
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
        $abonne = Abonne::findOrFail($id);

        $request->validate([
            'nom_complet' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
        ]);

        $abonne->update([
            'nom_complet' => $request->nom_complet,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
        ]);

        return redirect()->back()->with('success', 'Abonné modifié avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $abonne = Abonne::findOrFail($id);

        // Supprimer les paiements associés à l'abonné
        $abonne->paiements()->delete();

        // Supprimer l'abonné
        $abonne->delete();

        return redirect()->back()->with('success', 'Abonné supprimé avec succès.');
    }
}
