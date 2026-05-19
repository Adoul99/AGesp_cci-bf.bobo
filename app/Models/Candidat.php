<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    /**
     * Les champs qui peuvent être remplis en masse
     */
    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
        'dateNaissance',
        'lieuNaissance',
        'numeroPermisC',
        'dateDelivrancePermisC',
        'lieuDelivrancePermisC',
    ];

    /**
     * Un candidat peut appartenir à plusieurs groupes
     */
    public function groupes()
    {
        return $this->belongsToMany(Groupe::class, 'candidat_groupe');
    }

    /**
     * Un candidat peut avoir plusieurs dossiers
     */
    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }

    /**
     * Un candidat peut avoir plusieurs inscriptions
     */
    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
}