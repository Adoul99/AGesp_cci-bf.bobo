<x-layouts::app.sidebar title="Modifier Programmation">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-light: #E85040; --color-red-dark: #A00D20;
    --color-green-light: #00A572; --color-green-dark: #004D3A;
    --color-gold-dark: #E5B800;

    --bg-page: linear-gradient(160deg, #0B2F1D 0%, #0F3D24 45%, #123F26 100%);
    --card-bg: rgba(255,255,255,0.05);
    --card-border: rgba(255,255,255,0.14);
    --input-bg: rgba(0,0,0,0.22);
    --input-border: rgba(255,255,255,0.22);
    --text-light: #F4F9F6;
    --text-muted: #A9C4B4;
    --radius-md: 10px; --radius-lg: 16px;
    --shadow-md: 0 10px 30px rgba(0,0,0,0.35);
}

.content-wrapper { background: var(--bg-page); min-height: 100vh; padding: 2.5rem; font-family: inherit; }

.pg-breadcrumb { display:flex; align-items:center; gap:.5rem; font-size:.82rem; color:var(--text-muted); margin-bottom:1.5rem; }
.pg-breadcrumb a { color:#6EE7C0; text-decoration:none; font-weight:600; }
.pg-breadcrumb a:hover { text-decoration:underline; }

.pg-card {
    background: var(--card-bg); border: 1px solid var(--card-border);
    border-radius: var(--radius-lg); padding: 1.75rem 2rem; margin-bottom: 1.5rem;
    box-shadow: var(--shadow-md); backdrop-filter: blur(6px);
}

.pg-card-header { display:flex; align-items:center; gap:1rem; margin-bottom:1.5rem; }
.pg-card-icon {
    width:48px; height:48px; background:linear-gradient(135deg, var(--color-red), var(--color-red-dark));
    border-radius:12px; display:flex; align-items:center; justify-content:center; flex-shrink:0;
    box-shadow:0 4px 12px rgba(206,17,38,.4);
}
.pg-card-icon svg { width:22px; height:22px; color:white; }
.pg-form-title { font-size:1.4rem; font-weight:800; color:var(--text-light); margin:0; }
.pg-form-subtitle { font-size:.85rem; color:var(--text-muted); margin-top:.2rem; }
.pg-id-badge {
    margin-left:auto; background:rgba(0,122,94,0.2); color:#6EE7C0; font-size:.78rem; font-weight:700;
    padding:.3rem .8rem; border-radius:20px; border:1px solid rgba(0,122,94,.4);
}

.pg-field-label {
    display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem;
    text-transform:uppercase; letter-spacing:0.5px; color:var(--text-light);
}
.pg-input {
    width:100%; padding:0.75rem 1rem; border:2px solid var(--input-border);
    border-radius:var(--radius-md); font-size:0.875rem; color:#1A1A1A;
    background:var(--bg-input,#fff); transition: border-color 200ms ease, box-shadow 200ms ease;
}
.pg-input:focus { outline:none; border-color:var(--color-gold); box-shadow:0 0 0 3px rgba(252,209,22,0.25); }
.pg-error { font-size:.8rem; color:#FF8A80; margin-top:.4rem; }

.pg-form-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(240px,1fr)); gap:1.5rem; }

.pg-section-title {
    font-size:1rem; font-weight:700; color:var(--text-light); display:flex; align-items:center; gap:.6rem;
    margin-bottom:1rem; padding-bottom:.75rem; border-bottom:2px solid var(--color-gold);
}
.pg-section-title.red { border-bottom-color:var(--color-red-light); color:#FF8A80; }
.pg-count-pill {
    font-size:.7rem; font-weight:800; padding:.2rem .65rem; border-radius:20px;
    background:rgba(0,122,94,.3); color:#6EE7C0;
}
.pg-count-pill.red { background:rgba(206,17,38,.25); color:#FF8A80; }

.pg-cand-list { display:flex; flex-direction:column; gap:.5rem; max-height:380px; overflow-y:auto; padding:.25rem; }
.pg-cand-row {
    display:flex; align-items:center; gap:.75rem; padding:.75rem 1rem; border-radius:10px;
    border:1.5px solid rgba(255,255,255,0.08); background:rgba(255,255,255,0.03);
}
.pg-cand-row input[type="checkbox"] { width:16px; height:16px; accent-color:var(--color-green-light); flex-shrink:0; }
.pg-cand-name { font-weight:700; font-size:.875rem; color:var(--text-light); flex:1; }
.pg-cand-value { font-weight:800; font-size:1.05rem; color:#6EE7C0; }
.pg-cand-value small { font-size:.65rem; color:var(--text-muted); font-weight:400; }
.pg-cand-rank { font-weight:800; font-size:.85rem; color:var(--text-muted); width:22px; text-align:center; }
.pg-nok-row { opacity:.85; }
.pg-nok-motif { font-size:.72rem; color:#FF8A80; margin-top:.1rem; }
.pg-empty-msg { padding:1.5rem; text-align:center; color:var(--text-muted); font-size:.85rem; }

.pg-manual-box { position:relative; }
.pg-manual-results {
    display:none; position:absolute; top:100%; left:0; right:0; background:white; color:#1A1A1A;
    border:1px solid var(--input-border); border-radius:var(--radius-md); box-shadow:var(--shadow-md);
    z-index:10; max-height:230px; overflow-y:auto; margin-top:4px;
}
.pg-manual-results .item { padding:.6rem 1rem; cursor:pointer; font-size:.85rem; border-bottom:1px solid #eee; }
.pg-manual-results .item:hover { background: rgba(0,122,94,0.08); }
.pg-manual-pill {
    display:inline-flex; align-items:center; gap:.4rem; background:rgba(252,209,22,0.15);
    border:1.5px solid var(--color-gold); color:var(--color-gold); padding:.4rem .75rem;
    border-radius:20px; font-size:.8rem; font-weight:700;
}
.pg-manual-pill button { background:none; border:none; color:var(--color-red-light); cursor:pointer; font-weight:800; padding:0; margin-left:4px; }

.pg-selection-banner {
    padding:.75rem 1rem; background:rgba(0,122,94,0.15); border-radius:10px; font-size:.85rem;
    color:#6EE7C0; font-weight:700; margin-bottom:1.5rem;
}

.pg-footer { display:flex; justify-content:flex-end; gap:1rem; flex-wrap:wrap; }
.pg-btn { display:inline-flex; align-items:center; gap:.5rem; font-weight:700; font-size:.87rem;
    padding:.85rem 1.6rem; border-radius:var(--radius-md); border:none; cursor:pointer; text-decoration:none;
    transition: transform .18s; }
.pg-btn:hover { transform: translateY(-1px); }
.pg-btn svg { width:16px; height:16px; }
.pg-btn-cancel { background:transparent; color:var(--text-light); border:2px solid var(--input-border); }
.pg-btn-view { background:rgba(252,209,22,0.15); color:var(--color-gold); border:2px solid var(--color-gold); }
.pg-btn-submit { background:linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%); color:white; border:2px solid var(--color-green); box-shadow:0 4px 14px rgba(0,122,94,.4); }
</style>

<div class="content-wrapper">

    <div class="pg-breadcrumb">
        <a href="{{ route('programmations.index') }}">Programmations</a>
        <span>›</span>
        <span>Modifier #{{ $programmation->id }}</span>
    </div>

    <form id="progForm" method="POST" action="{{ route('programmations.update', $programmation->id) }}">
        @csrf
        @method('PUT')

        {{-- Paramètres généraux --}}
        <div class="pg-card">
            <div class="pg-card-header">
                <div class="pg-card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="pg-form-title">Modifier la programmation</h1>
                    <p class="pg-form-subtitle">Mise à jour du type d'examen et des candidats</p>
                </div>
                <span class="pg-id-badge">ID #{{ $programmation->id }}</span>
            </div>

            @if($errors->any())
            <div style="margin-bottom:1.5rem; padding:1rem 1.25rem; background:rgba(206,17,38,0.15); border-left:4px solid var(--color-red); border-radius:10px; color:#FFD6D0;">
                <strong>⚠ Erreurs :</strong>
                <ul style="margin:.5rem 0 0 1.25rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
            @endif

            <div class="pg-form-grid">
                <div>
                    <label class="pg-field-label" for="typeSession_id">Type de session / Examen <span style="color:var(--color-red-light);">*</span></label>
                    <select id="typeSession_id" name="typeSession_id" class="pg-input" style="font-weight:700;" required onchange="chargerCandidatsParType(this.value)">
                        <option value="">— Choisir un type —</option>
                        @foreach($typeSessions as $ts)
                            <option value="{{ $ts->id }}" data-type="{{ $ts->type }}"
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
                    @error('typeSession_id')<p class="pg-error">⚠ {{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="pg-field-label" for="moniteur_id">Moniteur responsable</label>
                    <select id="moniteur_id" name="moniteur_id" class="pg-input">
                        <option value="">— Choisir un moniteur —</option>
                        @foreach($moniteurs as $moniteur)
                            <option value="{{ $moniteur->id }}"
                                {{ old('moniteur_id', $programmation->moniteur_id) == $moniteur->id ? 'selected' : '' }}>
                                {{ $moniteur->nom }} {{ $moniteur->prenom }}
                            </option>
                        @endforeach
                    </select>
                    @error('moniteur_id')<p class="pg-error">⚠ {{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Candidats actuellement programmés --}}
        <div class="pg-card">
            <div class="pg-section-title">
                ✅ Candidats actuellement programmés
                <span class="pg-count-pill" id="count-actuels">{{ $candidatsActuels->count() }}</span>
            </div>
            <div class="pg-cand-list" id="actuels-container">
                @forelse($candidatsActuels as $i => $c)
                <label class="pg-cand-row" data-id="{{ $c->id }}">
                    <input type="checkbox" class="candidat-checkbox" value="{{ $c->id }}" checked onchange="updateSelection()">
                    <span class="pg-cand-name">
                        {{ $c->nom }} {{ $c->prenom }}
                        @if($i===0) 🥇 @elseif($i===1) 🥈 @elseif($i===2) 🥉 @endif
                    </span>
                    @if(!is_null($c->note))
                        <span class="pg-cand-value">{{ $c->note }}<small>/30</small></span>
                    @elseif(!empty($c->mention))
                        <span class="pg-cand-value" style="text-transform:uppercase; font-size:.8rem;">
                            {{ $c->mention === 'bien' ? '🟢 Bien' : ($c->mention === 'passable' ? '🟡 Passable' : '🔴 Médiocre') }}
                        </span>
                    @endif
                </label>
                @empty
                <div class="pg-empty-msg">Aucun candidat programmé pour l'instant.</div>
                @endforelse
            </div>
            <p style="font-size:.78rem;color:var(--text-muted);margin-top:.75rem;">
                ℹ️ Décochez un candidat pour le retirer. Changez le type d'examen ci-dessus pour afficher un nouveau classement.
            </p>
        </div>

        {{-- Nouveau classement (si changement de type) --}}
        <div id="resultats-container" style="display:none;">
            <div class="pg-card">
                <div class="pg-section-title">
                    🏆 <span id="titre-eligibles">Candidats ayant validé</span>
                    <span class="pg-count-pill" id="count-eligibles">0</span>
                </div>
                <div class="pg-cand-list" id="eligibles-container"></div>
            </div>

            <div class="pg-card">
                <div class="pg-section-title red">
                    🚫 <span id="titre-non-eligibles">Note/Mention insuffisante</span>
                    <span class="pg-count-pill red" id="count-non-eligibles">0</span>
                </div>
                <div class="pg-cand-list" id="non-eligibles-container"></div>
            </div>
        </div>

        {{-- Ajout manuel --}}
        <div class="pg-card">
            <div class="pg-section-title" style="color:var(--color-gold); border-bottom-color:var(--color-gold);">➕ Ajouter un candidat manuellement</div>
            <p style="font-size:.8rem; color:var(--text-muted); margin-bottom:1rem;">
                Pour un candidat ne remplissant pas les conditions, mais que vous souhaitez tout de même programmer.
            </p>
            <div class="pg-manual-box">
                <input type="text" id="search-candidat" class="pg-input" placeholder="🔍 Rechercher un candidat par nom..." autocomplete="off" oninput="rechercherCandidat(this.value)">
                <div id="search-results" class="pg-manual-results"></div>
            </div>
            <div id="ajoutes-manuellement" style="margin-top:1rem; display:flex; flex-wrap:wrap; gap:.5rem;"></div>
        </div>

        <div class="pg-selection-banner">
            ✓ <span id="selection-count">{{ $candidatsActuels->count() }}</span> candidat(s) sélectionné(s) au total
        </div>

        <div id="candidats-hidden-inputs"></div>

        <div class="pg-footer">
            <a href="{{ route('programmations.index') }}" class="pg-btn pg-btn-cancel">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                Annuler
            </a>
            <a href="{{ route('programmations.show', $programmation->id) }}" class="pg-btn pg-btn-view">
                👁️ Voir la liste DGTTM
            </a>
            <button type="submit" class="pg-btn pg-btn-submit">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                Mettre à jour
            </button>
        </div>
    </form>

</div>

<script>
let idsActuels = new Set([{{ implode(',', $candidatsSelectionnes) }}]);
let ajoutesManuellement = new Set();
let typeActuel = null;

function chargerCandidatsParType(typeSessionId) {
    const container = document.getElementById('resultats-container');
    const select     = document.getElementById('typeSession_id');
    const opt        = select.options[select.selectedIndex];
    typeActuel       = opt ? opt.dataset.type : null;

    if (!typeSessionId) { container.style.display = 'none'; return; }

    const libelles = { code: 'Code', creneau: 'Créneau', conduite: 'Conduite' };
    const libelle = libelles[typeActuel] || typeActuel;
    document.getElementById('titre-eligibles').textContent     = `Candidats ayant validé ${libelle}`;
    document.getElementById('titre-non-eligibles').textContent = typeActuel === 'code' ? 'Note insuffisante (< 25)' : 'Mention insuffisante (Médiocre)';

    container.style.display = 'block';
    document.getElementById('eligibles-container').innerHTML     = '<div class="pg-empty-msg">Chargement...</div>';
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
        container.innerHTML = `<div class="pg-empty-msg">Aucun candidat n'a encore validé cette étape.</div>`;
        return;
    }
    container.innerHTML = list.map((c, idx) => {
        const dejaCoche = idsActuels.has(c.id);
        const medaille = idx === 0 ? '🥇' : (idx === 1 ? '🥈' : (idx === 2 ? '🥉' : ''));
        const valeur = typeActuel === 'code'
            ? `<span class="pg-cand-value">${c.note}<small>/30</small></span>`
            : `<span class="pg-cand-value" style="text-transform:uppercase; font-size:.8rem;">${c.mention === 'bien' ? '🟢 Bien' : '🟡 Passable'}</span>`;
        return `
        <label class="pg-cand-row" data-id="${c.id}">
            <span class="pg-cand-rank">${idx + 1}</span>
            <input type="checkbox" class="candidat-checkbox-nouveau" value="${c.id}" ${dejaCoche ? 'checked' : ''} onchange="updateSelection()">
            <span class="pg-cand-name">${c.nom} ${c.prenom} ${medaille}</span>
            ${valeur}
        </label>`;
    }).join('');
}

function renderNonEligibles(list) {
    const container = document.getElementById('non-eligibles-container');
    if (!list.length) {
        container.innerHTML = `<div class="pg-empty-msg">Aucun candidat dans cette catégorie.</div>`;
        return;
    }
    container.innerHTML = list.map(c => `
        <div class="pg-cand-row pg-nok-row">
            <span>🚫</span>
            <div style="flex:1;">
                <div class="pg-cand-name">${c.nom} ${c.prenom}</div>
                <div class="pg-nok-motif">${c.motif}</div>
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
                resultsBox.innerHTML = '<div style="padding:.75rem; color:#888; font-size:.85rem;">Aucun candidat trouvé.</div>';
            } else {
                resultsBox.innerHTML = candidats.map(c => `
                    <div class="item" onclick="ajouterManuel(${c.id}, '${c.nom} ${c.prenom}')">
                        👤 ${c.nom} ${c.prenom} <span style="color:#888; font-size:.75rem;">(${c.statut})</span>
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
        return `<span class="pg-manual-pill">➕ ${c.nom}<button type="button" onclick="retirerManuel(${c.id})">✕</button></span>`;
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