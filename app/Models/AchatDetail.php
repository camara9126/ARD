<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AchatDetail extends Model
{
     protected $fillable = [
        'unite_id',
        'achat_id',
        'produit_id',
        'quantite',
        'prix_unitaire',
        'total',
        'designation'
    ];

    public function produit() {
        return $this->belongsTo(Produit::class);
    }
}
