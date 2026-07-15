<?php

namespace App\Http\Controllers;

use App\Models\SessionFormation;
use App\Models\Vehicule;
use App\Models\Evaluation;
use App\Models\Groupe;
use App\Models\Candidat;
use App\Models\TypeSession;
use App\Models\Moniteur;
use App\Traits\ExportableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionFormationController extends Controller
{
    use ExportableTrait;

    // ── INDEX ────────────────────────────────────────────────────

    public function index()
    {
        $sessions = SessionFormation::with(['vehicule', 'evaluation', 'groupe', 'moniteur', 'typeSession'])
                        ->latest()
                        ->get();

        $derniereSession = $sessions->first();

        // Sessions ouvertes
        $sessionsOuvertes = $sessions->where('statutSession', 'ouvert');

        // Pour compatibilité avec l'ancien code
        $sessionOuverte = $sessionsOuvertes->first();

        // Types déjà ouverts
        $typesOuverts = $sessionsOuvertes
            ->pluck('typeSession.type')
            ->filter()
            ->values()
            ->toArray();

        // Bloquer seulement si les 3 types sont tous ouverts
        $tousLesTypes    = ['code', 'creneau', 'conduite'];
        $creationBloquee = count(array_intersect($tousLesTypes, $typesOuverts)) >= count($tousLesTypes);

        return view('session_formations.index', compact(
            'sessions',
            'derniereSession',
            'sessionOuverte',
            'sessionsOuvertes',
            'typesOuverts',
            'creationBloquee'
        ));
    }

    // ── CREATE ───────────────────────────────────────────────────

    public function create()
    {
        $vehicules     = Vehicule::all();
        $evaluations   = Evaluation::with('candidat')->get();
        $groupes       = Groupe::with('candidats')->get();
        $typesSessions = TypeSession::all();
        $moniteurs     = Moniteur::all();

        // Candidats qui n'appartiennent à AUCUN groupe : à sélectionner
        // individuellement (champ de sélection multiple) pour les intégrer
        // quand même à la session, en plus des candidats du groupe choisi.
        $candidatsSansGroupe = Candidat::whereDoesntHave('groupes')
            ->orderBy('nom')
            ->get();

        // Si l'utilisateur connecté est lui-même un moniteur (email correspondant),
        // on pré-remplit automatiquement le champ Moniteur avec son propre nom.
        $moniteurConnecte = Moniteur::pourUtilisateur(Auth::user());

        return view('session_formations.create', compact(
            'vehicules', 'evaluations', 'groupes', 'typesSessions', 'moniteurs',
            'moniteurConnecte', 'candidatsSansGroupe'
        ));
    }

    // ── STORE ────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'dateDebut'                => 'required|date',
            'typeSession_id'           => 'required|exists:type_sessions,id',
            'groupe_id'                => 'required|exists:groupes,id',
            'moniteur_id'              => 'required|exists:moniteurs,id',
            'candidats_sans_groupe'    => 'nullable|array',
            'candidats_sans_groupe.*'  => 'exists:candidats,id',
        ]);

        // Le véhicule n'a de sens que pour les sessions Créneau/Conduite ;
        // pour une session Code, le champ est masqué et n'est donc pas exigé.
        $typeSession = TypeSession::find($request->typeSession_id);
        $typeNom     = $typeSession ? $typeSession->type : null;

        if ($typeNom !== 'code') {
            $request->validate([
                'vehicule_id' => 'required|exists:vehicules,id',
            ]);
        } else {
            $request->validate([
                'vehicule_id' => 'nullable|exists:vehicules,id',
            ]);
        }

        // Vérifier si une session du MÊME type est déjà ouverte
        $sessionMemeTypeOuverte = SessionFormation::ouverte()
            ->where('typeSession_id', $request->typeSession_id)
            ->latest()
            ->first();

        if ($sessionMemeTypeOuverte) {
            return redirect()->route('session_formations.index')
                ->with('error',
                    "⛔ Une session de ce type est déjà ouverte (créée le " .
                    \Carbon\Carbon::parse($sessionMemeTypeOuverte->dateDebut)->format('d/m/Y') .
                    "). Clôturez-la avant d'en créer une nouvelle du même type."
                );
        }

        // Une session est toujours créée « Ouvert » : ce statut n'est plus
        // demandé dans le formulaire (valeur par défaut en base de données).
        $session = SessionFormation::create($request->only(
            'dateDebut', 'typeSession_id',
            'groupe_id', 'vehicule_id', 'evaluation_id', 'moniteur_id'
        ));

        // Récupérer les candidats à attacher : ceux du groupe + ceux
        // sélectionnés individuellement (candidats sans groupe).
        $candidatsAAttacher = collect();

        $groupe = Groupe::with('candidats')->find($session->groupe_id);
        if ($groupe) {
            $candidatsAAttacher = $candidatsAAttacher->merge($groupe->candidats);
        }

        if ($request->filled('candidats_sans_groupe')) {
            $candidatsIndividuels = Candidat::whereIn('id', $request->candidats_sans_groupe)->get();
            $candidatsAAttacher   = $candidatsAAttacher->merge($candidatsIndividuels);
        }

        $candidatsAAttacher = $candidatsAAttacher->unique('id');

        if ($candidatsAAttacher->isNotEmpty()) {
            $pivotData = [];
            foreach ($candidatsAAttacher as $candidat) {
                $pivotData[$candidat->id] = [
                    'absent'      => false,
                    'note'        => null,
                    'observation' => null,
                ];

                $nouveauStatut = match($typeNom) {
                    'code'     => 'code_admis',
                    'creneau'  => 'creneau',
                    'conduite' => 'ajourne',
                    default    => $candidat->statut,
                };

                $candidat->update(['statut' => $nouveauStatut]);
            }
            $session->candidats()->sync($pivotData);
        }

        return redirect()->route('session_formations.index')
            ->with('success', '✅ Session créée avec succès.');
    }

    // ── EDIT ─────────────────────────────────────────────────────

    public function edit(SessionFormation $sessionFormation)
    {
        if (!$sessionFormation->est_ouverte) {
            return redirect()->route('session_formations.index')
                ->with('error', '⛔ Impossible de modifier une session clôturée ou annulée.');
        }

        $vehicules        = Vehicule::all();
        $evaluations      = Evaluation::with('candidat')->get();
        $groupes          = Groupe::all();
        $typesSessions    = TypeSession::all();
        $moniteurs        = Moniteur::all();
        $candidatsSession = $sessionFormation->candidats()->get();

        // Candidats sans groupe disponibles pour un ajout individuel
        // supplémentaire (ceux déjà attachés à cette session apparaissent
        // pré-sélectionnés).
        $candidatsSansGroupe = Candidat::whereDoesntHave('groupes')
            ->orderBy('nom')
            ->get();

        return view('session_formations.edit', compact(
            'sessionFormation', 'vehicules', 'evaluations', 'groupes',
            'typesSessions', 'moniteurs', 'candidatsSession', 'candidatsSansGroupe'
        ));
    }

    // ── UPDATE ───────────────────────────────────────────────────

    public function update(Request $request, SessionFormation $sessionFormation)
    {
        if (!$sessionFormation->est_ouverte) {
            return redirect()->route('session_formations.index')
                ->with('error', '⛔ Cette session est déjà clôturée.');
        }

        $request->validate([
            'dateDebut'               => 'required|date',
            'typeSession_id'          => 'required|exists:type_sessions,id',
            'moniteur_id'             => 'required|exists:moniteurs,id',
            'candidats_sans_groupe'   => 'nullable|array',
            'candidats_sans_groupe.*' => 'exists:candidats,id',
        ]);

        $typeSession = TypeSession::find($request->typeSession_id);
        $typeNom     = $typeSession ? $typeSession->type : null;

        if ($typeNom !== 'code') {
            $request->validate([
                'vehicule_id' => 'required|exists:vehicules,id',
            ]);
        } else {
            $request->validate([
                'vehicule_id' => 'nullable|exists:vehicules,id',
            ]);
        }

        // Vérifier si une session du MÊME nouveau type est déjà ouverte
        // en excluant la session actuelle
        $sessionMemeTypeOuverte = SessionFormation::ouverte()
            ->where('typeSession_id', $request->typeSession_id)
            ->where('id', '!=', $sessionFormation->id)
            ->latest()
            ->first();

        if ($sessionMemeTypeOuverte) {
            return redirect()->route('session_formations.index')
                ->with('error',
                    "⛔ Une session de ce type est déjà ouverte (créée le " .
                    \Carbon\Carbon::parse($sessionMemeTypeOuverte->dateDebut)->format('d/m/Y') .
                    "). Clôturez-la avant de changer le type."
                );
        }

        $sessionFormation->update($request->only(
            'dateDebut', 'typeSession_id', 'vehicule_id', 'evaluation_id', 'moniteur_id'
        ));

        // Ajouter les candidats sans groupe sélectionnés, SANS toucher aux
        // candidats déjà attachés (on ne veut pas effacer leurs notes/absences).
        if ($request->filled('candidats_sans_groupe')) {
            $idsDejaAttaches = $sessionFormation->candidats()->pluck('candidats.id')->all();
            $nouveauxIds     = array_diff($request->candidats_sans_groupe, $idsDejaAttaches);

            if (!empty($nouveauxIds)) {
                $nouveauxCandidats = Candidat::whereIn('id', $nouveauxIds)->get();
                foreach ($nouveauxCandidats as $candidat) {
                    $sessionFormation->candidats()->attach($candidat->id, [
                        'absent'      => false,
                        'note'        => null,
                        'observation' => null,
                    ]);

                    $nouveauStatut = match($typeNom) {
                        'code'     => 'code_admis',
                        'creneau'  => 'creneau',
                        'conduite' => 'ajourne',
                        default    => $candidat->statut,
                    };
                    $candidat->update(['statut' => $nouveauStatut]);
                }
            }
        }

        // Mettre à jour le statut des candidats selon le nouveau type
        if ($typeNom) {
            $sessionFormation->load('candidats');
            foreach ($sessionFormation->candidats as $candidat) {
                $nouveauStatut = match($typeNom) {
                    'code'     => 'code_admis',
                    'creneau'  => 'creneau',
                    'conduite' => 'ajourne',
                    default    => $candidat->statut,
                };
                $candidat->update(['statut' => $nouveauStatut]);
            }
        }

        // Mettre à jour les notes/absences si saisies
        if ($request->has('candidats')) {
            foreach ($request->candidats as $candidatId => $data) {
                $sessionFormation->candidats()->updateExistingPivot($candidatId, [
                    'absent'      => isset($data['absent']) ? 1 : 0,
                    'note'        => isset($data['absent']) ? null : ($data['note'] ?? null),
                    'observation' => $data['observation'] ?? null,
                ]);
            }
        }

        return redirect()->route('session_formations.index')
            ->with('success', '✅ Session mise à jour.');
    }

    // ── CLÔTURE ──────────────────────────────────────────────────

    /**
     * Le clic sur "Clôturer" envoie désormais vers le module Évaluation :
     * le moniteur y saisit les notes des candidats de CETTE session, et la
     * session se clôture automatiquement une fois tous les candidats notés
     * (ou marqués absents). Voir EvaluationController::create()/store().
     */
    public function cloture(SessionFormation $sessionFormation)
    {
        if (!$sessionFormation->est_ouverte) {
            return redirect()->route('session_formations.index')
                ->with('error', '⛔ Cette session est déjà clôturée.');
        }

        if ($sessionFormation->candidats()->count() === 0) {
            return redirect()->route('session_formations.edit', $sessionFormation->id)
                ->with('error', "⛔ Impossible de clôturer : aucun candidat n'est attaché à cette session.");
        }

        return redirect()->route('evaluations.create', [
            'session_formation_id' => $sessionFormation->id,
        ]);
    }

    public function cloturer(Request $request, SessionFormation $sessionFormation)
    {
        if (!$sessionFormation->est_ouverte) {
            return redirect()->route('session_formations.index')
                ->with('error', '⛔ Cette session est déjà clôturée.');
        }

        $resultats = [];

        if ($request->has('candidats')) {
            foreach ($request->candidats as $candidatId => $data) {
                $absent = isset($data['absent']) && $data['absent'] == '1';
                $note   = $absent ? null : ($data['note'] ?? null);

                if (!$absent && ($note === null || $note === '' || $note < 0 || $note > 30)) {
                    return back()->withInput()
                        ->with('error', '⚠️ Chaque candidat présent doit avoir une note valide (0–30).');
                }

                $resultats[$candidatId] = [
                    'absent'      => $absent,
                    'note'        => $absent ? null : (float) $note,
                    'observation' => $data['observation'] ?? null,
                ];
            }
        }

        $cloturee = $sessionFormation->appliquerResultats($resultats);

        if (!$cloturee) {
            $sessionFormation->load('candidats');
            $manquants = $sessionFormation->candidatsSansNote();
            $noms = $manquants->map(fn($c) => $c->nom . ' ' . $c->prenom)->implode(', ');
            return back()->withInput()
                ->with('error', "⚠️ Impossible de clôturer : note manquante pour → $noms");
        }

        return redirect()->route('session_formations.index')
            ->with('success', '✅ Session clôturée avec succès.');
    }

    // ── DESTROY ──────────────────────────────────────────────────

    public function destroy(SessionFormation $sessionFormation)
    {
        $sessionFormation->candidats()->detach();
        $sessionFormation->delete();

        return redirect()->route('session_formations.index')
            ->with('success', '✅ Session supprimée.');
    }
}
