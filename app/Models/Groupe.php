<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    /**
     * Les champs qui peuvent être remplis en masse
     */
    protected $fillable = [
        'nomGroupe',
        'dateDebutFormation',
    ];

    /**
     * Un groupe peut avoir plusieurs candidats (relation many-to-many)
     */
    public function candidats()
    {
        return $this->belongsToMany(Candidat::class, 'candidat_groupe');
    }
}