<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'prenom',
        'telephone',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function getPrenomFormatAttribute(): string
    {
        return ucfirst(strtolower($this->prenom ?? ''));
    }

    public function getTelephoneFormatAttribute(): string
    {
        $t = preg_replace('/\D/', '', $this->telephone ?? '');
        return preg_replace('/(\d{2})(\d{2})(\d{2})(\d{2})/', '$1 $2 $3 $4', $t);
    }

    public function getTelephoneFullAttribute(): string
    {
        return '+226 ' . $this->telephone_format;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCandidat(): bool
    {
        return $this->role === 'candidat';
    }

    public function isMoniteur(): bool
    {
        return $this->role === 'moniteur';
    }

    public function isSecretaire(): bool
    {
        return $this->role === 'secretaire';
    }

    /**
     * Fiche Moniteur liée à ce compte utilisateur (si le rôle est moniteur)
     */
    public function moniteur()
    {
        return $this->hasOne(\App\Models\Moniteur::class);
    }
}