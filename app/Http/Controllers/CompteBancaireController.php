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
        $compteBancaires = CompteBancaires::where('unite_id', request()->user()->unite_id)->latest()->get();

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
