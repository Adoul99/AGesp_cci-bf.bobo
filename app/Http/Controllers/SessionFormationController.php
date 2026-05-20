<?php

namespace App\Http\Controllers;

use App\Models\SessionFormation;
use App\Models\Vehicule;
use App\Models\Evaluation;
use App\Models\Groupe;
use Illuminate\Http\Request;

class SessionFormationController extends Controller
{
    /**
     * Affiche la liste de toutes les sessions de formation
     */
    public function index()
    {
        $sessions = SessionFormation::with(['vehicule', 'evaluation', 'groupe'])->get();
        return view('session_formations.index', compact('sessions'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle session
     */
    public function create()
    {
        $vehicules = Vehicule::all();
        $evaluations = Evaluation::all();
        $groupes = Groupe::all();
        return view('session_formations.create', compact('vehicules', 'evaluations', 'groupes'));
    }

    /**
     * Enregistre une nouvelle session dans la base de données
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'dateDebut' => 'required|date',
            'statutSession' => 'required',
        ]);

        // Création de la session
        SessionFormation::create($request->all());
        return redirect()->route('session_formations.index');
    }

    /**
     * Affiche le formulaire de modification d'une session
     */
    public function edit(SessionFormation $sessionFormation)
    {
        $vehicules = Vehicule::all();
        $evaluations = Evaluation::all();
        $groupes = Groupe::all();
        return view('session_formations.edit', compact('sessionFormation', 'vehicules', 'evaluations', 'groupes'));
    }

    /**
     * Met à jour une session existante
     */
    public function update(Request $request, SessionFormation $sessionFormation)
    {
        $sessionFormation->update($request->all());
        return redirect()->route('session_formations.index');
    }

    /**
     * Supprime une session de la base de données
     */
    public function destroy(SessionFormation $sessionFormation)
    {
        $sessionFormation->delete();
        return redirect()->route('session_formations.index');
    }
}