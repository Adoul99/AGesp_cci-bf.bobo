<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    /**
     * Montant total fixe de la formation (identique pour tous les candidats)
     */
    public const MONTANT_TOTAL_FORMATION = 135000;

    protected $fillable = [
        'montant',
        'datePaiement',
        'statut',
        'candidat_id',
    ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class);
    }

    /**
     * Un paiement génère un seul reçu
     */
    public function recus()
    {
        return $this->hasOne(Recus::class, 'paiement_id');
    }

    /**
     * L'inscription associée à ce paiement (1 paiement = 1 inscription)
     */
    public function inscription()
    {
        return $this->hasOne(Inscription::class, 'paiement_id');
    }
}