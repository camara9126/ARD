<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    protected $fillable = [
        'unite_id',
        'user_id',
        'reference',
        'libelle',
        'description',
        'montant',
        'date_depense',
        'mode_paiement',
        'statut',
    ];

    public function unite()
    {
        return $this->belongsTo((Unite::class));
    }
}
