<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AGesp — Auto-École GESP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
    :root {
        --v  : #1a6b3a;
        --vc : #22883f;
        --vp : #e8f2ec;
        --r  : #c0281e;
        --rp : #fbeaea;
        --o  : #d4a017;
        --op : #fdf8e1;
        --dk : #1a2520;
    }

    * { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Source Sans 3',sans-serif; background:#f3f6f4; color:var(--dk); font-size:14px; }

    /* ══ BARRE TRICOLORE TOP ══ */
    .tricolor {
        height    : 5px;
        background: linear-gradient(90deg,
            var(--r) 0%,var(--r) 33%,
            var(--o) 33%,var(--o) 66%,
            var(--v) 66%,var(--v) 100%);
    }

    /* ══ HEADER BANNER ══ */
    .site-header {
        background: linear-gradient(135deg, #0a1f0f 0%, var(--v) 50%, #0f2e1c 100%);
        padding   : 0;
        position  : relative;
        overflow  : hidden;
    }

    .site-header::before {
        content   : '';
        position  : absolute;
        inset     : 0;
        background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        opacity   : 1;
    }

    .header-inner {
        display        : flex;
        align-items    : center;
        justify-content: space-between;
        padding        : 14px 30px;
        position       : relative;
        z-index        : 1;
    }

    .header-logo {
        display    : flex;
        align-items: center;
        gap        : 14px;
    }

    .logo-img-box {
        width          : 58px;
        height         : 58px;
        background     : white;
        border-radius  : 10px;
        display        : flex;
        align-items    : center;
        justify-content: center;
        overflow       : hidden;
        box-shadow     : 0 2px 12px rgba(0,0,0,0.25);
        flex-shrink    : 0;
    }

    .logo-img-box img {
        width     : 88%;
        height    : 88%;
        object-fit: contain;
    }

    .logo-text-box { color:white; }

    .logo-main {
        font-family: 'Nunito',sans-serif;
        font-weight: 900;
        font-size  : 1.6rem;
        line-height: 1;
        letter-spacing: 0.02em;
    }

    .logo-main span { color:var(--o); }

    .logo-sub {
        font-size  : 0.75rem;
        opacity    : 0.8;
        margin-top : 2px;
        letter-spacing: 0.05em;
    }

    /* Header image droite */
    .header-image {
        display      : flex;
        gap          : 6px;
        align-items  : center;
        opacity      : 0.85;
    }

    .header-img-tile {
        width        : 120px;
        height       : 70px;
        border-radius: 6px;
        overflow     : hidden;
        background   : rgba(255,255,255,0.1);
        display      : flex;
        align-items  : center;
        justify-content: center;
        font-size    : 2rem;
        color        : rgba(255,255,255,0.3);
        border       : 1px solid rgba(255,255,255,0.1);
    }

    /* Slogan sous header */
    .site-slogan {
        background   : linear-gradient(90deg, var(--r), #8b1a12);
        color        : white;
        text-align   : center;
        padding      : 7px 20px;
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : 0.9rem;
        letter-spacing: 0.03em;
    }

    .site-slogan span { color:var(--o); }

    /* ══ NAVBAR ══ */
    .site-nav {
        background   : var(--v);
        padding      : 0 30px;
        display      : flex;
        align-items  : center;
        justify-content: space-between;
        box-shadow   : 0 2px 8px rgba(0,0,0,0.2);
    }

    .nav-links { display:flex; align-items:center; gap:2px; }

    .nav-link-item {
        display        : flex;
        align-items    : center;
        gap            : 6px;
        padding        : 10px 16px;
        color          : rgba(255,255,255,0.85);
        text-decoration: none;
        font-size      : 0.82rem;
        font-weight    : 600;
        font-family    : 'Nunito',sans-serif;
        border-bottom  : 3px solid transparent;
        transition     : all 0.2s;
        white-space    : nowrap;
    }

    .nav-link-item:hover,
    .nav-link-item.active {
        color           : white;
        border-bottom-color: var(--o);
        background      : rgba(255,255,255,0.08);
    }

    .nav-link-item i { font-size:0.9rem; }

    .nav-connexion {
        display        : flex;
        align-items    : center;
        gap            : 7px;
        padding        : 7px 16px;
        background     : var(--o);
        color          : var(--dk);
        text-decoration: none;
        font-size      : 0.82rem;
        font-weight    : 700;
        font-family    : 'Nunito',sans-serif;
        border-radius  : 5px;
        transition     : all 0.2s;
        white-space    : nowrap;
    }

    .nav-connexion:hover {
        background: #e6b020;
        color     : var(--dk);
        transform : translateY(-1px);
    }

    /* ══ CONTENU PRINCIPAL ══ */
    .site-body {
        max-width: 1200px;
        margin   : 0 auto;
        padding  : 20px 20px;
        display  : grid;
        grid-template-columns: 220px 1fr 220px;
        gap      : 16px;
        align-items: start;
    }

    /* ── COLONNE GAUCHE ── */
    .col-left { display:flex; flex-direction:column; gap:12px; }

    .side-card {
        background   : white;
        border-radius: 8px;
        box-shadow   : 0 1px 6px rgba(26,107,58,0.1);
        overflow     : hidden;
    }

    .side-card-head {
        background   : var(--v);
        color        : white;
        padding      : 8px 12px;
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : 0.8rem;
        display      : flex;
        align-items  : center;
        gap          : 6px;
    }

    .side-card-body { padding:12px; }

    .side-stat-item {
        display        : flex;
        justify-content: space-between;
        align-items    : center;
        padding        : 6px 0;
        border-bottom  : 1px solid rgba(26,107,58,0.07);
        font-size      : 0.78rem;
    }

    .side-stat-item:last-child { border-bottom:none; }

    .side-stat-val {
        font-family: 'Nunito',sans-serif;
        font-weight: 800;
        font-size  : 0.95rem;
        color      : var(--v);
    }

    .side-link-item {
        display        : flex;
        align-items    : center;
        gap            : 7px;
        padding        : 7px 0;
        color          : var(--dk);
        text-decoration: none;
        font-size      : 0.78rem;
        border-bottom  : 1px solid rgba(26,107,58,0.07);
        transition     : color 0.15s;
    }

    .side-link-item:last-child { border-bottom:none; }
    .side-link-item:hover { color:var(--v); }
    .side-link-item i { color:var(--v); font-size:0.75rem; }

    /* ── COLONNE CENTRALE ── */
    .col-center { display:flex; flex-direction:column; gap:14px; }

    .main-card {
        background   : white;
        border-radius: 8px;
        box-shadow   : 0 1px 6px rgba(26,107,58,0.1);
        overflow     : hidden;
    }

    .main-card-head {
        background   : var(--vp);
        border-bottom: 2px solid var(--v);
        padding      : 10px 16px;
        font-family  : 'Nunito',sans-serif;
        font-weight  : 800;
        font-size    : 0.92rem;
        color        : var(--v);
        display      : flex;
        align-items  : center;
        gap          : 8px;
    }

    .main-card-body { padding:16px; }

    .main-card-body p {
        font-size  : 0.85rem;
        line-height: 1.7;
        color      : #3a4a40;
        margin-bottom: 10px;
    }

    .main-card-body p:last-child { margin-bottom:0; }

    .highlight-text {
        color      : var(--r);
        font-weight: 700;
    }

    /* Modules grid */
    .modules-grid {
        display              : grid;
        grid-template-columns: repeat(3, 1fr);
        gap                  : 10px;
        margin-top           : 4px;
    }

    .module-item {
        border       : 1px solid rgba(26,107,58,0.15);
        border-radius: 8px;
        padding      : 12px 10px;
        text-align   : center;
        transition   : all 0.2s;
        cursor       : pointer;
        text-decoration: none;
        color        : var(--dk);
    }

    .module-item:hover {
        background  : var(--vp);
        border-color: var(--v);
        color       : var(--v);
        transform   : translateY(-2px);
        box-shadow  : 0 4px 12px rgba(26,107,58,0.12);
    }

    .module-icon {
        font-size    : 1.5rem;
        margin-bottom: 6px;
        display      : block;
    }

    .module-name {
        font-family: 'Nunito',sans-serif;
        font-weight: 700;
        font-size  : 0.72rem;
    }

    /* ── COLONNE DROITE ── */
    .col-right { display:flex; flex-direction:column; gap:12px; }

    /* Formulaire connexion */
    .login-card {
        background   : white;
        border-radius: 8px;
        box-shadow   : 0 1px 6px rgba(26,107,58,0.1);
        overflow     : hidden;
    }

    .login-head {
        background   : var(--r);
        color        : white;
        padding      : 8px 12px;
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : 0.8rem;
        display      : flex;
        align-items  : center;
        gap          : 6px;
    }

    .login-body { padding:14px; }

    .lbl {
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : 0.72rem;
        color        : var(--dk);
        margin-bottom: 4px;
        display      : block;
    }

    .inp {
        width        : 100%;
        border       : 1.5px solid #cdd8d0;
        border-radius: 5px;
        padding      : 7px 9px;
        font-size    : 0.8rem;
        background   : #f9fbfa;
        font-family  : 'Source Sans 3',sans-serif;
        margin-bottom: 10px;
        transition   : border-color 0.2s;
    }

    .inp:focus {
        border-color: var(--v);
        box-shadow  : 0 0 0 2px rgba(26,107,58,0.1);
        background  : white;
        outline     : none;
    }

    .btn-connexion {
        width        : 100%;
        background   : var(--v);
        color        : white;
        border       : none;
        border-radius: 5px;
        padding      : 8px;
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : 0.8rem;
        cursor       : pointer;
        transition   : background 0.2s;
        display      : flex;
        align-items  : center;
        justify-content: center;
        gap          : 6px;
    }

    .btn-connexion:hover { background:var(--vc); }

    /* ══ FOOTER ══ */
    .site-footer {
        background : var(--dk);
        color      : rgba(255,255,255,0.6);
        text-align : center;
        padding    : 12px 20px;
        font-size  : 0.72rem;
        margin-top : 20px;
    }

    .site-footer span { color:var(--o); }

    @media (max-width:900px) {
        .site-body { grid-template-columns:1fr; }
        .col-left,.col-right { display:none; }
        .header-image { display:none; }
    }
    </style>
</head>
<body>

{{-- Barre tricolore --}}
<div class="tricolor"></div>

{{-- ══ HEADER ══ --}}
<div class="site-header">
    <div class="header-inner">
        {{-- Logo --}}
        <div class="header-logo">
            <div class="logo-img-box">
                @if(file_exists(public_path('images/logo.jpeg')))
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo CCI-BF"
                         onerror="this.style.display='none'">
                @elseif(file_exists(public_path('images/logo.jpeg')))
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo CCI-BF"
                         onerror="this.style.display='none'">
                @else
                    <span style="font-family:'Nunito',sans-serif;font-weight:900;font-size:1.2rem;color:#1a6b3a;">AG</span>
                @endif
            </div>
            <div class="logo-text-box">
                <div class="logo-main">A<span>G</span>esP</div>
                <div class="logo-sub">Système de Gestion Auto-École</div>
                <div style="font-size:0.65rem;opacity:0.6;margin-top:1px;letter-spacing:0.04em;">
                    CCI-BF · Burkina Faso
                </div>
            </div>
        </div>

        {{-- Tuiles image droite --}}
        <div class="header-image">
            <div class="header-img-tile">🚗</div>
            <div class="header-img-tile">📋</div>
            <div class="header-img-tile">🎓</div>
        </div>
    </div>

    {{-- Slogan --}}
    <div class="site-slogan">
        Plateforme de Gestion — <span>Auto-École GESP</span> — Formation · Examens · Certification
    </div>
</div>

{{-- ══ NAVBAR ══ --}}
<div class="site-nav">
    <div class="nav-links">
        <a href="#" class="nav-link-item active">
            <i class="bi bi-house"></i> Accueil
        </a>
        <a href="#modules" class="nav-link-item">
            <i class="bi bi-grid"></i> Modules
        </a>
        <a href="#presentation" class="nav-link-item">
            <i class="bi bi-info-circle"></i> À propos
        </a>
        <a href="#contact" class="nav-link-item">
            <i class="bi bi-telephone"></i> Contact
        </a>
    </div>
    <div style="display:flex;align-items:center;gap:8px;">
    <a href="{{ route('register') }}" style="display:flex;align-items:center;gap:6px;padding:7px 14px;background:var(--o);color:var(--dk);text-decoration:none;font-size:0.82rem;font-weight:700;font-family:'Nunito',sans-serif;border-radius:5px;transition:all 0.2s;white-space:nowrap;">
        <i class="bi bi-pencil-square"></i> S'inscrire
    </a>
    <a href="{{ route('login') }}" class="nav-connexion">
        <i class="bi bi-person-circle"></i> Connexion
    </a>
</div>
</div>

{{-- ══ CORPS ══ --}}
<div class="site-body">

    {{-- ── GAUCHE ── --}}
    <div class="col-left">

        {{-- Statistiques --}}
        <div class="side-card">
            <div class="side-card-head">
                <i class="bi bi-bar-chart"></i> Statistiques
            </div>
            <div class="side-card-body">
                <div class="side-stat-item">
                    <span>Candidats inscrits</span>
                    <span class="side-stat-val">—</span>
                </div>
                <div class="side-stat-item">
                    <span>Examens ce mois</span>
                    <span class="side-stat-val">—</span>
                </div>
                <div class="side-stat-item">
                    <span>Formations actives</span>
                    <span class="side-stat-val">—</span>
                </div>
                <div class="side-stat-item">
                    <span>Moniteurs</span>
                    <span class="side-stat-val">—</span>
                </div>
            </div>
        </div>

        {{-- Liens rapides --}}
        <div class="side-card">
            <div class="side-card-head">
                <i class="bi bi-link-45deg"></i> Liens rapides
            </div>
            <div class="side-card-body">
                <a href="{{ route('login') }}" class="side-link-item">
                    <i class="bi bi-chevron-right"></i> Espace administrateur
                </a>
                <a href="#" class="side-link-item">
                    <i class="bi bi-chevron-right"></i> Vérifier une inscription
                </a>
                <a href="#" class="side-link-item">
                    <i class="bi bi-chevron-right"></i> Résultats d'examens
                </a>
                <a href="#contact" class="side-link-item">
                    <i class="bi bi-chevron-right"></i> Nous contacter
                </a>
            </div>
        </div>

    </div>

    {{-- ── CENTRE ── --}}
    <div class="col-center" id="presentation">

        {{-- Présentation --}}
        <div class="main-card">
            <div class="main-card-head">
                <i class="bi bi-info-circle"></i>
                Bienvenue sur AGesp — Système de Gestion Auto-École
            </div>
            <div class="main-card-body">
                <p>
                    La plateforme <strong>« AGesp »</strong> est le système de gestion intégré
                    de l'Auto-École GESP, développé sous l'égide de la
                    <strong>Chambre de Commerce et d'Industrie du Burkina Faso (CCI-BF)</strong>.
                </p>
                <p>
                    Elle permet la gestion complète des candidats, des formations,
                    des examens et des ressources de l'auto-école en toute sécurité.
                </p>
                <p>
                    Période en cours :
                    <span class="highlight-text">{{ now()->locale('fr')->isoFormat('MMMM YYYY') }}</span>
                </p>
                <p>
                    Pour accéder à votre espace, utilisez le formulaire de connexion
                    ou contactez l'administration.
                </p>
            </div>
        </div>

        {{-- Modules --}}
        <div class="main-card" id="modules">
            <div class="main-card-head">
                <i class="bi bi-grid"></i>
                Modules disponibles
            </div>
            <div class="main-card-body">
                <div class="modules-grid">
                    <a href="{{ route('login') }}" class="module-item">
                        <span class="module-icon">👥</span>
                        <div class="module-name">Candidats</div>
                    </a>
                    <a href="{{ route('login') }}" class="module-item">
                        <span class="module-icon">📚</span>
                        <div class="module-name">Formations</div>
                    </a>
                    <a href="{{ route('login') }}" class="module-item">
                        <span class="module-icon">📝</span>
                        <div class="module-name">Examens</div>
                    </a>
                    <a href="{{ route('login') }}" class="module-item">
                        <span class="module-icon">💰</span>
                        <div class="module-name">Paiements</div>
                    </a>
                    <a href="{{ route('login') }}" class="module-item">
                        <span class="module-icon">🏆</span>
                        <div class="module-name">Attestations</div>
                    </a>
                    <a href="{{ route('login') }}" class="module-item">
                        <span class="module-icon">🚗</span>
                        <div class="module-name">Véhicules</div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Contact --}}
        <div class="main-card" id="contact">
            <div class="main-card-head">
                <i class="bi bi-telephone"></i> Contacts
            </div>
            <div class="main-card-body">
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <div style="font-family:'Nunito',sans-serif;font-weight:700;font-size:0.78rem;color:var(--r);margin-bottom:5px;text-transform:uppercase;letter-spacing:0.05em;">E-MAIL</div>
                        <div style="font-size:0.78rem;color:#3a4a40;">contact@gesp.bf</div>
                        <div style="font-size:0.78rem;color:#3a4a40;">admin@gesp.bf</div>
                    </div>
                    <div>
                        <div style="font-family:'Nunito',sans-serif;font-weight:700;font-size:0.78rem;color:var(--r);margin-bottom:5px;text-transform:uppercase;letter-spacing:0.05em;">TÉLÉPHONE</div>
                        <div style="font-size:0.78rem;color:#3a4a40;">+226 25 30 XX XX</div>
                        <div style="font-size:0.78rem;color:#3a4a40;">+226 70 XX XX XX</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── DROITE ── --}}
    <div class="col-right">

        {{-- Formulaire connexion --}}
        <div class="login-card">
            <div class="login-head">
                <i class="bi bi-person-lock"></i> Connexion
            </div>
            <div class="login-body">

                @if ($errors->any())
                    <div style="background:#fbeaea;color:#c0281e;border-left:3px solid #c0281e;border-radius:5px;padding:7px 10px;font-size:0.72rem;margin-bottom:10px;">
                        <i class="bi bi-exclamation-triangle me-1"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <label class="lbl"><i class="bi bi-envelope me-1"></i>Email</label>
                    <input type="email" name="email" class="inp"
                           value="{{ old('email') }}"
                           placeholder="votre@email.com"
                           required autofocus>

                    <label class="lbl"><i class="bi bi-lock me-1"></i>Mot de passe</label>
                    <input type="password" name="password" class="inp"
                           placeholder="••••••••"
                           required>

                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                        <label style="display:flex;align-items:center;gap:5px;font-size:0.7rem;color:#6b7a70;cursor:pointer;">
                            <input type="checkbox" name="remember" style="accent-color:#1a6b3a;"> Se souvenir
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               style="font-size:0.7rem;color:var(--v);text-decoration:none;">
                                Oublié ?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="btn-connexion">
                        <i class="bi bi-box-arrow-in-right"></i> Se connecter
                    </button>
                </form>
            </div>
        </div>

        {{-- Info sécurité --}}
        <div class="side-card">
            <div class="side-card-head" style="background:var(--o);color:var(--dk);">
                <i class="bi bi-shield-check"></i> Accès sécurisé
            </div>
            <div class="side-card-body">
                <p style="font-size:0.75rem;color:#3a4a40;line-height:1.6;">
                    Cet espace est réservé au personnel autorisé de l'Auto-École GESP.
                    Toute tentative d'accès non autorisé est enregistrée.
                </p>
            </div>
        </div>

        {{-- Infos système --}}
        <div class="side-card">
            <div class="side-card-head" style="background:#3a4a40;">
                <i class="bi bi-info-circle"></i> Système
            </div>
            <div class="side-card-body">
                <div class="side-stat-item">
                    <span>Version</span>
                    <span style="font-weight:700;font-size:0.78rem;">AGesp v1.0</span>
                </div>
                <div class="side-stat-item">
                    <span>Année</span>
                    <span style="font-weight:700;font-size:0.78rem;">{{ date('Y') }}</span>
                </div>
                <div class="side-stat-item">
                    <span>Laravel</span>
                    <span style="font-weight:700;font-size:0.78rem;">v{{ app()->version() }}</span>
                </div>
            </div>
        </div>

    </div>

</div>

{{-- ══ FOOTER ══ --}}
<div class="site-footer">
    © {{ date('Y') }} <span>AGesp</span> — Auto-École GESP ·
    Chambre de Commerce et d'Industrie du Burkina Faso (CCI-BF) ·
    Tous droits réservés
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
