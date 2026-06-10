<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MouvementStock extends Model
{
    protected $fillable = [
        'unite_id',
        'produit_id',
        'type',
        'quantite',
        'reference',
        'note',
        'user_id',
    ];

    public function produit()
    {
        return $this->belongsTo((Produit::class));
    } 
}
