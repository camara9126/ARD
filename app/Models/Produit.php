<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Produit extends Model
{
    protected $fillable = [
        'unite_id',
        'fournisseur_id',
        'nom',
        'slug',
        'code',
        'prix_achat',
        'prix_vente',
        'stock',
        'stock_min',
        'categorie_id',
        'statut',
    ];


    // creation de slug a chaque article
        protected static function boot()
            {
                parent::boot();
            
                static::saving(function ($produit) {
                    if (empty($produit->slug)) {
                        $slug = Str::slug($produit->nom);
                        $originalSlug = $slug;
            
                        // Vérifier l'unicité du slug
                        $count = 1;
                        while (Produit::where('slug', $slug)->exists()) {
                            $slug = $originalSlug . '-' . $count;
                            $count++;
                        }
            
                        $produit->slug = $slug;
                    }
                });
            }


    public function fournisseur()
    {
        return $this->belongsTo(Fournisseur::class);
    }

    public function unite()
    {
        return $this->belongsTo(Unite::class);
    }

    // Alerte stock minimum
    public static function produitsEnAlerte()
    {
        return self::whereColumn('stock', '<=', 'stock_min')->where('unite_id', request()->user()->unite_id);
    }
}
