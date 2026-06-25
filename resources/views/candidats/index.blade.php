<x-layouts::app.sidebar title="Liste des Candidats">
    <style>
        :root {
            --color-red: #CE1126;
            --color-green: #007A5E;
            --color-gold: #FCD116;
            --color-red-light: #E85040;
            --color-red-dark: #A00D20;
            --color-green-light: #00A572;
            --color-green-dark: #004D3A;
            --color-gold-light: #FFE657;
            --color-gold-dark: #E5B800;
            --color-dark: #1A1A1A;
            --color-light: #F8F8F8;
            --color-gray-100: #E8E8E8;
            --color-gray-200: #D1D1D1;
            --color-gray-500: #666666;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
            --transition-normal: 300ms ease-in-out;
            --radius-md: 8px;
            --radius-lg: 12px;
        }
        @media print {
            .no-print, .header-section div:last-child,
            table th:last-child, table td:last-child,
            nav, .sidebar { display: none !important; }
            body { background: white !important; color: black !important; }
            .content-wrapper { padding: 0 !important; margin: 0 !important; }
            .header-section { box-shadow: none !important; border: 1px solid #ccc !important; margin-bottom: 2rem !important; border-left: 4px solid var(--color-red) !important; }
            table { border-collapse: collapse !important; border: 1px solid #000 !important; }
            th { background: #f2f2f2 !important; color: black !important; border: 1px solid #000 !important; }
            td { border: 1px solid #ccc !important; }
        }

        /* ── Badge statut dossier ── */
        .badge-dossier {
            display: inline-flex; align-items: center; gap: 4px;
            font-size: 0.65rem; font-weight: 700;
            padding: 2px 8px; border-radius: 50px;
            margin-top: 4px;
        }
        .badge-valide   { background: rgba(0,122,94,0.12);  color: #004D3A; border: 1px solid rgba(0,122,94,0.3); }
        .badge-rejete   { background: rgba(206,17,38,0.1);  color: #A00D20; border: 1px solid rgba(206,17,38,0.3); }
        .badge-attente  { background: rgba(252,209,22,0.15); color: #7a5800; border: 1px solid rgba(252,209,22,0.4); }
        .badge-aucun    { background: rgba(102,102,102,0.1); color: #555;    border: 1px solid rgba(102,102,102,0.2); }
    </style>

    <div class="content-wrapper" style="padding: 2rem;">

        <!-- En-tête -->
        <div class="header-section" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; background: white; padding: 1.5rem 2rem; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); border-left: 4px solid var(--color-red);">
            <div>
                <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--color-dark); margin: 0; display: flex; align-items: center;">
                    <span style="width: 5px; height: 35px; background: linear-gradient(180deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%); margin-right: 1rem; border-radius: 2px;"></span>
                    Liste des Candidats
                </h1>
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('candidats.create') }}"
                   style="background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; padding: 0.75rem 1.5rem; border-radius: var(--radius-md); text-decoration: none; font-weight: 600; border: 2px solid var(--color-red); cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.8rem;">
                    + Nouveau Candidat
                </a>
                <button onclick="window.print()"
                   style="background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-dark) 100%); color: var(--color-dark); padding: 0.75rem 1.5rem; border-radius: var(--radius-md); border: 2px solid var(--color-gold); font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.8rem;">
                    ⬇️ Exporter en PDF
                </button>
            </div>
        </div>

        <!-- Alert Success -->
        @if(session('success'))
            <div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(0, 122, 94, 0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark); font-weight: 600;">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Barre de filtres -->
        <div class="no-print" style="display:flex; flex-wrap:wrap; gap:0.6rem; margin-bottom:1.5rem;">
            @php
                $filtres = [
                    ''             => ['Tous',          $counts['tous'] ?? 0,         '#666',                        'rgba(102,102,102,0.1)'],
                    'inscrit'      => ['Inscrit',       $counts['inscrit'] ?? 0,      '#444',                        'rgba(102,102,102,0.08)'],
                    'en_formation' => ['En Formation',  $counts['en_formation'] ?? 0, 'var(--color-green-dark)',      'rgba(0,122,94,0.1)'],
                    'code_admis'   => ['Code Admis',    $counts['code_admis'] ?? 0,   'var(--color-gold-dark)',       'rgba(252,209,22,0.15)'],
                    'admis'        => ['Admis',         $counts['admis'] ?? 0,        'var(--color-green-dark)',      'rgba(0,122,94,0.15)'],
                    'ajourne'      => ['Ajourné',       $counts['ajourne'] ?? 0,      'var(--color-red-dark)',        'rgba(206,17,38,0.1)'],
                ];
                $statutActuel = request('statut', '');
            @endphp
            @foreach($filtres as $valeur => $info)
                <a href="{{ route('candidats.index', $valeur ? ['statut' => $valeur] : []) }}"
                   style="padding:0.5rem 1rem; border-radius:50px; font-size:0.8rem; font-weight:700; text-decoration:none;
                          color:{{ $info[2] }}; background:{{ $info[3] }};
                          border:2px solid {{ $statutActuel === $valeur ? $info[2] : 'transparent' }};
                          display:inline-flex; align-items:center; gap:0.4rem; transition:all 0.2s;">
                    {{ $info[0] }}
                    <span style="background:{{ $info[2] }}; color:white; padding:0.1rem 0.5rem; border-radius:50px; font-size:0.7rem;">{{ $info[1] }}</span>
                </a>
            @endforeach
        </div>

        <!-- Table -->
        <div style="background: white; border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-md); border: 1px solid var(--color-gray-100);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: linear-gradient(90deg, var(--color-green) 0%, var(--color-green-light) 100%); color: white; font-weight: 600; text-transform: uppercase; font-size: 0.875rem; letter-spacing: 0.5px;">
                    <tr>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Candidat</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Téléphone</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Email</th>
                        <th style="padding: 1rem 1.5rem; text-align: left; border-bottom: 3px solid var(--color-gold);">Pièces Jointes</th>
                        <th style="padding: 1rem 1.5rem; text-align: center; border-bottom: 3px solid var(--color-gold);">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($candidats as $candidat)
                    @php
                        $dossier = $candidat->dossiers->first();
                        $piecesJointes = [
                            'cnib'               => 'CNIB',
                            'photo_identite'     => 'Photo',
                            'certificat_medical' => 'Médical',
                            'acte_naissance'     => 'Naissance',
                            'permis_c'           => 'Permis C',
                        ];
                        // Statut dossier
                        $statutDoss = $dossier->statutDossier ?? null;
                        $badgeClass = match($statutDoss) {
                            'valide'           => 'badge-valide',
                            'rejete', 'rejeté' => 'badge-rejete',
                            'en_attente'       => 'badge-attente',
                            default            => 'badge-aucun',
                        };
                        $badgeIcon = match($statutDoss) {
                            'valide'           => '✅',
                            'rejete', 'rejeté' => '❌',
                            'en_attente'       => '⏳',
                            default            => '📂',
                        };
                        $badgeTexte = match($statutDoss) {
                            'valide'           => 'Dossier validé',
                            'rejete', 'rejeté' => 'Dossier rejeté',
                            'en_attente'       => 'Dossier en attente',
                            default            => 'Aucun dossier',
                        };
                    @endphp
                    <tr style="border-bottom: 1px solid var(--color-gray-100); transition: all var(--transition-normal);"
                        onmouseover="this.style.backgroundColor='rgba(0, 122, 94, 0.04)'"
                        onmouseout="this.style.backgroundColor='transparent'">

                        {{-- ── Colonne Candidat : photo + nom + badge dossier ── --}}
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem;">
                            <div style="display:flex; align-items:center; gap:0.75rem;">
                                {{-- Photo --}}
                                @if($dossier && $dossier->photo_identite)
                                    <img src="{{ asset('storage/' . $dossier->photo_identite) }}"
                                         alt="Photo"
                                         style="width:42px; height:42px; border-radius:50%; object-fit:cover; border:2px solid var(--color-green); flex-shrink:0;">
                                @else
                                    <div style="width:42px; height:42px; border-radius:50%; background:var(--color-gray-100); border:2px solid var(--color-gray-200); display:flex; align-items:center; justify-content:center; flex-shrink:0; font-size:1.1rem;">
                                        👤
                                    </div>
                                @endif

                                {{-- Nom + badge statut dossier --}}
                                <div>
                                    <div style="font-weight:700; color:var(--color-dark);">
                                        {{ $candidat->nom }} {{ $candidat->prenom }}
                                    </div>
                                    {{-- ✅ BADGE STATUT DOSSIER --}}
                                    <span class="badge-dossier {{ $badgeClass }}">
                                        {{ $badgeIcon }} {{ $badgeTexte }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem;">{{ $candidat->telephone }}</td>
                        <td style="padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem;">{{ $candidat->email }}</td>

                        {{-- Pièces Jointes --}}
                        <td style="padding: 1rem 1.5rem;">
                            @if($dossier)
                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                @foreach($piecesJointes as $key => $label)
                                    @if($dossier->$key)
                                        <a href="{{ asset('storage/' . $dossier->$key) }}" target="_blank"
                                           style="font-size: 0.7rem; background: rgba(0, 122, 94, 0.1); color: var(--color-green-dark); padding: 4px 10px; border-radius: 50px; text-decoration: none; font-weight: 700; border: 1px solid var(--color-green-light); transition: 200ms;"
                                           onmouseover="this.style.background='var(--color-green)'; this.style.color='white';"
                                           onmouseout="this.style.background='rgba(0, 122, 94, 0.1)'; this.style.color='var(--color-green-dark)';">
                                            {{ $label }}
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                            @else
                                <span style="font-size:0.75rem; color:var(--color-gray-500); font-style:italic;">Aucun dossier</span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td style="padding: 1rem 1.5rem; text-align: center;">
                            <div style="display: flex; gap: 0.5rem; justify-content: center;">

                                {{-- Voir son espace --}}
                                <a href="{{ route('candidats.espace.admin', $candidat->id) }}" target="_blank"
                                   style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:var(--radius-md);background-color:rgba(206,17,38,0.08);color:var(--color-red-dark);border:none;cursor:pointer;text-decoration:none;font-size:1.1rem;"
                                   onmouseover="this.style.backgroundColor='var(--color-red)';this.style.color='white';this.style.transform='scale(1.1)'"
                                   onmouseout="this.style.backgroundColor='rgba(206,17,38,0.08)';this.style.color='var(--color-red-dark)';this.style.transform='scale(1)'"
                                   title="Voir son espace">👁️</a>

                                {{-- Fiche statut --}}
                                <a href="{{ route('candidats.show', $candidat->id) }}"
                                   style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:var(--radius-md);background-color:rgba(252,209,22,0.15);color:var(--color-gold-dark);border:none;cursor:pointer;text-decoration:none;font-size:1.1rem;"
                                   onmouseover="this.style.backgroundColor='var(--color-gold)';this.style.color='var(--color-dark)';this.style.transform='scale(1.1)'"
                                   onmouseout="this.style.backgroundColor='rgba(252,209,22,0.15)';this.style.color='var(--color-gold-dark)';this.style.transform='scale(1)'"
                                   title="Voir fiche">📋</a>

                                {{-- Éditer candidat --}}
                                <a href="{{ route('candidats.edit', $candidat->id) }}"
                                   style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:var(--radius-md);background-color:var(--color-gray-100);color:var(--color-green);border:none;cursor:pointer;text-decoration:none;font-size:1.2rem;"
                                   onmouseover="this.style.backgroundColor='var(--color-green)';this.style.color='white';this.style.transform='scale(1.1)'"
                                   onmouseout="this.style.backgroundColor='var(--color-gray-100)';this.style.color='var(--color-green)';this.style.transform='scale(1)'"
                                   title="Éditer">✎</a>

                                {{-- Supprimer --}}
                                <form action="{{ route('candidats.destroy', $candidat->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce candidat ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;border-radius:var(--radius-md);background-color:var(--color-gray-100);color:#D32F2F;border:none;cursor:pointer;font-size:1.2rem;padding:0;"
                                            onmouseover="this.style.backgroundColor='#D32F2F';this.style.color='white';this.style.transform='scale(1.1)'"
                                            onmouseout="this.style.backgroundColor='var(--color-gray-100)';this.style.color='#D32F2F';this.style.transform='scale(1)'"
                                            title="Supprimer">✕</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 3rem; text-align: center; color: var(--color-gray-500);">
                            <p style="margin: 0; font-size: 1rem;">📭 Aucun candidat trouvé</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($candidats->count() > 0)
        <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(0, 122, 94, 0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark);">
            <strong>Total :</strong> {{ $candidats->count() }} candidat(s)
        </div>
        @endif
    </div>
</x-layouts::app.sidebar>