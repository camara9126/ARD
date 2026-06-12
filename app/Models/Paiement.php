<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'vente_id',
        'unite_id',
        'user_id',
        'montant',
        'mode_paiement',
        'reference',
        'date_paiement',
        'statut',
        'motif',
        'annule_par',
        'annule_le',
    ];

     public function achat()
    {
        return $this->belongsTo(Achat::class);
    }
    
    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recette()
    {
        return $this->hasOne(Recette::class, 'paiement_id');
    }
}
