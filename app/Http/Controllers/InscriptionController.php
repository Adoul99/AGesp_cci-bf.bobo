<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Candidat;
use App\Models\CategoriePermis;
use App\Models\Dossier;
use App\Models\Paiement; // Assurez-vous que ce modèle existe
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscriptionController extends Controller
{
    // [Les autres méthodes de l'administration restent inchangées...]

    public function formulairePublic()
    {
        $categories = CategoriePermis::orderBy('nomCategorie')->get();
        return view('inscription-publique', compact('categories'));
    }

    public function storePublic(Request $request)
    {
        // ── Validation sans reçu de paiement ────────────────────────────────────────
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
            // Preuve ou statut du paiement direct requis depuis le front
            'statut_paiement_en_ligne' => 'required|string|in:PAYE',
            // Pièces jointes restantes
            'cnib'                  => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'photo_identite'        => 'required|file|mimes:jpeg,jpg,png|max:5120',
            'certificat_medical'    => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'acte_naissance'        => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'permis_c'              => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
        ], [
            'nom.required'                  => 'Le nom est obligatoire.',
            'prenom.required'               => 'Le prénom est obligatoire.',
            'telephone.required'            => 'Le téléphone est obligatoire.',
            'dateNaissance.required'        => 'La date de naissance est obligatoire.',
            'lieuNaissance.required'        => 'Le lieu de naissance est obligatoire.',
            'categoriePermis_id.required'   => 'Veuillez choisir une catégorie de permis.',
            'dataDebut_formation.required'  => 'La date de début de formation est obligatoire.',
            'statut_paiement_en_ligne.required' => 'Le paiement des frais d\'inscription est obligatoire.',
            'cnib.required'                 => 'La CNIB est obligatoire.',
            'photo_identite.required'       => 'La photo d\'identité est obligatoire.',
            'certificat_medical.required'   => 'Le certificat médical est obligatoire.',
            'acte_naissance.required'       => 'L\'acte de naissance est obligatoire.',
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

            $reference = 'GESP-' . date('Y') . '-' . str_pad($candidat->id, 5, '0', STR_PAD_LEFT);
            $dossierPath = 'dossiers/' . $reference;

            // 2. Enregistrement des fichiers physiques
            $cnibPath          = $request->file('cnib')->store($dossierPath, 'public');
            $photoIdentitePath = $request->file('photo_identite')->store($dossierPath, 'public');
            $certificatPath    = $request->file('certificat_medical')->store($dossierPath, 'public');
            $acteNaissancePath = $request->file('acte_naissance')->store($dossierPath, 'public');
            $permisCPath       = $request->hasFile('permis_c') 
                                    ? $request->file('permis_c')->store($dossierPath, 'public') 
                                    : null;

            // 3. Génération automatique de la ligne de Paiement suite à la validation
            // Modifiez les colonnes selon la structure réelle de votre table paiements
            $paiement = Paiement::create([
                'montant'       => 15000, // Ajustez le montant par défaut si nécessaire
                'datePaiement'  => now()->toDateString(),
                'statutPaiement'=> 'valide',
                'motif'         => 'Frais d\'inscription en ligne '.$reference,
            ]);

            $statutFormate = ($request->statutInscription && strtolower($request->statutInscription) === 'actif') ? 'actif' : 'en attente';

            // 4. Créer l'inscription avec liaison paiement_id
            Inscription::create([
                'candidat_id'         => $candidat->id,
                'paiement_id'         => $paiement->id,
                'reference'           => $reference,
                'dateInscription'     => $request->dateInscription ?? now()->toDateString(),
                'statutInscription'   => $statutFormate,
                'dataDebut_formation' => $request->dataDebut_formation,
                'cnib'                => $cnibPath,
                'photo_identite'      => $photoIdentitePath,
                'certificat_medical'  => $certificatPath,
                'acte_naissance'      => $acteNaissancePath,
                'permis_c'            => $permisCPath,
            ]);

            // 5. Créer le dossier administratif (sans colonne recu_paiement)
            Dossier::create([
                'nomDossier'         => $reference,
                'description'        => 'Dossier automatique créé après inscription et paiement en ligne',
                'dateDepot'          => now()->toDateString(),
                'statutDossier'      => 'en_attente',
                'candidat_id'        => $candidat->id,
                'cnib'               => $cnibPath,
                'photo_identite'     => $photoIdentitePath,
                'certificat_medical' => $certificatPath,
                'acte_naissance'     => $acteNaissancePath,
                'permis_c'           => $permisCPath,
            ]);

            $categorie = CategoriePermis::find($request->categoriePermis_id);
            $nomCategorie = $categorie ? ($categorie->pareCategorie ?? $categorie->nomCategorie ?? $categorie->nom) : '—';

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

        return redirect()->route('inscription.succes')->with($data);
    }

    public function succes()
    {
        if (!session('reference')) { return redirect()->route('inscription.public'); }
        return view('inscription-success');
    }
}