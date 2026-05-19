<x-layouts::app.sidebar title="Nouvelle Attestation">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Nouvelle Attestation</h1>

        <form method="POST" action="{{ route('attestations.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Numéro Attestation</label>
                    <input type="text" name="numeroAttestation" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Date Délivrance</label>
                    <input type="date" name="dateDelivrance" class="w-full border rounded p-2" required>
                </div>
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
                    <label class="block font-medium">Examen</label>
                    <select name="examen_id" class="w-full border rounded p-2">
                        <option value="">-- Choisir un examen --</option>
                        @foreach($examens as $examen)
                        <option value="{{ $examen->id }}">{{ $examen->libelle }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Enregistrer
                </button>
                <a href="{{ route('attestations.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>