<?php

namespace App\Http\Controllers;

use App\Models\TypeSession;
use Illuminate\Http\Request;

class TypeSessionController extends Controller
{
    public function index()
    {
        $typeSessions = TypeSession::all();
        return view('type_sessions.index', compact('typeSessions'));
    }

    public function create()
    {
        return view('type_sessions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'        => 'required|in:code,creneau,conduite',
            'description' => 'nullable|string|max:255',
        ], [
            'type.required' => 'Veuillez choisir un type de session.',
            'type.in'       => 'Le type choisi est invalide.',
        ]);

        TypeSession::create([
            'type'        => $request->type,
            'description' => $request->description,
        ]);

        return redirect()->route('type_sessions.index')
                         ->with('success', 'Type de session créé avec succès.');
    }

    public function edit(TypeSession $typeSession)
    {
        return view('type_sessions.edit', compact('typeSession'));
    }

    public function update(Request $request, TypeSession $typeSession)
    {
        $request->validate([
            'type'        => 'required|in:code,creneau,conduite',
            'description' => 'nullable|string|max:255',
        ]);

        $typeSession->update([
            'type'        => $request->type,
            'description' => $request->description,
        ]);

        return redirect()->route('type_sessions.index')
                         ->with('success', 'Type de session mis à jour.');
    }

    public function destroy(TypeSession $typeSession)
    {
        $typeSession->delete();
        return redirect()->route('type_sessions.index')
                         ->with('success', 'Type de session supprimé.');
    }
}