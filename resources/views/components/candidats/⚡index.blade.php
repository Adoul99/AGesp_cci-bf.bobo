<?php

use App\Models\Candidat;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.app')] class extends Component {
    public $candidats;

    public function mount()
    {
        $this->candidats = Candidat::all();
    }

    public function delete($id)
    {
        Candidat::find($id)->delete();
        $this->candidats = Candidat::all();
    }
}; ?>

<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Liste des Candidats</h1>
        <a href="{{ route('candidats.create') }}" 
           class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            + Nouveau Candidat
        </a>
    </div>

    <table class="w-full border-collapse border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-3 text-left">Nom</th>
                <th class="border p-3 text-left">Prénom</th>
                <th class="border p-3 text-left">Téléphone</th>
                <th class="border p-3 text-left">Email</th>
                <th class="border p-3 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidats as $candidat)
            <tr class="hover:bg-gray-50">
                <td class="border p-3">{{ $candidat->nom }}</td>
                <td class="border p-3">{{ $candidat->prenom }}</td>
                <td class="border p-3">{{ $candidat->telephone }}</td>
                <td class="border p-3">{{ $candidat->email }}</td>
                <td class="border p-3 flex gap-2">
                    <a href="{{ route('candidats.edit', $candidat->id) }}" 
                       class="bg-yellow-500 text-white px-3 py-1 rounded">
                        Modifier
                    </a>
                    <button wire:click="delete({{ $candidat->id }})" 
                            class="bg-red-500 text-white px-3 py-1 rounded">
                        Supprimer
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>