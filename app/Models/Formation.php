<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = [
        'dateDebut',
        'dateFin',
        'typeFormation',
        'lieu',
        'moniteur_id',
        'vehicule_id',
    ];

    public function moniteur()
    {
        return $this->belongsTo(Moniteur::class);
    }

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }
}