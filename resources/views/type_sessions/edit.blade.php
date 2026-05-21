<x-layouts::app.sidebar title="Modifier Type de Session">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier Type de Session</h1>

        <form method="POST" action="{{ route('type_sessions.update', $typeSession->id) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">ID Session</label>
                    <input type="text" name="idSession" value="{{ $typeSession->idSession }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Code</label>
                    <input type="text" name="code" value="{{ $typeSession->code }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Créneau</label>
                    <input type="text" name="creneau" value="{{ $typeSession->creneau }}" class="w-full border rounded p-2">
                </div>
                <div>
                    <label class="block font-medium">Conduite</label>
                    <input type="text" name="conduite" value="{{ $typeSession->conduite }}" class="w-full border rounded p-2">
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Mettre à jour
                </button>
                <a href="{{ route('type_sessions.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>