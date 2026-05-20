<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recus extends Model
{
    /**
     * Nom de la table dans la base de données
     */
    protected $table = 'recus';

    /**
     * Les champs qui peuvent être remplis en masse
     */
    protected $fillable = [
        'montant',
        'dateRecus',
        'paiement_id',
    ];

    /**
     * Un reçu appartient à un paiement
     */
    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }
}