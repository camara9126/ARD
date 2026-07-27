<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abonne extends Model
{
    protected $fillable = [
        'unite_id',
        'reference',
        'nom_complet',
        'telephone',
        'adresse',
        'date_abonnement',
    ];

    public function unite()
    {
        return $this->belongsTo(Unite::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement_abonne::class);
    }
}
