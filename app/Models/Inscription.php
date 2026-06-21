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
        'categoriePermis_id',
        'paiement_id',
        'cnib', 'photo_identite', 'certificat_medical', 'acte_naissance', 'permis_c'
    ];

    public function candidat() { return $this->belongsTo(Candidat::class); }
    public function paiement() { return $this->belongsTo(Paiement::class); }
    public function categoriePermis() { return $this->belongsTo(CategoriePermis::class, 'categoriePermis_id'); }
}