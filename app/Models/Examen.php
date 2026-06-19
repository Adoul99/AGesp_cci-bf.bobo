<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    protected $fillable = [
        'libelle',
        'dateDebut',
        'dateFin',
        'statutExamen',
        'moniteur_id',
    ];

    public function moniteur()
    {
        return $this->belongsTo(Moniteur::class, 'moniteur_id');
    }

    /**
     * Candidats inscrits à cet examen
     */
    public function candidats()
    {
        return $this->belongsToMany(Candidat::class, 'candidat_examen')
                    ->withPivot('resultat', 'note', 'observation')
                    ->withTimestamps();
    }
}
