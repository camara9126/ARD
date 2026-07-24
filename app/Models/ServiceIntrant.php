<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceIntrant extends Model
{
    protected $fillable = [
        'unite_id',
        'service_id',
        'designation',
        'quantite',
        'prix_unitaire',
        'total'
    ];

    public function service() {
        return $this->belongsTo(Service::class);
    }
}
