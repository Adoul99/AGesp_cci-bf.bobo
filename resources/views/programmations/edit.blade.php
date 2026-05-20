<x-layouts::app.sidebar title="Modifier Programmation">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier Programmation</h1>

        <form method="POST" action="{{ route('programmations.update', $programmation->id) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Date Début</label>
                    <input type="date" name="dateDebut" value="{{ $programmation->dateDebut }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Date Fin</label>
                    <input type="date" name="dateFin" value="{{ $programmation->dateFin }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Moniteur</label>
                    <select name="moniteur_id" class="w-full border rounded p-2">
                        <option value="">-- Choisir un moniteur --</option>
                        @foreach($moniteurs as $moniteur)
                        <option value="{{ $moniteur->id }}" {{ $programmation->moniteur_id == $moniteur->id ? 'selected' : '' }}>
                            {{ $moniteur->nom }} {{ $moniteur->prenom }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block font-medium mb-2">Candidats</label>
                    <div class="border rounded p-3 grid grid-cols-2 gap-2 max-h-48 overflow-y-auto">
                        @foreach($candidats as $candidat)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="candidat_ids[]" value="{{ $candidat->id }}"
                                       {{ in_array($candidat->id, $candidatsSelectionnes) ? 'checked' : '' }}
                                       class="w-4 h-4">
                                {{ $candidat->nom }} {{ $candidat->prenom }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Mettre à jour
                </button>
                <a href="{{ route('programmations.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>