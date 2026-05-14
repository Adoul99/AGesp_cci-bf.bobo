<x-layouts::app.sidebar title="Nouveau Candidat">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Nouveau Candidat</h1>

        <form method="POST" action="{{ route('candidats.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Nom</label>
                    <input type="text" name="nom" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Prenom</label>
                    <input type="text" name="prenom" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Telephone</label>
                    <input type="text" name="telephone" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-medium">Email</label>
                    <input type="email" name="email" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-medium">Date de Naissance</label>
                    <input type="date" name="dateNaissance" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Lieu de Naissance</label>
                    <input type="text" name="lieuNaissance" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Numero Permis C</label>
                    <input type="text" name="numeroPermisC" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Date de Delivrance Permis C</label>
                    <input type="date" name="dateDelivrancePermisC" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Lieu de Delivrance Permis C</label>
                    <input type="text" name="lieuDelivrancePermisC" class="w-full border rounded p-2" required>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Enregistrer
                </button>
                <a href="{{ route('candidats.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>