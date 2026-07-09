<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Candidat;
use App\Models\CategoriePermis;
use App\Models\Dossier;
use App\Models\Paiement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InscriptionController extends Controller
{
    // ── Liste ───────────────────────────────────────────────
    public function index()
    {
        $inscriptions = Inscription::with('candidat', 'paiement', 'categoriePermis')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('inscriptions.index', compact('inscriptions'));
    }

    // ── Formulaire de création (guichet CCI-BF) ────────────
    public function create()
    {
        $categories = CategoriePermis::orderBy('nomCategorie')->get();
        return view('inscriptions.create', compact('categories'));
    }

    // ── Enregistrement : crée candidat + dossier + paiement + inscription ──
    public function store(Request $request)
    {
        $dateLimitePermisC  = Carbon::now()->subMonths(6)->format('Y-m-d');
        $dateLimiteMajorite = Carbon::now()->subYears(21)->format('Y-m-d');

        $request->validate([
            // Identité du candidat
            'nom'                    => 'required|string|max:100',
            'prenom'                 => 'required|string|max:100',
            'telephone'              => 'required|string|max:20',
            'email'                  => 'nullable|email|max:100',
            // ✅ Âge minimum requis : 21 ans à la date d'inscription, et année de naissance plausible
            'dateNaissance'          => "required|date|after:1920-01-01|before_or_equal:{$dateLimiteMajorite}",
            'lieuNaissance'          => 'required|string|max:100',

            // Permis C — obligatoire, avec règle des 6 mois minimum
            'numeroPermisC'          => 'required|string|max:50',
            'dateDelivrancePermisC'  => "required|date|after:1970-01-01|before_or_equal:{$dateLimitePermisC}",
            'lieuDelivrancePermisC'  => 'required|string|max:100',

            // Formation
            'categoriePermis_id'     => 'required|exists:categorie_permis,id',
            'dateInscription'        => 'required|date',

            // Pièces jointes
            'cnib'                   => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'photo_identite'         => 'required|file|mimes:jpeg,jpg,png|max:5120',
            'certificat_medical'     => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'acte_naissance'         => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'permis_c'               => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',

            // Paiement — encaissé en espèces au moment de l'inscription
            'montantPaiement'        => 'required|numeric|min:1',
        ], [
            'dateNaissance.before_or_equal' =>
                "Le candidat doit avoir au moins 21 ans (né avant le " .
                Carbon::parse($dateLimiteMajorite)->format('d/m/Y') . ").",
            'dateDelivrancePermisC.before_or_equal' =>
                "Le permis C doit avoir au moins 6 mois d'ancienneté (délivré avant le " .
                Carbon::parse($dateLimitePermisC)->format('d/m/Y') . ").",
            'nom.required'                    => 'Le nom est obligatoire.',
            'prenom.required'                 => 'Le prénom est obligatoire.',
            'telephone.required'              => 'Le téléphone est obligatoire.',
            'numeroPermisC.required'          => 'Le numéro du permis C est obligatoire.',
            'dateDelivrancePermisC.required'  => 'La date de délivrance du permis C est obligatoire.',
            'categoriePermis_id.required'     => 'Veuillez choisir une catégorie de permis.',
            'montantPaiement.required'        => 'Le montant encaissé est obligatoire.',
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
                'statut'                => 'inscrit',
            ]);

            // 2. Référence unique du dossier
            $reference = 'GESP-' . date('Y') . '-' . str_pad($candidat->id, 5, '0', STR_PAD_LEFT);
            $dossierPath = 'dossiers/' . $reference;

            // 3. Upload des pièces jointes
            $cnibPath          = $request->file('cnib')->store($dossierPath, 'public');
            $photoIdentitePath = $request->file('photo_identite')->store($dossierPath, 'public');
            $certificatPath    = $request->file('certificat_medical')->store($dossierPath, 'public');
            $acteNaissancePath = $request->file('acte_naissance')->store($dossierPath, 'public');
            $permisCPath       = $request->hasFile('permis_c')
                                    ? $request->file('permis_c')->store($dossierPath, 'public')
                                    : null;

            // 4. Créer le paiement — encaissement immédiat en espèces au guichet
            $paiement = Paiement::create([
                'montant'      => $request->montantPaiement,
                'datePaiement' => now()->toDateString(),
                'statut'       => 'paye',
                'candidat_id'  => $candidat->id,
            ]);

            // 5. Créer l'inscription — validée directement (saisie par un agent CCI-BF)
            //    La date de début de formation n'est plus saisie séparément :
            //    elle est alignée sur la date d'inscription par défaut.
            Inscription::create([
                'candidat_id'         => $candidat->id,
                'categoriePermis_id'  => $request->categoriePermis_id,
                'reference'           => $reference,
                'dateInscription'     => $request->dateInscription,
                'statutInscription'   => 'actif',
                'dataDebut_formation' => $request->dateInscription,
                'paiement_id'         => $paiement->id,
                'cnib'                => $cnibPath,
                'photo_identite'      => $photoIdentitePath,
                'certificat_medical'  => $certificatPath,
                'acte_naissance'      => $acteNaissancePath,
                'permis_c'            => $permisCPath,
            ]);

            // 6. Créer le dossier lié — validé directement (vérifié sur place par l'agent)
            Dossier::create([
                'nomDossier'         => $reference,
                'description'        => 'Dossier créé lors de l\'inscription au guichet CCI-BF',
                'dateDepot'          => now()->toDateString(),
                'statutDossier'      => 'valide',
                'candidat_id'        => $candidat->id,
                'cnib'               => $cnibPath,
                'photo_identite'     => $photoIdentitePath,
                'certificat_medical' => $certificatPath,
                'acte_naissance'     => $acteNaissancePath,
                'permis_c'           => $permisCPath,
            ]);

            return $reference;
        });

        return redirect()->route('inscriptions.index')
            ->with('success', "✅ Inscription enregistrée avec succès. Référence : {$data}");
    }

    // ── Modifier ────────────────────────────────────────────
    public function edit(Inscription $inscription)
    {
        $candidats  = Candidat::all();
        $categories = CategoriePermis::orderBy('nomCategorie')->get();
        return view('inscriptions.edit', compact('inscription', 'candidats', 'categories'));
    }

    // ── Mettre à jour ───────────────────────────────────────
    public function update(Request $request, Inscription $inscription)
    {
        $inscription->update($request->all());
        return redirect()->route('inscriptions.index')->with('success', 'Inscription mise à jour.');
    }

    // ── Supprimer ───────────────────────────────────────────
    public function destroy(Inscription $inscription)
    {
        $inscription->delete();
        return redirect()->route('inscriptions.index')->with('success', 'Inscription supprimée.');
    }
}