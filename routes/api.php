<?php

use App\Http\Controllers\Api\ProduitController;
use App\Http\Controllers\Api\UniteController;
use Illuminate\Support\Facades\Route;

// Route API produits
Route::get('/produit', [ProduitController::class, 'index']);
Route::get('/produit/{id}', [ProduitController::class, 'show']);

// Route API unites
Route::get('/unite', [UniteController::class, 'index']);
Route::get('/unite/{id}', [UniteController::class, 'show']);