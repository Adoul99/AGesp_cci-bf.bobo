<x-layouts::app.sidebar title="Liste des Paiements">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Liste des Paiements</h1>
            <a href="{{ route('paiements.create') }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Nouveau Paiement
            </a>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-3 text-left">Candidat</th>
                    <th class="border p-3 text-left">Montant</th>
                    <th class="border p-3 text-left">Date Paiement</th>
                    <th class="border p-3 text-left">Statut</th>
                    <th class="border p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paiements as $paiement)
                <tr class="hover:bg-gray-50">
                    <td class="border p-3">{{ $paiement->candidat->nom }} {{ $paiement->candidat->prenom }}</td>
                    <td class="border p-3">{{ number_format($paiement->montant, 0, ',', ' ') }} FCFA</td>
                    <td class="border p-3">{{ $paiement->datePaiement }}</td>
                    <td class="border p-3">{{ $paiement->statut }}</td>
                    <td class="border p-3 flex gap-2">
                        <a href="{{ route('paiements.edit', $paiement->id) }}" 
                           class="bg-yellow-500 text-white px-3 py-1 rounded">
                            Modifier
                        </a>
                        <form method="POST" action="{{ route('paiements.destroy', $paiement->id) }}">
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