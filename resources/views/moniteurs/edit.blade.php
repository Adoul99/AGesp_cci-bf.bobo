<x-layouts::app.sidebar title="Modifier Moniteur">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier Moniteur</h1>

        <form method="POST" action="{{ route('moniteurs.update', $moniteur->id) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Nom</label>
                    <input type="text" name="nom" value="{{ $moniteur->nom }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Prénom</label>
                    <input type="text" name="prenom" value="{{ $moniteur->prenom }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Téléphone</label>
                    <input type="text" name="telephone" value="{{ $moniteur->telephone }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-medium">Email</label>
                    <input type="email" name="email" value="{{ $moniteur->email }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-medium">Spécialité</label>
                    <input type="text" name="specialite" value="{{ $moniteur->specialite }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-medium">Disponibilité</label>
                    <select name="disponibilite" class="w-full border rounded p-2">
                        <option value="1" {{ $moniteur->disponibilite ? 'selected' : '' }}>Disponible</option>
                        <option value="0" {{ !$moniteur->disponibilite ? 'selected' : '' }}>Indisponible</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Mettre à jour
                </button>
                <a href="{{ route('moniteurs.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>