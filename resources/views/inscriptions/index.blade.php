<x-layouts::app.sidebar title="Liste des Inscriptions">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-red-dark: #A00D20; --color-gray-100: #F8F9FA;
            --color-gray-200: #E9ECEF; --color-dark: #1A1A1A; --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --radius-lg: 12px;
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">
        <div class="header-section" style="margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red); display: flex; justify-content: space-between; align-items: center;">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Liste des Inscriptions
            </h1>
            <a href="{{ route('inscriptions.create') }}" style="background: var(--color-red); color: white; padding: 0.75rem 1.5rem; border-radius: var(--radius-lg); text-decoration: none; font-weight: 600; display: flex; align-items: center; transition: background 0.3s;">
                + Nouvelle Inscription
            </a>
        </div>

        <div style="background: white; padding: 1rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead style="background-color: var(--color-gray-100);">
                    <tr>
                        <th style="padding: 1rem; border-bottom: 2px solid var(--color-gray-200);">Candidat</th>
                        <th style="padding: 1rem; border-bottom: 2px solid var(--color-gray-200);">Date Inscription</th>
                        <th style="padding: 1rem; border-bottom: 2px solid var(--color-gray-200);">Statut</th>
                        <th style="padding: 1rem; border-bottom: 2px solid var(--color-gray-200);">Début Formation</th>
                        <th style="padding: 1rem; border-bottom: 2px solid var(--color-gray-200);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscriptions as $inscription)
                    <tr style="border-bottom: 1px solid var(--color-gray-200); transition: background 0.2s;" onmouseover="this.style.backgroundColor='#fcfcfc'" onmouseout="this.style.backgroundColor='transparent'">
                        <td style="padding: 1rem; font-weight: 500;">{{ $inscription->candidat->nom ?? 'N/A' }} {{ $inscription->candidat->prenom ?? '' }}</td>
                        <td style="padding: 1rem;">{{ $inscription->dateInscription }}</td>
                        <td style="padding: 1rem;">
                            <span style="padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.85rem; background: {{ $inscription->statutInscription == 'actif' ? '#d4edda' : '#fff3cd' }}; color: {{ $inscription->statutInscription == 'actif' ? '#155724' : '#856404' }};">
                                {{ ucfirst($inscription->statutInscription) }}
                            </span>
                        </td>
                        <td style="padding: 1rem;">{{ $inscription->dataDebut_formation }}</td>
                        <td style="padding: 1rem; display: flex; gap: 0.5rem;">
                            <a href="{{ route('inscriptions.edit', $inscription->id) }}" style="background: #ffc107; color: #000; padding: 0.4rem 0.8rem; border-radius: 6px; text-decoration: none; font-size: 0.85rem;">Modifier</a>
                            <form method="POST" action="{{ route('inscriptions.destroy', $inscription->id) }}" onsubmit="return confirm('Êtes-vous sûr ?')">
                                @csrf @method('DELETE')
                                <button type="submit" style="background: #dc3545; color: white; padding: 0.4rem 0.8rem; border-radius: 6px; border: none; cursor: pointer; font-size: 0.85rem;">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layouts::app.sidebar>