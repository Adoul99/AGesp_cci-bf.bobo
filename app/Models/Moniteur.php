<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moniteur extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
        'specialite',
        'disponibilite',
    ];
}