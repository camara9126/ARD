<?php

use App\Http\Controllers\Api\ProduitController;
use App\Http\Controllers\Api\UniteController;
use Illuminate\Support\Facades\Route;

// Route API produits
Route::get('/produits', [ProduitController::class, 'index']);
Route::get('/produits/{id}', [ProduitController::class, 'show']);

// Route API unites
Route::get('/unites', [UniteController::class, 'index']);
Route::get('/unites/{id}', [UniteController::class, 'show']);

