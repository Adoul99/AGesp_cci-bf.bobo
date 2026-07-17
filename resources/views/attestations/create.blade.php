<x-layouts::app title="Nouvelle Attestation">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-dark: #A00D20; --color-green-light: #00A572;
    --color-green-dark: #004D3A; --color-gold-dark: #E5B800;
    --color-dark: #1A1A1A; --color-gray-100: #E8E8E8;
    --color-gray-200: #D1D1D1; --color-gray-500: #666666;
    --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
    --radius-md: 8px; --radius-lg: 12px;
}
.locked-box {
    padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md);
    background:var(--color-gray-100); color:var(--color-dark); font-weight:700; font-size:0.875rem;
    display:flex; align-items:center; gap:0.5rem; min-height:2.6rem;
}
.locked-box.is-empty { color:var(--color-red); font-weight:600; font-size:0.8rem; }
.locked-badge {
    background:var(--color-gray-500); color:white; font-size:0.6rem; padding:0.1rem 0.4rem;
    border-radius:50px; margin-left:0.3rem; text-transform:uppercase; letter-spacing:0.3px;
}
</style>

<div class="content-wrapper" style="padding:2rem;">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; background:white; padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Nouvelle Attestation
        </h1>
        <a href="{{ route('attestations.index') }}" style="color:var(--color-gray-500); text-decoration:none; font-size:.85rem;">← Retour</a>
    </div>

    @if($errors->any())
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(206,17,38,0.1); border-left:4px solid var(--color-red); border-radius:var(--radius-md); color:var(--color-red-dark);">
        <strong>⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    @if(isset($candidatPreselectionne) && $candidatPreselectionne)
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(0,122,94,0.1); border-left:4px solid var(--color-green); border-radius:var(--radius-md); color:var(--color-green-dark); font-weight:600;">
        🎓 Candidat présélectionné automatiquement depuis l'examen — vérifiez les informations avant validation.
    </div>
    @endif

    @if($candidats->isEmpty())
    <div style="padding:2rem; text-align:center; background:white; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); color:var(--color-gray-500);">
        📭 Aucun candidat admis disponible. Tous les candidats admis ont déjà une attestation, ou aucun candidat n'a encore validé le permis (code + créneau + conduite).
    </div>
    @else
    <form method="POST" action="{{ route('attestations.store') }}" style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100);">
        @csrf

        <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-bottom:1.5rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
            🎓 Informations de l'Attestation
        </h2>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px,1fr)); gap:1.75rem;">

            {{-- Numéro auto-généré (verrouillé) --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Numéro d'Attestation
                    <span style="background:var(--color-green); color:white; font-size:0.65rem; padding:0.15rem 0.5rem; border-radius:50px; margin-left:0.5rem;">AUTO</span>
                </label>
                <div style="padding:0.75rem 1rem; border:2px solid var(--color-green); border-radius:var(--radius-md); background:rgba(0,122,94,0.06); color:var(--color-green-dark); font-weight:700; font-size:0.875rem; display:flex; align-items:center; gap:0.5rem; font-family:monospace;">
                    🔖 {{ $numeroAuto }}
                </div>
                <input type="hidden" name="numeroAttestation" value="{{ $numeroAuto }}">
            </div>

            {{-- Candidat : SEUL champ librement choisi par l'utilisateur avec la civilité/date/directeur --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Candidat <span style="color:var(--color-red);">*</span>
                    <span style="background:rgba(0,122,94,0.15); color:var(--color-green-dark); font-size:0.65rem; padding:0.15rem 0.5rem; border-radius:50px; margin-left:0.5rem;">ADMIS UNIQUEMENT</span>
                </label>
                <select name="candidat_id" id="candidat_id" required onchange="appliquerSuggestions(this)"
                        style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                        onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                    <option value="">-- Choisir un candidat admis --</option>
                    @foreach($candidats as $c)
                        @php $sug = $suggestions[$c->id] ?? []; @endphp
                        <option value="{{ $c->id }}"
                                {{ old('candidat_id', $candidatPreselectionne ?? null) == $c->id ? 'selected' : '' }}
                                data-admission-code="{{ $sug['dateAdmissionCode'] ? \Carbon\Carbon::parse($sug['dateAdmissionCode'])->format('Y-m-d') : '' }}"
                                data-admission-conduite="{{ $sug['dateAdmissionConduite'] ? \Carbon\Carbon::parse($sug['dateAdmissionConduite'])->format('Y-m-d') : '' }}"
                                data-categorie="{{ $sug['categorieObtenue'] ?? '' }}"
                                data-examen-id="{{ $sug['examenId'] ?? '' }}"
                                data-examen-libelle="{{ $sug['examenLibelle'] ?? '' }}">
                            🏆 {{ $c->nom }} {{ $c->prenom }}
                        </option>
                    @endforeach
                </select>
                @error('candidat_id')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
                <div style="font-size:0.7rem; color:var(--color-gray-500); margin-top:0.3rem;">💡 Tous les champs ci-dessous sont récupérés automatiquement dès que le candidat est choisi.</div>
            </div>

            {{-- Civilité --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Civilité <span style="color:var(--color-red);">*</span>
                </label>
                <select name="civilite" style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem;">
                    <option value="Monsieur"   {{ old('civilite','Monsieur') == 'Monsieur'   ? 'selected' : '' }}>Monsieur</option>
                    <option value="Madame"     {{ old('civilite') == 'Madame'     ? 'selected' : '' }}>Madame</option>
                    <option value="Mademoiselle" {{ old('civilite') == 'Mademoiselle' ? 'selected' : '' }}>Mademoiselle</option>
                </select>
            </div>

            {{-- Catégorie obtenue : VERROUILLÉE, calculée automatiquement --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Catégorie de Permis Obtenue <span class="locked-badge">🔒 Auto</span>
                </label>
                <div class="locked-box" id="categorieObtenue-display">Choisissez un candidat</div>
                <input type="hidden" name="categorieObtenue" id="categorieObtenue">
                @error('categorieObtenue')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
            </div>

            {{-- Examen : VERROUILLÉ, déduit de la catégorie du candidat --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Examen <span class="locked-badge">🔒 Auto</span>
                </label>
                <div class="locked-box" id="examen-display">Choisissez un candidat</div>
                <input type="hidden" name="examen_id" id="examen_id">
            </div>

            {{-- Date de délivrance --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Date de Délivrance <span style="color:var(--color-red);">*</span>
                </label>
                <input type="date" name="dateDelivrance" value="{{ old('dateDelivrance', date('Y-m-d')) }}"
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                       onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                @error('dateDelivrance')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
            </div>

            {{-- Date d'admission Code : VERROUILLÉE --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Date d'admission — Code <span class="locked-badge">🔒 Auto</span>
                </label>
                <input type="date" name="dateAdmissionCode" id="dateAdmissionCode" readonly
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; background:var(--color-gray-100); color:var(--color-dark);">
            </div>

            {{-- Date d'admission Conduite : VERROUILLÉE --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Date d'admission — Conduite <span class="locked-badge">🔒 Auto</span>
                </label>
                <input type="date" name="dateAdmissionConduite" id="dateAdmissionConduite" readonly
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; background:var(--color-gray-100); color:var(--color-dark);">
            </div>

            {{-- Directeur (signataire) --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Civilité du Directeur Régional
                </label>
                <select name="directeurCivilite" style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem;">
                    <option value="Monsieur" {{ old('directeurCivilite','Monsieur') == 'Monsieur' ? 'selected' : '' }}>Monsieur</option>
                    <option value="Madame"   {{ old('directeurCivilite') == 'Madame'   ? 'selected' : '' }}>Madame</option>
                </select>
            </div>

            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Nom du Directeur Régional <span style="color:var(--color-red);">*</span>
                </label>
                <input type="text" name="directeurNom" value="{{ old('directeurNom', 'François DRABO') }}" required
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem;">
            </div>

        </div>

        {{-- Boutons --}}
        <div style="display:flex; gap:1rem; margin-top:2rem; padding-top:2rem; border-top:1px solid var(--color-gray-100);">
            <button type="submit"
                    style="background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white; padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-red); font-weight:600; cursor:pointer; font-size:0.875rem; text-transform:uppercase;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                ✓ Créer l'attestation
            </button>
            <a href="{{ route('attestations.index') }}"
               style="background:var(--color-gray-100); color:var(--color-dark); padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-gray-200); font-weight:600; text-decoration:none; font-size:0.875rem; text-transform:uppercase; display:inline-flex; align-items:center;">
                ✕ Annuler
            </a>
        </div>
    </form>
    @endif
</div>

<script>
function appliquerSuggestions(select) {
    const opt = select.options[select.selectedIndex];
    const categorieDisplay = document.getElementById('categorieObtenue-display');
    const examenDisplay    = document.getElementById('examen-display');

    if (!opt || !opt.value) {
        categorieDisplay.textContent = 'Choisissez un candidat';
        categorieDisplay.classList.remove('is-empty');
        examenDisplay.textContent = 'Choisissez un candidat';
        examenDisplay.classList.remove('is-empty');
        document.getElementById('categorieObtenue').value = '';
        document.getElementById('examen_id').value = '';
        document.getElementById('dateAdmissionCode').value = '';
        document.getElementById('dateAdmissionConduite').value = '';
        return;
    }

    // Dates d'admission officielles (verrouillées)
    document.getElementById('dateAdmissionCode').value     = opt.dataset.admissionCode || '';
    document.getElementById('dateAdmissionConduite').value = opt.dataset.admissionConduite || '';

    // Catégorie obtenue (verrouillée)
    const categorie = opt.dataset.categorie;
    document.getElementById('categorieObtenue').value = categorie || '';
    if (categorie) {
        categorieDisplay.textContent = 'Catégorie ' + categorie;
        categorieDisplay.classList.remove('is-empty');
    } else {
        categorieDisplay.textContent = '⚠️ Catégorie introuvable — vérifiez l\'inscription du candidat';
        categorieDisplay.classList.add('is-empty');
    }

    // Examen correspondant (verrouillé)
    const examenId      = opt.dataset.examenId;
    const examenLibelle  = opt.dataset.examenLibelle;
    document.getElementById('examen_id').value = examenId || '';
    if (examenLibelle) {
        examenDisplay.textContent = '📋 ' + examenLibelle;
        examenDisplay.classList.remove('is-empty');
    } else {
        examenDisplay.textContent = '⚠️ Aucun examen correspondant trouvé';
        examenDisplay.classList.add('is-empty');
    }
}

// Si un candidat est présélectionné (via ?candidat_id=... depuis le module Examens),
// on applique immédiatement ses informations au chargement de la page.
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('candidat_id');
    if (select && select.value) {
        appliquerSuggestions(select);
    }
});
</script>
</x-layouts::app>
