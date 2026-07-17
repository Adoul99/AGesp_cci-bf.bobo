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

    // ── Helpers privés ───────────────────────────────────────────

    /**
     * Libellé lisible du type de session (Code / Créneau / Conduite).
     */
    private function libelleType(?string $type): string
    {
        return match ($type) {
            'code'     => 'Code',
            'creneau'  => 'Créneau',
            'conduite' => 'Conduite',
            default    => $type ?? '',
        };
    }

    /**
     * Calcule resultat + statut pour UNE évaluation, selon le type de session.
     *
     * @return array{0:?string,1:?float,2:?string,3:string,4:string} [note, mention, resultat, statut]
     */
    private function calculerResultat(bool $absent, ?string $type, ?float $note, ?string $mention): array
    {
        $libelle = $this->libelleType($type);

        if ($absent) {
            return [$note, $mention, 'Absent', 'absent'];
        }

        // Session Code : logique par note chiffrée /30 (seuil 25)
        if ($type === 'code') {
            $mention = null; // pas de mention pour le Code
            if (is_null($note)) {
                return [$note, $mention, 'En attente', 'en_attente'];
            }
            $valide = $note >= 25;
            $resultat = $valide ? "Validé la session de {$libelle}" : "Échoué la session de {$libelle}";
            return [$note, $mention, $resultat, $valide ? 'reussi' : 'echoue'];
        }

        // Session Créneau / Conduite : logique par mention
        if (in_array($type, ['creneau', 'conduite'])) {
            $note = null; // pas de note chiffrée pour Créneau/Conduite
            if (empty($mention)) {
                return [$note, $mention, 'En attente', 'en_attente'];
            }
            // Bien et Passable = validé, Médiocre = échoué
            $valide = in_array($mention, ['bien', 'passable']);
            $resultat = $valide ? "Validé la session de {$libelle}" : "Échoué la session de {$libelle}";
            return [$note, $mention, $resultat, $valide ? 'reussi' : 'echoue'];
        }

        // Type inconnu / non défini
        return [$note, $mention, 'En attente', 'en_attente'];
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
                'dateEvaluation'         => 'required|date',
                'typeSession_id'         => 'nullable|exists:type_sessions,id',
                'moniteur_id'            => 'nullable|exists:moniteurs,id',
                'evaluations'            => 'required|array',
                'evaluations.*.note'     => 'nullable|numeric|min:0|max:30',
                'evaluations.*.mention'  => 'nullable|in:bien,passable,mediocre',
            ]);

            $typeSession = $typeSessionId ? TypeSession::find($typeSessionId) : null;
            $type        = $typeSession?->type;

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
                $absent     = isset($data['absent']) && $data['absent'] == '1';
                $noteRaw    = isset($data['note']) ? trim($data['note']) : '';
                $mentionRaw = isset($data['mention']) ? trim($data['mention']) : '';
                $obs        = trim($data['observation'] ?? '');

                // Ignorer si rien n'a été saisi (ni absence, ni note, ni mention, ni observation)
                if (!$absent && $noteRaw === '' && $mentionRaw === '' && $obs === '') continue;

                $note    = ($noteRaw !== '') ? (float) $noteRaw : null;
                $mention = ($mentionRaw !== '') ? $mentionRaw : null;

                [$note, $mention, $resultat, $statut] = $this->calculerResultat($absent, $type, $note, $mention);

                // 1. Enregistrer dans la table evaluations
                Evaluation::updateOrCreate(
                    [
                        'candidat_id'    => $candidatId,
                        'dateEvaluation' => $dateEvaluation,
                    ],
                    [
                        'typeSession_id' => $typeSessionId ?: null,
                        'note'           => $note,
                        'mention'        => $mention,
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
                    'mention'     => $mention,
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
            'typeSession_id' => 'nullable|exists:type_sessions,id',
            'dateEvaluation' => 'required|date',
            'note'           => 'nullable|numeric|min:0|max:30',
            'mention'        => 'nullable|in:bien,passable,mediocre',
            'statut'         => 'required|in:en_attente,reussi,echoue',
            'moniteur_id'    => 'nullable|exists:moniteurs,id',
        ]);

        $typeSession = $request->typeSession_id ? TypeSession::find($request->typeSession_id) : null;
        $type        = $typeSession?->type;

        [$note, $mention, $resultat] = $this->calculerResultat(
            false, $type, $request->note, $request->mention
        );

        $evaluation = Evaluation::create([
            'candidat_id'    => $request->candidat_id,
            'typeSession_id' => $request->typeSession_id,
            'dateEvaluation' => $request->dateEvaluation,
            'note'           => $note,
            'mention'        => $mention,
            'resultat'       => $resultat,
            'statut'         => $request->statut,
            'moniteur_id'    => $request->moniteur_id,
            'observation'    => $request->observation,
        ]);

        // Recalcule le statut du candidat pour refléter cette nouvelle évaluation
        // (cas manquant jusqu'ici : seul le formulaire groupé le faisait).
        $evaluation->candidat?->mettreAJourStatut();

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
            'typeSession_id' => 'nullable|exists:type_sessions,id',
            'dateEvaluation' => 'required|date',
            'note'           => 'nullable|numeric|min:0|max:30',
            'mention'        => 'nullable|in:bien,passable,mediocre',
            'statut'         => 'required|in:en_attente,reussi,echoue',
            'moniteur_id'    => 'nullable|exists:moniteurs,id',
        ]);

        // On mémorise l'ancien candidat AVANT modification, au cas où
        // candidat_id changerait dans ce formulaire (rare, mais possible) :
        // il faut recalculer le statut de L'ANCIEN candidat aussi, sinon un
        // statut obsolète (ex: "code_admis") pourrait lui rester attribué
        // à tort après que son évaluation lui a été retirée.
        $ancienCandidatId = $evaluation->candidat_id;

        $typeSession = $request->typeSession_id ? TypeSession::find($request->typeSession_id) : null;
        $type        = $typeSession?->type;

        [$note, $mention, $resultat] = $this->calculerResultat(
            false, $type, $request->note, $request->mention
        );

        $evaluation->update([
            'candidat_id'    => $request->candidat_id,
            'typeSession_id' => $request->typeSession_id,
            'dateEvaluation' => $request->dateEvaluation,
            'note'           => $note,
            'mention'        => $mention,
            'resultat'       => $resultat,
            'statut'         => $request->statut,
            'moniteur_id'    => $request->moniteur_id,
            'observation'    => $request->observation,
        ]);

        // Recalcule le statut du candidat actuel (résultat modifié : ex.
        // reussi -> echoue) — sans cet appel, un ancien statut "code_admis"
        // pouvait rester figé en base même après correction de l'évaluation.
        $evaluation->candidat?->mettreAJourStatut();

        // Si le candidat a changé dans ce formulaire, recalcule aussi
        // l'ancien candidat qui vient de perdre cette évaluation.
        if ($ancienCandidatId && $ancienCandidatId != $request->candidat_id) {
            Candidat::find($ancienCandidatId)?->mettreAJourStatut();
        }

        return redirect()->route('evaluations.index')
            ->with('success', 'Évaluation mise à jour.');
    }

    // ── DESTROY ──────────────────────────────────────────────────

    public function destroy(Evaluation $evaluation)
    {
        // On récupère le candidat AVANT suppression, sinon la référence est perdue.
        $candidat = $evaluation->candidat;

        $evaluation->delete();

        // Sans cet appel, le statut du candidat (ex: "code_admis") reste figé
        // en base même si la preuve qui le justifiait (cette évaluation) vient
        // de disparaître — c'est exactement le bug observé en production.
        $candidat?->mettreAJourStatut();

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