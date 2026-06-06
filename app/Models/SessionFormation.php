<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionFormation extends Model
{
    protected $fillable = [
        'dateDebut',
        'statutSession',
        'vehicule_id',
        'evaluation_id',
        'groupe_id',
        'typeSession_id',
        'moniteur_id',
    ];

    // ── Relations ────────────────────────────────────────────────

    public function vehicule()
    {
        return $this->belongsTo(Vehicule::class, 'vehicule_id');
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id');
    }

    public function groupe()
    {
        return $this->belongsTo(Groupe::class, 'groupe_id');
    }

    public function typeSession()
    {
        // Clé explicite car Laravel chercherait type_session_id par défaut
        return $this->belongsTo(TypeSession::class, 'typeSession_id');
    }

    public function moniteur()
    {
        return $this->belongsTo(Moniteur::class, 'moniteur_id');
    }

    /**
     * Candidats attachés à cette session (via pivot session_candidat)
     * Le pivot contient : absent (bool), note (decimal), observation (string)
     */
    public function candidats()
    {
        return $this->belongsToMany(Candidat::class, 'session_candidat')
                    ->withPivot('absent', 'note', 'observation')
                    ->withTimestamps();
    }

    // ── Accesseurs ───────────────────────────────────────────────

    public function getEstOuverteAttribute(): bool
    {
        return $this->statutSession === 'ouvert';
    }

    /**
     * Vérifie si la session peut être clôturée :
     * tous les candidats doivent avoir une note OU être marqués absents.
     */
    public function peutEtreCloturee(): bool
    {
        $candidats = $this->candidats;

        if ($candidats->isEmpty()) {
            return false;
        }

        foreach ($candidats as $c) {
            if ($c->pivot->absent) continue;
            if (is_null($c->pivot->note)) return false;
        }

        return true;
    }

    /**
     * Candidats sans note et non marqués absents (bloquants pour la clôture)
     */
    public function candidatsSansNote()
    {
        return $this->candidats->filter(function ($c) {
            return !$c->pivot->absent && is_null($c->pivot->note);
        });
    }

    // ── Scopes ───────────────────────────────────────────────────

    public function scopeOuverte($query)
    {
        return $query->where('statutSession', 'ouvert');
    }

    public function scopeParMoniteur($query, int $moniteurId)
    {
        return $query->where('moniteur_id', $moniteurId);
    }

    // ── Méthodes statiques ───────────────────────────────────────

    /**
     * Retourne la session ouverte d'un moniteur, ou null.
     */
    public static function sessionOuvertePourMoniteur(int $moniteurId): ?self
    {
        return self::ouverte()->parMoniteur($moniteurId)->latest()->first();
    }
}