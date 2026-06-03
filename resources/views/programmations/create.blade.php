<x-layouts::app.sidebar title="Nouvelle Programmation">
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

    .form-card { background: var(--cci-white); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; }

    .form-card-header { padding: 2rem 2rem 1.5rem; border-bottom: 1px solid var(--cci-line); display: flex; align-items: center; gap: 1rem; }
    .form-card-icon {
        width: 48px; height: 48px;
        background: linear-gradient(135deg, var(--cci-red), #A50F20);
        border-radius: 12px; display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; box-shadow: 0 4px 12px rgba(206,17,38,.3);
    }
    .form-card-icon svg { width: 22px; height: 22px; color: white; }
    .form-title { font-family: 'Sora', sans-serif; font-size: 1.5rem; font-weight: 800; color: var(--cci-dark); }
    .form-subtitle { font-size: .87rem; color: var(--cci-muted); margin-top: .2rem; }

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

    /* Zone candidats */
    .candidats-section {
        border: 1.5px solid var(--cci-line);
        border-radius: 10px;
        overflow: hidden;
        transition: border-color .2s;
    }
    .candidats-section.has-candidats { border-color: rgba(0,122,94,.3); }

    .candidats-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: .75rem 1rem;
        background: var(--cci-bg);
        border-bottom: 1px solid var(--cci-line);
        font-size: .82rem; font-weight: 600; color: var(--cci-muted);
    }
    .candidats-count {
        background: var(--cci-green);
        color: white;
        font-size: .72rem; font-weight: 700;
        padding: .15rem .5rem; border-radius: 20px;
        display: none;
    }
    .candidats-count.visible { display: inline-flex; }

    .candidats-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
        gap: .3rem;
        padding: .75rem;
        max-height: 240px;
        overflow-y: auto;
    }

    .check-label {
        display: flex; align-items: center; gap: .6rem;
        padding: .6rem .75rem; border-radius: 8px; cursor: pointer;
        font-size: .87rem; transition: background .14s; border: 1px solid transparent;
    }
    .check-label:hover { background: var(--cci-green-soft); border-color: rgba(0,122,94,.15); }
    .check-label input[type="checkbox"] {
        width: 16px; height: 16px; accent-color: var(--cci-green);
        cursor: pointer; flex-shrink: 0;
    }
    .check-label .candidat-name { font-weight: 500; }

    /* État vide */
    .empty-candidats {
        padding: 2.5rem 1rem;
        text-align: center;
        color: var(--cci-muted);
        font-size: .88rem;
    }
    .empty-candidats svg { width: 36px; height: 36px; opacity: .3; display: block; margin: 0 auto .75rem; }

    /* Loading */
    .loading-candidats {
        padding: 2rem;
        text-align: center;
        color: var(--cci-green);
        font-size: .88rem;
        display: none;
    }
    .spinner {
        display: inline-block; width: 20px; height: 20px;
        border: 2px solid rgba(0,122,94,.2); border-top-color: var(--cci-green);
        border-radius: 50%; animation: spin .7s linear infinite;
        margin-right: .5rem; vertical-align: middle;
    }
    @keyframes spin { to { transform: rotate(360deg); } }

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
    .btn-cancel:hover { border-color: #CBD5E1; }
    .btn-submit { background: linear-gradient(135deg, var(--cci-red) 0%, #A50F20 100%); color: white; box-shadow: 0 4px 14px rgba(206,17,38,.35); }
    .btn-submit:hover { box-shadow: 0 6px 20px rgba(206,17,38,.45); }
    .btn-submit:disabled { opacity: .6; cursor: not-allowed; transform: none; }
</style>

<div class="pg-wrap">

    <div class="breadcrumb">
        <a href="{{ route('programmations.index') }}">Programmations</a>
        <span>›</span>
        <span>Nouvelle programmation</span>
    </div>

    <div class="form-card">
        <div class="form-card-header">
            <div class="form-card-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                    <line x1="12" y1="14" x2="12" y2="18"/><line x1="10" y1="16" x2="14" y2="16"/>
                </svg>
            </div>
            <div>
                <h1 class="form-title">Nouvelle programmation</h1>
                <p class="form-subtitle">Sélectionnez un groupe pour voir ses candidats automatiquement</p>
            </div>
        </div>

        <div class="form-body">
            <form method="POST" action="{{ route('programmations.store') }}" id="progForm">
                @csrf

                <div class="form-grid">

                    <div class="field">
                        <label class="field-label" for="dateDebut">Date de début <span>*</span></label>
                        <input id="dateDebut" type="date" name="dateDebut"
                               value="{{ old('dateDebut') }}" class="field-input" required>
                        @error('dateDebut')<p class="error-msg">⚠ {{ $message }}</p>@enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="dateFin">Date de fin <span>*</span></label>
                        <input id="dateFin" type="date" name="dateFin"
                               value="{{ old('dateFin') }}" class="field-input" required>
                        @error('dateFin')<p class="error-msg">⚠ {{ $message }}</p>@enderror
                    </div>

                    <!-- Groupe — déclencheur principal -->
                    <div class="field">
                        <label class="field-label" for="groupe_id">Groupe <span>*</span></label>
                        <div class="select-wrap">
                            <select id="groupe_id" name="groupe_id" class="field-select" required>
                                <option value="">— Choisir un groupe —</option>
                                @foreach($groupes as $groupe)
                                    <option value="{{ $groupe->id }}"
                                        {{ old('groupe_id') == $groupe->id ? 'selected' : '' }}>
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
                                        {{ old('moniteur_id') == $moniteur->id ? 'selected' : '' }}>
                                        {{ $moniteur->nom }} {{ $moniteur->prenom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('moniteur_id')<p class="error-msg">⚠ {{ $message }}</p>@enderror
                    </div>

                    <!-- Candidats du groupe (chargés dynamiquement) -->
                    <div class="field form-full">
                        <label class="field-label">
                            Candidats du groupe
                            <span id="candidatsCount" class="candidats-count"></span>
                        </label>

                        <div class="candidats-section" id="candidatsSection">

                            <div class="candidats-header">
                                <span id="candidatsGroupeNom">Sélectionnez d'abord un groupe</span>
                            </div>

                            <!-- Loading -->
                            <div class="loading-candidats" id="loadingCandidats">
                                <span class="spinner"></span> Chargement des candidats…
                            </div>

                            <!-- Liste des candidats -->
                            <div class="candidats-list" id="candidatsList">
                                <div class="empty-candidats">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                    Choisissez un groupe pour voir ses candidats
                                </div>
                            </div>

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
                    <button type="submit" class="btn btn-submit" id="btnSubmit">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const groupeSelect   = document.getElementById('groupe_id');
const candidatsList  = document.getElementById('candidatsList');
const loadingEl      = document.getElementById('loadingCandidats');
const countBadge     = document.getElementById('candidatsCount');
const groupeNomEl    = document.getElementById('candidatsGroupeNom');
const section        = document.getElementById('candidatsSection');

groupeSelect.addEventListener('change', function () {
    const groupeId = this.value;
    const groupeNom = this.options[this.selectedIndex].text;

    // Réinitialiser
    candidatsList.innerHTML = '';
    countBadge.classList.remove('visible');
    section.classList.remove('has-candidats');

    if (!groupeId) {
        groupeNomEl.textContent = 'Sélectionnez d\'abord un groupe';
        candidatsList.innerHTML = `
            <div class="empty-candidats">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Choisissez un groupe pour voir ses candidats
            </div>`;
        return;
    }

    // Afficher le loading
    groupeNomEl.textContent = groupeNom;
    loadingEl.style.display = 'block';
    candidatsList.style.display = 'none';

    fetch(`/groupes/${groupeId}/candidats`)
        .then(r => r.json())
        .then(candidats => {
            loadingEl.style.display = 'none';
            candidatsList.style.display = 'grid';

            if (candidats.length === 0) {
                candidatsList.innerHTML = `
                    <div class="empty-candidats">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                        Aucun candidat dans ce groupe
                    </div>`;
                return;
            }

            // Afficher les candidats avec checkbox pré-cochées
            candidats.forEach(c => {
                const label = document.createElement('label');
                label.className = 'check-label';
                label.innerHTML = `
                    <input type="checkbox" name="candidat_ids[]"
                           value="${c.id}" checked
                           style="width:16px;height:16px;accent-color:var(--cci-green);cursor:pointer;flex-shrink:0;">
                    <span class="candidat-name">${c.nom} ${c.prenom}</span>`;
                candidatsList.appendChild(label);
            });

            // Badge compteur
            countBadge.textContent = candidats.length + ' candidat' + (candidats.length > 1 ? 's' : '');
            countBadge.classList.add('visible');
            section.classList.add('has-candidats');
        })
        .catch(() => {
            loadingEl.style.display = 'none';
            candidatsList.style.display = 'grid';
            candidatsList.innerHTML = `<div class="empty-candidats" style="color:var(--cci-red);">Erreur de chargement</div>`;
        });
});
</script>
</x-layouts::app.sidebar>
