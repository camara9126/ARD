<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompteBancaires;
use App\Models\MouvementBancaires;

class CompteBancaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compteBancaires = CompteBancaires::latest()->get();

        return view('dashboard.compteBancaires.index', compact('compteBancaires'));
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
            'banque' => 'required|string|max:255',
            'numero_compte' => 'required|string|max:255|unique:compte_bancaires,numero_compte',
            'titulaire' => 'required|string|max:255',
            'solde_initial' => 'required|numeric|min:0',
            'date_ouverture' => 'required|date',
            'statut' => 'in:actif,inactif',
        ]);

        try {
                $compteBancaire = CompteBancaires::create([
                    'banque' => $request->banque,
                    'numero_compte' => $request->numero_compte,
                    'titulaire' => $request->titulaire,
                    'solde_initial' => $request->solde_initial,
                    'date_ouverture' => $request->date_ouverture,
                    'statut' => $request->statut ?? 'actif',
                    'unite_id' => request()->user()->unite_id,
                ]);

                return redirect()->back()->with('success', 'Compte bancaire créé avec succès.');

            } catch (\Exception $e) {

                return redirect()->back()->with('danger', "Erreur lors de la création du compte bancaire : " . $e->getMessage());
            }

    }

    /**
     * Store a newly created mouvement in storage.
     */
    public function mouvementStore(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:virement,retrait,depot,versement,encaissement,autre',
            'montant' => 'required|numeric|min:0',
            'frais' => 'nullable|numeric|min:0',
            'motif' => 'required|string|max:255',
            'reference' => 'required|string|max:255',
            'date_operation' => 'required|date',
        ]);

        try {
            $compteBancaire = CompteBancaires::findOrFail($id);

            $mouvement = MouvementBancaires::create([
                'type' => $request->type,
                'montant' => $request->montant,
                'frais' => $request->frais,
                'motif' => $request->motif,
                'reference' => $request->reference,
                'date_operation' => $request->date_operation,
                'compte_id' => $compteBancaire->id,
            ]);

            if ($request->type === 'depot' || $request->type === 'versement' || $request->type === 'encaissement') {

                $compteBancaire->increment('solde_initial', $request->montant);
            
            } elseif ($request->type === 'retrait' || $request->type === 'virement') {

                $compteBancaire->decrement('solde_initial', $request->montant);

            }

            return redirect()->back()->with('success', 'Mouvement bancaire enregistré avec succès.');

        } catch (\Exception $e) {

            return redirect()->back()->with('danger', "Erreur lors de l'enregistrement du mouvement bancaire : " . $e->getMessage());
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
        $request->validate([
            'banque' => 'required|string|max:255',
            'numero_compte' => 'required|string|max:255|unique:compte_bancaires,numero_compte,' . $id,
            
        ]);

        try {
                $compteBancaire = CompteBancaires::findOrFail($id);

                $compteBancaire->update([
                    'banque' => $request->banque,
                    'numero_compte' => $request->numero_compte,
                ]);

                return redirect()->back()->with('success', 'Compte bancaire mis à jour avec succès.');

            } catch (\Exception $e) {

                return redirect()->back()->with('danger', "Erreur lors de la mise à jour du compte bancaire : " . $e->getMessage());
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
