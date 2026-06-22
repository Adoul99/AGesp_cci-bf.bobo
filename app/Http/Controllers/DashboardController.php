<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Evaluation;
use App\Models\Inscription;
use App\Models\Paiement;
use App\Models\Formation;
use App\Models\SessionFormation;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Total candidats ──
        $totalCandidats = Candidat::count();

        // ── Répartition par étape ──
        // Inscrits = tous les candidats du système
        $candidatsInscrits  = $totalCandidats;

        // Code = candidats ayant réussi le code
        $candidatsCode      = Candidat::where('statut', 'code_admis')->count();

        // Créneau = candidats en session créneau
        $candidatsCreneau   = Candidat::where('statut', 'creneau')->count();

        // Conduite en ville = candidats ajourné (en attente ou échec conduite)
        $candidatsConduite  = Candidat::where('statut', 'ajourne')->count();

        // Admis = permis obtenu
        $candidatsAdmis     = Candidat::where('statut', 'admis')->count();

        $candidatsAjournes  = Candidat::where('statut', 'ajourne')->count();

        // ── Candidats ayant au moins une session formation ──
        $candidatsEnSession = Candidat::whereHas('sessions')->count();

        // ── Sessions ouvertes par type ──
        $sessionsOuvertes = SessionFormation::with('typeSession')
            ->where('statutSession', 'ouvert')
            ->get();

        $sessionCodeOuverte     = $sessionsOuvertes->first(fn($s) => $s->typeSession?->type === 'code');
        $sessionCreneauOuverte  = $sessionsOuvertes->first(fn($s) => $s->typeSession?->type === 'creneau');
        $sessionConduiteOuverte = $sessionsOuvertes->first(fn($s) => $s->typeSession?->type === 'conduite');

        // ── Dernières inscriptions ──
        $derniereInscriptions = Inscription::with('candidat')
            ->orderBy('dateInscription', 'desc')
            ->limit(5)
            ->get();

        // ── Paiements récents ──
        $paiementsRecents = Paiement::with('candidat')
            ->orderBy('datePaiement', 'desc')
            ->limit(5)
            ->get();

        // ── Autres stats ──
        $inscriptionsActives = Inscription::where('statutInscription', 'actif')->count();
        $paiementsEffectues  = Paiement::where('statut', 'paye')->count();
        $formationsEnCours   = Formation::count();
        $moyenneNotes        = round(Evaluation::whereNotNull('note')->avg('note') ?? 0, 2);

        // ── Répartition par catégorie de permis ──
        $repartitionPermis = Inscription::selectRaw('
                COALESCE(categorie_permis.nomCategorie, "Non renseigné") AS categorie,
                COUNT(*) AS total
            ')
            ->leftJoin('categorie_permis', 'categorie_permis.id', '=', 'inscriptions.categoriePermis_id')
            ->groupBy('categorie')
            ->pluck('total', 'categorie');

        return view('dashboard', compact(
            'totalCandidats',
            'inscriptionsActives',
            'paiementsEffectues',
            'formationsEnCours',
            'derniereInscriptions',
            'paiementsRecents',
            'moyenneNotes',
            'candidatsInscrits',
            'candidatsCode',
            'candidatsCreneau',
            'candidatsConduite',
            'candidatsAdmis',
            'candidatsAjournes',
            'candidatsEnSession',
            'sessionsOuvertes',
            'sessionCodeOuverte',
            'sessionCreneauOuverte',
            'sessionConduiteOuverte',
            'repartitionPermis'
        ));
    }
}