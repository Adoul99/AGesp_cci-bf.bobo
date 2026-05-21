<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeSession extends Model
{
    /**
     * Nom de la table dans la base de données
     */
    protected $table = 'type_sessions';

    /**
     * Les champs qui peuvent être remplis en masse
     */
    protected $fillable = [
        'idSession',
        'code',
        'creneau',
        'conduite',
    ];

    /**
     * Un type de session peut avoir plusieurs sessions de formation
     */
    public function sessions()
    {
        return $this->hasMany(SessionFormation::class);
    }
}