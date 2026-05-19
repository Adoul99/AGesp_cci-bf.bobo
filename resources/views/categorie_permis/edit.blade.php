<x-layouts::app.sidebar title="Modifier Catégorie de Permis">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier Catégorie de Permis</h1>

        <form method="POST" action="{{ route('categorie_permis.update', $categoriePermis->id) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Nom Catégorie</label>
                    <input type="text" name="nomCategorie" value="{{ $categoriePermis->nomCategorie }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Description</label>
                    <textarea name="description" class="w-full border rounded p-2" rows="3">{{ $categoriePermis->description }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Mettre à jour
                </button>
                <a href="{{ route('categorie_permis.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>