<x-layouts::app.sidebar title="Nouvelle Évaluation">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Nouvelle Évaluation</h1>

        <form method="POST" action="{{ route('evaluations.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Date Évaluation</label>
                    <input type="date" name="dateEvaluation" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Résultat</label>
                    <select name="resultat" class="w-full border rounded p-2" required>
                        <option value="">-- Choisir un résultat --</option>
                        <option value="Admis">Admis</option>
                        <option value="Ajourné">Ajourné</option>
                        <option value="Absent">Absent</option>
                        <option value="Eliminé">Eliminé</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Statut</label>
                    <select name="statut" class="w-full border rounded p-2" required>
                        <option value="en_attente">En attente</option>
                        <option value="reussi">Réussi</option>
                        <option value="echoue">Échoué</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Moniteur</label>
                    <select name="moniteur_id" class="w-full border rounded p-2">
                        <option value="">-- Choisir un moniteur --</option>
                        @foreach($moniteurs as $moniteur)
                        <option value="{{ $moniteur->id }}">{{ $moniteur->nom }} {{ $moniteur->prenom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Enregistrer
                </button>
                <a href="{{ route('evaluations.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>