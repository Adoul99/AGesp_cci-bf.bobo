<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $fillable = [
        'dateInscription',
        'statutInscription',
        'dataDebut_formation',
        'candidat_id',
        'paiement_id',
    ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class);
    }
}