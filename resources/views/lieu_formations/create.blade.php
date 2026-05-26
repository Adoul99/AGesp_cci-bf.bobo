<x-layouts::app.sidebar title="Nouveau Lieu de Formation">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-green-dark: #005A42; --color-gold: #FCD116;
            --color-dark: #1A1A1A; --color-gray-200: #D1D1D1;
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1); --radius-md: 8px; --radius-lg: 12px;
            --transition-normal: 300ms ease-in-out;
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">
        <div class="header-section" style="margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Nouveau Lieu de Formation
            </h1>
        </div>

        <form method="POST" action="{{ route('lieu_formations.store') }}" style="background: white; padding: 2.5rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            @csrf
            
            <h2 style="font-size: 1.125rem; font-weight: 700; color: var(--color-dark); margin-bottom: 2rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center;">
                <span style="width: 4px; height: 20px; background: var(--color-green); margin-right: 0.75rem; border-radius: 2px;"></span>
                Localisation & Détails
            </h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                <div class="form-group">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Nom du Lieu *</label>
                    <input type="text" name="nomLieu" required placeholder="Ex: Centre de Bobo"
                           style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); transition: var(--transition-normal);"
                           onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                           onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'">
                </div>

                <div class="form-group">
                    <label style="display: block; margin-bottom: 0.5rem; color: var(--color-dark); font-weight: 600; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.5px;">Localisation *</label>
                    <input type="text" name="localisation" required placeholder="Ex: Secteur 15, Rue 12.44"
                           style="width: 100%; padding: 0.75rem 1rem; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); transition: var(--transition-normal);"
                           onfocus="this.style.borderColor='var(--color-green)'; this.style.boxShadow='0 0 0 3px rgba(0, 122, 94, 0.1)'"
                           onblur="this.style.borderColor='var(--color-gray-200)'; this.style.boxShadow='none'">
                </div>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 3rem; padding-top: 2rem; border-top: 1px solid #eee;">
                <button type="submit" style="background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%); color: white; padding: 0.875rem 2.5rem; border-radius: var(--radius-md); border: none; font-weight: 600; cursor: pointer; text-transform: uppercase; font-size: 0.85rem;">✓ Enregistrer</button>
                <a href="{{ route('lieu_formations.index') }}" style="background: #eee; color: var(--color-dark); padding: 0.875rem 2.5rem; border-radius: var(--radius-md); text-decoration: none; font-weight: 600; text-transform: uppercase; font-size: 0.85rem;">✕ Annuler</a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>