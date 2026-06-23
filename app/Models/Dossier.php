<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    protected $fillable = [
        'nomDossier', 'description', 'dateDepot', 'statutDossier', 'commentaireAdmin', 'candidat_id',
        'cnib', 'photo_identite', 'certificat_medical', 'acte_naissance', 'recu_paiement', 'permis_c'
    ];

    public function candidat() {
        return $this->belongsTo(Candidat::class);
    }
}