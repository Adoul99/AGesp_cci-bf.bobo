<x-layouts::app.sidebar title="Nouveau Véhicule">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-dark: #1A1A1A; --color-gray-100: #E8E8E8;
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1); --radius-lg: 12px;
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem; max-width: 800px; margin: 0 auto;">
        <div class="header-section" style="margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red), var(--color-green), var(--color-gold)); margin-right: 1rem; border-radius: 2px;"></span>
                Ajouter un Véhicule
            </h1>
            <p style="color: #666; margin: 0.5rem 0 0 1.5rem;">Remplissez les informations ci-dessous pour enregistrer un nouveau véhicule.</p>
        </div>

        <form method="POST" action="{{ route('vehicules.store') }}" style="background: white; padding: 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md);">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div style="grid-column: span 2;">
                    <label style="display: block; font-weight: 600; color: var(--color-dark); margin-bottom: 0.5rem;">Nom Véhicule</label>
                    <input type="text" name="nomVehicule" style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-100); border-radius: 8px; outline: none;" required>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: var(--color-dark); margin-bottom: 0.5rem;">Modèle</label>
                    <input type="text" name="modeleVehicule" style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-100); border-radius: 8px; outline: none;" required>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: var(--color-dark); margin-bottom: 0.5rem;">Immatriculation</label>
                    <input type="text" name="immatriculation" style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-gray-100); border-radius: 8px; outline: none;" required>
                </div>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" style="background: var(--color-green); color: white; padding: 0.75rem 2rem; border-radius: 8px; border: none; font-weight: 600; cursor: pointer;">
                    Enregistrer
                </button>
                <a href="{{ route('vehicules.index') }}" style="background: var(--color-gray-100); color: var(--color-dark); padding: 0.75rem 2rem; border-radius: 8px; text-decoration: none; font-weight: 600;">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</x-layouts::app.sidebar>