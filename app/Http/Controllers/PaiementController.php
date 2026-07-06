<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Candidat;
use App\Models\Recus;
use App\Traits\ExportableTrait;
use Illuminate\Http\Request;

class PaiementController extends Controller
{
    use ExportableTrait;

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
            'montant'      => 'required|numeric',
            'datePaiement' => 'required|date',
            'candidat_id'  => 'required',
            'statut'       => 'required|in:en_attente,paye,annule',
        ]);

        $paiement = Paiement::create($request->all());

        // Génération automatique du reçu uniquement si le paiement est marqué "payé"
        if ($paiement->statut === 'paye') {
            Recus::create([
                'numero_recu' => Recus::genererNumero(),
                'montant'     => $paiement->montant,
                'dateRecus'   => $paiement->datePaiement,
                'paiement_id' => $paiement->id,
            ]);
        }

        $message = $paiement->statut === 'paye'
            ? '✅ Paiement enregistré et reçu généré automatiquement.'
            : '✅ Paiement enregistré.';

        return redirect()->route('paiements.index')->with('success', $message);
    }

    public function edit(Paiement $paiement)
    {
        $candidats = Candidat::all();
        return view('paiements.edit', compact('paiement', 'candidats'));
    }

    public function update(Request $request, Paiement $paiement)
    {
        $request->validate([
            'montant'      => 'required|numeric',
            'datePaiement' => 'required|date',
            'candidat_id'  => 'required',
            'statut'       => 'required|in:en_attente,paye,annule',
        ]);

        $etaitPaye = $paiement->statut === 'paye';

        $paiement->update($request->all());

        $estMaintenantPaye = $paiement->statut === 'paye';

        if (!$etaitPaye && $estMaintenantPaye) {
            // Le paiement vient de passer à "payé" → on génère le reçu
            if (!$paiement->recus) {
                Recus::create([
                    'numero_recu' => Recus::genererNumero(),
                    'montant'     => $paiement->montant,
                    'dateRecus'   => $paiement->datePaiement,
                    'paiement_id' => $paiement->id,
                ]);
            }
        } elseif ($estMaintenantPaye && $paiement->recus) {
            // Toujours payé, on garde le reçu synchronisé (montant/date à jour)
            $paiement->recus->update([
                'montant'   => $paiement->montant,
                'dateRecus' => $paiement->datePaiement,
            ]);
        }

        return redirect()->route('paiements.index')
            ->with('success', '✅ Paiement mis à jour.');
    }

    public function destroy(Paiement $paiement)
    {
        $paiement->delete();
        return redirect()->route('paiements.index')
            ->with('success', '✅ Paiement supprimé.');
    }
}