<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Unite;
use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class UniteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('unite.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user= request()->user();

        $request->validate([
            'nom' => 'string|max:255',
            'adresse' => 'string',
            'contact' => 'numeric|min:9',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gestion des logo
        if ($request->hasFile('logo')) {

            $filename = time().$request->file('logo')->getClientOriginalName();
            $path = $request->file('logo')->storeAs('logo', $filename, 'public');
            $request['logo'] = '/storage/' . $path;
        }


         $unite= Unite::create([
            'nom' => $request->nom,
            'adresse' => $request->adresse,
            'contact' => $request->contact,
            'logo' =>  $request->contact,
         ]);

         $user->update([
            'unite_id' => $unite->id
            ]);


        return redirect()->route('dashboard');
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
        $unite = unite::FindOrFail($id);

         $request->validate([
            'contact' => 'nullable|string|max:50',
            'taux_tva' => 'numeric|max:100',
            'adresse' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ninea' => 'nullable',
        ]);

        // Gestion des logo
        if ($request->hasFile('logo')) {
            
            if($unite->logo){
                Storage::delete('public/logo/'.$unite->logo);
            }

            $filename = time().$request->file('logo')->getClientOriginalName();
            $path = $request->file('logo')->storeAs('logo', $filename, 'public');
            $request['logo'] = '/storage/' . $path;
           
        } else {
            $unite->logo;
        }

        $unite->update([
            'contact' => $request->contact,
            'taux_tva' => $request->taux_tva,
            'adresse' => $request->adresse,
            'logo' => $path  ?? $unite->logo,
            'ninea' => $request->ninea  ?? null,
        ]);


        // Lier l'utilisateur a l'unite
        $user= $request->user();
        $user->save();

        return redirect()->back()->with('success', 'unite mise a jour avec success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    
}
