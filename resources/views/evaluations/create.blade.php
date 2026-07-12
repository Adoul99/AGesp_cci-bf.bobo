<x-layouts::app title="Nouvelle Évaluation">
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

.small-input {
    padding:0.5rem 0.6rem; border:2px solid var(--border-input); border-radius:var(--radius-md);
    text-align:center; font-size:0.9rem; font-weight:600; background:var(--bg-input); color:#1A1A1A;
    transition: border-color 200ms ease;
}
.small-input:focus { outline:none; border-color:var(--color-gold); }
.small-input:disabled { background:var(--bg-input-disabled); color:var(--text-muted); }

.obs-input {
    width:100%; padding:0.4rem 0.75rem; border:2px solid var(--border-input); border-radius:var(--radius-md);
    font-size:0.8rem; background:var(--bg-input); color:#1A1A1A;
}
.obs-input:focus { outline:none; border-color:var(--color-gold); }

table.evals thead th { color:white; }
.col-note.is-hidden, .col-mention.is-hidden { display:none !important; }
</style>

<div class="content-wrapper">

    {{-- En-tête --}}
    <div style="margin-bottom:2rem; background:var(--bg-card); padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--text-light); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Nouvelle Évaluation
        </h1>
    </div>

    {{-- Erreurs --}}
    @if($errors->any())
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(206,17,38,0.15); border-left:4px solid var(--color-red); border-radius:var(--radius-md); color:#FF8A80;">
        <strong>⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    {{-- Bandeau : évaluation liée à une session de formation --}}
    @if($sessionDuMoniteur)
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(0,122,94,0.15); border-left:4px solid var(--color-green-light); border-radius:var(--radius-md); color:#ECF0F1; font-size:0.875rem;">
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
        <div style="background:var(--bg-card); padding:1.75rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid rgba(255,255,255,0.05); margin-bottom:1.5rem;">

            <h2 style="font-size:1rem; font-weight:700; color:var(--text-light); margin-bottom:1.25rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                Paramètres de la Session
            </h2>

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px,1fr)); gap:1.5rem;">

                {{-- MONITEUR : readonly si connecté --}}
                <div>
                    <label class="field-label">
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
                        <select name="moniteur_id" class="dark-input">
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
                    <label class="field-label">Date Évaluation <span style="color:var(--color-red);">*</span></label>
                    <input type="date" name="dateEvaluation"
                           value="{{ old('dateEvaluation', $sessionDuMoniteur?->dateDebut ?? date('Y-m-d')) }}"
                           class="dark-input" required>
                </div>

                {{-- TYPE SESSION --}}
                <div>
                    <label class="field-label">Type de Session <span style="color:var(--color-red);">*</span></label>
                    <select name="typeSession_id" id="typeSession_id" class="dark-input" onchange="onTypeSessionChange(this)" required>
                        <option value="">-- Choisir --</option>
                        @foreach($typeSessions as $ts)
                            <option value="{{ $ts->id }}" data-type="{{ $ts->type }}"
                                    {{ old('typeSession_id', $sessionDuMoniteur?->typeSession_id) == $ts->id ? 'selected' : '' }}>
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
        <div style="background:var(--bg-card); border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid rgba(255,255,255,0.05); overflow:hidden; margin-bottom:1.5rem;">

            <div style="padding:1rem 1.5rem; border-bottom:2px solid var(--color-gold); background:var(--bg-card-header); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:0.5rem;">
                <h2 style="margin:0; font-size:1rem; font-weight:700; color:var(--text-light);">
                    📋 Notes des Candidats
                    @if($candidatsDuGroupe->isNotEmpty())
                        <span style="background:var(--color-green-light); color:white; font-size:0.7rem; padding:0.2rem 0.6rem; border-radius:50px; margin-left:0.5rem; font-weight:700;">{{ $candidatsDuGroupe->count() }} de ma session</span>
                    @endif
                </h2>
                <span id="seuil-info" style="font-size:0.8rem; color:var(--text-muted);">Seuil d'admission : <strong style="color:var(--text-light);">25 / 30</strong></span>
            </div>

            @if($candidats->isEmpty())
            <div style="padding:3rem; text-align:center; color:var(--text-muted);">
                📭 Aucun candidat disponible.
                @if($moniteurConnecte && !$sessionDuMoniteur)
                    <br><span style="font-size:0.8rem;">Ouvrez d'abord une session de formation pour voir vos candidats.</span>
                @endif
            </div>
            @else
            <div style="overflow-x:auto;">
                <table class="evals" style="width:100%; border-collapse:collapse; font-size:0.875rem;">
                    <thead style="background:linear-gradient(90deg,var(--color-green) 0%,var(--color-green-light) 100%); font-size:0.75rem; text-transform:uppercase; letter-spacing:0.5px;">
                        <tr>
                            <th style="padding:0.875rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">#</th>
                            <th style="padding:0.875rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Candidat</th>
                            <th style="padding:0.875rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Moniteur</th>
                            <th style="padding:0.875rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold); color:#FFD6D0;">Absent</th>
                            <th class="col-note" style="padding:0.875rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);">Note /30</th>
                            <th class="col-mention is-hidden" style="padding:0.875rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);">Mention</th>
                            <th style="padding:0.875rem 1.25rem; text-align:center; border-bottom:3px solid var(--color-gold);">Résultat</th>
                            <th style="padding:0.875rem 1.25rem; text-align:left; border-bottom:3px solid var(--color-gold);">Observation</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($candidats as $i => $candidat)
                        <tr style="border-bottom:1px solid rgba(255,255,255,0.06);" id="row-{{ $candidat->id }}">
                            <td style="padding:0.875rem 1.25rem; color:var(--text-muted); font-size:0.8rem;">{{ $i + 1 }}</td>

                            <td style="padding:0.875rem 1.25rem; font-weight:600; color:var(--text-light);">
                                👤 {{ $candidat->nom }} {{ $candidat->prenom }}
                            </td>

                            <td style="padding:0.875rem 1.25rem; color:var(--text-muted); font-size:0.8rem;">
                                @if($moniteurConnecte)
                                    {{ $moniteurConnecte->nom }} {{ $moniteurConnecte->prenom }}
                                @else
                                    <span style="font-style:italic;">—</span>
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

                            {{-- Note (visible si type = Code) --}}
                            <td class="col-note" style="padding:0.875rem 1.25rem; text-align:center;">
                                <input type="number"
                                       name="evaluations[{{ $candidat->id }}][note]"
                                       id="note-{{ $candidat->id }}"
                                       min="0" max="30" step="0.5"
                                       placeholder="—"
                                       oninput="updateResultat({{ $candidat->id }})"
                                       class="small-input" style="width:85px;">
                            </td>

                            {{-- Mention (visible si type = Créneau/Conduite) --}}
                            <td class="col-mention is-hidden" style="padding:0.875rem 1.25rem; text-align:center;">
                                <select name="evaluations[{{ $candidat->id }}][mention]"
                                        id="mention-{{ $candidat->id }}"
                                        onchange="updateResultat({{ $candidat->id }})"
                                        class="small-input" style="width:130px; text-align:left;">
                                    <option value="">-- Choisir --</option>
                                    <option value="bien">🟢 Bien</option>
                                    <option value="passable">🟡 Passable</option>
                                    <option value="mediocre">🔴 Médiocre</option>
                                </select>
                            </td>

                            <td style="padding:0.875rem 1.25rem; text-align:center;">
                                <span id="res-{{ $candidat->id }}" style="background:rgba(255,255,255,0.08); color:var(--text-muted); padding:0.3rem 0.75rem; border-radius:50px; font-size:0.72rem; font-weight:700; text-transform:uppercase;">
                                    — en attente
                                </span>
                            </td>

                            <td style="padding:0.875rem 1.25rem;">
                                <input type="text"
                                       name="evaluations[{{ $candidat->id }}][observation]"
                                       placeholder="Remarque..."
                                       class="obs-input">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Barre de progression --}}
            <div style="padding:1rem 1.5rem; background:rgba(0,122,94,0.08); border-top:1px solid rgba(255,255,255,0.06);">
                <div style="display:flex; justify-content:space-between; font-size:0.8rem; font-weight:600; color:var(--text-light); margin-bottom:0.5rem;">
                    <span id="progress-label">0 / {{ $candidats->count() }} notés</span>
                    <span id="progress-pct">0%</span>
                </div>
                <div style="background:rgba(255,255,255,0.1); border-radius:50px; height:8px;">
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
               style="background:transparent; color:var(--text-light); padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--border-input); font-weight:600; text-decoration:none; font-size:0.875rem; text-transform:uppercase; display:inline-flex; align-items:center;">
                ✕ Annuler
            </a>
        </div>
    </form>

    <div id="info-bandeau" style="margin-top:1.5rem; padding:1rem; background:rgba(0,122,94,0.15); border-left:4px solid var(--color-green-light); border-radius:var(--radius-md); color:#ECF0F1; font-size:0.875rem;">
        ℹ️ Le résultat est calculé <strong>automatiquement</strong> selon le type de session. Les candidats sans note/mention ne seront pas enregistrés.
    </div>
</div>

<script>
const total = {{ $candidats->count() }};

function toggleAbsent(checkbox, id) {
    const note    = document.getElementById('note-' + id);
    const mention = document.getElementById('mention-' + id);
    const res     = document.getElementById('res-' + id);

    if (checkbox.checked) {
        if (note)    { note.disabled = true; note.value = ''; }
        if (mention) { mention.disabled = true; mention.value = ''; }
        res.style.background = 'rgba(206,17,38,0.2)';
        res.style.color      = '#FF8A80';
        res.textContent      = 'ABSENT';
    } else {
        if (note)    note.disabled = false;
        if (mention) mention.disabled = false;
        res.style.background = 'rgba(255,255,255,0.08)';
        res.style.color      = 'var(--text-muted)';
        res.textContent      = '— en attente';
    }
    updateProgress();
}

function currentSessionType() {
    const select = document.getElementById('typeSession_id');
    const opt = select.options[select.selectedIndex];
    return opt ? opt.dataset.type : null;
}

function updateResultat(id) {
    const type    = currentSessionType();
    const res     = document.getElementById('res-' + id);
    const absent  = document.getElementById('abs-' + id).checked;

    if (absent) { return; } // déjà géré par toggleAbsent

    if (type === 'code') {
        const noteInput = document.getElementById('note-' + id);
        const val = noteInput.value;
        if (val === '' || isNaN(parseFloat(val))) {
            res.style.background = 'rgba(255,255,255,0.08)';
            res.style.color      = 'var(--text-muted)';
            res.textContent      = '— en attente';
            noteInput.style.borderColor = 'var(--border-input)';
        } else if (parseFloat(val) >= 25) {
            res.style.background = 'rgba(0,122,94,0.25)';
            res.style.color      = '#6EE7C0';
            res.textContent      = '✅ VALIDÉ';
            noteInput.style.borderColor = 'var(--color-green-light)';
        } else {
            res.style.background = 'rgba(206,17,38,0.2)';
            res.style.color      = '#FF8A80';
            res.textContent      = '❌ ÉCHOUÉ';
            noteInput.style.borderColor = 'var(--color-red-light)';
        }
    } else if (type === 'creneau' || type === 'conduite') {
        const mentionSelect = document.getElementById('mention-' + id);
        const val = mentionSelect.value;
        if (val === '') {
            res.style.background = 'rgba(255,255,255,0.08)';
            res.style.color      = 'var(--text-muted)';
            res.textContent      = '— en attente';
        } else if (val === 'bien' || val === 'passable') {
            res.style.background = 'rgba(0,122,94,0.25)';
            res.style.color      = '#6EE7C0';
            res.textContent      = '✅ VALIDÉ';
        } else {
            res.style.background = 'rgba(206,17,38,0.2)';
            res.style.color      = '#FF8A80';
            res.textContent      = '❌ ÉCHOUÉ';
        }
    }
    updateProgress();
}

function onTypeSessionChange(select) {
    const opt  = select.options[select.selectedIndex];
    const type = opt ? opt.dataset.type : null;

    const noteCols    = document.querySelectorAll('.col-note');
    const mentionCols = document.querySelectorAll('.col-mention');
    const seuilInfo    = document.getElementById('seuil-info');

    if (type === 'code') {
        noteCols.forEach(el => el.classList.remove('is-hidden'));
        mentionCols.forEach(el => el.classList.add('is-hidden'));
        seuilInfo.style.display = '';
    } else if (type === 'creneau' || type === 'conduite') {
        noteCols.forEach(el => el.classList.add('is-hidden'));
        mentionCols.forEach(el => el.classList.remove('is-hidden'));
        seuilInfo.style.display = 'none';
    } else {
        noteCols.forEach(el => el.classList.remove('is-hidden'));
        mentionCols.forEach(el => el.classList.add('is-hidden'));
        seuilInfo.style.display = '';
    }

    // Recalcule tous les résultats affichés avec le nouveau type
    document.querySelectorAll('tr[id^="row-"]').forEach(row => {
        const id = row.id.replace('row-', '');
        updateResultat(id);
    });
}

function updateProgress() {
    let count = 0;
    document.querySelectorAll('input[type=number][id^="note-"]:not([disabled])').forEach(inp => {
        if (inp.value !== '' && !isNaN(parseFloat(inp.value))) count++;
    });
    document.querySelectorAll('select[id^="mention-"]:not([disabled])').forEach(sel => {
        if (sel.value !== '') count++;
    });
    document.querySelectorAll('input[type=checkbox][id^="abs-"]').forEach(chk => {
        if (chk.checked) count++;
    });
    const pct = total ? Math.round(count / total * 100) : 0;
    document.getElementById('progress-label').textContent = `${count} / ${total} notés`;
    document.getElementById('progress-pct').textContent   = `${pct}%`;
    document.getElementById('progress-bar').style.width   = `${pct}%`;
}

document.addEventListener('DOMContentLoaded', () => {
    const typeSelect = document.getElementById('typeSession_id');
    if (typeSelect.value) onTypeSessionChange(typeSelect);
});
</script>
</x-layouts::app>
