<?php

namespace App\Http\Controllers;

use App\Models\Attestation;
use App\Models\Candidat;
use App\Models\Examen;
use Illuminate\Http\Request;

class AttestationController extends Controller
{
    public function index()
    {
        $attestations = Attestation::with(['candidat', 'examen'])->get();
        return view('attestations.index', compact('attestations'));
    }

    public function create()
    {
        $candidats = Candidat::all();
        $examens = Examen::all();
        return view('attestations.create', compact('candidats', 'examens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dateDelivrance' => 'required|date',
            'numeroAttestation' => 'required|unique:attestations',
            'candidat_id' => 'required',
        ]);

        Attestation::create($request->all());
        return redirect()->route('attestations.index');
    }

    public function edit(Attestation $attestation)
    {
        $candidats = Candidat::all();
        $examens = Examen::all();
        return view('attestations.edit', compact('attestation', 'candidats', 'examens'));
    }

    public function update(Request $request, Attestation $attestation)
    {
        $attestation->update($request->all());
        return redirect()->route('attestations.index');
    }

    public function destroy(Attestation $attestation)
    {
        $attestation->delete();
        return redirect()->route('attestations.index');
    }
}