<x-layouts::app.sidebar title="Liste des Formations">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Liste des Formations</h1>
            <a href="{{ route('formations.create') }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Nouvelle Formation
            </a>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-3 text-left">Type</th>
                    <th class="border p-3 text-left">Date Début</th>
                    <th class="border p-3 text-left">Date Fin</th>
                    <th class="border p-3 text-left">Lieu</th>
                    <th class="border p-3 text-left">Moniteur</th>
                    <th class="border p-3 text-left">Véhicule</th>
                    <th class="border p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($formations as $formation)
                <tr class="hover:bg-gray-50">
                    <td class="border p-3">{{ $formation->typeFormation }}</td>
                    <td class="border p-3">{{ $formation->dateDebut }}</td>
                    <td class="border p-3">{{ $formation->dateFin }}</td>
                    <td class="border p-3">{{ $formation->lieu }}</td>
                    <td class="border p-3">{{ $formation->moniteur ? $formation->moniteur->nom : 'N/A' }}</td>
                    <td class="border p-3">{{ $formation->vehicule ? $formation->vehicule->nomVehicule : 'N/A' }}</td>
                    <td class="border p-3 flex gap-2">
                        <a href="{{ route('formations.edit', $formation->id) }}" 
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('formations.destroy', $formation->id) }}">
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