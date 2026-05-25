<x-layouts::app.sidebar title="Liste des Véhicules">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-dark: #1A1A1A; --color-gray-100: #E8E8E8;
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1); --radius-lg: 12px;
        }
        @media print { .no-print { display: none !important; } }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">
        <!-- En-tête -->
        <div class="header-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red), var(--color-green), var(--color-gold)); margin-right: 1rem; border-radius: 2px;"></span>
                Parc Automobile
            </h1>
            <div class="no-print" style="display: flex; gap: 1rem;">
                <a href="{{ route('vehicules.create') }}" style="background: var(--color-red); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 0.8rem;">+ Nouveau Véhicule</a>
            </div>
        </div>

        @if(session('success'))
            <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(0, 122, 94, 0.1); border-left: 4px solid var(--color-green); color: var(--color-green); font-weight: 600; border-radius: 8px;">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: var(--color-green); color: white; text-transform: uppercase; font-size: 0.8rem;">
                    <tr>
                        <th style="padding: 1rem; text-align: left;">Nom</th>
                        <th style="padding: 1rem; text-align: left;">Modèle</th>
                        <th style="padding: 1rem; text-align: left;">Immatriculation</th>
                        <th style="padding: 1rem; text-align: center;" class="no-print">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicules as $vehicule)
                    <tr style="border-bottom: 1px solid var(--color-gray-100);">
                        <td style="padding: 1rem; font-weight: 600;">{{ $vehicule->nomVehicule }}</td>
                        <td style="padding: 1rem;">{{ $vehicule->modeleVehicule }}</td>
                        <td style="padding: 1rem;">
                            <span style="background: #fef3c7; color: #856404; padding: 0.2rem 0.5rem; border-radius: 4px; font-weight: bold; font-family: monospace;">
                                {{ $vehicule->immatriculation }}
                            </span>
                        </td>
                        <td style="padding: 1rem; text-align: center;" class="no-print">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <a href="{{ route('vehicules.edit', $vehicule->id) }}" style="color: var(--color-green); text-decoration: none;">✎</a>
                                <form action="{{ route('vehicules.destroy', $vehicule->id) }}" method="POST" onsubmit="return confirm('Supprimer ce véhicule ?')">
                                    @csrf @method('DELETE')
                                    <button style="color: var(--color-red); background: none; border: none; cursor: pointer;">✕</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="padding: 3rem; text-align: center; color: #666;">Aucun véhicule enregistré.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts::app.sidebar>