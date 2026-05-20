<?php

namespace App\Http\Controllers;

use App\Models\Recus;
use App\Models\Paiement;
use Illuminate\Http\Request;

class RecusController extends Controller
{
    /**
     * Affiche la liste de tous les reçus
     */
    public function index()
    {
        $recus = Recus::with('paiement')->get();
        return view('recus.index', compact('recus'));
    }

    /**
     * Affiche le formulaire de création d'un nouveau reçu
     */
    public function create()
    {
        $paiements = Paiement::with('candidat')->get();
        return view('recus.create', compact('paiements'));
    }

    /**
     * Enregistre un nouveau reçu dans la base de données
     */
    public function store(Request $request)
    {
        // Validation des données du formulaire
        $request->validate([
            'montant' => 'required|numeric',
            'dateRecus' => 'required|date',
            'paiement_id' => 'required',
        ]);

        // Création du reçu
        Recus::create($request->all());
        return redirect()->route('recus.index');
    }

    /**
     * Affiche le formulaire de modification d'un reçu
     */
    public function edit(Recus $recus)
    {
        $paiements = Paiement::with('candidat')->get();
        return view('recus.edit', compact('recus', 'paiements'));
    }

    /**
     * Met à jour un reçu existant
     */
    public function update(Request $request, Recus $recus)
    {
        $recus->update($request->all());
        return redirect()->route('recus.index');
    }

    /**
     * Supprime un reçu de la base de données
     */
    public function destroy(Recus $recus)
    {
        $recus->delete();
        return redirect()->route('recus.index');
    }
}