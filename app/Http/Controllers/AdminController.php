<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Depense;
use App\Models\Unite;
use App\Models\User;
use App\Models\Vente;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentUserUniteId = request()->user()->unite_id;

       $repUnites = Unite::select('unites.id','unites.nom')->where('id', '!=', $currentUserUniteId)->selectSub(function ($query) {

                $query->from('ventes')->selectRaw('COALESCE(SUM(total), 0)')->where('statut', 'payee')->whereColumn('unite_id', 'unites.id')->whereMonth('created_at', now()->month);


            }, 'total_ventes')->selectSub(function ($query) {

                $query->from('depenses')->selectRaw('COALESCE(SUM(montant), 0)')->where('statut', 'payee')->whereColumn('unite_id', 'unites.id')->whereMonth('created_at', now()->month);

            }, 'total_depenses')->selectSub(function ($query) {  

                $query->from('recettes')->selectRaw('COALESCE(SUM(montant), 0)')->where('statut', 'recu')->whereColumn('unite_id', 'unites.id')->whereMonth('created_at', now()->month);
            }, 'total_recettes')->get();
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

                }, 'productivite')->where('productivite', '>', 0); // Ne montrer que les unités avec des ventes->get()
            
            $labels = $unites->pluck('nom')->toArray();
            $data = $unites->pluck('productivite')->toArray();

            return view('admin.dashboard', compact('repUnites','unites', 'labels', 'data', 'mois', 'annee', 'moisListe'));
    }


    // Liste des Unites
    public function unites()
    {
        $unites= Unite::where('nom', '!=', 'ARD')->latest()->get();

        return view('admin.unites.listeUnites', compact('unites'));
    }


    // Liste des Utilisateurs
    public function users()
    {
        $users= User::where('role', 'commercial')->latest()->get();

        return view('admin.users.listeUsers', compact('users'));
    }

    // Liste des Users Superviseurs
     // Liste des Utilisateurs
    public function directions()
    {
        $utilisateurs= User::where('role', 'superviseur')->latest()->get();

        return view('admin.directions.superviseurs', compact('utilisateurs'));
    }


    // Ajout Nouvelle Unite
    public function addUnite()
    {
        $categories= Categorie::latest()->get();

        return view('admin.unites.addUnite', compact('categories'));
    }


    // Supprimer un utilisateur
    public function deleteUser($id)
    {

        $user = User::findOrFail($id);

        $admin = request()->user();

        if($admin->role != 'admin') {

            session()->flash('error', 'Vous n\'avez pas les droits administrateur.');
        } else{

            $user->delete();
            return redirect()->back()->with('success', 'Utilisateur supprimé avec success');
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
        $request->validate([
            'nom' => 'string|max:255',
            'adresse' => 'string',
            'contact' => 'numeric|min:9',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'taux_tva' => 'nullable|numeric',
            'categorie_id' => 'nullable|exists:categories,id',
            // Info User
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()], 
        ]);

        // Gestion des logo
        if ($request->hasFile('logo')) {

            $filename = time().$request->file('logo')->getClientOriginalName();
            $path = $request->file('logo')->storeAs('logo', $filename, 'public');
            $request['logo'] = '/storage/' . $path;
        }


        // Verification si c'est un User commercial ou Admin
        if(!empty($request->nom && $request->addresse)) {

        $unite= Unite::where('id', request()->user()->unite_id)->first();

            $unites= Unite::create([
                'nom' => $request->nom,
                'adresse' => $request->adresse,
                'contact' => $request->contact,
                'logo' =>  $path ?? null,
                'statut' => 0,
                'taux_tva' => $request->taux_tva ?? 0,
                'categorie_id' => $request->categorie_id
            ]);

            //  Info User
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'telephone' => $request->telephone,
                'password' => Hash::make($request->password),
                'role' => 'commercial',
                'unite_id' => $unites->id
            ]);

            return redirect()->route('admin.unites')->with('success', 'Unite crée avec success');

        } else{

            //  Creation User Superviseur
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'superviseur',
                'unite_id' => null
            ]);


            return redirect()->back()->with('success', 'Utilisateur crée avec success');

        }
        
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
        $ventes = Vente::where('unite_id', $id)->where('statut', 'payee')->whereBetween('created_at', [$debut, $fin])->get();

        $totalVentes = $ventes->sum('total_ttc');

        // DEPENSES
        $depenses = Depense::where('unite_id', $id)->where('statut', 'payee')->whereBetween('created_at', [$debut, $fin])->get();

        $totalDepenses = $depenses->sum('montant');

        $net = $totalVentes - $totalDepenses;

        // Analyse automatique
        $analyse = $net >= 0 ? "L'unité est bénéficiaire sur la période" : ($net <= 0 ? "L'unité est en déficit sur la période" : "L'unité est en equilibre sur la période" );

        $data = compact('unite','ventes','depenses','totalVentes','totalDepenses','net','analyse','debut','fin');

        $pdf = Pdf::loadView('admin.rapportUnite', $data);

        return $pdf->stream('admin.rapportUnite-'.$unite->id.'.pdf');
    }


    // Repartition des ventes, depenses et recettes
    public function repartitionRecettes()
    {
        $unites = Unite::select('unites.id','unites.nom')->selectSub(function ($query) {

        $query->from('ventes')->selectRaw('COALESCE(SUM(total),0)')->where('statut', 'recu')->whereColumn('unite_id', 'unites.id');

            }, 'total_ventes')->selectSub(function ($query) {

                $query->from('depenses')->selectRaw('COALESCE(SUM(montant),0)')->where('statut', 'payee')->whereColumn('unite_id', 'unites.id');

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


    // Afficher le dashboard d'une unité spécifique
    public function dashboardUnite(Unite $unite)
    {
        // Vérifier si l'utilisateur a le droit d'accéder à ce dashboard
        $user = request()->user();
        $unite = Unite::findOrFail($unite->id);
       
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        // Toutes les statistiques de cette unité

        return view('dashboard.index', compact('unite'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unite= Unite::findorFail($id);

        if($unite->statut) {
            $unite->update(['statut' => false]);
            return redirect()->back()->with('success', 'Unite désactivé');
        }
        else {
            $unite->update(['statut' => true]);
            return redirect()->back()->with('success', 'Unite activé');
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
