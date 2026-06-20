<x-layouts::app.sidebar title="Modifier Attestation">
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

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; background:white; padding:1.5rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-gold);">
        <h1 style="font-size:1.875rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center;">
            <span style="width:5px; height:35px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); margin-right:1rem; border-radius:2px;"></span>
            Modifier — {{ $attestation->numeroAttestation }}
        </h1>
        <a href="{{ route('attestations.index') }}" style="color:var(--color-gray-500); text-decoration:none; font-size:.85rem;">← Retour</a>
    </div>

    @if($errors->any())
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(206,17,38,0.1); border-left:4px solid var(--color-red); border-radius:var(--radius-md); color:var(--color-red-dark);">
        <strong>⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem;">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('attestations.update', $attestation->id) }}" style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100);">
        @csrf
        @method('PUT')

        <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-bottom:1.5rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
            🎓 Informations de l'Attestation
        </h2>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px,1fr)); gap:1.75rem;">

            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Numéro d'Attestation <span style="color:var(--color-red);">*</span>
                </label>
                <input type="text" name="numeroAttestation" value="{{ old('numeroAttestation', $attestation->numeroAttestation) }}"
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); font-family:monospace;"
                       onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                @error('numeroAttestation')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Candidat <span style="color:var(--color-red);">*</span>
                </label>
                <select name="candidat_id" required
                        style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                        onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                    <option value="">-- Choisir --</option>
                    @foreach($candidats as $c)
                        <option value="{{ $c->id }}" {{ old('candidat_id', $attestation->candidat_id) == $c->id ? 'selected' : '' }}>
                            {{ $c->nom }} {{ $c->prenom }}
                        </option>
                    @endforeach
                </select>
                @error('candidat_id')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
            </div>

            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Examen <span style="color:var(--color-gray-500); font-size:0.7rem; font-weight:400;">(Facultatif)</span>
                </label>
                <select name="examen_id"
                        style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                        onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                    <option value="">-- Aucun --</option>
                    @foreach($examens as $ex)
                        <option value="{{ $ex->id }}" {{ old('examen_id', $attestation->examen_id) == $ex->id ? 'selected' : '' }}>
                            {{ $ex->libelle }} ({{ \Carbon\Carbon::parse($ex->dateDebut)->format('d/m/Y') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Date de Délivrance <span style="color:var(--color-red);">*</span>
                </label>
                <input type="date" name="dateDelivrance" value="{{ old('dateDelivrance', \Carbon\Carbon::parse($attestation->dateDelivrance)->format('Y-m-d')) }}"
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                       onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'" required>
                @error('dateDelivrance')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
            </div>

        </div>

        <div style="display:flex; gap:1rem; margin-top:2rem; padding-top:2rem; border-top:1px solid var(--color-gray-100);">
            <button type="submit"
                    style="background:linear-gradient(135deg,var(--color-green) 0%,var(--color-green-dark) 100%); color:white; padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-green); font-weight:600; cursor:pointer; font-size:0.875rem; text-transform:uppercase;">
                ✓ Mettre à jour
            </button>
            <a href="{{ route('attestations.show', $attestation->id) }}"
               style="background:rgba(252,209,22,0.15); color:var(--color-gold-dark); padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-gold); font-weight:600; text-decoration:none; font-size:0.875rem; text-transform:uppercase; display:inline-flex; align-items:center;">
                👁️ Voir attestation
            </a>
            <a href="{{ route('attestations.index') }}"
               style="background:var(--color-gray-100); color:var(--color-dark); padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-gray-200); font-weight:600; text-decoration:none; font-size:0.875rem; text-transform:uppercase; display:inline-flex; align-items:center;">
                ✕ Annuler
            </a>
        </div>
    </form>
</div>
</x-layouts::app.sidebar>
