<?php

namespace App\Http\Controllers;

use App\Models\CategoriePermis;
use Illuminate\Http\Request;

class CategoriePermisController extends Controller
{
    /**
     * Affiche la liste de toutes les catégories de permis
     */
    public function index()
    {
        $categories = CategoriePermis::all();
        return view('categorie_permis.index', compact('categories'));
    }

    /**
     * Affiche le formulaire de création d'une nouvelle catégorie
     */
    public function create()
    {
        return view('categorie_permis.create');
    }

    /**
     * Enregistre une nouvelle catégorie dans la base de données
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'nomCategorie' => 'required',
        ]);

        // Création de la catégorie
        CategoriePermis::create($request->all());
        return redirect()->route('categorie_permis.index');
    }

    /**
     * Affiche le formulaire de modification d'une catégorie
     */
    public function edit(CategoriePermis $categoriePermis)
    {
        return view('categorie_permis.edit', compact('categoriePermis'));
    }

    /**
     * Met à jour une catégorie existante
     */
    public function update(Request $request, CategoriePermis $categoriePermis)
    {
        // Mise à jour de la catégorie
        $categoriePermis->update($request->all());
        return redirect()->route('categorie_permis.index');
    }

    /**
     * Supprime une catégorie de la base de données
     */
    public function destroy(CategoriePermis $categoriePermis)
    {
        $categoriePermis->delete();
        return redirect()->route('categorie_permis.index');
    }
}