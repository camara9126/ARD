<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Unite;
use App\Models\User;
use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentUserUniteId = request()->user()->unite_id;

       $repUnites = Unite::select('unites.id','unites.nom')->where('id', '!=', $currentUserUniteId)->selectSub(function ($query) {

                $query->from('ventes')->selectRaw('COALESCE(SUM(total))')->whereColumn('unite_id', 'unites.id')->whereMonth('created_at', now()->month);

            }, 'total_ventes')->selectSub(function ($query) {

                $query->from('depenses')->selectRaw('COALESCE(SUM(montant))')->whereColumn('unite_id', 'unites.id')->whereMonth('created_at', now()->month);

            }, 'total_depenses')->get();
//dd($unites);

             // Permettre de changer de mois via l'URL ?mois=5&annee=2026
            $mois = $request->get('mois', now()->month);
            $annee = $request->get('annee', now()->year);
            
            // Liste des mois pour le filtre
            $moisListe = [
                1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
                5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
                9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
            ];
            
            $unites = Unite::select('unites.id', 'unites.nom')->where('nom', '!=', 'ARD')->selectSub(function ($query) use ($mois, $annee) {

                    $query->from('ventes')->selectRaw('COALESCE(SUM(total), 0)')->whereColumn('unite_id', 'unites.id')->whereMonth('created_at', $mois)->whereYear('created_at', $annee);

                }, 'productivite')->having('productivite', '>', 0); // Ne montrer que les unités avec des ventes->get()
            
            $labels = $unites->pluck('nom')->toArray();
            $data = $unites->pluck('productivite')->toArray();

                return view('dashboard', compact('repUnites','unites', 'labels', 'data', 'mois', 'annee', 'moisListe'));
    }


    // Liste des Unites
    public function unites()
    {
        $unites= Unite::where('nom', '!=', 'ARD')->latest()->get();

        return view('admin.listeUnites', compact('unites'));
    }


    // Liste des Utilisateurs
    public function users()
    {
        $users= User::where('role', '!=', 'admin')->latest()->get();

        return view('admin.listeUsers', compact('users'));
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
     * Display rapport des unites.
     */
    public function show(string $id)
    {
        $unite = Unite::findOrFail($id);

        // Période (mois actuel par défaut)
        $debut = Carbon::now()->startOfMonth();
        $fin = Carbon::now()->endOfMonth();

        // VENTES
        $ventes = Vente::where('unite_id', $id)->whereBetween('created_at', [$debut, $fin])->get();

        $totalVentes = $ventes->sum('total_ttc');

        // DEPENSES
        $depenses = Depense::where('unite_id', $id)->whereBetween('created_at', [$debut, $fin])->get();

        $totalDepenses = $depenses->sum('montant');

        $net = $totalVentes - $totalDepenses;

        // Analyse automatique
        $analyse = $net >= 0 ? "L'unité est bénéficiaire sur la période" : "L'unité est en déficit sur la période";

        $data = compact('unite','ventes','depenses','totalVentes','totalDepenses','net','analyse','debut','fin');

        $pdf = Pdf::loadView('admin.rapportUnite', $data);

        return $pdf->stream('admin.rapportUnite-'.$unite->id.'.pdf');
    }


    // Repartition des ventes, depenses et recettes
    public function repartitionRecettes()
    {
        $unites = Unite::select('unites.id','unites.nom')->selectSub(function ($query) {

        $query->from('ventes')->selectRaw('COALESCE(SUM(total),0)')->whereColumn('unite_id', 'unites.id');

            }, 'total_ventes')->selectSub(function ($query) {

                $query->from('depenses')->selectRaw('COALESCE(SUM(montant),0)')->whereColumn('unite_id', 'unites.id');

            }, 'total_depenses')->get();

        return view('dashboard', compact('unites'));
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
