<?php

namespace App\Http\Controllers;

use App\Models\Programmation;
use App\Models\Candidat;
use App\Models\Moniteur;
use Illuminate\Http\Request;

class ProgrammationController extends Controller
{
    /**
     * Affiche la liste de toutes les programmations
     */
    public function index()
    {
        $programmations = Programmation::with(['moniteur', 'candidats'])->get();
        return view('programmations.index', compact('programmations'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle programmation
     */
    public function create()
    {
        $moniteurs = Moniteur::all();
        $candidats = Candidat::with('programmations')->get();
        return view('programmations.create', compact('moniteurs', 'candidats'));
    }

    /**
     * Enregistre une nouvelle programmation dans la base de données
     */
    public function store(Request $request)
    {
        $request->validate([
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date',
        ]);

        // Création de la programmation
        $programmation = Programmation::create($request->only('dateDebut', 'dateFin', 'moniteur_id'));

        // Attacher les candidats sélectionnés
        if ($request->has('candidat_ids')) {
            $programmation->candidats()->attach($request->candidat_ids);
        }

        return redirect()->route('programmations.index');
    }

    /**
     * Affiche le formulaire de modification d'une programmation
     */
    public function edit(Programmation $programmation)
    {
        $moniteurs = Moniteur::all();
        $candidats = Candidat::with('programmations')->get();
        $candidatsSelectionnes = $programmation->candidats->pluck('id')->toArray();
        return view('programmations.edit', compact('programmation', 'moniteurs', 'candidats', 'candidatsSelectionnes'));
    }

    /**
     * Met à jour une programmation existante
     */
    public function update(Request $request, Programmation $programmation)
    {
        $programmation->update($request->only('dateDebut', 'dateFin', 'moniteur_id'));

        // Synchroniser les candidats sélectionnés
        $programmation->candidats()->sync($request->candidat_ids ?? []);

        return redirect()->route('programmations.index');
    }

    /**
     * Supprime une programmation de la base de données
     */
    public function destroy(Programmation $programmation)
    {
        // Détacher tous les candidats avant suppression
        $programmation->candidats()->detach();
        $programmation->delete();
        return redirect()->route('programmations.index');
    }
}