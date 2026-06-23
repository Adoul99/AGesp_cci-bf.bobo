<x-layouts::app.sidebar title="Nouvelle Attestation">
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

            {{-- Numéro auto-généré (readonly) --}}
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

            {{-- Candidat --}}
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
                        <option value="{{ $c->id }}" {{ old('candidat_id') == $c->id ? 'selected' : '' }}
                                data-formation-debut="{{ $sug['formationDateDebut'] ? \Carbon\Carbon::parse($sug['formationDateDebut'])->format('Y-m-d') : '' }}"
                                data-formation-fin="{{ $sug['formationDateFin'] ? \Carbon\Carbon::parse($sug['formationDateFin'])->format('Y-m-d') : '' }}"
                                data-admission-code="{{ $sug['dateAdmissionCode'] ? \Carbon\Carbon::parse($sug['dateAdmissionCode'])->format('Y-m-d') : '' }}"
                                data-admission-conduite="{{ $sug['dateAdmissionConduite'] ? \Carbon\Carbon::parse($sug['dateAdmissionConduite'])->format('Y-m-d') : '' }}">
                            🏆 {{ $c->nom }} {{ $c->prenom }}
                        </option>
                    @endforeach
                </select>
                @error('candidat_id')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
                <div style="font-size:0.7rem; color:var(--color-gray-500); margin-top:0.3rem;">💡 Les dates ci-dessous se remplissent automatiquement — vérifiez et corrigez si besoin.</div>
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

            {{-- Catégorie obtenue --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Catégorie de Permis Obtenue <span style="color:var(--color-red);">*</span>
                </label>
                <select name="categorieObtenue" style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; font-weight:700;">
                    <option value="E" {{ old('categorieObtenue','E') == 'E' ? 'selected' : '' }}>Catégorie E</option>
                    <option value="D" {{ old('categorieObtenue') == 'D' ? 'selected' : '' }}>Catégorie D</option>
                </select>
            </div>

            {{-- Examen --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Examen <span style="color:var(--color-gray-500); font-size:0.7rem; font-weight:400;">(Facultatif)</span>
                </label>
                <select name="examen_id"
                        style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                        onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                    <option value="">-- Aucun --</option>
                    @foreach($examens as $ex)
                        <option value="{{ $ex->id }}" {{ old('examen_id') == $ex->id ? 'selected' : '' }}>
                            {{ $ex->libelle }} ({{ \Carbon\Carbon::parse($ex->dateDebut)->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
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

            {{-- Formation : du --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Formation — Du <span style="background:var(--color-gold); color:var(--color-dark); font-size:0.6rem; padding:0.1rem 0.4rem; border-radius:50px; margin-left:0.3rem;">SUGGÉRÉ</span>
                </label>
                <input type="date" name="formationDateDebut" id="formationDateDebut" value="{{ old('formationDateDebut') }}"
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem;">
            </div>

            {{-- Formation : au --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Formation — Au <span style="background:var(--color-gold); color:var(--color-dark); font-size:0.6rem; padding:0.1rem 0.4rem; border-radius:50px; margin-left:0.3rem;">SUGGÉRÉ</span>
                </label>
                <input type="date" name="formationDateFin" id="formationDateFin" value="{{ old('formationDateFin') }}"
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem;">
            </div>

            {{-- Date d'admission Code --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Date d'admission — Code <span style="background:var(--color-gold); color:var(--color-dark); font-size:0.6rem; padding:0.1rem 0.4rem; border-radius:50px; margin-left:0.3rem;">SUGGÉRÉ</span>
                </label>
                <input type="date" name="dateAdmissionCode" id="dateAdmissionCode" value="{{ old('dateAdmissionCode') }}"
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem;">
            </div>

            {{-- Date d'admission Conduite --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Date d'admission — Conduite <span style="background:var(--color-gold); color:var(--color-dark); font-size:0.6rem; padding:0.1rem 0.4rem; border-radius:50px; margin-left:0.3rem;">SUGGÉRÉ</span>
                </label>
                <input type="date" name="dateAdmissionConduite" id="dateAdmissionConduite" value="{{ old('dateAdmissionConduite') }}"
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem;">
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
    if (!opt) return;
    const map = {
        'formationDateDebut':    opt.dataset.formationDebut,
        'formationDateFin':      opt.dataset.formationFin,
        'dateAdmissionCode':     opt.dataset.admissionCode,
        'dateAdmissionConduite': opt.dataset.admissionConduite,
    };
    for (const [id, val] of Object.entries(map)) {
        if (val) document.getElementById(id).value = val;
    }
}
</script>
</x-layouts::app.sidebar>