<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionFormation extends Model
{
    /**
     * Les champs qui peuvent être remplis en masse
     */
    protected $fillable = [
        'dateDebut',
        'statutSession',
        'vehicule_id',
        'evaluation_id',
        'groupe_id',
        'typeSession_id',
    ];

    /**
     * Une session appartient à un véhicule
     */
    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class);
    }

    /**
     * Une session appartient à une évaluation
     */
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    /**
     * Une session appartient à un groupe
     */
    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    /**
     * Une session appartient à un type de session
     */
    public function typeSession()
    {
        return $this->belongsTo(TypeSession::class);
    }
}