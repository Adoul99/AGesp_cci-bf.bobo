<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moniteur extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'prenom',
        'telephone',
        'email',
        'specialite',
        'disponibilite',
    ];

    /**
     * Compte utilisateur lié à ce moniteur (pour la connexion)
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

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
     * Retrouve le Moniteur correspondant à l'utilisateur connecté.
     * Priorité au lien user_id ; repli sur l'email si non encore lié.
     */
    public static function pourUtilisateur(\App\Models\User $user): ?self
    {
        return self::where('user_id', $user->id)
            ->orWhere('email', $user->email)
            ->first();
    }
}