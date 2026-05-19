<x-layouts::app.sidebar title="Nouvel Examen">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Nouvel Examen</h1>

        <form method="POST" action="{{ route('examens.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Libellé</label>
                    <input type="text" name="libelle" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Statut</label>
                    <select name="statutExamen" class="w-full border rounded p-2">
                        <option value="en_attente">En attente</option>
                        <option value="admis">Admis</option>
                        <option value="ajourne">Ajourné</option>
                        <option value="abandon">Abandon</option>
                    </select>
                </div>
                <div>
                    <label class="block font-medium">Date Début</label>
                    <input type="date" name="dateDebut" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Date Fin</label>
                    <input type="date" name="dateFin" class="w-full border rounded p-2" required>
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
                <a href="{{ route('examens.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>