<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Dossier;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CandidatController extends Controller
{
    public function index(Request $request)
    {
        $query = Candidat::query();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        // Les candidats les plus récemment inscrits apparaissent en premier
        $candidats = $query->with('dossiers')->orderBy('created_at', 'desc')->get();

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
        // Le formulaire "Nouveau Candidat" ne crée qu'un Candidat + Dossier, sans
        // Paiement ni Inscription (donc sans référence officielle GESP-XXXX).
        // On redirige donc vers le parcours complet d'Inscription au guichet,
        // qui crée Candidat + Dossier + Paiement + Inscription en une fois.
        return redirect()->route('inscriptions.create');
    }

    public function store(Request $request)
    {
        $dateLimiteMajorite = Carbon::now()->subYears(21)->format('Y-m-d');
        $dateLimitePermisC  = Carbon::now()->subMonths(6)->format('Y-m-d');

        $request->validate([
            'nom'                    => 'required',
            'prenom'                 => 'required',
            'dateNaissance'          => "required|date|after:1920-01-01|before_or_equal:{$dateLimiteMajorite}",
            'lieuNaissance'          => 'required',
            'telephone'              => 'required',
            'numeroPermisC'          => 'required',
            'dateDelivrancePermisC'  => "required|date|after:1970-01-01|before_or_equal:{$dateLimitePermisC}",
            'lieuDelivrancePermisC'  => 'required',
            'cnib'                   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'photo_identite'         => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'certificat_medical'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'acte_naissance'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'permis_c'               => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'dateNaissance.before_or_equal' =>
                "Le candidat doit avoir au moins 21 ans (né avant le " .
                Carbon::parse($dateLimiteMajorite)->format('d/m/Y') . ").",
            'dateDelivrancePermisC.before_or_equal' =>
                "Le permis C doit avoir au moins 6 mois d'ancienneté (délivré avant le " .
                Carbon::parse($dateLimitePermisC)->format('d/m/Y') . ").",
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

        $pieces = [
            'cnib'               => 'cnib',
            'photo_identite'     => 'photo_identite',
            'certificat_medical' => 'certificat_medical',
            'acte_naissance'     => 'acte_naissance',
            'permis_c'           => 'permis_c',
        ];

        $dossierData = [
            'candidat_id'   => $candidat->id,
            'nomDossier'    => 'Dossier de ' . $candidat->nom . ' ' . $candidat->prenom,
            'dateDepot'     => now()->toDateString(),
            'statutDossier' => 'en_attente',
        ];

        foreach ($pieces as $field => $col) {
            if ($request->hasFile($field)) {
                $dossierData[$col] = $request->file($field)->store("dossiers/{$candidat->id}", 'public');
            }
        }

        if (count($dossierData) > 1) {
            Dossier::create($dossierData);
        }

        return redirect()->route('candidats.index')
            ->with('success', '✅ Candidat enregistré avec succès.');
    }

    public function show(Candidat $candidat)
    {
        $candidat->load([
            'evaluations.typeSession',
            'sessions.typeSession',
            'inscriptions',
            'dossiers',
        ]);

        $candidat->mettreAJourStatut();
        $candidat->refresh();

        $evalParType = $candidat->evaluations->groupBy(function($e) {
            return $e->typeSession?->type ?? 'inconnu';
        });

        return view('candidats.show', compact('candidat', 'evalParType'));
    }

    public function edit(Candidat $candidat)
    {
        // Dernier dossier de pièces jointes du candidat (s'il existe), pour
        // afficher les documents actuellement enregistrés et permettre leur
        // remplacement individuel depuis cette même page.
        $dossier = $candidat->dossiers()->latest()->first();

        return view('candidats.edit', compact('candidat', 'dossier'));
    }

    public function update(Request $request, Candidat $candidat)
    {
        $dateLimiteMajorite = Carbon::now()->subYears(21)->format('Y-m-d');
        $dateLimitePermisC  = Carbon::now()->subMonths(6)->format('Y-m-d');

        $request->validate([
            'nom'                    => 'required|string|max:100',
            'prenom'                 => 'required|string|max:100',
            'telephone'              => 'nullable|string|max:20',
            'email'                  => 'nullable|email|max:100',
            // Même règle des 21 ans qu'à l'inscription — appliquée aussi en modification
            'dateNaissance'          => "required|date|after:1920-01-01|before_or_equal:{$dateLimiteMajorite}",
            'lieuNaissance'          => 'required|string|max:100',
            'numeroPermisC'          => 'required|string|max:50',
            'dateDelivrancePermisC'  => "required|date|after:1970-01-01|before_or_equal:{$dateLimitePermisC}",
            'lieuDelivrancePermisC'  => 'required|string|max:100',
            // Pièces jointes : facultatives ici, seulement si l'agent veut REMPLACER un document existant
            'cnib'                   => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'photo_identite'         => 'nullable|file|mimes:jpeg,jpg,png|max:5120',
            'certificat_medical'     => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'acte_naissance'         => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'permis_c'               => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
        ], [
            'dateNaissance.before_or_equal' =>
                "Le candidat doit avoir au moins 21 ans (né avant le " .
                Carbon::parse($dateLimiteMajorite)->format('d/m/Y') . ").",
            'dateDelivrancePermisC.before_or_equal' =>
                "Le permis C doit avoir au moins 6 mois d'ancienneté (délivré avant le " .
                Carbon::parse($dateLimitePermisC)->format('d/m/Y') . ").",
        ]);

        // Mise à jour ciblée (pas $request->all() : on ne veut pas écraser
        // 'statut' ou d'autres champs sensibles par erreur depuis ce formulaire)
        $candidat->update([
            'nom'                   => strtoupper(trim($request->nom)),
            'prenom'                => ucwords(strtolower(trim($request->prenom))),
            'telephone'             => $request->telephone,
            'email'                 => $request->email,
            'dateNaissance'         => $request->dateNaissance,
            'lieuNaissance'         => $request->lieuNaissance,
            'numeroPermisC'         => $request->numeroPermisC,
            'dateDelivrancePermisC' => $request->dateDelivrancePermisC,
            'lieuDelivrancePermisC' => $request->lieuDelivrancePermisC,
        ]);

        // Si l'agent a fourni un nouveau fichier pour une pièce jointe, on
        // met à jour le dossier existant (ou on en crée un si aucun n'existe).
        $piecesEnvoyees = collect(['cnib', 'photo_identite', 'certificat_medical', 'acte_naissance', 'permis_c'])
            ->filter(fn($champ) => $request->hasFile($champ));

        if ($piecesEnvoyees->isNotEmpty()) {
            $dossier = $candidat->dossiers()->latest()->first();

            $dossierData = [];
            foreach ($piecesEnvoyees as $champ) {
                $dossierData[$champ] = $request->file($champ)->store("dossiers/{$candidat->id}", 'public');
            }

            if ($dossier) {
                $dossier->update($dossierData);
            } else {
                Dossier::create(array_merge($dossierData, [
                    'candidat_id'   => $candidat->id,
                    'nomDossier'    => 'Dossier de ' . $candidat->nom . ' ' . $candidat->prenom,
                    'dateDepot'     => now()->toDateString(),
                    'statutDossier' => 'en_attente',
                ]));
            }
        }

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
