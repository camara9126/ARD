<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    protected $fillable = [
        'unite_id',
        'user_id',
        'client_id',
        'reference',
        'date',
        'total',
        'statut',
        'total_tva',
        'total_ttc',
    ];

     public function items()
    {
        return $this->hasMany(VenteItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

     //calcule montant payee
    public function getMontantPayeAttribute()
    {
        return $this->paiements()->where('statut', 'valide')->sum('montant');
    }

    // calcule montant restant
    public function getMontantRestantAttribute()
    {
        return max(0, $this->total_ttc - $this->montant_paye);
    }
}
