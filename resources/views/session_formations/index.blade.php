<x-layouts::app.sidebar title="Liste des Sessions de Formation">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Liste des Sessions de Formation</h1>
            <a href="{{ route('session_formations.create') }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Nouvelle Session
            </a>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-3 text-left">Date Début</th>
                    <th class="border p-3 text-left">Statut</th>
                    <th class="border p-3 text-left">Véhicule</th>
                    <th class="border p-3 text-left">Groupe</th>
                    <th class="border p-3 text-left">Évaluation</th>
                    <th class="border p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                <tr class="hover:bg-gray-50">
                    <td class="border p-3">{{ $session->dateDebut }}</td>
                    <td class="border p-3">{{ $session->statutSession }}</td>
                    <td class="border p-3">{{ $session->vehicule ? $session->vehicule->nomVehicule : 'N/A' }}</td>
                    <td class="border p-3">{{ $session->groupe ? $session->groupe->nomGroupe : 'N/A' }}</td>
                    <td class="border p-3">{{ $session->evaluation ? $session->evaluation->resultat : 'N/A' }}</td>
                    <td class="border p-3">
                        <div class="flex gap-2">
                            <a href="{{ route('session_formations.edit', $session->id) }}" 
                               class="bg-yellow-500 text-white px-3 py-1 rounded">
                                Modifier
                            </a>
                            <form method="POST" action="{{ route('session_formations.destroy', $session->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts::app.sidebar>