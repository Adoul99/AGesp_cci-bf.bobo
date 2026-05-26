<x-layouts::app.sidebar title="Modifier Programmation">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-dark: #1A1A1A; --color-gray-100: #E8E8E8; --color-gray-200: #D1D5DB;
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1); --radius-lg: 16px;
            --transition: 250ms ease;
        }
        .prog-card { background: white; border: 1px solid var(--color-gray-200); border-radius: var(--radius-lg); box-shadow: var(--shadow-md); }
        .prog-input { width: 100%; padding: 0.95rem 1rem; border: 1px solid var(--color-gray-200); border-radius: 14px; transition: border-color var(--transition), box-shadow var(--transition); }
        .prog-input:focus { outline: none; border-color: var(--color-green); box-shadow: 0 0 0 4px rgba(0, 122, 94, 0.08); }
        .prog-label { display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 700; }
        .prog-title { font-size: 1.9rem; font-weight: 800; color: var(--color-dark); margin-bottom: 0.25rem; }
        .prog-subtitle { color: #4B5563; }
        .prog-button { display: inline-flex; align-items: center; justify-content: center; padding: 0.95rem 1.5rem; border-radius: 14px; font-weight: 700; transition: transform var(--transition), box-shadow var(--transition); }
        .prog-button:hover { transform: translateY(-1px); }
        .prog-primary { background: linear-gradient(135deg, var(--color-green) 0%, #0F766E 100%); color: white; }
        .prog-secondary { background: white; color: var(--color-dark); border: 1px solid var(--color-gray-200); }
        .prog-checkbox { width: 1rem; height: 1rem; accent-color: var(--color-red); }
        .error-text { color: #B91C1C; font-size: 0.88rem; margin-top: 0.35rem; }
    </style>

    <div class="p-6">
        <div class="prog-card p-8 mb-6">
            <div class="mb-6">
                <h1 class="prog-title">Modifier la programmation</h1>
                <p class="prog-subtitle">Le formulaire utilise maintenant le même style que la page d’index.</p>
            </div>

            <form method="POST" action="{{ route('programmations.update', $programmation->id) }}">
                @csrf
                @method('PUT')

                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <label class="prog-label" for="dateDebut">Date Début</label>
                        <input id="dateDebut" type="date" name="dateDebut" value="{{ old('dateDebut', $programmation->dateDebut) }}" class="prog-input" required>
                        @error('dateDebut')<p class="error-text">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="prog-label" for="dateFin">Date Fin</label>
                        <input id="dateFin" type="date" name="dateFin" value="{{ old('dateFin', $programmation->dateFin) }}" class="prog-input" required>
                        @error('dateFin')<p class="error-text">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="prog-label" for="moniteur_id">Moniteur</label>
                        <select id="moniteur_id" name="moniteur_id" class="prog-input">
                            <option value="">-- Choisir un moniteur --</option>
                            @foreach($moniteurs as $moniteur)
                                <option value="{{ $moniteur->id }}" {{ old('moniteur_id', $programmation->moniteur_id) == $moniteur->id ? 'selected' : '' }}>
                                    {{ $moniteur->nom }} {{ $moniteur->prenom }}
                                </option>
                            @endforeach
                        </select>
                        @error('moniteur_id')<p class="error-text">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="prog-label">Candidats</label>
                        <div class="border border-gray-200 rounded-2xl p-4 grid grid-cols-1 sm:grid-cols-2 gap-3 max-h-64 overflow-y-auto">
                            @foreach($candidats as $candidat)
                                <label class="flex items-center gap-3 cursor-pointer rounded-xl border border-transparent hover:border-gray-200 p-3 transition">
                                    <input type="checkbox" name="candidat_ids[]" value="{{ $candidat->id }}" class="prog-checkbox" {{ in_array($candidat->id, old('candidat_ids', $candidatsSelectionnes)) ? 'checked' : '' }}>
                                    <span>{{ $candidat->nom }} {{ $candidat->prenom }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('candidat_ids')<p class="error-text">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row sm:justify-end gap-4">
                    <a href="{{ route('programmations.index') }}" class="prog-button prog-secondary w-full sm:w-auto">Annuler</a>
                    <button type="submit" class="prog-button prog-primary w-full sm:w-auto">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app.sidebar>