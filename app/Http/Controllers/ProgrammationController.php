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
     * AJAX : retourne les candidats classés par mérite pour un type de session donné.
     *
     * Règle d'éligibilité :
     * - Code           → meilleure note ≥ 25/30
     * - Créneau/Conduite → mention "bien" ou "passable" (obtenue au moins une fois)
     *
     * Les candidats DÉJÀ programmés pour CE type de session précis sont exclus
     * (on ne veut pas reprogrammer quelqu'un déjà inscrit à l'examen).
     */
    public function candidatsParType(Request $request, TypeSession $typeSession)
    {
        $type = strtolower($typeSession->type);

        // Candidats déjà programmés pour ce type de session
        $dejaProgrammesIds = Candidat::whereHas('programmations', function ($q) use ($typeSession) {
            $q->where('typeSession_id', $typeSession->id);
        })->pluck('id');

        $tousCandidats = Candidat::with('evaluations.typeSession')
            ->whereNotIn('id', $dejaProgrammesIds)
            ->orderBy('nom')
            ->get();

        $eligibles    = collect();
        $nonEligibles = collect();
        $autres       = collect();

        foreach ($tousCandidats as $c) {
            $evalsType = $c->evaluations->filter(fn($e) => $e->typeSession?->type === $type);

            $item = [
                'id'           => $c->id,
                'nom'          => $c->nom,
                'prenom'       => $c->prenom,
                'statut_label' => $c->statut_label,
            ];

            if ($type === 'code') {
                // ── Session Code : logique par note chiffrée ──
                $meilleureNote = $evalsType->whereNotNull('note')->max('note');
                $item['note']    = $meilleureNote;
                $item['mention'] = null;

                if (!is_null($meilleureNote) && $meilleureNote >= 25) {
                    $eligibles->push($item);
                } elseif (!is_null($meilleureNote)) {
                    $item['motif'] = "Note insuffisante : {$meilleureNote}/30 (seuil 25)";
                    $nonEligibles->push($item);
                } else {
                    $item['motif'] = "Pas encore évalué en Code";
                    $autres->push($item);
                }
            } else {
                // ── Créneau / Conduite : logique par mention ──
                $meilleureMention = $evalsType->whereNotNull('mention')
                    ->sortByDesc(fn($e) => $this->rangMention($e->mention))
                    ->first()?->mention;

                $item['note']    = null;
                $item['mention'] = $meilleureMention;

                if (in_array($meilleureMention, ['bien', 'passable'])) {
                    $eligibles->push($item);
                } elseif (!is_null($meilleureMention)) {
                    $item['motif'] = "Mention insuffisante : " . ucfirst($meilleureMention);
                    $nonEligibles->push($item);
                } else {
                    $libelle = $type === 'creneau' ? 'Créneau' : 'Conduite';
                    $item['motif'] = "Pas encore évalué en {$libelle}";
                    $autres->push($item);
                }
            }
        }

        if ($type === 'code') {
            $eligibles = $eligibles->sortByDesc('note')->values();
        } else {
            $eligibles = $eligibles->sortByDesc(fn($e) => $this->rangMention($e['mention']))->values();
        }
        $autres       = $autres->sortBy('nom')->values();
        $nonEligibles = $nonEligibles->sortBy('nom')->values();

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
