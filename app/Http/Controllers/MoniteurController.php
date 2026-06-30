<?php

namespace App\Http\Controllers;

use App\Models\Moniteur;
use App\Models\SessionFormation;
use App\Models\Evaluation;
use App\Traits\ExportableTrait;
use Illuminate\Http\Request;

class MoniteurController extends Controller
{
    use ExportableTrait;

    // ══════════════════════════════════════════════════════════
    // CRUD ADMIN
    // ══════════════════════════════════════════════════════════

    public function index()
    {
        $moniteurs = Moniteur::all();
        return view('moniteurs.index', compact('moniteurs'));
    }

    public function create()
    {
        return view('moniteurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom'    => 'required',
            'prenom' => 'required',
        ]);

        Moniteur::create($request->all());
        return redirect()->route('moniteurs.index');
    }

    public function show(Moniteur $moniteur)
    {
        return view('moniteurs.show', compact('moniteur'));
    }

    public function edit(Moniteur $moniteur)
    {
        return view('moniteurs.edit', compact('moniteur'));
    }

    public function update(Request $request, Moniteur $moniteur)
    {
        $moniteur->update($request->all());
        return redirect()->route('moniteurs.index');
    }

    public function destroy(Moniteur $moniteur)
    {
        $moniteur->delete();
        return redirect()->route('moniteurs.index');
    }

    // ══════════════════════════════════════════════════════════
    // ESPACE MONITEUR CONNECTÉ
    // ══════════════════════════════════════════════════════════

    /**
     * Tableau de bord moniteur → GET /moniteur/espace
     */
    public function espace(Request $request)
    {
        $moniteur = $this->getMoniteurConnecte($request);

        $sessionsCount = SessionFormation::where('moniteur_id', $moniteur->id)->count();

        $prochainesSessions = SessionFormation::where('moniteur_id', $moniteur->id)
            ->where('dateDebut', '>=', now())
            ->orderBy('dateDebut')
            ->limit(5)
            ->get();

        return view('moniteurs.espace', compact('moniteur', 'sessionsCount', 'prochainesSessions'));
    }

    /**
     * Toutes les sessions → GET /moniteur/sessions
     */
    public function sessionsIndex(Request $request)
    {
        $moniteur = $this->getMoniteurConnecte($request);

        $sessions = SessionFormation::where('moniteur_id', $moniteur->id)
            ->orderBy('dateDebut', 'desc')
            ->get();

        return view('moniteurs.sessions', compact('moniteur', 'sessions'));
    }

    /**
     * Détail d'une session → GET /moniteur/sessions/{sessionFormation}
     */
    public function sessionsShow(Request $request, SessionFormation $sessionFormation)
    {
        $moniteur = $this->getMoniteurConnecte($request);

        abort_if($sessionFormation->moniteur_id !== $moniteur->id, 403, 'Cette session ne vous appartient pas.');

        $candidats = collect();
        if ($sessionFormation->groupe && $sessionFormation->groupe->candidats) {
            $candidats = $sessionFormation->groupe->candidats;
        }

        return view('moniteurs.session_show', compact('moniteur', 'sessionFormation', 'candidats'));
    }

    /**
     * Formulaire saisie évaluation → GET /moniteur/evaluations/creer
     */
    public function evaluationsCreate(Request $request)
    {
        $moniteur = $this->getMoniteurConnecte($request);

        $sessions = SessionFormation::where('moniteur_id', $moniteur->id)
            ->where('statutSession', 'ouvert')
            ->with('groupe.candidats')
            ->get();

        return view('moniteurs.evaluation_create', compact('moniteur', 'sessions'));
    }

    /**
     * Enregistrer une évaluation → POST /moniteur/evaluations
     */
    public function evaluationsStore(Request $request)
    {
        $moniteur = $this->getMoniteurConnecte($request);

        $data = $request->validate([
            'candidat_id'         => 'required|exists:candidats,id',
            'sessionFormation_id' => 'required|exists:session_formations,id',
            'note_code'           => 'nullable|numeric|min:0|max:20',
            'note_conduite'       => 'nullable|numeric|min:0|max:20',
            'resultat'            => 'nullable|string',
            'observation'         => 'nullable|string|max:500',
        ]);

        // Vérifie que la session appartient bien au moniteur
        $session = SessionFormation::findOrFail($data['sessionFormation_id']);
        abort_if($session->moniteur_id !== $moniteur->id, 403);

        Evaluation::create($data);

        return redirect()->route('moniteur.espace')
                         ->with('success', 'Évaluation enregistrée avec succès.');
    }

    /**
     * Performances / statistiques → GET /moniteur/performances
     */
    public function performances(Request $request)
    {
        $moniteur = $this->getMoniteurConnecte($request);

        $totalSessions = SessionFormation::where('moniteur_id', $moniteur->id)->count();

        $sessionIds = SessionFormation::where('moniteur_id', $moniteur->id)->pluck('id');

        $totalEvaluations = Evaluation::whereIn('sessionFormation_id', $sessionIds)->count();

        $admis = Evaluation::whereIn('sessionFormation_id', $sessionIds)
            ->where('resultat', 'admis')
            ->count();

        $tauxReussite = $totalEvaluations > 0
            ? round(($admis / $totalEvaluations) * 100, 1)
            : 0;

        return view('moniteurs.performances', compact(
            'moniteur',
            'totalSessions',
            'totalEvaluations',
            'admis',
            'tauxReussite'
        ));
    }

    // ══════════════════════════════════════════════════════════
    // HELPER PRIVÉ
    // ══════════════════════════════════════════════════════════

    private function getMoniteurConnecte(Request $request): Moniteur
    {
        $user     = $request->user();
        $moniteur = Moniteur::where('user_id', $user->id)
                            ->orWhere('email', $user->email)
                            ->first();

        abort_if(!$moniteur, 404, "Aucune fiche moniteur n'est associée à ce compte. Contactez un administrateur.");

        return $moniteur;
    }
}