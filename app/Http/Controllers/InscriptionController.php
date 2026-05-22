<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Candidat;
use App\Models\CategoriePermis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Important pour les transactions

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

        // Utilisation d'une transaction pour sécuriser la double écriture
        $data = DB::transaction(function () use ($request) {
            
            // 1. Créer le candidat
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

            // Formater le statut d'inscription en minuscules (pour correspondre à l'enum MySQL)
            $statutFormate = 'en attente';
            if ($request->statutInscription && strtolower($request->statutInscription) === 'actif') {
                $statutFormate = 'actif';
            }

            // 2. Générer la référence unique basée sur l'ID fraîchement généré
            $reference = 'GESP-' . date('Y') . '-' . str_pad($candidat->id, 5, '0', STR_PAD_LEFT);

            // 3. Créer l'inscription avec sa référence intégrée
            Inscription::create([
                'candidat_id'         => $candidat->id,
                'reference'           => $reference, 
                'dateInscription'     => $request->dateInscription ?? now()->toDateString(),
                'statutInscription'   => $statutFormate,
                'dataDebut_formation' => $request->dataDebut_formation,
            ]);

            return [
                'reference'    => $reference,
                'candidat_nom' => $candidat->nom . ' ' . $candidat->prenom
            ];
        });

        // Redirection vers la vue succès avec les données flashées
        return redirect()
            ->route('inscription.succes')
            ->with('reference', $data['reference'])
            ->with('candidat_nom', $data['candidat_nom']);
    }

    public function succes()
{
    // Si la session n'a pas de référence (accès direct à l'URL sans s'inscrire)
    if (!session('reference')) {
        // Redirige vers la route nommée 'inscription.public' définie dans votre web.php
        return redirect()->route('inscription.public'); 
    }
    
    // Affiche votre vue 'inscription-success.blade.php'
    return view('inscription-success'); 
}
}