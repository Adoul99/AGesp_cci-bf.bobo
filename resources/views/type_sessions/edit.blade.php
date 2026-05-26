<x-layouts::app.sidebar title="Modifier Type de Session">
    <style>
        :root {
            --card-bg: #ffffff;
            --card-border: #E5E7EB;
            --card-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            --accent: #10B981;
            --text-dark: #111827;
            --text-muted: #6B7280;
            --radius: 20px;
            --transition: 250ms ease;
        }
        .form-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: var(--radius); box-shadow: var(--card-shadow); }
        .form-input { width: 100%; padding: 1rem 1.1rem; border: 1px solid #D1D5DB; border-radius: 14px; transition: border-color var(--transition), box-shadow var(--transition); }
        .form-input:focus { border-color: var(--accent); box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.16); outline: none; }
        .form-select { appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%230B6F51'%3E%3Cpath d='M5.5 7.5l4.5 4.5 4.5-4.5'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 1rem center; background-size: 12px 12px; }
        .form-label { display: block; margin-bottom: 0.5rem; color: var(--text-dark); font-weight: 700; }
        .form-title { font-size: 1.95rem; font-weight: 800; color: var(--text-dark); margin-bottom: 0.5rem; }
        .form-subtitle { color: var(--text-muted); }
        .btn-primary { background: linear-gradient(135deg, #10B981 0%, #047857 100%); color: white; }
        .btn-secondary { background: white; color: var(--text-dark); border: 1px solid #D1D5DB; }
        .button { display: inline-flex; align-items: center; justify-content: center; padding: 0.95rem 1.8rem; gap: 0.5rem; border-radius: 14px; font-weight: 700; transition: transform var(--transition), box-shadow var(--transition); }
        .button:hover { transform: translateY(-1px); }
        .error-text { color: #B91C1C; font-size: 0.88rem; margin-top: 0.35rem; }
    </style>

    <div class="p-6">
        <div class="form-card p-8 mb-6">
            <div class="mb-6">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-emerald-600">Modification</p>
                <h1 class="form-title">Modifier le type de session</h1>
                <p class="form-subtitle">Mettez à jour le type choisi et ajustez ses paramètres.</p>
            </div>

            <form method="POST" action="{{ route('type_sessions.update', $typeSession->id) }}">
                @csrf
                @method('PUT')
                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <label class="form-label" for="idSession">ID Session</label>
                        <input id="idSession" type="text" name="idSession" value="{{ old('idSession', $typeSession->idSession) }}" class="form-input" required>
                        @error('idSession')<p class="error-text">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label" for="code">Type de session</label>
                        <select id="code" name="code" class="form-input form-select" required>
                            <option value="">-- Choisir un type --</option>
                            @foreach($typeCodes as $value => $label)
                                <option value="{{ $value }}" {{ old('code', $typeSession->code) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('code')<p class="error-text">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label" for="creneau">Créneau</label>
                        <input id="creneau" type="text" name="creneau" value="{{ old('creneau', $typeSession->creneau) }}" class="form-input" required>
                        @error('creneau')<p class="error-text">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="form-label" for="conduite">Conduite (optionnel)</label>
                        <input id="conduite" type="text" name="conduite" value="{{ old('conduite', $typeSession->conduite) }}" class="form-input">
                        @error('conduite')<p class="error-text">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row sm:justify-end gap-4">
                    <a href="{{ route('type_sessions.index') }}" class="button btn-secondary w-full sm:w-auto">Annuler</a>
                    <button type="submit" class="button btn-primary w-full sm:w-auto">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::app.sidebar>