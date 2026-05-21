<?php

namespace App\Http\Controllers;

use App\Models\TypeSession;
use Illuminate\Http\Request;

class TypeSessionController extends Controller
{
    /**
     * Affiche la liste de tous les types de session
     */
    public function index()
    {
        $types = TypeSession::all();
        return view('type_sessions.index', compact('types'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau type de session
     */
    public function create()
    {
        return view('type_sessions.create');
    }

    /**
     * Enregistre un nouveau type dans la base de données
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'idSession' => 'required|unique:type_sessions',
            'code' => 'required',
        ]);

        // Création du type de session
        TypeSession::create($request->all());
        return redirect()->route('type_sessions.index');
    }

    /**
     * Affiche le formulaire de modification d'un type de session
     */
    public function edit(TypeSession $typeSession)
    {
        return view('type_sessions.edit', compact('typeSession'));
    }

    /**
     * Met à jour un type de session existant
     */
    public function update(Request $request, TypeSession $typeSession)
    {
        $typeSession->update($request->all());
        return redirect()->route('type_sessions.index');
    }

    /**
     * Supprime un type de session de la base de données
     */
    public function destroy(TypeSession $typeSession)
    {
        $typeSession->delete();
        return redirect()->route('type_sessions.index');
    }
}