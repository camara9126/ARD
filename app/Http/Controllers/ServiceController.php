<?php

namespace App\Http\Controllers;

use App\Models\MouvementStock;
use App\Models\Service;
use App\Models\ServiceIntrant;
use App\Models\Unite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unite= Unite::Where('id', request()->user()->unite_id)->first(); 

        $services= Service::where('unite_id', request()->user()->unite_id)->latest()->paginate(10);
        // Service instrant
        $intrants= ServiceIntrant::where('unite_id', request()->user()->unite_id)->latest()->get();
        return view('dashboard.services.index', compact('unite','services', 'intrants'));
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
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'intrants' => 'array',
            'intrants.*.id',
            'intrants.*.quantite',
            'description',
            'unite_de_mesure',
            'categorie'
        ]);
    // dd($request);

        DB::beginTransaction();
    
        try {

                $service= Service::create([
                    'unite_id' => $request->user()->unite_id,
                    'description' => $request->description ?? null,
                    'unite_de_mesure' => $request->unite_de_mesure ?? null,
                    'nom' => $request->nom,
                    'prix' => $request->prix,
                    'categorie' => $request->categorie ?? null
                ]);

                if(!empty($request->intrants) && is_array($request->intrants)) {
                
                    foreach ($request->intrants as $item) {


                        $intrant = ServiceIntrant::where('id', $item['id'])->lockForUpdate()->first(); // verrou stock
                        // dd($intrant);

                        // if ($intrant->quantite < $item['quantite']) {
                        //     throw new \Exception('Quantite insuffisant dans cet intrant');
                        // }

                        // Mise a jour quantite Intrant
                        // $intrant->decrement('quantite', $item['quantite']);
                        
                        // Enregistrememt historique stock
                        MouvementStock::create([
                            'unite_id' => $request->user()->unite_id,
                            'designation' => $intrant->designation,
                            'type' => 'sortie',
                            'quantite' => $item['quantite'] ?? 0,
                            'reference' => 'MVT/CSM-' . now()->timestamp,
                            'user_id' => $request->user()->id,
                        ]);
                    }
                }

                // Enregistrement d'un historique de mouvement
                MouvementStock::create([
                    'unite_id' => $request->user()->unite_id,
                    'designation' => $service->nom,
                    'type' => 'entree',
                    'quantite' => 1,
                    'reference' => 'MVT/SRC-' . now()->timestamp,
                    'user_id' => $request->user()->id,
                ]);


            DB::commit();
            return redirect()->route('service.index')->with('success', 'Service ajouté avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('danger', 'Erreur: ' . $e->getMessage());
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
        $service= Service::findorFail($id);

         $request->validate([
            'nom' => 'required|string|max:255',
            'prix' => 'required|numeric|min:0',
            'description',
            'unite_de_mesure',
            'categorie'
         ]);

        $service->update([
            'unite_id' => $request->user()->unite_id,
            'description' => $request->description ?? null,
            'unite_de_mesure' => $request->unite_de_mesure ?? null,
            'nom' => $request->nom,
            'prix' => $request->prix,
            'categorie' => $request->categorie ?? null
        ]);

        return redirect()->route('service.index')->with('success', 'Service modifié');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
