<?php

namespace App\Http\Controllers;

use App\Models\Groupe;
use App\Models\Candidat;
use Illuminate\Http\Request;

class GroupeController extends Controller
{
    /**
     * Affiche la liste de tous les groupes
     */
    public function index()
    {
        $groupes = Groupe::with('candidats')->get();
        return view('groupes.index', compact('groupes'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau groupe
     */
    public function create()
    {
        // Charger les candidats avec leurs groupes
        $candidats = Candidat::with('groupes')->get();
        return view('groupes.create', compact('candidats'));
    }

    /**
     * Enregistre un nouveau groupe dans la base de données
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'nomGroupe' => 'required',
            'dateDebutFormation' => 'required|date',
        ]);

        // Création du groupe
        $groupe = Groupe::create($request->only('nomGroupe', 'dateDebutFormation'));

        // Attacher les candidats sélectionnés
        if ($request->has('candidat_ids')) {
            $groupe->candidats()->attach($request->candidat_ids);
        }

        return redirect()->route('groupes.index');
    }

    /**
     * Affiche le formulaire de modification d'un groupe
     */
    public function edit(Groupe $groupe)
    {
        // Charger les candidats avec leurs groupes
        $candidats = Candidat::with('groupes')->get();
        $candidatsSelectionnes = $groupe->candidats->pluck('id')->toArray();
        return view('groupes.edit', compact('groupe', 'candidats', 'candidatsSelectionnes'));
    }

    /**
     * Met à jour un groupe existant
     */
    public function update(Request $request, Groupe $groupe)
    {
        $groupe->update($request->only('nomGroupe', 'dateDebutFormation'));

        // Synchroniser les candidats sélectionnés
        $groupe->candidats()->sync($request->candidat_ids ?? []);

        return redirect()->route('groupes.index');
    }

    /**
     * Supprime un groupe de la base de données
     */
    public function destroy(Groupe $groupe)
    {
        // Détacher tous les candidats avant suppression
        $groupe->candidats()->detach();
        $groupe->delete();
        return redirect()->route('groupes.index');
    }
}