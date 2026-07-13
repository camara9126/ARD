<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeFixe extends Model
{
    protected $fillable = [
        'unite_id',
        'user_id',
        'designation',
        'intitulait',
        'montant',
        'periode',
        'date_debut',
        'date_fin',
        'description',
        'statut'
    ];
}
