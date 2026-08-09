<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mouvementBancaires extends Model
{
        protected $fillable = [
        'compte_bancaires_id',
        'type',
        'montant',
        'frais',
        'motif',
        'reference',
        'date_operation',
    ];

    public function compte()
    {
        return $this->belongsTo(CompteBancaires::class, 'compte_bancaires_id');
    }
}
