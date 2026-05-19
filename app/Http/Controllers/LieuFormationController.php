<?php

namespace App\Http\Controllers;

use App\Models\LieuFormation;
use Illuminate\Http\Request;

class LieuFormationController extends Controller
{
    /**
     * Affiche la liste de tous les lieux de formation
     */
    public function index()
    {
        $lieux = LieuFormation::all();
        return view('lieu_formations.index', compact('lieux'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau lieu
     */
    public function create()
    {
        return view('lieu_formations.create');
    }

    /**
     * Enregistre un nouveau lieu dans la base de données
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'nomLieu' => 'required',
            'localisation' => 'required',
        ]);

        // Création du lieu
        LieuFormation::create($request->all());
        return redirect()->route('lieu_formations.index');
    }

    /**
     * Affiche le formulaire de modification d'un lieu
     */
    public function edit(LieuFormation $lieuFormation)
    {
        return view('lieu_formations.edit', compact('lieuFormation'));
    }

    /**
     * Met à jour un lieu existant
     */
    public function update(Request $request, LieuFormation $lieuFormation)
    {
        $lieuFormation->update($request->all());
        return redirect()->route('lieu_formations.index');
    }

    /**
     * Supprime un lieu de la base de données
     */
    public function destroy(LieuFormation $lieuFormation)
    {
        $lieuFormation->delete();
        return redirect()->route('lieu_formations.index');
    }
}