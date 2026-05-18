<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\Candidat;
use Illuminate\Http\Request;

class DossierController extends Controller
{
    public function index()
    {
        $dossiers = Dossier::with('candidat')->get();
        return view('dossiers.index', compact('dossiers'));
    }

    public function create()
    {
        $candidats = Candidat::all();
        return view('dossiers.create', compact('candidats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomDossier' => 'required',
            'dateDepot' => 'required|date',
            'candidat_id' => 'required',
        ]);

        Dossier::create($request->all());
        return redirect()->route('dossiers.index');
    }

    public function edit(Dossier $dossier)
    {
        $candidats = Candidat::all();
        return view('dossiers.edit', compact('dossier', 'candidats'));
    }

    public function update(Request $request, Dossier $dossier)
    {
        $dossier->update($request->all());
        return redirect()->route('dossiers.index');
    }

    public function destroy(Dossier $dossier)
    {
        $dossier->delete();
        return redirect()->route('dossiers.index');
    }
}