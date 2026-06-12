<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recette extends Model
{
    protected $fillable = [
        'user_id',
        'unite_id',
        'reference',
        'libelle',
        'description',
        'montant',
        'date_recette',
        'paiement_id',
        'mode_paiement',
        'statut'
    ];

    public function unite()
    {
        return $this->belongsTo((Unite::class));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paiement()
    {
        return $this->belongsTo(Paiement::class, 'paiement_id');
    }
}
