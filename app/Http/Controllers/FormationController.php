<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\Moniteur;
use App\Models\Vehicule;
use Illuminate\Http\Request;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::with(['moniteur', 'vehicule'])->get();
        return view('formations.index', compact('formations'));
    }

    public function create()
    {
        $moniteurs = Moniteur::all();
        $vehicules = Vehicule::all();
        return view('formations.create', compact('moniteurs', 'vehicules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dateDebut' => 'required|date',
            'dateFin' => 'required|date',
            'typeFormation' => 'required',
        ]);

        Formation::create($request->all());
        return redirect()->route('formations.index');
    }

    public function edit(Formation $formation)
    {
        $moniteurs = Moniteur::all();
        $vehicules = Vehicule::all();
        return view('formations.edit', compact('formation', 'moniteurs', 'vehicules'));
    }

    public function update(Request $request, Formation $formation)
    {
        $formation->update($request->all());
        return redirect()->route('formations.index');
    }

    public function destroy(Formation $formation)
    {
        $formation->delete();
        return redirect()->route('formations.index');
    }
}