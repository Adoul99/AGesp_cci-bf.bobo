<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoteEvaluation extends Model
{
    protected $table = 'notes_evaluation';

    protected $fillable = [
        'candidat_id',
        'evaluation_id',
        'date_note',
        'note',
        'observation',
    ];

    // Une note appartient à un candidat
    public function candidat()
    {
        return $this->belongsTo(Candidat::class);
    }

    // Une note appartient à une évaluation
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    // Vérifie si la note est validée (>= 25)
    public function estValidee(): bool
    {
        return $this->note >= 25;
    }
}