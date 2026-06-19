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
        $programmations = Programmation::with(['moniteur', 'groupe', 'candidats'])->latest()->get();
        return view('programmations.index', compact('programmations'));
    }

    public function create()
    {
        $moniteurs = Moniteur::all();
        $groupes   = Groupe::all();

        // Tous les candidats sont programmables
        // Les admis (code+créneau+conduite) sont programmables pour l'examen
        $candidatsProgrammables = Candidat::orderBy('nom')
            ->get()
            ->map(function ($c) {
                $c->nb_sessions = $c->sessions()->count();
                return $c;
            });

        // Candidats ≥ 5 sessions (priorité)
        $candidats5Sessions = $candidatsProgrammables->where('nb_sessions', '>=', 5);

        // Candidats admis → programmables pour l'examen (badge spécial)
        $candidatsAdmis = $candidatsProgrammables->where('statut', 'admis');

        // Aucun candidat exclu
        $candidatsNonProgrammables = collect();

        return view('programmations.create', compact(
            'moniteurs', 'groupes',
            'candidatsProgrammables', 'candidats5Sessions',
            'candidatsAdmis', 'candidatsNonProgrammables'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dateDebut'    => 'required|date',
            'dateFin'      => 'required|date|after_or_equal:dateDebut',
            'moniteur_id'  => 'nullable|exists:moniteurs,id',
            'groupe_id'    => 'nullable|exists:groupes,id',
            'candidat_ids' => 'nullable|array',
            'candidat_ids.*' => 'exists:candidats,id',
        ]);

        $programmation = Programmation::create(
            $request->only('dateDebut', 'dateFin', 'moniteur_id', 'groupe_id')
        );

        // Candidats sélectionnés manuellement
        $candidatIds = $request->candidat_ids ?? [];

        // Si un groupe est sélectionné, ajouter aussi ses candidats programmables
        if ($request->groupe_id) {
            $groupe = Groupe::with('candidats')->find($request->groupe_id);
            if ($groupe) {
                $idsGroupe = $groupe->candidats
                    ->pluck('id')
                    ->toArray();
                $candidatIds = array_unique(array_merge($candidatIds, $idsGroupe));
            }
        }

        if (!empty($candidatIds)) {
            $programmation->candidats()->sync($candidatIds);

            // Auto-inscrire les candidats admis au prochain examen ouvert
            $candidatsAdmis = \App\Models\Candidat::whereIn('id', $candidatIds)
                ->where('statut', 'admis')
                ->get();

            if ($candidatsAdmis->isNotEmpty()) {
                // Chercher un examen ouvert ou en créer un automatiquement
                $examenOuvert = \App\Models\Examen::where('statutExamen', 'ouvert')
                    ->orWhereNull('statutExamen')
                    ->latest()
                    ->first();

                if ($examenOuvert) {
                    foreach ($candidatsAdmis as $candidat) {
                        // Éviter les doublons
                        $examenOuvert->candidats()->syncWithoutDetaching([
                            $candidat->id => ['resultat' => 'En attente']
                        ]);
                    }
                }
            }
        }

        return redirect()->route('programmations.index')
            ->with('success', '✅ Programmation créée avec succès.');
    }

    public function edit(Programmation $programmation)
    {
        $moniteurs = Moniteur::all();
        $groupes   = Groupe::all();

        $candidatsSelectionnes = $programmation->candidats->pluck('id')->toArray();

        $candidatsProgrammables = Candidat::orderBy('nom')->get()
            ->map(function ($c) {
                $c->nb_sessions = $c->sessions()->count();
                return $c;
            });

        return view('programmations.edit', compact(
            'programmation', 'moniteurs', 'groupes',
            'candidatsProgrammables', 'candidatsSelectionnes'
        ));
    }

    public function update(Request $request, Programmation $programmation)
    {
        $request->validate([
            'dateDebut'    => 'required|date',
            'dateFin'      => 'required|date|after_or_equal:dateDebut',
            'moniteur_id'  => 'nullable|exists:moniteurs,id',
            'groupe_id'    => 'nullable|exists:groupes,id',
            'candidat_ids' => 'nullable|array',
        ]);

        $programmation->update(
            $request->only('dateDebut', 'dateFin', 'moniteur_id', 'groupe_id')
        );

        $candidatIds = $request->candidat_ids ?? [];

        if ($request->groupe_id) {
            $groupe = Groupe::with('candidats')->find($request->groupe_id);
            if ($groupe) {
                $idsGroupe = $groupe->candidats
                    ->pluck('id')->toArray();
                $candidatIds = array_unique(array_merge($candidatIds, $idsGroupe));
            }
        }

        $programmation->candidats()->sync($candidatIds);

        return redirect()->route('programmations.index')
            ->with('success', '✅ Programmation mise à jour.');
    }

    public function destroy(Programmation $programmation)
    {
        $programmation->candidats()->detach();
        $programmation->delete();
        return redirect()->route('programmations.index')
            ->with('success', '✅ Programmation supprimée.');
    }

    public function candidatsParGroupe(Groupe $groupe)
    {
        $candidats = $groupe->candidats()
            ->whereNotIn('statut', ['admis', 'code_admis'])
            ->select('id', 'nom', 'prenom', 'statut')
            ->get()
            ->map(function ($c) {
                $c->nb_sessions = $c->sessions()->count();
                return $c;
            });
        return response()->json($candidats);
    }
}
