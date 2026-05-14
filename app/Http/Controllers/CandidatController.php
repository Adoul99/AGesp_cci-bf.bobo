<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use Illuminate\Http\Request;

class CandidatController extends Controller
{
    public function index()
    {
        $candidats = Candidat::all();
        return view('candidats.index', compact('candidats'));
    }

    public function create()
    {
        return view('candidats.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'dateNaissance' => 'required|date',
            'lieuNaissance' => 'required',
            'numeroPermisC' => 'required',
            'dateDelivrancePermisC' => 'required|date',
            'lieuDelivrancePermisC' => 'required',
        ]);

        Candidat::create($request->all());
        return redirect()->route('candidats.index');
    }

    public function edit(Candidat $candidat)
    {
        return view('candidats.edit', compact('candidat'));
    }

    public function update(Request $request, Candidat $candidat)
    {
        $candidat->update($request->all());
        return redirect()->route('candidats.index');
    }

    public function destroy(Candidat $candidat)
    {
        $candidat->delete();
        return redirect()->route('candidats.index');
    }
}