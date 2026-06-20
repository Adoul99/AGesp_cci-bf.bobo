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
     * Génère un numéro d'attestation unique : ATT-YYYY-NNNNN
     */
    public static function genererNumero(): string
    {
        $annee   = date('Y');
        $dernier = self::whereYear('created_at', $annee)->count();
        $seq     = str_pad($dernier + 1, 5, '0', STR_PAD_LEFT);
        return "ATT-{$annee}-{$seq}";
    }
}
