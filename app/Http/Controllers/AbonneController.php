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
    public function index(Request $request)
    {
        $mois = $request->filled('mois')? (int) $request->mois: now()->month;

        $annee = $request->filled('annee')? (int) $request->annee: now()->year;

        $abonnes = Abonne::with(['unite','paiements' => function ($query) use ($mois, $annee) {
                $query->where('mois', $mois)
                    ->where('annee', $annee);
            }
        ])->latest()->get();
        
        // Statistiques
        $totalAbonnes = $abonnes->count();

        $abonnesPayes = $abonnes->filter(function ($abonne) {
            return $abonne->paiements->where('statut', 'payé')->isNotEmpty();
        })->count();

        $abonnesNonPayes = $totalAbonnes - $abonnesPayes;

        $montantEncaisse = $abonnes->sum(function ($abonne) {
            return $abonne->paiements->where('statut', 'payé')->sum('montant');
        });

        $tauxRecouvrement = $totalAbonnes > 0 ? round(($abonnesPayes / $totalAbonnes) * 100, 2) : 0;
        
        return view('dashboard.abonnes.index', compact('abonnes', 'mois', 'annee', 'totalAbonnes', 'abonnesPayes', 'abonnesNonPayes', 'montantEncaisse', 'tauxRecouvrement'));
    }


    // recherche abonne par nom ou telephone
    public function abonneSearch(Request $request)
    {
        $search = $request->input('search');

        $mois = $request->filled('mois')? (int) $request->mois: now()->month;
        $annee = $request->filled('annee')? (int) $request->annee: now()->year;

        $abonnes = Abonne::with(['unite','paiements' => function ($query) use ($mois, $annee) {
                $query->where('mois', $mois)
                    ->where('annee', $annee);
            }
        ])->where('unite_id', request()->user()->unite_id)->where(function ($query) use ($search) {
                $query->where('nom_complet', 'like', '%' . $search . '%')->orWhere('telephone', 'like', '%' . $search . '%');
                })->latest()->paginate(50)->withQueryString();

        // Statistiques
        $totalAbonnes = $abonnes->count();

        $abonnesPayes = $abonnes->filter(function ($abonne) {
            return $abonne->paiements->where('statut', 'payé')->isNotEmpty();
        })->count();

        $abonnesNonPayes = $totalAbonnes - $abonnesPayes;

        $montantEncaisse = $abonnes->sum(function ($abonne) {
            return $abonne->paiements->where('statut', 'payé')->sum('montant');
        });

        $tauxRecouvrement = $totalAbonnes > 0 ? round(($abonnesPayes / $totalAbonnes) * 100, 2) : 0;

        return view('dashboard.abonnes.index', compact('abonnes', 'mois', 'annee', 'totalAbonnes', 'abonnesPayes', 'abonnesNonPayes', 'montantEncaisse', 'tauxRecouvrement'));
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
