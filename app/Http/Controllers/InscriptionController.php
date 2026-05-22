<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Candidat;
use App\Models\CategoriePermis;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    // ── ADMIN : liste ──────────────────────────────────────────
    public function index()
    {
        $inscriptions = Inscription::with('candidat')->get();
        return view('inscriptions.index', compact('inscriptions'));
    }

    // ── ADMIN : formulaire création ────────────────────────────
    public function create()
    {
        $candidats = Candidat::all();
        return view('inscriptions.create', compact('candidats'));
    }

    // ── ADMIN : enregistrer ────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'dateInscription' => 'required|date',
            'candidat_id'     => 'required',
        ]);

        Inscription::create($request->all());
        return redirect()->route('inscriptions.index');
    }

    // ── ADMIN : modifier ───────────────────────────────────────
    public function edit(Inscription $inscription)
    {
        $candidats = Candidat::all();
        return view('inscriptions.edit', compact('inscription', 'candidats'));
    }

    // ── ADMIN : mettre à jour ──────────────────────────────────
    public function update(Request $request, Inscription $inscription)
    {
        $inscription->update($request->all());
        return redirect()->route('inscriptions.index');
    }

    // ── ADMIN : supprimer ──────────────────────────────────────
    public function destroy(Inscription $inscription)
    {
        $inscription->delete();
        return redirect()->route('inscriptions.index');
    }

    // ══════════════════════════════════════════════════════════
    // PUBLIC : formulaire d'inscription en ligne
    // ══════════════════════════════════════════════════════════

    public function formulairePublic()
    {
        $categories = CategoriePermis::orderBy('nomCategorie')->get();
        return view('inscription-publique', compact('categories'));
    }

    public function storePublic(Request $request)
    {
        // ── Validation ────────────────────────────────────────
        $request->validate([
            'nom'                   => 'required|string|max:100',
            'prenom'                => 'required|string|max:100',
            'telephone'             => 'required|string|max:20',
            'email'                 => 'nullable|email|max:100',
            'dateNaissance'         => 'required|date',
            'lieuNaissance'         => 'required|string|max:100',
            'numeroPermisC'         => 'nullable|string|max:50',
            'dateDelivrancePermisC' => 'nullable|date',
            'lieuDelivrancePermisC' => 'nullable|string|max:100',
            'categoriePermis_id'    => 'required|exists:categorie_permis,id',
            'dataDebut_formation'   => 'required|date',
            'dateInscription'       => 'nullable|date',
        ], [
            'nom.required'                 => 'Le nom est obligatoire.',
            'prenom.required'              => 'Le prénom est obligatoire.',
            'telephone.required'           => 'Le téléphone est obligatoire.',
            'dateNaissance.required'       => 'La date de naissance est obligatoire.',
            'lieuNaissance.required'       => 'Le lieu de naissance est obligatoire.',
            'categoriePermis_id.required'  => 'Veuillez choisir une catégorie de permis.',
            'categoriePermis_id.exists'    => 'Catégorie invalide.',
            'dataDebut_formation.required' => 'La date de début de formation est obligatoire.',
        ]);

        // ── Créer le candidat ─────────────────────────────────
        $candidat = Candidat::create([
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

        // ── Créer l'inscription ───────────────────────────────
        Inscription::create([
            'candidat_id'         => $candidat->id,
            'dateInscription'     => $request->dateInscription ?? now()->toDateString(),
            'statutInscription'   => 'en_attente',
            'dataDebut_formation' => $request->dataDebut_formation,
        ]);

        // ── Numéro de référence ───────────────────────────────
        $reference = 'GESP-' . date('Y') . '-' . str_pad($candidat->id, 5, '0', STR_PAD_LEFT);

        return redirect()
            ->route('inscription.succes')
            ->with('reference', $reference)
            ->with('candidat_nom', $candidat->nom . ' ' . $candidat->prenom);
    }

    public function succes()
    {
        if (!session('reference')) {
            return redirect()->route('inscription.public');
        }
        return view('inscription-success');
    }
}
