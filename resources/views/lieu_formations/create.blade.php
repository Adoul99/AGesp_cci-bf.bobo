<x-layouts::app.sidebar title="Nouveau Lieu de Formation">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Nouveau Lieu de Formation</h1>

        <form method="POST" action="{{ route('lieu_formations.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Nom Lieu</label>
                    <input type="text" name="nomLieu" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Localisation</label>
                    <input type="text" name="localisation" class="w-full border rounded p-2" required>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Enregistrer
                </button>
                <a href="{{ route('lieu_formations.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>