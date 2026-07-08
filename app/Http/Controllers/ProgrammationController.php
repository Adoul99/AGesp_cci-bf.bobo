<?php

namespace App\Http\Controllers;

use App\Models\Programmation;
use App\Models\Candidat;
use App\Models\Moniteur;
use App\Models\Groupe;
use App\Models\TypeSession;
use Illuminate\Http\Request;

class ProgrammationController extends Controller
{
    public function index()
    {
        $programmations = Programmation::with(['moniteur', 'candidats', 'typeSession'])->latest()->get();
        return view('programmations.index', compact('programmations'));
    }

    public function create()
    {
        $moniteurs    = Moniteur::all();
        $typeSessions = TypeSession::orderBy('type')->get();

        return view('programmations.create', compact('moniteurs', 'typeSessions'));
    }

    /**
     * AJAX : retourne les candidats classés par mérite (note décroissante)
     * pour un type de session donné.
     *
     * Règle d'éligibilité UNIQUE : avoir une évaluation "Admis" (note ≥ 25)
     * pour ce type de session précis (Code / Créneau / Conduite).
     */
    public function candidatsParType(Request $request, TypeSession $typeSession)
    {
        $type = strtolower($typeSession->type);

        $tousCandidats = Candidat::with('evaluations.typeSession')
            ->orderBy('nom')
            ->get();

        $eligibles    = collect();
        $nonEligibles = collect();
        $autres       = collect();

        foreach ($tousCandidats as $c) {
            $evalsType = $c->evaluations->filter(fn($e) => $e->typeSession?->type === $type);
            $meilleureNote = $evalsType->whereNotNull('note')->max('note');

            $item = [
                'id'           => $c->id,
                'nom'          => $c->nom,
                'prenom'       => $c->prenom,
                'note'         => $meilleureNote,
                'statut_label' => $c->statut_label,
            ];

            if (!is_null($meilleureNote) && $meilleureNote >= 25) {
                $eligibles->push($item);
            } elseif (!is_null($meilleureNote)) {
                $item['motif'] = "Note insuffisante : {$meilleureNote}/30 (seuil 25)";
                $nonEligibles->push($item);
            } else {
                $item['motif'] = "Pas encore évalué en " . $typeSession->type;
                $autres->push($item);
            }
        }

        $eligibles    = $eligibles->sortByDesc('note')->values();
        $autres       = $autres->sortBy('nom')->values();
        $nonEligibles = $nonEligibles->sortByDesc('note')->values();

        return response()->json([
            'eligibles'    => $eligibles,
            'nonEligibles' => $nonEligibles,
            'autres'       => $autres,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'typeSession_id' => 'required|exists:type_sessions,id',
            'moniteur_id'    => 'nullable|exists:moniteurs,id',
            'candidat_ids'   => 'required|array|min:1',
            'candidat_ids.*' => 'exists:candidats,id',
        ], [
            'candidat_ids.required' => 'Sélectionnez au moins un candidat à programmer.',
        ]);

        // Date automatique (date du jour de création de la programmation)
        $aujourdhui = now()->toDateString();

        $programmation = Programmation::create([
            'dateDebut'      => $aujourdhui,
            'dateFin'        => $aujourdhui,
            'moniteur_id'    => $request->moniteur_id,
            'typeSession_id' => $request->typeSession_id,
        ]);

        $programmation->candidats()->sync($request->candidat_ids);

        return redirect()->route('programmations.show', $programmation->id)
            ->with('success', '✅ Programmation créée avec succès.');
    }

    /**
     * Affiche la liste DGTTM imprimable des candidats programmés
     */
    public function show(Programmation $programmation)
    {
        $programmation->load(['candidats', 'moniteur', 'typeSession']);

        $type = strtolower($programmation->typeSession->type ?? '');
        $candidats = $programmation->candidats->map(function ($c) use ($type) {
            $c->load('evaluations.typeSession');
            $evalsType = $c->evaluations->filter(fn($e) => $e->typeSession?->type === $type);
            $c->meilleure_note = $evalsType->whereNotNull('note')->max('note');
            return $c;
        })->sortByDesc('meilleure_note')->values();

        return view('programmations.show', compact('programmation', 'candidats'));
    }

    public function edit(Programmation $programmation)
    {
        $programmation->load(['candidats', 'moniteur', 'typeSession']);
        $moniteurs    = Moniteur::all();
        $typeSessions = TypeSession::orderBy('type')->get();

        $candidatsSelectionnes = $programmation->candidats->pluck('id')->toArray();

        $type = strtolower($programmation->typeSession->type ?? '');
        $candidatsActuels = $programmation->candidats->map(function ($c) use ($type) {
            $c->load('evaluations.typeSession');
            $evalsType = $c->evaluations->filter(fn($e) => $e->typeSession?->type === $type);
            $c->note = $evalsType->whereNotNull('note')->max('note');
            return $c;
        })->sortByDesc('note')->values();

        return view('programmations.edit', compact(
            'programmation', 'moniteurs', 'typeSessions',
            'candidatsSelectionnes', 'candidatsActuels'
        ));
    }

    public function update(Request $request, Programmation $programmation)
    {
        $request->validate([
            'typeSession_id' => 'required|exists:type_sessions,id',
            'moniteur_id'    => 'nullable|exists:moniteurs,id',
            'candidat_ids'   => 'nullable|array',
        ]);

        $programmation->update([
            'typeSession_id' => $request->typeSession_id,
            'moniteur_id'    => $request->moniteur_id,
        ]);

        $candidatIds = $request->candidat_ids ?? [];
        $programmation->candidats()->sync($candidatIds);

        return redirect()->route('programmations.show', $programmation->id)
            ->with('success', '✅ Programmation mise à jour.');
    }

    public function destroy(Programmation $programmation)
    {
        $programmation->candidats()->detach();
        $programmation->delete();
        return redirect()->route('programmations.index')
            ->with('success', '✅ Programmation supprimée.');
    }

    /**
     * AJAX : recherche d'un candidat par nom (pour l'ajout manuel)
     */
    public function rechercherCandidat(Request $request)
    {
        $q = $request->get('q', '');
        $candidats = Candidat::where('nom', 'LIKE', "%{$q}%")
            ->orWhere('prenom', 'LIKE', "%{$q}%")
            ->limit(10)
            ->get(['id', 'nom', 'prenom', 'statut']);

        return response()->json($candidats);
    }
}