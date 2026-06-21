<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programmation extends Model
{
    /**
     * Les champs qui peuvent être remplis en masse
     */
    protected $fillable = [
        'dateDebut',
        'dateFin',
        'moniteur_id',
        'typeSession_id',
    ];

    /**
     * Une programmation appartient à un moniteur
     */
    public function moniteur()
    {
        return $this->belongsTo(Moniteur::class);
    }

    /**
     * Une programmation appartient à un type de session (Code, Créneau, Conduite)
     */
    public function typeSession()
    {
        return $this->belongsTo(TypeSession::class, 'typeSession_id');
    }

    /**
     * Une programmation peut concerner plusieurs candidats
     */
    public function candidats()
    {
        return $this->belongsToMany(Candidat::class, 'candidat_programmation');
    }
}
