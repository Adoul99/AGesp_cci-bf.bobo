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
        return $this->belongsTo(Candidat::class);
    }

    public function examen()
    {
        return $this->belongsTo(Examen::class);
    }
}