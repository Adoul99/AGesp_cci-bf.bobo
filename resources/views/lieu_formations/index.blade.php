<x-layouts::app.sidebar title="Liste des Lieux de Formation">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-red-dark: #A00D20; --color-green-light: #00A572; --color-gold-dark: #E5B800;
            --color-dark: #1A1A1A; --color-gray-100: #E8E8E8; --color-gray-200: #D1D1D1;
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1); --radius-md: 8px; --radius-lg: 12px;
            --transition-normal: 300ms ease-in-out;
        }

        @media print {
            .no-print, .header-section div:last-child, table th:last-child, table td:last-child, nav, .sidebar {
                display: none !important;
            }
            body { background: white !important; color: black !important; }
            .content-wrapper { padding: 0 !important; margin: 0 !important; }
            .header-section { box-shadow: none !important; border: 1px solid #ccc !important; border-left: 4px solid var(--color-red) !important; }
            table { border-collapse: collapse !important; border: 1px solid #000 !important; }
            th { background: #f2f2f2 !important; color: black !important; border: 1px solid #000 !important; }
            td { border: 1px solid #ccc !important; }
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">
        <!-- En-tête -->
        <div class="header-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <div>
                <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                    <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                    Lieux de Formation
                </h1>
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('lieu_formations.create') }}" 
                   style="background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; padding: 0.75rem 1.5rem; border-radius: var(--radius-md); text-decoration: none; font-weight: 600; border: 2px solid var(--color-red); cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.8rem;"
                   onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';"
                >
                    + Nouveau Lieu
                </a>
                <button onclick="window.print()"
                   style="background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-dark) 100%); color: var(--color-dark); padding: 0.75rem 1.5rem; border-radius: var(--radius-md); border: 2px solid var(--color-gold); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.8rem;"
                   onmouseover="this.style.transform='translateY(-2px)';" onmouseout="this.style.transform='translateY(0)';"
                >
                    ⬇️ Exporter en PDF
                </button>
            </div>
        </div>

        <!-- Table container -->
        <div style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: linear-gradient(90deg, var(--color-green) 0%, var(--color-green-light) 100%); color: white; font-weight: 600; text-transform: uppercase; font-size: 0.875rem; letter-spacing: 0.5px;">
                    <tr>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Nom du Lieu</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Localisation</th>
                        <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lieux as $lieu)
                    <tr style="border-bottom: 1px solid var(--color-gray-100); transition: all var(--transition-normal);"
                        onmouseover="this.style.backgroundColor='rgba(0, 122, 94, 0.04)'" onmouseout="this.style.backgroundColor='transparent'">
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem; font-weight: 600;">
                            🏢 {{ $lieu->nomLieu }}
                        </td>
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem;">
                            📍 {{ $lieu->localisation }}
                        </td>
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <a href="{{ route('lieu_formations.edit', $lieu->id) }}" 
                                   style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: var(--color-gray-100); color: var(--color-green); text-decoration: none; transition: 200ms;"
                                   onmouseover="this.style.backgroundColor='var(--color-green)'; this.style.color='white';" onmouseout="this.style.backgroundColor='var(--color-gray-100)'; this.style.color='var(--color-green)';"
                                >✎</a>
                                <form method="POST" action="{{ route('lieu_formations.destroy', $lieu->id) }}" onsubmit="return confirm('Supprimer ce lieu ?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" 
                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: var(--color-gray-100); color: #D32F2F; border: none; cursor: pointer; transition: 200ms;"
                                            onmouseover="this.style.backgroundColor='#D32F2F'; this.style.color='white';" onmouseout="this.style.backgroundColor='var(--color-gray-100)'; this.style.color='#D32F2F';"
                                    >✕</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="padding: 3rem; text-align: center; color: var(--color-gray-500);">Aucun lieu de formation enregistré.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts::app.sidebar>