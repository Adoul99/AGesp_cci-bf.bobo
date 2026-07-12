<x-layouts::app title="Nouvelle Programmation">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-light: #E85040; --color-red-dark: #A00D20;
    --color-green-light: #00A572; --color-green-dark: #004D3A;
    --color-gold-dark: #E5B800;

    --bg-page: #1E2A38;
    --bg-card: #2C3E50;
    --bg-card-header: #26374A;
    --bg-input: #FFFFFF;
    --bg-input-disabled: #47586B;
    --text-light: #ECF0F1;
    --text-muted: #9FB0C0;
    --border-input: #47586B;
    --shadow-md: 0 6px 20px rgba(0,0,0,0.35);
    --radius-md: 8px; --radius-lg: 12px;
}

.content-wrapper { background: linear-gradient(160deg, var(--bg-page) 0%, #17222E 100%); min-height: 100vh; padding: 2rem; }

.pg-card {
    background: var(--bg-card); border: 1px solid rgba(255,255,255,0.06);
    border-radius: var(--radius-lg); box-shadow: var(--shadow-md);
    padding: 1.75rem 2rem; margin-bottom: 1.5rem;
}

.pg-input {
    width:100%; padding:0.75rem 1rem; border:2px solid var(--border-input);
    border-radius:var(--radius-md); font-size:0.875rem; color:#1A1A1A;
    background:var(--bg-input); transition: border-color 200ms ease, box-shadow 200ms ease;
}
.pg-input:focus { outline:none; border-color:var(--color-gold); box-shadow:0 0 0 3px rgba(252,209,22,0.25); }

.pg-label {
    display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem;
    text-transform:uppercase; letter-spacing:0.5px; color:var(--text-light);
}

.pg-section-title {
    font-size:1rem; font-weight:700; margin:0; display:flex; align-items:center; gap:0.6rem;
}
.pg-count-badge {
    font-size:0.7rem; padding:0.2rem 0.6rem; border-radius:50px; font-weight:700;
}

.pg-btn-toggle {
    padding:0.5rem 1rem; border-radius:var(--radius-md); font-size:0.8rem; font-weight:600; cursor:pointer;
    border:1.5px solid var(--border-input); background: rgba(255,255,255,0.05); color: var(--text-light);
}

.pg-candidate-row {
    display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; border-radius:8px;
    background: rgba(255,255,255,0.03); border: 2px solid rgba(255,255,255,0.06); cursor: pointer;
}

.pg-empty-msg { padding:1.5rem; text-align:center; color: var(--text-muted); font-size:0.85rem; }

.pg-btn-primary {
    background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white;
    padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-red); font-weight:700;
    cursor:pointer; font-size:0.875rem; text-transform:uppercase;
}
.pg-btn-secondary {
    background:transparent; color:var(--text-light); padding:0.875rem 2rem; border-radius:var(--radius-md);
    border:2px solid var(--border-input); font-weight:600; text-decoration:none; font-size:0.875rem;
    text-transform:uppercase; display:inline-flex; align-items:center;
}

.pg-search-box {
    position:relative;
}
.pg-search-results {
    display:none; position:absolute; top:100%; left:0; right:0; background:white; color:#1A1A1A;
    border:1px solid var(--border-input); border-radius:var(--radius-md); box-shadow:var(--shadow-md);
    z-index:10; max-height:250px; overflow-y:auto; margin-top:4px;
}
.pg-search-results .item { padding:0.65rem 1rem; cursor:pointer; border-bottom:1px solid #eee; font-size:0.85rem; }
.pg-search-results .item:hover { background: rgba(0,122,94,0.08); }

.pg-manual-tag {
    display:inline-flex; align-items:center; gap:0.4rem; background:rgba(252,209,22,0.15);
    border:1.5px solid var(--color-gold); color:var(--color-gold-dark); padding:0.4rem 0.75rem;
    border-radius:50px; font-size:0.8rem; font-weight:600;
}
</style>

<div class="content-wrapper">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; background:var(--bg-card); padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--text-light); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Nouvelle Programmation
        </h1>
        <a href="{{ route('programmations.index') }}" style="color:var(--text-muted); text-decoration:none; font-size:.85rem;">← Retour</a>
    </div>

    @if($errors->any())
    <div class="pg-card" style="border-color: rgba(206,17,38,0.4); background: rgba(206,17,38,0.12);">
        <strong style="color:#FFD6D0;">⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem; color:#FFD6D0;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form id="progForm" method="POST" action="{{ route('programmations.store') }}">
        @csrf

        {{-- Paramètres --}}
        <div class="pg-card">
            <h2 class="pg-section-title" style="color:var(--text-light); margin-bottom:1.5rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                📅 Paramètres de la Programmation
            </h2>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:1.5rem;">
                <div>
                    <label class="pg-label">Type de session / Examen <span style="color:var(--color-red-light);">*</span></label>
                    <select name="typeSession_id" id="typeSession_id" required class="pg-input" style="font-weight:700;" onchange="chargerCandidatsParType(this.value)">
                        <option value="">-- Choisir un type --</option>
                        @foreach($typeSessions as $ts)
                            <option value="{{ $ts->id }}" data-type="{{ $ts->type }}">
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
                <div>
                    <label class="pg-label">Moniteur responsable</label>
                    <select name="moniteur_id" class="pg-input">
                        <option value="">-- Aucun --</option>
                        @foreach($moniteurs as $m)
                            <option value="{{ $m->id }}" {{ old('moniteur_id')==$m->id ? 'selected':'' }}>👤 {{ $m->nom }} {{ $m->prenom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div id="placeholder-empty" class="pg-card" style="text-align:center; color:var(--text-muted); padding:3rem;">
            👆 Choisissez un <strong style="color:var(--text-light);">type d'examen</strong> ci-dessus pour afficher la liste des candidats ayant validé cette étape.
        </div>

        <div id="resultats-container" style="display:none;">

            {{-- Éligibles --}}
            <div class="pg-card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-green-light);">
                    <h2 class="pg-section-title" style="color:#6EE7C0;">
                        🏆 <span id="titre-eligibles">Candidats ayant validé</span>
                        <span id="count-eligibles" class="pg-count-badge" style="background:rgba(0,122,94,0.3); color:#6EE7C0;">0</span>
                    </h2>
                    <div style="display:flex; gap:0.75rem;">
                        <button type="button" onclick="toutSelectionner(true)" class="pg-btn-toggle" style="border-color:var(--color-green-light); color:#6EE7C0;">✓ Tous</button>
                        <button type="button" onclick="toutSelectionner(false)" class="pg-btn-toggle">✕ Aucun</button>
                    </div>
                </div>
                <div id="eligibles-container" style="display:flex; flex-direction:column; gap:0.5rem; max-height:420px; overflow-y:auto; padding:0.25rem;"></div>
                <div id="selection-info" style="display:none; margin-top:1rem; padding:0.75rem 1rem; background:rgba(0,122,94,0.15); border-radius:var(--radius-md); font-size:0.85rem; color:#6EE7C0; font-weight:600;">
                    ✓ <span id="selection-count">0</span> candidat(s) sélectionné(s) pour l'examen
                </div>
            </div>

            {{-- Ajout manuel --}}
            <div class="pg-card" style="border:2px solid var(--color-gold);">
                <h2 class="pg-section-title" style="color:var(--color-gold); margin-bottom:1rem;">➕ Ajouter un candidat manuellement</h2>
                <p style="font-size:0.8rem; color:var(--text-muted); margin-bottom:1rem;">
                    Pour un candidat ne remplissant pas les conditions, ou pas encore évalué, mais que vous souhaitez tout de même programmer.
                </p>
                <div class="pg-search-box">
                    <input type="text" id="search-candidat" placeholder="🔍 Rechercher un candidat par nom..." autocomplete="off"
                           class="pg-input" oninput="rechercherCandidat(this.value)">
                    <div id="search-results" class="pg-search-results"></div>
                </div>
                <div id="ajoutes-manuellement" style="margin-top:1rem; display:flex; flex-wrap:wrap; gap:0.5rem;"></div>
            </div>

            {{-- Note/Mention insuffisante --}}
            <div class="pg-card">
                <h2 class="pg-section-title" style="color:#FF8A80; margin-bottom:1.25rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-red-light);">
                    🚫 <span id="titre-non-eligibles">Note/Mention insuffisante</span>
                    <span id="count-non-eligibles" class="pg-count-badge" style="background:rgba(206,17,38,0.25); color:#FF8A80;">0</span>
                </h2>
                <div id="non-eligibles-container" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:0.75rem; max-height:250px; overflow-y:auto; padding:0.25rem;"></div>
            </div>

            {{-- Pas encore évalués --}}
            <div class="pg-card">
                <h2 class="pg-section-title" style="color:var(--text-muted); margin-bottom:1.25rem; padding-bottom:0.75rem; border-bottom:2px solid var(--border-input);">
                    ⏳ <span id="titre-autres">Pas encore évalués</span>
                    <span id="count-autres" class="pg-count-badge" style="background:rgba(255,255,255,0.08); color:var(--text-muted);">0</span>
                </h2>
                <div id="autres-container" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:0.75rem; max-height:250px; overflow-y:auto; padding:0.25rem;"></div>
            </div>
        </div>

        <div id="candidats-hidden-inputs"></div>

        <div style="display:flex; gap:1rem;">
            <button type="submit" class="pg-btn-primary">✓ Créer la programmation</button>
            <a href="{{ route('programmations.index') }}" class="pg-btn-secondary">✕ Annuler</a>
        </div>
    </form>
</div>

<script>
let ajoutesManuellement = new Set();
let typeActuel = null;

function chargerCandidatsParType(typeSessionId) {
    const placeholder = document.getElementById('placeholder-empty');
    const container   = document.getElementById('resultats-container');
    const select      = document.getElementById('typeSession_id');
    const opt         = select.options[select.selectedIndex];
    typeActuel        = opt ? opt.dataset.type : null;

    if (!typeSessionId) {
        placeholder.style.display = 'block';
        container.style.display  = 'none';
        return;
    }

    const libelles = { code: 'Code', creneau: 'Créneau', conduite: 'Conduite' };
    const libelle = libelles[typeActuel] || typeActuel;

    document.getElementById('titre-eligibles').textContent     = `Candidats ayant validé ${libelle}`;
    document.getElementById('titre-non-eligibles').textContent = typeActuel === 'code' ? 'Note insuffisante (< 25)' : 'Mention insuffisante (Médiocre)';
    document.getElementById('titre-autres').textContent        = `Pas encore évalués en ${libelle}`;

    placeholder.style.display = 'none';
    container.style.display   = 'block';
    document.getElementById('eligibles-container').innerHTML     = '<div class="pg-empty-msg">Chargement...</div>';
    document.getElementById('non-eligibles-container').innerHTML = '';
    document.getElementById('autres-container').innerHTML        = '';

    fetch(`/programmations/candidats-par-type/${typeSessionId}`)
        .then(r => r.json())
        .then(data => {
            renderEligibles(data.eligibles);
            renderMotifList('non-eligibles-container', data.nonEligibles);
            renderMotifList('autres-container', data.autres);
            document.getElementById('count-eligibles').textContent     = data.eligibles.length;
            document.getElementById('count-non-eligibles').textContent = data.nonEligibles.length;
            document.getElementById('count-autres').textContent        = data.autres.length;
            updateSelection();
        });
}

function renderEligibles(list) {
    const container = document.getElementById('eligibles-container');
    if (!list.length) {
        container.innerHTML = `<div class="pg-empty-msg">Aucun candidat n'a encore validé cette étape. Utilisez l'ajout manuel si besoin.</div>`;
        return;
    }

    container.innerHTML = list.map((c, idx) => {
        const medaille = idx === 0 ? '🥇' : (idx === 1 ? '🥈' : (idx === 2 ? '🥉' : ''));
        const valeur = typeActuel === 'code'
            ? `<div style="font-weight:800; font-size:1.1rem; color:#6EE7C0;">${c.note}<span style="font-size:0.7rem; color:var(--text-muted);">/30</span></div>`
            : `<div style="font-weight:800; font-size:0.85rem; color:#6EE7C0; text-transform:uppercase;">${c.mention === 'bien' ? '🟢 Bien' : '🟡 Passable'}</div>`;

        return `
        <label data-id="${c.id}" class="pg-candidate-row" style="border-color:${idx === 0 ? 'var(--color-gold)' : 'rgba(255,255,255,0.06)'}; background:${idx === 0 ? 'rgba(252,209,22,0.06)' : 'rgba(255,255,255,0.03)'};">
            <span style="font-weight:800; font-size:0.9rem; color:var(--text-muted); width:24px; text-align:center;">${idx + 1}</span>
            <input type="checkbox" class="candidat-checkbox" value="${c.id}" checked style="width:16px;height:16px;accent-color:var(--color-green);flex-shrink:0;" onchange="updateSelection()">
            <div style="flex:1; min-width:0;">
                <div style="font-weight:700; font-size:0.875rem; color:var(--text-light);">${c.nom} ${c.prenom} ${medaille}</div>
            </div>
            ${valeur}
        </label>`;
    }).join('');
}

function renderMotifList(containerId, list) {
    const container = document.getElementById(containerId);
    if (!list.length) {
        container.innerHTML = `<div class="pg-empty-msg" style="grid-column:1/-1;">Aucun candidat dans cette catégorie.</div>`;
        return;
    }
    container.innerHTML = list.map(c => `
        <div style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; border-radius:8px; background:rgba(255,255,255,0.03); border:2px solid rgba(255,255,255,0.06); opacity:0.9;">
            <span style="font-size:1.1rem;">🚫</span>
            <div style="flex:1; min-width:0;">
                <div style="font-weight:700; font-size:0.875rem; color:var(--text-light);">${c.nom} ${c.prenom}</div>
                <div style="font-size:0.72rem; color:#FF8A80; margin-top:0.15rem;">${c.motif}</div>
            </div>
        </div>
    `).join('');
}

function toutSelectionner(val) {
    document.querySelectorAll('#eligibles-container .candidat-checkbox').forEach(cb => cb.checked = val);
    updateSelection();
}

function rechercherCandidat(q) {
    const resultsBox = document.getElementById('search-results');
    if (!q || q.length < 2) { resultsBox.style.display = 'none'; return; }

    fetch(`/programmations/rechercher-candidat?q=${encodeURIComponent(q)}`)
        .then(r => r.json())
        .then(candidats => {
            if (!candidats.length) {
                resultsBox.innerHTML = '<div style="padding:0.75rem; color:#888; font-size:0.85rem;">Aucun candidat trouvé.</div>';
            } else {
                resultsBox.innerHTML = candidats.map(c => `
                    <div class="item" onclick="ajouterManuel(${c.id}, '${c.nom} ${c.prenom}')">
                        👤 ${c.nom} ${c.prenom} <span style="color:#888; font-size:0.75rem;">(${c.statut})</span>
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
        return `<span class="pg-manual-tag">
            ➕ ${c.nom}
            <button type="button" onclick="retirerManuel(${c.id})" style="background:none;border:none;color:var(--color-red-light);cursor:pointer;font-weight:800;padding:0;margin-left:4px;">✕</button>
        </span>`;
    }).join('');
}

function updateSelection() {
    const checkedEligibles = Array.from(document.querySelectorAll('#eligibles-container .candidat-checkbox:checked')).map(cb => cb.value);
    const manuels = Array.from(ajoutesManuellement).map(item => String(JSON.parse(item).id));
    const allIds = [...new Set([...checkedEligibles, ...manuels])];

    const info = document.getElementById('selection-info');
    document.getElementById('selection-count').textContent = allIds.length;
    info.style.display = allIds.length > 0 ? 'block' : 'none';

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
</script>
</x-layouts::app>