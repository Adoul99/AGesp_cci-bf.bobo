<?php

namespace App\Http\Controllers;

use App\Models\Programmation;
use App\Models\Candidat;
use App\Models\Moniteur;
use App\Models\Groupe;
use Illuminate\Http\Request;

class ProgrammationController extends Controller
{
    public function index()
    {
        $programmations = Programmation::with(['moniteur', 'groupe', 'candidats'])->get();
        return view('programmations.index', compact('programmations'));
    }

    public function create()
    {
        $moniteurs = Moniteur::all();
        $groupes   = Groupe::all();
        return view('programmations.create', compact('moniteurs', 'groupes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dateDebut'   => 'required|date',
            'dateFin'     => 'required|date|after_or_equal:dateDebut',
            'moniteur_id' => 'nullable|exists:moniteurs,id',
            'groupe_id'   => 'nullable|exists:groupes,id',
        ]);

        $programmation = Programmation::create(
            $request->only('dateDebut', 'dateFin', 'moniteur_id', 'groupe_id')
        );

        // Attacher les candidats du groupe sélectionné
        if ($request->groupe_id) {
            $groupe = Groupe::find($request->groupe_id);
            if ($groupe) {
                $candidatIds = $groupe->candidats->pluck('id')->toArray();
                $programmation->candidats()->attach($candidatIds);
            }
        }

        return redirect()->route('programmations.index')
                         ->with('success', 'Programmation créée avec succès.');
    }

    public function edit(Programmation $programmation)
    {
        $moniteurs             = Moniteur::all();
        $groupes               = Groupe::all();
        $candidatsSelectionnes = $programmation->candidats->pluck('id')->toArray();
        // Candidats du groupe associé
        $candidats = $programmation->groupe
            ? $programmation->groupe->candidats
            : collect();

        return view('programmations.edit',
            compact('programmation', 'moniteurs', 'groupes', 'candidats', 'candidatsSelectionnes')
        );
    }

    public function update(Request $request, Programmation $programmation)
    {
        $request->validate([
            'dateDebut'   => 'required|date',
            'dateFin'     => 'required|date|after_or_equal:dateDebut',
            'moniteur_id' => 'nullable|exists:moniteurs,id',
            'groupe_id'   => 'nullable|exists:groupes,id',
        ]);

        $programmation->update(
            $request->only('dateDebut', 'dateFin', 'moniteur_id', 'groupe_id')
        );

        // Si groupe changé, synchroniser avec les candidats du nouveau groupe
        if ($request->groupe_id) {
            $groupe = Groupe::find($request->groupe_id);
            if ($groupe) {
                $candidatIds = $groupe->candidats->pluck('id')->toArray();
                $programmation->candidats()->sync($candidatIds);
            }
        } else {
            $programmation->candidats()->sync($request->candidat_ids ?? []);
        }

        return redirect()->route('programmations.index')
                         ->with('success', 'Programmation mise à jour.');
    }

    public function destroy(Programmation $programmation)
    {
        $programmation->candidats()->detach();
        $programmation->delete();
        return redirect()->route('programmations.index')
                         ->with('success', 'Programmation supprimée.');
    }

    /**
     * API : retourne les candidats d'un groupe (appelé en AJAX)
     */
    public function candidatsParGroupe(Groupe $groupe)
    {
        $candidats = $groupe->candidats()->select('id', 'nom', 'prenom')->get();
        return response()->json($candidats);
    }
}
