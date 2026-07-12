<x-layouts::app title="Nouvelle Session de Formation">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-light: #E85040; --color-red-dark: #A00D20;
    --color-green-light: #00A572; --color-green-dark: #004D3A;
    --color-gold-dark: #E5B800;

    /* Palette sombre */
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

.content-wrapper { background: var(--bg-page); min-height: 100vh; padding: 2rem; }

.dark-input {
    width:100%; padding:0.75rem 1rem; border:2px solid var(--border-input);
    border-radius:var(--radius-md); font-size:0.875rem; color:#1A1A1A;
    background:var(--bg-input); transition: border-color 200ms ease, box-shadow 200ms ease;
}
.dark-input:focus {
    outline:none; border-color:var(--color-gold); box-shadow:0 0 0 3px rgba(252,209,22,0.25);
}
.dark-input:disabled {
    background:var(--bg-input-disabled); color:var(--text-muted); cursor:not-allowed; opacity:0.7;
}
.field-label {
    display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem;
    text-transform:uppercase; letter-spacing:0.5px; color:var(--text-light);
}
.field-hint { color:var(--text-muted); font-size:0.7rem; font-weight:400; text-transform:none; letter-spacing:0; }
.field-error { color:#FF8A80; font-size:0.75rem; }
.field-group.is-hidden { display:none; }
</style>

<div class="content-wrapper">

    {{-- En-tête --}}
    <div style="margin-bottom:2rem; background:var(--bg-card); padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--text-light); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Nouvelle Session de Formation
        </h1>
        <p style="margin:0.5rem 0 0 1.5rem; color:var(--text-muted); font-size:0.875rem;">
            ℹ️ Une seule session peut être ouverte à la fois. Remplissez les informations puis enregistrez.
        </p>
    </div>

    @if($errors->any())
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(206,17,38,0.15); border-left:4px solid var(--color-red); border-radius:var(--radius-md); color:#FF8A80;">
        <strong>⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem; padding:0;">
            @foreach($errors->all() as $e)<li style="margin:0.25rem 0;">{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('session_formations.store') }}" style="background:var(--bg-card); padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid rgba(255,255,255,0.05);">
        @csrf

        <h2 style="font-size:1rem; font-weight:700; color:var(--text-light); margin-bottom:1.5rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
            Configuration de la Session
        </h2>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px,1fr)); gap:1.75rem;">

            {{-- Date --}}
            <div class="field-group">
                <label class="field-label">Date <span style="color:var(--color-red);">*</span></label>
                <input type="date" name="dateDebut" value="{{ old('dateDebut', date('Y-m-d')) }}" class="dark-input" required>
                @error('dateDebut')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            {{-- Type de session --}}
            <div class="field-group">
                <label class="field-label">Type de session <span style="color:var(--color-red);">*</span></label>
                <select name="typeSession_id" id="typeSession_id" class="dark-input" onchange="onTypeSessionChange(this)" required>
                    <option value="">-- Choisir --</option>
                    @foreach($typesSessions as $t)
                        <option value="{{ $t->id }}" data-type="{{ $t->type }}" {{ old('typeSession_id') == $t->id ? 'selected' : '' }}>
                            @switch($t->type) @case('code') 📋 Code @break @case('creneau') 🔧 Créneau @break @case('conduite') 🚗 Conduite @break @default {{ $t->type }} @endswitch
                        </option>
                    @endforeach
                </select>
                @error('typeSession_id')<span class="field-error">{{ $message }}</span>@enderror
            </div>

            {{-- Statut --}}
            <div class="field-group">
                <label class="field-label">Statut <span style="color:var(--color-red);">*</span></label>
                <select name="statutSession" class="dark-input" required>
                    <option value="ouvert" selected>🟢 Ouvert</option>
                    <option value="annule" {{ old('statutSession')=='annule' ? 'selected' : '' }}>⚪ Annulé</option>
                </select>
            </div>

            {{-- Groupe --}}
            <div class="field-group">
                <label class="field-label">Groupe <span class="field-hint">(facultatif)</span></label>
                <select name="groupe_id" id="groupe_id" class="dark-input" onchange="afficherCandidats(this.value)">
                    <option value="">-- Aucun groupe --</option>
                    @foreach($groupes as $g)
                        <option value="{{ $g->id }}" {{ old('groupe_id') == $g->id ? 'selected' : '' }}
                                data-candidats="{{ $g->candidats->map(fn($c)=>['id'=>$c->id,'nom'=>$c->nom.' '.$c->prenom])->toJson() }}">
                            👥 {{ $g->nomGroupe }} ({{ $g->candidats->count() }} candidat(s))
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Moniteur --}}
            <div class="field-group">
                <label class="field-label">
                    Moniteur
                    @if(!$moniteurConnecte)<span class="field-hint">(facultatif)</span>@endif
                </label>

                @if($moniteurConnecte)
                    <div style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-green-light); border-radius:var(--radius-md); font-size:0.875rem; color:#FFFFFF; background:rgba(0,165,114,0.15); font-weight:700; display:flex; align-items:center; justify-content:space-between;">
                        <span>👤 {{ $moniteurConnecte->nom }} {{ $moniteurConnecte->prenom }}</span>
                        <span style="background:var(--color-green-light); color:white; font-size:0.65rem; padding:0.15rem 0.5rem; border-radius:50px;">VOUS</span>
                    </div>
                    <input type="hidden" name="moniteur_id" value="{{ $moniteurConnecte->id }}">
                @else
                    <select name="moniteur_id" class="dark-input">
                        <option value="">-- Aucun --</option>
                        @foreach($moniteurs as $m)
                            <option value="{{ $m->id }}" {{ old('moniteur_id') == $m->id ? 'selected' : '' }}>
                                👤 {{ $m->nom }} {{ $m->prenom }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>

            {{-- Véhicule : masqué si type de session = Code --}}
            <div class="field-group" id="vehicule-field">
                <label class="field-label">Véhicule <span class="field-hint">(facultatif)</span></label>
                <select name="vehicule_id" id="vehicule_id" class="dark-input">
                    <option value="">-- Aucun --</option>
                    @foreach($vehicules as $v)
                        <option value="{{ $v->id }}" {{ old('vehicule_id') == $v->id ? 'selected' : '' }}>🚗 {{ $v->nomVehicule }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- Aperçu candidats --}}
        <div id="candidats-preview" style="display:none; margin-top:2rem; padding:1.25rem; background:rgba(0,122,94,0.15); border:2px solid var(--color-green-light); border-radius:var(--radius-md);">
            <h3 style="margin:0 0 0.75rem 0; font-size:0.875rem; font-weight:700; color:#ECF0F1;">
                👥 Candidats qui seront intégrés à la session :
            </h3>
            <div id="candidats-list" style="display:flex; flex-wrap:wrap; gap:0.5rem;"></div>
        </div>

        {{-- Boutons --}}
        <div style="display:flex; gap:1rem; margin-top:2rem; padding-top:2rem; border-top:1px solid rgba(255,255,255,0.08);">
            <button type="submit"
                    style="background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white; padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-red); font-weight:600; cursor:pointer; font-size:0.875rem; text-transform:uppercase;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                ✓ Ouvrir la session
            </button>
            <a href="{{ route('session_formations.index') }}"
               style="background:transparent; color:var(--text-light); padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--border-input); font-weight:600; text-decoration:none; font-size:0.875rem; text-transform:uppercase; display:inline-flex; align-items:center;">
                ✕ Annuler
            </a>
        </div>
    </form>
</div>

<script>
function afficherCandidats(groupeId) {
    const preview = document.getElementById('candidats-preview');
    const list    = document.getElementById('candidats-list');
    if (!groupeId) { preview.style.display = 'none'; return; }
    const opt = document.querySelector(`#groupe_id option[value="${groupeId}"]`);
    if (!opt) return;
    const candidats = JSON.parse(opt.dataset.candidats || '[]');
    if (!candidats.length) { preview.style.display = 'none'; return; }
    list.innerHTML = candidats.map(c =>
        `<span style="background:var(--bg-card-header); border:1.5px solid var(--color-green-light); color:#ECF0F1; padding:0.3rem 0.75rem; border-radius:50px; font-size:0.8rem; font-weight:600;">👤 ${c.nom}</span>`
    ).join('');
    preview.style.display = 'block';
}

function onTypeSessionChange(select) {
    const opt = select.options[select.selectedIndex];
    const type = opt ? opt.dataset.type : null;
    const vehiculeField  = document.getElementById('vehicule-field');
    const vehiculeSelect = document.getElementById('vehicule_id');

    if (type === 'code') {
        // Session Code : pas de véhicule à choisir
        vehiculeField.classList.add('is-hidden');
        vehiculeSelect.value = '';
        vehiculeSelect.disabled = true;
    } else {
        // Créneau / Conduite : véhicule choisissable
        vehiculeField.classList.remove('is-hidden');
        vehiculeSelect.disabled = false;
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const g = document.getElementById('groupe_id');
    if (g.value) afficherCandidats(g.value);

    const typeSelect = document.getElementById('typeSession_id');
    if (typeSelect.value) onTypeSessionChange(typeSelect);
});
</script>
</x-layouts::app>