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
        'groupe_id',
    ];

    /**
     * Une programmation appartient à un moniteur
     */
    public function moniteur()
    {
        return $this->belongsTo(Moniteur::class);
    }

    /**
     * Une programmation appartient à un groupe
     */
    public function groupe()
    {
        return $this->belongsTo(Groupe::class);
    }

    /**
     * Une programmation peut concerner plusieurs candidats
     */
    public function candidats()
    {
        return $this->belongsToMany(Candidat::class, 'candidat_programmation');
    }
}
