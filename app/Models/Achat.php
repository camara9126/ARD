<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achat extends Model
{
     protected $fillable = [
        'fournisseur_id',
        'unite_id',
        'reference',
        'total',
        'note',
        'statut',
    ];

    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }


    public function details()
    {
        return $this->hasMany(AchatDetail::class);
    }

     public function entreprise()
    {
        return $this->belongsTo(Unite::class);
    }


     public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
