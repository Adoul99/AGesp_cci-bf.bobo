<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
        'dateNaissance',
        'lieuNaissance',
        'numeroPermisC',
        'dateDelivrancePermisC',
        'lieuDelivrancePermisC',
    ];
}