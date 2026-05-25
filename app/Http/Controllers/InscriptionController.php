<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Candidat;
use App\Models\CategoriePermis;
use App\Models\Dossier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            // Pièces jointes — toutes obligatoires
            'cnib'                  => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'photo_identite'        => 'required|file|mimes:jpeg,jpg,png|max:5120',
            'certificat_medical'    => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'acte_naissance'        => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'recu_paiement'         => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'permis_c'              => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
        ], [
            'nom.required'                  => 'Le nom est obligatoire.',
            'prenom.required'               => 'Le prénom est obligatoire.',
            'telephone.required'            => 'Le téléphone est obligatoire.',
            'dateNaissance.required'        => 'La date de naissance est obligatoire.',
            'lieuNaissance.required'        => 'Le lieu de naissance est obligatoire.',
            'categoriePermis_id.required'   => 'Veuillez choisir une catégorie de permis.',
            'categoriePermis_id.exists'     => 'Catégorie invalide.',
            'dataDebut_formation.required'  => 'La date de début de formation est obligatoire.',
            'cnib.required'                 => 'La CNIB est obligatoire.',
            'cnib.mimes'                    => 'La CNIB doit être un fichier JPEG, PNG ou PDF.',
            'cnib.max'                      => 'La CNIB ne doit pas dépasser 5 Mo.',
            'photo_identite.required'       => 'La photo d\'identité est obligatoire.',
            'photo_identite.mimes'          => 'La photo d\'identité doit être un fichier JPEG ou PNG.',
            'photo_identite.max'            => 'La photo d\'identité ne doit pas dépasser 5 Mo.',
            'certificat_medical.required'   => 'Le certificat médical est obligatoire.',
            'certificat_medical.mimes'      => 'Le certificat médical doit être un fichier JPEG, PNG ou PDF.',
            'certificat_medical.max'        => 'Le certificat médical ne doit pas dépasser 5 Mo.',
            'acte_naissance.required'       => 'L\'acte de naissance est obligatoire.',
            'acte_naissance.mimes'          => 'L\'acte de naissance doit être un fichier JPEG, PNG ou PDF.',
            'acte_naissance.max'            => 'L\'acte de naissance ne doit pas dépasser 5 Mo.',
            'recu_paiement.required'        => 'Le reçu de paiement est obligatoire.',
            'recu_paiement.mimes'           => 'Le reçu de paiement doit être un fichier JPEG, PNG ou PDF.',
            'recu_paiement.max'             => 'Le reçu de paiement ne doit pas dépasser 5 Mo.',
            'permis_c.mimes'                => 'La copie du permis C doit être un fichier JPEG, PNG ou PDF.',
            'permis_c.max'                  => 'La copie du permis C ne doit pas dépasser 5 Mo.',
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

            // 2. Générer la référence unique basée sur l'ID fraîchement généré
            $reference = 'GESP-' . date('Y') . '-' . str_pad($candidat->id, 5, '0', STR_PAD_LEFT);

            // 3. Uploader les pièces jointes dans storage/app/public/dossiers/{reference}/
            $dossierPath = 'dossiers/' . $reference;

            $cnibPath             = $request->file('cnib')->store($dossierPath, 'public');
            $photoIdentitePath    = $request->file('photo_identite')->store($dossierPath, 'public');
            $certificatPath       = $request->file('certificat_medical')->store($dossierPath, 'public');
            $acteNaissancePath    = $request->file('acte_naissance')->store($dossierPath, 'public');
            $recuPaiementPath     = $request->file('recu_paiement')->store($dossierPath, 'public');
            $permisCPath          = $request->hasFile('permis_c')
                                        ? $request->file('permis_c')->store($dossierPath, 'public')
                                        : null;

            // 4. Formater le statut
            $statutFormate = 'en attente';
            if ($request->statutInscription && strtolower($request->statutInscription) === 'actif') {
                $statutFormate = 'actif';
            }

            // 5. Créer l'inscription avec sa référence et ses pièces jointes
            Inscription::create([
                'candidat_id'         => $candidat->id,
                'reference'           => $reference,
                'dateInscription'     => $request->dateInscription ?? now()->toDateString(),
                'statutInscription'   => $statutFormate,
                'dataDebut_formation' => $request->dataDebut_formation,
                'cnib'                => $cnibPath,
                'photo_identite'      => $photoIdentitePath,
                'certificat_medical'  => $certificatPath,
                'acte_naissance'      => $acteNaissancePath,
                'recu_paiement'       => $recuPaiementPath,
                'permis_c'            => $permisCPath,
            ]);

            // 6. Créer également un dossier lié au candidat pour que l'administration puisse le vérifier
            Dossier::create([
                'nomDossier'      => $reference,
                'description'     => 'Dossier automatique créé après inscription en ligne',
                'dateDepot'       => now()->toDateString(),
                'statutDossier'   => 'en_attente',
                'candidat_id'     => $candidat->id,
                'cnib'            => $cnibPath,
                'photo_identite'  => $photoIdentitePath,
                'certificat_medical' => $certificatPath,
                'acte_naissance'  => $acteNaissancePath,
                'recu_paiement'   => $recuPaiementPath,
                'permis_c'        => $permisCPath,
            ]);

            // 7. Récupérer le nom de la catégorie pour le récépissé
            $categorie    = CategoriePermis::find($request->categoriePermis_id);
            $nomCategorie = $categorie
                ? ($categorie->pareCategorie ?? $categorie->nomCategorie ?? $categorie->nom)
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
            ];
        });

        // Redirection vers la vue succès avec TOUTES les données flashées
        return redirect()
            ->route('inscription.succes')
            ->with($data);
    }

    public function succes()
    {
        // Si la session n'a pas de référence (accès direct à l'URL sans s'inscrire)
        if (!session('reference')) {
            return redirect()->route('inscription.public');
        }

        return view('inscription-success');
    }
}
