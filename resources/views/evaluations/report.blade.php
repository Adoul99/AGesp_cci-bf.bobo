<x-layouts::app.sidebar title="Rapport des Notes d'Évaluation">
    <style>
        :root {
            --color-red: #CE1126;
            --color-green: #007A5E;
            --color-gold: #FCD116;
            --color-gray-100: #E8E8E8;
            --color-gray-500: #666666;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
            --radius-md: 8px;
            --radius-lg: 12px;
        }

        @media print {
            .no-print,
            .header-row,
            table th:last-child,
            table td:last-child {
                display: none !important;
            }
            body {
                background: white !important;
            }
            .report-wrapper {
                padding: 0 !important;
            }
            .report-section {
                box-shadow: none !important;
                border: none !important;
            }
            table {
                border: 1px solid #000 !important;
            }
        }

        .report-wrapper {
            padding: 2rem;
        }

        .report-card {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            border: 1px solid var(--color-gray-100);
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem 2rem;
            background: linear-gradient(90deg, var(--color-green) 0%, #2a9d75 100%);
            color: white;
        }

        .report-header h1 {
            margin: 0;
            font-size: 1.75rem;
        }

        .btn-report {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.85rem 1.25rem;
            border-radius: var(--radius-md);
            font-weight: 700;
            text-decoration: none;
            border: 2px solid transparent;
            transition: all 250ms ease;
        }

        .btn-report-print {
            background: #FCD116;
            color: var(--color-red);
            border-color: rgba(0,0,0,0.08);
        }

        .btn-report-back {
            background: white;
            color: var(--color-green);
            border-color: white;
        }

        .btn-report-print:hover,
        .btn-report-back:hover {
            transform: translateY(-2px);
        }

        .report-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .report-summary-card {
            background: #fff;
            padding: 1rem 1.25rem;
            border-radius: var(--radius-md);
            border-left: 4px solid var(--color-green);
            box-shadow: var(--shadow-sm);
            text-align: center;
        }

        .report-summary-card strong {
            display: block;
            font-size: 1.75rem;
            margin-bottom: 0.25rem;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        .report-table th,
        .report-table td {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--color-gray-100);
            text-align: left;
            font-size: 0.9rem;
        }

        .report-table thead {
            background: #f4f6f4;
        }

        .report-table th {
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.08em;
            color: var(--color-gray-500);
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.4rem 0.75rem;
            border-radius: 999px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-success {
            background: rgba(0,122,94,0.12);
            color: var(--color-green);
        }

        .badge-danger {
            background: rgba(206,17,38,0.12);
            color: var(--color-red);
        }

        .badge-warning {
            background: rgba(252,209,22,0.2);
            color: #8d6a00;
        }
    </style>

    <div class="report-wrapper">
        <div class="report-card report-header">
            <div>
                <h1>Relevé de notes</h1>
                <div style="opacity: .85; margin-top: 0.4rem;">Évaluations par type de session pour chaque candidat</div>
            </div>
            <div style="display:flex; gap:0.75rem; flex-wrap: wrap;">
                <a href="{{ route('evaluations.index') }}" class="btn-report btn-report-back no-print">
                    ← Retour à la liste
                </a>
                <button onclick="window.print()" class="btn-report btn-report-print no-print">
                    ⬇️ Imprimer en PDF
                </button>
            </div>
        </div>

        @if(session('success'))
            <div style="margin-bottom: 1.25rem; padding: 1rem; border-radius: var(--radius-md); background: rgba(0,122,94,0.1); color: var(--color-green); border: 1px solid rgba(0,122,94,0.2);">
                ✅ {{ session('success') }}
            </div>
        @endif

        @php
            $totalNotes = $evaluations->count();
            $notesValides = $evaluations->where('resultat', 'Admis')->count();
            $notesAjournees = $evaluations->where('resultat', 'Ajourné')->count();
            $notesVide = $evaluations->whereNull('note')->count();
            $moyenneNotes = $evaluations->whereNotNull('note')->avg('note');
        @endphp

        <div class="report-summary">
            <div class="report-summary-card">
                <strong>{{ $totalNotes }}</strong>
                Total des évaluations
            </div>
            <div class="report-summary-card">
                <strong>{{ $notesValides }}</strong>
                Admis
            </div>
            <div class="report-summary-card">
                <strong>{{ $notesAjournees }}</strong>
                Ajournés
            </div>
            <div class="report-summary-card">
                <strong>{{ $notesVide }}</strong>
                Notes manquantes
            </div>
            <div class="report-summary-card">
                <strong>{{ $moyenneNotes !== null ? number_format($moyenneNotes, 2, ',', ' ') : 'N/A' }}</strong>
                Moyenne /30
            </div>
        </div>

        <div class="report-card report-section">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Candidat</th>
                        <th>Type de session</th>
                        <th>Date</th>
                        <th>Note /30</th>
                        <th>Résultat</th>
                        <th>Moniteur</th>
                        <th>Observation</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($evaluations as $evaluation)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $evaluation->candidat->nom ?? 'N/A' }} {{ $evaluation->candidat->prenom ?? '' }}</td>
                            <td>{{ $evaluation->typeSession?->code ?: $evaluation->typeSession?->creneau ?: $evaluation->typeSession?->conduite ?: $evaluation->sessionFormation?->typeSession?->code ?: $evaluation->sessionFormation?->typeSession?->creneau ?: $evaluation->sessionFormation?->typeSession?->conduite ?? 'Non défini' }}</td>
                            <td>{{ \Carbon\Carbon::parse($evaluation->dateEvaluation)->format('d/m/Y') }}</td>
                            <td>{{ $evaluation->note !== null ? number_format($evaluation->note, 1, ',', ' ') : '—' }}</td>
                            <td>
                                @if($evaluation->resultat === 'Admis')
                                    <span class="badge-status badge-success">Admis</span>
                                @elseif($evaluation->resultat === 'Ajourné')
                                    <span class="badge-status badge-danger">Ajourné</span>
                                @elseif($evaluation->resultat === 'En attente')
                                    <span class="badge-status badge-warning">En attente</span>
                                @else
                                    <span class="badge-status badge-warning">{{ ucfirst($evaluation->resultat) }}</span>
                                @endif
                            </td>
                            <td>{{ $evaluation->moniteur->nom ?? '—' }} {{ $evaluation->moniteur->prenom ?? '' }}</td>
                            <td>{{ $evaluation->observation ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding:1.5rem; text-align:center; color: var(--color-gray-500);">
                                Aucune évaluation disponible.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts::app.sidebar>
