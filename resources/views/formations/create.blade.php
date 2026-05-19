<x-layouts::app.sidebar title="Nouvelle Formation">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Nouvelle Formation</h1>

        <form method="POST" action="{{ route('formations.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Type Formation</label>
                    <select name="typeFormation" class="w-full border rounded p-2" required>
                        <option value="theorique">Théorique</option>
                        <option value="pratique">Pratique</option>
                        <option value="mixte">Mixte</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Lieu</label>
                    <input type="text" name="lieu" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-medium">Date Début</label>
                    <input type="date" name="dateDebut" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Date Fin</label>
                    <input type="date" name="dateFin" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Moniteur</label>
                    <select name="moniteur_id" class="w-full border rounded p-2">
                        <option value="">-- Choisir un moniteur --</option>
                        @foreach($moniteurs as $moniteur)
                        <option value="{{ $moniteur->id }}">{{ $moniteur->nom }} {{ $moniteur->prenom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Véhicule</label>
                    <select name="vehicule_id" class="w-full border rounded p-2">
                        <option value="">-- Choisir un véhicule --</option>
                        @foreach($vehicules as $vehicule)
                        <option value="{{ $vehicule->id }}">{{ $vehicule->nomVehicule }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Enregistrer
                </button>
                <a href="{{ route('formations.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>