<x-layouts::app.sidebar title="Nouveau Reçu">
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
            Nouveau Reçu
        </h1>
        <p style="margin:0.5rem 0 0 1.5rem; color:var(--color-gray-500); font-size:0.875rem;">
            🔖 Le numéro de reçu sera généré automatiquement.
        </p>
    </div>

    {{-- Erreurs --}}
    @if($errors->any())
    <div style="margin-bottom:1.5rem; padding:1rem 1.5rem; background:rgba(206,17,38,0.1); border-left:4px solid var(--color-red); border-radius:var(--radius-md); color:var(--color-red-dark);">
        <strong>⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('recus.store') }}" enctype="multipart/form-data" style="background:white; padding:2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border:1px solid var(--color-gray-100);">
        @csrf

        <h2 style="font-size:1rem; font-weight:700; color:var(--color-dark); margin-bottom:1.5rem; padding-bottom:0.75rem; border-bottom:2px solid var(--color-gold);">
            Informations du Reçu
        </h2>

        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(260px,1fr)); gap:1.75rem;">

            {{-- Numéro reçu (readonly, généré auto) --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Numéro de Reçu
                    <span style="background:var(--color-green); color:white; font-size:0.65rem; padding:0.15rem 0.5rem; border-radius:50px; margin-left:0.5rem;">AUTO</span>
                </label>
                <div style="padding:0.75rem 1rem; border:2px solid var(--color-green); border-radius:var(--radius-md); background:rgba(0,122,94,0.06); color:var(--color-green-dark); font-weight:700; font-size:0.875rem; display:flex; align-items:center; gap:0.5rem;">
                    🔖 Généré automatiquement à l'enregistrement
                </div>
            </div>

            {{-- Paiement --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Paiement <span style="color:var(--color-red);">*</span>
                </label>
                <select name="paiement_id" id="paiement_id" required
                        style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark); background:white;"
                        onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'"
                        onchange="remplirMontant(this)">
                    <option value="">-- Choisir un paiement --</option>
                    @foreach($paiements as $paiement)
                        <option value="{{ $paiement->id }}"
                                data-montant="{{ $paiement->montant }}"
                                {{ old('paiement_id') == $paiement->id ? 'selected' : '' }}>
                            {{ $paiement->candidat ? $paiement->candidat->nom.' '.$paiement->candidat->prenom : 'N/A' }}
                            — {{ number_format($paiement->montant, 0, ',', ' ') }} FCFA
                        </option>
                    @endforeach
                </select>
                @error('paiement_id')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
            </div>

            {{-- Montant --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Montant (FCFA) <span style="color:var(--color-red);">*</span>
                </label>
                <input type="number" name="montant" id="montant"
                       value="{{ old('montant') }}" min="0" step="1" placeholder="Ex: 50000" required
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                       onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                @error('montant')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
            </div>

            {{-- Date --}}
            <div>
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Date du Reçu <span style="color:var(--color-red);">*</span>
                </label>
                <input type="date" name="dateRecus"
                       value="{{ old('dateRecus', date('Y-m-d')) }}" required
                       style="width:100%; padding:0.75rem 1rem; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); font-size:0.875rem; color:var(--color-dark);"
                       onfocus="this.style.borderColor='var(--color-green)'" onblur="this.style.borderColor='var(--color-gray-200)'">
                @error('dateRecus')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
            </div>

            {{-- Pièce jointe reçu paiement --}}
            <div style="grid-column:1/-1;">
                <label style="display:block; margin-bottom:0.5rem; font-weight:600; font-size:0.8rem; text-transform:uppercase; color:var(--color-dark);">
                    Reçu de Paiement (Pièce jointe)
                    <span style="color:var(--color-gray-500); font-size:0.7rem; font-weight:400;">(Facultatif — JPG, PNG, PDF — max 5 Mo)</span>
                </label>
                <div id="upload-zone"
                     style="border:2px dashed var(--color-gray-200); border-radius:var(--radius-md); padding:2rem; text-align:center; cursor:pointer; transition:all 0.3s; background:rgba(0,122,94,0.02);"
                     onclick="document.getElementById('recus_paiement').click()"
                     ondragover="event.preventDefault(); this.style.borderColor='var(--color-green)'; this.style.background='rgba(0,122,94,0.06)'"
                     ondragleave="this.style.borderColor='var(--color-gray-200)'; this.style.background='rgba(0,122,94,0.02)'"
                     ondrop="handleDrop(event)">
                    <div id="upload-placeholder">
                        <div style="font-size:2.5rem; margin-bottom:0.5rem;">📎</div>
                        <div style="font-weight:600; color:var(--color-dark); margin-bottom:0.25rem;">Glissez-déposez votre fichier ici</div>
                        <div style="color:var(--color-gray-500); font-size:0.8rem;">ou cliquez pour sélectionner</div>
                        <div style="margin-top:0.75rem; display:inline-block; padding:0.5rem 1.25rem; background:var(--color-green); color:white; border-radius:var(--radius-md); font-size:0.8rem; font-weight:600;">
                            📂 Choisir un fichier
                        </div>
                    </div>
                    <div id="upload-preview" style="display:none;">
                        <div style="font-size:2.5rem; margin-bottom:0.5rem;" id="file-icon">📄</div>
                        <div id="file-name" style="font-weight:700; color:var(--color-green-dark);"></div>
                        <div id="file-size" style="color:var(--color-gray-500); font-size:0.8rem; margin-top:0.25rem;"></div>
                        <button type="button" onclick="supprimerFichier(event)"
                                style="margin-top:0.75rem; padding:0.4rem 1rem; background:rgba(206,17,38,0.1); color:var(--color-red); border:1.5px solid var(--color-red); border-radius:var(--radius-md); font-size:0.8rem; cursor:pointer;">
                            ✕ Supprimer
                        </button>
                    </div>
                </div>
                <input type="file" id="recus_paiement" name="recus_paiement"
                       accept=".jpg,.jpeg,.png,.pdf"
                       style="display:none;"
                       onchange="afficherPreview(this)">
                @error('recus_paiement')<span style="color:var(--color-red); font-size:0.75rem;">{{ $message }}</span>@enderror
            </div>

        </div>

        {{-- Boutons --}}
        <div style="display:flex; gap:1rem; margin-top:2rem; padding-top:2rem; border-top:1px solid var(--color-gray-100);">
            <button type="submit"
                    style="background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white; padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-red); font-weight:600; cursor:pointer; font-size:0.875rem; text-transform:uppercase;"
                    onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                ✓ Enregistrer
            </button>
            <a href="{{ route('recus.index') }}"
               style="background:var(--color-gray-100); color:var(--color-dark); padding:0.875rem 2rem; border-radius:var(--radius-md); border:2px solid var(--color-gray-200); font-weight:600; text-decoration:none; font-size:0.875rem; text-transform:uppercase; display:inline-flex; align-items:center;">
                ✕ Annuler
            </a>
        </div>
    </form>
</div>

<script>
function afficherPreview(input) {
    if (!input.files || !input.files[0]) return;
    const file = input.files[0];
    document.getElementById('upload-placeholder').style.display = 'none';
    document.getElementById('upload-preview').style.display = 'block';
    document.getElementById('file-name').textContent = file.name;
    document.getElementById('file-size').textContent = (file.size / 1024).toFixed(1) + ' Ko';
    document.getElementById('file-icon').textContent = file.type === 'application/pdf' ? '📕' : '🖼️';
    document.getElementById('upload-zone').style.borderColor = 'var(--color-green)';
    document.getElementById('upload-zone').style.background  = 'rgba(0,122,94,0.06)';
}
function supprimerFichier(e) {
    e.stopPropagation();
    document.getElementById('recus_paiement').value = '';
    document.getElementById('upload-placeholder').style.display = 'block';
    document.getElementById('upload-preview').style.display = 'none';
    document.getElementById('upload-zone').style.borderColor = 'var(--color-gray-200)';
    document.getElementById('upload-zone').style.background  = 'rgba(0,122,94,0.02)';
}
function handleDrop(e) {
    e.preventDefault();
    const dt = e.dataTransfer;
    if (dt.files && dt.files[0]) {
        document.getElementById('recus_paiement').files = dt.files;
        afficherPreview(document.getElementById('recus_paiement'));
    }
}
function remplirMontant(select) {
    const opt = select.options[select.selectedIndex];
    if (opt.dataset.montant) document.getElementById('montant').value = opt.dataset.montant;
}
document.addEventListener('DOMContentLoaded', () => {
    const sel = document.getElementById('paiement_id');
    if (sel.value) remplirMontant(sel);
});
</script>
</x-layouts::app.sidebar>
