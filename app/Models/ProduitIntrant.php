<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProduitIntrant extends Model
{
    protected $fillable = [
        'unite_id',
        'produit_id',
        'designation',
        'quantite',
        'prix_unitaire',
    ];

    public function produit() {
        return $this->belongsTo(Produit::class);
    }
}
