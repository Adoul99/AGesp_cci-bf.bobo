<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attestation extends Model
{
    protected $fillable = [
        'dateDelivrance',
        'numeroAttestation',
        'candidat_id',
        'examen_id',
        'civilite',
        'categorieObtenue',
        'formationDateDebut',
        'formationDateFin',
        'dateAdmissionCode',
        'dateAdmissionConduite',
        'directeurCivilite',
        'directeurNom',
    ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'candidat_id');
    }

    public function examen()
    {
        return $this->belongsTo(Examen::class, 'examen_id');
    }

    /**
     * Génère un numéro d'attestation au format officiel CFTRA :
     * {année}/{séquence}/DRB-SFP/CFTRA — ex : 2026/102/DRB-SFP/CFTRA
     */
    public static function genererNumero(): string
    {
        $annee   = date('Y');
        $dernier = self::whereYear('created_at', $annee)->count();
        $seq     = $dernier + 1;
        return "{$annee}/{$seq}/DRB-SFP/CFTRA";
    }
}