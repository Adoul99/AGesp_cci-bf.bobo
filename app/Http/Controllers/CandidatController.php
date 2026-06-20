<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;

class CandidatController extends Controller
{
    public function index(Request $request)
    {
        $query = Candidat::query();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $candidats = $query->orderBy('nom')->get();

        // Compter par statut pour les badges du filtre
        $counts = [
            'tous'         => Candidat::count(),
            'inscrit'      => Candidat::where('statut', 'inscrit')->count(),
            'en_formation' => Candidat::where('statut', 'en_formation')->count(),
            'code_admis'   => Candidat::where('statut', 'code_admis')->count(),
            'admis'        => Candidat::where('statut', 'admis')->count(),
            'ajourne'      => Candidat::where('statut', 'ajourne')->count(),
        ];

        return view('candidats.index', compact('candidats', 'counts'));
    }

    public function create()
    {
        return view('candidats.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'                    => 'required',
            'prenom'                 => 'required',
            'dateNaissance'          => 'required|date',
            'lieuNaissance'          => 'required',
            'telephone'              => 'required',
            'numeroPermisC'          => 'required',
            'dateDelivrancePermisC'  => 'required|date',
            'lieuDelivrancePermisC'  => 'required',
            'cnib'                   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'photo_identite'         => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'certificat_medical'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'acte_naissance'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'permis_c'               => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $candidat = Candidat::create([
            'nom'                   => $request->nom,
            'prenom'                => $request->prenom,
            'dateNaissance'         => $request->dateNaissance,
            'lieuNaissance'         => $request->lieuNaissance,
            'telephone'             => $request->telephone,
            'email'                 => $request->email,
            'numeroPermisC'         => $request->numeroPermisC,
            'dateDelivrancePermisC' => $request->dateDelivrancePermisC,
            'lieuDelivrancePermisC' => $request->lieuDelivrancePermisC,
            'statut'                => 'inscrit',
        ]);

        // Créer le dossier et stocker les pièces jointes
        $pieces = [
            'cnib'               => 'cnib',
            'photo_identite'     => 'photo_identite',
            'certificat_medical' => 'certificat_medical',
            'acte_naissance'     => 'acte_naissance',
            'permis_c'           => 'permis_c',
        ];

        $dossierData = [
            'candidat_id'  => $candidat->id,
            'nomDossier'   => 'Dossier de ' . $candidat->nom . ' ' . $candidat->prenom,
            'dateDepot'    => now()->toDateString(),
            'statutDossier'=> 'en_attente',
        ];
        foreach ($pieces as $field => $col) {
            if ($request->hasFile($field)) {
                $dossierData[$col] = $request->file($field)->store("dossiers/{$candidat->id}", 'public');
            }
        }

        // Créer le dossier si au moins une pièce fournie
        if (count($dossierData) > 1) {
            \App\Models\Dossier::create($dossierData);
        }

        return redirect()->route('candidats.index')
            ->with('success', '✅ Candidat enregistré avec succès.');
    }

    /**
     * Fiche statut du candidat — affiche son niveau complet
     */
    public function show(Candidat $candidat)
    {
        $candidat->load([
            'evaluations.typeSession',
            'sessions.typeSession',
            'inscriptions',
            'dossiers',
        ]);

        // Mettre à jour le statut automatiquement
        $candidat->mettreAJourStatut();
        $candidat->refresh();

        // Résumé des évaluations par type
        $evalParType = $candidat->evaluations->groupBy(function($e) {
            return $e->typeSession?->type ?? 'inconnu';
        });

        return view('candidats.show', compact('candidat', 'evalParType'));
    }

    public function edit(Candidat $candidat)
    {
        return view('candidats.edit', compact('candidat'));
    }

    public function update(Request $request, Candidat $candidat)
    {
        $candidat->update($request->all());
        return redirect()->route('candidats.index')
            ->with('success', '✅ Candidat mis à jour.');
    }

    public function destroy(Candidat $candidat)
    {
        $candidat->delete();
        return redirect()->route('candidats.index')
            ->with('success', '✅ Candidat supprimé.');
    }
}