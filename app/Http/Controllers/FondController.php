<?php

namespace App\Http\Controllers;

use App\Models\Fonds;
use Illuminate\Http\Request;

class FondController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fonds = Fonds::where('unite_id', request()->user()->unite_id)->latest()->paginate(10);

        return view('admin.fonds.index', compact('fonds'));
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
            'libelle' => 'required',
            'montant' => 'required|numeric|min:0',
            'date_fond' => 'required|date',
            'mode_paiement' => 'required'
        ]);

        Fonds::create([
            'unite_id' => $request->user()->unite_id,
            'user_id' => $request->user()->id,
            'reference' => 'FND-' . now()->timestamp,
            'libelle' => $request->libelle,
            'description' => $request->description,
            'montant' => $request->montant,
            'date_fond' => $request->date_fond,
            'mode_paiement' => $request->mode_paiement,
        ]);

        return redirect()->back()->with('success', 'Fonds enregistrée avec succès');
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
