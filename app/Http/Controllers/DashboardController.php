<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Inscription;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCandidats = Candidat::count();

        $statsD = $this->statsParCategorie('D');
        $statsE = $this->statsParCategorie('E');

        $repartitionPermis = Inscription::selectRaw('
                COALESCE(categorie_permis.nomCategorie, "Non renseigné") AS categorie,
                COUNT(*) AS total
            ')
            ->leftJoin('categorie_permis', 'categorie_permis.id', '=', 'inscriptions.categoriePermis_id')
            ->groupBy('categorie')
            ->pluck('total', 'categorie');

        return view('dashboard', compact(
            'totalCandidats',
            'statsD',
            'statsE',
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
            'inscrits' => (clone $base)->count(),
            'code'     => (clone $base)->where('statut', 'code_admis')->count(),
            'creneau'  => (clone $base)->where('statut', 'creneau')->count(),
            'conduite' => (clone $base)->where('statut', 'ajourne')->count(),
            'admis'    => (clone $base)->where('statut', 'admis')->count(),
        ];
    }
}