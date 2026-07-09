<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\Moniteur;
use App\Models\Candidat;
use App\Models\TypeSession;
use Illuminate\Http\Request;

class ExamenController extends Controller
{
    public function index()
    {
        $examens = Examen::with(['moniteur', 'candidats', 'typeSession'])->latest()->get();
        return view('examens.index', compact('examens'));
    }

    public function create()
    {
        $moniteurConnecte = Moniteur::pourUtilisateur(auth()->user());
        $moniteurs        = Moniteur::all();
        $typeSessions     = TypeSession::orderBy('type')->get();

        return view('examens.create', compact('moniteurs', 'typeSessions', 'moniteurConnecte'));
    }

    /**
     * AJAX : candidats programmés pour un type d'examen donné, et pas encore
     * inscrits à un examen de CE MÊME TYPE (un candidat déjà examiné en Code
     * peut très bien être encore éligible pour l'examen Conduite).
     */
    public function candidatsParType(TypeSession $typeSession)
    {
        $candidats = Candidat::whereHas('programmations', function ($q) use ($typeSession) {
                $q->where('typeSession_id', $typeSession->id);
            })
            ->whereDoesntHave('examens', function ($q) use ($typeSession) {
                $q->where('typeSession_id', $typeSession->id);
            })
            ->orderBy('nom')
            ->get(['id', 'nom', 'prenom']);

        return response()->json([
            'candidats' => $candidats->map(fn($c) => [
                'id'     => $c->id,
                'nom'    => $c->nom,
                'prenom' => $c->prenom,
            ]),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle'        => 'required',
            'typeSession_id' => 'required|exists:type_sessions,id',
            'dateDebut'      => 'required|date',
            'moniteur_id'    => 'nullable|exists:moniteurs,id',
            'candidat_ids'   => 'nullable|array',
        ]);

        $moniteurConnecte = Moniteur::pourUtilisateur(auth()->user());
        $moniteurId = $moniteurConnecte ? $moniteurConnecte->id : $request->moniteur_id;

        $examen = Examen::create([
            'libelle'        => $request->libelle,
            'typeSession_id' => $request->typeSession_id,
            'dateDebut'      => $request->dateDebut,
            'dateFin'        => $request->dateDebut, // Un examen se tient sur une seule date
            'statutExamen'   => 'ouvert', // Toujours "ouvert" à la création, non modifiable ici
            'moniteur_id'    => $moniteurId,
        ]);

        if ($request->candidat_ids) {
            $pivotData = [];
            foreach ($request->candidat_ids as $id) {
                $pivotData[$id] = ['resultat' => 'En attente'];
            }
            $examen->candidats()->sync($pivotData);
        }

        return redirect()->route('examens.index')
            ->with('success', '✅ Examen créé avec succès.');
    }

    public function show(Examen $examen)
    {
        $examen->load(['moniteur', 'candidats', 'typeSession']);
        return view('examens.show', compact('examen'));
    }

    public function edit(Examen $examen)
    {
        $moniteurs    = Moniteur::all();
        $typeSessions = TypeSession::orderBy('type')->get();

        // Candidats déjà programmés pour LE MÊME TYPE que cet examen, pas encore
        // inscrits à CET examen précis (mais potentiellement inscrits à d'autres).
        $idsDejaInscrits = $examen->candidats->pluck('id');
        $candidatsProgrammes = collect();

        if ($examen->typeSession_id) {
            $candidatsProgrammes = Candidat::whereHas('programmations', function ($q) use ($examen) {
                    $q->where('typeSession_id', $examen->typeSession_id);
                })
                ->whereNotIn('id', $idsDejaInscrits)
                ->orderBy('nom')
                ->get();
        }

        $candidatsSelectionnes = $examen->candidats->pluck('id')->toArray();

        return view('examens.edit', compact(
            'examen', 'moniteurs', 'typeSessions', 'candidatsProgrammes', 'candidatsSelectionnes'
        ));
    }

    public function update(Request $request, Examen $examen)
    {
        $request->validate([
            'libelle'      => 'required',
            'dateDebut'    => 'required|date',
            'statutExamen' => 'required',
            'moniteur_id'  => 'nullable|exists:moniteurs,id',
        ]);

        // Le type d'examen (Code/Créneau/Conduite) n'est JAMAIS modifiable après
        // création : il détermine quels candidats sont éligibles, et le changer
        // risquerait de garder des candidats inscrits qui ne correspondent plus
        // au type. On ignore donc toute valeur envoyée pour typeSession_id.
        $examen->update([
            'libelle'      => $request->libelle,
            'dateDebut'    => $request->dateDebut,
            'dateFin'      => $request->dateDebut, // Toujours alignée sur Date Début
            'statutExamen' => $request->statutExamen,
            'moniteur_id'  => $request->moniteur_id,
        ]);

        if ($request->has('candidat_ids')) {
            $pivotData = [];
            foreach ($request->candidat_ids as $id) {
                $pivotData[$id] = [
                    'resultat'    => $request->input("resultats.$id", 'En attente'),
                    'observation' => $request->input("observations.$id"),
                ];
            }
            $examen->candidats()->sync($pivotData);
        } else {
            $examen->candidats()->detach();
        }

        return redirect()->route('examens.index')
            ->with('success', '✅ Examen mis à jour.');
    }

    public function destroy(Examen $examen)
    {
        $examen->candidats()->detach();
        $examen->delete();
        return redirect()->route('examens.index')
            ->with('success', '✅ Examen supprimé.');
    }
}