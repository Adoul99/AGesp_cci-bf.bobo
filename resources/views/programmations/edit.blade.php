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
        --cci-gold-soft:  rgba(252,209,22,.12);
        --radius: 14px;
        --shadow: 0 2px 16px rgba(15,25,35,.08);
    }
    * { box-sizing: border-box; margin: 0; padding: 0; }

    .pg-wrap { font-family: 'Inter', sans-serif; background: var(--cci-bg); min-height: 100vh; padding: 2rem; }

    .breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: .82rem; color: var(--cci-muted); margin-bottom: 1.5rem; }
    .breadcrumb a { color: var(--cci-green); text-decoration: none; font-weight: 500; }
    .breadcrumb a:hover { text-decoration: underline; }

    .form-card { background: var(--cci-white); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; margin-bottom: 1.5rem; }

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
    .btn-view { background: var(--cci-gold-soft); color: #92400E; border: 1.5px solid var(--cci-gold); }
    .btn-submit { background: linear-gradient(135deg, var(--cci-green) 0%, #005A46 100%); color: white; box-shadow: 0 4px 14px rgba(0,122,94,.35); }
    .btn-submit:hover { box-shadow: 0 6px 20px rgba(0,122,94,.45); }

    /* Candidats actuels / classement */
    .cand-section-title { font-family:'Sora',sans-serif; font-size:.95rem; font-weight:800; color:var(--cci-dark); display:flex; align-items:center; gap:.5rem; margin-bottom:1rem; padding-bottom:.75rem; border-bottom:2px solid var(--cci-line); }
    .cand-count { background:var(--cci-green); color:white; font-size:.7rem; padding:.2rem .6rem; border-radius:20px; font-weight:700; }
    .cand-count-red { background:var(--cci-red); }
    .cand-list { display:flex; flex-direction:column; gap:.5rem; max-height:380px; overflow-y:auto; padding:.25rem; }
    .cand-row { display:flex; align-items:center; gap:.75rem; padding:.75rem 1rem; border-radius:10px; border:1.5px solid var(--cci-line); background:white; }
    .cand-row input[type="checkbox"] { width:16px; height:16px; accent-color:var(--cci-green); flex-shrink:0; }
    .cand-name { font-weight:700; font-size:.875rem; color:var(--cci-dark); flex:1; }
    .cand-note { font-weight:800; font-size:1.05rem; color:var(--cci-green); }
    .cand-note small { font-size:.65rem; color:var(--cci-muted); font-weight:400; }
    .cand-rank { font-weight:800; font-size:.85rem; color:var(--cci-muted); width:22px; text-align:center; }
    .nok-row { opacity:.85; background:#fafafa; }
    .nok-motif { font-size:.72rem; color:var(--cci-red); margin-top:.1rem; }

    .manual-box { position:relative; }
    .manual-results { display:none; position:absolute; top:100%; left:0; right:0; background:white; border:1.5px solid var(--cci-line); border-radius:10px; box-shadow:var(--shadow); z-index:10; max-height:230px; overflow-y:auto; margin-top:4px; }
    .manual-result-item { padding:.6rem 1rem; cursor:pointer; font-size:.85rem; border-bottom:1px solid var(--cci-line); }
    .manual-result-item:hover { background:var(--cci-green-soft); }
    .manual-pill { display:inline-flex; align-items:center; gap:.4rem; background:var(--cci-gold-soft); border:1.5px solid var(--cci-gold); color:#92400E; padding:.4rem .75rem; border-radius:20px; font-size:.8rem; font-weight:700; }
    .manual-pill button { background:none; border:none; color:var(--cci-red); cursor:pointer; font-weight:800; padding:0; margin-left:4px; }

    .selection-banner { padding:.75rem 1rem; background:var(--cci-green-soft); border-radius:10px; font-size:.85rem; color:var(--cci-green); font-weight:700; margin-bottom:1.5rem; }
</style>

<div class="pg-wrap">

    <div class="breadcrumb">
        <a href="{{ route('programmations.index') }}">Programmations</a>
        <span>›</span>
        <span>Modifier #{{ $programmation->id }}</span>
    </div>

    <form id="progForm" method="POST" action="{{ route('programmations.update', $programmation->id) }}">
        @csrf
        @method('PUT')

        {{-- Paramètres généraux (sans dates) --}}
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
                    <p class="form-subtitle">Mise à jour du type d'examen et des candidats</p>
                </div>
                <span class="id-badge">ID #{{ $programmation->id }}</span>
            </div>

            <div class="form-body">
                @if($errors->any())
                <div style="margin-bottom:1.5rem; padding:1rem 1.25rem; background:var(--cci-red-soft); border-left:4px solid var(--cci-red); border-radius:10px; color:var(--cci-red);">
                    <strong>⚠ Erreurs :</strong>
                    <ul style="margin:.5rem 0 0 1.25rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
                @endif

                <div class="form-grid">

                    <div class="field">
                        <label class="field-label" for="typeSession_id">Type de session / Examen <span>*</span></label>
                        <div class="select-wrap">
                            <select id="typeSession_id" name="typeSession_id" class="field-select" required onchange="chargerCandidatsParType(this.value)">
                                <option value="">— Choisir un type —</option>
                                @foreach($typeSessions as $ts)
                                    <option value="{{ $ts->id }}"
                                        {{ old('typeSession_id', $programmation->typeSession_id) == $ts->id ? 'selected' : '' }}>
                                        @switch($ts->type)
                                            @case('code') 📋 Examen Code @break
                                            @case('creneau') 🔧 Examen Créneau @break
                                            @case('conduite') 🚗 Examen Conduite @break
                                            @default {{ $ts->type }}
                                        @endswitch
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('typeSession_id')<p class="error-msg">⚠ {{ $message }}</p>@enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="moniteur_id">Moniteur responsable</label>
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

                </div>
            </div>
        </div>

        {{-- Candidats actuellement programmés --}}
        <div class="form-card">
            <div class="form-body">
                <div class="cand-section-title">
                    ✅ Candidats actuellement programmés
                    <span class="cand-count" id="count-actuels">{{ $candidatsActuels->count() }}</span>
                </div>
                <div class="cand-list" id="actuels-container">
                    @forelse($candidatsActuels as $i => $c)
                    <label class="cand-row" data-id="{{ $c->id }}">
                        <input type="checkbox" class="candidat-checkbox" value="{{ $c->id }}" checked onchange="updateSelection()">
                        <span class="cand-name">
                            {{ $c->nom }} {{ $c->prenom }}
                            @if($i===0) 🥇 @elseif($i===1) 🥈 @elseif($i===2) 🥉 @endif
                        </span>
                        @if(!is_null($c->note))
                        <span class="cand-note">{{ $c->note }}<small>/30</small></span>
                        @endif
                    </label>
                    @empty
                    <div style="padding:1.5rem;text-align:center;color:var(--cci-muted);">Aucun candidat programmé pour l'instant.</div>
                    @endforelse
                </div>
                <p style="font-size:.78rem;color:var(--cci-muted);margin-top:.75rem;">
                    ℹ️ Décochez un candidat pour le retirer. Changez le type d'examen ci-dessus pour afficher un nouveau classement par mérite.
                </p>
            </div>
        </div>

        {{-- Nouveau classement (si changement de type) --}}
        <div id="resultats-container" style="display:none;">
            <div class="form-card">
                <div class="form-body">
                    <div class="cand-section-title">
                        🏆 Classement par mérite (note ≥ 25)
                        <span class="cand-count" id="count-eligibles">0</span>
                    </div>
                    <div class="cand-list" id="eligibles-container"></div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-body">
                    <div class="cand-section-title" style="color:var(--cci-red);">
                        🚫 Note insuffisante (&lt; 25)
                        <span class="cand-count cand-count-red" id="count-non-eligibles">0</span>
                    </div>
                    <div class="cand-list" id="non-eligibles-container"></div>
                </div>
            </div>
        </div>

        {{-- Ajout manuel --}}
        <div class="form-card">
            <div class="form-body">
                <div class="cand-section-title" style="color:#92400E;">➕ Ajouter un candidat manuellement</div>
                <p style="font-size:.8rem; color:var(--cci-muted); margin-bottom:1rem;">
                    Pour un candidat ne remplissant pas les conditions, mais que vous souhaitez tout de même programmer.
                </p>
                <div class="manual-box">
                    <input type="text" id="search-candidat" class="field-input" placeholder="🔍 Rechercher un candidat par nom..." autocomplete="off" oninput="rechercherCandidat(this.value)">
                    <div id="search-results" class="manual-results"></div>
                </div>
                <div id="ajoutes-manuellement" style="margin-top:1rem; display:flex; flex-wrap:wrap; gap:.5rem;"></div>
            </div>
        </div>

        <div class="selection-banner">
            ✓ <span id="selection-count">{{ $candidatsActuels->count() }}</span> candidat(s) sélectionné(s) au total
        </div>

        <div id="candidats-hidden-inputs"></div>

        <div class="form-footer">
            <a href="{{ route('programmations.index') }}" class="btn btn-cancel">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Annuler
            </a>
            <a href="{{ route('programmations.show', $programmation->id) }}" class="btn btn-view">
                👁️ Voir la liste DGTTM
            </a>
            <button type="submit" class="btn btn-submit">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Mettre à jour
            </button>
        </div>
    </form>

</div>

<script>
let idsActuels = new Set([{{ implode(',', $candidatsSelectionnes) }}]);
let ajoutesManuellement = new Set();

function chargerCandidatsParType(typeSessionId) {
    const container = document.getElementById('resultats-container');
    if (!typeSessionId) { container.style.display = 'none'; return; }

    container.style.display = 'block';
    document.getElementById('eligibles-container').innerHTML    = '<div style="text-align:center;padding:1rem;color:var(--cci-muted);">Chargement...</div>';
    document.getElementById('non-eligibles-container').innerHTML = '';

    fetch(`/programmations/candidats-par-type/${typeSessionId}`)
        .then(r => r.json())
        .then(data => {
            renderEligibles(data.eligibles);
            renderNonEligibles(data.nonEligibles.concat(data.autres));
            document.getElementById('count-eligibles').textContent     = data.eligibles.length;
            document.getElementById('count-non-eligibles').textContent = data.nonEligibles.length + data.autres.length;
            updateSelection();
        });
}

function renderEligibles(list) {
    const container = document.getElementById('eligibles-container');
    if (!list.length) {
        container.innerHTML = `<div style="padding:1.5rem;text-align:center;color:var(--cci-muted);">Aucun candidat n'a encore une note ≥ 25 pour ce type.</div>`;
        return;
    }
    container.innerHTML = list.map((c, idx) => {
        const dejaCoche = idsActuels.has(c.id);
        return `
        <label class="cand-row" data-id="${c.id}">
            <span class="cand-rank">${idx + 1}</span>
            <input type="checkbox" class="candidat-checkbox-nouveau" value="${c.id}" ${dejaCoche ? 'checked' : ''} onchange="updateSelection()">
            <span class="cand-name">${c.nom} ${c.prenom} ${idx === 0 ? '🥇' : (idx === 1 ? '🥈' : (idx === 2 ? '🥉' : ''))}</span>
            <span class="cand-note">${c.note}<small>/30</small></span>
        </label>`;
    }).join('');
}

function renderNonEligibles(list) {
    const container = document.getElementById('non-eligibles-container');
    if (!list.length) {
        container.innerHTML = `<div style="padding:1.5rem;text-align:center;color:var(--cci-muted);">Aucun candidat dans cette catégorie.</div>`;
        return;
    }
    container.innerHTML = list.map(c => `
        <div class="cand-row nok-row">
            <span>🚫</span>
            <div style="flex:1;">
                <div class="cand-name">${c.nom} ${c.prenom}</div>
                <div class="nok-motif">${c.motif}</div>
            </div>
        </div>
    `).join('');
}

function rechercherCandidat(q) {
    const resultsBox = document.getElementById('search-results');
    if (!q || q.length < 2) { resultsBox.style.display = 'none'; return; }

    fetch(`/programmations/rechercher-candidat?q=${encodeURIComponent(q)}`)
        .then(r => r.json())
        .then(candidats => {
            if (!candidats.length) {
                resultsBox.innerHTML = '<div style="padding:.75rem; color:var(--cci-muted); font-size:.85rem;">Aucun candidat trouvé.</div>';
            } else {
                resultsBox.innerHTML = candidats.map(c => `
                    <div class="manual-result-item" onclick="ajouterManuel(${c.id}, '${c.nom} ${c.prenom}')">
                        👤 ${c.nom} ${c.prenom} <span style="color:var(--cci-muted); font-size:.75rem;">(${c.statut})</span>
                    </div>
                `).join('');
            }
            resultsBox.style.display = 'block';
        });
}

function ajouterManuel(id, nom) {
    ajoutesManuellement.add(JSON.stringify({id, nom}));
    renderAjoutesManuellement();
    document.getElementById('search-results').style.display = 'none';
    document.getElementById('search-candidat').value = '';
    updateSelection();
}

function retirerManuel(id) {
    ajoutesManuellement.forEach(item => {
        const parsed = JSON.parse(item);
        if (parsed.id === id) ajoutesManuellement.delete(item);
    });
    renderAjoutesManuellement();
    updateSelection();
}

function renderAjoutesManuellement() {
    const container = document.getElementById('ajoutes-manuellement');
    container.innerHTML = Array.from(ajoutesManuellement).map(item => {
        const c = JSON.parse(item);
        return `<span class="manual-pill">➕ ${c.nom}<button type="button" onclick="retirerManuel(${c.id})">✕</button></span>`;
    }).join('');
}

function updateSelection() {
    const checkedActuels  = Array.from(document.querySelectorAll('#actuels-container .candidat-checkbox:checked')).map(cb => cb.value);
    const checkedNouveaux = Array.from(document.querySelectorAll('.candidat-checkbox-nouveau:checked')).map(cb => cb.value);
    const manuels         = Array.from(ajoutesManuellement).map(item => String(JSON.parse(item).id));

    const allIds = [...new Set([...checkedActuels, ...checkedNouveaux, ...manuels])];

    document.getElementById('selection-count').textContent = allIds.length;
    document.getElementById('count-actuels').textContent = checkedActuels.length;

    const hiddenContainer = document.getElementById('candidats-hidden-inputs');
    hiddenContainer.innerHTML = '';
    allIds.forEach(id => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'candidat_ids[]';
        input.value = id;
        hiddenContainer.appendChild(input);
    });
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('#search-candidat') && !e.target.closest('#search-results')) {
        document.getElementById('search-results').style.display = 'none';
    }
});

document.addEventListener('DOMContentLoaded', updateSelection);
</script>
</x-layouts::app.sidebar>