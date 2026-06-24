<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Candidat;
use App\Models\CategoriePermis;
use App\Models\Dossier;
use App\Models\Paiement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InscriptionController extends Controller
{
    // ── ADMIN : liste ──────────────────────────────────────────
    public function index()
    {
        $inscriptions = Inscription::with('candidat', 'paiement')->get();
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
            'paiement_id'     => 'required',
        ]);

        Inscription::create($request->all());
        return redirect()->route('inscriptions.index')->with('success', 'Inscription créée avec succès.');
    }

    // ── ADMIN : modifier ───────────────────────────────────────
    public function edit(Inscription $inscription)
    {
        $candidats  = Candidat::all();
        $categories = CategoriePermis::orderBy('nomCategorie')->get();
        return view('inscriptions.edit', compact('inscription', 'candidats', 'categories'));
    }

    // ── ADMIN : mettre à jour ──────────────────────────────────
    public function update(Request $request, Inscription $inscription)
    {
        $inscription->update($request->all());
        return redirect()->route('inscriptions.index')->with('success', 'Inscription mise à jour.');
    }

    // ── ADMIN : supprimer ──────────────────────────────────────
    public function destroy(Inscription $inscription)
    {
        $inscription->delete();
        return redirect()->route('inscriptions.index')->with('success', 'Inscription supprimée.');
    }

    // ══════════════════════════════════════════════════════════
    // PUBLIC : formulaire d'inscription en ligne
    // ══════════════════════════════════════════════════════════

    /**
     * Affiche le formulaire d'inscription en ligne
     */
    public function formulairePublic()
    {
        $categories = CategoriePermis::orderBy('nomCategorie')->get();
        return view('inscription-publique', compact('categories'));
    }

    /**
     * Enregistre une nouvelle inscription
     * SANS recu_paiement (le reçu sera remis à l'arrivée)
     */
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

            // Pièces jointes — SANS recu_paiement
            'cnib'                  => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'photo_identite'        => 'required|file|mimes:jpeg,jpg,png|max:5120',
            'certificat_medical'    => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'acte_naissance'        => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'permis_c'              => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',

            // Paiement — OBLIGATOIRE
            'modePaiement'          => 'required|in:especes,mobile_money,virement',
            'montantPaiement'       => 'required|numeric|min:1',
            'tranchePaiement'       => 'required|string|in:total,tranche1,tranche2',
            'operateur'             => 'nullable|string|max:100',
            'numeroTransaction'     => 'nullable|string|max:100',
            'referenceVirement'     => 'nullable|string|max:100',
            'dateVirement'          => 'nullable|date',
            'datePaiement'          => 'required|date',
        ], [
            'nom.required'                  => 'Le nom est obligatoire.',
            'prenom.required'               => 'Le prénom est obligatoire.',
            'telephone.required'            => 'Le téléphone est obligatoire.',
            'dateNaissance.required'        => 'La date de naissance est obligatoire.',
            'lieuNaissance.required'        => 'Le lieu de naissance est obligatoire.',
            'categoriePermis_id.required'   => 'Veuillez choisir une catégorie de permis.',
            'dataDebut_formation.required'  => 'La date de début de formation est obligatoire.',
            'cnib.required'                 => 'La CNIB est obligatoire.',
            'photo_identite.required'       => 'La photo d\'identité est obligatoire.',
            'certificat_medical.required'   => 'Le certificat médical est obligatoire.',
            'acte_naissance.required'       => 'L\'acte de naissance est obligatoire.',
            'modePaiement.required'         => 'Veuillez choisir un mode de paiement.',
            'montantPaiement.required'      => 'Le montant de paiement est obligatoire.',
            'tranchePaiement.required'      => 'Veuillez choisir une modalité (total ou tranche).',
        ]);

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

            // 2. Référence unique
            $reference = 'GESP-' . date('Y') . '-' . str_pad($candidat->id, 5, '0', STR_PAD_LEFT);

            // 3. Upload pièces jointes — SANS recu_paiement
            $dossierPath = 'dossiers/' . $reference;

            $cnibPath          = $request->file('cnib')->store($dossierPath, 'public');
            $photoIdentitePath = $request->file('photo_identite')->store($dossierPath, 'public');
            $certificatPath    = $request->file('certificat_medical')->store($dossierPath, 'public');
            $acteNaissancePath = $request->file('acte_naissance')->store($dossierPath, 'public');
            $permisCPath       = $request->hasFile('permis_c')
                                    ? $request->file('permis_c')->store($dossierPath, 'public')
                                    : null;

            // 4. Créer le paiement
            $paiement = Paiement::create([
                'montant'           => $request->montantPaiement,
                'modePaiement'      => $request->modePaiement,
                'tranchePaiement'   => $request->tranchePaiement,
                'operateur'         => $request->operateur,
                'numeroTransaction' => $request->numeroTransaction,
                'referenceVirement' => $request->referenceVirement,
                'dateVirement'      => $request->dateVirement,
                'datePaiement'      => $request->datePaiement,
                'statut'            => 'en_attente',
                'candidat_id'       => $candidat->id,
            ]);

            // 5. Statut inscription — TOUJOURS "en attente" lors d'une inscription publique.
            // Seule l'administration peut faire passer une inscription à "actif",
            // après vérification du dossier (pièces jointes). Le candidat ne doit
            // jamais pouvoir choisir lui-même ce statut.
            $statutFormate = 'en_attente';

            // 6. Créer l'inscription
            Inscription::create([
                'candidat_id'         => $candidat->id,
                'categoriePermis_id'  => $request->categoriePermis_id,
                'reference'           => $reference,
                'dateInscription'     => $request->dateInscription ?? now()->toDateString(),
                'statutInscription'   => $statutFormate,
                'dataDebut_formation' => $request->dataDebut_formation,
                'paiement_id'         => $paiement->id,
                // Fichiers — SANS recu_paiement
                'cnib'                => $cnibPath,
                'photo_identite'      => $photoIdentitePath,
                'certificat_medical'  => $certificatPath,
                'acte_naissance'      => $acteNaissancePath,
                'permis_c'            => $permisCPath,
            ]);

            // 7. Créer le dossier lié
            Dossier::create([
                'nomDossier'         => $reference,
                'description'        => 'Dossier automatique créé après inscription en ligne',
                'dateDepot'          => now()->toDateString(),
                'statutDossier'      => 'en_attente',
                'candidat_id'        => $candidat->id,
                'cnib'               => $cnibPath,
                'photo_identite'     => $photoIdentitePath,
                'certificat_medical' => $certificatPath,
                'acte_naissance'     => $acteNaissancePath,
                'permis_c'           => $permisCPath,
            ]);

            // 8. Données pour le récépissé
            $categorie    = CategoriePermis::find($request->categoriePermis_id);
            $nomCategorie = $categorie
                ? ($categorie->pareCategorie ?? $categorie->nomCategorie ?? $categorie->nom ?? '—')
                : '—';

            return [
                'reference'           => $reference,
                'nom'                 => $candidat->nom,
                'prenom'              => $candidat->prenom,
                'telephone'           => $candidat->telephone,
                'dateNaissance'       => $candidat->dateNaissance,
                'lieuNaissance'       => $candidat->lieuNaissance,
                'categorie_nom'       => $nomCategorie,
                'dataDebut_formation' => $request->dataDebut_formation,
                'dateInscription'     => $request->dateInscription ?? now()->toDateString(),
                'montantPaiement'     => $request->montantPaiement,
                'modePaiement'        => $request->modePaiement,
                'tranchePaiement'     => $request->tranchePaiement,
            ];
        });

        return redirect()
            ->route('inscription.succes')
            ->with($data);
    }

    /**
     * Affiche la page de succès avec le récépissé
     */
    public function succes()
    {
        if (!session('reference')) {
            return redirect()->route('inscription.public');
        }
        return view('inscription-success');
    }
}