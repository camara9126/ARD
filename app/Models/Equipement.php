<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    protected $fillable= [
        'unite_id',
        'nom',
        'valeur_achat',
        'duree_vie_annees',
        'date_mise_service',
    ];



    public function getAmortissementMensuelAttribute()
    {
        return round($this->valeur_achat / ($this->duree_vie_annees * 12), 2);
    }
}
