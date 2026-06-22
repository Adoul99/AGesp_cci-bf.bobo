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

    public function create(Request $request)
    {
        // Identifier le moniteur connecté par son email
        $user = Auth::user();
        $moniteurConnecte  = Moniteur::pourUtilisateur($user);
        $sessionDuMoniteur = null;
        $candidatsDuGroupe = collect();

        // Cas prioritaire : on arrive depuis le bouton "Clôturer" d'une session précise
        // → on charge CETTE session (peu importe qui est connecté), pour évaluer
        //   exactement les candidats qui doivent permettre de la clôturer.
        $sessionFormationId = $request->query('session_formation_id');
        if ($sessionFormationId) {
            $sessionCiblee = SessionFormation::with(['typeSession', 'moniteur'])
                ->where('id', $sessionFormationId)
                ->where('statutSession', 'ouvert')
                ->first();

            if ($sessionCiblee) {
                $sessionDuMoniteur = $sessionCiblee;
                $candidatsDuGroupe = $sessionCiblee->candidats()->orderBy('nom')->get();
                if ($sessionCiblee->moniteur) {
                    $moniteurConnecte = $sessionCiblee->moniteur;
                }
            }
        }

        // Sinon, comportement habituel : la session ouverte du moniteur connecté
        if (!$sessionDuMoniteur && $moniteurConnecte) {
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

            // La session liée est déterminée en priorité par le champ caché
            // session_formation_id (venant du bouton "Clôturer"), sinon par
            // la session ouverte du moniteur sélectionné.
            $sessionDuMoniteur = null;
            if ($request->filled('session_formation_id')) {
                $sessionDuMoniteur = SessionFormation::ouverte()
                    ->find($request->session_formation_id);
            }
            if (!$sessionDuMoniteur && $moniteurId) {
                $sessionDuMoniteur = SessionFormation::ouverte()
                    ->where('moniteur_id', $moniteurId)
                    ->latest()->first();
            }

            $resultatsPourSession = [];

            foreach ($request->evaluations as $candidatId => $data) {
                $absent  = isset($data['absent']) && $data['absent'] == '1';
                $noteRaw = isset($data['note']) ? trim($data['note']) : '';
                $obs     = trim($data['observation'] ?? '');

                // Ignorer si rien n'a été saisi (ni absence, ni note, ni observation)
                if (!$absent && $noteRaw === '' && $obs === '') continue;

                $note     = ($absent || $noteRaw === '') ? null : (float) $noteRaw;
                $resultat = $absent ? 'Absent' : (is_null($note) ? 'En attente' : ($note >= 25 ? 'Admis' : 'Ajourné'));
                $statut   = $absent ? 'absent' : (is_null($note) ? 'en_attente' : ($note >= 25 ? 'reussi' : 'echoue'));

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

                // 2. On mémorise ce résultat pour le répercuter sur la session liée
                $resultatsPourSession[$candidatId] = [
                    'absent'      => $absent,
                    'note'        => $note,
                    'observation' => $obs ?: null,
                ];

                $count++;
            }

            // Mettre à jour le statut de chaque candidat évalué (agrégation globale)
            foreach ($resultatsPourSession as $candidatId => $r) {
                $c = \App\Models\Candidat::find($candidatId);
                if ($c) $c->mettreAJourStatut();
            }

            // 3. Répercuter automatiquement sur la SessionFormation liée, et la
            //    clôturer si tous ses candidats sont désormais notés/absents.
            $messageCloture = '';
            if ($sessionDuMoniteur && !empty($resultatsPourSession)) {
                $cloturee = $sessionDuMoniteur->appliquerResultats($resultatsPourSession);
                $messageCloture = $cloturee
                    ? ' 🔒 La session de formation a été clôturée automatiquement.'
                    : ' ⏳ Il reste des candidats sans note dans la session — clôturez-la une fois complète.';
            }

            return redirect()->route('evaluations.index')
                ->with('success', "✅ $count évaluation(s) enregistrée(s) avec succès.$messageCloture");
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