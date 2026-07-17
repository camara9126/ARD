<?php

namespace App\Http\Controllers;

use App\Models\ChargeFixe;
use Illuminate\Http\Request;

class ChargeFixeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $charges = ChargeFixe::where('unite_id', request()->user()->unite_id)->latest()->paginate(10);

        return view('dashboard.chargeFixe.index', compact('charges'));
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
            'designation' => 'required',
            'intitulait' => 'required',
            'montant' => 'required|numeric|min:0',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'periode' => 'required',
            'description',
        ]);

        ChargeFixe::create([
            'unite_id' => $request->user()->unite_id,
            'user_id' => $request->user()->id,
            'designation' => $request->designation,
            'intitulait' => $request->intitulait,
            'periode' => $request->periode,
            'description' => $request->description,
            'montant' => $request->montant,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
        ]);

        return redirect()->back()->with('success', 'Charge enregistrée avec succès');
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
        $charge = ChargeFixe::findOrFail($id);

         $request->validate([
            'designation' => 'required',
            'intitulait' => 'string',
            'montant' => 'required|numeric|min:0',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'periode' => 'string',
            'description',
        ]);

        $charge->update([
            'unite_id' => $request->user()->unite_id,
            'user_id' => $request->user()->id,
            'designation' => $request->designation ?? $charge->designation,
            'intitulait' => $request->intitulait ?? $charge->intitulait,
            'periode' => $request->periode ?? $charge->periode,
            'description' => $request->description ?? $charge->description,
            'montant' => $request->montant ?? $charge->montant,
            'date_debut' => $request->date_debut ?? $charge->date_debut,
            'date_fin' => $request->date_fin ?? $charge->date_fin,
        ]);

        return back()->with('success', 'Charge modifiée avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $charge = ChargeFixe::findOrFail($id);
        $charge->delete();

        return back()->with('success', 'Charge supprimée avec succès');

    }
}
