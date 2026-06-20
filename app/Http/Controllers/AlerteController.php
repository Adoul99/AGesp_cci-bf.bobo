<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\SessionFormation;
use App\Models\Attestation;
use Carbon\Carbon;

class AlerteController extends Controller
{
    /**
     * Seuils configurables
     */
    const JOURS_SANS_EVALUATION = 14;   // candidats sans note depuis X jours
    const JOURS_SESSION_OUVERTE = 7;    // sessions ouvertes depuis X jours

    public function index()
    {
        // 1) Candidats inscrits/en formation sans aucune évaluation depuis X jours
        $seuilEval = Carbon::now()->subDays(self::JOURS_SANS_EVALUATION);

        $candidatsSansEvaluation = Candidat::whereIn('statut', ['inscrit', 'en_formation'])
            ->where('created_at', '<=', $seuilEval)
            ->whereDoesntHave('evaluations')
            ->orderBy('created_at')
            ->get();

        // 2) Candidats ayant une évaluation, mais dont la dernière date d'évaluation
        //    remonte à plus de X jours (toujours en formation, pas encore admis/ajourné figé)
        $candidatsEvaluationAncienne = Candidat::whereIn('statut', ['inscrit', 'en_formation'])
            ->whereHas('evaluations')
            ->with('evaluations')
            ->get()
            ->filter(function ($c) use ($seuilEval) {
                $derniere = $c->evaluations->max('dateEvaluation');
                return $derniere && Carbon::parse($derniere)->lessThanOrEqualTo($seuilEval);
            });

        // 3) Sessions de formation ouvertes depuis trop longtemps (à clôturer)
        $seuilSession = Carbon::now()->subDays(self::JOURS_SESSION_OUVERTE);

        $sessionsAOuvertesLongtemps = SessionFormation::where('statutSession', 'ouvert')
            ->where('dateDebut', '<=', $seuilSession->toDateString())
            ->with(['moniteur', 'groupe', 'candidats'])
            ->get();

        // 4) Candidats admis n'ayant pas encore d'attestation
        $candidatsAvecAttestation = Attestation::pluck('candidat_id')->toArray();

        $candidatsAdmisSansAttestation = Candidat::where('statut', 'admis')
            ->whereNotIn('id', $candidatsAvecAttestation)
            ->orderBy('updated_at')
            ->get();

        // 5) Candidats ajournés (à relancer / replanifier)
        $candidatsAjournes = Candidat::where('statut', 'ajourne')
            ->orderBy('updated_at', 'desc')
            ->get();

        $totalAlertes = $candidatsSansEvaluation->count()
            + $candidatsEvaluationAncienne->count()
            + $sessionsAOuvertesLongtemps->count()
            + $candidatsAdmisSansAttestation->count()
            + $candidatsAjournes->count();

        return view('alertes.index', compact(
            'candidatsSansEvaluation',
            'candidatsEvaluationAncienne',
            'sessionsAOuvertesLongtemps',
            'candidatsAdmisSansAttestation',
            'candidatsAjournes',
            'totalAlertes'
        ));
    }

    /**
     * Nombre total d'alertes — utilisé pour le badge dans le menu (sidebar)
     */
    public static function compterAlertes(): int
    {
        $seuilEval    = Carbon::now()->subDays(self::JOURS_SANS_EVALUATION);
        $seuilSession = Carbon::now()->subDays(self::JOURS_SESSION_OUVERTE);

        $sansEval = Candidat::whereIn('statut', ['inscrit', 'en_formation'])
            ->where('created_at', '<=', $seuilEval)
            ->whereDoesntHave('evaluations')
            ->count();

        $sessionsLongues = SessionFormation::where('statutSession', 'ouvert')
            ->where('dateDebut', '<=', $seuilSession->toDateString())
            ->count();

        $candidatsAvecAttestation = Attestation::pluck('candidat_id')->toArray();
        $admisSansAttestation = Candidat::where('statut', 'admis')
            ->whereNotIn('id', $candidatsAvecAttestation)
            ->count();

        $ajournes = Candidat::where('statut', 'ajourne')->count();

        return $sansEval + $sessionsLongues + $admisSansAttestation + $ajournes;
    }
}
