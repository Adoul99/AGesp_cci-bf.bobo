<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Evaluation;
use App\Models\Inscription;
use App\Models\Paiement;
use App\Models\Formation;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord avec les statistiques
     */
    public function index()
    {
        // Total des candidats
        $totalCandidats = Candidat::count();

        // Inscriptions actives
        $inscriptionsActives = Inscription::where('statutInscription', 'actif')->count();

        // Paiements effectués
        $paiementsEffectues = Paiement::where('statut', 'paye')->count();

        // Formations en cours (supposé que la colonne dateDebut est utilisée)
        $formationsEnCours = Formation::count();

        // 5 dernières inscriptions
        $derniereInscriptions = Inscription::with('candidat')
            ->orderBy('dateInscription', 'desc')
            ->limit(5)
            ->get();

        // 5 derniers paiements
        $paiementsRecents = Paiement::with('candidat')
            ->orderBy('datePaiement', 'desc')
            ->limit(5)
            ->get();

        // Moyenne des notes d'évaluation
        $moyenneNotes = Evaluation::whereNotNull('note')->avg('note');
        $moyenneNotes = $moyenneNotes !== null ? round($moyenneNotes, 2) : null;

        return view('dashboard', compact(
            'totalCandidats',
            'inscriptionsActives',
            'paiementsEffectues',
            'formationsEnCours',
            'derniereInscriptions',
            'paiementsRecents',
            'moyenneNotes'
        ));
    }
}