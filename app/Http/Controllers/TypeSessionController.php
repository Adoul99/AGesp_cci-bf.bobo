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
            'idSession' => 'required|unique:type_sessions',
            'code'      => 'required|string|max:100',
            'creneau'   => 'required|string|max:100',   // ← était manquant
            'conduite'  => 'nullable|string|max:255',   // ← nullable si optionnel
        ], [
            'idSession.required' => 'L\'identifiant de session est obligatoire.',
            'idSession.unique'   => 'Cet identifiant de session existe déjà.',
            'code.required'      => 'Le code est obligatoire.',
            'creneau.required'   => 'Le créneau est obligatoire.',
        ]);

        TypeSession::create([
            'idSession' => $request->idSession,
            'code'      => $request->code,
            'creneau'   => $request->creneau,
            'conduite'  => $request->conduite,
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
            'code'     => 'required|string|max:100',
            'creneau'  => 'required|string|max:100',
            'conduite' => 'nullable|string|max:255',
        ]);

        $typeSession->update([
            'code'     => $request->code,
            'creneau'  => $request->creneau,
            'conduite' => $request->conduite,
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
