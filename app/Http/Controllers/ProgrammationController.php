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
     * Rang numérique d'une mention, pour le tri (plus haut = meilleur).
     */
    private function rangMention(?string $mention): int
    {
        return match ($mention) {
            'bien'     => 2,
            'passable' => 1,
            'mediocre' => 0,
            default    => -1,
        };
    }

    /**
     * AJAX : retourne, pour un type de session donné, DEUX listes distinctes
     * à proposer dans la programmation :
     *
     *   - "valides"        : candidats ayant VALIDÉ la session de formation
     *                        (Code : meilleure note >= 25/30 — Créneau/Conduite :
     *                        mention "bien" ou "passable"), prêts à passer
     *                        l'examen officiel de ce type pour la première fois.
     *
     *   - "a_reprogrammer" : candidats ayant ÉCHOUÉ à un examen OFFICIEL de ce
     *                        même type (résultat "Ajourné") et qui doivent
     *                        donc repasser cet examen.
     *
     * Un candidat déjà ADMIS officiellement à ce type précis est exclu
     * DÉFINITIVEMENT des deux listes (il n'a plus besoin d'être programmé
     * pour ce type). Un candidat déjà programmé et en attente de son
     * résultat est également exclu (pas de doublon).
     *
     * Note : un candidat qui a validé sa formation interne ET échoué un
     * examen officiel apparaît dans "valides" uniquement (aValide prime),
     * pour éviter les doublons entre les deux listes.
     */
    public function candidatsParType(Request $request, TypeSession $typeSession)
    {
        $type = strtolower($typeSession->type);

        // Déjà admis à ce type → exclu définitivement, plus jamais reproposé
        $dejaAdmisIds = Candidat::whereHas('examens', function ($q) use ($typeSession) {
            $q->where('typeSession_id', $typeSession->id)
              ->where('candidat_examen.resultat', 'Admis');
        })->pluck('id');

        // Déjà programmé pour ce type et toujours en attente de son examen
        // (ni admis, ni ajourné pour l'instant) → on évite de le proposer deux fois
        $dejaEnAttenteIds = Candidat::whereHas('programmations', function ($q) use ($typeSession) {
                $q->where('typeSession_id', $typeSession->id);
            })
            ->whereDoesntHave('examens', function ($q) use ($typeSession) {
                $q->where('typeSession_id', $typeSession->id)
                  ->whereIn('candidat_examen.resultat', ['Admis', 'Ajourné']);
            })
            ->pluck('id');

        $exclusIds = $dejaAdmisIds->merge($dejaEnAttenteIds)->unique();

        $candidats = Candidat::with(['evaluations.typeSession', 'examens'])
            ->whereNotIn('id', $exclusIds)
            ->orderBy('nom')
            ->get();

        $valides        = collect();
        $aReprogrammer  = collect();

        foreach ($candidats as $c) {
            $evalsType = $c->evaluations->filter(fn($e) => $e->typeSession?->type === $type);

            $item = [
                'id'     => $c->id,
                'nom'    => $c->nom,
                'prenom' => $c->prenom,
            ];

            $aEchoueExamen = $c->examens->contains(function ($examen) use ($typeSession) {
                return $examen->typeSession_id === $typeSession->id
                    && $examen->pivot->resultat === 'Ajourné';
            });

            if ($type === 'code') {
                $meilleureNote = $evalsType->whereNotNull('note')->max('note');
                $item['note']    = $meilleureNote;
                $item['mention'] = null;
                $aValide = !is_null($meilleureNote) && $meilleureNote >= 25;
            } else {
                $meilleureMention = $evalsType->whereNotNull('mention')
                    ->sortByDesc(fn($e) => $this->rangMention($e->mention))
                    ->first()?->mention;
                $item['note']    = null;
                $item['mention'] = $meilleureMention;
                $aValide = in_array($meilleureMention, ['bien', 'passable']);
            }

            // Priorité à "valides" pour éviter qu'un candidat apparaisse
            // dans les deux listes à la fois.
            if ($aValide) {
                $valides->push($item);
            } elseif ($aEchoueExamen) {
                $aReprogrammer->push($item);
            }
        }

        if ($type === 'code') {
            $valides       = $valides->sortByDesc('note')->values();
            $aReprogrammer = $aReprogrammer->sortByDesc('note')->values();
        } else {
            $valides       = $valides->sortByDesc(fn($e) => $this->rangMention($e['mention']))->values();
            $aReprogrammer = $aReprogrammer->sortByDesc(fn($e) => $this->rangMention($e['mention']))->values();
        }

        return response()->json([
            'valides'        => $valides,
            'a_reprogrammer' => $aReprogrammer,
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

            if ($type === 'code') {
                $c->meilleure_note    = $evalsType->whereNotNull('note')->max('note');
                $c->meilleure_mention = null;
            } else {
                $c->meilleure_note    = null;
                $c->meilleure_mention = $evalsType->whereNotNull('mention')
                    ->sortByDesc(fn($e) => $this->rangMention($e->mention))
                    ->first()?->mention;
            }
            return $c;
        });

        $candidats = $type === 'code'
            ? $candidats->sortByDesc('meilleure_note')->values()
            : $candidats->sortByDesc(fn($c) => $this->rangMention($c->meilleure_mention))->values();

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

            if ($type === 'code') {
                $c->note    = $evalsType->whereNotNull('note')->max('note');
                $c->mention = null;
            } else {
                $c->note    = null;
                $c->mention = $evalsType->whereNotNull('mention')
                    ->sortByDesc(fn($e) => $this->rangMention($e->mention))
                    ->first()?->mention;
            }
            return $c;
        });

        $candidatsActuels = $type === 'code'
            ? $candidatsActuels->sortByDesc('note')->values()
            : $candidatsActuels->sortByDesc(fn($c) => $this->rangMention($c->mention))->values();

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
