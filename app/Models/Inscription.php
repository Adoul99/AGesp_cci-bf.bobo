<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $fillable = [
        'reference', 
        'dateInscription', 
        'statutInscription', 
        'dataDebut_formation', 
        'candidat_id', 
        'paiement_id',
        // Ajout des colonnes pour les fichiers
        'cnib', 'photo_identite', 'certificat_medical', 'acte_naissance', 'recu_paiement', 'permis_c'
    ];

    public function candidat() { return $this->belongsTo(Candidat::class); }
    public function paiement() { return $this->belongsTo(Paiement::class); }
}