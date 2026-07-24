<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'unite_id',
        'nom',
        'categorie',
        'description',
        'prix',
        'unite_de_mesure',
        'categorie'
    ];
}
