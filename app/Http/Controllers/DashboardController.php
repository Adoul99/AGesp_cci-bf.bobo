<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Inscription;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCandidats = Candidat::count();

        $permisD = $this->statsParCategorie('D');
        $permisE = $this->statsParCategorie('E');

        $repartitionPermis = Inscription::selectRaw('
                COALESCE(categorie_permis.nomCategorie, "Non renseigné") AS categorie,
                COUNT(*) AS total
            ')
            ->leftJoin('categorie_permis', 'categorie_permis.id', '=', 'inscriptions.categoriePermis_id')
            ->groupBy('categorie')
            ->pluck('total', 'categorie');

        return view('dashboard', compact(
            'totalCandidats',
            'permisD',
            'permisE',
            'repartitionPermis'
        ));
    }

    private function statsParCategorie(string $nomCategorie): array
    {
        $candidatIds = Inscription::whereHas('categoriePermis', function ($q) use ($nomCategorie) {
                $q->where('nomCategorie', $nomCategorie);
            })
            ->pluck('candidat_id')
            ->unique();

        $base = Candidat::whereIn('id', $candidatIds);

        // Code / Créneau / Conduite : progression INTERNE (évaluations saisies
        // par les moniteurs). On se base sur le champ statut de l'évaluation
        // ('reussi'), PAS sur resultat qui contient un texte libre du type
        // "Validé la session de Créneau" et ne vaut jamais littéralement "Admis"
        // (voir EvaluationController::calculerResultat()).
        $aValideType = function ($ids, string $type) {
            return Candidat::whereIn('id', $ids)
                ->whereHas('evaluations', function ($q) use ($type) {
                    $q->where('statut', 'reussi')
                      ->whereHas('typeSession', fn($qq) => $qq->where('type', $type));
                })
                ->count();
        };

        return [
            'total'    => (clone $base)->count(), // candidats uniques de cette catégorie
            'inscrits' => (clone $base)->where('statut', 'inscrit')->count(),
            'code'     => $aValideType($candidatIds, 'code'),
            'creneau'  => $aValideType($candidatIds, 'creneau'),
            'conduite' => $aValideType($candidatIds, 'conduite'),
            // Admis : UNIQUEMENT via le résultat OFFICIEL de l'examen (ministère),
            // cf. Candidat::mettreAJourStatutApresExamen() dans ExamenController::update().
            'admis'    => (clone $base)->where('statut', 'admis')->count(),
        ];
    }
}