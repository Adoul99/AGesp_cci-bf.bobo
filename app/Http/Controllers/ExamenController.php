<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\Moniteur;
use App\Models\Candidat;
use Illuminate\Http\Request;

class ExamenController extends Controller
{
    public function index()
    {
        $examens = Examen::with(['moniteur', 'candidats'])->latest()->get();
        return view('examens.index', compact('examens'));
    }

    public function create()
    {
        // Détecter le moniteur connecté via son email
        $moniteurConnecte = Moniteur::pourUtilisateur(auth()->user());

        $moniteurs = Moniteur::all();
        // Candidats admis (prêts pour l'examen) + tous les autres
        $candidatsAdmis = Candidat::where('statut', 'admis')->orderBy('nom')->get();
        $autresCandidats = Candidat::where('statut', '!=', 'admis')->orderBy('nom')->get();
        return view('examens.create', compact(
            'moniteurs', 'candidatsAdmis', 'autresCandidats', 'moniteurConnecte'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle'       => 'required',
            'dateDebut'     => 'required|date',
            'dateFin'       => 'required|date',
            'statutExamen'  => 'required',
            'moniteur_id'   => 'nullable|exists:moniteurs,id',
            'candidat_ids'  => 'nullable|array',
        ]);

        // Si un moniteur est connecté, on force son ID (sécurité : pas de triche possible)
        $moniteurConnecte = Moniteur::pourUtilisateur(auth()->user());
        $moniteurId = $moniteurConnecte ? $moniteurConnecte->id : $request->moniteur_id;

        $examen = Examen::create([
            'libelle'      => $request->libelle,
            'dateDebut'    => $request->dateDebut,
            'dateFin'      => $request->dateFin,
            'statutExamen' => $request->statutExamen,
            'moniteur_id'  => $moniteurId,
        ]);

        // Attacher les candidats sélectionnés
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
        $examen->load(['moniteur', 'candidats']);
        return view('examens.show', compact('examen'));
    }

    public function edit(Examen $examen)
    {
        $moniteurs = Moniteur::all();
        $candidatsAdmis = Candidat::where('statut', 'admis')->orderBy('nom')->get();
        $autresCandidats = Candidat::where('statut', '!=', 'admis')->orderBy('nom')->get();
        $candidatsSelectionnes = $examen->candidats->pluck('id')->toArray();
        return view('examens.edit', compact(
            'examen', 'moniteurs', 'candidatsAdmis',
            'autresCandidats', 'candidatsSelectionnes'
        ));
    }

    public function update(Request $request, Examen $examen)
    {
        $request->validate([
            'libelle'      => 'required',
            'dateDebut'    => 'required|date',
            'dateFin'      => 'required|date',
            'statutExamen' => 'required',
            'moniteur_id'  => 'nullable|exists:moniteurs,id',
        ]);

        $examen->update($request->only(
            'libelle', 'dateDebut', 'dateFin', 'statutExamen', 'moniteur_id'
        ));

        // Mettre à jour les candidats + leurs résultats + observations
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
