<x-layouts::app.sidebar title="Modifier Reçu">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier Reçu</h1>

        <form method="POST" action="{{ route('recus.update', $recus->id) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Montant (FCFA)</label>
                    <input type="number" name="montant" value="{{ $recus->montant }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Date Reçu</label>
                    <input type="date" name="dateRecus" value="{{ $recus->dateRecus }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Paiement</label>
                    <select name="paiement_id" class="w-full border rounded p-2" required>
                        <option value="">-- Choisir un paiement --</option>
                        @foreach($paiements as $paiement)
                        <option value="{{ $paiement->id }}" {{ $recus->paiement_id == $paiement->id ? 'selected' : '' }}>
                            {{ $paiement->candidat ? $paiement->candidat->nom.' '.$paiement->candidat->prenom : 'N/A' }}
                            - {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Mettre à jour
                </button>
                <a href="{{ route('recus.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>