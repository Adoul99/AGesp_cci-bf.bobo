<x-layouts::app.sidebar title="Modifier Lieu de Formation">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier Lieu de Formation</h1>

        <form method="POST" action="{{ route('lieu_formations.update', $lieuFormation->id) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Nom Lieu</label>
                    <input type="text" name="nomLieu" value="{{ $lieuFormation->nomLieu }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Localisation</label>
                    <input type="text" name="localisation" value="{{ $lieuFormation->localisation }}" class="w-full border rounded p-2" required>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Mettre à jour
                </button>
                <a href="{{ route('lieu_formations.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>