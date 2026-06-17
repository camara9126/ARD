<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unite;
use Illuminate\Http\Request;

class UniteController extends Controller
{
     public function index()
    {
        return response()->json(
            Unite::with('user')->where('nom', '!=', 'ARD')->latest()->get()
        );
    }

    public function show($id)
    {
        return response()->json(
        Produit::with('unite')->where('unite_id', $id)->findOrFail()

        );
    }
}
