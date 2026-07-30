<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unite;
use App\Models\ProduitIntrant;
use App\Models\ServiceIntrant;

class IntrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unite= Unite::Where('id', request()->user()->unite_id)->first(); 

        if($unite->categorie->slug == 'service') {

            $intrants= ServiceIntrant::where('unite_id', request()->user()->unite_id)->latest()->paginate(10);
            
            return view('dashboard.intrants.index', compact('unite','intrants'));
        } elseif($unite->categorie->slug == 'transformation') {

            $intrants= ProduitIntrant::where('unite_id', request()->user()->unite_id)->latest()->paginate(10);
           
            return view('dashboard.intrants.index', compact('unite','intrants'));        
        }
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
        $request->validate([
            'nom' => 'required|string|max:255',
            'prix_unitaire' => 'required|numeric|min:0',
        ]);

        $unite= Unite::Where('id', request()->user()->unite_id)->first(); 

        if($unite->categorie->slug == 'service') {

            $intrant = ServiceIntrant::findOrFail($id);

            $intrant->designation = $request->nom;
            $intrant->prix_unitaire = $request->prix_unitaire;

            $intrant->save();
            
            return redirect()->route('intrant.index')->with('success', 'Intrant mis à jour avec succès.');

        } elseif($unite->categorie->slug == 'transformation') {

            $intrant = ProduitIntrant::findOrFail($id);

            $intrant->designation = $request->nom;
            $intrant->prix_unitaire = $request->prix_unitaire;

            $intrant->save();
            
            return redirect()->route('intrant.index')->with('success', 'Intrant mis à jour avec succès.');        
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unite= Unite::Where('id', request()->user()->unite_id)->first(); 

        if($unite->categorie->slug == 'service') {

            $intrant = ServiceIntrant::findOrFail($id);
            $intrant->delete();
            
            return redirect()->route('intrant.index')->with('success', 'Intrant supprimé avec succès.');

        } elseif($unite->categorie->slug == 'transformation') {

            $intrant = ProduitIntrant::findOrFail($id);
            $intrant->delete();
            
            return redirect()->route('intrant.index')->with('success', 'Intrant supprimé avec succès.');        
        }
    }
}
