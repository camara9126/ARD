<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fonds extends Model
{
    protected $fillable = [
        'unite_id',
        'user_id',
        'reference',
        'libelle',
        'description',
        'montant',
        'date_fond',
        'mode_paiement',
        'statut',
    ];

    public function unite()
    {
        return $this->belongsTo((Unite::class));
    }
}
