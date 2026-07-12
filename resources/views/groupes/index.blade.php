<x-layouts::app title="Liste des Groupes">
    <style>
        :root {
            --color-red: #CE1126;
            --color-red-dark: #A00D20;
            --color-green: #007A5E;
            --color-green-light: #00A572;
            --color-green-dark: #004D3A;
            --color-gold: #FCD116;
            --color-gold-dark: #E5B800;

            --bg-page-start: #0B0E14;
            --bg-page-end: #171B26;
            --bg-card: #12161F;
            --border-subtle: rgba(255,255,255,0.08);
            --text-main: #F2F3F5;
            --text-dim: #9AA1AC;

            --radius-md: 10px;
            --radius-lg: 16px;
            --shadow-card: 0 10px 30px rgba(0,0,0,0.35);
            --transition-normal: 220ms ease;
        }

        .gp-page {
            min-height: 100vh;
            padding: 2.5rem;
            background: radial-gradient(circle at 15% 0%, rgba(0,122,94,0.15), transparent 45%),
                        radial-gradient(circle at 85% 10%, rgba(206,17,38,0.12), transparent 40%),
                        linear-gradient(180deg, var(--bg-page-start) 0%, var(--bg-page-end) 100%);
            font-family: 'Segoe UI', system-ui, sans-serif;
            color: var(--text-main);
        }

        .gp-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .gp-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--color-gold);
            margin-bottom: 0.75rem;
        }
        .gp-eyebrow::before {
            content: '';
            width: 8px; height: 8px;
            background: var(--color-gold);
            border-radius: 2px;
        }
        .gp-title {
            font-size: 2.25rem;
            font-weight: 800;
            margin: 0;
            background: linear-gradient(90deg, #FFFFFF 0%, #C9CDD4 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .gp-header-actions { display: flex; gap: 0.75rem; }
        .gp-btn {
            padding: 0.75rem 1.5rem;
            border-radius: var(--radius-md);
            font-weight: 700;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: transform var(--transition-normal), box-shadow var(--transition-normal);
        }
        .gp-btn-primary {
            background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%);
            color: white;
            box-shadow: 0 6px 16px rgba(206,17,38,0.25);
        }
        .gp-btn-primary:hover { transform: translateY(-2px); box-shadow: 0 10px 22px rgba(206,17,38,0.4); }
        .gp-btn-gold {
            background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-dark) 100%);
            color: #1A1A1A;
            box-shadow: 0 6px 16px rgba(252,209,22,0.2);
        }
        .gp-btn-gold:hover { transform: translateY(-2px); box-shadow: 0 10px 22px rgba(252,209,22,0.35); }

        .gp-table-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            overflow: hidden;
        }
        table { width: 100%; border-collapse: collapse; }
        thead {
            background: linear-gradient(90deg, rgba(0,122,94,0.35) 0%, rgba(0,77,58,0.35) 100%);
            color: #E7FBF4;
        }
        th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            border-bottom: 2px solid rgba(252,209,22,0.5);
        }
        td {
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-subtle);
        }
        tbody tr { transition: background var(--transition-normal); }
        tbody tr:hover { background: rgba(0,122,94,0.08); }
        tbody tr:last-child td { border-bottom: none; }

        .gp-nom-groupe { font-weight: 700; }
        .gp-date-pill {
            background: rgba(0,122,94,0.18);
            color: var(--color-green-light);
            padding: 0.25rem 0.75rem;
            border-radius: var(--radius-md);
            font-size: 0.8rem;
            font-weight: 600;
        }
        .gp-candidat-pills { display: flex; gap: 6px; flex-wrap: wrap; }
        .gp-candidat-pill {
            background: rgba(255,255,255,0.05);
            color: #C9CDD4;
            padding: 0.25rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid var(--border-subtle);
        }
        .gp-empty-text { color: var(--text-dim); font-style: italic; font-size: 0.8rem; }

        .gp-row-actions { display: flex; gap: 0.5rem; justify-content: center; }
        .gp-icon-btn {
            width: 38px; height: 38px;
            display: flex; align-items: center; justify-content: center;
            border-radius: var(--radius-md);
            background: rgba(255,255,255,0.05);
            border: 1px solid var(--border-subtle);
            cursor: pointer;
            font-weight: bold;
            font-size: 1.1rem;
            text-decoration: none;
            padding: 0;
            transition: all var(--transition-normal);
        }
        .gp-icon-btn.edit { color: var(--color-green-light); }
        .gp-icon-btn.edit:hover { background: var(--color-green); color: white; transform: scale(1.08); }
        .gp-icon-btn.delete { color: #FF6B6B; }
        .gp-icon-btn.delete:hover { background: #D32F2F; color: white; transform: scale(1.08); }

        .gp-summary {
            margin-top: 1.5rem;
            padding: 1rem 1.25rem;
            background: rgba(0,122,94,0.12);
            border-left: 3px solid var(--color-green-light);
            border-radius: var(--radius-md);
            color: #B9EBDD;
            font-size: 0.875rem;
        }

        .gp-empty-state {
            padding: 3.5rem 1rem;
            text-align: center;
            color: var(--text-dim);
        }

        @media print {
            .no-print, .gp-header-actions, table th:last-child, table td:last-child { display: none !important; }
            .gp-page { background: white; color: black; padding: 0; }
            .gp-table-card { box-shadow: none; border: 1px solid #ccc; }
        }
    </style>

    <div class="gp-page">
        <div class="gp-header">
            <div>
                <div class="gp-eyebrow">CCI-BF — Bobo-Dioulasso</div>
                <h1 class="gp-title">Liste des Groupes</h1>
            </div>

            <div class="gp-header-actions no-print">
                <a href="{{ route('groupes.create') }}" class="gp-btn gp-btn-primary">+ Nouveau Groupe</a>
                <button onclick="window.print()" class="gp-btn gp-btn-gold">⬇️ Exporter en PDF</button>
            </div>
        </div>

        <div class="gp-table-card">
            <table>
                <thead>
                    <tr>
                        <th>Nom Groupe</th>
                        <th>Date Début Formation</th>
                        <th>Candidats</th>
                        <th style="text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groupes as $groupe)
                    <tr>
                        <td class="gp-nom-groupe">👥 {{ $groupe->nomGroupe }}</td>
                        <td><span class="gp-date-pill">{{ \Carbon\Carbon::parse($groupe->dateDebutFormation)->format('d/m/Y') }}</span></td>
                        <td>
                            <div class="gp-candidat-pills">
                                @forelse($groupe->candidats as $candidat)
                                    <span class="gp-candidat-pill">👨‍🎓 {{ $candidat->nom }} {{ $candidat->prenom }}</span>
                                @empty
                                    <span class="gp-empty-text">Aucun candidat</span>
                                @endforelse
                            </div>
                        </td>
                        <td>
                            <div class="gp-row-actions">
                                <a href="{{ route('groupes.edit', $groupe->id) }}" class="gp-icon-btn edit" title="Éditer">✎</a>
                                <form method="POST" action="{{ route('groupes.destroy', $groupe->id) }}" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce groupe ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="gp-icon-btn delete" title="Supprimer">✕</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="gp-empty-state">📭 Aucun groupe trouvé</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($groupes->count() > 0)
        <div class="gp-summary"><strong>Total :</strong> {{ $groupes->count() }} groupe(s) actif(s)</div>
        @endif
    </div>
</x-layouts::app>