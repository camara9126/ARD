<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    protected $fillable = [
        'unite_id',
        'nom',
        'telephone',
        'email',
        'adresse',
        'statut',
    ];

     public function unite()
    {
        return $this->belongsTo((Unite::class));
    }

    public function produit()
    {
        return $this->hasMany(Produit::class);
    }
}
