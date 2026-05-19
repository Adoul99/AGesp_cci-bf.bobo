<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Candidat;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements = Paiement::with('candidat')->get();
        return view('paiements.index', compact('paiements'));
    }

    public function create()
    {
        $candidats = Candidat::all();
        return view('paiements.create', compact('candidats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'montant' => 'required|numeric',
            'datePaiement' => 'required|date',
            'candidat_id' => 'required',
        ]);

        Paiement::create($request->all());
        return redirect()->route('paiements.index');
    }

    public function edit(Paiement $paiement)
    {
        $candidats = Candidat::all();
        return view('paiements.edit', compact('paiement', 'candidats'));
    }

    public function update(Request $request, Paiement $paiement)
    {
        $paiement->update($request->all());
        return redirect()->route('paiements.index');
    }

    public function destroy(Paiement $paiement)
    {
        $paiement->delete();
        return redirect()->route('paiements.index');
    }
}