<x-layouts::app.sidebar title="Modifier Paiement">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier Paiement</h1>

        <form method="POST" action="{{ route('paiements.update', $paiement->id) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Candidat</label>
                    <select name="candidat_id" class="w-full border rounded p-2" required>
                        @foreach($candidats as $candidat)
                        <option value="{{ $candidat->id }}" {{ $paiement->candidat_id == $candidat->id ? 'selected' : '' }}>
                            {{ $candidat->nom }} {{ $candidat->prenom }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Montant (FCFA)</label>
                    <input type="number" name="montant" value="{{ $paiement->montant }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Date Paiement</label>
                    <input type="date" name="datePaiement" value="{{ $paiement->datePaiement }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Statut</label>
                    <select name="statut" class="w-full border rounded p-2">
                        <option value="en_attente" {{ $paiement->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="paye" {{ $paiement->statut == 'paye' ? 'selected' : '' }}>Payé</option>
                        <option value="annule" {{ $paiement->statut == 'annule' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Mettre à jour
                </button>
                <a href="{{ route('paiements.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>