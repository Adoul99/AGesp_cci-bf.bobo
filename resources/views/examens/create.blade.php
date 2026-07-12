<x-layouts::app title="Nouvel Examen">
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

.content-wrapper { background: linear-gradient(160deg, var(--bg-page) 0%, #17222E 100%); min-height: 100vh; padding: 2rem; }

.ex-card {
    background: var(--bg-card); border: 1px solid rgba(255,255,255,0.06);
    border-radius: var(--radius-lg); box-shadow: var(--shadow-md);
    padding: 1.75rem 2rem; margin-bottom: 1.5rem;
}

.ex-label {
    display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem;
    text-transform:uppercase; letter-spacing:0.5px; color:var(--text-light);
}

.ex-input {
    width:100%; padding:0.75rem 1rem; border:2px solid var(--border-input);
    border-radius:var(--radius-md); font-size:0.875rem; color:#1A1A1A;
    background:var(--bg-input); transition: border-color 200ms ease, box-shadow 200ms ease;
}
.ex-input:focus { outline:none; border-color:var(--color-gold); box-shadow:0 0 0 3px rgba(252,209,22,0.25); }

.ex-statut-locked {
    width:100%; padding:0.75rem 1rem; border:2px solid var(--color-green-light);
    border-radius:var(--radius-md); background:rgba(0,165,114,0.15); color:#6EE7C0;
    font-weight:700; font-size:0.875rem; display:flex; align-items:center; gap:0.5rem;
}

.ex-btn-primary {
    background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white;
    padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-red); font-weight:700;
    cursor:pointer; font-size:0.875rem; text-transform:uppercase;
}
.ex-btn-secondary {
    background:transparent; color:var(--text-light); padding:0.875rem 2rem; border-radius:var(--radius-md);
    border:2px solid var(--border-input); font-weight:600; text-decoration:none; font-size:0.875rem;
    text-transform:uppercase; display:inline-flex; align-items:center;
}

.ex-multiselect {
    width:100%; min-height:210px; padding:0; border:2px solid var(--border-input);
    border-radius:12px; background:#FFFFFF; color:#1A1A1A; font-size:0.9rem; overflow-y:auto;
}
.ex-multiselect option { padding:0.6rem 0.85rem; color:#1A1A1A; background:#FFFFFF; }
.ex-multiselect option:checked {
    background: linear-gradient(0deg, var(--color-green) 0%, var(--color-green) 100%);
    background-color: var(--color-green) !important; color:white;
}

.ex-empty-msg { padding:2rem; text-align:center; color:var(--text-muted); background:rgba(255,255,255,0.03); border-radius:var(--radius-md); }
</style>

<div class="content-wrapper">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; background:var(--bg-card); padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--text-light); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Nouvel Examen
        </h1>
        <a href="{{ route('examens.index') }}" style="color:var(--text-muted); text-decoration:none; font-size:.85rem;">← Retour</a>
    </div>

    @if($errors->any())
    <div class="ex-card" style="border-color: rgba(206,17,38,0.4); background: rgba(206,17,38,0.12);">
        <strong style="color:#FFD6D0;">⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem; color:#FFD6D0;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('examens.store') }}">
        @csrf

        {{-- Informations générales --}}
        <div class="ex-card">
            <h2 style="font-size:1rem; font-weight:700; color:var(--text-light); margin-bottom:1.5rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                📋 Informations Générales
            </h2>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px,1fr)); gap:1.5rem;">

                <div>
                    <label class="ex-label">Libellé <span style="color:var(--color-red-light);">*</span></label>
                    <input type="text" name="libelle" value="{{ old('libelle') }}" placeholder="Ex: Examen Permis E - Session 2026" class="ex-input" required>
                </div>

                <div>
                    <label class="ex-label">Type d'examen <span style="color:var(--color-red-light);">*</span></label>
                    <select name="typeSession_id" id="typeSession_id" class="ex-input" style="background:white; font-weight:700;" onchange="chargerCandidats(this.value)" required>
                        <option value="">-- Choisir --</option>
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
                    <label class="ex-label">Statut <span style="color:var(--color-red-light);">*</span></label>
                    <div class="ex-statut-locked">🟢 Ouvert</div>
                    <input type="hidden" name="statutExamen" value="ouvert">
                    <p style="margin-top:0.4rem; font-size:0.7rem; color:var(--text-muted);">Un nouvel examen est toujours créé « Ouvert ». Modifiable depuis la page d'édition une fois créé.</p>
                </div>

                <div>
                    <label class="ex-label">Date Début <span style="color:var(--color-red-light);">*</span></label>
                    <input type="date" name="dateDebut" value="{{ old('dateDebut', date('Y-m-d')) }}" class="ex-input" required>
                </div>

                <div>
                    <label class="ex-label">
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
                        <select name="moniteur_id" class="ex-input">
                            <option value="">-- Aucun --</option>
                            @foreach($moniteurs as $m)
                                <option value="{{ $m->id }}" {{ old('moniteur_id')==$m->id ? 'selected':'' }}>{{ $m->nom }} {{ $m->prenom }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>

        {{-- Candidats programmés --}}
        <div class="ex-card">
            <h2 style="font-size:1rem; font-weight:700; color:var(--text-light); margin-bottom:1rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                👥 Candidats programmés — à inscrire à cet examen
            </h2>

            <div id="candidats-placeholder" style="padding:2rem; text-align:center; color:var(--text-muted);">
                👆 Choisissez d'abord un <strong style="color:var(--text-light);">type d'examen</strong> ci-dessus pour voir les candidats programmés correspondants.
            </div>

            <div id="candidats-wrapper" style="display:none;">
                <div style="margin-bottom:0.75rem;">
                    <input type="text" id="candidatSearch" onkeyup="filterSelect()"
                           placeholder="🔍 Rechercher un candidat par nom ou prénom..." class="ex-input">
                </div>

                <select name="candidat_ids[]" id="candidatSelect" multiple size="10" class="ex-multiselect"></select>

                <p style="margin-top:0.75rem; font-size:0.75rem; color:var(--text-muted);">
                    ℹ️ Maintenez <strong style="color:var(--text-light);">Ctrl</strong> (ou <strong style="color:var(--text-light);">Cmd</strong> sur Mac) pour sélectionner plusieurs candidats. Seuls les candidats déjà programmés pour ce type précis, et pas encore inscrits à un examen de ce type, apparaissent ici.
                </p>
            </div>
        </div>

        <div style="display:flex; gap:1rem;">
            <button type="submit" class="ex-btn-primary">✓ Créer l'examen</button>
            <a href="{{ route('examens.index') }}" class="ex-btn-secondary">✕ Annuler</a>
        </div>
    </form>
</div>

<script>
let candidatsCourants = [];

function chargerCandidats(typeSessionId) {
    const placeholder = document.getElementById('candidats-placeholder');
    const wrapper      = document.getElementById('candidats-wrapper');
    const select        = document.getElementById('candidatSelect');

    if (!typeSessionId) {
        placeholder.style.display = 'block';
        wrapper.style.display = 'none';
        return;
    }

    placeholder.style.display = 'none';
    wrapper.style.display = 'block';
    select.innerHTML = '<option disabled>Chargement...</option>';

    fetch(`/examens/candidats-par-type/${typeSessionId}`)
        .then(r => r.json())
        .then(data => {
            candidatsCourants = data.candidats;
            renderCandidats(candidatsCourants);
        });
}

function renderCandidats(list) {
    const select = document.getElementById('candidatSelect');
    if (!list.length) {
        select.innerHTML = '';
        select.style.display = 'none';
        document.getElementById('candidats-wrapper').insertAdjacentHTML('beforeend',
            '<div class="ex-empty-msg" id="empty-msg">📭 Aucun candidat programmé pour ce type et pas encore inscrit à un examen correspondant.</div>');
        return;
    }
    const oldEmpty = document.getElementById('empty-msg');
    if (oldEmpty) oldEmpty.remove();
    select.style.display = 'block';

    select.innerHTML = list.map(c => `
        <option value="${c.id}" data-search="${(c.nom + ' ' + c.prenom).toLowerCase()}">
            ${c.nom} ${c.prenom}
        </option>
    `).join('');
}

function filterSelect() {
    const query = document.getElementById('candidatSearch').value.toLowerCase().trim();
    document.querySelectorAll('#candidatSelect option').forEach(opt => {
        opt.style.display = opt.dataset.search.includes(query) ? '' : 'none';
    });
}
</script>
</x-layouts::app>
