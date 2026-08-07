<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mouvementBancaires extends Model
{
     protected $fillable = [
        'compte_id',
        'type',
        'montant',
        'frais',
        'motif',
        'reference',
        'date_operation',
    ];
}
