<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompteBancaires extends Model
{
    protected $fillable = [
        'banque',
        'unite_id',
        'numero_compte',
        'titulaire',
        'solde_initial',
        'date_ouverture',
        'statut',
    ];

    public function unite()
    {
        return $this->belongsTo(Unite::class);
    }

    public function mouvements()
    {
        return $this->hasMany(MouvementBancaires::class);
    }
}
