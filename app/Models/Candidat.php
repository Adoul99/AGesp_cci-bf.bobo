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
        'statut',
    ];

    public function groupes()
    {
        return $this->belongsToMany(Groupe::class, 'candidat_groupe');
    }

    public function programmations()
    {
        return $this->belongsToMany(Programmation::class, 'candidat_programmation');
    }

    public function dossiers()
    {
        return $this->hasMany(Dossier::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function sessions()
    {
        return $this->belongsToMany(SessionFormation::class, 'session_candidat')
                    ->withPivot('absent', 'note', 'observation')
                    ->withTimestamps();
    }

    public function examens()
    {
        return $this->belongsToMany(Examen::class, 'candidat_examen')
                    ->withPivot('resultat', 'note', 'observation')
                    ->withTimestamps();
    }

    /**
     * Attestations délivrées à ce candidat
     */
    public function attestations()
    {
        return $this->hasMany(Attestation::class, 'candidat_id');
    }

    /**
     * Paiements effectués par ce candidat
     */
    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'candidat_id');
    }

    /**
     * Libellé lisible du statut
     */
    public function getStatutLabelAttribute(): string
    {
        return match($this->statut) {
            'inscrit'      => 'Inscrit',
            'en_formation' => 'En formation',
            'code_admis'   => 'Code admis',
            'admis'        => 'Admis',
            'ajourne'      => 'Ajourné',
            default        => 'Inconnu',
        };
    }

    /**
     * Couleur associée au statut
     */
    public function getStatutColorAttribute(): string
    {
        return match($this->statut) {
            'inscrit'      => '#666666',
            'en_formation' => '#007A5E',
            'code_admis'   => '#E5B800',
            'admis'        => '#007A5E',
            'ajourne'      => '#CE1126',
            default        => '#666666',
        };
    }

    /**
     * Met à jour la progression du candidat selon ses évaluations INTERNES
     * (formation : code, conduite, créneau évalués en interne par les
     * moniteurs). Cette méthode ne déclenche JAMAIS le statut "admis" :
     * ce statut final est réservé exclusivement aux résultats OFFICIELS
     * de l'examen du ministère (voir mettreAJourStatutApresExamen() plus
     * bas, appelée depuis ExamenController::update()).
     */
    public function mettreAJourStatut(): void
    {
        // Statut définitif : une fois admis officiellement, la progression
        // interne ne doit plus jamais le faire régresser ou le recalculer.
        if ($this->statut === 'admis') {
            return;
        }

        $evaluations = $this->evaluations()->with('typeSession')->orderBy('dateEvaluation', 'desc')->get();

        if ($evaluations->isEmpty()) {
            $this->update(['statut' => 'inscrit']);
            return;
        }

        $aCode = $evaluations->where('resultat', 'Admis')
            ->filter(fn($e) => $e->typeSession?->type === 'code')
            ->count() > 0;

        if ($aCode) {
            $this->update(['statut' => 'code_admis']);
        } elseif ($evaluations->where('resultat', 'Ajourné')->count() > 0) {
            $this->update(['statut' => 'ajourne']);
        } else {
            $this->update(['statut' => 'en_formation']);
        }
    }

    /**
     * Vérifie si le candidat a réussi les DEUX examens OFFICIELS requis
     * (conduite + créneau), tels que saisis dans le module Examens à
     * partir des résultats transmis par le ministère.
     */
    public function estAdmisAuxExamensOfficiels(): bool
    {
        $conduiteAdmis = $this->examens()
            ->wherePivot('resultat', 'Admis')
            ->whereHas('typeSession', fn($q) => $q->where('type', 'conduite'))
            ->exists();

        $creneauAdmis = $this->examens()
            ->wherePivot('resultat', 'Admis')
            ->whereHas('typeSession', fn($q) => $q->where('type', 'creneau'))
            ->exists();

        return $conduiteAdmis && $creneauAdmis;
    }

    /**
     * SEUL point d'entrée autorisé à faire passer un candidat au statut
     * "admis". À appeler juste après la saisie/mise à jour d'un résultat
     * d'examen officiel (ExamenController::update()).
     *
     * @return bool true si le candidat vient JUSTE de devenir admis
     *              (utile pour déclencher une notification/redirection
     *              vers la création d'attestation).
     */
    public function mettreAJourStatutApresExamen(): bool
    {
        if ($this->statut === 'admis') {
            return false;
        }

        if ($this->estAdmisAuxExamensOfficiels()) {
            $this->update(['statut' => 'admis']);
            return true;
        }

        return false;
    }
}