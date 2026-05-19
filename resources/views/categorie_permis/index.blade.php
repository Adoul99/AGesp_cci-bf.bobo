<x-layouts::app.sidebar title="Liste des Catégories de Permis">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Liste des Catégories de Permis</h1>
            <a href="{{ route('categorie_permis.create') }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Nouvelle Catégorie
            </a>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-3 text-left">Nom Catégorie</th>
                    <th class="border p-3 text-left">Description</th>
                    <th class="border p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $categorie)
                <tr class="hover:bg-gray-50">
                    <td class="border p-3">{{ $categorie->nomCategorie }}</td>
                    <td class="border p-3">{{ $categorie->description }}</td>
                    <td class="border p-3 flex gap-2">
                        <a href="{{ route('categorie_permis.edit', $categorie->id) }}" 
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('categorie_permis.destroy', $categorie->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts::app.sidebar>