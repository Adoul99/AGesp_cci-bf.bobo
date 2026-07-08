<x-layouts::app.sidebar title="Nouvel Examen">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-dark: #A00D20; --color-green-light: #00A572;
    --color-green-dark: #004D3A; --color-gold-dark: #E5B800;
    --color-dark: #1A1A1A; --color-gray-100: #E8E8E8;
    --color-gray-200: #D1D1D1; --color-gray-500: #666666;
    --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
    --radius-md: 8px; --radius-lg: 12px; --transition-normal: 300ms ease-in-out;
}
</style>

<div class="content-wrapper" style="padding:2rem;">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; background:white; padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Nouvel Examen
        </h1>
        <a href="{{ route('examens.index') }}" style="color:var(--color-gray-500); text-decoration:none; font-size:.85rem;">← Retour</a>
    </div>

    @if($errors->any())
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(206,17,38,0.1); border-left:4px solid var(--color-red); border-radius:var(--radius-md); color:var(--color-red-dark);">
        <strong>⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('examens.store') }}">
        @csrf

        {{-- Informations générales --}}
        <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:1.5rem;">
            <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-bottom:1.5rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                📋 Informations Générales
            </h2>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px,1fr)); gap:1.5rem;">

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Libellé *</label>
                    <input type="text" name="libelle" value="{{ old('libelle') }}" placeholder="Ex: Examen Permis E - Session 2026"
                           style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                           onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                </div>

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Statut *</label>
                    <select name="statutExamen" style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;" required
                            onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                        <option value="ouvert" selected>🟢 Ouvert</option>
                        <option value="en_attente">⏳ En attente</option>
                        <option value="termine">🔴 Terminé</option>
                    </select>
                </div>

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Date Début *</label>
                    <input type="date" name="dateDebut" value="{{ old('dateDebut', date('Y-m-d')) }}"
                           style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                           onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                </div>

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Date Fin *</label>
                    <input type="date" name="dateFin" value="{{ old('dateFin', date('Y-m-d')) }}"
                           style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                           onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                </div>

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                        Moniteur
                        @if($moniteurConnecte)
                            <span style="background:var(--color-green); color:white; font-size:0.65rem; padding:0.15rem 0.5rem; border-radius:50px; margin-left:0.5rem; font-weight:700;">AUTO</span>
                        @endif
                    </label>
                    @if($moniteurConnecte)
                        <div style="padding:0.75rem 1rem; border:2px solid var(--color-green); border-radius:var(--radius-md); background:rgba(0,122,94,0.06); color:var(--color-green-dark); font-weight:700; font-size:0.875rem; display:flex; align-items:center; gap:0.5rem;">
                            🔒 {{ $moniteurConnecte->nom }} {{ $moniteurConnecte->prenom }}
                        </div>
                        <input type="hidden" name="moniteur_id" value="{{ $moniteurConnecte->id }}">
                    @else
                        <select name="moniteur_id" style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                                onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                            <option value="">-- Aucun --</option>
                            @foreach($moniteurs as $m)
                                <option value="{{ $m->id }}" {{ old('moniteur_id')==$m->id ? 'selected':'' }}>{{ $m->nom }} {{ $m->prenom }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── Candidats programmés : sélection via liste multiple ── --}}
        <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:1.5rem;">
            <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-bottom:1rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                👥 Candidats programmés — à inscrire à cet examen
            </h2>

            @if($candidatsProgrammes->isEmpty())
            <div style="padding:2rem; text-align:center; color:var(--color-gray-500); background:var(--color-light); border-radius:var(--radius-md);">
                📭 Aucun candidat programmé pour le moment.<br>
                <span style="font-size:0.8rem;">Programmez d'abord des candidats via le module <strong>Programmations</strong>.</span>
            </div>
            @else
            <div style="margin-bottom:0.75rem;">
                <input type="text" id="candidatSearch" onkeyup="filterSelect('candidatSearch','candidatSelect')"
                       placeholder="🔍 Rechercher un candidat par nom ou prénom..."
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                       onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
            </div>

            <select name="candidat_ids[]" id="candidatSelect" multiple size="10"
                    style="width:100%; padding:0.5rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.9rem; color:var(--color-dark); background:white;">
                @foreach($candidatsProgrammes as $c)
                    <option value="{{ $c->id }}"
                            data-search="{{ strtolower($c->nom.' '.$c->prenom) }}"
                            {{ is_array(old('candidat_ids')) && in_array($c->id, old('candidat_ids')) ? 'selected' : '' }}>
                        {{ $c->nom }} {{ $c->prenom }} — {{ $c->programmations->last()->typeSession->type ?? '—' }}
                    </option>
                @endforeach
            </select>

            <p style="margin-top:0.75rem; font-size:0.75rem; color:var(--color-gray-500);">
                ℹ️ Maintenez <strong>Ctrl</strong> (ou <strong>Cmd</strong> sur Mac) enfoncé pour sélectionner plusieurs candidats. Seuls les candidats déjà programmés (module Programmations) apparaissent ici.
            </p>
            @endif
        </div>

        <div style="display:flex; gap:1rem;">
            <button type="submit"
                    style="background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white; padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-red); font-weight:700; cursor:pointer; font-size:0.875rem; text-transform:uppercase;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                ✓ Créer l'examen
            </button>
            <a href="{{ route('examens.index') }}"
               style="background:var(--color-gray-100); color:var(--color-dark); padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-gray-200); font-weight:600; text-decoration:none; font-size:0.875rem; text-transform:uppercase; display:inline-flex; align-items:center;">
                ✕ Annuler
            </a>
        </div>
    </form>
</div>

<script>
function filterSelect(inputId, selectId) {
    const query = document.getElementById(inputId).value.toLowerCase().trim();
    const options = document.querySelectorAll('#' + selectId + ' option');
    options.forEach(opt => {
        opt.style.display = opt.dataset.search.includes(query) ? '' : 'none';
    });
}
</script>
</x-layouts::app.sidebar>