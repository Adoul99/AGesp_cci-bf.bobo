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
            ->with(['examens.typeSession', 'inscriptions.categoriePermis'])
            ->orderBy('nom')
            ->get();

        // Numéro pré-généré automatiquement
        $numeroAuto = Attestation::genererNumero();

        // Tout est désormais calculé automatiquement à partir du candidat :
        // catégorie obtenue, examen correspondant, dates d'admission officielles.
        // Rien de tout cela n'est plus modifiable manuellement dans le formulaire.
        $suggestions = $candidats->mapWithKeys(fn($c) => [$c->id => $this->calculerSuggestions($c)]);

        // Candidat présélectionné depuis le lien "🎓 Attestation" du module Examens
        // (?candidat_id=...). On vérifie qu'il fait bien partie des candidats
        // éligibles avant de l'imposer, sinon on l'ignore silencieusement.
        $candidatPreselectionne = $request->query('candidat_id');
        if ($candidatPreselectionne && !$candidats->contains('id', (int) $candidatPreselectionne)) {
            $candidatPreselectionne = null;
        }

        return view('attestations.create', compact(
            'candidats', 'numeroAuto', 'suggestions', 'candidatPreselectionne'
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
            'dateAdmissionCode'     => 'nullable|date',
            'dateAdmissionConduite' => 'nullable|date',
            'directeurCivilite'     => 'required|in:Monsieur,Madame',
            'directeurNom'          => 'required|string|max:150',
        ]);

        Attestation::create($request->only(
            'dateDelivrance', 'numeroAttestation', 'candidat_id', 'examen_id',
            'civilite', 'categorieObtenue',
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
          ->with(['examens.typeSession', 'inscriptions.categoriePermis'])
          ->orderBy('nom')->get();

        $suggestions = $candidats->mapWithKeys(fn($c) => [$c->id => $this->calculerSuggestions($c)]);

        return view('attestations.edit', compact('attestation', 'candidats', 'suggestions'));
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
            'dateAdmissionCode'     => 'nullable|date',
            'dateAdmissionConduite' => 'nullable|date',
            'directeurCivilite'     => 'required|in:Monsieur,Madame',
            'directeurNom'          => 'required|string|max:150',
        ]);

        $attestation->update($request->only(
            'dateDelivrance', 'numeroAttestation', 'candidat_id', 'examen_id',
            'civilite', 'categorieObtenue',
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
     * Calcule TOUTES les informations automatiques d'un candidat pour son
     * attestation — catégorie obtenue, examen correspondant, dates
     * d'admission officielles. Ces valeurs ne sont plus de simples
     * "suggestions" modifiables : elles verrouillent les champs du
     * formulaire (voir vues create/edit), l'utilisateur ne choisissant que
     * le candidat lui-même.
     */
    private function calculerSuggestions(Candidat $candidat): array
    {
        $categorie = $this->determinerCategorieObtenue($candidat);

        // Examens officiels où le candidat a été déclaré "Admis"
        $examensAdmis = $candidat->examens->filter(fn($e) => $e->pivot->resultat === 'Admis');

        // Date d'admission Code / Conduite = date à laquelle le résultat
        // officiel "Admis" a été enregistré pour ce type d'examen (timestamp
        // de mise à jour du pivot candidat_examen), PAS une simple date de
        // formation interne.
        $dateAdmissionCode = $examensAdmis
            ->filter(fn($e) => strtolower($e->typeSession?->type ?? '') === 'code')
            ->map(fn($e) => $e->pivot->updated_at)
            ->max();

        $dateAdmissionConduite = $examensAdmis
            ->filter(fn($e) => strtolower($e->typeSession?->type ?? '') === 'conduite')
            ->map(fn($e) => $e->pivot->updated_at)
            ->max();

        // Examen correspondant à la catégorie du candidat (le libellé de
        // l'examen contient "E" ou "D" selon la catégorie du permis passé —
        // ex : "Permis E"). On privilégie l'examen de Conduite (dernière
        // étape officielle) si plusieurs examens de cette catégorie existent.
        $examen = null;
        if ($categorie) {
            $examen = $examensAdmis
                ->filter(fn($e) => str_contains(strtoupper($e->libelle), $categorie))
                ->sortByDesc(fn($e) => strtolower($e->typeSession?->type ?? '') === 'conduite' ? 1 : 0)
                ->first();
        }

        return [
            'dateAdmissionCode'     => $dateAdmissionCode,
            'dateAdmissionConduite' => $dateAdmissionConduite,
            'categorieObtenue'      => $categorie,
            'examenId'              => $examen?->id,
            'examenLibelle'         => $examen?->libelle,
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
