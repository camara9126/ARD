<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unite extends Model
{
    protected $fillable = [
    'nom',
    'contact',
    'adresse',
    'logo',
    'statut',
    'taux_tva',
    ];

    public function produit() {
        return $this->hasMany(Produit::class);
    }

    public function recettes() {
        return $this->hasMany(Recette::class);
    }

    public function ventes() {
        return $this->hasMany(Vente::class);
    }

    public function depense() {
        return $this->hasMany(Depense::class);
    }

    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function equipements()
    {
        return $this->hasMany(Equipement::class);
    }

    public function categorie() 
    {
        return $this->belongsTo(Categorie::class);
    }
    
}
