<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EspaceCandidatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Récupère le candidat lié à cet utilisateur
        $candidat = \App\Models\Candidat::where('email', $user->email)
            ->orWhere('telephone', $user->telephone)
            ->first();

        // Récupère la dernière inscription (sans eager loading des relations)
        $inscription = null;
        $examens     = collect();
        $paiements   = collect();
        $attestations= collect();
        $dossier     = null;

        if ($candidat) {
            $inscription = $candidat->inscriptions()->latest()->first();
            
            // Charge la relation categoriePermis si elle existe
            if ($inscription) {
                try {
                    $inscription->load('categoriePermis');
                } catch (\Exception $e) {
                    // La relation n'existe pas — on continue sans
                }

                try {
                    $dossier = $inscription->dossiers()->latest()->first();
                } catch (\Exception $e) {
                    // Pas de relation dossiers
                }
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
            'dossier'
        ));
    }
}
