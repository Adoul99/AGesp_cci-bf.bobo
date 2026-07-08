<x-layouts::app.sidebar title="Modifier Examen">
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

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; background:white; padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-gold);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Modifier — {{ $examen->libelle }}
        </h1>
        <a href="{{ route('examens.index') }}" style="color:var(--color-gray-500); text-decoration:none; font-size:.85rem;">← Retour</a>
    </div>

    @if($errors->any())
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(206,17,38,0.1); border-left:4px solid var(--color-red); border-radius:var(--radius-md); color:var(--color-red-dark);">
        <strong>⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('examens.update', $examen->id) }}">
        @csrf
        @method('PUT')

        {{-- Informations générales --}}
        <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:1.5rem;">
            <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-bottom:1.5rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                📋 Informations Générales
            </h2>
            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(240px,1fr)); gap:1.5rem;">

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Libellé *</label>
                    <input type="text" name="libelle" value="{{ old('libelle', $examen->libelle) }}"
                           style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                           onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                    @error('libelle')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Statut *</label>
                    <select name="statutExamen" style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;" required
                            onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                        <option value="ouvert" {{ old('statutExamen', $examen->statutExamen)=='ouvert' ? 'selected':'' }}>🟢 Ouvert</option>
                        <option value="en_attente" {{ old('statutExamen', $examen->statutExamen)=='en_attente' ? 'selected':'' }}>⏳ En attente</option>
                        <option value="termine" {{ old('statutExamen', $examen->statutExamen)=='termine' ? 'selected':'' }}>🔴 Terminé</option>
                    </select>
                    @error('statutExamen')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Date Début *</label>
                    <input type="date" name="dateDebut" value="{{ old('dateDebut', $examen->dateDebut) }}"
                           style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                           onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                    @error('dateDebut')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Date Fin *</label>
                    <input type="date" name="dateFin" value="{{ old('dateFin', $examen->dateFin) }}"
                           style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                           onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                    @error('dateFin')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">Moniteur</label>
                    <select name="moniteur_id" style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                            onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                        <option value="">-- Aucun --</option>
                        @foreach($moniteurs as $m)
                            <option value="{{ $m->id }}" {{ old('moniteur_id', $examen->moniteur_id)==$m->id ? 'selected':'' }}>{{ $m->nom }} {{ $m->prenom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- ── Candidats programmés disponibles : sélection via liste multiple ── --}}
        @if($candidatsProgrammes->isNotEmpty())
        <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:1.5rem;">
            <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-bottom:1rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                📋 Candidats programmés disponibles ({{ $candidatsProgrammes->count() }})
            </h2>

            <div style="margin-bottom:0.75rem;">
                <input type="text" id="candidatSearchDispo" onkeyup="filterSelect('candidatSearchDispo','candidatSelectDispo')"
                       placeholder="🔍 Rechercher un candidat par nom ou prénom..."
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                       onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
            </div>

            <select name="candidat_ids[]" id="candidatSelectDispo" multiple size="8"
                    style="width:100%; padding:0.5rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.9rem; color:var(--color-dark); background:white;">
                @foreach($candidatsProgrammes as $c)
                    <option value="{{ $c->id }}"
                            data-search="{{ strtolower($c->nom.' '.$c->prenom) }}"
                            {{ in_array($c->id, old('candidat_ids', $candidatsSelectionnes)) ? 'selected' : '' }}>
                        {{ $c->nom }} {{ $c->prenom }} — {{ $c->programmations->last()->typeSession->type ?? '—' }}
                    </option>
                @endforeach
            </select>
            <p style="margin-top:0.75rem; font-size:0.75rem; color:var(--color-gray-500);">
                ℹ️ Maintenez <strong>Ctrl</strong> enfoncé pour sélectionner plusieurs candidats.
            </p>
        </div>
        @endif

        {{-- ── Candidats inscrits avec saisie résultat : reste en tableau (résultat + observation par ligne) ── --}}
        <div style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100); margin-bottom:1.5rem;">
            <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-bottom:1rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
                📋 Candidats inscrits & Résultats ({{ $examen->candidats->count() }})
            </h2>

            @if($examen->candidats->isEmpty())
            <div style="padding:2rem; text-align:center; color:var(--color-gray-500);">
                📭 Aucun candidat inscrit pour le moment.
            </div>
            @else
            <div style="margin-bottom:1rem;">
                <input type="text" id="candidatSearchInscrits" onkeyup="filterTable('candidatSearchInscrits','candidatsInscritsTableBody','noResultsInscrits')"
                       placeholder="🔍 Rechercher parmi les candidats inscrits..."
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                       onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
            </div>

            <div style="overflow-x:auto; border:1px solid var(--color-gray-100); border-radius:var(--radius-md); max-height:420px; overflow-y:auto;">
                <table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
                    <thead style="position:sticky; top:0; background:rgba(0,122,94,0.1); font-size:0.72rem; text-transform:uppercase; z-index:1;">
                        <tr>
                            <th style="padding:0.75rem 1rem; text-align:center; font-weight:700; color:var(--color-dark); width:70px;">Inscrire</th>
                            <th style="padding:0.75rem 1rem; text-align:left; font-weight:700; color:var(--color-dark);">Candidat</th>
                            <th style="padding:0.75rem 1rem; text-align:center; font-weight:700; color:var(--color-dark); width:160px;">Résultat</th>
                            <th style="padding:0.75rem 1rem; text-align:left; font-weight:700; color:var(--color-dark);">Observation</th>
                        </tr>
                    </thead>
                    <tbody id="candidatsInscritsTableBody">
                        @foreach($examen->candidats as $candidat)
                        <tr data-search="{{ strtolower($candidat->nom.' '.$candidat->prenom) }}" style="border-bottom:1px solid var(--color-gray-100);">
                            <td style="padding:0.75rem 1rem; text-align:center;">
                                <input type="checkbox" name="candidat_ids[]" value="{{ $candidat->id }}" checked
                                       style="width:18px; height:18px; accent-color:var(--color-green); cursor:pointer;">
                            </td>
                            <td style="padding:0.75rem 1rem; font-weight:600; color:var(--color-dark);">
                                👤 {{ $candidat->nom }} {{ $candidat->prenom }}
                            </td>
                            <td style="padding:0.75rem 1rem; text-align:center;">
                                <select name="resultats[{{ $candidat->id }}]"
                                        style="padding:0.4rem 0.75rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.8rem; background:white;">
                                    <option value="En attente" {{ $candidat->pivot->resultat=='En attente' ? 'selected':'' }}>⏳ En attente</option>
                                    <option value="Admis" {{ $candidat->pivot->resultat=='Admis' ? 'selected':'' }}>✅ Admis</option>
                                    <option value="Ajourné" {{ $candidat->pivot->resultat=='Ajourné' ? 'selected':'' }}>❌ Ajourné</option>
                                </select>
                            </td>
                            <td style="padding:0.75rem 1rem;">
                                <input type="text" name="observations[{{ $candidat->id }}]"
                                       value="{{ $candidat->pivot->observation }}" placeholder="Remarque..."
                                       style="width:100%; padding:0.4rem 0.75rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.8rem;">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="noResultsInscrits" style="display:none; padding:1.5rem; text-align:center; color:var(--color-gray-500);">
                    Aucun candidat ne correspond à cette recherche.
                </div>
            </div>
            <p style="margin-top:0.75rem; font-size:0.75rem; color:var(--color-gray-500);">
                ℹ️ Décochez "Inscrire" pour retirer un candidat de l'examen.
            </p>
            @endif
        </div>

        {{-- Boutons --}}
        <div style="display:flex; gap:1rem;">
            <button type="submit"
                    style="background:linear-gradient(135deg,var(--color-green) 0%,var(--color-green-dark) 100%); color:white; padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-green); font-weight:700; cursor:pointer; font-size:0.875rem; text-transform:uppercase;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                ✓ Mettre à jour
            </button>
            <a href="{{ route('examens.show', $examen->id) }}"
               style="background:rgba(252,209,22,0.15); color:var(--color-gold-dark); padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-gold); font-weight:600; text-decoration:none; font-size:0.875rem; text-transform:uppercase; display:inline-flex; align-items:center;">
                👁️ Voir détail
            </a>
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

function filterTable(inputId, tbodyId, noResultsId) {
    const query = document.getElementById(inputId).value.toLowerCase().trim();
    const rows = document.querySelectorAll('#' + tbodyId + ' tr');
    let visibleCount = 0;
    rows.forEach(row => {
        const match = row.dataset.search.includes(query);
        row.style.display = match ? '' : 'none';
        if (match) visibleCount++;
    });
    document.getElementById(noResultsId).style.display = visibleCount === 0 ? 'block' : 'none';
}
</script>
</x-layouts::app.sidebar>