<?php

namespace App\Http\Controllers;

use App\Models\Moniteur;
use Illuminate\Http\Request;

class MoniteurController extends Controller
{
    public function index()
    {
        $moniteurs = Moniteur::all();
        return view('moniteurs.index', compact('moniteurs'));
    }

    public function create()
    {
        return view('moniteurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
        ]);

        Moniteur::create($request->all());
        return redirect()->route('moniteurs.index');
    }

    public function edit(Moniteur $moniteur)
    {
        return view('moniteurs.edit', compact('moniteur'));
    }

    public function update(Request $request, Moniteur $moniteur)
    {
        $moniteur->update($request->all());
        return redirect()->route('moniteurs.index');
    }

    public function destroy(Moniteur $moniteur)
    {
        $moniteur->delete();
        return redirect()->route('moniteurs.index');
    }
}