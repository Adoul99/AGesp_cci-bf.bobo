<x-layouts::app.sidebar title="Liste des Moniteurs">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Liste des Moniteurs</h1>
            <a href="{{ route('moniteurs.create') }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Nouveau Moniteur
            </a>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-3 text-left">Nom</th>
                    <th class="border p-3 text-left">Prénom</th>
                    <th class="border p-3 text-left">Téléphone</th>
                    <th class="border p-3 text-left">Email</th>
                    <th class="border p-3 text-left">Spécialité</th>
                    <th class="border p-3 text-left">Disponibilité</th>
                    <th class="border p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($moniteurs as $moniteur)
                <tr class="hover:bg-gray-50">
                    <td class="border p-3">{{ $moniteur->nom }}</td>
                    <td class="border p-3">{{ $moniteur->prenom }}</td>
                    <td class="border p-3">{{ $moniteur->telephone }}</td>
                    <td class="border p-3">{{ $moniteur->email }}</td>
                    <td class="border p-3">{{ $moniteur->specialite }}</td>
                    <td class="border p-3">{{ $moniteur->disponibilite ? 'Disponible' : 'Indisponible' }}</td>
                    <td class="border p-3 flex gap-2">
                        <a href="{{ route('moniteurs.edit', $moniteur->id) }}" 
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('moniteurs.destroy', $moniteur->id) }}">
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