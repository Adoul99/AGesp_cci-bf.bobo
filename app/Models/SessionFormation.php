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

    /**
     * Point d'entrée UNIQUE pour appliquer des résultats (notes/absences/observations)
     * à cette session, qu'ils viennent du formulaire de clôture classique OU du
     * module Évaluation. Met à jour le pivot, le statut de chaque candidat, et
     * clôture automatiquement la session si tous les candidats sont traités.
     *
     * @param array $resultats [$candidatId => ['absent' => bool, 'note' => float|null, 'observation' => string|null]]
     * @return bool true si la session a été clôturée à l'issue de cet appel
     */
    public function appliquerResultats(array $resultats): bool
    {
        if (!$this->est_ouverte || empty($resultats)) {
            return false;
        }

        $typeNom        = $this->typeSession?->type;
        $idsDeLaSession = $this->candidats()->pluck('candidats.id')->all();

        foreach ($resultats as $candidatId => $data) {
            // On ignore tout candidat qui n'appartient pas à cette session
            if (!in_array((int) $candidatId, $idsDeLaSession)) {
                continue;
            }

            $absent = (bool) ($data['absent'] ?? false);
            $note   = $absent ? null : ($data['note'] ?? null);

            $this->candidats()->updateExistingPivot($candidatId, [
                'absent'      => $absent,
                'note'        => $note,
                'observation' => $data['observation'] ?? null,
            ]);

            if (!$absent && !is_null($note)) {
                $candidat = Candidat::find($candidatId);
                if ($candidat) {
                    $nouveauStatut = match ($typeNom) {
                        'code'     => ($note >= 14) ? 'code_admis' : 'ajourne',
                        'creneau'  => ($note >= 14) ? 'creneau'    : 'ajourne',
                        'conduite' => ($note >= 14) ? 'admis'      : 'ajourne',
                        default    => $candidat->statut,
                    };
                    $candidat->update(['statut' => $nouveauStatut]);
                }
            }
        }

        $this->load('candidats');

        if ($this->peutEtreCloturee()) {
            $this->update(['statutSession' => 'ferme']);
            return true;
        }

        return false;
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