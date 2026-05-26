<x-layouts::app.sidebar title="Liste des Types de Session">
    <style>
        :root {
            --card-bg: #ffffff;
            --card-border: #E5E7EB;
            --card-shadow: 0 20px 45px rgba(15, 23, 42, 0.08);
            --accent: #2563EB;
            --text-dark: #111827;
            --text-muted: #6B7280;
            --radius: 20px;
            --transition: 250ms ease;
        }
        .table-card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: var(--radius); box-shadow: var(--card-shadow); }
        .table-header { padding: 1.8rem 2rem; border-bottom: 1px solid #E5E7EB; }
        .table-title { font-size: 1.95rem; font-weight: 800; color: var(--text-dark); margin-bottom: 0.25rem; }
        .table-subtitle { color: var(--text-muted); }
        .table-action { display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.85rem 1.2rem; border-radius: 14px; font-weight: 700; background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%); color: white; transition: transform var(--transition); text-decoration: none; }
        .table-action:hover { transform: translateY(-1px); }
        .type-action { display: inline-flex; align-items: center; justify-content: center; min-width: 110px; padding: 0.65rem 1rem; border-radius: 12px; font-weight: 600; transition: background var(--transition); }
        .type-action-edit { background: #FBBF24; color: #111827; }
        .type-action-edit:hover { background: #F59E0B; }
        .type-action-delete { background: #EF4444; color: white; }
        .type-action-delete:hover { background: #DC2626; }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th, .data-table td { padding: 1rem 1.15rem; border-bottom: 1px solid #E5E7EB; }
        .data-table th { text-align: left; color: var(--text-muted); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.08em; }
        .data-table tbody tr:hover { background: #F8FAFC; }
    </style>

    <div class="p-6">
        @if(session('success'))
            <div class="mb-5 rounded-2xl border border-green-200 bg-green-50 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-card overflow-hidden">
            <div class="table-header flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="table-title">Liste des Types de Session</h1>
                    <p class="table-subtitle">Gérez votre liste de types de session avec un design clair et simple.</p>
                </div>
                <a href="{{ route('type_sessions.create') }}" class="table-action">+ Nouveau type</a>
            </div>

            <div class="overflow-x-auto">
                <table class="data-table w-full">
                    <thead>
                        <tr>
                            <th>ID Session</th>
                            <th>Type</th>
                            <th>Créneau</th>
                            <th>Conduite</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($typeSessions as $type)
                            <tr>
                                <td>{{ $type->idSession }}</td>
                                <td>{{ $type->code }}</td>
                                <td>{{ $type->creneau }}</td>
                                <td>{{ $type->conduite }}</td>
                                <td>
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('type_sessions.edit', $type->id) }}" class="type-action type-action-edit">Modifier</a>
                                        <form method="POST" action="{{ route('type_sessions.destroy', $type->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="type-action type-action-delete">Supprimer</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layouts::app.sidebar>