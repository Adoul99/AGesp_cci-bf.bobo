<x-layouts::app.sidebar title="Nouvelle Catégorie de Permis">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Nouvelle Catégorie de Permis</h1>

        <form method="POST" action="{{ route('categorie_permis.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Nom Catégorie</label>
                    <input type="text" name="nomCategorie" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Description</label>
                    <textarea name="description" class="w-full border rounded p-2" rows="3"></textarea>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Enregistrer
                </button>
                <a href="{{ route('categorie_permis.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>