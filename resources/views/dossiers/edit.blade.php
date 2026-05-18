<x-layouts::app.sidebar title="Modifier Dossier">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier Dossier</h1>

        <form method="POST" action="{{ route('dossiers.update', $dossier->id) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Nom Dossier</label>
                    <input type="text" name="nomDossier" value="{{ $dossier->nomDossier }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Candidat</label>
                    <select name="candidat_id" class="w-full border rounded p-2" required>
                        @foreach($candidats as $candidat)
                        <option value="{{ $candidat->id }}" {{ $dossier->candidat_id == $candidat->id ? 'selected' : '' }}>
                            {{ $candidat->nom }} {{ $candidat->prenom }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Description</label>
                    <textarea name="description" class="w-full border rounded p-2" rows="3">{{ $dossier->description }}</textarea>
                </div>
                <div>
                    <label class="block font-medium">Date Dépôt</label>
                    <input type="date" name="dateDepot" value="{{ $dossier->dateDepot }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Statut</label>
                    <select name="statutDossier" class="w-full border rounded p-2">
                        <option value="en_attente" {{ $dossier->statutDossier == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="valide" {{ $dossier->statutDossier == 'valide' ? 'selected' : '' }}>Validé</option>
                        <option value="rejete" {{ $dossier->statutDossier == 'rejete' ? 'selected' : '' }}>Rejeté</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Mettre à jour
                </button>
                <a href="{{ route('dossiers.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>