<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Moniteur;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    /**
     * Affiche la liste de toutes les évaluations
     */
    public function index()
    {
        $evaluations = Evaluation::with('moniteur')->get();
        return view('evaluations.index', compact('evaluations'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle évaluation
     */
    public function create()
    {
        $moniteurs = Moniteur::all();
        return view('evaluations.create', compact('moniteurs'));
    }

    /**
     * Enregistre une nouvelle évaluation dans la base de données
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'dateEvaluation' => 'required|date',
            'resultat' => 'required',
            'statut' => 'required',
        ]);

        // Création de l'évaluation
        Evaluation::create($request->all());
        return redirect()->route('evaluations.index');
    }

    /**
     * Affiche le formulaire de modification d'une évaluation
     */
    public function edit(Evaluation $evaluation)
    {
        $moniteurs = Moniteur::all();
        return view('evaluations.edit', compact('evaluation', 'moniteurs'));
    }

    /**
     * Met à jour une évaluation existante
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $evaluation->update($request->all());
        return redirect()->route('evaluations.index');
    }

    /**
     * Supprime une évaluation de la base de données
     */
    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        return redirect()->route('evaluations.index');
    }
}