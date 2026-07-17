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
                    ->withPivot('absent', 'note', 'mention', 'observation')
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
     * Vérifie si le candidat a réellement réussi une étape INTERNE donnée
     * ('code', 'creneau' ou 'conduite'), en se basant sur l'historique réel
     * de ses sessions de formation (et, en repli, sur ses anciennes
     * évaluations) — PAS sur le champ Candidat::statut.
     *
     * Pourquoi ne pas utiliser statut ? Parce qu'une réussite interne au
     * Code ET une réussite interne au Créneau produisent toutes les deux
     * le même statut "code_admis" (voir SessionFormation::appliquerResultats()).
     * Le statut seul ne permet donc pas de savoir PRÉCISÉMENT quelle étape
     * a été franchie : il faut regarder les sessions/évaluations elles-mêmes.
     *
     * Utilisé pour déterminer l'éligibilité d'un candidat à une session
     * Créneau (nécessite d'avoir réussi 'code') ou Conduite (nécessite
     * d'avoir réussi 'creneau').
     */
    public function aReussiEtapeInterne(string $type): bool
    {
        $type = strtolower($type);

        // 1) Voie principale : sessions de formation (session_candidat),
        //    alimentées par SessionFormation::appliquerResultats() —
        //    point d'entrée unique pour la clôture classique ET le module
        //    Évaluation.
        $viaSessions = $this->sessions()
            ->whereHas('typeSession', fn($q) => $q->whereRaw('LOWER(type) = ?', [$type]))
            ->get()
            ->contains(function ($session) use ($type) {
                if ($session->pivot->absent) {
                    return false;
                }
                if ($type === 'code') {
                    return !is_null($session->pivot->note) && $session->pivot->note >= 14;
                }
                // Créneau / Conduite : réussite via mention
                return in_array($session->pivot->mention, ['bien', 'passable']);
            });

        if ($viaSessions) {
            return true;
        }

        // 2) Repli : ancien système Evaluation (utilisé avant la mise en
        //    place du pivot session_candidat, ou en parallèle pour certains
        //    modules).
        return $this->evaluations()
            ->whereHas('typeSession', fn($q) => $q->whereRaw('LOWER(type) = ?', [$type]))
            ->where('statut', 'reussi')
            ->exists();
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

        $reussies = $evaluations->where('statut', 'reussi');

        $aCode = $reussies->filter(fn($e) => strtolower($e->typeSession?->type ?? '') === 'code')->count() > 0;

        if ($aCode) {
            $this->update(['statut' => 'code_admis']);
        } elseif ($evaluations->where('statut', 'echoue')->count() > 0) {
            $this->update(['statut' => 'ajourne']);
        } else {
            $this->update(['statut' => 'en_formation']);
        }
    }

    /**
     * Vérifie si le candidat a réussi les TROIS examens OFFICIELS requis —
     * Code, Créneau ET Conduite — tels que saisis dans le module Examens à
     * partir des résultats transmis par le ministère.
     */
    public function estAdmisAuxExamensOfficiels(): bool
    {
        $aResultatAdmis = function (string $type): bool {
            return $this->examens()
                ->wherePivot('resultat', 'Admis')
                ->whereHas('typeSession', fn($q) => $q->whereRaw('LOWER(type) = ?', [$type]))
                ->exists();
        };

        return $aResultatAdmis('code')
            && $aResultatAdmis('creneau')
            && $aResultatAdmis('conduite');
    }

    /**
     * SEUL point d'entrée autorisé à faire passer un candidat au statut
     * "admis" DEPUIS le circuit normal (saisie d'un résultat d'examen
     * officiel). À appeler juste après la saisie/mise à jour d'un résultat
     * d'examen officiel (ExamenController::update()). Ne fait rien si le
     * candidat est déjà admis (évite les recalculs inutiles).
     *
     * @return bool true si le candidat vient JUSTE de devenir admis.
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

    /**
     * Recalcul COMPLET et AUTORITAIRE du statut, à utiliser pour corriger
     * les anomalies (ex: statut "admis" resté en base après un ancien bug,
     * alors que les 3 examens officiels ne sont pas tous validés) ou pour
     * une resynchronisation générale. Contrairement à mettreAJourStatut()
     * et mettreAJourStatutApresExamen(), cette méthode ne s'arrête PAS
     * prématurément si le statut actuel est "admis" — elle vérifie toujours
     * la réalité des examens officiels avant de décider, ce qui lui permet
     * de corriger automatiquement une anomalie sans manipulation SQL manuelle.
     *
     * Utilisée par la commande Artisan php artisan candidats:recalculer-statuts.
     *
     * @return string Le statut final après recalcul.
     */
    public function recalculerStatutComplet(): string
    {
        // Priorité absolue : les 3 examens officiels validés = admis, un point c'est tout.
        if ($this->estAdmisAuxExamensOfficiels()) {
            if ($this->statut !== 'admis') {
                $this->update(['statut' => 'admis']);
            }
            return 'admis';
        }

        // Pas encore admis officiellement : on recalcule la progression
        // interne, MÊME si le statut actuel est (à tort) "admis" — c'est
        // précisément ce qui permet de corriger une anomalie automatiquement.
        $evaluations = $this->evaluations()->with('typeSession')->orderBy('dateEvaluation', 'desc')->get();

        if ($evaluations->isEmpty()) {
            $nouveauStatut = 'inscrit';
        } else {
            $reussies = $evaluations->where('statut', 'reussi');
            $aCode = $reussies->filter(fn($e) => strtolower($e->typeSession?->type ?? '') === 'code')->count() > 0;

            if ($aCode) {
                $nouveauStatut = 'code_admis';
            } elseif ($evaluations->where('statut', 'echoue')->count() > 0) {
                $nouveauStatut = 'ajourne';
            } else {
                $nouveauStatut = 'en_formation';
            }
        }

        if ($this->statut !== $nouveauStatut) {
            $this->update(['statut' => $nouveauStatut]);
        }

        return $nouveauStatut;
    }
}
