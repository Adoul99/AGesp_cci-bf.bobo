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

    {{-- En-tête --}}
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

    {{-- CANDIDATS ADMIS → pour l'examen --}}
    @if($candidatsAdmis->isNotEmpty())
    <div style="margin-bottom:1.5rem; padding:1.25rem 1.5rem; background:rgba(0,122,94,0.08); border:2px solid var(--color-green); border-radius:var(--radius-lg);">
        <strong style="color:var(--color-green-dark);">🏆 {{ $candidatsAdmis->count() }} candidat(s) admis — programmables pour l'examen</strong>
        <span style="color:var(--color-gray-500); font-size:0.8rem; margin-left:0.5rem;">(Code + Créneau + Conduite validés)</span>
        <div style="margin-top:0.75rem; display:flex; flex-wrap:wrap; gap:0.5rem;">
            @foreach($candidatsAdmis as $c)
            <span style="background:rgba(0,122,94,0.15); color:var(--color-green-dark); padding:0.3rem 0.75rem; border-radius:50px; font-size:0.8rem; font-weight:700; border:1.5px solid var(--color-green);">
                🏆 {{ $c->nom }} {{ $c->prenom }}
            </span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- CANDIDATS AVEC ≥ 5 SESSIONS --}}
    @if($candidats5Sessions->isNotEmpty())
    <div style="margin-bottom:1.5rem; padding:1.25rem 1.5rem; background:rgba(252,209,22,0.1); border:2px solid var(--color-gold); border-radius:var(--radius-lg);">
        <strong style="color:var(--color-gold-dark);">⭐ {{ $candidats5Sessions->count() }} candidat(s) ayant participé ≥ 5 fois à des sessions de formation</strong>
        <span style="color:var(--color-gray-500); font-size:0.8rem; margin-left:0.5rem;">— Priorité de programmation</span>
        <div style="margin-top:0.75rem; display:flex; flex-wrap:wrap; gap:0.5rem;">
            @foreach($candidats5Sessions as $c)
            <label style="display:flex; align-items:center; gap:0.4rem; background:white; border:2px solid var(--color-gold); border-radius:var(--radius-md); padding:0.4rem 0.75rem; cursor:pointer; font-size:0.8rem; font-weight:600; color:var(--color-dark);">
                <input type="checkbox" name="candidat_ids[]" value="{{ $c->id }}" form="progForm"
                       style="accent-color:var(--color-green);">
                ⭐ {{ $c->nom }} {{ $c->prenom }}
                <span style="background:var(--color-gold); color:var(--color-dark); padding:0.1rem 0.5rem; border-radius:50px; font-size:0.7rem; font-weight:700;">{{ $c->nb_sessions }} sessions</span>
            </label>
            @endforeach
        </div>
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
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Groupe</label>
                    <select name="groupe_id" id="groupe_id"
                            style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                            onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'"
                            onchange="chargerCandidatsGroupe(this.value)">
                        <option value="">-- Aucun groupe --</option>
                        @foreach($groupes as $g)
                            <option value="{{ $g->id }}" {{ old('groupe_id')==$g->id ? 'selected':'' }}>👥 {{ $g->nomGroupe }}</option>
                        @endforeach
                    </select>
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

        {{-- Sélection candidats --}}
        <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:1.5rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin:0;">
                    👥 Candidats programmables
                    <span id="count-badge" style="background:var(--color-green); color:white; font-size:0.7rem; padding:0.2rem 0.6rem; border-radius:50px; margin-left:0.5rem; font-weight:700;">
                        {{ $candidatsProgrammables->count() }}
                    </span>
                </h2>
                <div style="display:flex; gap:0.75rem; align-items:center;">
                    <input type="text" id="search-candidat" placeholder="🔍 Rechercher..." oninput="filtrerCandidats(this.value)"
                           style="padding:0.5rem 0.75rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.8rem; width:200px;"
                           onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
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

            <div id="candidats-container" style="display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:0.75rem; max-height:400px; overflow-y:auto; padding:0.25rem;">
                @forelse($candidatsProgrammables as $c)
                <label id="card-{{ $c->id }}" data-nom="{{ strtolower($c->nom.' '.$c->prenom) }}"
                       style="display:flex; align-items:center; gap:0.75rem; padding:0.75rem 1rem; border:2px solid var(--color-gray-100); border-radius:var(--radius-md); cursor:pointer; transition:all 0.2s; background:white;"
                       onmouseover="this.style.borderColor='var(--color-green)'; this.style.background='rgba(0,122,94,0.04)'"
                       onmouseout="this.style.borderColor='var(--color-gray-100)'; this.style.background='white'">
                    <input type="checkbox" name="candidat_ids[]" value="{{ $c->id }}"
                           style="width:16px; height:16px; accent-color:var(--color-green); flex-shrink:0;"
                           onchange="updateSelection()">
                    <div style="flex:1; min-width:0;">
                        <div style="font-weight:700; font-size:0.875rem; color:var(--color-dark);">
                            {{ $c->nom }} {{ $c->prenom }}
                            @if($c->statut === 'admis')
                                <span style="background:rgba(0,122,94,0.15); color:var(--color-green-dark); font-size:0.65rem; padding:0.1rem 0.5rem; border-radius:50px; font-weight:700; margin-left:4px;">🏆 EXAMEN</span>
                            @elseif($c->nb_sessions >= 5)
                                <span style="background:var(--color-gold); color:var(--color-dark); font-size:0.65rem; padding:0.1rem 0.4rem; border-radius:50px; font-weight:700;">⭐ {{ $c->nb_sessions }}×</span>
                            @endif
                        </div>
                        <div style="font-size:0.75rem; color:var(--color-gray-500); margin-top:0.15rem;">
                            {{ $c->nb_sessions }} session(s) · Statut:
                            @switch($c->statut)
                                @case('inscrit') <span style="color:#666;">Inscrit</span> @break
                                @case('en_formation') <span style="color:var(--color-green);">En formation</span> @break
                                @case('ajourne') <span style="color:var(--color-red);">Ajourné</span> @break
                                @default {{ $c->statut }}
                            @endswitch
                        </div>
                    </div>
                </label>
                @empty
                <div style="grid-column:1/-1; padding:2rem; text-align:center; color:var(--color-gray-500);">
                    ✅ Tous les candidats sont déjà admis ou au niveau code.
                </div>
                @endforelse
            </div>

            <div id="selection-info" style="margin-top:1rem; padding:0.75rem 1rem; background:rgba(0,122,94,0.06); border-radius:var(--radius-md); font-size:0.85rem; color:var(--color-green-dark); font-weight:600; display:none;">
                ✓ <span id="selection-count">0</span> candidat(s) sélectionné(s)
            </div>
        </div>

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
function filtrerCandidats(q) {
    const terme = q.toLowerCase();
    document.querySelectorAll('#candidats-container label[data-nom]').forEach(card => {
        card.style.display = card.dataset.nom.includes(terme) ? 'flex' : 'none';
    });
}

function toutSelectionner(val) {
    document.querySelectorAll('#candidats-container input[type=checkbox]').forEach(cb => {
        if (cb.closest('label').style.display !== 'none') cb.checked = val;
    });
    updateSelection();
}

function updateSelection() {
    const count = document.querySelectorAll('#candidats-container input[type=checkbox]:checked').length;
    const info = document.getElementById('selection-info');
    document.getElementById('selection-count').textContent = count;
    info.style.display = count > 0 ? 'block' : 'none';
}

function chargerCandidatsGroupe(groupeId) {
    if (!groupeId) return;
    // Désélectionner tout d'abord
    toutSelectionner(false);
    // Charger les candidats du groupe via AJAX et les cocher
    fetch(`/groupes/${groupeId}/candidats`)
        .then(r => r.json())
        .then(candidats => {
            candidats.forEach(c => {
                const cb = document.querySelector(`input[name="candidat_ids[]"][value="${c.id}"]`);
                if (cb) cb.checked = true;
            });
            updateSelection();
        });
}
</script>
</x-layouts::app.sidebar>
