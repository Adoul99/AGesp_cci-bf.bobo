<?php

namespace App\Http\Controllers;

use App\Models\Recus;
use App\Models\Paiement;
use Illuminate\Http\Request;

class RecusController extends Controller
{
    public function index()
    {
        $recus = Recus::with('paiement.candidat')->latest()->get();
        return view('recus.index', compact('recus'));
    }

    public function create()
    {
        $paiements = Paiement::with('candidat')->get();
        return view('recus.create', compact('paiements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'montant'        => 'required|numeric|min:0',
            'dateRecus'      => 'required|date',
            'paiement_id'    => 'required|exists:paiements,id',
            'recus_paiement' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $cheminFichier = null;
        if ($request->hasFile('recus_paiement')) {
            $cheminFichier = $request->file('recus_paiement')
                ->store('recus_paiements', 'public');
        }

        Recus::create([
            'numero_recu'    => Recus::genererNumero(),
            'montant'        => $request->montant,
            'dateRecus'      => $request->dateRecus,
            'paiement_id'    => $request->paiement_id,
            'recus_paiement' => $cheminFichier,
        ]);

        return redirect()->route('recus.index')
            ->with('success', '✅ Reçu créé avec succès.');
    }

    public function show(Recus $recus)
    {
        $recus->load('paiement.candidat');
        return view('recus.show', compact('recus'));
    }

    public function edit(Recus $recus)
    {
        $paiements = Paiement::with('candidat')->get();
        return view('recus.edit', compact('recus', 'paiements'));
    }

    public function update(Request $request, Recus $recus)
    {
        $request->validate([
            'montant'        => 'required|numeric|min:0',
            'dateRecus'      => 'required|date',
            'paiement_id'    => 'required|exists:paiements,id',
            'recus_paiement' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $cheminFichier = $recus->recus_paiement; // garder l'ancien si pas de nouveau
        if ($request->hasFile('recus_paiement')) {
            // Supprimer l'ancien fichier si existant
            if ($cheminFichier && \Storage::disk('public')->exists($cheminFichier)) {
                \Storage::disk('public')->delete($cheminFichier);
            }
            $cheminFichier = $request->file('recus_paiement')
                ->store('recus_paiements', 'public');
        }

        $recus->update([
            'montant'        => $request->montant,
            'dateRecus'      => $request->dateRecus,
            'paiement_id'    => $request->paiement_id,
            'recus_paiement' => $cheminFichier,
        ]);

        return redirect()->route('recus.index')
            ->with('success', '✅ Reçu mis à jour.');
    }

    public function destroy(Recus $recus)
    {
        $recus->delete();
        return redirect()->route('recus.index')
            ->with('success', '✅ Reçu supprimé.');
    }
}
