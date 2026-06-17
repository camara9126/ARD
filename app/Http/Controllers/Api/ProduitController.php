<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use Illuminate\Http\Request;

class ProduitController extends Controller
{
    public function index()
    {
        return response()->json(
            Produit::with('unite')->get()
        );
    }

    public function show($id)
    {
        return response()->json(
            Produit::with('unite')->where('unite_id', $id)->findOrFail()
        );
    }
}
