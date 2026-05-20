<x-layouts::app.sidebar title="Modifier Session de Formation">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier Session de Formation</h1>

        <form method="POST" action="{{ route('session_formations.update', $sessionFormation->id) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Date Début</label>
                    <input type="date" name="dateDebut" value="{{ $sessionFormation->dateDebut }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Statut</label>
                    <select name="statutSession" class="w-full border rounded p-2" required>
                        <option value="ouvert" {{ $sessionFormation->statutSession == 'ouvert' ? 'selected' : '' }}>Ouvert</option>
                        <option value="ferme" {{ $sessionFormation->statutSession == 'ferme' ? 'selected' : '' }}>Fermé</option>
                        <option value="annule" {{ $sessionFormation->statutSession == 'annule' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Véhicule</label>
                    <select name="vehicule_id" class="w-full border rounded p-2">
                        <option value="">-- Choisir un véhicule --</option>
                        @foreach($vehicules as $vehicule)
                        <option value="{{ $vehicule->id }}" {{ $sessionFormation->vehicule_id == $vehicule->id ? 'selected' : '' }}>
                            {{ $vehicule->nomVehicule }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Groupe</label>
                    <select name="groupe_id" class="w-full border rounded p-2">
                        <option value="">-- Choisir un groupe --</option>
                        @foreach($groupes as $groupe)
                        <option value="{{ $groupe->id }}" {{ $sessionFormation->groupe_id == $groupe->id ? 'selected' : '' }}>
                            {{ $groupe->nomGroupe }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Évaluation</label>
                    <select name="evaluation_id" class="w-full border rounded p-2">
                        <option value="">-- Choisir une évaluation --</option>
                        @foreach($evaluations as $evaluation)
                        <option value="{{ $evaluation->id }}" {{ $sessionFormation->evaluation_id == $evaluation->id ? 'selected' : '' }}>
                            {{ $evaluation->resultat }} - {{ $evaluation->dateEvaluation }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Mettre à jour
                </button>
                <a href="{{ route('session_formations.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>