<?php

namespace App\Http\Controllers;

use App\Models\Examen;
use App\Models\Moniteur;
use Illuminate\Http\Request;

class ExamenController extends Controller
{
    public function index()
    {
        $examens = Examen::with('moniteur')->get();
        return view('examens.index', compact('examens'));
    }

    public function create()
    {
        $moniteurs = Moniteur::all();
        return view('examens.create', compact('moniteurs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required',
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date',
        ]);

        Examen::create($request->all());
        return redirect()->route('examens.index');
    }

    public function edit(Examen $examen)
    {
        $moniteurs = Moniteur::all();
        return view('examens.edit', compact('examen', 'moniteurs'));
    }

    public function update(Request $request, Examen $examen)
    {
        $examen->update($request->all());
        return redirect()->route('examens.index');
    }

    public function destroy(Examen $examen)
    {
        $examen->delete();
        return redirect()->route('examens.index');
    }
}