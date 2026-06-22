<x-layouts::app.sidebar title="Nouvelle Programmation">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-dark: #A00D20; --color-green-light: #00A572;
    --color-green-dark: #004D3A; --color-gold-dark: #E5B800;
    --color-dark: #1A1A1A; --color-gray-100: #E8E8E8;
    --color-gray-200: #D1D1D1; --color-gray-500: #666666;
    --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
    --radius-md: 8px; --radius-lg: 12px;
}
</style>

<div class="content-wrapper" style="padding:2rem;">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; background:white; padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Nouvelle Programmation
        </h1>
        <a href="{{ route('programmations.index') }}" style="color:var(--color-gray-500); text-decoration:none; font-size:.85rem;">← Retour</a>
    </div>

    @if($errors->any())
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(206,17,38,0.1); border-left:4px solid var(--color-red); border-radius:var(--radius-md); color:var(--color-red-dark);">
        <strong>⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form id="progForm" method="POST" action="{{ route('programmations.store') }}">
        @csrf

        {{-- Paramètres --}}
        <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:1.5rem;">
            <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-bottom:1.5rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                📅 Paramètres de la Programmation
            </h2>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px,1fr)); gap:1.5rem;">

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                        Type de session / Examen <span style="color:var(--color-red);">*</span>
                    </label>
                    <select name="typeSession_id" id="typeSession_id" required
                            style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-green); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white; font-weight:700;"
                            onchange="chargerCandidatsParType(this.value)">
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
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Moniteur responsable</label>
                    <select name="moniteur_id"
                            style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                            onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                        <option value="">-- Aucun --</option>
                        @foreach($moniteurs as $m)
                            <option value="{{ $m->id }}" {{ old('moniteur_id')==$m->id ? 'selected':'' }}>👤 {{ $m->nom }} {{ $m->prenom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Message tant qu'aucun type n'est choisi --}}
        <div id="placeholder-empty" style="background:white; padding:3rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); text-align:center; color:var(--color-gray-500);">
            👆 Choisissez un <strong>type d'examen</strong> ci-dessus pour afficher le classement par mérite des candidats.
        </div>

        {{-- Conteneur résultats (rempli en AJAX) --}}
        <div id="resultats-container" style="display:none;">

            {{-- Candidats éligibles — classés par mérite --}}
            <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:1.5rem;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-green);">
                    <h2 style="font-size:1rem; font-weight:700; color:var(--color-green-dark); margin:0;">
                        🏆 Classement par mérite (note ≥ 25)
                        <span id="count-eligibles" style="background:var(--color-green); color:white; font-size:0.7rem; padding:0.2rem 0.6rem; border-radius:50px; margin-left:0.5rem; font-weight:700;">0</span>
                    </h2>
                    <div style="display:flex; gap:0.75rem;">
                        <button type="button" onclick="toutSelectionner(true)"
                                style="padding:0.5rem 1rem; background:rgba(0,122,94,0.1); color:var(--color-green-dark); border:1.5px solid var(--color-green); border-radius:var(--radius-md); font-size:0.8rem; font-weight:600; cursor:pointer;">
                            ✓ Tous
                        </button>
                        <button type="button" onclick="toutSelectionner(false)"
                                style="padding:0.5rem 1rem; background:var(--color-gray-100); color:var(--color-gray-500); border:1.5px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.8rem; font-weight:600; cursor:pointer;">
                            ✕ Aucun
                        </button>
                    </div>
                </div>
                <div id="eligibles-container" style="display:flex; flex-direction:column; gap:0.5rem; max-height:420px; overflow-y:auto; padding:0.25rem;"></div>
                <div id="selection-info" style="margin-top:1rem; padding:0.75rem 1rem; background:rgba(0,122,94,0.06); border-radius:var(--radius-md); font-size:0.85rem; color:var(--color-green-dark); font-weight:600; display:none;">
                    ✓ <span id="selection-count">0</span> candidat(s) sélectionné(s) pour l'examen
                </div>
            </div>

            {{-- Ajout manuel --}}
            <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:2px solid var(--color-gold); margin-bottom:1.5rem;">
                <h2 style="font-size:1rem; font-weight:700; color:var(--color-gold-dark); margin:0 0 1rem 0; display:flex; align-items:center; gap:0.5rem;">
                    ➕ Ajouter un candidat manuellement
                </h2>
                <p style="font-size:0.8rem; color:var(--color-gray-500); margin-bottom:1rem;">
                    Pour un candidat ne remplissant pas les conditions (note &lt; 25 ou pas encore évalué), mais que vous souhaitez tout de même programmer.
                </p>
                <div style="position:relative;">
                    <input type="text" id="search-candidat" placeholder="🔍 Rechercher un candidat par nom..." autocomplete="off"
                           style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem;"
                           oninput="rechercherCandidat(this.value)">
                    <div id="search-results" style="display:none; position:absolute; top:100%; left:0; right:0; background:white; border:1px solid var(--color-gray-200); border-radius:var(--radius-md); box-shadow:var(--shadow-md); z-index:10; max-height:250px; overflow-y:auto; margin-top:4px;"></div>
                </div>
                <div id="ajoutes-manuellement" style="margin-top:1rem; display:flex; flex-wrap:wrap; gap:0.5rem;"></div>
            </div>

            {{-- Candidats non éligibles (note < 25) --}}
            <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:1.5rem;">
                <h2 style="font-size:1rem; font-weight:700; color:var(--color-red-dark); margin:0 0 1.25rem 0; padding-bottom:0.75rem; border-bottom:2px solid var(--color-red-light);">
                    🚫 Note insuffisante (&lt; 25)
                    <span id="count-non-eligibles" style="background:rgba(206,17,38,0.15); color:var(--color-red-dark); font-size:0.7rem; padding:0.2rem 0.6rem; border-radius:50px; margin-left:0.5rem; font-weight:700;">0</span>
                </h2>
                <div id="non-eligibles-container" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:0.75rem; max-height:250px; overflow-y:auto; padding:0.25rem;"></div>
            </div>
        </div>

        <div id="candidats-hidden-inputs"></div>

        {{-- Boutons --}}
        <div style="display:flex; gap:1rem;">
            <button type="submit"
                    style="background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white; padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-red); font-weight:700; cursor:pointer; font-size:0.875rem; text-transform:uppercase;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                ✓ Créer la programmation
            </button>
            <a href="{{ route('programmations.index') }}"
               style="background:var(--color-gray-100); color:var(--color-dark); padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-gray-200); font-weight:600; text-decoration:none; font-size:0.875rem; text-transform:uppercase; display:inline-flex; align-items:center;">
                ✕ Annuler
            </a>
        </div>
    </form>
</div>

<script>
let ajoutesManuellement = new Set();

function chargerCandidatsParType(typeSessionId) {
    const placeholder = document.getElementById('placeholder-empty');
    const container   = document.getElementById('resultats-container');

    if (!typeSessionId) {
        placeholder.style.display = 'block';
        container.style.display  = 'none';
        return;
    }

    placeholder.style.display = 'none';
    container.style.display   = 'block';
    document.getElementById('eligibles-container').innerHTML    = '<div style="text-align:center;padding:1rem;color:var(--color-gray-500);">Chargement...</div>';
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
        container.innerHTML = `<div style="padding:1.5rem;text-align:center;color:var(--color-gray-500);">Aucun candidat n'a encore une note ≥ 25 pour ce type. Utilisez l'ajout manuel si besoin.</div>`;
        return;
    }

    container.innerHTML = list.map((c, idx) => `
        <label data-id="${c.id}"
               style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; border:2px solid ${idx === 0 ? 'var(--color-gold)' : 'var(--color-gray-100)'}; border-radius:8px; cursor:pointer; background:${idx === 0 ? 'rgba(252,209,22,0.06)' : 'white'};">
            <span style="font-weight:800; font-size:0.9rem; color:var(--color-gray-500); width:24px; text-align:center;">${idx + 1}</span>
            <input type="checkbox" class="candidat-checkbox" value="${c.id}" checked style="width:16px;height:16px;accent-color:var(--color-green);flex-shrink:0;" onchange="updateSelection()">
            <div style="flex:1; min-width:0;">
                <div style="font-weight:700; font-size:0.875rem; color:var(--color-dark);">${c.nom} ${c.prenom} ${idx === 0 ? '🥇' : (idx === 1 ? '🥈' : (idx === 2 ? '🥉' : ''))}</div>
            </div>
            <div style="font-weight:800; font-size:1.1rem; color:var(--color-green-dark);">${c.note}<span style="font-size:0.7rem; color:var(--color-gray-500);">/30</span></div>
        </label>
    `).join('');
}

function renderNonEligibles(list) {
    const container = document.getElementById('non-eligibles-container');
    if (!list.length) {
        container.innerHTML = `<div style="grid-column:1/-1;padding:1.5rem;text-align:center;color:var(--color-gray-500);">Aucun candidat dans cette catégorie.</div>`;
        return;
    }
    container.innerHTML = list.map(c => `
        <div style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; border:2px solid var(--color-gray-100); border-radius:8px; background:#fafafa; opacity:0.85;">
            <span style="font-size:1.1rem;">🚫</span>
            <div style="flex:1; min-width:0;">
                <div style="font-weight:700; font-size:0.875rem; color:var(--color-dark);">${c.nom} ${c.prenom}</div>
                <div style="font-size:0.72rem; color:var(--color-red-dark); margin-top:0.15rem;">${c.motif}</div>
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
                resultsBox.innerHTML = '<div style="padding:0.75rem; color:var(--color-gray-500); font-size:0.85rem;">Aucun candidat trouvé.</div>';
            } else {
                resultsBox.innerHTML = candidats.map(c => `
                    <div onclick="ajouterManuel(${c.id}, '${c.nom} ${c.prenom}')"
                         style="padding:0.65rem 1rem; cursor:pointer; border-bottom:1px solid var(--color-gray-100); font-size:0.85rem;"
                         onmouseover="this.style.background='rgba(0,122,94,0.06)'" onmouseout="this.style.background='white'">
                        👤 ${c.nom} ${c.prenom} <span style="color:var(--color-gray-500); font-size:0.75rem;">(${c.statut})</span>
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
        return `<span style="display:inline-flex; align-items:center; gap:0.4rem; background:rgba(252,209,22,0.15); border:1.5px solid var(--color-gold); color:var(--color-gold-dark); padding:0.4rem 0.75rem; border-radius:50px; font-size:0.8rem; font-weight:600;">
            ➕ ${c.nom}
            <button type="button" onclick="retirerManuel(${c.id})" style="background:none;border:none;color:var(--color-red);cursor:pointer;font-weight:800;padding:0;margin-left:4px;">✕</button>
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
</x-layouts::app.sidebar>