<x-layouts::app title="Nouveau Groupe">
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
    --shadow-lg: 0 20px 50px rgba(0,0,0,0.5);
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

.gp-counter { color: #BFEBD8; font-weight: 800; }

.gp-btn-primary {
    background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%);
    color: white; padding: 0.9rem 2.2rem; border-radius: var(--radius-md); border: 2px solid var(--color-red);
    font-weight: 700; cursor: pointer; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.04em;
}
.gp-btn-secondary {
    background: transparent; color: var(--text-light); padding: 0.9rem 2.2rem; border-radius: var(--radius-md);
    border: 2px solid var(--input-border); font-weight: 600; text-decoration: none; font-size: 0.875rem;
    text-transform: uppercase; letter-spacing: 0.04em; display: inline-flex; align-items: center;
}

.gp-info {
    margin-top: 1.5rem; padding: 1rem 1.25rem; background: rgba(0,122,94,0.15);
    border-left: 4px solid var(--color-green-light); border-radius: var(--radius-md);
    color: #D7F5E8; font-size: 0.85rem;
}

/* --- Champ déclencheur de la modale --- */
.gp-trigger-field {
    display:flex; justify-content:space-between; align-items:center; cursor:pointer; user-select:none;
}
.gp-trigger-arrow { transition: transform 200ms ease; flex-shrink:0; color: var(--text-light); }

/* --- Modale centrée (fixe à l'écran, ne dépend pas du scroll de la page) --- */
.gp-modal-overlay {
    display: none; position: fixed; inset: 0; background: rgba(11,47,29,0.75);
    z-index: 1000; align-items: center; justify-content: center; padding: 1.5rem;
    backdrop-filter: blur(2px);
}
.gp-modal-overlay.open { display: flex; }
.gp-modal-box {
    background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-lg);
    max-width: 560px; width: 100%; max-height: 85vh; display: flex; flex-direction: column;
    overflow: hidden;
}
.gp-modal-header {
    padding: 1.25rem 1.5rem; border-bottom: 1px solid #eee; display: flex;
    justify-content: space-between; align-items: center; flex-shrink: 0;
}
.gp-modal-title { font-size: 1rem; font-weight: 800; color: #1A1A1A; margin: 0; }
.gp-modal-close {
    background: #F1F1F1; border: none; width: 32px; height: 32px; border-radius: 50%;
    font-size: 1rem; color: #555; cursor: pointer; display: flex; align-items: center; justify-content: center;
}
.gp-modal-close:hover { background: #E0E0E0; }
.gp-modal-toolbar {
    padding: 1rem 1.5rem; border-bottom: 1px solid #eee; flex-shrink: 0;
    display: flex; flex-direction: column; gap: 0.6rem;
}
.gp-modal-toolbar .gp-input { color:#1A1A1A; background:#fff; border:1.5px solid #D1D1D1; }
.gp-modal-toolbar .gp-input::placeholder { color:#999; }

.gp-modal-chip {
    display:flex; align-items:center; gap:0.5rem; cursor:pointer;
    font-size:0.8rem; font-weight:600; color:#004D3A;
    background:rgba(0,122,94,0.1); padding:0.55rem 0.8rem; border-radius:var(--radius-md);
    border:1px solid rgba(0,122,94,0.25);
}
.gp-modal-chip input { width:1rem; height:1rem; accent-color:var(--color-green); cursor:pointer; }

.gp-modal-list { overflow-y: auto; flex: 1; padding: 0.5rem 0; }
.gp-modal-item {
    padding:0.75rem 1.5rem; display:flex; align-items:center; gap:0.7rem;
    cursor:pointer; font-size:0.9rem; color:#1A1A1A;
}
.gp-modal-item:hover { background: rgba(0,122,94,0.08); }
.gp-modal-item input[type=checkbox] { width:17px; height:17px; accent-color:var(--color-green); flex-shrink:0; }
.gp-modal-item.locked { color:#A00D20; cursor:not-allowed; background:rgba(206,17,38,0.04); }
.gp-modal-item.locked:hover { background:rgba(206,17,38,0.04); }
.gp-modal-item.locked input[type=checkbox] { accent-color:#A00D20; }

.gp-modal-footer {
    padding: 1rem 1.5rem; border-top: 1px solid #eee; flex-shrink: 0;
    display: flex; justify-content: flex-end;
}
.gp-modal-done-btn {
    background: var(--color-green); color: white; border: none; padding: 0.7rem 1.75rem;
    border-radius: var(--radius-md); font-weight: 700; font-size: 0.85rem; cursor: pointer;
}
.gp-modal-done-btn:hover { background: var(--color-green-dark); }

.gp-empty-msg { padding:1.25rem 1.5rem; text-align:center; color:#666; font-size:0.85rem; }
</style>

<div class="content-wrapper">

    <span class="gp-pill"><span class="dot"></span> CCI-BF — BOBO-DIOULASSO</span>
    <h1 class="gp-title">Nouveau Groupe</h1>
    <p class="gp-subtitle">Formulaire de création d'un groupe de formation.</p>

    @if($errors->any())
    <div class="gp-card" style="border-color: rgba(206,17,38,0.4); background: rgba(206,17,38,0.1);">
        <strong style="color:#FFD6D0;">⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem; color:#FFD6D0;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form id="groupeForm" method="POST" action="{{ route('groupes.store') }}">
        @csrf

        <div class="gp-card">
            <div class="gp-step-head">
                <span class="gp-step-num">1</span>
                <h2 class="gp-step-title">Configuration du Groupe</h2>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px,1fr)); gap:1.75rem;">
                <div>
                    <label class="gp-field-label">Nom Groupe <span style="color:var(--color-red-light);">*</span></label>
                    <input type="text" id="nomGroupe" name="nomGroupe" value="{{ old('nomGroupe') }}"
                           placeholder="Ex: Session Camion Groupe A" class="gp-input" required>
                </div>
                <div>
                    <label class="gp-field-label">Date Début Formation <span style="color:var(--color-red-light);">*</span></label>
                    <input type="date" id="dateDebutFormation" name="dateDebutFormation"
                           value="{{ old('dateDebutFormation') }}" class="gp-input" required>
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

            {{-- Champ déclencheur : ouvre la modale centrée --}}
            <div class="gp-input gp-trigger-field" onclick="ouvrirModaleCandidats()">
                <span id="candidatsFieldLabel">-- Choisir un ou plusieurs candidats --</span>
                <svg class="gp-trigger-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

        <div style="display:flex; gap:1rem;">
            <button type="submit" class="gp-btn-primary">✓ Enregistrer</button>
            <a href="{{ route('groupes.index') }}" class="gp-btn-secondary">✕ Annuler</a>
        </div>
    </form>

    <div class="gp-info">
        ℹ️ <strong>Rappel d'affectation :</strong> Un candidat ne peut être inscrit que dans un seul groupe de formation actif à la fois. Les candidats déjà inscrits ailleurs sont grisés et protégés.
    </div>
</div>

{{-- ── Modale centrée de sélection des candidats (fixe à l'écran, hors du flux de la page) ── --}}
<div id="candidatsModalOverlay" class="gp-modal-overlay">
    <div class="gp-modal-box">
        <div class="gp-modal-header">
            <h3 class="gp-modal-title">👥 Sélectionner les candidats</h3>
            <button type="button" class="gp-modal-close" onclick="fermerModaleCandidats()">✕</button>
        </div>
        <div class="gp-modal-toolbar">
            <input type="text" id="rechercheCandidat" class="gp-input"
                   placeholder="🔍 Rechercher un candidat par nom..." onkeyup="appliquerFiltres()">
            <label class="gp-modal-chip">
                <input type="checkbox" id="filtreSansGroupe" onchange="appliquerFiltres()">
                Afficher uniquement les candidats sans groupe
            </label>
        </div>
        <div id="candidatsList" class="gp-modal-list">
            @forelse($candidats as $candidat)
                @php $groupeExistant = $candidat->groupes->first(); @endphp
                @if($groupeExistant)
                    <label class="gp-modal-item locked" data-nom="{{ strtolower($candidat->nom.' '.$candidat->prenom) }}" data-a-groupe="1">
                        <input type="checkbox" value="{{ $candidat->id }}" disabled>
                        {{ $candidat->nom }} {{ $candidat->prenom }} 🔒 (déjà dans : {{ $groupeExistant->nomGroupe }})
                    </label>
                @else
                    <label class="gp-modal-item" data-nom="{{ strtolower($candidat->nom.' '.$candidat->prenom) }}" data-a-groupe="0">
                        <input type="checkbox" name="candidat_ids[]" value="{{ $candidat->id }}" onchange="majCompteur()" form="groupeForm">
                        {{ $candidat->nom }} {{ $candidat->prenom }}
                    </label>
                @endif
            @empty
                <div class="gp-empty-msg">📭 Aucun candidat disponible.</div>
            @endforelse
        </div>
        <div class="gp-modal-footer">
            <button type="button" class="gp-modal-done-btn" onclick="fermerModaleCandidats()">✓ Terminé</button>
        </div>
    </div>
</div>

<script>
function ouvrirModaleCandidats() {
    document.getElementById('candidatsModalOverlay').classList.add('open');
}

function fermerModaleCandidats() {
    document.getElementById('candidatsModalOverlay').classList.remove('open');
}

function majCompteur() {
    var checked = document.querySelectorAll('#candidatsList input[type=checkbox]:checked').length;
    document.getElementById('compteurCandidats').textContent = checked;
    document.getElementById('candidatsFieldLabel').textContent = checked > 0
        ? (checked + ' candidat(s) sélectionné(s)')
        : '-- Choisir un ou plusieurs candidats --';
}

function appliquerFiltres() {
    var terme = document.getElementById('rechercheCandidat').value.trim().toLowerCase();
    var seulementSansGroupe = document.getElementById('filtreSansGroupe').checked;

    document.querySelectorAll('#candidatsList .gp-modal-item').forEach(function(item) {
        var correspondNom = !terme || (item.dataset.nom || '').indexOf(terme) !== -1;
        var correspondFiltre = !seulementSansGroupe || item.dataset.aGroupe === '0';
        item.style.display = (correspondNom && correspondFiltre) ? '' : 'none';
    });
}

document.getElementById('candidatsModalOverlay').addEventListener('click', function(e) {
    if (e.target === this) fermerModaleCandidats();
});

document.addEventListener('DOMContentLoaded', majCompteur);
</script>

</x-layouts::app>