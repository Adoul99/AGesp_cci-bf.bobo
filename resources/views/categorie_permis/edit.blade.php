<x-layouts::app title="Modifier Catégorie de Permis">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-light: #E85040; --color-red-dark: #A00D20;
    --color-green-light: #00A572; --color-green-dark: #004D3A;
    --color-gold-dark: #E5B800;

    --bg-page: linear-gradient(160deg, #0B2F1D 0%, #0F3D24 45%, #123F26 100%);
    --card-bg: rgba(255,255,255,0.05);
    --card-border: rgba(255,255,255,0.14);
    --input-bg: rgba(0,0,0,0.22);
    --input-border: rgba(255,255,255,0.22);
    --text-light: #F4F9F6;
    --text-muted: #A9C4B4;
    --radius-md: 10px; --radius-lg: 16px;
    --shadow-md: 0 10px 30px rgba(0,0,0,0.35);
}

.content-wrapper { background: var(--bg-page); min-height: 100vh; padding: 2.5rem; font-family: inherit; }

.cp-pill {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: rgba(206,17,38,0.18); border: 1px solid rgba(206,17,38,0.4);
    color: #FFD6D0; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.06em; padding: 0.4rem 0.9rem; border-radius: 50px; margin-bottom: 1.25rem;
}
.cp-pill .dot { width: 7px; height: 7px; border-radius: 50%; background: var(--color-red); box-shadow: 0 0 6px var(--color-red); }

.cp-title { font-size: 2.1rem; font-weight: 800; color: var(--text-light); margin: 0 0 2rem 0; letter-spacing: -0.5px; }

.cp-card {
    background: var(--card-bg); border: 1px solid var(--card-border);
    border-radius: var(--radius-lg); padding: 1.75rem 2rem; margin-bottom: 1.5rem;
    box-shadow: var(--shadow-md); backdrop-filter: blur(6px);
}
.cp-section-head { display: flex; align-items: center; gap: 0.9rem; margin-bottom: 1.5rem; }
.cp-section-num {
    width: 32px; height: 32px; border-radius: 9px; background: var(--color-red);
    color: white; font-weight: 800; font-size: 0.95rem; display: flex; align-items: center;
    justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(206,17,38,0.4);
}
.cp-section-title { font-size: 1.1rem; font-weight: 700; color: var(--text-light); margin: 0; }

.cp-label {
    display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.78rem;
    text-transform: uppercase; letter-spacing: 0.06em; color: var(--text-muted);
}
.cp-input {
    width: 100%; padding: 0.85rem 1.1rem; border: 1.5px solid var(--input-border);
    border-radius: var(--radius-md); font-size: 0.9rem; color: var(--text-light);
    background: var(--input-bg); transition: border-color 200ms ease, box-shadow 200ms ease;
}
.cp-input::placeholder { color: rgba(244,249,246,0.35); }
.cp-input:focus { outline: none; border-color: var(--color-gold); box-shadow: 0 0 0 3px rgba(252,209,22,0.18); }

.cp-input.is-valid { border-color: var(--color-green-light); background: rgba(0,122,94,0.1); }
.cp-input.is-invalid { border-color: var(--color-red-light); background: rgba(206,17,38,0.1); }
.cp-feedback { font-size: 0.78rem; margin-top: 0.4rem; display: flex; align-items: center; gap: 0.35rem; }
.cp-feedback.valid { color: #6EE7C0; }
.cp-feedback.invalid { color: #FF8A80; }

.cp-btn-primary {
    background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%);
    color: white; padding: 0.9rem 2.2rem; border-radius: var(--radius-md); border: 2px solid var(--color-green);
    font-weight: 700; cursor: pointer; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.04em;
}
.cp-btn-secondary {
    background: transparent; color: var(--text-light); padding: 0.9rem 2.2rem; border-radius: var(--radius-md);
    border: 2px solid var(--input-border); font-weight: 600; text-decoration: none; font-size: 0.875rem;
    text-transform: uppercase; letter-spacing: 0.04em; display: inline-flex; align-items: center;
}

.cp-info {
    margin-top: 1.5rem; padding: 1rem 1.25rem; background: rgba(0,122,94,0.15);
    border-left: 4px solid var(--color-green-light); border-radius: var(--radius-md);
    color: #D7F5E8; font-size: 0.85rem;
}
</style>

<div class="content-wrapper">

    <span class="cp-pill"><span class="dot"></span> CCI-BF — BOBO-DIOULASSO</span>
    <h1 class="cp-title">Modifier Catégorie de Permis</h1>

    @if($errors->any())
    <div class="cp-card" style="border-color: rgba(206,17,38,0.4); background: rgba(206,17,38,0.1);">
        <strong style="color:#FFD6D0;">⚠️ Erreurs :</strong>
        <ul style="margin:0.5rem 0 0 1.5rem; color:#FFD6D0;">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('categorie_permis.update', ['categoriePermis' => $categoriePermis->id]) }}">
        @csrf
        @method('PUT')

        <div class="cp-card">
            <div class="cp-section-head">
                <span class="cp-section-num">1</span>
                <h2 class="cp-section-title">Informations de la Catégorie</h2>
            </div>

            <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px,1fr)); gap:1.75rem;">
                <div>
                    <label class="cp-label">Nom de la Catégorie <span style="color:var(--color-red-light);">*</span></label>
                    <input type="text" id="nomCategorie" name="nomCategorie"
                           value="{{ old('nomCategorie', $categoriePermis->nomCategorie) }}"
                           class="cp-input @error('nomCategorie') is-invalid @enderror"
                           placeholder="Ex: Catégorie B, Catégorie C..." required>
                    @error('nomCategorie')
                        <span class="cp-feedback invalid">⚠ {{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="cp-label">Description <span style="color:var(--text-muted); font-weight:400; text-transform:none;">(facultatif)</span></label>
                    <input type="text" id="description" name="description"
                           value="{{ old('description', $categoriePermis->description) }}"
                           class="cp-input @error('description') is-invalid @enderror"
                           placeholder="Ex: Véhicules légers, Poids lourds...">
                    @error('description')
                        <span class="cp-feedback invalid">⚠ {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div style="display:flex; gap:1rem;">
            <button type="submit" class="cp-btn-primary">✓ Mettre à jour</button>
            <a href="{{ route('categorie_permis.index') }}" class="cp-btn-secondary">✕ Annuler</a>
        </div>
    </form>

    <div class="cp-info">
        ℹ️ Les champs marqués avec un <strong style="color:#FF8A80;">*</strong> sont obligatoires.
    </div>
</div>

</x-layouts::app>
