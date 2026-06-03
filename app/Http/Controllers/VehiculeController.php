<?php

namespace App\Http\Controllers;

use App\Models\Vehicule;
use App\Traits\ExportableTrait;
use Illuminate\Http\Request;

class VehiculeController extends Controller
{
    use ExportableTrait;
    public function index()
    {
        $vehicules = Vehicule::all();
        return view('vehicules.index', compact('vehicules'));
    }

    public function create()
    {
        return view('vehicules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomVehicule' => 'required',
            'modeleVehicule' => 'required',
            'immatriculation' => 'required|unique:vehicules',
        ]);

        Vehicule::create($request->all());
        return redirect()->route('vehicules.index')
                         ->with('success', 'Véhicule ajouté avec succès.');
    }

    public function edit(Vehicule $vehicule)
    {
        return view('vehicules.edit', compact('vehicule'));
    }

    public function update(Request $request, Vehicule $vehicule)
    {
        $vehicule->update($request->all());
        return redirect()->route('vehicules.index');
    }

    public function destroy(Vehicule $vehicule)
    {
        $vehicule->delete();
        return redirect()->route('vehicules.index');
    }
}