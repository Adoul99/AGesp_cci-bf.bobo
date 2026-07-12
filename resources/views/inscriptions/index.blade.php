<x-layouts::app title="Liste des Inscriptions">
    <style>
        :root {
            --color-red: #CE1126;
            --color-green: #007A5E;
            --color-gold: #FCD116;
            --color-gray-border: #E7E9EC;
            --color-row-alt: #FAFBFC;
            --color-dark: #1A1A1A;
            --radius-lg: 14px;
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
            box-shadow: 0 1px 3px rgba(16,24,40,0.04), 0 8px 24px rgba(16,24,40,0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
        }
        .brand-left { display: flex; align-items: center; gap: 1rem; }
        .brand-logo {
            width: 56px; height: 56px; border-radius: 50%; flex-shrink: 0;
            object-fit: cover; border: 2px solid var(--color-gray-border);
        }
        .brand-name { font-size: 0.72rem; font-weight: 800; letter-spacing: 0.04em; color: #4B5157; text-transform: uppercase; line-height: 1.3; }
        .brand-name small { display: block; font-weight: 600; color: #8A9199; font-size: 0.68rem; text-transform: none; margin-top: 2px; }

        .brand-title {
            font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 1.55rem; color: var(--color-green);
            letter-spacing: 0.01em; text-transform: uppercase; margin: 0;
        }
        .brand-title-bar {
            height: 4px; width: 100%; margin-top: 6px; border-radius: 2px;
            background: linear-gradient(90deg, var(--color-red) 0%, var(--color-green) 50%, var(--color-gold) 100%);
        }
        .brand-tagline { text-align: right; font-size: 0.72rem; color: #6B7280; line-height: 1.4; }
        .brand-tagline strong { color: var(--color-green); display: block; font-size: 0.78rem; }

        .add-btn {
            background: var(--color-red); color: #fff; padding: 0.7rem 1.4rem;
            border-radius: 10px; text-decoration: none; font-weight: 600; font-size: 0.88rem;
            white-space: nowrap;
        }

        /* ── Carte tableau ── */
        .table-card {
            background: #fff;
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid var(--color-gray-border);
            box-shadow: 0 1px 3px rgba(16,24,40,0.04), 0 8px 24px rgba(16,24,40,0.06);
            position: relative;
        }

        .sheet-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.92rem;
        }
        .sheet-table thead th {
            background: var(--color-green);
            text-align: left;
            padding: 1rem 1.2rem;
            font-size: 0.74rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            color: #fff;
            white-space: nowrap;
        }
        .sheet-table thead th:first-child { border-top-left-radius: 0; }
        .th-num { width: 56px; text-align: center; }

        .sheet-table tbody td {
            padding: 0.85rem 1.2rem;
            border-bottom: 1px solid var(--color-gray-border);
            color: var(--color-dark);
            vertical-align: middle;
        }
        .sheet-table tbody tr:nth-child(even) { background-color: var(--color-row-alt); }
        .sheet-table tbody tr:hover { background-color: #F0F5F2; }
        .sheet-table tbody tr:last-child td { border-bottom: none; }

        .row-num {
            display: flex; align-items: center; justify-content: center;
            width: 34px; height: 34px; border-radius: 8px;
            background: var(--color-green); color: #fff;
            font-weight: 800; font-size: 0.85rem; margin: 0 auto;
        }

        .cat-icon {
            display: inline-flex; align-items: center; justify-content: center;
            width: 30px; height: 30px; border-radius: 50%; color: #fff;
            font-size: 0.85rem; font-weight: 800; margin-right: 0.6rem; flex-shrink: 0;
        }
        .cat-D { background: var(--color-red); }
        .cat-E { background: var(--color-gold); color: #4A3900; }
        .cat-cell { display: flex; align-items: center; }

        .statut-text { font-weight: 700; font-size: 0.85rem; }
        .statut-actif { color: var(--color-green); }
        .statut-attente { color: #A8760F; }

        .paiement-text { font-weight: 700; color: var(--color-dark); }
        .paiement-vide { color: #AAB0B6; font-weight: 400; }

        .action-link {
            display: inline-block;
            padding: 0.4rem 0.85rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 600;
            border: 1px solid transparent;
            transition: transform 0.12s ease, box-shadow 0.12s ease;
        }
        .action-link:hover { transform: translateY(-1px); box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
        .action-modifier { background: #FFF7E0; color: #8A6300; border-color: #F0DFA6; }
        .action-supprimer { background: #FDECEC; color: var(--color-red); border-color: #F4C6C6; cursor: pointer; }

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
                    <h1 class="brand-title">Liste des Inscriptions</h1>
                    <div class="brand-title-bar"></div>
                </div>
            </div>
            <div style="display:flex; align-items:center; gap:1.5rem;">
                <div class="brand-tagline">
                    <strong>Ensemble,</strong>
                    pour des conducteurs professionnels qualifiés
                </div>
                <a href="{{ route('inscriptions.create') }}" class="add-btn">+ Nouvelle Inscription</a>
            </div>
        </div>

        @if(session('success'))
            <div style="background:#d4edda; color:#155724; padding:0.9rem 1.4rem; border-radius:var(--radius-lg); margin-bottom:1.4rem; border:1px solid #c3e6cb; font-size:0.9rem;">
                {{ session('success') }}
            </div>
        @endif

        {{-- ── Tableau ── --}}
        <div class="table-card">
            <div style="overflow-x: auto;">
                <table class="sheet-table">
                    <thead>
                        <tr>
                            <th class="th-num">N°</th>
                            <th>Candidat</th>
                            <th>Catégorie</th>
                            <th>Date Inscription</th>
                            <th>Statut</th>
                            <th>Paiement</th>
                            <th>Début Formation</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inscriptions as $i => $inscription)
                        <tr>
                            <td class="th-num"><span class="row-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span></td>
                            <td style="font-weight: 600;">{{ $inscription->candidat->nom ?? 'N/A' }} {{ $inscription->candidat->prenom ?? '' }}</td>
                            <td>
                                @php $cat = $inscription->categoriePermis->nomCategorie ?? '—'; @endphp
                                <div class="cat-cell">
                                    <span class="cat-icon cat-{{ $cat }}">{{ $cat }}</span>
                                    Permis {{ $cat }}
                                </div>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($inscription->dateInscription)->format('d/m/Y') }}</td>
                            <td>
                                <span class="statut-text {{ $inscription->statutInscription == 'actif' ? 'statut-actif' : 'statut-attente' }}">
                                    {{ ucfirst($inscription->statutInscription) }}
                                </span>
                            </td>
                            <td>
                                @if($inscription->paiement)
                                    <span class="paiement-text">{{ number_format($inscription->paiement->montant, 0, ',', ' ') }} FCFA</span>
                                @else
                                    <span class="paiement-vide">—</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($inscription->dataDebut_formation)->format('d/m/Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('inscriptions.edit', $inscription->id) }}" class="action-link action-modifier">Modifier</a>
                                    <form method="POST" action="{{ route('inscriptions.destroy', $inscription->id) }}" onsubmit="return confirm('Êtes-vous sûr ?')" style="margin:0;">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-link action-supprimer">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="padding: 2rem; text-align: center; color: #999;">Aucune inscription enregistrée.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- ── Vague décorative façon document officiel ── --}}
            <div class="wave-footer">
                <svg viewBox="0 0 1200 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,30 C300,60 900,0 1200,30 L1200,60 L0,60 Z" fill="{{ '#007A5E' }}" opacity="0.9"/>
                    <path d="M0,40 C300,65 900,15 1200,40 L1200,60 L0,60 Z" fill="{{ '#FCD116' }}" opacity="0.85"/>
                    <path d="M0,50 C300,68 900,32 1200,50 L1200,60 L0,60 Z" fill="{{ '#CE1126' }}" opacity="0.15"/>
                </svg>
            </div>
        </div>
    </div>
</x-layouts::app>