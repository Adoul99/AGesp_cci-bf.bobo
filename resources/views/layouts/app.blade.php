<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name', 'AGesp') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">

    @livewireStyles

    <style>
    :root {
        --v  : #1a6b3a;
        --vc : #22883f;
        --vp : #e8f2ec;
        --r  : #c0281e;
        --rp : #fbeaea;
        --o  : #d4a017;
        --op : #fdf8e1;
        --sb : #0f2e1c;
        --sh : #183d26;
        --st : #90b8a0;
        --dk : #1a2520;
        --bg : #f3f6f4;
        --sw : 210px;
    }

    *, *::before, *::after { box-sizing:border-box; }
    html { scroll-behavior:smooth; }

    body {
        font-family     : 'Source Sans 3', sans-serif;
        background-color: var(--bg);
        color           : #3a4a40;
        margin          : 0;
        min-height      : 100vh;
        font-size       : 13px;
    }

    h1,h2,h3,h4,h5,h6 {
        font-family: 'Nunito', sans-serif;
        font-weight: 700;
        color      : var(--dk);
    }

    .aw { display:flex; min-height:100vh; }

    /* ══ SIDEBAR ══ */
    .as {
        width         : var(--sw);
        height        : 100vh;   /* ← FIX : était "min-height", empêchait le scroll interne */
        background    : var(--sb);
        display       : flex;
        flex-direction: column;
        position      : fixed;
        top:0; left:0;
        z-index       : 1000;
        box-shadow    : 3px 0 20px rgba(0,0,0,0.28);
        overflow-y    : auto;
        scrollbar-width: thin;
        scrollbar-color: var(--sh) transparent;
        transition    : transform 0.3s ease;
    }

    .as-tri {
        height    : 3px;
        flex-shrink: 0;
        background: linear-gradient(90deg,
            var(--r) 0%,var(--r) 33%,
            var(--o) 33%,var(--o) 66%,
            var(--v) 66%,var(--v) 100%);
    }

    .as-head {
        padding      : 10px;
        border-bottom: 1px solid rgba(255,255,255,0.06);
        display      : flex;
        flex-direction: column;
        gap          : 8px;
    }

    .as-head-top {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
    }

    .as-logo {
        width          : 36px;
        height         : 36px;
        border-radius  : 8px;
        display        : flex;
        align-items    : center;
        justify-content: center;
        font-family    : 'Nunito',sans-serif;
        font-weight    : 900;
        font-size      : 0.75rem;
        color          : var(--sb);
        flex-shrink    : 0;
        overflow       : hidden;
        background     : var(--o);
    }

    .as-logo img {
        width     : 100%;
        height    : 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    .as-name {
        font-family: 'Nunito',sans-serif;
        font-weight: 800;
        font-size  : 0.9rem;
        color      : #fff;
        line-height: 1.2;
    }

    .as-sub { font-size:0.6rem; color:var(--st); }

    .as-grp { padding:6px 0 2px; }

    .as-lbl {
        font-size     : 0.55rem;
        font-weight   : 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color         : rgba(144,184,160,0.4);
        padding       : 0 10px 2px;
        display       : block;
        font-family   : 'Nunito',sans-serif;
    }

    .as-lnk {
        display      : flex;
        align-items  : center;
        gap          : 7px;
        padding      : 5px 10px;
        color        : var(--st);
        font-size    : 0.8rem;
        font-weight  : 500;
        text-decoration: none;
        border-left  : 3px solid transparent;
        transition   : all 0.15s;
        white-space  : nowrap;
        overflow     : hidden;
        text-overflow: ellipsis;
    }

    .as-lnk i {
        font-size : 0.85rem;
        width     : 15px;
        text-align: center;
        opacity   : 0.6;
        flex-shrink: 0;
    }

    .as-lnk:hover {
        background       : var(--sh);
        color            : #fff;
        padding-left     : 13px;
        border-left-color: var(--o);
    }

    .as-lnk:hover i { opacity:1; }

    .as-lnk.active {
        background       : rgba(26,107,58,0.85);
        color            : #fff;
        font-weight      : 700;
        border-left-color: var(--o);
    }

    .as-lnk.active i { opacity:1; }

    .as-foot {
        margin-top : auto;
        padding    : 8px 10px;
        border-top : 1px solid rgba(255,255,255,0.06);
    }

    .as-avatar {
        width          : 28px; height:28px;
        border-radius  : 50%;
        background     : var(--o);
        display        : flex;
        align-items    : center;
        justify-content: center;
        font-family    : 'Nunito',sans-serif;
        font-weight    : 900;
        font-size      : 0.65rem;
        color          : var(--sb);
        flex-shrink    : 0;
    }

    .as-uname  { font-size:0.72rem; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
    .as-uemail { font-size:0.58rem; color:var(--st); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }

    .as-logout {
        width         : 100%;
        background    : rgba(255,255,255,0.06);
        border        : 1px solid rgba(255,255,255,0.08);
        color         : var(--st);
        border-radius : 5px;
        padding       : 4px 8px;
        font-size     : 0.72rem;
        cursor        : pointer;
        display       : flex;
        align-items   : center;
        justify-content: center;
        gap           : 5px;
        margin-top    : 2px;
        transition    : background 0.2s;
    }

    .as-logout:hover { background:rgba(192,40,30,0.3); color:#fff; }

    /* Badge rôle moniteur */
    .role-badge {
        display: inline-flex; align-items: center; gap: 4px;
        background: rgba(212,160,23,0.2); color: var(--o);
        border: 1px solid rgba(212,160,23,0.3);
        border-radius: 20px; padding: 2px 8px;
        font-size: 0.58rem; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.05em;
        margin-top: 3px;
    }

    /* ══ MAIN ══ */
    .am {
        margin-left   : var(--sw);
        flex          : 1;
        display       : flex;
        flex-direction: column;
        min-height    : 100vh;
    }

    /* ══ TOPBAR ══ */
    .at {
        background    : #fff;
        border-bottom : 1px solid rgba(26,107,58,0.1);
        padding       : 8px 20px;
        display       : flex;
        align-items   : center;
        justify-content: space-between;
        position      : sticky;
        top:0; z-index:500;
        box-shadow    : 0 2px 8px rgba(26,107,58,0.07);
    }

    .at-title {
        font-family: 'Nunito',sans-serif;
        font-weight: 800;
        font-size  : 1.05rem;
        color      : var(--dk);
        display    : flex;
        align-items: center;
        gap        : 7px;
        margin     : 0;
    }

    .at-bar {
        width:4px; height:18px;
        border-radius: 3px;
        background: linear-gradient(180deg, var(--r), var(--o) 50%, var(--v));
        flex-shrink: 0;
    }

    .at-date {
        font-size  : 0.68rem;
        color      : #6b7a70;
        background : var(--bg);
        padding    : 3px 10px;
        border-radius: 20px;
        border     : 1px solid rgba(26,107,58,0.12);
    }

    /* ══ CONTENT ══ */
    .ac { padding:1.25rem; flex:1; }

    /* ══ CARDS ══ */
    .card { border:none !important; border-radius:10px !important; box-shadow:0 2px 8px rgba(26,107,58,0.08) !important; background:#fff !important; transition:box-shadow 0.2s,transform 0.2s; }
    .card:hover { box-shadow:0 4px 16px rgba(26,107,58,0.14) !important; transform:translateY(-1px); }
    .card-header { background:transparent !important; border-bottom:1px solid rgba(26,107,58,0.08) !important; padding:0.75rem 1rem !important; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.9rem; color:var(--dk); border-radius:10px 10px 0 0 !important; }
    .card-body { padding:1rem !important; }

    .sc { border-radius:10px !important; padding:1rem !important; color:#fff; position:relative; overflow:hidden; box-shadow:0 3px 12px rgba(0,0,0,0.12) !important; }
    .sc::after { content:''; position:absolute; bottom:-14px; right:-14px; width:56px; height:56px; border-radius:50%; background:rgba(255,255,255,0.1); }
    .sc-ico { width:38px; height:38px; background:rgba(255,255,255,0.18); border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:1.1rem; margin-bottom:8px; }
    .sc-val { font-family:'Nunito',sans-serif; font-size:1.6rem; font-weight:900; line-height:1; }
    .sc-lbl { font-size:0.7rem; opacity:0.85; font-weight:600; margin-top:3px; }
    .sc-v { background:linear-gradient(135deg,#1a6b3a,#22883f) !important; }
    .sc-r { background:linear-gradient(135deg,#c0281e,#e03328) !important; }
    .sc-o { background:linear-gradient(135deg,#a07810,#d4a017) !important; }
    .sc-d { background:linear-gradient(135deg,#1a2520,#3a4a40) !important; }

    .table { font-size:0.82rem; }
    .table thead th { background:var(--vp) !important; color:var(--v) !important; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.68rem; letter-spacing:0.05em; text-transform:uppercase; border-bottom:2px solid rgba(26,107,58,0.15) !important; padding:0.65rem 0.85rem !important; }
    .table tbody tr { border-bottom:1px solid rgba(26,107,58,0.05) !important; transition:background 0.15s; }
    .table tbody tr:hover { background:var(--vp) !important; }
    .table tbody td { padding:0.55rem 0.85rem !important; vertical-align:middle !important; border:none !important; }

    .btn { font-family:'Nunito',sans-serif !important; font-weight:600 !important; border-radius:6px !important; font-size:0.82rem !important; transition:all 0.2s !important; }
    .btn:hover { transform:translateY(-1px); }
    .btn-success,.btn-primary { background:var(--v) !important; border-color:var(--v) !important; color:#fff !important; }
    .btn-success:hover,.btn-primary:hover { background:var(--vc) !important; border-color:var(--vc) !important; }
    .btn-danger { background:var(--r) !important; border-color:var(--r) !important; color:#fff !important; }
    .btn-outline-success { color:var(--v) !important; border-color:var(--v) !important; }
    .btn-outline-success:hover { background:var(--v) !important; color:#fff !important; }
    .btn-outline-danger { color:var(--r) !important; border-color:var(--r) !important; }
    .btn-outline-danger:hover { background:var(--r) !important; color:#fff !important; }
    .btn-warning { background:var(--o) !important; border-color:var(--o) !important; color:var(--dk) !important; }

    .form-control,.form-select { border-radius:6px !important; border:1.5px solid #cdd8d0 !important; font-size:0.85rem !important; background:#f9fbfa !important; }
    .form-control:focus,.form-select:focus { border-color:var(--v) !important; box-shadow:0 0 0 3px rgba(26,107,58,0.12) !important; background:#fff !important; outline:none !important; }
    .form-label { font-family:'Nunito',sans-serif; font-weight:600; font-size:0.78rem; }
    .input-group-text { background:var(--vp) !important; border-color:#cdd8d0 !important; color:var(--v) !important; font-size:0.85rem !important; }

    .badge { font-family:'Nunito',sans-serif; font-weight:600; border-radius:20px !important; padding:0.25em 0.65em !important; font-size:0.68rem !important; }
    .badge.bg-success { background:var(--v) !important; }
    .badge.bg-danger  { background:var(--r) !important; }
    .badge.bg-warning { background:var(--o) !important; color:var(--dk) !important; }
    .badge.bg-success-subtle { background:var(--vp) !important; color:var(--v) !important; }
    .badge.bg-danger-subtle  { background:var(--rp) !important; color:var(--r) !important; }
    .badge.bg-warning-subtle { background:var(--op) !important; color:#7a5800 !important; }

    .alert { border-radius:8px !important; border:none !important; font-size:0.85rem; }
    .alert-success { background:var(--vp) !important; color:var(--v) !important; border-left:4px solid var(--v) !important; }
    .alert-danger  { background:var(--rp) !important; color:var(--r) !important; border-left:4px solid var(--r) !important; }

    .pagination .page-link { color:var(--v) !important; border-color:rgba(26,107,58,0.2) !important; border-radius:5px !important; margin:0 2px; font-family:'Nunito',sans-serif; font-weight:600; font-size:0.82rem; }
    .pagination .page-link:hover { background:var(--vp) !important; }
    .pagination .page-item.active .page-link { background:var(--v) !important; border-color:var(--v) !important; color:#fff !important; }

    .modal-content { border-radius:12px !important; border:none !important; box-shadow:0 8px 40px rgba(0,0,0,0.15) !important; }
    .modal-header { border-radius:12px 12px 0 0 !important; padding:0.85rem 1.2rem !important; }
    .modal-header.bg-success { background:var(--v) !important; }
    .modal-header.bg-danger  { background:var(--r) !important; }
    .modal-footer { border-top:1px solid rgba(26,107,58,0.08) !important; }

    ::-webkit-scrollbar { width:4px; }
    ::-webkit-scrollbar-thumb { background:rgba(26,107,58,0.2); border-radius:3px; }
    ::-webkit-scrollbar-thumb:hover { background:var(--v); }

    @keyframes fadeInUp { from{opacity:0;transform:translateY(10px)} to{opacity:1;transform:translateY(0)} }
    .ac > * { animation:fadeInUp 0.28s ease both; }
    .ac > *:nth-child(1){animation-delay:0.04s}
    .ac > *:nth-child(2){animation-delay:0.08s}
    .ac > *:nth-child(3){animation-delay:0.12s}

    @media (max-width:991.98px) {
        .as { transform:translateX(-100%); }
        .as.show { transform:translateX(0); }
        .am { margin-left:0; }
        .ac { padding:0.85rem; }
    }
    </style>
</head>
<body>

<div class="aw">

{{-- ══ SIDEBAR ══ --}}
<aside class="as" id="agespSidebar">
    <div class="as-tri"></div>

    <div class="as-head">
        <div class="as-head-top">
            <div class="as-logo">
                @if(file_exists(public_path('images/logo.jpeg')) || file_exists(public_path('images/logo.jpg')) || file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" onerror="this.style.display='none';this.parentElement.innerText='AG'">
                @else
                    AG
                @endif
            </div>
            <div style="min-width:0; flex: 1;">
                <div class="as-name">AGesp</div>
                <div class="as-sub">Gestion Auto-École</div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="w-100">
            @csrf
            <button type="submit" class="as-logout">
                <i class="bi bi-box-arrow-right"></i> Déconnexion
            </button>
        </form>
    </div>

    <nav style="flex:1;padding:3px 0;overflow-y:auto;">

        @php $role = auth()->user()->role ?? 'candidat'; @endphp

        {{-- ══ MENU ADMIN ══ --}}
        @if($role === 'admin' || $role === 'superadmin')

            <div class="as-grp">
                <span class="as-lbl">Tableau de bord</span>
                <a href="{{ route('dashboard') }}" class="as-lnk {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Tableau de bord
                </a>
                @php $nbAlertes = \App\Http\Controllers\AlerteController::compterAlertes(); @endphp
                <a href="{{ route('alertes.index') }}" class="as-lnk {{ request()->routeIs('alertes.*') ? 'active' : '' }}" style="display:flex; align-items:center; justify-content:space-between;">
                    <span><i class="bi bi-bell-fill"></i> Alertes</span>
                    @if($nbAlertes > 0)
                        <span style="background:#CE1126; color:white; font-size:0.65rem; font-weight:800; padding:0.1rem 0.5rem; border-radius:50px; min-width:18px; text-align:center;">{{ $nbAlertes }}</span>
                    @endif
                </a>
            </div>

            <div class="as-grp">
                <span class="as-lbl">Candidats</span>
                <a href="{{ route('candidats.index') }}" class="as-lnk {{ request()->routeIs('candidats.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Candidats
                </a>
                <a href="{{ route('inscriptions.index') }}" class="as-lnk {{ request()->routeIs('inscriptions.*') ? 'active' : '' }}">
                    <i class="bi bi-check2-circle"></i> Inscriptions
                </a>
                <a href="{{ route('categorie_permis.index') }}" class="as-lnk {{ request()->routeIs('categorie_permis.*') ? 'active' : '' }}">
                    <i class="bi bi-card-list"></i> Catégories Permis
                </a>
            </div>

            <div class="as-grp">
                <span class="as-lbl">Formation</span>
                <a href="{{ route('formations.index') }}" class="as-lnk {{ request()->routeIs('formations.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark"></i> Formations
                </a>
                <a href="{{ route('lieu_formations.index') }}" class="as-lnk {{ request()->routeIs('lieu_formations.*') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt"></i> Lieux Formation
                </a>
                <a href="{{ route('groupes.index') }}" class="as-lnk {{ request()->routeIs('groupes.*') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3"></i> Groupes
                </a>
                <a href="{{ route('session_formations.index') }}" class="as-lnk {{ request()->routeIs('session_formations.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-week"></i> Sessions Formation
                </a>
                <a href="{{ route('type_sessions.index') }}" class="as-lnk {{ request()->routeIs('type_sessions.*') ? 'active' : '' }}">
                    <i class="bi bi-stack"></i> Types Session
                </a>
            </div>

            <div class="as-grp">
                <span class="as-lbl">Examens</span>
                <a href="{{ route('examens.index') }}" class="as-lnk {{ request()->routeIs('examens.*') ? 'active' : '' }}">
                    <i class="bi bi-pencil-square"></i> Examens
                </a>
                <a href="{{ route('evaluations.index') }}" class="as-lnk {{ request()->routeIs('evaluations.*') ? 'active' : '' }}">
                    <i class="bi bi-star-half"></i> Évaluations
                </a>
                <a href="{{ route('programmations.index') }}" class="as-lnk {{ request()->routeIs('programmations.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> Programmations
                </a>
            </div>

            <div class="as-grp">
                <span class="as-lbl">Administration</span>
                <a href="{{ route('paiements.index') }}" class="as-lnk {{ request()->routeIs('paiements.*') ? 'active' : '' }}">
                    <i class="bi bi-credit-card"></i> Paiements
                </a>
                <a href="{{ route('recus.index') }}" class="as-lnk {{ request()->routeIs('recus.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i> Reçus
                </a>
                <a href="{{ route('attestations.index') }}" class="as-lnk {{ request()->routeIs('attestations.*') ? 'active' : '' }}">
                    <i class="bi bi-award"></i> Attestations
                </a>
                <a href="{{ route('users.index') }}" class="as-lnk {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i> Utilisateurs
                </a>
            </div>

            <div class="as-grp">
                <span class="as-lbl">Ressources</span>
                <a href="{{ route('moniteurs.index') }}" class="as-lnk {{ request()->routeIs('moniteurs.*') ? 'active' : '' }}">
                    <i class="bi bi-person-badge"></i> Moniteurs
                </a>
                <a href="{{ route('vehicules.index') }}" class="as-lnk {{ request()->routeIs('vehicules.*') ? 'active' : '' }}">
                    <i class="bi bi-truck-front"></i> Véhicules
                </a>
            </div>

        {{-- ══ MENU MONITEUR ══ --}}
        @elseif($role === 'moniteur')

            <div class="as-grp">
                <span class="as-lbl">Mon espace</span>
                <a href="{{ route('moniteur.espace') }}" class="as-lnk {{ request()->routeIs('moniteur.espace') ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i> Tableau de bord
                </a>
                @php $nbAlertes = \App\Http\Controllers\AlerteController::compterAlertes(); @endphp
                <a href="{{ route('alertes.index') }}" class="as-lnk {{ request()->routeIs('alertes.*') ? 'active' : '' }}" style="display:flex; align-items:center; justify-content:space-between;">
                    <span><i class="bi bi-bell-fill"></i> Alertes</span>
                    @if($nbAlertes > 0)
                        <span style="background:#CE1126; color:white; font-size:0.65rem; font-weight:800; padding:0.1rem 0.5rem; border-radius:50px; min-width:18px; text-align:center;">{{ $nbAlertes }}</span>
                    @endif
                </a>
            </div>

            <div class="as-grp">
                <span class="as-lbl">Formation</span>
                <a href="{{ route('formations.index') }}" class="as-lnk {{ request()->routeIs('formations.*') ? 'active' : '' }}">
                    <i class="bi bi-journal-bookmark"></i> Formations
                </a>
                <a href="{{ route('lieu_formations.index') }}" class="as-lnk {{ request()->routeIs('lieu_formations.*') ? 'active' : '' }}">
                    <i class="bi bi-geo-alt"></i> Lieux Formation
                </a>
                <a href="{{ route('session_formations.index') }}" class="as-lnk {{ request()->routeIs('session_formations.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-week"></i> Sessions Formation
                </a>
            </div>

            <div class="as-grp">
                <span class="as-lbl">Examens</span>
                <a href="{{ route('examens.index') }}" class="as-lnk {{ request()->routeIs('examens.*') ? 'active' : '' }}">
                    <i class="bi bi-pencil-square"></i> Examens
                </a>
                <a href="{{ route('evaluations.index') }}" class="as-lnk {{ request()->routeIs('evaluations.*') ? 'active' : '' }}">
                    <i class="bi bi-star-half"></i> Évaluations
                </a>
                <a href="{{ route('programmations.index') }}" class="as-lnk {{ request()->routeIs('programmations.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i> Programmations
                </a>
            </div>

        {{-- ══ MENU SECRÉTAIRE ══ --}}
        @elseif($role === 'superviseur')

            <div class="as-grp">
                <span class="as-lbl">Mon espace</span>
                <a href="{{ route('dashboard') }}" class="as-lnk {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Tableau de bord
                </a>
                @php $nbAlertes = \App\Http\Controllers\AlerteController::compterAlertes(); @endphp
                <a href="{{ route('alertes.index') }}" class="as-lnk {{ request()->routeIs('alertes.*') ? 'active' : '' }}" style="display:flex; align-items:center; justify-content:space-between;">
                    <span><i class="bi bi-bell-fill"></i> Alertes</span>
                    @if($nbAlertes > 0)
                        <span style="background:#CE1126; color:white; font-size:0.65rem; font-weight:800; padding:0.1rem 0.5rem; border-radius:50px; min-width:18px; text-align:center;">{{ $nbAlertes }}</span>
                    @endif
                </a>
            </div>

            <div class="as-grp">
                <span class="as-lbl">Candidats</span>
                <a href="{{ route('candidats.index') }}" class="as-lnk {{ request()->routeIs('candidats.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Candidats
                </a>
                <a href="{{ route('inscriptions.index') }}" class="as-lnk {{ request()->routeIs('inscriptions.*') ? 'active' : '' }}">
                    <i class="bi bi-check2-circle"></i> Inscriptions
                </a>
                <a href="{{ route('categorie_permis.index') }}" class="as-lnk {{ request()->routeIs('categorie_permis.*') ? 'active' : '' }}">
                    <i class="bi bi-card-list"></i> Catégories Permis
                </a>
                <a href="{{ route('groupes.index') }}" class="as-lnk {{ request()->routeIs('groupes.*') ? 'active' : '' }}">
                    <i class="bi bi-diagram-3"></i> Groupes
                </a>
            </div>

        @endif

    </nav>

    <div class="as-foot">
        <div style="display:flex;align-items:center;gap:7px;">
            <div class="as-avatar">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
            </div>
            <div style="min-width:0;">
                <div class="as-uname">{{ auth()->user()->name ?? 'Utilisateur' }}</div>
                <div class="as-uemail">{{ auth()->user()->email ?? '' }}</div>
                @if(auth()->user()->role === 'moniteur')
                    <span class="role-badge"><i class="bi bi-person-badge"></i> Moniteur</span>
                @elseif(auth()->user()->role === 'superviseur')
                    <span class="role-badge"><i class="bi bi-eye-fill"></i> Superviseur</span>
                @endif
            </div>
        </div>
    </div>
</aside>

{{-- ══ MAIN ══ --}}
<div class="am">

    <div class="at">
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-sm d-lg-none" id="sidebarToggle"
                    style="background:var(--vp);color:var(--v);border:none;border-radius:6px;padding:4px 8px;">
                <i class="bi bi-list fs-5"></i>
            </button>
            <h1 class="at-title">
                <span class="at-bar"></span>
                {{ $title ?? 'Tableau de bord' }}
            </h1>
        </div>
        <span class="at-date">
            <i class="bi bi-calendar3 me-1"></i>
            {{ now()->locale('fr')->isoFormat('ddd D MMM YYYY') }}
        </span>
    </div>

    <div class="ac">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-3">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{ $slot }}
    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.getElementById('agespSidebar').classList.toggle('show');
    });
</script>

@livewireScripts
@stack('scripts')
</body>
</html>