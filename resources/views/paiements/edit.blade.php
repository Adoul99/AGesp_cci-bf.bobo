<x-layouts::app.sidebar title="Modifier Paiement">
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
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }

    .edit-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff8e1;
        border: 1px solid #f6cc4f;
        border-radius: 4px;
        padding: 4px 10px;
        font-size: 0.76rem;
        font-weight: 700;
        color: #8a6900;
        text-transform: uppercase;
        letter-spacing: 0.04em;
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

    .form-actions { display: flex; gap: 12px; padding-top: 8px; }

    .btn-update {
        background: #2e7d6e;
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
    .btn-update:hover { background: #245f53; }

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
        <h1 class="page-title">| Modifier Paiement</h1>
        <span class="edit-badge">
            <svg width="11" height="11" fill="currentColor" viewBox="0 0 20 20"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"/><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"/></svg>
            Édition
        </span>
    </div>

    <div class="form-card">
        <h2 class="section-title">Informations Générales</h2>

        <form method="POST" action="{{ route('paiements.update', $paiement->id) }}">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Candidat <span class="required-star">*</span></label>
                    <select name="candidat_id" class="form-select" required>
                        <option value="">-- Choisir un candidat --</option>
                        @foreach($candidats as $candidat)
                        <option value="{{ $candidat->id }}" {{ old('candidat_id', $paiement->candidat_id) == $candidat->id ? 'selected' : '' }}>
                            {{ $candidat->nom }} {{ $candidat->prenom }}
                        </option>
                        @endforeach
                    </select>
                    @error('candidat_id')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Montant (FCFA) <span class="required-star">*</span></label>
                    <input type="number" name="montant" class="form-input" value="{{ old('montant', $paiement->montant) }}" required>
                    @error('montant')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Date Paiement <span class="required-star">*</span></label>
                    <input type="date" name="datePaiement" class="form-input" value="{{ old('datePaiement', $paiement->datePaiement) }}" required>
                    @error('datePaiement')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Statut <span class="required-star">*</span></label>
                    <select name="statut" class="form-select">
                        <option value="en_attente" {{ old('statut', $paiement->statut) == 'en_attente' ? 'selected' : '' }}>En attente</option>
                        <option value="paye"       {{ old('statut', $paiement->statut) == 'paye'       ? 'selected' : '' }}>Payé</option>
                        <option value="annule"     {{ old('statut', $paiement->statut) == 'annule'     ? 'selected' : '' }}>Annulé</option>
                    </select>
                    @error('statut')<span class="field-error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="form-actions" style="margin-top: 28px;">
                <button type="submit" class="btn-update">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                    Mettre à jour
                </button>
                <a href="{{ route('paiements.index') }}" class="btn-cancel">
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
</x-layouts::app.sidebar>
