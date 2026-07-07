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

        return [
            // "Inscrit" = TOUS les candidats de la catégorie, même logique que CandidatController::index()
            'inscrits' => (clone $base)->count(),
            'code'     => (clone $base)->where('statut', 'code_admis')->count(),
            'creneau'  => 0, // ⚠️ aucun statut "creneau" n'existe en base actuellement
            'conduite' => (clone $base)->where('statut', 'en_formation')->count(),
            'admis'    => (clone $base)->where('statut', 'admis')->count(),
        ];
    }
}