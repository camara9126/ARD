<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorieUnite extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'image'
    ];

    public function unite() {
        return $this->hasMany(Unite::class);
    }
}
