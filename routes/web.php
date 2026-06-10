<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\MouvementStockController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\RecetteController;
use App\Http\Controllers\UniteController;
use App\Http\Controllers\VenteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('dashboard.index');
})->name('test');


Route::get('/dashboard', function () {

    $user= request()->user();

    if($user->role == 'commercial' && !$user->unite_id) {

            return redirect()->route('unite.create');

    } else {

        return view('dashboard.index');
    }
    
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/unite', UniteController::class)->middleware(['auth', 'verified']);


// Routes Inventaires
Route::middleware('auth')->group(function () {
    Route::resource('/categorie', CategorieController::class);
    Route::resource('/fournisseur', FournisseurController::class);
    Route::resource('/produit', ProduitController::class);
    Route::resource('stock', MouvementStockController::class);
});


// Route Commercials
Route::middleware('auth')->group(function () {
    Route::resource('/client', ClientController::class);
    Route::resource('/vente', VenteController::class);
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
    // Analyse
    Route::get('/analyse', [RapportController::class, 'rapport'])->name('analyse');
});

require __DIR__.'/auth.php';
