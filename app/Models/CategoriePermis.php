<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriePermis extends Model
{
    /**
     * Les champs qui peuvent être remplis en masse
     */
    protected $fillable = [
        'nomCategorie',
        'description',
    ];

    /**
     * Une catégorie de permis peut avoir plusieurs inscriptions
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}