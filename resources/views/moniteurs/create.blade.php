<x-layouts::app title="Nouveau Moniteur">
<style>
    .form-page {
        font-family: 'Segoe UI', sans-serif;
        background: #f0f2f5;
        min-height: 100vh;
        padding: 24px;
    }

    .page-header-card {
        background: #fff;
        border-radius: 6px;
        padding: 20px 28px;
        margin-bottom: 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        border-left: 4px solid #c0392b;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }

    .form-card {
        background: #fff;
        border-radius: 6px;
        padding: 28px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        border: 1px solid #e0e3e8;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0 0 20px 0;
        padding-bottom: 10px;
        border-bottom: 1px solid #eef0f3;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-title::before {
        content: '';
        display: inline-block;
        width: 4px;
        height: 18px;
        background: #2e7d6e;
        border-radius: 2px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .form-label {
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #4a5568;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .required-star { color: #c0392b; font-size: 0.9rem; }

    .form-input, .form-select {
        width: 100%;
        border: 1.5px solid #d1d5db;
        border-radius: 4px;
        padding: 9px 12px;
        font-size: 0.88rem;
        color: #1a1a2e;
        background: #fafbfc;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        box-sizing: border-box;
    }
    .form-input:focus, .form-select:focus {
        border-color: #2e7d6e;
        box-shadow: 0 0 0 3px rgba(46,125,110,0.12);
        background: #fff;
    }
    .form-input::placeholder { color: #9ca3af; font-style: italic; }

    .form-actions { display: flex; gap: 12px; padding-top: 8px; }

    .btn-save {
        background: #c0392b;
        color: #fff;
        border: none;
        padding: 10px 28px;
        border-radius: 4px;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        cursor: pointer;
        transition: background 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }
    .btn-save:hover { background: #a93226; }

    .btn-cancel {
        background: #6b7280;
        color: #fff;
        border: none;
        padding: 10px 28px;
        border-radius: 4px;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }
    .btn-cancel:hover { background: #4b5563; color: #fff; }

    .info-banner {
        background: #e8f4fd;
        border: 1px solid #bee3f8;
        border-radius: 5px;
        padding: 11px 16px;
        font-size: 0.82rem;
        color: #2b6cb0;
        display: flex;
        align-items: flex-start;
        gap: 8px;
    }

    .field-error { color: #c0392b; font-size: 0.76rem; margin-top: 2px; }
</style>

<div class="form-page">
    <div class="page-header-card">
        <h1 class="page-title">| Nouveau Moniteur</h1>
    </div>

    <div class="form-card">
        <h2 class="section-title">Informations Générales</h2>

        <form method="POST" action="{{ route('moniteurs.store') }}">
            @csrf
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nom <span class="required-star">*</span></label>
                    <input type="text" name="nom" class="form-input" placeholder="Ex: KONÉ" value="{{ old('nom') }}" required>
                    @error('nom')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Prénom <span class="required-star">*</span></label>
                    <input type="text" name="prenom" class="form-input" placeholder="Ex: Yacouba" value="{{ old('prenom') }}" required>
                    @error('prenom')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="telephone" class="form-input" placeholder="Ex: +226 70 00 00 00" value="{{ old('telephone') }}">
                    @error('telephone')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-input" placeholder="Ex: moniteur@email.com" value="{{ old('email') }}">
                    @error('email')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Spécialité</label>
                    <input type="text" name="specialite" class="form-input" placeholder="Ex: Code de la route, Conduite pratique" value="{{ old('specialite') }}">
                    @error('specialite')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Disponibilité <span class="required-star">*</span></label>
                    <select name="disponibilite" class="form-select">
                        <option value="1" {{ old('disponibilite') == '1' ? 'selected' : '' }}>✓ Disponible</option>
                        <option value="0" {{ old('disponibilite') == '0' ? 'selected' : '' }}>✕ Indisponible</option>
                    </select>
                    @error('disponibilite')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-actions" style="margin-top: 28px;">
                <button type="submit" class="btn-save">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                    Enregistrer
                </button>
                <a href="{{ route('moniteurs.index') }}" class="btn-cancel">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <div class="info-banner">
        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
        <span><strong>Information :</strong> Les champs marqués avec un <strong>*</strong> sont obligatoires.</span>
    </div>
</div>
</x-layouts::app>