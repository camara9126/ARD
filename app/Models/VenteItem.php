<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VenteItem extends Model
{
     protected $fillable = [
        'unite_id',
        'vente_id',
        'produit_id',
        'quantite',
        'prix_unitaire',
        'taux_tva',
        'montant_tva',
        'total_ttc',
        'total',
        'designation'
    ];

    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }

   
    public function produit()
    {
        return $this->belongsTo(Produit::class);
    }
}
