<x-layouts::app.sidebar title="Liste des Reçus">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Liste des Reçus</h1>
            <a href="{{ route('recus.create') }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Nouveau Reçu
            </a>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-3 text-left">Montant</th>
                    <th class="border p-3 text-left">Date Reçu</th>
                    <th class="border p-3 text-left">Paiement</th>
                    <th class="border p-3 text-left">Candidat</th>
                    <th class="border p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recus as $recu)
                <tr class="hover:bg-gray-50">
                    <td class="border p-3">{{ number_format($recu->montant, 0, ',', ' ') }} FCFA</td>
                    <td class="border p-3">{{ $recu->dateRecus }}</td>
                    <td class="border p-3">{{ $recu->paiement ? number_format($recu->paiement->montant, 0, ',', ' ').' FCFA' : 'N/A' }}</td>
                    <td class="border p-3">{{ $recu->paiement && $recu->paiement->candidat ? $recu->paiement->candidat->nom.' '.$recu->paiement->candidat->prenom : 'N/A' }}</td>
                    <td class="border p-3">
                        <div class="flex gap-2">
                            <a href="{{ route('recus.edit', $recu->id) }}" 
                               class="bg-yellow-500 text-white px-3 py-1 rounded">
                                Modifier
                            </a>
                            <form method="POST" action="{{ route('recus.destroy', $recu->id) }}">
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