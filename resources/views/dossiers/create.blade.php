<x-layouts::app.sidebar title="Nouveau Dossier">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Nouveau Dossier</h1>

        <form method="POST" action="{{ route('dossiers.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Nom Dossier</label>
                    <input type="text" name="nomDossier" class="w-full border rounded p-2" required>
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
                    <label class="block font-medium">Description</label>
                    <textarea name="description" class="w-full border rounded p-2" rows="3"></textarea>
                </div>
                <div>
                    <label class="block font-medium">Date Dépôt</label>
                    <input type="date" name="dateDepot" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Statut</label>
                    <select name="statutDossier" class="w-full border rounded p-2">
                        <option value="en_attente">En attente</option>
                        <option value="valide">Validé</option>
                        <option value="rejete">Rejeté</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Enregistrer
                </button>
                <a href="{{ route('dossiers.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>