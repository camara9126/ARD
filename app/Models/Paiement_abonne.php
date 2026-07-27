<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement_abonne extends Model
{
    protected $fillable = [
        'abonne_id',
        'mois',
        'annee',
        'montant',
        'statut',
        'date_paiement',
        'valide_par',
        'reference_paiement',
        'mode_paiement'
    ];

    public function abonne()
    {
        return $this->belongsTo(Abonne::class);
    }

    public function validateur()
    {
        return $this->belongsTo(User::class, 'valide_par');
    }
}
