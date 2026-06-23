<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EspaceCandidatController extends Controller
{
    /**
     * Espace personnel — accès par le candidat lui-même
     */
    public function index()
    {
        $user = Auth::user();

        // Récupère le candidat lié à cet utilisateur
        $candidat = Candidat::where('email', $user->email)
            ->orWhere('telephone', $user->telephone)
            ->first();

        return $this->construireVue($candidat, $user, false);
    }

    /**
     * Espace personnel — consultation par un administrateur, en lecture
     * (depuis le bouton "Voir son espace" du module Candidats)
     */
    public function voirCommeAdmin(Candidat $candidat)
    {
        // Cherche le compte utilisateur réellement lié à ce candidat (s'il existe)
        $user = \App\Models\User::where('email', $candidat->email)
            ->orWhere('telephone', $candidat->telephone)
            ->first();

        // Si le candidat n'a pas encore de compte utilisateur, on construit un
        // objet minimal à partir de ses propres données pour que la page reste affichable.
        if (!$user) {
            $user = (object) [
                'name'       => trim($candidat->nom . ' ' . $candidat->prenom),
                'email'      => $candidat->email,
                'telephone'  => $candidat->telephone,
                'role'       => 'candidat',
                'created_at' => $candidat->created_at,
            ];
        }

        return $this->construireVue($candidat, $user, true);
    }

    /**
     * Construit les données et retourne la vue de l'espace candidat,
     * que ce soit pour le candidat lui-même ou pour un admin en consultation.
     */
    private function construireVue(?Candidat $candidat, $user, bool $modePreviewAdmin)
    {
        $inscription  = null;
        $examens      = collect();
        $paiements    = collect();
        $attestations = collect();
        $dossier      = null;

        if ($candidat) {
            $inscription = $candidat->inscriptions()->latest()->first();

            // Charge la relation categoriePermis si elle existe
            if ($inscription) {
                try {
                    $inscription->load('categoriePermis');
                } catch (\Exception $e) {
                    // La relation n'existe pas — on continue sans
                }
            }

            // Le dossier (pièces jointes) est lié au CANDIDAT, pas à l'inscription
            try {
                $dossier = $candidat->dossiers()->latest()->first();
            } catch (\Exception $e) {
                $dossier = null;
            }

            // Examens
            try {
                $examens = $candidat->examens()->latest()->get();
            } catch (\Exception $e) {
                $examens = collect();
            }

            // Paiements
            try {
                $paiements = $candidat->paiements()->latest()->get();
            } catch (\Exception $e) {
                $paiements = collect();
            }

            // Attestations
            try {
                $attestations = $candidat->attestations()->get();
            } catch (\Exception $e) {
                $attestations = collect();
            }
        }

        return view('candidats.espace', compact(
            'user',
            'candidat',
            'inscription',
            'examens',
            'paiements',
            'attestations',
            'dossier',
            'modePreviewAdmin'
        ));
    }
}