<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompteBancaires;
use App\Models\MouvementBancaires;

class MouvementBanqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $mouvementsBancaires =MouvementBancaires::where('compte_bancaires_id', '!=', null)->latest()->get();
        $compteBancaires = CompteBancaires::where('unite_id', request()->user()->unite_id)->get();

        return view('dashboard.mouvementBanque.index', compact('mouvementsBancaires', 'compteBancaires'));
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
            'compte_bancaires_id' => 'required|exists:compte_bancaires,id',
            'type' => 'required|in:virement,retrait,depot,versement,encaissement,autre',
            'montant' => 'required|numeric|min:0',
            'frais' => 'nullable|numeric|min:0',
            'motif' => 'nullable|string|max:255',
            'reference' => 'nullable|string|max:255',
            'date_operation' => 'required|date',
        ]);

        try {

            $compteBancaire = CompteBancaires::findOrFail($request->compte_bancaires_id);
//dd($compteBancaire);
            $mouvement = MouvementBancaires::create([
                'type' => $request->type,
                'montant' => $request->montant,
                'frais' => $request->frais,
                'motif' => $request->motif,
                'reference' => $request->reference ?? $request->type . '-' . now()->timestamp,
                'date_operation' => $request->date_operation,
                'compte_bancaires_id' => $compteBancaire->id,
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
