<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unite extends Model
{
    protected $fillable = [
    'nom',
    'contact',
    'adresse',
    'logo',
    'statut',
    'taux_tva',
    ];
}
