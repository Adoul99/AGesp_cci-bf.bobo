<x-layouts::app title="Nouvel Examen">
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

.ex-card {
    background: var(--bg-card); border: 1px solid rgba(255,255,255,0.06);
    border-radius: var(--radius-lg); box-shadow: var(--shadow-md);
    padding: 1.75rem 2rem; margin-bottom: 1.5rem;
}

.ex-label {
    display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem;
    text-transform:uppercase; letter-spacing:0.5px; color:var(--text-light);
}

.ex-input {
    width:100%; padding:0.75rem 1rem; border:2px solid var(--border-input);
    border-radius:var(--radius-md); font-size:0.875rem; color:#1A1A1A;
    background:var(--bg-input); transition: border-color 200ms ease, box-shadow 200ms ease;
}
.ex-input:focus { outline:none; border-color:var(--color-gold); box-shadow:0 0 0 3px rgba(252,209,22,0.25); }

.ex-statut-locked {
    width:100%; padding:0.75rem 1rem; border:2px solid var(--color-green-light);
    border-radius:var(--radius-md); background:rgba(0,165,114,0.15); color:#6EE7C0;
    font-weight:700; font-size:0.875rem; display:flex; align-items:center; gap:0.5rem;
}

.ex-btn-primary {
    background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white;
    padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-red); font-weight:700;
    cursor:pointer; font-size:0.875rem; text-transform:uppercase;
}
.ex-btn-secondary {
    background:transparent; color:var(--text-light); padding:0.875rem 2rem; border-radius:var(--radius-md);
    border:2px solid var(--border-input); font-weight:600; text-decoration:none; font-size:0.875rem;
    text-transform:uppercase; display:inline-flex; align-items:center;
}

/* --- Dropdown custom (même comportement que programmations/create) --- */
.ex-dropdown { position: relative; }
.ex-dropdown-field {
    display:flex; justify-content:space-between; align-items:center; cursor:pointer; user-select:none;
}
.ex-dropdown-panel {
    display:none; position:absolute; top:100%; left:0; right:0; margin-top:6px;
    background:#fff; border:2px solid var(--border-input); border-radius:12px;
    max-height:260px; overflow-y:auto; z-index:20; box-shadow:var(--shadow-md);
}
.ex-dropdown-panel.open { display:block; }
.ex-dropdown-item {
    padding:0.65rem 1rem; display:flex; align-items:center; gap:0.6rem;
    cursor:pointer; font-size:0.875rem; color:#1A1A1A; font-weight:600;
}
.ex-dropdown-item:hover { background: rgba(0,122,94,0.08); }
.ex-dropdown-item.selected { background: var(--color-green); color:white; }
.ex-dropdown-arrow { transition: transform 200ms ease; flex-shrink:0; }
.ex-dropdown-arrow.open { transform: rotate(180deg); }

.ex-dropdown-search { padding:0.6rem; position:sticky; top:0; background:#fff; border-bottom:1px solid #eee; }
.ex-dropdown-checkitem {
    padding:0.6rem 1rem; display:flex; align-items:center; gap:0.6rem;
    cursor:pointer; font-size:0.85rem; color:#1A1A1A; font-weight:400;
}
.ex-dropdown-checkitem:hover { background: rgba(0,122,94,0.08); }
.ex-dropdown-checkitem input[type=checkbox] { width:16px; height:16px; accent-color:var(--color-green); }

.ex-empty-msg { padding:1.25rem; text-align:center; color:var(--text-muted); font-size:0.85rem; }
</style>

<div class="content-wrapper">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; background:var(--bg-card); padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--text-light); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Nouvel Examen
        </h1>
        <a href="{{ route('examens.index') }}" style="color:var(--text-muted); text-decoration:none; font-size:.85rem;">← Retour</a>
    </div>

    @if($errors->any())
    <div class="ex-card" style="border-color: rgba(206,17,38,0.4); background: rgba(206,17,38,0.12);">
        <strong style="color:#FFD6D0;">⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem; color:#FFD6D0;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('examens.store') }}">
        @csrf

        {{-- Informations générales --}}
        <div class="ex-card">
            <h2 style="font-size:1rem; font-weight:700; color:var(--text-light); margin-bottom:1.5rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                📋 Informations Générales
            </h2>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px,1fr)); gap:1.5rem;">

                <div>
                    <label class="ex-label">Libellé <span style="color:var(--color-red-light);">*</span></label>
                    <input type="text" name="libelle" value="{{ old('libelle') }}" placeholder="Ex: Examen Permis E - Session 2026" class="ex-input" required>
                </div>

                <div>
                    <label class="ex-label">Type d'examen <span style="color:var(--color-red-light);">*</span></label>

                    {{-- Champ compact type "GROUPE" / programmations-create : ouvre/ferme la liste au clic --}}
                    <div class="ex-dropdown" id="typeSessionDropdown">
                        <div class="ex-input ex-dropdown-field" onclick="toggleTypeSessionDropdown()">
                            <span id="typeSessionLabel">-- Choisir --</span>
                            <svg id="typeSessionArrow" class="ex-dropdown-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                        <div id="typeSessionPanel" class="ex-dropdown-panel">
                            @foreach($typeSessions as $ts)
                                @php
                                    $libelleTs = match($ts->type) {
                                        'code' => '📋 Code',
                                        'creneau' => '🔧 Créneau',
                                        'conduite' => '🚗 Conduite',
                                        default => $ts->type,
                                    };
                                @endphp
                                <div class="ex-dropdown-item" data-id="{{ $ts->id }}" data-label="{{ $libelleTs }}" onclick="selectTypeSession('{{ $ts->id }}', '{{ $libelleTs }}', this)">
                                    {{ $libelleTs }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <input type="hidden" name="typeSession_id" id="typeSession_id" value="{{ old('typeSession_id') }}" required>
                </div>

                <div>
                    <label class="ex-label">Statut <span style="color:var(--color-red-light);">*</span></label>
                    <div class="ex-statut-locked">🟢 Ouvert</div>
                    <input type="hidden" name="statutExamen" value="ouvert">
                    <p style="margin-top:0.4rem; font-size:0.7rem; color:var(--text-muted);">Un nouvel examen est toujours créé « Ouvert ». Modifiable depuis la page d'édition une fois créé.</p>
                </div>

                <div>
                    <label class="ex-label">Date <span style="color:var(--color-red-light);">*</span></label>
                    <input type="date" name="dateDebut" value="{{ old('dateDebut', date('Y-m-d')) }}" class="ex-input" required>
                </div>

                <div>
                    <label class="ex-label">Lieu de l'examen</label>
                    <input type="text" name="lieu" value="{{ old('lieu') }}" placeholder="Ex: DGTTM Bobo-Dioulasso" class="ex-input">
                </div>

                <div>
                    <label class="ex-label">
                        Moniteur
                        @if($moniteurConnecte)
                            <span style="background:var(--color-green-light); color:white; font-size:0.65rem; padding:0.15rem 0.5rem; border-radius:50px; margin-left:0.5rem; text-transform:uppercase;">AUTO</span>
                        @endif
                    </label>
                    @if($moniteurConnecte)
                        <div style="padding:0.75rem 1rem; border:2px solid var(--color-green-light); border-radius:var(--radius-md); background:rgba(0,165,114,0.15); color:#FFFFFF; font-weight:700; font-size:0.875rem; display:flex; align-items:center; gap:0.5rem;">
                            🔒 {{ $moniteurConnecte->nom }} {{ $moniteurConnecte->prenom }}
                        </div>
                        <input type="hidden" name="moniteur_id" value="{{ $moniteurConnecte->id }}">
                    @else
                        <select name="moniteur_id" class="ex-input">
                            <option value="">-- Aucun --</option>
                            @foreach($moniteurs as $m)
                                <option value="{{ $m->id }}" {{ old('moniteur_id')==$m->id ? 'selected':'' }}>{{ $m->nom }} {{ $m->prenom }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>

        {{-- Candidats programmés --}}
        <div class="ex-card">
            <h2 style="font-size:1rem; font-weight:700; color:var(--text-light); margin-bottom:1rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                👥 Candidats programmés — à inscrire à cet examen
            </h2>

            <div id="candidats-placeholder" style="padding:1.5rem; text-align:center; color:var(--text-muted); font-size:0.85rem;">
                👆 Choisissez d'abord un <strong style="color:var(--text-light);">type d'examen</strong> ci-dessus pour voir les candidats programmés correspondants.
            </div>

            <div id="candidats-wrapper" style="display:none;">
                {{-- Champ compact type "GROUPE" : ouvre/ferme la liste au clic --}}
                <div class="ex-dropdown" id="candidatDropdown">
                    <div class="ex-input ex-dropdown-field" onclick="toggleCandidatDropdown()">
                        <span id="candidatFieldLabel">-- Choisir un ou plusieurs candidats --</span>
                        <svg id="candidatArrow" class="ex-dropdown-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <div id="candidatPanel" class="ex-dropdown-panel">
                        <div class="ex-dropdown-search">
                            <input type="text" id="candidatSearch" onkeyup="filterCandidats()"
                                   placeholder="🔍 Rechercher un candidat par nom ou prénom..." class="ex-input" style="margin:0;">
                        </div>
                        <div id="candidatList"></div>
                    </div>
                </div>

                <p style="margin-top:0.75rem; font-size:0.75rem; color:var(--text-muted);">
                    ℹ️ Seuls les candidats déjà programmés pour ce type précis, et pas encore inscrits à un examen de ce type, apparaissent ici.
                </p>
            </div>
        </div>

        <div id="candidats-hidden-inputs"></div>

        <div style="display:flex; gap:1rem;">
            <button type="submit" class="ex-btn-primary">✓ Créer l'examen</button>
            <a href="{{ route('examens.index') }}" class="ex-btn-secondary">✕ Annuler</a>
        </div>
    </form>
</div>

<script>
var candidatsCourants = [];

function toggleTypeSessionDropdown() {
    document.getElementById('typeSessionPanel').classList.toggle('open');
    document.getElementById('typeSessionArrow').classList.toggle('open');
}

function selectTypeSession(id, label, el) {
    document.getElementById('typeSession_id').value = id;
    document.getElementById('typeSessionLabel').textContent = label;

    document.querySelectorAll('#typeSessionPanel .ex-dropdown-item').forEach(function(item) {
        item.classList.remove('selected');
    });
    el.classList.add('selected');

    document.getElementById('typeSessionPanel').classList.remove('open');
    document.getElementById('typeSessionArrow').classList.remove('open');

    chargerCandidats(id);
}

function chargerCandidats(typeSessionId) {
    var placeholder = document.getElementById('candidats-placeholder');
    var wrapper = document.getElementById('candidats-wrapper');

    if (!typeSessionId) {
        placeholder.style.display = 'block';
        wrapper.style.display = 'none';
        return;
    }

    placeholder.style.display = 'none';
    wrapper.style.display = 'block';
    document.getElementById('candidatList').innerHTML = '<div class="ex-dropdown-checkitem" style="cursor:default;">Chargement...</div>';

    fetch('/examens/candidats-par-type/' + typeSessionId)
        .then(function(r) { return r.json(); })
        .then(function(data) {
            candidatsCourants = data.candidats;
            renderCandidats(candidatsCourants);
            updateCandidatSelection();
        });
}

function renderCandidats(list) {
    var container = document.getElementById('candidatList');
    if (!list.length) {
        container.innerHTML = '<div class="ex-empty-msg">📭 Aucun candidat programmé pour ce type et pas encore inscrit à un examen correspondant.</div>';
        return;
    }

    container.innerHTML = list.map(function(c) {
        var search = (c.nom + ' ' + c.prenom).toLowerCase();
        return '<label class="ex-dropdown-checkitem" data-search="' + search + '">'
            + '<input type="checkbox" value="' + c.id + '" onchange="updateCandidatSelection()">'
            + c.nom + ' ' + c.prenom
            + '</label>';
    }).join('');
}

function filterCandidats() {
    var query = document.getElementById('candidatSearch').value.toLowerCase().trim();
    document.querySelectorAll('#candidatList .ex-dropdown-checkitem').forEach(function(item) {
        item.style.display = (item.dataset.search || '').indexOf(query) !== -1 ? '' : 'none';
    });
}

function toggleCandidatDropdown() {
    document.getElementById('candidatPanel').classList.toggle('open');
    document.getElementById('candidatArrow').classList.toggle('open');
}

function updateCandidatSelection() {
    var checked = Array.from(document.querySelectorAll('#candidatList input[type=checkbox]:checked')).map(function(cb) { return cb.value; });

    document.getElementById('candidatFieldLabel').textContent = checked.length > 0
        ? (checked.length + ' candidat(s) sélectionné(s)')
        : '-- Choisir un ou plusieurs candidats --';

    var hiddenContainer = document.getElementById('candidats-hidden-inputs');
    hiddenContainer.innerHTML = '';
    checked.forEach(function(id) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'candidat_ids[]';
        input.value = id;
        hiddenContainer.appendChild(input);
    });
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('#typeSessionDropdown')) {
        document.getElementById('typeSessionPanel').classList.remove('open');
        document.getElementById('typeSessionArrow').classList.remove('open');
    }
    if (!e.target.closest('#candidatDropdown')) {
        var panel = document.getElementById('candidatPanel');
        var arrow = document.getElementById('candidatArrow');
        if (panel) panel.classList.remove('open');
        if (arrow) arrow.classList.remove('open');
    }
});
</script>
</x-layouts::app>