<x-layouts::app.sidebar title="Liste des Types de Session">
    <div class="p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Liste des Types de Session</h1>
            <a href="{{ route('type_sessions.create') }}" 
               class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Nouveau Type
            </a>
        </div>

        <table class="w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-3 text-left">ID Session</th>
                    <th class="border p-3 text-left">Code</th>
                    <th class="border p-3 text-left">Créneau</th>
                    <th class="border p-3 text-left">Conduite</th>
                    <th class="border p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($types as $type)
                <tr class="hover:bg-gray-50">
                    <td class="border p-3">{{ $type->idSession }}</td>
                    <td class="border p-3">{{ $type->code }}</td>
                    <td class="border p-3">{{ $type->creneau }}</td>
                    <td class="border p-3">{{ $type->conduite }}</td>
                    <td class="border p-3">
                        <div class="flex gap-2">
                            <a href="{{ route('type_sessions.edit', $type->id) }}" 
                               class="bg-yellow-500 text-white px-3 py-1 rounded">
                                Modifier
                            </a>
                            <form method="POST" action="{{ route('type_sessions.destroy', $type->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts::app.sidebar>