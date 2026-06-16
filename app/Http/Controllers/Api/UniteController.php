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
            Unite::with('user')->get()
        );
    }

    public function show($id)
    {
        return response()->json(
            Unite::with('user')->findOrFail($id)
        );
    }
}
