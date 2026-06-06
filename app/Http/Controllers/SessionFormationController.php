<?php

namespace App\Http\Controllers;

use App\Models\SessionFormation;
use App\Models\Vehicule;
use App\Models\Evaluation;
use App\Models\Groupe;
use App\Models\TypeSession;
use App\Models\Moniteur;
use App\Traits\ExportableTrait;
use Illuminate\Http\Request;

class SessionFormationController extends Controller
{
    use ExportableTrait;

    // ── INDEX ────────────────────────────────────────────────────

    public function index()
    {
        $sessions = SessionFormation::with(['vehicule', 'evaluation', 'groupe', 'moniteur', 'typeSession'])
                        ->latest()
                        ->get();

        // Dernière session créée (toutes confondues)
        $derniereSession = $sessions->first();

        // Session actuellement ouverte (s'il en existe une)
        $sessionOuverte = $sessions->where('statutSession', 'ouvert')->first();

        return view('session_formations.index', compact('sessions', 'derniereSession', 'sessionOuverte'));
    }

    // ── CREATE ───────────────────────────────────────────────────

    public function create()
    {
        // Vérifier s'il existe déjà une session ouverte (tous moniteurs confondus)
        $sessionOuverte = SessionFormation::ouverte()->with(['moniteur', 'groupe'])->latest()->first();

        if ($sessionOuverte) {
            return redirect()->route('session_formations.index')
                ->with('error',
                    "⛔ Une session est déjà en cours (créée le " .
                    \Carbon\Carbon::parse($sessionOuverte->dateDebut)->format('d/m/Y') .
                    "). Vous devez la clôturer avant d'en créer une nouvelle."
                );
        }

        $vehicules    = Vehicule::all();
        $evaluations  = Evaluation::with('candidat')->get();
        $groupes      = Groupe::with('candidats')->get();
        $typesSessions = TypeSession::all();
        $moniteurs    = Moniteur::all();

        return view('session_formations.create', compact(
            'vehicules', 'evaluations', 'groupes', 'typesSessions', 'moniteurs'
        ));
    }

    // ── STORE ────────────────────────────────────────────────────

    public function store(Request $request)
    {
        // Double vérification : session ouverte ?
        $sessionOuverte = SessionFormation::ouverte()->latest()->first();
        if ($sessionOuverte) {
            return redirect()->route('session_formations.index')
                ->with('error', "⛔ Une session est déjà ouverte. Clôturez-la d'abord.");
        }

        $request->validate([
            'dateDebut'      => 'required|date',
            'statutSession'  => 'required|in:ouvert,ferme,annule',
            'typeSession_id' => 'required|exists:type_sessions,id',
            'groupe_id'      => 'nullable|exists:groupes,id',
            'vehicule_id'    => 'nullable|exists:vehicules,id',
            'moniteur_id'    => 'nullable|exists:moniteurs,id',
        ]);

        $session = SessionFormation::create($request->only(
            'dateDebut', 'statutSession', 'typeSession_id',
            'groupe_id', 'vehicule_id', 'evaluation_id', 'moniteur_id'
        ));

        // Attacher automatiquement les candidats du groupe au pivot
        if ($session->groupe_id) {
            $groupe = Groupe::with('candidats')->find($session->groupe_id);
            if ($groupe) {
                $pivotData = [];
                foreach ($groupe->candidats as $candidat) {
                    $pivotData[$candidat->id] = ['absent' => false, 'note' => null, 'observation' => null];
                }
                $session->candidats()->sync($pivotData);
            }
        }

        return redirect()->route('session_formations.index')
            ->with('success', '✅ Session créée avec succès.');
    }

    // ── EDIT ─────────────────────────────────────────────────────

    public function edit(SessionFormation $sessionFormation)
    {
        // Si la session est fermée ou annulée, on ne peut plus la modifier
        if (!$sessionFormation->est_ouverte) {
            return redirect()->route('session_formations.index')
                ->with('error', '⛔ Impossible de modifier une session clôturée ou annulée.');
        }

        $vehicules     = Vehicule::all();
        $evaluations   = Evaluation::with('candidat')->get();
        $groupes       = Groupe::all();
        $typesSessions = TypeSession::all();
        $moniteurs     = Moniteur::all();

        // Candidats de la session avec leurs données pivot
        $candidatsSession = $sessionFormation->candidats()->get();

        return view('session_formations.edit', compact(
            'sessionFormation', 'vehicules', 'evaluations', 'groupes',
            'typesSessions', 'moniteurs', 'candidatsSession'
        ));
    }

    // ── UPDATE ───────────────────────────────────────────────────

    public function update(Request $request, SessionFormation $sessionFormation)
    {
        // Empêcher toute modification d'une session fermée
        if (!$sessionFormation->est_ouverte) {
            return redirect()->route('session_formations.index')
                ->with('error', '⛔ Cette session est déjà clôturée.');
        }

        $request->validate([
            'dateDebut'      => 'required|date',
            'typeSession_id' => 'required|exists:type_sessions,id',
            'groupe_id'      => 'nullable|exists:groupes,id',
            'vehicule_id'    => 'nullable|exists:vehicules,id',
            'moniteur_id'    => 'nullable|exists:moniteurs,id',
        ]);

        $sessionFormation->update($request->only(
            'dateDebut', 'typeSession_id', 'groupe_id', 'vehicule_id', 'evaluation_id', 'moniteur_id'
        ));

        // Mettre à jour les absences et notes des candidats (saisies dans le formulaire)
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

    // ── CLÔTURE ─────────────────────────────────────────────────

    /**
     * Affiche la page de clôture (saisie des absences + notes obligatoire)
     */
    public function cloture(SessionFormation $sessionFormation)
    {
        if (!$sessionFormation->est_ouverte) {
            return redirect()->route('session_formations.index')
                ->with('error', '⛔ Cette session est déjà clôturée.');
        }

        $candidatsSession = $sessionFormation->candidats()->get();

        return view('session_formations.cloture', compact('sessionFormation', 'candidatsSession'));
    }

    /**
     * Traite la clôture : vérifie que tous les candidats ont une note ou sont absents
     */
    public function cloturer(Request $request, SessionFormation $sessionFormation)
    {
        if (!$sessionFormation->est_ouverte) {
            return redirect()->route('session_formations.index')
                ->with('error', '⛔ Cette session est déjà clôturée.');
        }

        $candidatsSession = $sessionFormation->candidats;

        // Mise à jour des absences et notes depuis le formulaire
        if ($request->has('candidats')) {
            foreach ($request->candidats as $candidatId => $data) {
                $absent = isset($data['absent']) && $data['absent'] == '1';
                $note   = $absent ? null : ($data['note'] ?? null);

                // Valider la note si le candidat est présent
                if (!$absent && (is_null($note) || $note < 0 || $note > 30)) {
                    return back()->withInput()
                        ->with('error', '⚠️ Chaque candidat présent doit avoir une note valide (0–30).');
                }

                $sessionFormation->candidats()->updateExistingPivot($candidatId, [
                    'absent'      => $absent ? 1 : 0,
                    'note'        => $note,
                    'observation' => $data['observation'] ?? null,
                ]);
            }
        }

        // Recharger pour vérifier
        $sessionFormation->load('candidats');
        if (!$sessionFormation->peutEtreCloturee()) {
            $manquants = $sessionFormation->candidatsSansNote();
            $noms = $manquants->map(fn($c) => $c->nom . ' ' . $c->prenom)->implode(', ');
            return back()->withInput()
                ->with('error', "⚠️ Impossible de clôturer : note manquante pour → $noms");
        }

        // Tout est OK → fermer la session
        $sessionFormation->update(['statutSession' => 'ferme']);

        return redirect()->route('session_formations.index')
            ->with('success', '✅ Session clôturée avec succès. Toutes les notes ont été enregistrées.');
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
