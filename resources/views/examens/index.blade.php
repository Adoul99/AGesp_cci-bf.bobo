<x-layouts::app.sidebar title="Liste des Examens">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Liste des Examens</h1>
            <a href="{{ route('examens.create') }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Nouvel Examen
            </a>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-3 text-left">Libellé</th>
                    <th class="border p-3 text-left">Date Début</th>
                    <th class="border p-3 text-left">Date Fin</th>
                    <th class="border p-3 text-left">Statut</th>
                    <th class="border p-3 text-left">Moniteur</th>
                    <th class="border p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($examens as $examen)
                <tr class="hover:bg-gray-50">
                    <td class="border p-3">{{ $examen->libelle }}</td>
                    <td class="border p-3">{{ $examen->dateDebut }}</td>
                    <td class="border p-3">{{ $examen->dateFin }}</td>
                    <td class="border p-3">{{ $examen->statutExamen }}</td>
                    <td class="border p-3">{{ $examen->moniteur ? $examen->moniteur->nom : 'N/A' }}</td>
                    <td class="border p-3 flex gap-2">
                        <a href="{{ route('examens.edit', $examen->id) }}" 
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('examens.destroy', $examen->id) }}">
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