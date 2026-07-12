<x-layouts::app title="Liste des Candidats">
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
            --radius-lg: 14px;
        }
        @media print {
            .no-print, .brand-banner .add-actions,
            table th:last-child, table td:last-child,
            .wave-footer,
            nav, .sidebar { display: none !important; }
            body { background: white !important; color: black !important; }
            .content-wrapper { padding: 0 !important; margin: 0 !important; }
            .brand-banner { box-shadow: none !important; border: 1px solid #ccc !important; margin-bottom: 2rem !important; }
            table { border-collapse: collapse !important; border: 1px solid #000 !important; }
            th { background: #f2f2f2 !important; color: black !important; border: 1px solid #000 !important; }
            td { border: 1px solid #ccc !important; }
        }

        .page-bg {
            background: linear-gradient(180deg, #F4F6F5 0%, #EEF1F0 100%);
            border-radius: 18px;
            padding: 1.75rem;
            margin: -1.25rem -1.25rem 0;
        }

        /* ── Bannière logo façon document officiel ── */
        .brand-banner {
            background: #fff;
            border-radius: var(--radius-lg);
            padding: 1.4rem 2rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow-md);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .brand-left { display: flex; align-items: center; gap: 1rem; }
        .brand-logo {
            width: 56px; height: 56px; border-radius: 50%; flex-shrink: 0;
            object-fit: cover; border: 2px solid var(--color-gray-100);
        }
        .brand-title {
            font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 1.55rem; color: var(--color-green-dark);
            letter-spacing: 0.01em; text-transform: uppercase; margin: 0;
        }
        .brand-name { font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em; color: #4B5157; text-transform: uppercase; line-height: 1.3; }
        .brand-name small { display: block; font-weight: 600; color: #8A9199; font-size: 0.68rem; text-transform: none; margin-top: 2px; }
        .brand-title-bar {
            height: 4px; width: 100%; margin-top: 6px; border-radius: 2px;
            background: linear-gradient(90deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%);
        }
        .add-actions { display: flex; gap: 1rem; flex-wrap: wrap; }
        .btn-add {
            background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white;
            padding: 0.7rem 1.4rem; border-radius: var(--radius-md); text-decoration: none; font-weight: 600;
            border: 2px solid var(--color-red); cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;
            text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.78rem;
        }
        .btn-export {
            background: linear-gradient(135deg, var(--color-gold) 0%, var(--color-gold-dark) 100%); color: var(--color-dark);
            padding: 0.7rem 1.4rem; border-radius: var(--radius-md); border: 2px solid var(--color-gold); font-weight: 600;
            cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;
            text-transform: uppercase; letter-spacing: 0.5px; font-size: 0.78rem;
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

        /* ── Carte tableau : fond et bordures harmonisés avec la palette verte ── */
        .table-card {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: 0 10px 28px rgba(0,77,58,0.12);
            border: 1px solid rgba(0,122,94,0.16);
            position: relative;
        }

        /* En-tête en dégradé (au lieu d'un vert uni) pour plus de profondeur */
        .candidats-table thead {
            background: linear-gradient(90deg, var(--color-green-dark) 0%, var(--color-green) 55%, var(--color-green-light) 100%);
            color: white;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.82rem;
            letter-spacing: 0.6px;
        }
        .candidats-table thead th {
            padding: 1.05rem 1.5rem;
            border-bottom: 3px solid var(--color-gold);
            text-align: left;
        }
        .candidats-table thead th.th-num { text-align: center; }

        /* Lignes zébrées, teintées de vert très clair, avec séparateurs doux */
        .candidats-table tbody tr {
            border-bottom: 1px solid rgba(0,122,94,0.12);
            transition: background-color var(--transition-normal);
        }
        .candidats-table tbody tr:nth-child(even) { background-color: rgba(0,122,94,0.025); }
        .candidats-table tbody tr:hover { background-color: rgba(0,122,94,0.07) !important; }
        .candidats-table tbody tr:last-child { border-bottom: none; }
        .candidats-table tbody td { padding: 1rem 1.5rem; color: var(--color-dark); font-size: 0.875rem; }

        .row-num {
            display: flex; align-items: center; justify-content: center;
            width: 32px; height: 32px; border-radius: 8px;
            background: var(--color-green); color: #fff;
            font-weight: 800; font-size: 0.8rem; margin: 0 auto;
            box-shadow: 0 2px 6px rgba(0,122,94,0.35);
        }
        .th-num { width: 54px; text-align: center; }

        /* ── Vague décorative en bas de carte ── */
        .wave-footer { position: relative; height: 34px; overflow: hidden; }
        .wave-footer svg { position: absolute; bottom: -2px; left: 0; width: 100%; height: 100%; }
    </style>

    <div class="content-wrapper page-bg">

        {{-- ── Bannière logo ── --}}
        <div class="brand-banner">
            <div class="brand-left">
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" class="brand-logo">
                <div>
                    <div class="brand-name">AGesP <small>Auto-École GESP — CFTRAF / CCI-BF</small></div>
                    <h1 class="brand-title">Liste des Candidats</h1>
                    <div class="brand-title-bar"></div>
                </div>
            </div>
            <div class="add-actions no-print">
                <a href="{{ route('candidats.create') }}" class="btn-add">+ Nouveau Candidat</a>
                <button onclick="window.print()" class="btn-export">⬇️ Exporter en PDF</button>
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
        <div class="table-card">
            <div style="overflow-x:auto;">
            <table class="candidats-table" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th class="th-num">N°</th>
                        <th>Candidat</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Pièces Jointes</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($candidats as $i => $candidat)
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
                    <tr>

                        <td class="th-num"><span class="row-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span></td>

                        {{-- ── Colonne Candidat : photo + nom + badge dossier ── --}}
                        <td>
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

                        <td>{{ $candidat->telephone }}</td>
                        <td>{{ $candidat->email }}</td>

                        {{-- Pièces Jointes --}}
                        <td>
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
                        <td style="text-align: center;">
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
                        <td colspan="6" style="padding: 3rem; text-align: center; color: var(--color-gray-500);">
                            <p style="margin: 0; font-size: 1rem;">📭 Aucun candidat trouvé</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>

            {{-- ── Vague décorative façon document officiel ── --}}
            <div class="wave-footer no-print">
                <svg viewBox="0 0 1200 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,30 C300,60 900,0 1200,30 L1200,60 L0,60 Z" fill="#007A5E" opacity="0.9"/>
                    <path d="M0,40 C300,65 900,15 1200,40 L1200,60 L0,60 Z" fill="#FCD116" opacity="0.85"/>
                    <path d="M0,50 C300,68 900,32 1200,50 L1200,60 L0,60 Z" fill="#CE1126" opacity="0.15"/>
                </svg>
            </div>
        </div>

        @if($candidats->count() > 0)
        <div style="margin-top: 1.5rem; padding: 1rem; background: rgba(0, 122, 94, 0.1); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); color: var(--color-green-dark);">
            <strong>Total :</strong> {{ $candidats->count() }} candidat(s)
        </div>
        @endif
    </div>
</x-layouts::app>