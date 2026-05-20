<x-layouts::app.sidebar title="Modifier Groupe">
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-6">Modifier Groupe</h1>

        <form method="POST" action="{{ route('groupes.update', $groupe->id) }}">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium">Nom Groupe</label>
                    <input type="text" name="nomGroupe" value="{{ $groupe->nomGroupe }}" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium">Date Début Formation</label>
                    <input type="date" name="dateDebutFormation" value="{{ $groupe->dateDebutFormation }}" class="w-full border rounded p-2" required>
                </div>
                <div class="col-span-2">
                    <label class="block font-medium mb-2">Candidats</label>
                    <div class="border rounded p-3 grid grid-cols-2 gap-2 max-h-48 overflow-y-auto">
                        @foreach($candidats as $candidat)
                            @php
                                $groupeExistant = $candidat->groupes->first();
                                $dejaDansGroupe = $groupeExistant && $groupeExistant->id != $groupe->id;
                            @endphp
                            @if($dejaDansGroupe)
                                <label class="flex items-center gap-2 cursor-not-allowed opacity-50">
                                    <input type="checkbox" disabled class="w-4 h-4">
                                    {{ $candidat->nom }} {{ $candidat->prenom }}
                                    <span class="text-red-500 text-xs">(Déjà dans {{ $groupeExistant->nomGroupe }})</span>
                                </label>
                            @else
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" name="candidat_ids[]" value="{{ $candidat->id }}"
                                           {{ in_array($candidat->id, $candidatsSelectionnes) ? 'checked' : '' }}
                                           class="w-4 h-4">
                                    {{ $candidat->nom }} {{ $candidat->prenom }}
                                </label>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600">
                    Mettre à jour
                </button>
                <a href="{{ route('groupes.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>