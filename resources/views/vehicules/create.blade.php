<x-layouts::app.sidebar title="Nouveau Véhicule">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Nouveau Véhicule</h1>

        <form method="POST" action="{{ route('vehicules.store') }}">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Nom Véhicule</label>
                    <input type="text" name="nomVehicule" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Modèle</label>
                    <input type="text" name="modeleVehicule" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Immatriculation</label>
                    <input type="text" name="immatriculation" class="w-full border rounded p-2" required>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Enregistrer
                </button>
                <a href="{{ route('vehicules.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>