<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Moniteur;
use App\Models\Candidat;
use App\Models\TypeSession;
use App\Models\SessionFormation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    // ── INDEX ────────────────────────────────────────────────────

    public function index()
    {
        $evaluations = Evaluation::with(['candidat', 'moniteur', 'typeSession'])->latest()->get();
        return view('evaluations.index', compact('evaluations'));
    }

    // ── CREATE ───────────────────────────────────────────────────

    public function create()
    {
        // Identifier le moniteur connecté par son email
        $user = Auth::user();
        $moniteurConnecte  = Moniteur::pourUtilisateur($user);
        $sessionDuMoniteur = null;
        $candidatsDuGroupe = collect();

        if ($moniteurConnecte) {
            $sessionDuMoniteur = $moniteurConnecte->sessionOuverte();
            if ($sessionDuMoniteur) {
                $candidatsDuGroupe = $sessionDuMoniteur->candidats()->orderBy('nom')->get();
            }
        }

        // Fallback : chercher par nom si email ne correspond pas
        if (!$moniteurConnecte) {
            $moniteurConnecte = Moniteur::where('nom', 'LIKE', '%' . ($user->name ?? '') . '%')
                ->orWhere('prenom', 'LIKE', '%' . ($user->prenom ?? '') . '%')
                ->first();
        }

        // Tous les candidats si pas de session filtrée
        $candidats    = $candidatsDuGroupe->isNotEmpty() ? $candidatsDuGroupe : Candidat::orderBy('nom')->get();
        $typeSessions = TypeSession::orderBy('type')->get();
        $moniteurs    = Moniteur::all();

        return view('evaluations.create', compact(
            'moniteurs', 'candidats', 'typeSessions',
            'moniteurConnecte', 'sessionDuMoniteur', 'candidatsDuGroupe', 'user'
        ));
    }

    // ── STORE (tableau de candidats) ─────────────────────────────

    public function store(Request $request)
    {
        // Cas 1 : soumission du tableau groupé (plusieurs candidats)
        if ($request->has('evaluations')) {
            $moniteurId      = $request->moniteur_id;
            $dateEvaluation  = $request->dateEvaluation;
            $typeSessionId   = $request->typeSession_id;

            $request->validate([
                'dateEvaluation'     => 'required|date',
                'typeSession_id'     => 'nullable|exists:type_sessions,id',
                'moniteur_id'        => 'nullable|exists:moniteurs,id',
                'evaluations'        => 'required|array',
                'evaluations.*.note' => 'nullable|numeric|min:0|max:30',
            ]);

            $count = 0;

            // Chercher la session ouverte du moniteur pour synchroniser les notes
            $sessionDuMoniteur = null;
            if ($moniteurId) {
                $sessionDuMoniteur = SessionFormation::ouverte()
                    ->where('moniteur_id', $moniteurId)
                    ->latest()->first();
            }

            foreach ($request->evaluations as $candidatId => $data) {
                $noteRaw = isset($data['note']) ? trim($data['note']) : '';
                $obs     = trim($data['observation'] ?? '');

                // Ignorer si note vide ET pas d'observation
                if ($noteRaw === '' && $obs === '') continue;

                $note     = $noteRaw !== '' ? (float) $noteRaw : null;
                $resultat = is_null($note) ? 'En attente' : ($note >= 25 ? 'Admis' : 'Ajourné');
                $statut   = is_null($note) ? 'en_attente' : ($note >= 25 ? 'reussi' : 'echoue');

                // 1. Enregistrer dans la table evaluations
                Evaluation::updateOrCreate(
                    [
                        'candidat_id'    => $candidatId,
                        'dateEvaluation' => $dateEvaluation,
                    ],
                    [
                        'typeSession_id' => $typeSessionId ?: null,
                        'note'           => $note,
                        'resultat'       => $resultat,
                        'statut'         => $statut,
                        'moniteur_id'    => $moniteurId ?: null,
                        'observation'    => $obs ?: null,
                    ]
                );

                // 2. Synchroniser dans le pivot session_candidat si session ouverte trouvée
                if ($sessionDuMoniteur) {
                    // Vérifier que ce candidat est bien dans la session
                    $estDansSession = $sessionDuMoniteur->candidats()
                        ->wherePivot('candidat_id', $candidatId)
                        ->exists();

                    if ($estDansSession) {
                        $sessionDuMoniteur->candidats()->updateExistingPivot($candidatId, [
                            'note'        => $note,
                            'observation' => $obs ?: null,
                        ]);
                    }
                }

                $count++;
            }

            return redirect()->route('evaluations.index')
                ->with('success', "✅ $count évaluation(s) enregistrée(s) avec succès.");
        }

        // Cas 2 : formulaire individuel (fallback)
        $request->validate([
            'candidat_id'    => 'required|exists:candidats,id',
            'dateEvaluation' => 'required|date',
            'note'           => 'nullable|numeric|min:0|max:30',
            'statut'         => 'required|in:en_attente,reussi,echoue',
            'moniteur_id'    => 'nullable|exists:moniteurs,id',
        ]);

        $note     = $request->note;
        $resultat = is_null($note) ? 'En attente' : ($note >= 25 ? 'Admis' : 'Ajourné');

        Evaluation::create([
            'candidat_id'    => $request->candidat_id,
            'dateEvaluation' => $request->dateEvaluation,
            'note'           => $note,
            'resultat'       => $resultat,
            'statut'         => $request->statut,
            'moniteur_id'    => $request->moniteur_id,
            'observation'    => $request->observation,
        ]);

        return redirect()->route('evaluations.index')
            ->with('success', 'Évaluation enregistrée avec succès.');
    }

    // ── EDIT ─────────────────────────────────────────────────────

    public function edit(Evaluation $evaluation)
    {
        $moniteurs    = Moniteur::all();
        $candidats    = Candidat::orderBy('nom')->get();
        $typeSessions = TypeSession::orderBy('type')->get();
        return view('evaluations.edit', compact('evaluation', 'moniteurs', 'candidats', 'typeSessions'));
    }

    // ── UPDATE ───────────────────────────────────────────────────

    public function update(Request $request, Evaluation $evaluation)
    {
        $request->validate([
            'candidat_id'    => 'required|exists:candidats,id',
            'dateEvaluation' => 'required|date',
            'note'           => 'nullable|numeric|min:0|max:30',
            'statut'         => 'required|in:en_attente,reussi,echoue',
            'moniteur_id'    => 'nullable|exists:moniteurs,id',
        ]);

        $note     = $request->note;
        $resultat = is_null($note) ? 'En attente' : ($note >= 25 ? 'Admis' : 'Ajourné');

        $evaluation->update([
            'candidat_id'    => $request->candidat_id,
            'dateEvaluation' => $request->dateEvaluation,
            'note'           => $note,
            'resultat'       => $resultat,
            'statut'         => $request->statut,
            'moniteur_id'    => $request->moniteur_id,
            'observation'    => $request->observation,
        ]);

        return redirect()->route('evaluations.index')
            ->with('success', 'Évaluation mise à jour.');
    }

    // ── DESTROY ──────────────────────────────────────────────────

    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        return redirect()->route('evaluations.index')
            ->with('success', 'Évaluation supprimée.');
    }

    // ── REPORT ───────────────────────────────────────────────────

    public function report()
    {
        $evaluations = Evaluation::with(['candidat', 'moniteur'])
            ->orderBy('dateEvaluation', 'desc')->get();
        return view('evaluations.report', compact('evaluations'));
    }
}
