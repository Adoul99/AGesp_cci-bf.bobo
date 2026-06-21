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
                        Type de session <span style="color:var(--color-red);">*</span>
                        <span style="background:var(--color-gold); color:var(--color-dark); font-size:0.65rem; padding:0.15rem 0.5rem; border-radius:50px; margin-left:0.5rem;">FILTRE PRINCIPAL</span>
                    </label>
                    <select name="typeSession_id" id="typeSession_id" required
                            style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-green); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white; font-weight:700;"
                            onchange="chargerCandidatsParType(this.value)">
                        <option value="">-- Choisir un type --</option>
                        @foreach($typeSessions as $ts)
                            <option value="{{ $ts->id }}" data-type="{{ $ts->type }}">
                                @switch($ts->type)
                                    @case('code') 📋 Code @break
                                    @case('creneau') 🔧 Créneau @break
                                    @case('conduite') 🚗 Conduite @break
                                    @default {{ $ts->type }}
                                @endswitch
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Date Début *</label>
                    <input type="date" name="dateDebut" value="{{ old('dateDebut', date('Y-m-d')) }}"
                           style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                           onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                </div>
                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Date Fin *</label>
                    <input type="date" name="dateFin" value="{{ old('dateFin') }}"
                           style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                           onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                </div>
                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Moniteur</label>
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
            👆 Choisissez un <strong>type de session</strong> ci-dessus pour afficher les candidats éligibles.
        </div>

        {{-- Conteneur résultats (rempli en AJAX) --}}
        <div id="resultats-container" style="display:none;">

            {{-- Candidats éligibles --}}
            <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:1.5rem;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-green);">
                    <h2 style="font-size:1rem; font-weight:700; color:var(--color-green-dark); margin:0;">
                        ✅ Candidats éligibles
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
                <div style="margin-bottom:1rem; padding:0.6rem 1rem; background:rgba(252,209,22,0.1); border-left:3px solid var(--color-gold); border-radius:var(--radius-md); font-size:0.78rem; color:var(--color-gold-dark);">
                    ⭐ Les candidats avec une moyenne ≥ 25 sont automatiquement classés en priorité.
                </div>
                <div id="eligibles-container" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:0.75rem; max-height:400px; overflow-y:auto; padding:0.25rem;"></div>
                <div id="selection-info" style="margin-top:1rem; padding:0.75rem 1rem; background:rgba(0,122,94,0.06); border-radius:var(--radius-md); font-size:0.85rem; color:var(--color-green-dark); font-weight:600; display:none;">
                    ✓ <span id="selection-count">0</span> candidat(s) sélectionné(s)
                </div>
            </div>

            {{-- Candidats non éligibles --}}
            <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:1.5rem;">
                <h2 style="font-size:1rem; font-weight:700; color:var(--color-red-dark); margin:0 0 1.25rem 0; padding-bottom:0.75rem; border-bottom:2px solid var(--color-red-light);">
                    🚫 Candidats non éligibles
                    <span id="count-non-eligibles" style="background:rgba(206,17,38,0.15); color:var(--color-red-dark); font-size:0.7rem; padding:0.2rem 0.6rem; border-radius:50px; margin-left:0.5rem; font-weight:700;">0</span>
                </h2>
                <div id="non-eligibles-container" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:0.75rem; max-height:300px; overflow-y:auto; padding:0.25rem;"></div>
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
    document.getElementById('eligibles-container').innerHTML    = '<div style="grid-column:1/-1;text-align:center;padding:1rem;color:var(--color-gray-500);">Chargement...</div>';
    document.getElementById('non-eligibles-container').innerHTML = '';

    fetch(`/programmations/candidats-par-type/${typeSessionId}`)
        .then(r => r.json())
        .then(data => {
            renderCandidats(data.eligibles, 'eligibles-container', true);
            renderCandidats(data.nonEligibles, 'non-eligibles-container', false);
            document.getElementById('count-eligibles').textContent     = data.eligibles.length;
            document.getElementById('count-non-eligibles').textContent = data.nonEligibles.length;
            updateSelection();
        });
}

function renderCandidats(list, containerId, selectable) {
    const container = document.getElementById(containerId);
    if (!list.length) {
        container.innerHTML = `<div style="grid-column:1/-1;padding:1.5rem;text-align:center;color:var(--color-gray-500);">${selectable ? 'Aucun candidat éligible pour ce type.' : 'Aucun candidat non éligible.'}</div>`;
        return;
    }

    container.innerHTML = list.map(c => {
        const prioriteBadge = c.priorite
            ? `<span style="background:var(--color-gold); color:var(--color-dark); font-size:0.65rem; padding:0.1rem 0.4rem; border-radius:50px; font-weight:700;">⭐ moy. ${c.moyenne_notes}</span>`
            : '';

        if (selectable) {
            return `
            <label data-nom="${(c.nom+' '+c.prenom).toLowerCase()}"
                   style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; border:2px solid ${c.priorite ? 'var(--color-gold)' : 'var(--color-gray-100)'}; border-radius:8px; cursor:pointer; background:white;">
                <input type="checkbox" class="candidat-checkbox" value="${c.id}" style="width:16px;height:16px;accent-color:var(--color-green);flex-shrink:0;" onchange="updateSelection()">
                <div style="flex:1; min-width:0;">
                    <div style="font-weight:700; font-size:0.875rem; color:var(--color-dark);">${c.nom} ${c.prenom} ${prioriteBadge}</div>
                </div>
            </label>`;
        } else {
            return `
            <div style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; border:2px solid var(--color-gray-100); border-radius:8px; background:#fafafa; opacity:0.85;">
                <span style="font-size:1.1rem;">🚫</span>
                <div style="flex:1; min-width:0;">
                    <div style="font-weight:700; font-size:0.875rem; color:var(--color-dark);">${c.nom} ${c.prenom}</div>
                    <div style="font-size:0.72rem; color:var(--color-red-dark); margin-top:0.15rem;">${c.motif}</div>
                </div>
            </div>`;
        }
    }).join('');
}

function toutSelectionner(val) {
    document.querySelectorAll('.candidat-checkbox').forEach(cb => cb.checked = val);
    updateSelection();
}

function updateSelection() {
    const checked = document.querySelectorAll('.candidat-checkbox:checked');
    const info = document.getElementById('selection-info');
    document.getElementById('selection-count').textContent = checked.length;
    info.style.display = checked.length > 0 ? 'block' : 'none';

    // Synchroniser les inputs hidden pour soumission
    const hiddenContainer = document.getElementById('candidats-hidden-inputs');
    hiddenContainer.innerHTML = '';
    checked.forEach(cb => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'candidat_ids[]';
        input.value = cb.value;
        hiddenContainer.appendChild(input);
    });
}
</script>
</x-layouts::app.sidebar>