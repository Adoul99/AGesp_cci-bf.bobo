{{-- resources/views/admin/users/index.blade.php --}}

@extends('layouts.app')

@section('content')

<style>
:root { --v:#1a6b3a; --vc:#22883f; --vp:#e8f2ec; --r:#c0281e; --rp:#fbeaea; --o:#d4a017; --op:#fdf8e1; --dk:#1a2520; --sub:#6b7a70; --brd:#dde5e0; }

.page-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:20px; }
.page-title { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.3rem; color:var(--dk); display:flex; align-items:center; gap:10px; }
.page-title i { color:var(--v); }

.btn-create { display:inline-flex; align-items:center; gap:7px; background:var(--v); color:white; padding:9px 18px; border-radius:8px; font-family:'Nunito',sans-serif; font-weight:700; font-size:.82rem; text-decoration:none; transition:all .2s; border:none; cursor:pointer; }
.btn-create:hover { background:var(--vc); color:white; transform:translateY(-1px); }

.alert-ok  { background:var(--vp); color:var(--v); border-left:4px solid var(--v); border-radius:8px; padding:10px 14px; font-size:.82rem; margin-bottom:16px; display:flex; align-items:center; gap:8px; }
.alert-err { background:var(--rp); color:var(--r); border-left:4px solid var(--r); border-radius:8px; padding:10px 14px; font-size:.82rem; margin-bottom:16px; display:flex; align-items:center; gap:8px; }

.filter-card { background:white; border-radius:10px; box-shadow:0 1px 6px rgba(26,107,58,.08); padding:14px 18px; margin-bottom:16px; display:flex; gap:12px; align-items:flex-end; flex-wrap:wrap; }
.filter-group { display:flex; flex-direction:column; gap:5px; }
.filter-group label { font-family:'Nunito',sans-serif; font-weight:700; font-size:.7rem; color:var(--dk); text-transform:uppercase; letter-spacing:.04em; }
.filter-inp { border:1.5px solid var(--brd); border-radius:7px; padding:8px 12px; font-size:.82rem; background:#f9fbfa; color:var(--dk); outline:none; transition:border-color .18s; }
.filter-inp:focus { border-color:var(--v); box-shadow:0 0 0 2px rgba(26,107,58,.1); background:white; }
.btn-filter { background:var(--v); color:white; border:none; border-radius:7px; padding:8px 16px; font-family:'Nunito',sans-serif; font-weight:700; font-size:.8rem; cursor:pointer; display:flex; align-items:center; gap:6px; }
.btn-filter:hover { background:var(--vc); }
.btn-reset { background:#f1f5f9; color:var(--sub); border:1.5px solid var(--brd); border-radius:7px; padding:8px 14px; font-family:'Nunito',sans-serif; font-weight:600; font-size:.8rem; cursor:pointer; text-decoration:none; display:flex; align-items:center; gap:6px; }

.table-card { background:white; border-radius:10px; box-shadow:0 1px 6px rgba(26,107,58,.08); overflow:hidden; }
.table-head { background:var(--vp); border-bottom:2px solid var(--v); padding:12px 18px; font-family:'Nunito',sans-serif; font-weight:700; font-size:.88rem; color:var(--v); display:flex; align-items:center; gap:8px; justify-content:space-between; }
.table-head span { font-size:.75rem; font-weight:600; color:var(--sub); }

table { width:100%; border-collapse:collapse; font-size:.82rem; }
thead th { background:#f8faf9; color:var(--v); font-family:'Nunito',sans-serif; font-weight:700; padding:10px 14px; text-align:left; font-size:.72rem; text-transform:uppercase; letter-spacing:.05em; border-bottom:1px solid var(--brd); }
tbody td { padding:11px 14px; border-bottom:1px solid var(--brd); vertical-align:middle; }
tbody tr:last-child td { border-bottom:none; }
tbody tr:hover td { background:#f9fbfa; }

.user-info { display:flex; align-items:center; gap:10px; }
.user-avatar { width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-family:'Nunito',sans-serif; font-weight:800; font-size:.85rem; flex-shrink:0; }
.avatar-admin    { background:rgba(26,107,58,.15); color:var(--v); }
.avatar-moniteur { background:rgba(212,160,23,.15); color:var(--o); }
.avatar-candidat { background:rgba(192,40,30,.1); color:var(--r); }
.user-name { font-weight:700; color:var(--dk); display:block; font-size:.82rem; }
.user-email { font-size:.72rem; color:var(--sub); }

.badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:20px; font-family:'Nunito',sans-serif; font-weight:700; font-size:.7rem; }
.badge-admin    { background:rgba(26,107,58,.12); color:var(--v); }
.badge-moniteur { background:rgba(212,160,23,.15); color:#9a7010; }
.badge-candidat { background:rgba(192,40,30,.1); color:var(--r); }

.role-form { display:flex; align-items:center; gap:6px; }
.role-select { border:1.5px solid var(--brd); border-radius:6px; padding:5px 8px; font-size:.78rem; background:#f9fbfa; color:var(--dk); outline:none; cursor:pointer; }
.role-select:focus { border-color:var(--v); }
.btn-save { background:var(--v); color:white; border:none; border-radius:6px; padding:5px 10px; font-size:.75rem; cursor:pointer; font-family:'Nunito',sans-serif; font-weight:700; display:flex; align-items:center; gap:4px; }
.btn-save:hover { background:var(--vc); }

.btn-delete { background:var(--rp); color:var(--r); border:1px solid rgba(192,40,30,.2); border-radius:6px; padding:5px 10px; font-size:.75rem; cursor:pointer; font-family:'Nunito',sans-serif; font-weight:700; display:flex; align-items:center; gap:4px; }
.btn-delete:hover { background:var(--r); color:white; }

.empty-state { text-align:center; padding:40px 20px; }
.empty-state i { font-size:2.5rem; color:var(--sub); opacity:.3; margin-bottom:10px; display:block; }
.empty-state p { font-size:.85rem; color:var(--sub); }

.stats-pills { display:flex; gap:8px; margin-bottom:16px; flex-wrap:wrap; }
.stat-pill { background:white; border-radius:8px; padding:8px 16px; box-shadow:0 1px 4px rgba(26,107,58,.08); display:flex; align-items:center; gap:8px; font-size:.78rem; }
.stat-pill strong { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.1rem; }
.stat-pill.green strong { color:var(--v); }
.stat-pill.orange strong { color:var(--o); }
.stat-pill.red strong { color:var(--r); }
</style>

{{-- En-tête --}}
<div class="page-header">
    <div class="page-title">
        <i class="bi bi-people-fill"></i> Gestion des utilisateurs
    </div>
    <a href="{{ route('users.create') }}" class="btn-create">
        <i class="bi bi-person-plus-fill"></i> Nouvel utilisateur
    </a>
</div>

{{-- Alertes --}}
@if(session('success'))
    <div class="alert-ok"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-err"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
@endif

{{-- Stats --}}
<div class="stats-pills">
    <div class="stat-pill green">
        <i class="bi bi-shield-fill-check" style="color:var(--v);"></i>
        <div><strong>{{ $users->where('role','admin')->count() }}</strong><br><span style="color:var(--sub);">Admin(s)</span></div>
    </div>
    <div class="stat-pill orange">
        <i class="bi bi-person-badge-fill" style="color:var(--o);"></i>
        <div><strong>{{ $users->where('role','moniteur')->count() }}</strong><br><span style="color:var(--sub);">Moniteur(s)</span></div>
    </div>
    <div class="stat-pill red">
        <i class="bi bi-person-fill" style="color:var(--r);"></i>
        <div><strong>{{ $users->where('role','candidat')->count() }}</strong><br><span style="color:var(--sub);">Candidat(s)</span></div>
    </div>
    <div class="stat-pill" style="border-left:3px solid var(--v);">
        <i class="bi bi-people" style="color:var(--v);"></i>
        <div><strong>{{ $users->total() }}</strong><br><span style="color:var(--sub);">Total</span></div>
    </div>
</div>

{{-- Filtres --}}
<form method="GET" action="{{ route('users.index') }}">
    <div class="filter-card">
        <div class="filter-group">
            <label><i class="bi bi-search" style="color:var(--v);"></i> Recherche</label>
            <input type="text" name="search" class="filter-inp" placeholder="Nom, email ou téléphone..." value="{{ request('search') }}" style="width:220px;">
        </div>
        <div class="filter-group">
            <label><i class="bi bi-person-badge" style="color:var(--v);"></i> Rôle</label>
            <select name="role" class="filter-inp">
                <option value="">Tous les rôles</option>
                <option value="admin"    {{ request('role')==='admin'    ? 'selected' : '' }}>Admin</option>
                <option value="moniteur" {{ request('role')==='moniteur' ? 'selected' : '' }}>Moniteur</option>
                <option value="candidat" {{ request('role')==='candidat' ? 'selected' : '' }}>Candidat</option>
            </select>
        </div>
        <button type="submit" class="btn-filter"><i class="bi bi-search"></i> Filtrer</button>
        <a href="{{ route('users.index') }}" class="btn-reset"><i class="bi bi-x-circle"></i> Réinitialiser</a>
    </div>
</form>

{{-- Table --}}
<div class="table-card">
    <div class="table-head">
        <span><i class="bi bi-list-ul"></i> Liste des utilisateurs</span>
        <span>{{ $users->total() }} utilisateur(s) trouvé(s)</span>
    </div>

    @if($users->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Utilisateur</th>
                    <th>Téléphone</th>
                    <th>Rôle actuel</th>
                    <th>Changer le rôle</th>
                    <th>Créé le</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td style="color:var(--sub);font-size:.75rem;">{{ $user->id }}</td>

                    <td>
                        <div class="user-info">
                            <div class="user-avatar avatar-{{ $user->role }}">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <span class="user-name">{{ $user->name }}</span>
                                <span class="user-email">{{ $user->email }}</span>
                            </div>
                        </div>
                    </td>

                    <td>{{ $user->telephone ? '+226 '.$user->telephone : '—' }}</td>

                    <td>
                        <span class="badge badge-{{ $user->role }}">
                            <i class="bi {{ $user->role === 'admin' ? 'bi-shield-fill-check' : ($user->role === 'moniteur' ? 'bi-person-badge-fill' : 'bi-person-fill') }}"></i>
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>

                    <td>
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.role', $user) }}" class="role-form">
                                @csrf
                                @method('PATCH')
                                <select name="role" class="role-select">
                                    <option value="admin"    {{ $user->role === 'admin'    ? 'selected' : '' }}>Admin</option>
                                    <option value="moniteur" {{ $user->role === 'moniteur' ? 'selected' : '' }}>Moniteur</option>
                                    <option value="candidat" {{ $user->role === 'candidat' ? 'selected' : '' }}>Candidat</option>
                                </select>
                                <button type="submit" class="btn-save">
                                    <i class="bi bi-check"></i> Sauver
                                </button>
                            </form>
                        @else
                            <span style="font-size:.75rem;color:var(--sub);font-style:italic;">Votre compte</span>
                        @endif
                    </td>

                    <td style="color:var(--sub);font-size:.75rem;">
                        {{ $user->created_at->format('d/m/Y') }}
                    </td>

                    <td>
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', $user) }}"
                                  onsubmit="return confirm('Supprimer {{ $user->name }} ? Cette action est irréversible.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    <i class="bi bi-trash"></i> Supprimer
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Pagination --}}
        <div style="padding:14px 18px;border-top:1px solid var(--brd);">
            {{ $users->withQueryString()->links() }}
        </div>

    @else
        <div class="empty-state">
            <i class="bi bi-people"></i>
            <p>Aucun utilisateur trouvé.</p>
        </div>
    @endif
</div>

@endsection
