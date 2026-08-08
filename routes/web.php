<?php

use App\Http\Controllers\AchatController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ChargeFixeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\FondController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\MouvementStockController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\RecetteController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UniteController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\AbonneController;
use App\Http\Controllers\PaiementAbonneController;
use App\Http\Controllers\IntrantController;
use App\Http\Controllers\CompteBancaireController;
use App\Http\Controllers\MouvementBanqueController;
use App\Models\Abonne;
use App\Models\MouvementStock;
use App\Models\Vente;
use App\Models\Unite;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.landingPage');
});

// Route::get('/test', function () {
//     return view('dashboard.index');
// })->name('test');


Route::get('/dashboard', function () {

    $user = request()->user();

    $unite = Unite::where('id', $user->unite_id)->first();

    if ($user->role == 'admin' && !$user->unite_id) {

        return redirect()->route('unite.create');

    } elseif ($user->role == 'admin' || $user->role == 'superviseur') {

        return redirect()->route('admin.index');

    } elseif ($user->unite->statut == 0) {

        return view('unite.attenteValidation');

    } else {

        return view('dashboard.index', compact('unite'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/unite', UniteController::class)->middleware(['auth', 'verified']);

// Route Admin
Route::middleware('auth')->group(function () {
    Route::resource('/admin', AdminController::class);
    // liste des unités
    Route::get('/unites', [AdminController::class, 'unites'])->name('admin.unites');
    // Liste des utilisateurs
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    // Liste des agents ARD
    Route::get('/directions', [AdminController::class, 'directions'])->name('admin.directions');
    // Ajout unité par l'Admin
    Route::get('/addUnite', [AdminController::class, 'addUnite'])->name('admin.addUnite');
    // Dashboard de l'unité specifié
    Route::get('/dashboard/{unite}', [AdminController::class, 'dashboardUnite'])->name('admin.dashboard');
    // Suppression utilisateur
    Route::delete('/deleteUser/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');

    Route::resource('/fond', FondController::class);
});


// Routes Inventaires
Route::middleware('auth')->group(function () {
    Route::resource('/categorie', CategorieController::class);
    Route::resource('/fournisseur', FournisseurController::class);
    Route::resource('/produit', ProduitController::class);
    Route::resource('stock', MouvementStockController::class);
    Route::resource('/achat', AchatController::class);
    // Route pour recherche produit dans achat
    Route::get('/achatSearch', [AchatController::class, 'achatSearch'])->name('achat.search');
    Route::resource('/service', ServiceController::class);
    Route::resource('/intrant', IntrantController::class);
    Route::resource('/mouvement', MouvementBanqueController::class);
});


// Route Commercials
Route::middleware('auth')->group(function () {
    Route::resource('/client', ClientController::class);
    Route::resource('/vente', VenteController::class);
    Route::resource('/abonne', AbonneController::class);
    // Route pour recherche abonne 
    Route::get('/abonneSearch', [AbonneController::class, 'abonneSearch'])->name('abonne.search');
    // Facture
    Route::get('/facture', [VenteController::class, 'facture'])->name('vente.facture');
    // Route pour recherche article dans caisse
    Route::get('/caisseSearch', [VenteController::class, 'caisseSearch'])->name('caisse.search');
});


//Route Finance
Route::middleware('auth')->group(function () {
    Route::resource('paiement', PaiementController::class);
    Route::resource('/recette', RecetteController::class);
    Route::resource('/depense', DepenseController::class);
    Route::resource('/chargefixe', ChargeFixeController::class);
    Route::resource('/paiementAbonne', PaiementAbonneController::class);
    Route::resource('/compteBancaire', CompteBancaireController::class);
});


// Analyse
Route::get('/analyse', [RapportController::class, 'rapport'])->middleware(['auth', 'verified'])->name('analyse');


// Route Support & Assistance
Route::get('/support', function () {

    return view('assistance');
})->middleware(['auth', 'verified'])->name('assistance');


// Route Equipements
Route::resource('/equipements', EquipementController::class)->middleware(['auth', 'verified']);

require __DIR__ . '/auth.php';

