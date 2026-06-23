<?php

namespace App\Http\Controllers;

use App\Models\Dossier;
use App\Models\Candidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DossierController extends Controller
{
    private $fileFields = ['cnib', 'photo_identite', 'certificat_medical', 'acte_naissance', 'recu_paiement', 'permis_c'];

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
            'cnib' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'photo_identite' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'certificat_medical' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'acte_naissance' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'recu_paiement' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'permis_c' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except($this->fileFields);

        foreach ($this->fileFields as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('dossiers', 'public');
            }
        }

        Dossier::create($data);
        return redirect()->route('dossiers.index')->with('success', 'Dossier créé avec succès.');
    }

    public function edit(Dossier $dossier)
    {
        $candidats = Candidat::all();
        return view('dossiers.edit', compact('dossier', 'candidats'));
    }

    public function update(Request $request, Dossier $dossier)
    {
        $request->validate([
            'nomDossier'        => 'required',
            'dateDepot'         => 'required|date',
            'candidat_id'       => 'required',
            'statutDossier'     => 'nullable|in:en_attente,valide,rejete',
            'commentaireAdmin'  => 'nullable|string|max:1000',
        ]);

        $data = $request->except($this->fileFields);

        foreach ($this->fileFields as $field) {
            if ($request->hasFile($field)) {
                if ($dossier->$field) {
                    Storage::disk('public')->delete($dossier->$field);
                }
                $data[$field] = $request->file($field)->store('dossiers', 'public');
            }
        }

        $dossier->update($data);
        return redirect()->route('dossiers.index')->with('success', 'Dossier mis à jour.');
    }

    public function destroy(Dossier $dossier)
    {
        foreach ($this->fileFields as $field) {
            if ($dossier->$field) {
                Storage::disk('public')->delete($dossier->$field);
            }
        }
        $dossier->delete();
        return redirect()->route('dossiers.index')->with('success', 'Dossier supprimé.');
    }
}