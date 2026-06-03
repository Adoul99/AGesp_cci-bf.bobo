<x-layouts::app.sidebar title="Modifier Programmation">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500&display=swap');

    :root {
        --cci-red:    #CE1126;
        --cci-green:  #007A5E;
        --cci-gold:   #FCD116;
        --cci-dark:   #0F1923;
        --cci-muted:  #64748B;
        --cci-line:   #E8ECF0;
        --cci-bg:     #F4F6F9;
        --cci-white:  #FFFFFF;
        --cci-red-soft:   rgba(206,17,38,.07);
        --cci-green-soft: rgba(0,122,94,.07);
        --radius: 14px;
        --shadow: 0 2px 16px rgba(15,25,35,.08);
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }

    .pg-wrap { font-family: 'Inter', sans-serif; background: var(--cci-bg); min-height: 100vh; padding: 2rem; }

    .breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: .82rem; color: var(--cci-muted); margin-bottom: 1.5rem; }
    .breadcrumb a { color: var(--cci-green); text-decoration: none; font-weight: 500; }
    .breadcrumb a:hover { text-decoration: underline; }

    .form-card { background: var(--cci-white); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; }

    .form-card-header { padding: 2rem 2rem 1.5rem; border-bottom: 1px solid var(--cci-line); display: flex; align-items: center; gap: 1rem; }
    .form-card-icon {
        width: 48px; height: 48px;
        background: linear-gradient(135deg, var(--cci-green), #005A46);
        border-radius: 12px; display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; box-shadow: 0 4px 12px rgba(0,122,94,.3);
    }
    .form-card-icon svg { width: 22px; height: 22px; color: white; }

    .form-title { font-family: 'Sora', sans-serif; font-size: 1.5rem; font-weight: 800; color: var(--cci-dark); }
    .form-subtitle { font-size: .87rem; color: var(--cci-muted); margin-top: .2rem; }

    /* Badge ID */
    .id-badge {
        margin-left: auto;
        background: var(--cci-green-soft);
        color: var(--cci-green);
        font-family: 'Sora', sans-serif;
        font-size: .78rem; font-weight: 700;
        padding: .3rem .8rem; border-radius: 20px;
        border: 1px solid rgba(0,122,94,.2);
    }

    .form-body { padding: 2rem; }
    .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
    @media (max-width: 700px) { .form-grid { grid-template-columns: 1fr; } }
    .form-full { grid-column: 1 / -1; }

    .field { display: flex; flex-direction: column; gap: .45rem; }
    .field-label { font-family: 'Sora', sans-serif; font-size: .82rem; font-weight: 700; color: var(--cci-dark); letter-spacing: .03em; }
    .field-label span { color: var(--cci-red); margin-left: .15rem; }

    .field-input, .field-select {
        width: 100%; padding: .85rem 1rem;
        border: 1.5px solid var(--cci-line); border-radius: 10px;
        font-family: 'Inter', sans-serif; font-size: .9rem; color: var(--cci-dark);
        background: white; transition: border-color .18s, box-shadow .18s;
        appearance: none; -webkit-appearance: none;
    }
    .field-input:focus, .field-select:focus { outline: none; border-color: var(--cci-green); box-shadow: 0 0 0 4px rgba(0,122,94,.1); }

    .select-wrap { position: relative; }
    .select-wrap::after {
        content: ''; position: absolute; right: 1rem; top: 50%; transform: translateY(-50%);
        width: 0; height: 0; border-left: 5px solid transparent; border-right: 5px solid transparent;
        border-top: 6px solid var(--cci-muted); pointer-events: none;
    }

    .error-msg { font-size: .8rem; color: var(--cci-red); display: flex; align-items: center; gap: .3rem; }

    .candidats-box {
        border: 1.5px solid var(--cci-line); border-radius: 10px;
        max-height: 220px; overflow-y: auto; padding: .5rem;
        display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: .3rem;
    }
    .check-label {
        display: flex; align-items: center; gap: .6rem;
        padding: .6rem .75rem; border-radius: 8px; cursor: pointer;
        font-size: .87rem; transition: background .14s; border: 1px solid transparent;
    }
    .check-label:hover { background: var(--cci-green-soft); border-color: rgba(0,122,94,.15); }
    .check-label input[type="checkbox"] { width: 16px; height: 16px; accent-color: var(--cci-green); cursor: pointer; flex-shrink: 0; }

    .form-divider { height: 1px; background: var(--cci-line); margin: 2rem 0; }

    .form-footer { display: flex; justify-content: flex-end; gap: 1rem; flex-wrap: wrap; }

    .btn {
        display: inline-flex; align-items: center; gap: .5rem;
        font-family: 'Sora', sans-serif; font-weight: 700; font-size: .87rem;
        padding: .85rem 1.6rem; border-radius: 10px; border: none; cursor: pointer;
        text-decoration: none; transition: transform .18s, box-shadow .18s;
    }
    .btn:hover { transform: translateY(-1px); }
    .btn svg { width: 16px; height: 16px; }

    .btn-cancel { background: white; color: var(--cci-dark); border: 1.5px solid var(--cci-line); box-shadow: 0 1px 4px rgba(0,0,0,.06); }
    .btn-cancel:hover { border-color: #CBD5E1; box-shadow: 0 2px 8px rgba(0,0,0,.1); }

    .btn-submit { background: linear-gradient(135deg, var(--cci-green) 0%, #005A46 100%); color: white; box-shadow: 0 4px 14px rgba(0,122,94,.35); }
    .btn-submit:hover { box-shadow: 0 6px 20px rgba(0,122,94,.45); }
</style>

<div class="pg-wrap">

    <div class="breadcrumb">
        <a href="{{ route('programmations.index') }}">Programmations</a>
        <span>›</span>
        <span>Modifier #{{ $programmation->id }}</span>
    </div>

    <div class="form-card">
        <div class="form-card-header">
            <div class="form-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </div>
            <div>
                <h1 class="form-title">Modifier la programmation</h1>
                <p class="form-subtitle">Mise à jour des informations de la session</p>
            </div>
            <span class="id-badge">ID #{{ $programmation->id }}</span>
        </div>

        <div class="form-body">
            <form method="POST" action="{{ route('programmations.update', $programmation->id) }}">
                @csrf
                @method('PUT')

                <div class="form-grid">

                    <div class="field">
                        <label class="field-label" for="dateDebut">Date de début <span>*</span></label>
                        <input id="dateDebut" type="date" name="dateDebut"
                               value="{{ old('dateDebut', $programmation->dateDebut) }}" class="field-input" required>
                        @error('dateDebut')<p class="error-msg">⚠ {{ $message }}</p>@enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="dateFin">Date de fin <span>*</span></label>
                        <input id="dateFin" type="date" name="dateFin"
                               value="{{ old('dateFin', $programmation->dateFin) }}" class="field-input" required>
                        @error('dateFin')<p class="error-msg">⚠ {{ $message }}</p>@enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="groupe_id">Groupe</label>
                        <div class="select-wrap">
                            <select id="groupe_id" name="groupe_id" class="field-select">
                                <option value="">— Choisir un groupe —</option>
                                @foreach($groupes as $groupe)
                                    <option value="{{ $groupe->id }}"
                                        {{ old('groupe_id', $programmation->groupe_id) == $groupe->id ? 'selected' : '' }}>
                                        {{ $groupe->nomGroupe }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('groupe_id')<p class="error-msg">⚠ {{ $message }}</p>@enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="moniteur_id">Moniteur</label>
                        <div class="select-wrap">
                            <select id="moniteur_id" name="moniteur_id" class="field-select">
                                <option value="">— Choisir un moniteur —</option>
                                @foreach($moniteurs as $moniteur)
                                    <option value="{{ $moniteur->id }}"
                                        {{ old('moniteur_id', $programmation->moniteur_id) == $moniteur->id ? 'selected' : '' }}>
                                        {{ $moniteur->nom }} {{ $moniteur->prenom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('moniteur_id')<p class="error-msg">⚠ {{ $message }}</p>@enderror
                    </div>

                    <div class="field form-full">
                        <label class="field-label">Candidats</label>
                        <div class="candidats-box">
                            @foreach($candidats as $candidat)
                                <label class="check-label">
                                    <input type="checkbox" name="candidat_ids[]" value="{{ $candidat->id }}"
                                        {{ in_array($candidat->id, old('candidat_ids', $candidatsSelectionnes)) ? 'checked' : '' }}>
                                    {{ $candidat->nom }} {{ $candidat->prenom }}
                                </label>
                            @endforeach
                        </div>
                        @error('candidat_ids')<p class="error-msg">⚠ {{ $message }}</p>@enderror
                    </div>

                </div>

                <div class="form-divider"></div>

                <div class="form-footer">
                    <a href="{{ route('programmations.index') }}" class="btn btn-cancel">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                        Annuler
                    </a>
                    <button type="submit" class="btn btn-submit">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Mettre à jour
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
</x-layouts::app.sidebar>
