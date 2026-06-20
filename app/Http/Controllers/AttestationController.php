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

    public function create()
    {
        // Seuls les candidats admis (code + créneau + conduite) peuvent recevoir une attestation
        // et qui n'ont pas déjà d'attestation existante
        $candidatsAvecAttestation = Attestation::pluck('candidat_id')->toArray();

        $candidats = Candidat::where('statut', 'admis')
            ->whereNotIn('id', $candidatsAvecAttestation)
            ->orderBy('nom')
            ->get();

        $examens = Examen::orderBy('dateDebut', 'desc')->get();

        // Numéro pré-généré automatiquement
        $numeroAuto = Attestation::genererNumero();

        return view('attestations.create', compact('candidats', 'examens', 'numeroAuto'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dateDelivrance'    => 'required|date',
            'numeroAttestation' => 'required|unique:attestations,numeroAttestation',
            'candidat_id'       => 'required|exists:candidats,id',
            'examen_id'         => 'nullable|exists:examens,id',
        ]);

        Attestation::create($request->only(
            'dateDelivrance', 'numeroAttestation', 'candidat_id', 'examen_id'
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
          ->orderBy('nom')->get();

        $examens = Examen::orderBy('dateDebut', 'desc')->get();

        return view('attestations.edit', compact('attestation', 'candidats', 'examens'));
    }

    public function update(Request $request, Attestation $attestation)
    {
        $request->validate([
            'dateDelivrance'    => 'required|date',
            'numeroAttestation' => 'required|unique:attestations,numeroAttestation,' . $attestation->id,
            'candidat_id'       => 'required|exists:candidats,id',
            'examen_id'         => 'nullable|exists:examens,id',
        ]);

        $attestation->update($request->only(
            'dateDelivrance', 'numeroAttestation', 'candidat_id', 'examen_id'
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
}
