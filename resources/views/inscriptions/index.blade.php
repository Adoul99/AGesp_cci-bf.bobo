<x-layouts::app.sidebar title="Liste des Inscriptions">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Liste des Inscriptions</h1>
            <a href="{{ route('inscriptions.create') }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Nouvelle Inscription
            </a>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-3 text-left">Candidat</th>
                    <th class="border p-3 text-left">Date Inscription</th>
                    <th class="border p-3 text-left">Statut</th>
                    <th class="border p-3 text-left">Début Formation</th>
                    <th class="border p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inscriptions as $inscription)
                <tr class="hover:bg-gray-50">
                    <td class="border p-3">{{ $inscription->candidat->nom }} {{ $inscription->candidat->prenom }}</td>
                    <td class="border p-3">{{ $inscription->dateInscription }}</td>
                    <td class="border p-3">{{ $inscription->statutInscription }}</td>
                    <td class="border p-3">{{ $inscription->dataDebut_formation }}</td>
                    <td class="border p-3 flex gap-2">
                        <a href="{{ route('inscriptions.edit', $inscription->id) }}" 
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('inscriptions.destroy', $inscription->id) }}">
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