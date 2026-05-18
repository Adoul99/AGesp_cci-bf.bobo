<x-layouts::app.sidebar title="Modifier Candidat">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier Candidat</h1>

        <form method="POST" action="{{ route('candidats.update', $candidat->id) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Nom</label>
                    <input type="text" name="nom" value="{{ $candidat->nom }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Prénom</label>
                    <input type="text" name="prenom" value="{{ $candidat->prenom }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Téléphone</label>
                    <input type="text" name="telephone" value="{{ $candidat->telephone }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-medium">Email</label>
                    <input type="email" name="email" value="{{ $candidat->email }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-medium">Date de Naissance</label>
                    <input type="date" name="dateNaissance" value="{{ $candidat->dateNaissance }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Lieu de Naissance</label>
                    <input type="text" name="lieuNaissance" value="{{ $candidat->lieuNaissance }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Numéro Permis C</label>
                    <input type="text" name="numeroPermisC" value="{{ $candidat->numeroPermisC }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Date Délivrance Permis C</label>
                    <input type="date" name="dateDelivrancePermisC" value="{{ $candidat->dateDelivrancePermisC }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Lieu Délivrance Permis C</label>
                    <input type="text" name="lieuDelivrancePermisC" value="{{ $candidat->lieuDelivrancePermisC }}" class="w-full border rounded p-2" required>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Mettre à jour
                </button>
                <a href="{{ route('candidats.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>