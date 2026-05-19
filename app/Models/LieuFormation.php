<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LieuFormation extends Model
{
    /**
     * Les champs qui peuvent être remplis en masse
     */
    protected $fillable = [
        'nomLieu',
        'localisation',
    ];

    /**
     * Un lieu de formation peut avoir plusieurs formations
     */
    public function formations()
    {
        return $this->hasMany(Formation::class);
    }
}