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
    /**
     * Affiche le tableau de bord avec les statistiques
     */
    public function index()
    {
        // ── Statistiques globales existantes ─────────────────
        $totalCandidats      = Candidat::count();
        $inscriptionsActives = Inscription::where('statutInscription', 'actif')->count();
        $paiementsEffectues  = Paiement::where('statut', 'paye')->count();
        $formationsEnCours   = Formation::count();

        $derniereInscriptions = Inscription::with('candidat')
            ->orderBy('dateInscription', 'desc')
            ->limit(5)
            ->get();

        $paiementsRecents = Paiement::with('candidat')
            ->orderBy('datePaiement', 'desc')
            ->limit(5)
            ->get();

        $moyenneNotes = Evaluation::whereNotNull('note')->avg('note');
        $moyenneNotes = $moyenneNotes !== null ? round($moyenneNotes, 2) : null;

        // ── NOUVELLES STATISTIQUES PAR STATUT CANDIDAT ───────
        // (basé sur le champ 'statut' du modèle Candidat : inscrit, en_formation, code_admis, admis, ajourne)
        $candidatsInscrits = Candidat::where('statut', 'inscrit')->count();

        // Candidats actuellement au niveau Code (en formation, pas encore code validé)
        $candidatsCode = Candidat::whereIn('statut', ['inscrit', 'en_formation'])
            ->whereDoesntHave('evaluations', function ($q) {
                $q->where('resultat', 'Admis');
            })
            ->count();

        // Candidats ayant validé le Code et en attente/cours de Créneau
        $candidatsCreneau = Candidat::where('statut', 'code_admis')->count();

        // Candidats en formation Conduite (code + créneau validés, conduite en cours)
        // = ceux qui ont une évaluation "Admis" en créneau mais ne sont pas encore "admis" global
        $candidatsConduite = Candidat::where('statut', 'en_formation')
            ->whereHas('evaluations', function ($q) {
                $q->where('resultat', 'Admis');
            })
            ->count();

        // Total Admis (code + créneau + conduite tous validés)
        $candidatsAdmis = Candidat::where('statut', 'admis')->count();

        // Total Ajournés
        $candidatsAjournes = Candidat::where('statut', 'ajourne')->count();

        // ── Répartition par catégorie de permis (E / D / autres) ─
        $repartitionPermis = Inscription::selectRaw('COALESCE(categorie_permis.nomCategorie, "Non renseigné") as categorie, COUNT(*) as total')
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
            'repartitionPermis'
        ));
    }
}
