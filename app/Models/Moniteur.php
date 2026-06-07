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

    /**
     * Sessions de formation de ce moniteur
     */
    public function sessionFormations()
    {
        return $this->hasMany(SessionFormation::class, 'moniteur_id');
    }

    /**
     * Session ouverte en cours pour ce moniteur
     */
    public function sessionOuverte()
    {
        return $this->sessionFormations()->where('statutSession', 'ouvert')->latest()->first();
    }

    /**
     * Retrouve le Moniteur correspondant à l'utilisateur connecté (par email)
     */
    public static function pourUtilisateur(\App\Models\User $user): ?self
    {
        return self::where('email', $user->email)->first();
    }
}
