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
        // 'recu_paiement' a été supprimé ici
        'cnib', 'photo_identite', 'certificat_medical', 'acte_naissance', 'permis_c'
    ];

    public function candidat() { return $this->belongsTo(Candidat::class); }
    public function paiement() { return $this->belongsTo(Paiement::class); }
}