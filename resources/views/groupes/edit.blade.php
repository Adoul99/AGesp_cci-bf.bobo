<x-layouts::app.sidebar title="Modifier Groupe">
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

.content-wrapper {
    background: var(--bg-page);
    min-height: 100vh;
    padding: 2.5rem;
    font-family: inherit;
}

.gp-pill {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: rgba(206,17,38,0.18); border: 1px solid rgba(206,17,38,0.4);
    color: #FFD6D0; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.06em; padding: 0.4rem 0.9rem; border-radius: 50px; margin-bottom: 1.25rem;
}
.gp-pill .dot { width: 7px; height: 7px; border-radius: 50%; background: var(--color-red); box-shadow: 0 0 6px var(--color-red); }

.gp-title {
    font-size: 2.25rem; font-weight: 800; color: var(--text-light); margin: 0 0 0.5rem 0; letter-spacing: -0.5px;
}
.gp-subtitle { color: var(--text-muted); font-size: 0.95rem; margin-bottom: 2rem; }

.gp-card {
    background: var(--card-bg); border: 1px solid var(--card-border);
    border-radius: var(--radius-lg); padding: 1.75rem 2rem; margin-bottom: 1.5rem;
    box-shadow: var(--shadow-md); backdrop-filter: blur(6px);
}

.gp-step-head { display: flex; align-items: center; gap: 0.9rem; margin-bottom: 1.5rem; }
.gp-step-num {
    width: 32px; height: 32px; border-radius: 9px; background: var(--color-red);
    color: white; font-weight: 800; font-size: 0.95rem; display: flex; align-items: center;
    justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(206,17,38,0.4);
}
.gp-step-title { font-size: 1.1rem; font-weight: 700; color: var(--text-light); margin: 0; }

.gp-field-label {
    display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.78rem;
    text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-muted);
}
.gp-input {
    width: 100%; padding: 0.85rem 1.1rem; border: 1.5px solid var(--input-border);
    border-radius: var(--radius-md); font-size: 0.9rem; color: var(--text-light);
    background: var(--input-bg); transition: border-color 200ms ease, box-shadow 200ms ease;
}
.gp-input::placeholder { color: rgba(244,249,246,0.35); }
.gp-input:focus { outline: none; border-color: var(--color-gold); box-shadow: 0 0 0 3px rgba(252,209,22,0.18); }
.gp-input::-webkit-calendar-picker-indicator { filter: invert(1) opacity(0.7); }

/* ── Multi-select "listbox" façon image de référence ── */
.gp-multiselect {
    width: 100%;
    min-height: 210px;
    padding: 0.4rem;
    border: 1.5px solid var(--input-border);
    border-radius: var(--radius-md);
    background: var(--input-bg);
    color: var(--text-light);
    font-size: 0.9rem;
}
.gp-multiselect:focus { outline: none; border-color: var(--color-gold); box-shadow: 0 0 0 3px rgba(252,209,22,0.18); }
.gp-multiselect option {
    padding: 0.55rem 0.75rem;
    border-radius: 6px;
    color: var(--text-light);
    background: transparent;
}
.gp-multiselect option:checked {
    background: linear-gradient(0deg, var(--color-green) 0%, var(--color-green) 100%);
    background-color: var(--color-green) !important;
    color: white;
}
.gp-multiselect option:disabled {
    color: rgba(255,138,128,0.75);
    background: rgba(206,17,38,0.08);
}

.gp-search-row { display: flex; gap: 0.75rem; flex-wrap: wrap; margin-bottom: 0.85rem; }
.gp-search-input { flex: 1; min-width: 220px; }

.gp-filter-chip {
    display: flex; align-items: center; gap: 0.5rem; cursor: pointer;
    font-size: 0.78rem; font-weight: 600; color: #BFEBD8;
    background: rgba(0,122,94,0.18); padding: 0.6rem 0.9rem; border-radius: var(--radius-md);
    border: 1px solid rgba(0,165,114,0.35); white-space: nowrap;
}
.gp-filter-chip input { width: 1.05rem; height: 1.05rem; accent-color: var(--color-green-light); cursor: pointer; }

.gp-counter { color: #BFEBD8; font-weight: 800; }

.gp-btn-primary {
    background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%);
    color: white; padding: 0.9rem 2.2rem; border-radius: var(--radius-md); border: 2px solid var(--color-green);
    font-weight: 700; cursor: pointer; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.04em;
}
.gp-btn-secondary {
    background: transparent; color: var(--text-light); padding: 0.9rem 2.2rem; border-radius: var(--radius-md);
    border: 2px solid var(--input-border); font-weight: 600; text-decoration: none; font-size: 0.875rem;
    text-transform: uppercase; letter-spacing: 0.04em; display: inline-flex; align-items: center;
}
</style>

<div class="content-wrapper">

    <span class="gp-pill"><span class="dot"></span> CCI-BF — BOBO-DIOULASSO</span>
    <h1 class="gp-title">Modifier Groupe</h1>
    <p class="gp-subtitle">Édition des paramètres du groupe « {{ $groupe->nomGroupe }} ».</p>

    @if($errors->any())
    <div class="gp-card" style="border-color: rgba(206,17,38,0.4); background: rgba(206,17,38,0.1);">
        <strong style="color:#FFD6D0;">⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem; color:#FFD6D0;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('groupes.update', $groupe->id) }}">
        @csrf
        @method('PUT')

        <div class="gp-card">
            <div class="gp-step-head">
                <span class="gp-step-num">1</span>
                <h2 class="gp-step-title">Édition des Paramètres</h2>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px,1fr)); gap:1.75rem;">
                <div>
                    <label class="gp-field-label">Nom Groupe <span style="color:var(--color-red-light);">*</span></label>
                    <input type="text" id="nomGroupe" name="nomGroupe"
                           value="{{ old('nomGroupe', $groupe->nomGroupe) }}" class="gp-input" required>
                </div>
                <div>
                    <label class="gp-field-label">Date Début Formation <span style="color:var(--color-red-light);">*</span></label>
                    <input type="date" id="dateDebutFormation" name="dateDebutFormation"
                           value="{{ old('dateDebutFormation', $groupe->dateDebutFormation) }}" class="gp-input" required>
                </div>
            </div>
        </div>

        <div class="gp-card">
            <div class="gp-step-head">
                <span class="gp-step-num">2</span>
                <h2 class="gp-step-title">
                    Sélection des Candidats
                    — <span class="gp-counter" id="compteurCandidats">0</span> sélectionné(s)
                </h2>
            </div>

            <div class="gp-search-row">
                <input type="text" id="rechercheCandidat" class="gp-input gp-search-input"
                       placeholder="🔍 Rechercher un candidat par nom...">
                <label class="gp-filter-chip">
                    <input type="checkbox" id="filtreSansGroupe">
                    Afficher uniquement les candidats sans groupe
                </label>
            </div>

            <select id="candidatsSelect" name="candidat_ids[]" multiple size="10" class="gp-multiselect">
                @foreach($candidats as $candidat)
                    @php
                        $groupeExistant = $candidat->groupes->first();
                        $dejaDansAutreGroupe = $groupeExistant && $groupeExistant->id != $groupe->id;
                    @endphp
                    @if($dejaDansAutreGroupe)
                        <option value="{{ $candidat->id }}" disabled data-nom="{{ strtolower($candidat->nom.' '.$candidat->prenom) }}" data-a-groupe="1">
                            {{ $candidat->nom }} {{ $candidat->prenom }} 🔒 (déjà dans : {{ $groupeExistant->nomGroupe }})
                        </option>
                    @else
                        <option value="{{ $candidat->id }}" data-nom="{{ strtolower($candidat->nom.' '.$candidat->prenom) }}" data-a-groupe="0"
                                {{ in_array($candidat->id, $candidatsSelectionnes) ? 'selected' : '' }}>
                            {{ $candidat->nom }} {{ $candidat->prenom }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div style="display:flex; gap:1rem;">
            <button type="submit" class="gp-btn-primary">✓ Mettre à jour</button>
            <a href="{{ route('groupes.index') }}" class="gp-btn-secondary">✕ Annuler</a>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectEl   = document.getElementById('candidatsSelect');
    const compteurEl = document.getElementById('compteurCandidats');
    const rechercheEl = document.getElementById('rechercheCandidat');
    const filtreEl   = document.getElementById('filtreSansGroupe');

    function majCompteur() {
        compteurEl.textContent = Array.from(selectEl.selectedOptions).length;
    }

    function appliquerFiltres() {
        const terme = rechercheEl.value.trim().toLowerCase();
        const seulementSansGroupe = filtreEl.checked;

        Array.from(selectEl.options).forEach(opt => {
            const correspondNom = !terme || opt.dataset.nom.includes(terme);
            const correspondFiltre = !seulementSansGroupe || opt.dataset.aGroupe === '0';
            opt.hidden = !(correspondNom && correspondFiltre);
        });
    }

    selectEl.addEventListener('change', majCompteur);
    rechercheEl.addEventListener('input', appliquerFiltres);
    filtreEl.addEventListener('change', appliquerFiltres);

    majCompteur();
});
</script>

</x-layouts::app.sidebar>
