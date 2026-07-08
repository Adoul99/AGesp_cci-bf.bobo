<x-layouts::app.sidebar title="Liste des Évaluations">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-red-light: #E85040; --color-red-dark: #A00D20;
            --color-green-light: #00A572; --color-green-dark: #004D3A;
            --color-gold-light: #FFE657; --color-gold-dark: #E5B800;
            --color-dark: #1A1A1A; --color-light: #F8F8F8;
            --color-gray-100: #E8E8E8; --color-gray-200: #D1D1D1; --color-gray-500: #666666;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05); --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
            --shadow-lg: 0 8px 24px rgba(0,0,0,0.15);
            --transition-normal: 300ms ease-in-out; --radius-md: 8px; --radius-lg: 12px;
        }
        @media print {
            .no-print, .header-section div:last-child,
            table th:last-child, table td:last-child { display: none !important; }
            body { background: white !important; }
            .content-wrapper { padding: 0 !important; }
            .header-section { box-shadow: none !important; border: 1px solid #eee !important; margin-bottom: 1rem !important; }
            table { border: 1px solid #000 !important; }
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">

        @if(session('success'))
            <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(0,122,94,0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark); font-weight: 600;">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="header-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Liste des Évaluations
            </h1>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('evaluations.create') }}"
                   style="background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; padding: 0.75rem 1.5rem; border-radius: var(--radius-md); text-decoration: none; font-weight: 600; border: 2px solid var(--color-red); transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.8rem;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(206,17,38,0.3)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    + Nouvelle Évaluation
                </a>
                <button onclick="window.print()"
                   style="background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-dark) 100%); color: var(--color-dark); padding: 0.75rem 1.5rem; border-radius: var(--radius-md); border: 2px solid var(--color-gold); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.8rem;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(252,209,22,0.3)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ⬇️ Exporter en PDF
                </button>
            </div>
        </div>

        <div style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: linear-gradient(90deg, var(--color-green) 0%, var(--color-green-light) 100%); color: white; font-weight: 600; text-transform: uppercase; font-size: 0.78rem; letter-spacing: 0.5px;">
                    <tr>
                        <th style="padding: 1rem 1rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Candidat</th>
                        <th style="padding: 1rem 1rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Type Session</th>
                        <th style="padding: 1rem 1rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Date</th>
                        <th style="padding: 1rem 1rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Note / Mention</th>
                        <th style="padding: 1rem 1rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Résultat</th>
                        <th style="padding: 1rem 1rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Statut</th>
                        <th style="padding: 1rem 1rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Moniteur</th>
                        <th style="padding: 1rem 1rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($evaluations as $evaluation)
                    <tr style="border-bottom: 1px solid var(--color-gray-100); transition: all var(--transition-normal);"
                        onmouseover="this.style.backgroundColor='rgba(0,122,94,0.04)'"
                        onmouseout="this.style.backgroundColor='transparent'">

                        {{-- Candidat --}}
                        <td style="padding: 0.875rem 1rem; color: var(--color-dark); font-size: 0.875rem; font-weight: 600;">
                            {{ $evaluation->candidat->nom ?? 'N/A' }} {{ $evaluation->candidat->prenom ?? '' }}
                        </td>

                        {{-- Type Session --}}
                        <td style="padding: 0.875rem 1rem; text-align: center;">
                            @if($evaluation->typeSession)
                                @switch($evaluation->typeSession->type)
                                    @case('code')
                                        <span style="background: rgba(0,122,94,0.15); color: var(--color-green); padding: 0.3rem 0.7rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; border: 1px solid var(--color-green-light);">📋 Code</span>
                                        @break
                                    @case('creneau')
                                        <span style="background: rgba(252,209,22,0.2); color: var(--color-gold-dark); padding: 0.3rem 0.7rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; border: 1px solid var(--color-gold);">🔧 Créneau</span>
                                        @break
                                    @case('conduite')
                                        <span style="background: rgba(206,17,38,0.1); color: var(--color-red-dark); padding: 0.3rem 0.7rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; border: 1px solid var(--color-red-light);">🚗 Conduite</span>
                                        @break
                                    @default
                                        <span style="color: var(--color-gray-500);">{{ $evaluation->typeSession->type }}</span>
                                @endswitch
                            @else
                                <span style="color: var(--color-gray-500); font-size: 0.85rem;">—</span>
                            @endif
                        </td>

                        {{-- Date --}}
                        <td style="padding: 0.875rem 1rem; text-align: center;">
                            <span style="background: rgba(0,122,94,0.15); color: var(--color-green); padding: 0.25rem 0.65rem; border-radius: var(--radius-md); font-size: 0.78rem; font-weight: 500;">
                                {{ \Carbon\Carbon::parse($evaluation->dateEvaluation)->format('d/m/Y') }}
                            </span>
                        </td>

                        {{-- Note / Mention --}}
                        <td style="padding: 0.875rem 1rem; text-align: center;">
                            @if(!is_null($evaluation->note))
                                {{-- Session Code : note chiffrée --}}
                                @php $noteColor = $evaluation->note >= 25 ? 'var(--color-green)' : 'var(--color-red)'; @endphp
                                <span style="font-size: 1.2rem; font-weight: 800; color: {{ $noteColor }};">{{ $evaluation->note }}</span>
                                <span style="font-size: 0.75rem; color: var(--color-gray-500);">/30</span>
                            @elseif(!empty($evaluation->mention))
                                {{-- Session Créneau/Conduite : mention --}}
                                @switch($evaluation->mention)
                                    @case('bien')
                                        <span style="background: rgba(0,122,94,0.15); color: var(--color-green); padding: 0.3rem 0.7rem; border-radius: 50px; font-size: 0.78rem; font-weight: 700; border: 1px solid var(--color-green-light);">🟢 Bien</span>
                                        @break
                                    @case('passable')
                                        <span style="background: rgba(252,209,22,0.2); color: var(--color-gold-dark); padding: 0.3rem 0.7rem; border-radius: 50px; font-size: 0.78rem; font-weight: 700; border: 1px solid var(--color-gold);">🟡 Passable</span>
                                        @break
                                    @case('mediocre')
                                        <span style="background: rgba(206,17,38,0.1); color: var(--color-red-dark); padding: 0.3rem 0.7rem; border-radius: 50px; font-size: 0.78rem; font-weight: 700; border: 1px solid var(--color-red-light);">🔴 Médiocre</span>
                                        @break
                                @endswitch
                            @else
                                <span style="color: var(--color-gray-500); font-size: 0.85rem;">—</span>
                            @endif
                        </td>

                        {{-- Résultat --}}
                        <td style="padding: 0.875rem 1rem; text-align: center;">
                            @if(str_starts_with($evaluation->resultat ?? '', 'Validé'))
                                <span style="background: rgba(0,122,94,0.15); color: var(--color-green); padding: 0.3rem 0.7rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; border: 1px solid var(--color-green-light);">🟢 {{ $evaluation->resultat }}</span>
                            @elseif(str_starts_with($evaluation->resultat ?? '', 'Échoué'))
                                <span style="background: rgba(206,17,38,0.1); color: var(--color-red-dark); padding: 0.3rem 0.7rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; border: 1px solid var(--color-red-light);">🔴 {{ $evaluation->resultat }}</span>
                            @elseif($evaluation->resultat == 'Admis')
                                <span style="background: rgba(0,122,94,0.15); color: var(--color-green); padding: 0.3rem 0.7rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; border: 1px solid var(--color-green-light);">🟢 Admis</span>
                            @elseif($evaluation->resultat == 'Ajourné')
                                <span style="background: rgba(206,17,38,0.1); color: var(--color-red-dark); padding: 0.3rem 0.7rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; border: 1px solid var(--color-red-light);">🔴 Ajourné</span>
                            @elseif($evaluation->resultat == 'En attente')
                                <span style="background: rgba(252,209,22,0.2); color: var(--color-gold-dark); padding: 0.3rem 0.7rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700; border: 1px solid var(--color-gold);">⏳ En attente</span>
                            @elseif($evaluation->resultat == 'Absent')
                                <span style="background: var(--color-gray-100); color: var(--color-gray-500); padding: 0.3rem 0.7rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700;">⚪ Absent</span>
                            @else
                                <span style="background: var(--color-gray-100); color: var(--color-gray-500); padding: 0.3rem 0.7rem; border-radius: 50px; font-size: 0.75rem; font-weight: 700;">⚪ {{ $evaluation->resultat }}</span>
                            @endif
                        </td>

                        {{-- Statut --}}
                        <td style="padding: 0.875rem 1rem; text-align: center;">
                            @if($evaluation->statut == 'en_attente')
                                <span style="background: rgba(252,209,22,0.2); color: var(--color-gold-dark); padding: 0.25rem 0.65rem; border-radius: var(--radius-md); font-size: 0.78rem; font-weight: 600; text-transform: uppercase;">En attente</span>
                            @elseif($evaluation->statut == 'reussi')
                                <span style="background: rgba(0,122,94,0.1); color: var(--color-green); padding: 0.25rem 0.65rem; border-radius: var(--radius-md); font-size: 0.78rem; font-weight: 600; text-transform: uppercase;">Réussi</span>
                            @elseif($evaluation->statut == 'echoue')
                                <span style="background: rgba(206,17,38,0.1); color: var(--color-red-dark); padding: 0.25rem 0.65rem; border-radius: var(--radius-md); font-size: 0.78rem; font-weight: 600; text-transform: uppercase;">Échoué</span>
                            @else
                                <span style="background: var(--color-gray-100); color: var(--color-gray-500); padding: 0.25rem 0.65rem; border-radius: var(--radius-md); font-size: 0.78rem; font-weight: 600; text-transform: uppercase;">{{ $evaluation->statut ?? '—' }}</span>
                            @endif
                        </td>

                        {{-- Moniteur --}}
                        <td style="padding: 0.875rem 1rem; text-align: center; font-size: 0.875rem; color: var(--color-dark);">
                            {{ $evaluation->moniteur->nom ?? '—' }} {{ $evaluation->moniteur->prenom ?? '' }}
                        </td>

                        {{-- Actions --}}
                        <td style="padding: 0.875rem 1rem; text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <a href="{{ route('evaluations.edit', $evaluation->id) }}"
                                   style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: var(--color-gray-100); color: var(--color-green); text-decoration: none; transition: all var(--transition-normal); font-size: 1.1rem;"
                                   onmouseover="this.style.backgroundColor='var(--color-green)'; this.style.color='white';"
                                   onmouseout="this.style.backgroundColor='var(--color-gray-100)'; this.style.color='var(--color-green)';"
                                   title="Modifier">✎</a>
                                <form method="POST" action="{{ route('evaluations.destroy', $evaluation->id) }}" style="display: inline;" onsubmit="return confirm('Supprimer cette évaluation ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: var(--color-gray-100); color: #D32F2F; border: none; cursor: pointer; transition: all var(--transition-normal); font-size: 1.1rem;"
                                            onmouseover="this.style.backgroundColor='#D32F2F'; this.style.color='white';"
                                            onmouseout="this.style.backgroundColor='var(--color-gray-100)'; this.style.color='#D32F2F';"
                                            title="Supprimer">✕</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="padding: 3rem; text-align: center; color: var(--color-gray-500);">
                            📭 Aucune évaluation trouvée
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Résumé statistique --}}
        @if($evaluations->count() > 0)
        @php
            $total       = $evaluations->count();
            $reussis     = $evaluations->filter(fn($e) => str_starts_with($e->resultat ?? '', 'Validé') || $e->resultat === 'Admis')->count();
            $echoues     = $evaluations->filter(fn($e) => str_starts_with($e->resultat ?? '', 'Échoué') || $e->resultat === 'Ajourné')->count();
            $attente     = $evaluations->filter(fn($e) => is_null($e->note) && empty($e->mention))->count();
            $moyenneNote = $evaluations->whereNotNull('note')->avg('note');
        @endphp
        <div style="margin-top: 1.5rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
            <div style="padding: 1rem; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-left: 4px solid var(--color-dark); text-align: center;">
                <div style="font-size: 1.5rem; font-weight: 800; color: var(--color-dark);">{{ $total }}</div>
                <div style="font-size: 0.75rem; color: var(--color-gray-500); text-transform: uppercase;">Total</div>
            </div>
            <div style="padding: 1rem; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-left: 4px solid var(--color-green); text-align: center;">
                <div style="font-size: 1.5rem; font-weight: 800; color: var(--color-green);">{{ $reussis }}</div>
                <div style="font-size: 0.75rem; color: var(--color-gray-500); text-transform: uppercase;">🟢 Validées</div>
            </div>
            <div style="padding: 1rem; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-left: 4px solid var(--color-red); text-align: center;">
                <div style="font-size: 1.5rem; font-weight: 800; color: var(--color-red);">{{ $echoues }}</div>
                <div style="font-size: 0.75rem; color: var(--color-gray-500); text-transform: uppercase;">🔴 Échouées</div>
            </div>
            <div style="padding: 1rem; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-left: 4px solid var(--color-gold); text-align: center;">
                <div style="font-size: 1.5rem; font-weight: 800; color: var(--color-gold-dark);">{{ $attente }}</div>
                <div style="font-size: 0.75rem; color: var(--color-gray-500); text-transform: uppercase;">⏳ En attente</div>
            </div>
            <div style="padding: 1rem; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-left: 4px solid var(--color-green); text-align: center;">
                <div style="font-size: 1.5rem; font-weight: 800; color: {{ ($moyenneNote ?? 0) >= 25 ? 'var(--color-green)' : 'var(--color-red)' }};">
                    {{ $moyenneNote ? number_format($moyenneNote, 1) : '—' }}
                </div>
                <div style="font-size: 0.75rem; color: var(--color-gray-500); text-transform: uppercase;">Moyenne /30 (Code)</div>
            </div>
        </div>
        @endif

    </div>
</x-layouts::app.sidebar>