<x-layouts::app.sidebar title="Liste des Reçus">
<style>
    .recus-page {
        font-family: 'Segoe UI', sans-serif;
        background: #f0f2f5;
        min-height: 100vh;
        padding: 24px;
    }

    .page-header-card {
        background: #fff;
        border-radius: 6px;
        padding: 20px 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        border-left: 4px solid #c0392b;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    .btn-new {
        background: #c0392b;
        color: #fff;
        border: none;
        padding: 9px 20px;
        border-radius: 4px;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-decoration: none;
        cursor: pointer;
        text-transform: uppercase;
        transition: background 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-new:hover { background: #a93226; color: #fff; }

    .btn-export {
        background: #d4870a;
        color: #fff;
        border: none;
        padding: 9px 20px;
        border-radius: 4px;
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.04em;
        text-decoration: none;
        cursor: pointer;
        text-transform: uppercase;
        transition: background 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-export:hover { background: #b8730a; color: #fff; }

    .table-card {
        background: #fff;
        border-radius: 6px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        border: 1px solid #e0e3e8;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table thead tr {
        background: #2e7d6e;
    }

    .data-table thead th {
        color: #fff;
        font-size: 0.78rem;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        padding: 14px 18px;
        text-align: left;
        border: none;
    }

    .data-table tbody tr {
        border-bottom: 1px solid #eef0f3;
        transition: background 0.15s;
    }

    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #f7f9fc; }

    .data-table tbody td {
        padding: 13px 18px;
        font-size: 0.88rem;
        color: #2c3e50;
        vertical-align: middle;
    }

    .empty-state {
        text-align: center;
        padding: 48px 20px;
        color: #7f8c9a;
        font-size: 0.9rem;
    }

    .empty-state::before {
        content: "📋";
        display: block;
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .btn-edit {
        background: #e67e22;
        color: #fff;
        border: none;
        padding: 5px 14px;
        border-radius: 3px;
        font-size: 0.78rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        transition: background 0.2s;
        letter-spacing: 0.02em;
    }
    .btn-edit:hover { background: #ca6f1e; color: #fff; }

    .btn-delete {
        background: #c0392b;
        color: #fff;
        border: none;
        padding: 5px 14px;
        border-radius: 3px;
        font-size: 0.78rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        letter-spacing: 0.02em;
    }
    .btn-delete:hover { background: #a93226; }

    .action-cell { display: flex; gap: 6px; align-items: center; }

    .badge-montant {
        font-weight: 700;
        color: #1a6b4a;
    }

    /* --- EXPORT PDF --- */
    @media print {
        .header-actions,
        .action-cell,
        .data-table thead th:last-child,
        .data-table tbody td:last-child,
        nav, .sidebar {
            display: none !important;
        }
        body { background: white !important; }
        .recus-page { padding: 0 !important; }
        .page-header-card { box-shadow: none !important; border: 1px solid #ccc !important; }
        .table-card { box-shadow: none !important; border: 1px solid #000 !important; }
        .data-table thead tr { background: #f2f2f2 !important; }
        .data-table thead th { color: black !important; border: 1px solid #000 !important; }
        .data-table tbody td { border: 1px solid #ccc !important; }
    }
</style>

<div class="recus-page">
    <!-- Page Header -->
    <div class="page-header-card">
        <h1 class="page-title">| Liste des Reçus</h1>
        <div class="header-actions">
            <a href="{{ route('recus.create') }}" class="btn-new">+ Nouveau Reçu</a>
            <!-- BOUTON EXPORTER : onclick="window.print()" ajouté -->
            <button onclick="window.print()" class="btn-export">
                <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M13 7H7v6h6V7zm4-4H3a1 1 0 00-1 1v14a1 1 0 001 1h14a1 1 0 001-1V4a1 1 0 00-1-1z"/></svg>
                Exporter en PDF
            </button>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div style="margin-bottom: 16px; padding: 12px 18px; background: rgba(46,125,110,0.1); border-left: 4px solid #2e7d6e; border-radius: 5px; color: #1a5c4f; font-weight: 600;">
            ✅ {{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="table-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Montant</th>
                    <th>Date Reçu</th>
                    <th>Paiement</th>
                    <th>Candidat</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recus as $recu)
                <tr>
                    <td class="badge-montant">{{ number_format($recu->montant, 0, ',', ' ') }} FCFA</td>
                    <td>{{ \Carbon\Carbon::parse($recu->dateRecus)->format('d/m/Y') }}</td>
                    <td>{{ $recu->paiement ? number_format($recu->paiement->montant, 0, ',', ' ').' FCFA' : 'N/A' }}</td>
                    <td>{{ $recu->paiement && $recu->paiement->candidat ? $recu->paiement->candidat->nom.' '.$recu->paiement->candidat->prenom : 'N/A' }}</td>
                    <td>
                        <div class="action-cell">
                            <a href="{{ route('recus.edit', $recu->id) }}" class="btn-edit">Modifier</a>
                            <form method="POST" action="{{ route('recus.destroy', $recu->id) }}" onsubmit="return confirm('Confirmer la suppression ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">Aucun reçu trouvé</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Résumé -->
    @if(isset($recus) && $recus->count() > 0)
    <div style="margin-top: 16px; padding: 12px 18px; background: rgba(46,125,110,0.1); border-left: 4px solid #2e7d6e; border-radius: 5px; color: #1a5c4f; font-size: 0.875rem;">
        <strong>Total :</strong> {{ $recus->count() }} reçu(s)
    </div>
    @endif
</div>
</x-layouts::app.sidebar>