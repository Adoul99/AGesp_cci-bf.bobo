<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'candidat_id',
        'typeSession_id',
        'dateEvaluation',
        'note',          // ← Ajouté
        'resultat',
        'statut',
        'moniteur_id',
    ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class);
    }

    public function moniteur()
    {
        return $this->belongsTo(Moniteur::class);
    }

    public function typeSession()
    {
        return $this->belongsTo(TypeSession::class);
    }

    public function sessionFormation()
    {
        return $this->hasOne(SessionFormation::class);
    }

    public function notes()
    {
        return $this->hasMany(NoteEvaluation::class);
    }

    // Calcule automatiquement le résultat selon la note
    public function getResultatAutomatiqueAttribute(): string
    {
        if (is_null($this->note)) return 'En attente';
        return $this->note >= 25 ? 'Admis' : 'Ajourné';
    }

    // Vérifie si la note est suffisante
    public function getNoteValideeAttribute(): bool
    {
        return !is_null($this->note) && $this->note >= 25;
    }
}