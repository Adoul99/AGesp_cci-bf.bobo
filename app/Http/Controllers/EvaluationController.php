<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Moniteur;
use App\Models\Candidat;
use App\Models\TypeSession;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::with(['candidat', 'moniteur'])->get();
        return view('evaluations.index', compact('evaluations'));
    }

    public function create()
    {
        $moniteurs    = Moniteur::all();
        $candidats    = Candidat::orderBy('nom')->get();
        $typeSessions = TypeSession::orderBy('type')->get(); // ← 'code' → 'type'
        return view('evaluations.create', compact('moniteurs', 'candidats', 'typeSessions'));
    }

    public function report()
    {
        $evaluations = Evaluation::with(['candidat', 'moniteur'])
            ->orderBy('dateEvaluation', 'desc')
            ->get();
        return view('evaluations.report', compact('evaluations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'candidat_id'    => 'required|exists:candidats,id',
            'dateEvaluation' => 'required|date',
            'note'           => 'nullable|numeric|min:0|max:30',
            'statut'         => 'required|in:en_attente,reussi,echoue',
            'moniteur_id'    => 'nullable|exists:moniteurs,id',
        ]);

        $note     = $request->note;
        $resultat = 'En attente';
        if (!is_null($note)) {
            $resultat = $note >= 25 ? 'Admis' : 'Ajourné';
        }

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

    public function edit(Evaluation $evaluation)
    {
        $moniteurs    = Moniteur::all();
        $candidats    = Candidat::orderBy('nom')->get();
        $typeSessions = TypeSession::orderBy('type')->get(); // ← 'code' → 'type'
        return view('evaluations.edit', compact('evaluation', 'moniteurs', 'candidats', 'typeSessions'));
    }

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
        $resultat = 'En attente';
        if (!is_null($note)) {
            $resultat = $note >= 25 ? 'Admis' : 'Ajourné';
        }

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

    public function destroy(Evaluation $evaluation)
    {
        $evaluation->delete();
        return redirect()->route('evaluations.index')
                         ->with('success', 'Évaluation supprimée.');
    }
}