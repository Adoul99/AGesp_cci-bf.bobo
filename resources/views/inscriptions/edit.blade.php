<x-layouts::app.sidebar title="Modifier Inscription">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier Inscription</h1>

        <form method="POST" action="{{ route('inscriptions.update', $inscription->id) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Candidat</label>
                    <select name="candidat_id" class="w-full border rounded p-2" required>
                        @foreach($candidats as $candidat)
                        <option value="{{ $candidat->id }}" {{ $inscription->candidat_id == $candidat->id ? 'selected' : '' }}>
                            {{ $candidat->nom }} {{ $candidat->prenom }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Date Inscription</label>
                    <input type="date" name="dateInscription" value="{{ $inscription->dateInscription }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Statut</label>
                    <select name="statutInscription" class="w-full border rounded p-2">
                        <option value="actif" {{ $inscription->statutInscription == 'actif' ? 'selected' : '' }}>Actif</option>
                        <option value="abandon" {{ $inscription->statutInscription == 'abandon' ? 'selected' : '' }}>Abandon</option>
                        <option value="ajourne" {{ $inscription->statutInscription == 'ajourne' ? 'selected' : '' }}>Ajourné</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Date Début Formation</label>
                    <input type="date" name="dataDebut_formation" value="{{ $inscription->dataDebut_formation }}" class="w-full border rounded p-2">
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Mettre à jour
                </button>
                <a href="{{ route('inscriptions.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>