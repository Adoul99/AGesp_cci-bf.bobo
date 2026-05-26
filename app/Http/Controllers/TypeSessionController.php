<?php

namespace App\Http\Controllers;

use App\Models\TypeSession;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TypeSessionController extends Controller
{
    private function sessionTypes(): array
    {
        return [
            'Théorique' => 'Théorique',
            'Pratique'  => 'Pratique',
            'Mixte'     => 'Mixte',
        ];
    }

    public function index()
    {
        $typeSessions = TypeSession::all();
        return view('type_sessions.index', compact('typeSessions'));
    }

    public function create()
    {
        return view('type_sessions.create', [
            'typeCodes' => $this->sessionTypes(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'idSession' => 'required|unique:type_sessions',
            'code'      => ['required', Rule::in(array_keys($this->sessionTypes()))],
            'creneau'   => 'required|string|max:100',
            'conduite'  => 'nullable|string|max:255',
        ], [
            'idSession.required' => 'L\'identifiant de session est obligatoire.',
            'idSession.unique'   => 'Cet identifiant de session existe déjà.',
            'code.required'      => 'Le type est obligatoire.',
            'code.in'            => 'Le type sélectionné n\'est pas valide.',
            'creneau.required'   => 'Le créneau est obligatoire.',
        ]);

        TypeSession::create([
            'idSession' => $request->idSession,
            'code'      => $request->code,
            'creneau'   => $request->creneau,
            'conduite'  => $request->conduite ?? '',
        ]);

        return redirect()->route('type_sessions.index')
                         ->with('success', 'Type de session créé avec succès.');
    }

    public function edit(TypeSession $typeSession)
    {
        return view('type_sessions.edit', [
            'typeSession' => $typeSession,
            'typeCodes'   => $this->sessionTypes(),
        ]);
    }

    public function update(Request $request, TypeSession $typeSession)
    {
        $request->validate([
            'idSession' => 'required|unique:type_sessions,idSession,'.$typeSession->id,
            'code'      => ['required', Rule::in(array_keys($this->sessionTypes()))],
            'creneau'   => 'required|string|max:100',
            'conduite'  => 'nullable|string|max:255',
        ], [
            'idSession.required' => 'L\'identifiant de session est obligatoire.',
            'idSession.unique'   => 'Cet identifiant de session existe déjà.',
            'code.required'      => 'Le type est obligatoire.',
            'code.in'            => 'Le type sélectionné n\'est pas valide.',
            'creneau.required'   => 'Le créneau est obligatoire.',
        ]);

        $typeSession->update([
            'idSession' => $request->idSession,
            'code'      => $request->code,
            'creneau'   => $request->creneau,
            'conduite'  => $request->conduite ?? '',
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
