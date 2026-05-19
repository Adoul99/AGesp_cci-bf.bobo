<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    protected $fillable = [
        'montant',
        'datePaiement',
        'statut',
        'candidat_id',
    ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class);
    }
}