<x-layouts::app.sidebar title="Liste des Programmations">
<style>
    @import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&family=Inter:wght@400;500&display=swap');

    :root {
        --cci-red:    #CE1126;
        --cci-green:  #007A5E;
        --cci-gold:   #FCD116;
        --cci-dark:   #0F1923;
        --cci-slate:  #1E2D3D;
        --cci-muted:  #64748B;
        --cci-line:   #E8ECF0;
        --cci-bg:     #F4F6F9;
        --cci-white:  #FFFFFF;
        --cci-red-soft:   rgba(206,17,38,.08);
        --cci-green-soft: rgba(0,122,94,.08);
        --cci-gold-soft:  rgba(252,209,22,.15);
        --radius:  14px;
        --shadow:  0 2px 16px rgba(15,25,35,.08);
        --shadow-lg: 0 8px 32px rgba(15,25,35,.12);
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }

    .pg-wrap {
        font-family: 'Inter', sans-serif;
        background: var(--cci-bg);
        min-height: 100vh;
        padding: 2rem;
    }

    .pg-header {
        display: flex; align-items: center; justify-content: space-between;
        background: var(--cci-white); border-radius: var(--radius);
        padding: 1.5rem 2rem; box-shadow: var(--shadow); margin-bottom: 1.75rem;
        border-top: 4px solid transparent;
        border-image: linear-gradient(90deg, var(--cci-red), var(--cci-green), var(--cci-gold)) 1;
        border-image-slice: 1;
    }
    .pg-header-left { display: flex; align-items: center; gap: 1rem; }
    .pg-flag-bar {
        width: 5px; height: 42px; border-radius: 3px; flex-shrink: 0;
        background: linear-gradient(180deg, var(--cci-red) 33%, var(--cci-green) 33% 66%, var(--cci-gold) 66%);
    }
    .pg-title { font-family: 'Sora', sans-serif; font-size: 1.75rem; font-weight: 800; color: var(--cci-dark); letter-spacing: -.5px; }
    .pg-count {
        display: inline-flex; align-items: center;
        background: var(--cci-green-soft); color: var(--cci-green);
        font-size: .75rem; font-weight: 700; padding: .25rem .65rem;
        border-radius: 20px; letter-spacing: .04em; margin-left: .5rem; vertical-align: middle;
    }
    .btn-new {
        display: inline-flex; align-items: center; gap: .5rem;
        background: linear-gradient(135deg, var(--cci-red) 0%, #A50F20 100%);
        color: white; font-family: 'Sora', sans-serif; font-weight: 700; font-size: .85rem;
        padding: .75rem 1.4rem; border-radius: 10px; text-decoration: none;
        box-shadow: 0 4px 14px rgba(206,17,38,.35); transition: transform .18s, box-shadow .18s;
    }
    .btn-new:hover { transform: translateY(-2px); box-shadow: 0 6px 18px rgba(206,17,38,.45); }

    .flash { display: flex; align-items: center; gap: .75rem; padding: .9rem 1.25rem; border-radius: var(--radius); margin-bottom: 1.25rem; font-size: .9rem; font-weight: 500; }
    .flash-success { background: var(--cci-green-soft); color: #065F46; border: 1px solid rgba(0,122,94,.2); }

    .table-card { background: var(--cci-white); border-radius: var(--radius); box-shadow: var(--shadow); overflow: hidden; }

    table { width: 100%; border-collapse: collapse; }
    thead { background: linear-gradient(135deg, var(--cci-green) 0%, #005A46 100%); }
    thead th {
        padding: 1rem 1.25rem; text-align: left; color: white;
        font-family: 'Sora', sans-serif; font-size: .72rem; font-weight: 700;
        letter-spacing: .1em; text-transform: uppercase;
    }
    thead th:last-child { text-align: center; }

    tbody tr { border-bottom: 1px solid var(--cci-line); transition: background .15s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #FAFBFC; }

    td { padding: 1rem 1.25rem; vertical-align: top; color: var(--cci-dark); font-size: .9rem; }
    td.td-middle { vertical-align: middle; }

    .date-range {
        display: inline-flex; align-items: center; gap: .4rem;
        background: var(--cci-green-soft); color: var(--cci-green);
        padding: .3rem .75rem; border-radius: 8px; font-size: .82rem; font-weight: 600;
    }
    .moniteur-pill {
        display: inline-flex; align-items: center; gap: .4rem;
        background: var(--cci-red-soft); color: var(--cci-red);
        padding: .3rem .75rem; border-radius: 8px; font-size: .82rem; font-weight: 600;
    }
    .groupe-pill {
        display: inline-flex; align-items: center; gap: .4rem;
        background: var(--cci-gold-soft); color: #92620A;
        padding: .3rem .75rem; border-radius: 8px; font-size: .82rem; font-weight: 600;
    }

    /* ── CANDIDATS EN GRILLE 3 COLONNES ─────── */
    .candidats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .3rem;
    }
    .candidat-tag {
        display: flex;
        align-items: center;
        gap: .3rem;
        background: #EFF6FF;
        color: #1D4ED8;
        padding: .28rem .55rem;
        border-radius: 6px;
        font-size: .75rem;
        font-weight: 500;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .candidat-tag::before {
        content: '';
        width: 5px; height: 5px;
        background: #3B82F6;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .td-actions { text-align: center; vertical-align: middle; }
    .actions-wrap { display: inline-flex; align-items: center; gap: .5rem; }
    .btn-edit {
        display: inline-flex; align-items: center; justify-content: center;
        width: 34px; height: 34px; border-radius: 8px;
        background: var(--cci-green-soft); color: var(--cci-green);
        text-decoration: none; border: 1px solid rgba(0,122,94,.15);
        transition: background .15s, transform .15s;
    }
    .btn-edit:hover { background: var(--cci-green); color: white; transform: translateY(-1px); }
    .btn-del {
        display: inline-flex; align-items: center; justify-content: center;
        width: 34px; height: 34px; border-radius: 8px;
        background: var(--cci-red-soft); color: var(--cci-red);
        cursor: pointer; border: 1px solid rgba(206,17,38,.15);
        transition: background .15s, transform .15s;
    }
    .btn-del:hover { background: var(--cci-red); color: white; transform: translateY(-1px); }
    .btn-del form { display: contents; }
    .btn-del button { all: unset; display: contents; cursor: pointer; }

    .empty-state { padding: 4rem 2rem; text-align: center; color: var(--cci-muted); }
    .empty-state svg { width: 48px; height: 48px; opacity: .3; display: block; margin: 0 auto 1rem; }
</style>

<div class="pg-wrap">

    @if(session('success'))
    <div class="flash flash-success">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="pg-header">
        <div class="pg-header-left">
            <div class="pg-flag-bar"></div>
            <h1 class="pg-title">
                Programmations
                <span class="pg-count">{{ $programmations->count() }}</span>
            </h1>
        </div>
        <a href="{{ route('programmations.create') }}" class="btn-new">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nouvelle Programmation
        </a>
    </div>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th style="width:200px">Dates</th>
                    <th style="width:130px">Type de session</th>
                    <th style="width:160px">Moniteur</th>
                    <th>Candidats</th>
                    <th style="width:100px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($programmations as $p)
                <tr>
                    <td class="td-middle">
                        <span class="date-range">
                            {{ \Carbon\Carbon::parse($p->dateDebut)->format('d/m/Y') }}
                            <span style="opacity:.5;font-size:.75rem;">→</span>
                            {{ \Carbon\Carbon::parse($p->dateFin)->format('d/m/Y') }}
                        </span>
                    </td>

                    <td class="td-middle">
                        @if($p->typeSession)
                            @php
                                $tsColors = ['code' => '#c0281e', 'creneau' => '#d4a017', 'conduite' => '#1a6b3a'];
                                $tsColor = $tsColors[$p->typeSession->type] ?? '#666';
                            @endphp
                            <span class="groupe-pill" style="background:{{ $tsColor }}1A; color:{{ $tsColor }}; border-color:{{ $tsColor }}40;">
                                @switch($p->typeSession->type)
                                    @case('code') 📋 Code @break
                                    @case('creneau') 🔧 Créneau @break
                                    @case('conduite') 🚗 Conduite @break
                                    @default {{ $p->typeSession->type }}
                                @endswitch
                            </span>
                        @else
                            <span style="color:var(--cci-muted);font-size:.82rem;">—</span>
                        @endif
                    </td>

                    <td class="td-middle">
                        @if($p->moniteur)
                            <span class="moniteur-pill">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                {{ $p->moniteur->nom }} {{ $p->moniteur->prenom }}
                            </span>
                        @else
                            <span style="color:var(--cci-muted);font-size:.82rem;">Non assigné</span>
                        @endif
                    </td>

                    <!-- Candidats en grille 3 colonnes -->
                    <td>
                        @if($p->candidats->count() > 0)
                            <div class="candidats-grid">
                                @foreach($p->candidats as $c)
                                    <span class="candidat-tag" title="{{ $c->nom }} {{ $c->prenom }}">
                                        {{ $c->nom }} {{ $c->prenom }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span style="color:var(--cci-muted);font-size:.82rem;">Aucun candidat</span>
                        @endif
                    </td>

                    <td class="td-actions">
                        <div class="actions-wrap">
                            <a href="{{ route('programmations.edit', $p->id) }}" class="btn-edit" title="Modifier">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <span class="btn-del" title="Supprimer">
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
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            <p>Aucune programmation enregistrée.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
</x-layouts::app.sidebar>