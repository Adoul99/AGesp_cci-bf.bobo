<x-layouts::app.sidebar title="Modifier Attestation">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier Attestation</h1>

        <form method="POST" action="{{ route('attestations.update', $attestation->id) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Numéro Attestation</label>
                    <input type="text" name="numeroAttestation" value="{{ $attestation->numeroAttestation }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Date Délivrance</label>
                    <input type="date" name="dateDelivrance" value="{{ $attestation->dateDelivrance }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Candidat</label>
                    <select name="candidat_id" class="w-full border rounded p-2" required>
                        @foreach($candidats as $candidat)
                        <option value="{{ $candidat->id }}" {{ $attestation->candidat_id == $candidat->id ? 'selected' : '' }}>
                            {{ $candidat->nom }} {{ $candidat->prenom }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Examen</label>
                    <select name="examen_id" class="w-full border rounded p-2">
                        <option value="">-- Choisir un examen --</option>
                        @foreach($examens as $examen)
                        <option value="{{ $examen->id }}" {{ $attestation->examen_id == $examen->id ? 'selected' : '' }}>
                            {{ $examen->libelle }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Mettre à jour
                </button>
                <a href="{{ route('attestations.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>