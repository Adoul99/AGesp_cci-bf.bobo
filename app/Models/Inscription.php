<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $fillable = [
        'reference', // Ajouté pour correspondre à la nouvelle migration et au contrôleur
        'dateInscription',
        'statutInscription',
        'dataDebut_formation',
        'candidat_id',
        'paiement_id',
    ];

    /**
     * Relation : Une inscription appartient à un candidat.
     */
    public function candidat()
    {
        return $this->belongsTo(Candidat::class);
    }

    /**
     * Relation : Une inscription peut être liée à un paiement (optionnel).
     */
    public function paiement()
    {
        return $this->belongsTo(Paiement::class); // Assurez-vous que le modèle Paiement existe
    }
}