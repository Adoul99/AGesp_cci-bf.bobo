<x-layouts::app.sidebar title="Nouvelle Évaluation">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-light: #E85040; --color-red-dark: #A00D20;
    --color-green-light: #00A572; --color-green-dark: #004D3A;
    --color-gold-dark: #E5B800; --color-dark: #1A1A1A;
    --color-gray-100: #E8E8E8; --color-gray-200: #D1D1D1; --color-gray-500: #666666;
    --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
    --radius-md: 8px; --radius-lg: 12px;
}
</style>

<div class="content-wrapper" style="padding:2rem;">

    {{-- En-tête --}}
    <div style="margin-bottom:2rem; background:white; padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Nouvelle Évaluation
        </h1>
    </div>

    {{-- Erreurs --}}
    @if($errors->any())
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(206,17,38,0.1); border-left:4px solid var(--color-red); border-radius:var(--radius-md); color:var(--color-red-dark);">
        <strong>⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    {{-- Bandeau : évaluation liée à une session de formation --}}
    @if($sessionDuMoniteur)
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(0,122,94,0.08); border-left:4px solid var(--color-green); border-radius:var(--radius-md); color:var(--color-green-dark); font-size:0.875rem;">
        🔗 <strong>Évaluation liée à la session du {{ \Carbon\Carbon::parse($sessionDuMoniteur->dateDebut)->format('d/m/Y') }}</strong>
        ({{ $sessionDuMoniteur->typeSession?->label ?? $sessionDuMoniteur->typeSession?->type }}).
        Une fois tous les candidats notés ou marqués absents, <strong>cette session sera clôturée automatiquement</strong>.
    </div>
    @endif

    <form method="POST" action="{{ route('evaluations.store') }}">
        @csrf
        @if($sessionDuMoniteur)
            <input type="hidden" name="session_formation_id" value="{{ $sessionDuMoniteur->id }}">
        @endif

        {{-- ── ENTÊTE FORMULAIRE : Moniteur / Date / Type ── --}}
        <div style="background:white; padding:1.75rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:1.5rem;">

            <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-bottom:1.25rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                Paramètres de la Session
            </h2>

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px,1fr)); gap:1.5rem;">

                {{-- MONITEUR : readonly si connecté --}}
                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                        Moniteur
                        @if($moniteurConnecte)
                            <span style="background:var(--color-green); color:white; font-size:0.65rem; padding:0.15rem 0.5rem; border-radius:50px; margin-left:0.5rem;">AUTO</span>
                        @endif
                    </label>
                    @if($moniteurConnecte)
                        <div style="padding:0.75rem 1rem; border:2px solid var(--color-green); border-radius:var(--radius-md); background:rgba(0,122,94,0.06); color:var(--color-green-dark); font-weight:700; font-size:0.875rem; display:flex; align-items:center; gap:0.5rem;">
                            🔒 {{ $moniteurConnecte->nom }} {{ $moniteurConnecte->prenom }}
                        </div>
                        <input type="hidden" name="moniteur_id" value="{{ $moniteurConnecte->id }}">
                    @else
                        <select name="moniteur_id" style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;">
                            <option value="">-- Aucun --</option>
                            @foreach($moniteurs as $m)
                                <option value="{{ $m->id }}" {{ old('moniteur_id')==$m->id ? 'selected' : '' }}>
                                    {{ $m->nom }} {{ $m->prenom }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>

                {{-- DATE --}}
                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                        Date Évaluation <span style="color:var(--color-red);">*</span>
                    </label>
                    <input type="date" name="dateEvaluation"
                           value="{{ old('dateEvaluation', $sessionDuMoniteur?->dateDebut ?? date('Y-m-d')) }}"
                           style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                           onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                </div>

                {{-- TYPE SESSION --}}
                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                        Type de Session <span style="color:var(--color-red);">*</span>
                    </label>
                    <select name="typeSession_id" required style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                            onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                        <option value="">-- Choisir --</option>
                        @foreach($typeSessions as $ts)
                            <option value="{{ $ts->id }}" {{ old('typeSession_id', $sessionDuMoniteur?->typeSession_id) == $ts->id ? 'selected' : '' }}>
                                @switch($ts->type)
                                    @case('code')     📋 Code @break
                                    @case('creneau')  🔧 Créneau @break
                                    @case('conduite') 🚗 Conduite @break
                                    @default {{ $ts->type }}
                                @endswitch
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        {{-- ── TABLEAU DES CANDIDATS ── --}}
        <div style="background:white; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); overflow:hidden; margin-bottom:1.5rem;">

            <div style="padding:1rem 1.5rem; border-bottom:2px solid var(--color-gold); background:rgba(252,209,22,0.05); display:flex; justify-content:space-between; align-items:center;">
                <h2 style="margin:0; font-size:1rem; font-weight:700; color:var(--color-dark);">
                    📋 Notes des Candidats
                    @if($candidatsDuGroupe->isNotEmpty())
                        <span style="background:var(--color-green); color:white; font-size:0.7rem; padding:0.2rem 0.6rem; border-radius:50px; margin-left:0.5rem; font-weight:700;">{{ $candidatsDuGroupe->count() }} de ma session</span>
                    @endif
                </h2>
                <span style="font-size:0.8rem; color:var(--color-gray-500);">Seuil d'admission : <strong>25 / 30</strong></span>
            </div>

            @if($candidats->isEmpty())
            <div style="padding:3rem; text-align:center; color:var(--color-gray-500);">
                📭 Aucun candidat disponible.
                @if($moniteurConnecte && !$sessionDuMoniteur)
                    <br><span style="font-size:0.8rem;">Ouvrez d'abord une session de formation pour voir vos candidats.</span>
                @endif
            </div>
            @else
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
                    <thead style="background:linear-gradient(90deg,var(--color-green) 0%,var(--color-green-light) 100%); color:white; font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">
                        <tr>
                            <th style="padding:0.875rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">#</th>
                            <th style="padding:0.875rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Candidat</th>
                            <th style="padding:0.875rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Moniteur</th>
                            <th style="padding:0.875rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold); color:var(--color-red);">Absent</th>
                            <th style="padding:0.875rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);">Note /30</th>
                            <th style="padding:0.875rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);">Résultat</th>
                            <th style="padding:0.875rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Observation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidats as $i => $candidat)
                        <tr style="border-bottom:1px solid var(--color-gray-100);" id="row-{{ $candidat->id }}">
                            <td style="padding:0.875rem 1.25rem; color:var(--color-gray-500); font-size:0.8rem;">{{ $i + 1 }}</td>

                            <td style="padding:0.875rem 1.25rem; font-weight:600; color:var(--color-dark);">
                                👤 {{ $candidat->nom }} {{ $candidat->prenom }}
                            </td>

                            <td style="padding:0.875rem 1.25rem; color:var(--color-dark); font-size:0.8rem;">
                                @if($moniteurConnecte)
                                    {{ $moniteurConnecte->nom }} {{ $moniteurConnecte->prenom }}
                                @else
                                    <span style="color:var(--color-gray-500); font-style:italic;">—</span>
                                @endif
                            </td>

                            <td style="padding:0.875rem 1.25rem; text-align:center;">
                                <input type="checkbox"
                                       name="evaluations[{{ $candidat->id }}][absent]"
                                       value="1"
                                       id="abs-{{ $candidat->id }}"
                                       onchange="toggleAbsent(this, {{ $candidat->id }})"
                                       style="width:18px; height:18px; accent-color:var(--color-red); cursor:pointer;">
                            </td>

                            <td style="padding:0.875rem 1.25rem; text-align:center;">
                                <input type="number"
                                       name="evaluations[{{ $candidat->id }}][note]"
                                       id="note-{{ $candidat->id }}"
                                       min="0" max="30" step="0.5"
                                       placeholder="—"
                                       oninput="updateResultat(this, {{ $candidat->id }})"
                                       style="width:85px; padding:0.5rem 0.6rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); text-align:center; font-size:0.9rem; font-weight:600;"
                                       onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                            </td>

                            <td style="padding:0.875rem 1.25rem; text-align:center;">
                                <span id="res-{{ $candidat->id }}" style="background:var(--color-gray-100); color:var(--color-gray-500); padding:0.3rem 0.75rem; border-radius:50px; font-size:0.72rem; font-weight:700; text-transform:uppercase;">
                                    — en attente
                                </span>
                            </td>

                            <td style="padding:0.875rem 1.25rem;">
                                <input type="text"
                                       name="evaluations[{{ $candidat->id }}][observation]"
                                       placeholder="Remarque..."
                                       style="width:100%; padding:0.4rem 0.75rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.8rem;"
                                       onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Barre de progression --}}
            <div style="padding:1rem 1.5rem; background:rgba(0,122,94,0.04); border-top:1px solid var(--color-gray-100);">
                <div style="display:flex; justify-content:space-between; font-size:0.8rem; font-weight:600; color:var(--color-dark); margin-bottom:0.5rem;">
                    <span id="progress-label">0 / {{ $candidats->count() }} notés</span>
                    <span id="progress-pct">0%</span>
                </div>
                <div style="background:var(--color-gray-100); border-radius:50px; height:8px;">
                    <div id="progress-bar" style="background:linear-gradient(90deg,var(--color-green),var(--color-green-light)); height:100%; width:0%; border-radius:50px; transition:width 0.3s;"></div>
                </div>
            </div>
            @endif
        </div>

        {{-- Boutons --}}
        <div style="display:flex; gap:1rem;">
            <button type="submit"
                    style="background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white; padding:0.875rem 2.5rem; border-radius:var(--radius-md); border:2px solid var(--color-red); font-weight:700; cursor:pointer; font-size:0.9rem; text-transform:uppercase;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                ✓ Enregistrer les évaluations
            </button>
            <a href="{{ route('evaluations.index') }}"
               style="background:var(--color-gray-100); color:var(--color-dark); padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-gray-200); font-weight:600; text-decoration:none; font-size:0.875rem; text-transform:uppercase; display:inline-flex; align-items:center;">
                ✕ Annuler
            </a>
        </div>
    </form>

    <div style="margin-top:1.5rem; padding:1rem; background:rgba(0,122,94,0.1); border-left:4px solid var(--color-green); border-radius:var(--radius-md); color:var(--color-green-dark); font-size:0.875rem;">
        ℹ️ Le résultat (Admis / Ajourné) est calculé <strong>automatiquement</strong>. Seuil : <strong>25/30</strong>. Les candidats sans note ne seront pas enregistrés.
    </div>
</div>

<script>
const total = {{ $candidats->count() }};

function toggleAbsent(checkbox, id) {
    const note = document.getElementById('note-' + id);
    const res  = document.getElementById('res-' + id);
    if (checkbox.checked) {
        note.disabled = true;
        note.value = '';
        note.style.background = '#f5f5f5';
        note.style.color = '#999';
        res.style.background = 'rgba(206,17,38,0.1)';
        res.style.color      = 'var(--color-red-dark)';
        res.textContent      = 'ABSENT';
    } else {
        note.disabled = false;
        note.style.background = 'white';
        note.style.color = 'var(--color-dark)';
        res.style.background = 'var(--color-gray-100)';
        res.style.color      = 'var(--color-gray-500)';
        res.textContent      = '— en attente';
    }
    updateProgress();
}

function updateResultat(input, id) {
    const res = document.getElementById('res-' + id);
    const val = input.value;
    if (val === '' || isNaN(parseFloat(val))) {
        res.style.background = 'var(--color-gray-100)';
        res.style.color      = 'var(--color-gray-500)';
        res.textContent      = '— en attente';
        input.style.borderColor = 'var(--color-gray-200)';
    } else if (parseFloat(val) >= 25) {
        res.style.background = 'rgba(0,122,94,0.15)';
        res.style.color      = 'var(--color-green-dark)';
        res.textContent      = '✅ ADMIS';
        input.style.borderColor = 'var(--color-green)';
    } else {
        res.style.background = 'rgba(206,17,38,0.1)';
        res.style.color      = 'var(--color-red-dark)';
        res.textContent      = '❌ AJOURNÉ';
        input.style.borderColor = 'var(--color-red)';
    }
    updateProgress();
}

function updateProgress() {
    let count = 0;
    document.querySelectorAll('input[type=number][id^="note-"]').forEach(inp => {
        if (inp.value !== '' && !isNaN(parseFloat(inp.value))) count++;
    });
    document.querySelectorAll('input[type=checkbox][id^="abs-"]').forEach(chk => {
        if (chk.checked) count++;
    });
    const pct = total ? Math.round(count / total * 100) : 0;
    document.getElementById('progress-label').textContent = `${count} / ${total} notés`;
    document.getElementById('progress-pct').textContent   = `${pct}%`;
    document.getElementById('progress-bar').style.width   = `${pct}%`;
}
</script>
</x-layouts::app.sidebar>