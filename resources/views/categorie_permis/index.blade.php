<x-layouts::app.sidebar title="Liste des Catégories de Permis">
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

.cp-pill {
    display: inline-flex; align-items: center; gap: 0.5rem;
    background: rgba(206,17,38,0.18); border: 1px solid rgba(206,17,38,0.4);
    color: #FFD6D0; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.06em; padding: 0.4rem 0.9rem; border-radius: 50px; margin-bottom: 1.25rem;
}
.cp-pill .dot { width: 7px; height: 7px; border-radius: 50%; background: var(--color-red); box-shadow: 0 0 6px var(--color-red); }

.cp-header-row {
    display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;
    margin-bottom: 1.75rem;
}
.cp-title { font-size: 2.1rem; font-weight: 800; color: var(--text-light); margin: 0; letter-spacing: -0.5px; }

.cp-btn-new {
    background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%);
    color: white; padding: 0.8rem 1.5rem; border-radius: var(--radius-md); border: 2px solid var(--color-red);
    font-weight: 700; text-decoration: none; font-size: 0.85rem; text-transform: uppercase;
    letter-spacing: 0.03em; display: inline-flex; align-items: center; gap: 0.5rem;
    box-shadow: 0 6px 18px rgba(206,17,38,0.35);
}

.cp-flash {
    display: flex; align-items: center; gap: 0.75rem; padding: 0.9rem 1.25rem;
    border-radius: var(--radius-md); margin-bottom: 1.25rem; font-size: 0.9rem; font-weight: 600;
    background: rgba(0,122,94,0.18); color: #6EE7C0; border: 1px solid rgba(0,122,94,0.35);
}

.cp-card {
    background: var(--card-bg); border: 1px solid var(--card-border);
    border-radius: var(--radius-lg); box-shadow: var(--shadow-md); overflow: hidden;
    backdrop-filter: blur(6px);
}

.cp-table { width: 100%; border-collapse: collapse; }
.cp-table thead th {
    background: rgba(0,122,94,0.28); color: var(--text-light); font-weight: 700;
    text-transform: uppercase; font-size: 0.72rem; letter-spacing: 0.06em;
    padding: 1rem 1.25rem; text-align: left; border-bottom: 3px solid var(--color-gold);
}
.cp-table thead th.center { text-align: center; }
.cp-table tbody td {
    padding: 1rem 1.25rem; color: var(--text-light); font-size: 0.875rem; vertical-align: middle;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.cp-table tbody tr:last-child td { border-bottom: none; }
.cp-table tbody tr:hover { background: rgba(255,255,255,0.03); }
.cp-desc { color: var(--text-muted); }

.cp-actions { display: flex; gap: 0.5rem; justify-content: center; }
.cp-btn-icon {
    width: 34px; height: 34px; display: inline-flex; align-items: center; justify-content: center;
    border-radius: 8px; text-decoration: none; border: 1px solid transparent; cursor: pointer;
    transition: transform 0.15s;
}
.cp-btn-icon:hover { transform: translateY(-1px); }
.cp-btn-edit { background: rgba(0,122,94,0.18); color: #6EE7C0; border-color: rgba(0,122,94,0.35); }
.cp-btn-del  { background: rgba(206,17,38,0.16); color: #FF8A80; border-color: rgba(206,17,38,0.35); }
.cp-btn-del form { display: contents; }
.cp-btn-del button { all: unset; display: contents; cursor: pointer; }

.cp-empty-state { padding: 4rem 2rem; text-align: center; color: var(--text-muted); }

.cp-summary {
    margin-top: 1.5rem; padding: 1rem 1.25rem; background: rgba(0,122,94,0.15);
    border-left: 4px solid var(--color-green-light); border-radius: var(--radius-md);
    color: #D7F5E8; font-size: 0.875rem;
}
</style>

<div class="content-wrapper">

    @if(session('success'))
    <div class="cp-flash">✓ {{ session('success') }}</div>
    @endif

    <span class="cp-pill"><span class="dot"></span> CCI-BF — BOBO-DIOULASSO</span>

    <div class="cp-header-row">
        <h1 class="cp-title">Liste des Catégories de Permis</h1>
        <a href="{{ route('categorie_permis.create') }}" class="cp-btn-new">+ Nouvelle Catégorie</a>
    </div>

    <div class="cp-card">
        <table class="cp-table">
            <thead>
                <tr>
                    <th>Nom Catégorie</th>
                    <th>Description</th>
                    <th class="center" style="width:110px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $categorie)
                <tr>
                    <td style="font-weight:700;">{{ $categorie->nomCategorie }}</td>
                    <td class="cp-desc">{{ $categorie->description ?? '—' }}</td>
                    <td>
                        <div class="cp-actions">
                            <a href="{{ route('categorie_permis.edit', $categorie->id) }}" class="cp-btn-icon cp-btn-edit" title="Modifier">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </a>
                            <span class="cp-btn-icon cp-btn-del" title="Supprimer">
                                <form action="{{ route('categorie_permis.destroy', $categorie->id) }}" method="POST"
                                      onsubmit="return confirm('Supprimer cette catégorie ?')">
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
                    <td colspan="3">
                        <div class="cp-empty-state">📭 Aucune catégorie trouvée</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(isset($categories) && $categories->count() > 0)
    <div class="cp-summary">
        <strong>Total :</strong> {{ $categories->count() }} catégorie(s) de permis
    </div>
    @endif

</div>
</x-layouts::app.sidebar>