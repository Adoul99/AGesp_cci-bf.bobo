<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    /**
     * Les champs qui peuvent être remplis en masse
     */
    protected $fillable = [
        'dateEvaluation',
        'resultat',
        'statut',
        'moniteur_id',
    ];

    /**
     * Une évaluation appartient à un moniteur
     */
    public function moniteur()
    {
        return $this->belongsTo(Moniteur::class);
    }
}