<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    protected $fillable = [
        'nomDossier',
        'description',
        'dateDepot',
        'statutDossier',
        'candidat_id',
    ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class);
    }
}