<x-layouts::app.sidebar title="Nouvelle Session de Formation">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-light: #E85040; --color-red-dark: #A00D20;
    --color-green-light: #00A572; --color-green-dark: #004D3A;
    --color-gold-dark: #E5B800; --color-dark: #1A1A1A; --color-light: #F8F8F8;
    --color-gray-100: #E8E8E8; --color-gray-200: #D1D1D1; --color-gray-500: #666666;
    --shadow-sm: 0 1px 2px rgba(0,0,0,0.05); --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
    --transition-normal: 300ms ease-in-out; --radius-md: 8px; --radius-lg: 12px;
}
</style>

<div class="content-wrapper" style="padding:2rem;">

    {{-- En-tête --}}
    <div style="margin-bottom:2rem; background:white; padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Nouvelle Session de Formation
        </h1>
        <p style="margin:0.5rem 0 0 1.5rem; color:var(--color-gray-500); font-size:0.875rem;">
            ℹ️ Une seule session peut être ouverte à la fois. Remplissez les informations puis enregistrez.
        </p>
    </div>

    @if($errors->any())
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(206,17,38,0.1); border-left:4px solid var(--color-red); border-radius:var(--radius-md); color:var(--color-red-dark);">
        <strong>⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem; padding:0;">
            @foreach($errors->all() as $e)<li style="margin:0.25rem 0;">{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('session_formations.store') }}" style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100);">
        @csrf

        <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-bottom:1.5rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
            Configuration de la Session
        </h2>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px,1fr)); gap:1.75rem;">

            {{-- Date --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px; color:var(--color-dark);">
                    Date <span style="color:var(--color-red);">*</span>
                </label>
                <input type="date" name="dateDebut" value="{{ old('dateDebut', date('Y-m-d')) }}"
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                       onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                @error('dateDebut')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
            </div>

            {{-- Type de session --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px; color:var(--color-dark);">
                    Type de session <span style="color:var(--color-red);">*</span>
                </label>
                <select name="typeSession_id"
                        style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                        onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                    <option value="">-- Choisir --</option>
                    @foreach($typesSessions as $t)
                        <option value="{{ $t->id }}" {{ old('typeSession_id') == $t->id ? 'selected' : '' }}>
                            @switch($t->type) @case('code') 📋 Code @break @case('creneau') 🔧 Créneau @break @case('conduite') 🚗 Conduite @break @default {{ $t->type }} @endswitch
                        </option>
                    @endforeach
                </select>
                @error('typeSession_id')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
            </div>

            {{-- Statut --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px; color:var(--color-dark);">
                    Statut <span style="color:var(--color-red);">*</span>
                </label>
                <select name="statutSession"
                        style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                        onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                    <option value="ouvert" selected>🟢 Ouvert</option>
                    <option value="annule" {{ old('statutSession')=='annule' ? 'selected' : '' }}>⚪ Annulé</option>
                </select>
            </div>

            {{-- Groupe --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px; color:var(--color-dark);">
                    Groupe <span style="color:var(--color-gray-500); font-size:0.7rem; font-weight:400;">(facultatif)</span>
                </label>
                <select name="groupe_id" id="groupe_id"
                        style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                        onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'"
                        onchange="afficherCandidats(this.value)">
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
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px; color:var(--color-dark);">
                    Moniteur <span style="color:var(--color-gray-500); font-size:0.7rem; font-weight:400;">(facultatif)</span>
                </label>
                <select name="moniteur_id"
                        style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                        onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                    <option value="">-- Aucun --</option>
                    @foreach($moniteurs as $m)
                        <option value="{{ $m->id }}" {{ old('moniteur_id') == $m->id ? 'selected' : '' }}>
                            👤 {{ $m->nom }} {{ $m->prenom }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Véhicule --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.5px; color:var(--color-dark);">
                    Véhicule <span style="color:var(--color-gray-500); font-size:0.7rem; font-weight:400;">(facultatif)</span>
                </label>
                <select name="vehicule_id"
                        style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                        onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                    <option value="">-- Aucun --</option>
                    @foreach($vehicules as $v)
                        <option value="{{ $v->id }}" {{ old('vehicule_id') == $v->id ? 'selected' : '' }}>🚗 {{ $v->nomVehicule }}</option>
                    @endforeach
                </select>
            </div>

        </div>

        {{-- Aperçu candidats --}}
        <div id="candidats-preview" style="display:none; margin-top:2rem; padding:1.25rem; background:rgba(0,122,94,0.06); border:2px solid var(--color-green); border-radius:var(--radius-md);">
            <h3 style="margin:0 0 0.75rem 0; font-size:0.875rem; font-weight:700; color:var(--color-green-dark);">
                👥 Candidats qui seront intégrés à la session :
            </h3>
            <div id="candidats-list" style="display:flex; flex-wrap:wrap; gap:0.5rem;"></div>
        </div>

        {{-- Boutons --}}
        <div style="display:flex; gap:1rem; margin-top:2rem; padding-top:2rem; border-top:1px solid var(--color-gray-100);">
            <button type="submit"
                    style="background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white; padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-red); font-weight:600; cursor:pointer; font-size:0.875rem; text-transform:uppercase;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                ✓ Ouvrir la session
            </button>
            <a href="{{ route('session_formations.index') }}"
               style="background:var(--color-gray-100); color:var(--color-dark); padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-gray-200); font-weight:600; text-decoration:none; font-size:0.875rem; text-transform:uppercase; display:inline-flex; align-items:center;">
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
        `<span style="background:white; border:1.5px solid var(--color-green); color:var(--color-green-dark); padding:0.3rem 0.75rem; border-radius:50px; font-size:0.8rem; font-weight:600;">👤 ${c.nom}</span>`
    ).join('');
    preview.style.display = 'block';
}
document.addEventListener('DOMContentLoaded', () => {
    const g = document.getElementById('groupe_id');
    if (g.value) afficherCandidats(g.value);
});
</script>
</x-layouts::app.sidebar>
