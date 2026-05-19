<x-layouts::app.sidebar title="Nouveau Paiement">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Nouveau Paiement</h1>

        <form method="POST" action="{{ route('paiements.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Candidat</label>
                    <select name="candidat_id" class="w-full border rounded p-2" required>
                        <option value="">-- Choisir un candidat --</option>
                        @foreach($candidats as $candidat)
                        <option value="{{ $candidat->id }}">{{ $candidat->nom }} {{ $candidat->prenom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Montant (FCFA)</label>
                    <input type="number" name="montant" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Date Paiement</label>
                    <input type="date" name="datePaiement" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Statut</label>
                    <select name="statut" class="w-full border rounded p-2">
                        <option value="en_attente">En attente</option>
                        <option value="paye">Payé</option>
                        <option value="annule">Annulé</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Enregistrer
                </button>
                <a href="{{ route('paiements.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>