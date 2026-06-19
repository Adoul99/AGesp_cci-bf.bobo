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
     * Met à jour automatiquement le statut selon les évaluations
     */
    public function mettreAJourStatut(): void
    {
        $evaluations = $this->evaluations()->orderBy('dateEvaluation', 'desc')->get();

        if ($evaluations->isEmpty()) {
            $this->update(['statut' => 'inscrit']);
            return;
        }

        $aCode    = $evaluations->where('resultat', 'Admis')->whereHas('typeSession', fn($q) => $q->where('type', 'code'))->count() > 0;
        $aConduite = $evaluations->where('resultat', 'Admis')->whereHas('typeSession', fn($q) => $q->where('type', 'conduite'))->count() > 0;
        $aCreneau  = $evaluations->where('resultat', 'Admis')->whereHas('typeSession', fn($q) => $q->where('type', 'creneau'))->count() > 0;

        if ($aConduite && $aCreneau) {
            $this->update(['statut' => 'admis']);
        } elseif ($aCode) {
            $this->update(['statut' => 'code_admis']);
        } elseif ($evaluations->where('resultat', 'Ajourné')->count() > 0) {
            $this->update(['statut' => 'ajourne']);
        } else {
            $this->update(['statut' => 'en_formation']);
        }
    }
}
