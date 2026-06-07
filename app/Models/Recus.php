<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recus extends Model
{
    protected $table = 'recus';

    protected $fillable = [
        'numero_recu',
        'montant',
        'dateRecus',
        'paiement_id',
        'recus_paiement',
    ];

    /**
     * Un reçu appartient à un paiement
     */
    public function paiement()
    {
        return $this->belongsTo(Paiement::class);
    }

    /**
     * Génère un numéro de reçu unique style CNIB burkinabè
     * Format : REC-YYYYNNNNN  ex: REC-202600001
     */
    public static function genererNumero(): string
    {
        $annee   = date('Y');
        $dernier = self::whereYear('created_at', $annee)->max('id') ?? 0;
        $seq     = str_pad($dernier + 1, 5, '0', STR_PAD_LEFT);
        return "REC-{$annee}{$seq}";
    }
}
