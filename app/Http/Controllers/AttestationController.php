<?php

namespace App\Http\Controllers;

use App\Models\Attestation;
use App\Models\Candidat;
use App\Models\Examen;
use Illuminate\Http\Request;

class AttestationController extends Controller
{
    public function index()
    {
        $attestations = Attestation::with(['candidat', 'examen'])->latest()->get();
        return view('attestations.index', compact('attestations'));
    }

    public function create(Request $request)
    {
        // Seuls les candidats admis (code + créneau + conduite) peuvent recevoir une attestation
        // et qui n'ont pas déjà d'attestation existante
        $candidatsAvecAttestation = Attestation::pluck('candidat_id')->toArray();

        $candidats = Candidat::where('statut', 'admis')
            ->whereNotIn('id', $candidatsAvecAttestation)
            ->with(['evaluations.typeSession', 'sessions', 'inscriptions.categoriePermis'])
            ->orderBy('nom')
            ->get();

        $examens = Examen::orderBy('dateDebut', 'desc')->get();

        // Numéro pré-généré automatiquement
        $numeroAuto = Attestation::genererNumero();

        // Suggestions de dates + catégorie par candidat (auto-remplissage JS, modifiable)
        $suggestions = $candidats->mapWithKeys(fn($c) => [$c->id => $this->calculerSuggestions($c)]);

        // Candidat présélectionné depuis le lien "🎓 Attestation" du module Examens
        // (?candidat_id=...). On vérifie qu'il fait bien partie des candidats
        // éligibles avant de l'imposer, sinon on l'ignore silencieusement.
        $candidatPreselectionne = $request->query('candidat_id');
        if ($candidatPreselectionne && !$candidats->contains('id', (int) $candidatPreselectionne)) {
            $candidatPreselectionne = null;
        }

        return view('attestations.create', compact(
            'candidats', 'examens', 'numeroAuto', 'suggestions', 'candidatPreselectionne'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dateDelivrance'        => 'required|date',
            'numeroAttestation'     => 'required|unique:attestations,numeroAttestation',
            'candidat_id'           => 'required|exists:candidats,id',
            'examen_id'             => 'nullable|exists:examens,id',
            'civilite'              => 'required|in:Monsieur,Madame,Mademoiselle',
            'categorieObtenue'      => 'required|in:E,D',
            'formationDateDebut'    => 'nullable|date',
            'formationDateFin'      => 'nullable|date',
            'dateAdmissionCode'     => 'nullable|date',
            'dateAdmissionConduite' => 'nullable|date',
            'directeurCivilite'     => 'required|in:Monsieur,Madame',
            'directeurNom'          => 'required|string|max:150',
        ]);

        Attestation::create($request->only(
            'dateDelivrance', 'numeroAttestation', 'candidat_id', 'examen_id',
            'civilite', 'categorieObtenue', 'formationDateDebut', 'formationDateFin',
            'dateAdmissionCode', 'dateAdmissionConduite', 'directeurCivilite', 'directeurNom'
        ));

        return redirect()->route('attestations.index')
            ->with('success', '✅ Attestation créée avec succès.');
    }

    /**
     * Affiche l'attestation officielle imprimable
     */
    public function show(Attestation $attestation)
    {
        $attestation->load(['candidat', 'examen']);
        return view('attestations.show', compact('attestation'));
    }

    public function edit(Attestation $attestation)
    {
        $candidatsAvecAttestation = Attestation::where('id', '!=', $attestation->id)
            ->pluck('candidat_id')->toArray();

        $candidats = Candidat::where(function ($q) use ($candidatsAvecAttestation, $attestation) {
            $q->where('statut', 'admis')
              ->whereNotIn('id', $candidatsAvecAttestation);
        })->orWhere('id', $attestation->candidat_id)
          ->with(['evaluations.typeSession', 'sessions', 'inscriptions.categoriePermis'])
          ->orderBy('nom')->get();

        $examens = Examen::orderBy('dateDebut', 'desc')->get();

        $suggestions = $candidats->mapWithKeys(fn($c) => [$c->id => $this->calculerSuggestions($c)]);

        return view('attestations.edit', compact('attestation', 'candidats', 'examens', 'suggestions'));
    }

    public function update(Request $request, Attestation $attestation)
    {
        $request->validate([
            'dateDelivrance'        => 'required|date',
            'numeroAttestation'     => 'required|unique:attestations,numeroAttestation,' . $attestation->id,
            'candidat_id'           => 'required|exists:candidats,id',
            'examen_id'             => 'nullable|exists:examens,id',
            'civilite'              => 'required|in:Monsieur,Madame,Mademoiselle',
            'categorieObtenue'      => 'required|in:E,D',
            'formationDateDebut'    => 'nullable|date',
            'formationDateFin'      => 'nullable|date',
            'dateAdmissionCode'     => 'nullable|date',
            'dateAdmissionConduite' => 'nullable|date',
            'directeurCivilite'     => 'required|in:Monsieur,Madame',
            'directeurNom'          => 'required|string|max:150',
        ]);

        $attestation->update($request->only(
            'dateDelivrance', 'numeroAttestation', 'candidat_id', 'examen_id',
            'civilite', 'categorieObtenue', 'formationDateDebut', 'formationDateFin',
            'dateAdmissionCode', 'dateAdmissionConduite', 'directeurCivilite', 'directeurNom'
        ));

        return redirect()->route('attestations.index')
            ->with('success', '✅ Attestation mise à jour.');
    }

    public function destroy(Attestation $attestation)
    {
        $attestation->delete();
        return redirect()->route('attestations.index')
            ->with('success', '✅ Attestation supprimée.');
    }

    /**
     * Calcule des suggestions (dates + catégorie de permis) pour un candidat,
     * utilisées pour pré-remplir automatiquement le formulaire (reste modifiable).
     */
    private function calculerSuggestions(Candidat $candidat): array
    {
        $dateAdmissionCode = $candidat->evaluations
            ->filter(fn($e) => $e->typeSession?->type === 'code' && $e->resultat === 'Admis')
            ->max('dateEvaluation');

        $dateAdmissionConduite = $candidat->evaluations
            ->filter(fn($e) => $e->typeSession?->type === 'conduite' && $e->resultat === 'Admis')
            ->max('dateEvaluation');

        $formationDateDebut = $candidat->sessions->min('dateDebut');
        $formationDateFin   = $dateAdmissionConduite ?: $candidat->sessions->max('dateDebut');

        return [
            'dateAdmissionCode'     => $dateAdmissionCode,
            'dateAdmissionConduite' => $dateAdmissionConduite,
            'formationDateDebut'    => $formationDateDebut,
            'formationDateFin'      => $formationDateFin,
            'categorieObtenue'      => $this->determinerCategorieObtenue($candidat),
        ];
    }

    /**
     * Détermine la catégorie de permis (E ou D) du candidat à partir
     * de sa dernière inscription (relation Inscription -> CategoriePermis).
     */
    private function determinerCategorieObtenue(Candidat $candidat): ?string
    {
        $inscription = $candidat->inscriptions->sortByDesc('id')->first();
        $nomCategorie = $inscription?->categoriePermis?->nomCategorie;

        if (!$nomCategorie) {
            return null;
        }

        $nomCategorie = strtoupper($nomCategorie);

        if (str_contains($nomCategorie, 'D')) {
            return 'D';
        }

        if (str_contains($nomCategorie, 'E')) {
            return 'E';
        }

        return null;
    }
}