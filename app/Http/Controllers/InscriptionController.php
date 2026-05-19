<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Candidat;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    public function index()
    {
        $inscriptions = Inscription::with('candidat')->get();
        return view('inscriptions.index', compact('inscriptions'));
    }

    public function create()
    {
        $candidats = Candidat::all();
        return view('inscriptions.create', compact('candidats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dateInscription' => 'required|date',
            'candidat_id' => 'required',
        ]);

        Inscription::create($request->all());
        return redirect()->route('inscriptions.index');
    }

    public function edit(Inscription $inscription)
    {
        $candidats = Candidat::all();
        return view('inscriptions.edit', compact('inscription', 'candidats'));
    }

    public function update(Request $request, Inscription $inscription)
    {
        $inscription->update($request->all());
        return redirect()->route('inscriptions.index');
    }

    public function destroy(Inscription $inscription)
    {
        $inscription->delete();
        return redirect()->route('inscriptions.index');
    }
}