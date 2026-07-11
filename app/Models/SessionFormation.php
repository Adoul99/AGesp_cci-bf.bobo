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
     * Le pivot contient : absent (bool), note (decimal, sessions Code),
     * mention (enum bien/passable/mediocre, sessions Créneau/Conduite), observation (string)
     */
    public function candidats()
    {
        return $this->belongsToMany(Candidat::class, 'session_candidat')
                    ->withPivot('absent', 'note', 'mention', 'observation')
                    ->withTimestamps();
    }

    // ── Accesseurs ───────────────────────────────────────────────

    public function getEstOuverteAttribute(): bool
    {
        return $this->statutSession === 'ouvert';
    }

    /**
     * Un candidat du pivot est-il "traité" pour la clôture ?
     * → absent, OU note renseignée (session Code), OU mention renseignée (Créneau/Conduite).
     */
    private function pivotEstTraite($pivot): bool
    {
        if ($pivot->absent) return true;
        if (!is_null($pivot->note)) return true;
        if (!empty($pivot->mention)) return true;
        return false;
    }

    /**
     * Vérifie si la session peut être clôturée :
     * tous les candidats doivent avoir une note/mention OU être marqués absents.
     */
    public function peutEtreCloturee(): bool
    {
        $candidats = $this->candidats;

        if ($candidats->isEmpty()) {
            return false;
        }

        foreach ($candidats as $c) {
            if (!$this->pivotEstTraite($c->pivot)) return false;
        }

        return true;
    }

    /**
     * Candidats sans note/mention et non marqués absents (bloquants pour la clôture)
     */
    public function candidatsSansNote()
    {
        return $this->candidats->filter(function ($c) {
            return !$this->pivotEstTraite($c->pivot);
        });
    }

    /**
     * Point d'entrée UNIQUE pour appliquer des résultats (notes/mentions/absences/observations)
     * à cette session, qu'ils viennent du formulaire de clôture classique OU du
     * module Évaluation. Met à jour le pivot, le statut de chaque candidat, et
     * clôture automatiquement la session si tous les candidats sont traités.
     *
     * @param array $resultats [$candidatId => ['absent' => bool, 'note' => float|null, 'mention' => string|null, 'observation' => string|null]]
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

            $absent  = (bool) ($data['absent'] ?? false);
            $note    = $absent ? null : ($data['note'] ?? null);
            $mention = $absent ? null : ($data['mention'] ?? null);

            $this->candidats()->updateExistingPivot($candidatId, [
                'absent'      => $absent,
                'note'        => $note,
                'mention'     => $mention,
                'observation' => $data['observation'] ?? null,
            ]);

            if (!$absent) {
                $candidat = Candidat::find($candidatId);
                if ($candidat) {
                    // ⚠️ Statut "admis" INTERDIT depuis une évaluation INTERNE
                    // (formation, moniteur). Ce statut est réservé exclusivement
                    // au résultat OFFICIEL de l'examen du ministère, saisi via
                    // ExamenController::update() → Candidat::mettreAJourStatutApresExamen().
                    // Ici, on ne fait que suivre la progression interne : une
                    // réussite avance vers "code_admis" (statut d'attente le plus
                    // avancé disponible avant l'admission officielle), un échec
                    // marque "ajourne". Rien ici ne peut jamais produire "admis".
                    $nouveauStatut = match ($typeNom) {
                        // Code : validé selon note >= 14 (seuil interne, distinct du seuil d'admission 25/30 de l'évaluation)
                        'code' => !is_null($note)
                            ? (($note >= 14) ? 'code_admis' : 'ajourne')
                            : $candidat->statut,

                        // Créneau/Conduite : validé selon la mention (bien/passable = ok, médiocre = échec).
                        // Succès interne = simple maintien/avancée vers "code_admis",
                        // JAMAIS "admis" — l'admission finale exige le passage par
                        // l'examen officiel (Code + Créneau + Conduite tous "Admis").
                        'creneau', 'conduite' => !is_null($mention)
                            ? (in_array($mention, ['bien', 'passable']) ? 'code_admis' : 'ajourne')
                            : $candidat->statut,

                        default => $candidat->statut,
                    };

                    // Garde-fou supplémentaire : ne jamais toucher un candidat déjà
                    // admis officiellement (cohérent avec Candidat::mettreAJourStatut()).
                    if ($candidat->statut !== 'admis') {
                        $candidat->update(['statut' => $nouveauStatut]);
                    }
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