<x-layouts::app.sidebar title="Liste des Dossiers">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-red-dark: #A00D20; --color-green-light: #00A572; --color-green-dark: #004D3A;
            --color-dark: #1A1A1A; --color-gray-100: #E8E8E8; --color-gray-500: #666666;
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1); --radius-lg: 12px; --radius-md: 8px;
            --transition-normal: 300ms ease-in-out;
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">
        <!-- En-tête -->
        <div class="header-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Liste des Dossiers
            </h1>
            <a href="{{ route('dossiers.create') }}" style="background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; padding: 0.75rem 1.5rem; border-radius: var(--radius-md); text-decoration: none; font-weight: 600;">
                + Nouveau Dossier
            </a>
        </div>

        @if(session('success'))
            <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(0, 122, 94, 0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark);">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div style="background: white; border-radius: var(--radius-lg); overflow-x: auto; box-shadow: var(--shadow-md);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: linear-gradient(90deg, var(--color-green) 0%, var(--color-green-light) 100%); color: white; text-transform: uppercase; font-size: 0.8rem;">
                    <tr>
                        <th style="padding: 1rem;">Dossier</th>
                        <th style="padding: 1rem;">Candidat</th>
                        <th style="padding: 1rem;">Pièces</th>
                        <th style="padding: 1rem;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dossiers as $dossier)
                    <tr style="border-bottom: 1px solid var(--color-gray-100);">
                        <td style="padding: 1rem; font-weight: 600;">{{ $dossier->nomDossier }}</td>
                        <td style="padding: 1rem;">{{ $dossier->candidat->nom ?? 'N/A' }} {{ $dossier->candidat->prenom ?? '' }}</td>
                        <td style="padding: 1rem;">
                            <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                @foreach(['cnib', 'photo_identite', 'certificat_medical', 'acte_naissance', 'recu_paiement', 'permis_c'] as $file)
                                    @if($dossier->$file)
                                        <a href="{{ asset('storage/' . $dossier->$file) }}" target="_blank" style="font-size: 0.7rem; background: #f0f0f0; padding: 2px 6px; border-radius: 4px; text-decoration: none; color: var(--color-green-dark);">
                                            {{ strtoupper($file) }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <a href="{{ route('dossiers.edit', $dossier->id) }}" style="padding: 0.5rem 1rem; background: var(--color-gray-100); border-radius: var(--radius-md); text-decoration: none; color: var(--color-green);">✎</a>
                                <form action="{{ route('dossiers.destroy', $dossier->id) }}" method="POST" onsubmit="return confirm('Supprimer ce dossier ?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" style="padding: 0.5rem 1rem; background: var(--color-gray-100); border: none; border-radius: var(--radius-md); color: #D32F2F; cursor: pointer;">✕</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 3rem; text-align: center;">Aucun dossier trouvé.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts::app.sidebar>