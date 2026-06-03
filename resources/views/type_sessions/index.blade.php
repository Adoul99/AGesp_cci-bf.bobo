<x-layouts::app.sidebar title="Types de Session">
    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-red-light: #E85040; --color-red-dark: #A00D20;
            --color-green-light: #00A572; --color-green-dark: #004D3A;
            --color-gold-light: #FFE657; --color-gold-dark: #E5B800;
            --color-dark: #1A1A1A; --color-light: #F8F8F8;
            --color-gray-100: #E8E8E8; --color-gray-200: #D1D1D1; --color-gray-500: #666666;
            --shadow-sm: 0 1px 2px rgba(0,0,0,0.05); --shadow-md: 0 4px 12px rgba(0,0,0,0.1);
            --transition-normal: 300ms ease-in-out; --radius-md: 8px; --radius-lg: 12px;
        }
        @media print {
            .no-print, table th:last-child, table td:last-child { display: none !important; }
            body { background: white !important; }
            table { border: 1px solid #000 !important; }
        }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">

        {{-- Message succès --}}
        @if(session('success'))
            <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(0,122,94,0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark); font-weight: 600;">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- En-tête --}}
        <div class="header-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                Types de Session
            </h1>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('type_sessions.create') }}"
                   style="background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; padding: 0.75rem 1.5rem; border-radius: var(--radius-md); text-decoration: none; font-weight: 600; border: 2px solid var(--color-red); transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.8rem;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(206,17,38,0.3)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    + Nouveau Type
                </a>
                <button onclick="window.print()"
                   style="background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-dark) 100%); color: var(--color-dark); padding: 0.75rem 1.5rem; border-radius: var(--radius-md); border: 2px solid var(--color-gold); font-weight: 600; cursor: pointer; transition: all var(--transition-normal); display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; box-shadow: var(--shadow-sm); font-size: 0.8rem;"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(252,209,22,0.3)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='var(--shadow-sm)'">
                    ⬇️ Exporter en PDF
                </button>
            </div>
        </div>

        {{-- Tableau --}}
        <div style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: linear-gradient(90deg, var(--color-green) 0%, var(--color-green-light) 100%); color: white; font-weight: 600; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;">
                    <tr>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">#</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Type de Session</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Description</th>
                        <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($typeSessions as $index => $typeSession)
                    <tr style="border-bottom: 1px solid var(--color-gray-100); transition: all var(--transition-normal);"
                        onmouseover="this.style.backgroundColor='rgba(0,122,94,0.04)'"
                        onmouseout="this.style.backgroundColor='transparent'">

                        {{-- Numéro --}}
                        <td style="padding: 1rem 1.5rem; color: var(--color-gray-500); font-size: 0.875rem; font-weight: 600;">
                            {{ $index + 1 }}
                        </td>

                        {{-- Type --}}
                        <td style="padding: 1rem 1.5rem;">
                            @if($typeSession->type == 'code')
                                <span style="background: rgba(0,122,94,0.15); color: var(--color-green); padding: 0.4rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; border: 1px solid var(--color-green-light); display: inline-flex; align-items: center; gap: 0.4rem;">
                                    📋 Code
                                </span>
                            @elseif($typeSession->type == 'creneau')
                                <span style="background: rgba(252,209,22,0.2); color: var(--color-gold-dark); padding: 0.4rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; border: 1px solid var(--color-gold); display: inline-flex; align-items: center; gap: 0.4rem;">
                                    🔧 Créneau
                                </span>
                            @elseif($typeSession->type == 'conduite')
                                <span style="background: rgba(206,17,38,0.1); color: var(--color-red-dark); padding: 0.4rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; border: 1px solid var(--color-red-light); display: inline-flex; align-items: center; gap: 0.4rem;">
                                    🚗 Conduite
                                </span>
                            @endif
                        </td>

                        {{-- Description --}}
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem;">
                            {{ $typeSession->description ?? '—' }}
                        </td>

                        {{-- Actions --}}
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                <a href="{{ route('type_sessions.edit', $typeSession->id) }}"
                                   style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: var(--color-gray-100); color: var(--color-green); text-decoration: none; transition: all var(--transition-normal); font-size: 1.1rem;"
                                   onmouseover="this.style.backgroundColor='var(--color-green)'; this.style.color='white';"
                                   onmouseout="this.style.backgroundColor='var(--color-gray-100)'; this.style.color='var(--color-green)';"
                                   title="Modifier">✎</a>

                                <form method="POST" action="{{ route('type_sessions.destroy', $typeSession->id) }}" style="display: inline;" onsubmit="return confirm('Supprimer ce type de session ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="width: 38px; height: 38px; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-md); background-color: var(--color-gray-100); color: #D32F2F; border: none; cursor: pointer; transition: all var(--transition-normal); font-size: 1.1rem;"
                                            onmouseover="this.style.backgroundColor='#D32F2F'; this.style.color='white';"
                                            onmouseout="this.style.backgroundColor='var(--color-gray-100)'; this.style.color='#D32F2F';"
                                            title="Supprimer">✕</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="padding: 3rem; text-align: center; color: var(--color-gray-500);">
                            📭 Aucun type de session trouvé
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Résumé --}}
        @if($typeSessions->count() > 0)
        <div style="margin-top: 1.5rem; display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
            <div style="padding: 1rem; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-left: 4px solid var(--color-green); text-align: center;">
                <div style="font-size: 1.4rem; font-weight: 800; color: var(--color-green);">{{ $typeSessions->where('type','code')->count() }}</div>
                <div style="font-size: 0.75rem; color: var(--color-gray-500); text-transform: uppercase;">📋 Code</div>
            </div>
            <div style="padding: 1rem; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-left: 4px solid var(--color-gold); text-align: center;">
                <div style="font-size: 1.4rem; font-weight: 800; color: var(--color-gold-dark);">{{ $typeSessions->where('type','creneau')->count() }}</div>
                <div style="font-size: 0.75rem; color: var(--color-gray-500); text-transform: uppercase;">🔧 Créneau</div>
            </div>
            <div style="padding: 1rem; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-left: 4px solid var(--color-red); text-align: center;">
                <div style="font-size: 1.4rem; font-weight: 800; color: var(--color-red);">{{ $typeSessions->where('type','conduite')->count() }}</div>
                <div style="font-size: 0.75rem; color: var(--color-gray-500); text-transform: uppercase;">🚗 Conduite</div>
            </div>
            <div style="padding: 1rem; background: white; border-radius: var(--radius-md); box-shadow: var(--shadow-sm); border-left: 4px solid var(--color-dark); text-align: center;">
                <div style="font-size: 1.4rem; font-weight: 800; color: var(--color-dark);">{{ $typeSessions->count() }}</div>
                <div style="font-size: 0.75rem; color: var(--color-gray-500); text-transform: uppercase;">Total</div>
            </div>
        </div>
        @endif

    </div>
</x-layouts::app.sidebar>