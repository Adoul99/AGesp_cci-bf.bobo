<x-layouts::app.sidebar title="Nouveau Reçu">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Nouveau Reçu</h1>

        <form method="POST" action="{{ route('recus.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Montant (FCFA)</label>
                    <input type="number" name="montant" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Date Reçu</label>
                    <input type="date" name="dateRecus" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Paiement</label>
                    <select name="paiement_id" class="w-full border rounded p-2" required>
                        <option value="">-- Choisir un paiement --</option>
                        @foreach($paiements as $paiement)
                        <option value="{{ $paiement->id }}">
                            {{ $paiement->candidat ? $paiement->candidat->nom.' '.$paiement->candidat->prenom : 'N/A' }}
                            - {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Enregistrer
                </button>
                <a href="{{ route('recus.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>