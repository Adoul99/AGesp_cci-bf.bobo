<x-layouts::app.sidebar title="Liste des Programmations">
<style>
:root {
    --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
    --color-red-light: #E85040; --color-red-dark: #A00D20;
    --color-green-light: #00A572; --color-green-dark: #004D3A;
    --color-gold-dark: #E5B800;

    --bg-page: linear-gradient(160deg, #0B2F1D 0%, #0F3D24 45%, #123F26 100%);
    --card-bg: rgba(255,255,255,0.05);
    --card-border: rgba(255,255,255,0.14);
    --text-light: #F4F9F6;
    --text-muted: #A9C4B4;
    --radius-md: 10px; --radius-lg: 16px;
    --shadow-md: 0 10px 30px rgba(0,0,0,0.35);
}

.content-wrapper { background: var(--bg-page); min-height: 100vh; padding: 2.5rem; font-family: inherit; }

.pg-pill {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: rgba(206,17,38,0.18); border: 1px solid rgba(206,17,38,0.4);
    color: #FFD6D0; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.06em; padding: 0.4rem 0.9rem; border-radius: 50px; margin-bottom: 1.25rem;
}
.pg-pill .dot { width: 7px; height: 7px; border-radius: 50%; background: var(--color-red); box-shadow: 0 0 6px var(--color-red); }

.pg-header-row {
    display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;
    margin-bottom: 1.75rem;
}
.pg-title {
    font-size: 2.1rem; font-weight: 800; color: var(--text-light); margin: 0; letter-spacing: -0.5px;
    display: flex; align-items: center; gap: 0.75rem;
}
.pg-count-badge {
    background: rgba(0,122,94,0.25); color: #6EE7C0; font-size: 0.85rem; font-weight: 800;
    padding: 0.2rem 0.75rem; border-radius: 50px;
}

.pg-btn-new {
    background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%);
    color: white; padding: 0.8rem 1.5rem; border-radius: var(--radius-md); border: 2px solid var(--color-red);
    font-weight: 700; text-decoration: none; font-size: 0.85rem; text-transform: uppercase;
    letter-spacing: 0.03em; display: inline-flex; align-items: center; gap: 0.5rem;
    box-shadow: 0 6px 18px rgba(206,17,38,0.35);
}

.pg-card {
    background: var(--card-bg); border: 1px solid var(--card-border);
    border-radius: var(--radius-lg); box-shadow: var(--shadow-md); overflow: hidden;
    backdrop-filter: blur(6px);
}

.pg-table { width: 100%; border-collapse: collapse; }
.pg-table thead th {
    background: rgba(0,122,94,0.28); color: var(--text-light); font-weight: 700;
    text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.06em;
    padding: 1rem 1.25rem; text-align: left; border-bottom: 3px solid var(--color-gold);
}
.pg-table thead th.center { text-align: center; }
.pg-table tbody td {
    padding: 1rem 1.25rem; color: var(--text-light); font-size: 0.875rem; vertical-align: middle;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.pg-table tbody tr:last-child td { border-bottom: none; }
.pg-table tbody tr:hover { background: rgba(255,255,255,0.03); }

.pg-date-range {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: rgba(0,122,94,0.18); color: #6EE7C0;
    padding: 0.3rem 0.75rem; border-radius: 8px; font-size: 0.8rem; font-weight: 600;
}

.pg-type-badge {
    display: inline-flex; align-items: center; gap: 0.4rem;
    padding: 0.35rem 0.85rem; border-radius: 8px; font-size: 0.8rem; font-weight: 700;
}
.pg-type-code     { background: rgba(206,17,38,0.18); color: #FFB3AB; border: 1px solid rgba(206,17,38,0.35); }
.pg-type-creneau  { background: rgba(252,209,22,0.15); color: #FCD116; border: 1px solid rgba(252,209,22,0.35); }
.pg-type-conduite { background: rgba(0,122,94,0.2); color: #6EE7C0; border: 1px solid rgba(0,122,94,0.4); }

.pg-moniteur-pill {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: rgba(255,255,255,0.06); color: var(--text-light);
    padding: 0.3rem 0.75rem; border-radius: 8px; font-size: 0.8rem; font-weight: 600;
}
.pg-non-assigne { color: var(--text-muted); font-size: 0.8rem; font-style: italic; }

.pg-candidats-grid { display: flex; flex-wrap: wrap; gap: 0.4rem; }
.pg-candidat-tag {
    display: inline-flex; align-items: center; gap: 0.3rem;
    background: rgba(0,122,94,0.14); color: #A9E8CC; border: 1px solid rgba(0,122,94,0.3);
    padding: 0.28rem 0.65rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600; white-space: nowrap;
}
.pg-candidat-tag::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: #6EE7C0; flex-shrink: 0; }
.pg-aucun-candidat { color: var(--text-muted); font-size: 0.8rem; font-style: italic; }

.pg-actions { display: flex; gap: 0.5rem; justify-content: center; }
.pg-btn-icon {
    width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;
    border-radius: 8px; text-decoration: none; border: 1px solid transparent; cursor: pointer;
    transition: transform 0.15s;
}
.pg-btn-icon:hover { transform: translateY(-1px); }
.pg-btn-edit { background: rgba(0,122,94,0.18); color: #6EE7C0; border-color: rgba(0,122,94,0.35); }
.pg-btn-del  { background: rgba(206,17,38,0.16); color: #FF8A80; border-color: rgba(206,17,38,0.35); }
.pg-btn-del form { display: contents; }
.pg-btn-del button { all: unset; display: contents; cursor: pointer; }

.pg-empty-state { padding: 4rem 2rem; text-align: center; color: var(--text-muted); }

.pg-flash {
    display: flex; align-items: center; gap: 0.75rem; padding: 0.9rem 1.25rem;
    border-radius: var(--radius-md); margin-bottom: 1.25rem; font-size: 0.9rem; font-weight: 600;
    background: rgba(0,122,94,0.18); color: #6EE7C0; border: 1px solid rgba(0,122,94,0.35);
}
</style>

<div class="content-wrapper">

    @if(session('success'))
    <div class="pg-flash">✓ {{ session('success') }}</div>
    @endif

    <span class="pg-pill"><span class="dot"></span> CCI-BF — BOBO-DIOULASSO</span>

    <div class="pg-header-row">
        <h1 class="pg-title">
            Programmations
            <span class="pg-count-badge">{{ $programmations->count() }}</span>
        </h1>
        <a href="{{ route('programmations.create') }}" class="pg-btn-new">+ Nouvelle Programmation</a>
    </div>

    <div class="pg-card">
        <table class="pg-table">
            <thead>
                <tr>
                    <th style="width:200px;">Dates</th>
                    <th style="width:140px;">Type de session</th>
                    <th style="width:160px;">Moniteur</th>
                    <th>Candidats</th>
                    <th class="center" style="width:110px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programmations as $p)
                <tr>
                    <td>
                        <span class="pg-date-range">
                            {{ \Carbon\Carbon::parse($p->dateDebut)->format('d/m/Y') }}
                            <span style="opacity:.5;">→</span>
                            {{ \Carbon\Carbon::parse($p->dateFin)->format('d/m/Y') }}
                        </span>
                    </td>

                    <td>
                        @if($p->typeSession)
                            @php $type = strtolower($p->typeSession->type ?? ''); @endphp
                            <span class="pg-type-badge pg-type-{{ $type }}">
                                @switch($type)
                                    @case('code') 📋 Code @break
                                    @case('creneau') 🔧 Créneau @break
                                    @case('conduite') 🚗 Conduite @break
                                    @default {{ $p->typeSession->type }}
                                @endswitch
                            </span>
                        @else
                            <span class="pg-non-assigne">—</span>
                        @endif
                    </td>

                    <td>
                        @if($p->moniteur)
                            <span class="pg-moniteur-pill">👤 {{ $p->moniteur->nom }} {{ $p->moniteur->prenom }}</span>
                        @else
                            <span class="pg-non-assigne">Non assigné</span>
                        @endif
                    </td>

                    <td>
                        @if($p->candidats->count() > 0)
                            <div class="pg-candidats-grid">
                                @foreach($p->candidats as $c)
                                    <span class="pg-candidat-tag">{{ $c->nom }} {{ $c->prenom }}</span>
                                @endforeach
                            </div>
                        @else
                            <span class="pg-aucun-candidat">Aucun candidat</span>
                        @endif
                    </td>

                    <td>
                        <div class="pg-actions">
                            <a href="{{ route('programmations.edit', $p->id) }}" class="pg-btn-icon pg-btn-edit" title="Modifier">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <span class="pg-btn-icon pg-btn-del" title="Supprimer">
                                <form action="{{ route('programmations.destroy', $p->id) }}" method="POST"
                                      onsubmit="return confirm('Supprimer cette programmation ?')">
                                    @csrf @method('DELETE')
                                    <button type="submit">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                    </button>
                                </form>
                            </span>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="pg-empty-state">
                            📭 Aucune programmation enregistrée.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
</x-layouts::app.sidebar>