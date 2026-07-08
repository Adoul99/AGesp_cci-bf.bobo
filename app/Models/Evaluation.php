<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'candidat_id',
        'typeSession_id',
        'dateEvaluation',
        'note',
        'mention',
        'resultat',
        'statut',
        'moniteur_id',
        'observation',
    ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'candidat_id');
    }

    public function moniteur()
    {
        return $this->belongsTo(Moniteur::class, 'moniteur_id');
    }

    public function typeSession()
    {
        // Clé explicite car Laravel chercherait type_session_id par défaut
        return $this->belongsTo(TypeSession::class, 'typeSession_id');
    }

    public function sessionFormation()
    {
        return $this->hasOne(SessionFormation::class);
    }

    public function notes()
    {
        return $this->hasMany(NoteEvaluation::class);
    }

    // Label lisible du type de session (Code / Créneau / Conduite)
    public function getLibelleTypeSessionAttribute(): string
    {
        return match ($this->typeSession?->type) {
            'code'     => 'Code',
            'creneau'  => 'Créneau',
            'conduite' => 'Conduite',
            default    => $this->typeSession?->type ?? '',
        };
    }

    // Calcule automatiquement si l'évaluation est validée
    // - Code : note >= 25
    // - Créneau / Conduite : mention "bien" ou "passable"
    public function estValidee(): bool
    {
        if ($this->typeSession?->type === 'code') {
            return !is_null($this->note) && $this->note >= 25;
        }

        return in_array($this->mention, ['bien', 'passable']);
    }

    // Calcule automatiquement le résultat selon le type de session
    public function getResultatAutomatiqueAttribute(): string
    {
        $type = $this->typeSession?->type;

        if ($type === 'code') {
            if (is_null($this->note)) return 'En attente';
            return $this->note >= 25
                ? 'Validé la session de Code'
                : 'Échoué la session de Code';
        }

        if (in_array($type, ['creneau', 'conduite'])) {
            if (is_null($this->mention) || $this->mention === '') return 'En attente';
            $libelle = $this->libelle_type_session;
            return in_array($this->mention, ['bien', 'passable'])
                ? "Validé la session de {$libelle}"
                : "Échoué la session de {$libelle}";
        }

        return 'En attente';
    }

    // Vérifie si la note est suffisante (Code uniquement)
    public function getNoteValideeAttribute(): bool
    {
        return !is_null($this->note) && $this->note >= 25;
    }
}
