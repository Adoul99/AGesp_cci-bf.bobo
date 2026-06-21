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
        $groupes      = Groupe::all();
        $typeSessions = TypeSession::orderBy('type')->get();

        // Par défaut (avant sélection d'un type), aucun candidat affiché
        // Le chargement se fait en AJAX via candidatsParType()
        return view('programmations.create', compact('moniteurs', 'groupes', 'typeSessions'));
    }

    /**
     * AJAX : retourne les candidats éligibles ET non éligibles pour un type de session donné
     *
     * Règles d'éligibilité (basées sur le statut du candidat) :
     * - Code     → éligibles : inscrit, en_formation, ajourne (pas encore code_admis/admis)
     * - Créneau  → éligibles : code_admis uniquement (a déjà réussi le code)
     * - Conduite → éligibles : code_admis (créneau en cours) — en pratique ceux ayant
     *              déjà une évaluation Créneau "Admis" mais pas encore "admis" global
     */
    public function candidatsParType(TypeSession $typeSession)
    {
        $type = strtolower($typeSession->type);

        $tousCandidats = Candidat::with('evaluations.typeSession')
            ->orderBy('nom')
            ->get()
            ->map(function ($c) {
                $c->nb_sessions   = $c->sessions()->count();
                $c->moyenne_notes = $c->evaluations->whereNotNull('note')->avg('note');
                return $c;
            });

        $eligibles    = collect();
        $nonEligibles = collect();

        foreach ($tousCandidats as $c) {
            $estEligible = match ($type) {
                'code'     => in_array($c->statut, ['inscrit', 'en_formation', 'ajourne']),
                'creneau'  => in_array($c->statut, ['code_admis']),
                'conduite' => $c->evaluations
                                ->where('resultat', 'Admis')
                                ->filter(fn($e) => $e->typeSession?->type === 'creneau')
                                ->isNotEmpty()
                                && $c->statut !== 'admis',
                default    => true,
            };

            $motif = match ($type) {
                'code'     => $estEligible ? 'Code non encore validé' : "Statut actuel : {$c->statut_label}",
                'creneau'  => $estEligible ? 'Code validé, prêt pour le créneau' : 'Le code doit être validé en premier',
                'conduite' => $estEligible ? 'Créneau validé, prêt pour la conduite' : 'Le créneau doit être validé en premier',
                default    => '',
            };

            $item = [
                'id'             => $c->id,
                'nom'            => $c->nom,
                'prenom'         => $c->prenom,
                'statut'         => $c->statut,
                'statut_label'   => $c->statut_label,
                'nb_sessions'    => $c->nb_sessions,
                'moyenne_notes'  => $c->moyenne_notes ? round($c->moyenne_notes, 2) : null,
                'priorite'       => $c->moyenne_notes && $c->moyenne_notes >= 25,
                'motif'          => $motif,
            ];

            if ($estEligible) {
                $eligibles->push($item);
            } else {
                $nonEligibles->push($item);
            }
        }

        // Tri : priorité (moyenne ≥ 25) en premier, puis par nombre de sessions décroissant
        $eligibles = $eligibles->sortByDesc(fn($c) => [$c['priorite'] ? 1 : 0, $c['nb_sessions']])->values();

        return response()->json([
            'eligibles'    => $eligibles,
            'nonEligibles' => $nonEligibles->values(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'dateDebut'      => 'required|date',
            'dateFin'        => 'required|date|after_or_equal:dateDebut',
            'typeSession_id' => 'required|exists:type_sessions,id',
            'moniteur_id'    => 'nullable|exists:moniteurs,id',
            'candidat_ids'   => 'required|array|min:1',
            'candidat_ids.*' => 'exists:candidats,id',
        ], [
            'candidat_ids.required' => 'Sélectionnez au moins un candidat éligible.',
        ]);

        $programmation = Programmation::create(
            $request->only('dateDebut', 'dateFin', 'moniteur_id', 'typeSession_id')
        );

        $candidatIds = $request->candidat_ids;
        $programmation->candidats()->sync($candidatIds);

        // Auto-inscrire les candidats admis au prochain examen ouvert
        $candidatsAdmis = Candidat::whereIn('id', $candidatIds)
            ->where('statut', 'admis')
            ->get();

        if ($candidatsAdmis->isNotEmpty()) {
            $examenOuvert = \App\Models\Examen::where('statutExamen', 'ouvert')
                ->orWhereNull('statutExamen')
                ->latest()
                ->first();

            if ($examenOuvert) {
                foreach ($candidatsAdmis as $candidat) {
                    $examenOuvert->candidats()->syncWithoutDetaching([
                        $candidat->id => ['resultat' => 'En attente']
                    ]);
                }
            }
        }

        return redirect()->route('programmations.index')
            ->with('success', '✅ Programmation créée avec succès.');
    }

    public function edit(Programmation $programmation)
    {
        $moniteurs    = Moniteur::all();
        $typeSessions = TypeSession::orderBy('type')->get();

        $candidatsSelectionnes = $programmation->candidats->pluck('id')->toArray();

        // Pour l'édition, on affiche directement les candidats déjà liés
        $candidatsActuels = $programmation->candidats->map(function ($c) {
            $c->nb_sessions   = $c->sessions()->count();
            $c->moyenne_notes = $c->evaluations()->whereNotNull('note')->avg('note');
            return $c;
        });

        return view('programmations.edit', compact(
            'programmation', 'moniteurs', 'typeSessions',
            'candidatsSelectionnes', 'candidatsActuels'
        ));
    }

    public function update(Request $request, Programmation $programmation)
    {
        $request->validate([
            'dateDebut'      => 'required|date',
            'dateFin'        => 'required|date|after_or_equal:dateDebut',
            'typeSession_id' => 'required|exists:type_sessions,id',
            'moniteur_id'    => 'nullable|exists:moniteurs,id',
            'candidat_ids'   => 'nullable|array',
        ]);

        $programmation->update(
            $request->only('dateDebut', 'dateFin', 'moniteur_id', 'typeSession_id')
        );

        $candidatIds = $request->candidat_ids ?? [];
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
}