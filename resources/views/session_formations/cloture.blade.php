<x-layouts::app title="Clôturer la Session">
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
    <div style="margin-bottom:2rem; background:white; padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            🔒 Clôturer la Session du {{ \Carbon\Carbon::parse($sessionFormation->dateDebut)->format('d/m/Y') }}
        </h1>
        <p style="margin:0.5rem 0 0 1.5rem; color:var(--color-gray-500); font-size:0.875rem;">
            ⚠️ <strong>Avant de clôturer</strong>, vous devez obligatoirement cocher les absences et saisir la note de chaque candidat présent.
        </p>
    </div>

    {{-- Alerte erreur --}}
    @if(session('error'))
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(206,17,38,0.1); border-left:4px solid var(--color-red); border-radius:var(--radius-md); color:var(--color-red-dark); font-weight:600;">
        {{ session('error') }}
    </div>
    @endif

    {{-- Règles à respecter --}}
    <div style="margin-bottom:2rem; padding:1.25rem 1.5rem; background:rgba(252,209,22,0.1); border:2px solid var(--color-gold); border-radius:var(--radius-lg);">
        <h3 style="margin:0 0 0.75rem 0; color:var(--color-gold-dark); font-size:0.9rem; font-weight:700;">📋 Règles de clôture :</h3>
        <ul style="margin:0; padding-left:1.5rem; color:var(--color-dark); font-size:0.875rem; line-height:1.8;">
            <li>Tout candidat <strong>absent</strong> doit avoir la case cochée.</li>
            <li>Tout candidat <strong>présent</strong> doit avoir une note entre 0 et 30.</li>
            <li>Une fois clôturée, <strong>la session ne peut plus être modifiée</strong>.</li>
            <li>Une nouvelle session pourra être créée immédiatement après.</li>
        </ul>
    </div>

    <form method="POST" action="{{ route('session_formations.cloturer', $sessionFormation->id) }}">
        @csrf

        {{-- Tableau de saisie --}}
        @if($candidatsSession->isNotEmpty())
        <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:2rem;">
            <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-bottom:1.25rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-red);">
                Présences & Notes — {{ $candidatsSession->count() }} candidat(s)
            </h2>

            {{-- Barre de progression --}}
            <div style="margin-bottom:1.5rem;">
                <div style="display:flex; justify-content:space-between; font-size:0.8rem; font-weight:600; color:var(--color-dark); margin-bottom:0.5rem;">
                    <span id="progress-label">0 / {{ $candidatsSession->count() }} complétés</span>
                    <span id="progress-pct">0%</span>
                </div>
                <div style="background:var(--color-gray-100); border-radius:50px; height:10px; overflow:hidden;">
                    <div id="progress-bar" style="background:linear-gradient(90deg,var(--color-green) 0%,var(--color-green-light) 100%); height:100%; width:0%; transition:width 0.3s ease; border-radius:50px;"></div>
                </div>
            </div>

            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
                    <thead>
                        <tr style="background:linear-gradient(90deg,var(--color-green) 0%,var(--color-green-light) 100%); color:white; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">
                            <th style="padding:0.875rem 1.25rem; text-align:left; font-weight:700;">#</th>
                            <th style="padding:0.875rem 1.25rem; text-align:left; font-weight:700;">Candidat</th>
                            <th style="padding:0.875rem 1.25rem; text-align:center; font-weight:700; color:var(--color-gold);">Absent</th>
                            <th style="padding:0.875rem 1.25rem; text-align:center; font-weight:700;">Note /30</th>
                            <th style="padding:0.875rem 1.25rem; text-align:center; font-weight:700;">Résultat</th>
                            <th style="padding:0.875rem 1.25rem; text-align:left; font-weight:700;">Observation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidatsSession as $i => $candidat)
                        <tr id="row-{{ $candidat->id }}" style="border-bottom:1px solid var(--color-gray-100);">
                            <td style="padding:0.875rem 1.25rem; color:var(--color-gray-500); font-size:0.8rem;">{{ $i+1 }}</td>
                            <td style="padding:0.875rem 1.25rem; font-weight:600; color:var(--color-dark);">
                                👤 {{ $candidat->nom }} {{ $candidat->prenom }}
                            </td>
                            <td style="padding:0.875rem 1.25rem; text-align:center;">
                                <input type="checkbox"
                                       name="candidats[{{ $candidat->id }}][absent]"
                                       value="1"
                                       {{ $candidat->pivot->absent ? 'checked' : '' }}
                                       id="abs-{{ $candidat->id }}"
                                       onchange="toggleAbsent(this, {{ $candidat->id }})"
                                       style="width:20px; height:20px; accent-color:var(--color-red); cursor:pointer;">
                            </td>
                            <td style="padding:0.875rem 1.25rem; text-align:center;">
                                <input type="number"
                                       name="candidats[{{ $candidat->id }}][note]"
                                       id="note-{{ $candidat->id }}"
                                       value="{{ $candidat->pivot->note }}"
                                       min="0" max="30" step="0.5"
                                       placeholder="0–30"
                                       {{ $candidat->pivot->absent ? 'disabled' : '' }}
                                       oninput="updateResultat(this, {{ $candidat->id }}); updateProgress()"
                                       style="width:80px; padding:0.5rem 0.6rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); text-align:center; font-size:0.9rem; font-weight:600; {{ $candidat->pivot->absent ? 'background:#f5f5f5; color:#999;' : '' }}"
                                       onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                            </td>
                            <td style="padding:0.875rem 1.25rem; text-align:center;">
                                <span id="res-{{ $candidat->id }}" style="padding:0.3rem 0.75rem; border-radius:50px; font-size:0.72rem; font-weight:700; text-transform:uppercase;">
                                    @if($candidat->pivot->absent)
                                        <span style="background:rgba(206,17,38,0.1); color:var(--color-red-dark); padding:0.3rem 0.75rem; border-radius:50px;">ABSENT</span>
                                    @elseif(!is_null($candidat->pivot->note))
                                        @if($candidat->pivot->note >= 25)
                                            <span style="background:rgba(0,122,94,0.15); color:var(--color-green-dark); padding:0.3rem 0.75rem; border-radius:50px;">✅ ADMIS</span>
                                        @else
                                            <span style="background:rgba(206,17,38,0.1); color:var(--color-red-dark); padding:0.3rem 0.75rem; border-radius:50px;">❌ AJOURNÉ</span>
                                        @endif
                                    @else
                                        <span style="background:var(--color-gray-100); color:var(--color-gray-500); padding:0.3rem 0.75rem; border-radius:50px;">— en attente</span>
                                    @endif
                                </span>
                            </td>
                            <td style="padding:0.875rem 1.25rem;">
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
        <div style="margin-bottom:2rem; padding:1.5rem; background:rgba(206,17,38,0.06); border:2px solid var(--color-red-light); border-radius:var(--radius-lg); color:var(--color-red-dark); text-align:center;">
            ⛔ Impossible de clôturer : aucun candidat n'est attaché à cette session.
            <br><br>
            <a href="{{ route('session_formations.edit', $sessionFormation->id) }}" style="color:var(--color-red); font-weight:700;">← Retour pour configurer le groupe</a>
        </div>
        @endif

        {{-- Boutons --}}
        <div style="display:flex; gap:1rem; align-items:center; flex-wrap:wrap;">
            @if($candidatsSession->isNotEmpty())
            <button type="submit" id="btn-cloture"
                    style="background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white; padding:1rem 2.5rem; border-radius:var(--radius-md); border:2px solid var(--color-red); font-weight:700; cursor:pointer; font-size:1rem; text-transform:uppercase; letter-spacing:0.5px;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'"
                    onclick="return confirmerCloture()">
                🔒 Confirmer la clôture
            </button>
            @endif
            <a href="{{ route('session_formations.index') }}"
               style="background:var(--color-gray-100); color:var(--color-dark); padding:1rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-gray-200); font-weight:600; text-decoration:none; font-size:0.875rem; text-transform:uppercase; display:inline-flex; align-items:center;">
                ✕ Annuler
            </a>
        </div>
    </form>
</div>

<script>
const totalCandidats = {{ $candidatsSession->count() }};

function toggleAbsent(checkbox, id) {
    const note = document.getElementById('note-' + id);
    const res  = document.getElementById('res-' + id);
    if (checkbox.checked) {
        note.disabled = true;
        note.value = '';
        note.style.background = '#f5f5f5';
        note.style.color = '#999';
        res.innerHTML = '<span style="background:rgba(206,17,38,0.1); color:var(--color-red-dark); padding:0.3rem 0.75rem; border-radius:50px;">ABSENT</span>';
    } else {
        note.disabled = false;
        note.style.background = 'white';
        note.style.color = 'var(--color-dark)';
        res.innerHTML = '<span style="background:var(--color-gray-100); color:var(--color-gray-500); padding:0.3rem 0.75rem; border-radius:50px;">— en attente</span>';
    }
    updateProgress();
}

function updateResultat(input, id) {
    const note = parseFloat(input.value);
    const res  = document.getElementById('res-' + id);
    if (input.value === '' || isNaN(note)) {
        res.innerHTML = '<span style="background:var(--color-gray-100); color:var(--color-gray-500); padding:0.3rem 0.75rem; border-radius:50px;">— en attente</span>';
        return;
    }
    if (note >= 25) {
        res.innerHTML = '<span style="background:rgba(0,122,94,0.15); color:var(--color-green-dark); padding:0.3rem 0.75rem; border-radius:50px;">✅ ADMIS</span>';
        input.style.borderColor = 'var(--color-green)';
    } else {
        res.innerHTML = '<span style="background:rgba(206,17,38,0.1); color:var(--color-red-dark); padding:0.3rem 0.75rem; border-radius:50px;">❌ AJOURNÉ</span>';
        input.style.borderColor = 'var(--color-red)';
    }
}

function updateProgress() {
    let complets = 0;
    @foreach($candidatsSession as $c)
    (function() {
        const abs  = document.getElementById('abs-{{ $c->id }}');
        const note = document.getElementById('note-{{ $c->id }}');
        if (abs && abs.checked) complets++;
        else if (note && note.value !== '' && !isNaN(parseFloat(note.value))) complets++;
    })();
    @endforeach

    const pct = totalCandidats ? Math.round(complets / totalCandidats * 100) : 0;
    document.getElementById('progress-label').textContent = `${complets} / ${totalCandidats} complétés`;
    document.getElementById('progress-pct').textContent   = `${pct}%`;
    document.getElementById('progress-bar').style.width   = `${pct}%`;
}

function confirmerCloture() {
    return confirm(
        '⚠️ Attention !\n\n' +
        'Une fois clôturée, cette session ne pourra plus être modifiée.\n' +
        'Confirmez-vous la clôture ?'
    );
}

// Init au chargement
document.addEventListener('DOMContentLoaded', updateProgress);
</script>
</x-layouts::app>
