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
     * ADMIS à un examen de CE MÊME TYPE.
     *
     * Seuls ceux ayant RÉUSSI (résultat = 'Admis') ce type précis sont
     * exclus ; un candidat ajourné reste éligible pour une nouvelle tentative.
     */
    public function candidatsParType(TypeSession $typeSession)
    {
        $candidats = Candidat::whereHas('programmations', function ($q) use ($typeSession) {
                $q->where('typeSession_id', $typeSession->id);
            })
            ->whereDoesntHave('examens', function ($q) use ($typeSession) {
                $q->where('typeSession_id', $typeSession->id)
                  ->where('candidat_examen.resultat', 'Admis');
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
            'lieu'           => 'nullable|string|max:255',
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
            'lieu'           => $request->lieu,
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

        return view('examens.edit', compact('examen', 'moniteurs', 'typeSessions'));
    }

    public function update(Request $request, Examen $examen)
    {
        $request->validate([
            'libelle'      => 'required',
            'dateDebut'    => 'required|date',
            'lieu'         => 'nullable|string|max:255',
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
            'lieu'         => $request->lieu,
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

        // ── Recalcul du statut candidat selon le résultat officiel ──
        // C'est ICI, et UNIQUEMENT ici (juste après la saisie des résultats
        // officiels de l'examen), que le statut du candidat évolue depuis
        // "en attente" (posé lors de la programmation) :
        //   - Admis aux 3 phases (Code + Créneau + Conduite) → "admis"
        //     (mettreAJourStatutApresExamen() vérifie les 3 phases)
        //   - Ajourné à CET examen → "ajourne" (il devra être reprogrammé)
        //   - Toujours "En attente" → on ne touche à rien
        // Sans cet appel, le statut ne se met jamais à jour automatiquement,
        // même si le résultat est bien enregistré en base.
        $examen->load('candidats'); // recharge le pivot fraîchement mis à jour
        $nouveauxAdmis   = [];
        $nouveauxAjournes = [];

        foreach ($examen->candidats as $candidat) {
            if ($candidat->mettreAJourStatutApresExamen()) {
                $nouveauxAdmis[] = $candidat->nom . ' ' . $candidat->prenom;
                // Le candidat vient de devenir admis officiellement : il n'a
                // plus rien à faire dans une session de formation en cours.
                $candidat->retirerDesSessionsOuvertes();
                continue;
            }

            // Ne jamais faire régresser un candidat déjà admis officiellement.
            if ($candidat->statut === 'admis') {
                continue;
            }

            if ($candidat->pivot->resultat === 'Ajourné') {
                $candidat->update(['statut' => 'ajourne']);
                $nouveauxAjournes[] = $candidat->nom . ' ' . $candidat->prenom;
            }
            // resultat === 'En attente' : le statut reste "en_attente", rien à faire.
        }

        $message = '✅ Examen mis à jour.';
        if (!empty($nouveauxAdmis)) {
            $message .= ' 🎓 Candidat(s) admis : ' . implode(', ', $nouveauxAdmis)
                . '. Vous pouvez maintenant établir leur(s) attestation(s).';
        }
        if (!empty($nouveauxAjournes)) {
            $message .= ' ⚠️ Candidat(s) ajourné(s) : ' . implode(', ', $nouveauxAjournes) . '.';
        }

        return redirect()->route('examens.index')->with('success', $message);
    }

    public function destroy(Examen $examen)
    {
        $examen->candidats()->detach();
        $examen->delete();
        return redirect()->route('examens.index')
            ->with('success', '✅ Examen supprimé.');
    }
}
