<x-layouts::app title="Modifier Session de Formation">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-light: #E85040; --color-red-dark: #A00D20;
    --color-green-light: #00A572; --color-green-dark: #004D3A;
    --color-gold-dark: #E5B800; --color-dark: #1A1A1A;
    --color-gray-100: #E8E8E8; --color-gray-200: #D1D1D1; --color-gray-500: #666666;
    --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
    --transition-normal: 300ms ease-in-out; --radius-md: 8px; --radius-lg: 12px;
}
</style>

<div class="content-wrapper" style="padding:2rem;">

    {{-- En-tête --}}
    <div style="margin-bottom:2rem; background:white; padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-gold);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Modifier Session — {{ \Carbon\Carbon::parse($sessionFormation->dateDebut)->format('d/m/Y') }}
        </h1>
        <p style="margin:0.5rem 0 0 1.5rem; color:var(--color-gray-500); font-size:0.875rem;">
            ✎ Vous pouvez modifier les informations et mettre à jour les absences/notes des candidats.
        </p>
    </div>

    @if(session('error'))
        <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(206,17,38,0.1); border-left:4px solid var(--color-red); border-radius:var(--radius-md); color:var(--color-red-dark); font-weight:600;">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(206,17,38,0.1); border-left:4px solid var(--color-red); border-radius:var(--radius-md); color:var(--color-red-dark);">
            <strong>⚠️ Erreurs :</strong>
            <ul style="margin:0.5rem 0 0 1.5rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="POST" action="{{ route('session_formations.update', $sessionFormation->id) }}" style="display:contents;">
        @csrf @method('PUT')

        {{-- INFORMATIONS GÉNÉRALES --}}
        <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:2rem;">
            <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-bottom:1.5rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                Informations de la session
            </h2>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px,1fr)); gap:1.75rem;">

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Date *</label>
                    <input type="date" name="dateDebut" value="{{ old('dateDebut', $sessionFormation->dateDebut) }}"
                           style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                           onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                </div>

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Type de session *</label>
                    <select name="typeSession_id" id="typeSession_id" onchange="onTypeSessionChange(this)" style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;" required>
                        <option value="">-- Choisir --</option>
                        @foreach($typesSessions as $t)
                            <option value="{{ $t->id }}" data-type="{{ $t->type }}" {{ $sessionFormation->typeSession_id == $t->id ? 'selected' : '' }}>
                                @switch($t->type) @case('code') 📋 Code @break @case('creneau') 🔧 Créneau @break @case('conduite') 🚗 Conduite @break @default {{ $t->type }} @endswitch
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Moniteur *</label>
                    <select name="moniteur_id" style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;" required>
                        <option value="">-- Choisir un moniteur --</option>
                        @foreach($moniteurs as $m)
                            <option value="{{ $m->id }}" {{ $sessionFormation->moniteur_id == $m->id ? 'selected' : '' }}>
                                👤 {{ $m->nom }} {{ $m->prenom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="vehicule-field">
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                        Véhicule <span id="vehicule-required">*</span>
                    </label>
                    <select name="vehicule_id" id="vehicule_id" style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;">
                        <option value="">-- Choisir un véhicule --</option>
                        @foreach($vehicules as $v)
                            <option value="{{ $v->id }}" {{ $sessionFormation->vehicule_id == $v->id ? 'selected' : '' }}>🚗 {{ $v->nomVehicule }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Groupe</label>
                    <div style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:var(--color-gray-100); font-weight:600;">
                        👥 {{ $sessionFormation->groupe->nomGroupe ?? '—' }}
                    </div>
                    <p style="margin:0.4rem 0 0 0; font-size:0.72rem; color:var(--color-gray-500);">
                        Le groupe est fixé à la création de la session et ne peut pas être modifié ici.
                    </p>
                </div>

            </div>
        </div>

        {{-- SAISIE ABSENCES + NOTES : candidats du groupe, en lecture/gestion des présences uniquement --}}
        @if($candidatsSession->isNotEmpty())
        <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:2rem;">
            <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-bottom:0.5rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                📋 Présences / Absences & Notes des candidats du groupe
            </h2>
            <p style="color:var(--color-gray-500); font-size:0.8rem; margin:0 0 1.25rem 0;">
                Cochez la case <strong>Absent</strong> si le candidat n'est pas présent. Les candidats présents doivent recevoir une note avant la clôture.
            </p>

            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
                    <thead>
                        <tr style="background:rgba(0,122,94,0.08); font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">
                            <th style="padding:0.75rem 1rem; text-align:left; font-weight:700; color:var(--color-dark);">Candidat</th>
                            <th style="padding:0.75rem 1rem; text-align:center; font-weight:700; color:var(--color-red);">Absent</th>
                            <th style="padding:0.75rem 1rem; text-align:center; font-weight:700; color:var(--color-green);">Note /30</th>
                            <th style="padding:0.75rem 1rem; text-align:left; font-weight:700; color:var(--color-dark);">Observation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidatsSession as $candidat)
                        <tr style="border-bottom:1px solid var(--color-gray-100);" id="row-{{ $candidat->id }}">
                            <td style="padding:0.75rem 1rem; font-weight:600; color:var(--color-dark);">
                                👤 {{ $candidat->nom }} {{ $candidat->prenom }}
                            </td>
                            <td style="padding:0.75rem 1rem; text-align:center;">
                                <input type="checkbox"
                                       name="candidats[{{ $candidat->id }}][absent]"
                                       value="1"
                                       {{ $candidat->pivot->absent ? 'checked' : '' }}
                                       onchange="toggleNote(this, {{ $candidat->id }})"
                                       style="width:18px; height:18px; accent-color:var(--color-red); cursor:pointer;">
                            </td>
                            <td style="padding:0.75rem 1rem; text-align:center;">
                                <input type="number"
                                       name="candidats[{{ $candidat->id }}][note]"
                                       id="note-{{ $candidat->id }}"
                                       value="{{ $candidat->pivot->note }}"
                                       min="0" max="30" step="0.5"
                                       placeholder="—"
                                       {{ $candidat->pivot->absent ? 'disabled' : '' }}
                                       style="width:80px; padding:0.4rem 0.6rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); text-align:center; font-size:0.875rem; {{ $candidat->pivot->absent ? 'background:#f5f5f5; color:#999;' : '' }}"
                                       onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                            </td>
                            <td style="padding:0.75rem 1rem;">
                                <input type="text"
                                       name="candidats[{{ $candidat->id }}][observation]"
                                       value="{{ $candidat->pivot->observation }}"
                                       placeholder="Remarque..."
                                       style="width:100%; padding:0.4rem 0.75rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.8rem;"
                                       onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div style="margin-bottom:2rem; padding:1.25rem; background:rgba(252,209,22,0.1); border-left:4px solid var(--color-gold); border-radius:var(--radius-md); color:var(--color-gold-dark);">
            ⚠️ Aucun candidat n'est attaché à cette session. Vérifiez que le groupe sélectionné à la création contient bien des candidats.
        </div>
        @endif

        {{-- Boutons --}}
        <div style="display:flex; gap:1rem; flex-wrap:wrap;">
            <button type="submit"
                    style="background:linear-gradient(135deg,var(--color-green) 0%,var(--color-green-dark) 100%); color:white; padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-green); font-weight:600; cursor:pointer; font-size:0.875rem; text-transform:uppercase;">
                ✓ Enregistrer les modifications
            </button>
            <a href="{{ route('session_formations.cloture', $sessionFormation->id) }}"
               style="background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white; padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-red); font-weight:600; text-decoration:none; font-size:0.875rem; text-transform:uppercase; display:inline-flex; align-items:center; gap:0.5rem;">
                🔒 Aller à la clôture
            </a>
            <a href="{{ route('session_formations.index') }}"
               style="background:var(--color-gray-100); color:var(--color-dark); padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-gray-200); font-weight:600; text-decoration:none; font-size:0.875rem; text-transform:uppercase; display:inline-flex; align-items:center;">
                ✕ Retour
            </a>
        </div>
    </form>
</div>

<script>
function toggleNote(checkbox, candidatId) {
    const noteInput = document.getElementById('note-' + candidatId);
    if (checkbox.checked) {
        noteInput.disabled = true;
        noteInput.value = '';
        noteInput.style.background = '#f5f5f5';
        noteInput.style.color = '#999';
    } else {
        noteInput.disabled = false;
        noteInput.style.background = 'white';
        noteInput.style.color = 'var(--color-dark)';
    }
}

function onTypeSessionChange(select) {
    const opt = select.options[select.selectedIndex];
    const type = opt ? opt.dataset.type : null;
    const vehiculeField    = document.getElementById('vehicule-field');
    const vehiculeSelect   = document.getElementById('vehicule_id');
    const vehiculeRequired = document.getElementById('vehicule-required');

    if (type === 'code') {
        vehiculeField.style.display = 'none';
        vehiculeSelect.value = '';
        vehiculeSelect.required = false;
        vehiculeRequired.style.display = 'none';
    } else {
        vehiculeField.style.display = 'block';
        vehiculeSelect.required = true;
        vehiculeRequired.style.display = 'inline';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const typeSelect = document.getElementById('typeSession_id');
    if (typeSelect.value) onTypeSessionChange(typeSelect);
});
</script>
</x-layouts::app>