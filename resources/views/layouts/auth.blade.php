{{--
    USAGE : @extends('layouts.auth')  @section('title','...') @section('form') ... @endsection
    Paramètres optionnels via @section('panel-*')
--}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AGesp') — Auto-École GESP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
    /* ════════════════════════════════════════════════════
       VARIABLES & RESET
    ════════════════════════════════════════════════════ */
    :root {
        --v  : #1a6b3a;
        --vc : #22883f;
        --vd : #0e4525;
        --vp : #e8f2ec;
        --r  : #c0281e;
        --rd : #8b1a12;
        --rp : #fbeaea;
        --o  : #d4a017;
        --od : #a87c10;
        --op : #fdf8e1;
        --dk : #1a2520;
        --mid: #f0f4f1;
        --brd: #dde5e0;
        --txt: #3a4a40;
        --sub: #6b7a70;
        --rad: 14px;
        --sha: 0 20px 60px rgba(0,0,0,.18);
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family  : 'Source Sans 3', sans-serif;
        background   : var(--mid);
        min-height   : 100vh;
        display      : flex;
        flex-direction: column;
        color        : var(--dk);
    }

    /* ════════════════════════════════════════════════════
       BARRE TRICOLORE TOP
    ════════════════════════════════════════════════════ */
    .tricolor {
        height    : 5px;
        background: linear-gradient(90deg,
            var(--r) 0%,var(--r) 33%,
            var(--o) 33%,var(--o) 66%,
            var(--v) 66%,var(--v) 100%);
        flex-shrink: 0;
    }

    /* ════════════════════════════════════════════════════
       WRAPPER CENTRÉ
    ════════════════════════════════════════════════════ */
    .auth-wrap {
        flex           : 1;
        display        : flex;
        align-items    : center;
        justify-content: center;
        padding        : 28px 16px;
    }

    /* ════════════════════════════════════════════════════
       CARTE PRINCIPALE — SPLIT SCREEN
    ════════════════════════════════════════════════════ */
    .auth-card {
        display              : grid;
        grid-template-columns: 1fr 1fr;
        width                : 920px;
        max-width            : 100%;
        border-radius        : var(--rad);
        overflow             : hidden;
        box-shadow           : var(--sha);
    }

    /* ══ PANNEAU GAUCHE (vert) ══ */
    .panel-left {
        background   : linear-gradient(155deg, #0a2415 0%, var(--v) 45%, #0d3520 100%);
        padding      : 44px 38px;
        display      : flex;
        flex-direction: column;
        position     : relative;
        overflow     : hidden;
    }

    /* Cercles décoratifs */
    .panel-left::before {
        content      : '';
        position     : absolute;
        top          : -70px;
        right        : -70px;
        width        : 240px;
        height       : 240px;
        border-radius: 50%;
        background   : rgba(255,255,255,.04);
        pointer-events: none;
    }
    .panel-left::after {
        content      : '';
        position     : absolute;
        bottom       : -50px;
        left         : -50px;
        width        : 180px;
        height       : 180px;
        border-radius: 50%;
        background   : rgba(255,255,255,.03);
        pointer-events: none;
    }

    /* ── Logo ── */
    .p-logo {
        display    : flex;
        align-items: center;
        gap        : 12px;
        margin-bottom: 32px;
        position   : relative;
        z-index    : 1;
    }

    .p-logo-img {
        width          : 52px;
        height         : 52px;
        background     : white;
        border-radius  : 10px;
        display        : flex;
        align-items    : center;
        justify-content: center;
        overflow       : hidden;
        box-shadow     : 0 4px 14px rgba(0,0,0,.22);
        flex-shrink    : 0;
    }
    .p-logo-img img   { width:88%; height:88%; object-fit:contain; }
    .p-logo-img span  { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.1rem; color:var(--v); }

    .p-logo-name      { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.4rem; color:white; line-height:1.1; }
    .p-logo-name em   { color:var(--o); font-style:normal; }
    .p-logo-sub       { font-size:.68rem; color:rgba(255,255,255,.55); margin-top:2px; letter-spacing:.05em; }

    /* ── Badge espace ── */
    .p-badge {
        display      : inline-flex;
        align-items  : center;
        gap          : 7px;
        background   : rgba(212,160,23,.18);
        border       : 1px solid rgba(212,160,23,.4);
        color        : var(--o);
        padding      : 5px 14px;
        border-radius: 20px;
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : .7rem;
        letter-spacing: .08em;
        text-transform: uppercase;
        margin-bottom: 22px;
        width        : fit-content;
        position     : relative;
        z-index      : 1;
    }

    /* ── Titre & desc ── */
    .p-title {
        font-family : 'Nunito',sans-serif;
        font-weight : 900;
        font-size   : 1.75rem;
        color       : white;
        line-height : 1.2;
        margin-bottom: 12px;
        position    : relative;
        z-index     : 1;
    }
    .p-title em { color:var(--o); font-style:normal; }

    .p-desc {
        font-size   : .83rem;
        color       : rgba(255,255,255,.68);
        line-height : 1.7;
        margin-bottom: 28px;
        position    : relative;
        z-index     : 1;
    }

    /* ── Liste features ── */
    .p-features {
        display      : flex;
        flex-direction: column;
        gap          : 11px;
        margin-top   : auto;
        position     : relative;
        z-index      : 1;
    }
    .p-feat {
        display    : flex;
        align-items: center;
        gap        : 10px;
        font-size  : .8rem;
        color      : rgba(255,255,255,.82);
    }
    .p-feat-dot {
        width        : 8px;
        height       : 8px;
        border-radius: 50%;
        background   : var(--o);
        flex-shrink  : 0;
    }
    .p-feat i {
        font-size  : .85rem;
        color      : var(--o);
        flex-shrink: 0;
    }

    /* ══ PANNEAU DROIT (blanc) ══ */
    .panel-right {
        background   : white;
        padding      : 40px 38px;
        display      : flex;
        flex-direction: column;
        overflow-y   : auto;
        max-height   : 90vh;
    }

    /* ── En-tête form ── */
    .f-eyebrow {
        display      : flex;
        align-items  : center;
        gap          : 8px;
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : .7rem;
        letter-spacing: .1em;
        text-transform: uppercase;
        color        : var(--v);
        margin-bottom: 8px;
    }
    .f-eyebrow::before {
        content      : '';
        display      : inline-block;
        width        : 22px;
        height       : 2px;
        background   : var(--v);
        border-radius: 1px;
    }

    .f-title {
        font-family : 'Nunito',sans-serif;
        font-weight : 900;
        font-size   : 1.75rem;
        color       : var(--dk);
        margin-bottom: 6px;
        line-height : 1.15;
    }

    .f-sub {
        font-size   : .82rem;
        color       : var(--sub);
        margin-bottom: 26px;
        line-height : 1.5;
    }

    /* ── Champs ── */
    .fg { margin-bottom: 16px; }

    .fg label {
        display      : flex;
        align-items  : center;
        gap          : 4px;
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : .73rem;
        color        : var(--dk);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: .04em;
    }
    .fg label .req { color:var(--r); }

    .inp-wrap { position:relative; display:flex; align-items:center; }

    .inp-ico {
        position      : absolute;
        left          : 12px;
        color         : #aab5b0;
        font-size     : .9rem;
        pointer-events: none;
    }

    .inp {
        width        : 100%;
        border       : 1.5px solid var(--brd);
        border-radius: 9px;
        padding      : 11px 12px 11px 36px;
        font-size    : .88rem;
        font-family  : 'Source Sans 3',sans-serif;
        background   : #f9fbfa;
        color        : var(--dk);
        transition   : all .18s;
    }
    .inp:focus {
        border-color: var(--v);
        box-shadow  : 0 0 0 3px rgba(26,107,58,.1);
        background  : white;
        outline     : none;
    }
    .inp.is-invalid { border-color:var(--r); }

    /* Champ sans icône */
    .inp.no-ico { padding-left:12px; }

    /* Œil */
    .inp-eye {
        position  : absolute;
        right     : 12px;
        background: none;
        border    : none;
        color     : #aab5b0;
        cursor    : pointer;
        padding   : 0;
        font-size : .9rem;
        transition: color .15s;
    }
    .inp-eye:hover { color:var(--v); }

    /* Téléphone avec préfixe */
    .phone-wrap { display:flex; }
    .phone-prefix {
        padding      : 11px 13px;
        background   : var(--v);
        color        : var(--o);
        border-radius: 9px 0 0 9px;
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : .86rem;
        border       : 1.5px solid var(--v);
        white-space  : nowrap;
        display      : flex;
        align-items  : center;
        gap          : 4px;
        flex-shrink  : 0;
    }
    .phone-wrap .inp {
        border-radius: 0 9px 9px 0;
        border-left  : none;
        padding-left : 12px;
    }

    /* Force mdp */
    .pwd-bar-wrap { margin-top:5px; }
    .pwd-bar {
        height       : 4px;
        border-radius: 2px;
        background   : var(--brd);
        overflow     : hidden;
        margin-bottom: 3px;
    }
    .pwd-fill { height:100%; border-radius:2px; transition:all .3s; width:0; }
    .pwd-text { font-size:.67rem; }

    /* ── Boutons ── */
    .btn {
        border       : none;
        border-radius: 9px;
        padding      : 12px 22px;
        font-family  : 'Nunito',sans-serif;
        font-weight  : 800;
        font-size    : .9rem;
        cursor       : pointer;
        transition   : all .2s;
        display      : inline-flex;
        align-items  : center;
        justify-content: center;
        gap          : 8px;
        width        : 100%;
        letter-spacing: .02em;
    }
    .btn-primary {
        background: linear-gradient(135deg, var(--v) 0%, var(--vc) 100%);
        color     : white;
        box-shadow: 0 4px 14px rgba(26,107,58,.28);
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, var(--vd) 0%, var(--v) 100%);
        box-shadow: 0 6px 20px rgba(26,107,58,.38);
        transform : translateY(-1px);
    }
    .btn:disabled,
    .btn:disabled:hover {
        background : var(--brd) !important;
        color       : var(--sub) !important;
        box-shadow  : none !important;
        cursor      : not-allowed !important;
        transform   : none !important;
        opacity     : .85;
    }
    .btn-danger {
        background: linear-gradient(135deg, var(--r) 0%, var(--rd) 100%);
        color     : white;
        box-shadow: 0 4px 14px rgba(192,40,30,.25);
    }
    .btn-danger:hover {
        box-shadow: 0 6px 20px rgba(192,40,30,.35);
        transform : translateY(-1px);
    }
    .btn-outline {
        background: transparent;
        color     : var(--v);
        border    : 1.5px solid var(--v) !important;
    }
    .btn-outline:hover { background:var(--vp); }

    .btn-ghost {
        background: var(--mid);
        color     : var(--txt);
        border    : 1.5px solid var(--brd) !important;
    }
    .btn-ghost:hover { background:#e0e8e3; }

    /* ── Séparateur ── */
    .sep {
        display    : flex;
        align-items: center;
        gap        : 10px;
        margin     : 16px 0;
        color      : #b0bdb5;
        font-size  : .72rem;
    }
    .sep hr { flex:1; border:none; border-top:1px solid var(--brd); }

    /* ── Alertes ── */
    .alert {
        border-radius: 8px;
        padding      : 10px 13px;
        font-size    : .8rem;
        margin-bottom: 16px;
        display      : flex;
        align-items  : flex-start;
        gap          : 8px;
        line-height  : 1.5;
    }
    .alert i { flex-shrink:0; margin-top:1px; font-size:.95rem; }
    .alert-err  { background:var(--rp); color:var(--rd); border-left:4px solid var(--r); }
    .alert-ok   { background:var(--vp); color:var(--vd); border-left:4px solid var(--v); }
    .alert-warn { background:var(--op); color:var(--od); border-left:4px solid var(--o); }

    .invalid-msg { font-size:.7rem; color:var(--r); margin-top:4px; display:block; }

    /* ── Pied form ── */
    .f-footer {
        margin-top : auto;
        padding-top: 18px;
        text-align : center;
        font-size  : .7rem;
        color      : #b0bdb5;
    }

    /* Remember / oublié */
    .f-meta {
        display        : flex;
        justify-content: space-between;
        align-items    : center;
        margin-bottom  : 18px;
    }
    .remember-lbl {
        display    : flex;
        align-items: center;
        gap        : 6px;
        font-size  : .78rem;
        color      : var(--sub);
        cursor     : pointer;
    }
    .remember-lbl input { accent-color:var(--v); }
    .forgot-lnk {
        font-size      : .78rem;
        color          : var(--v);
        text-decoration: none;
        font-weight    : 600;
    }
    .forgot-lnk:hover { text-decoration:underline; }

    /* Lien bas de page */
    .f-link-row {
        text-align : center;
        font-size  : .8rem;
        color      : var(--sub);
        margin-top : 14px;
    }
    .f-link-row a {
        color          : var(--v);
        font-weight    : 700;
        text-decoration: none;
    }
    .f-link-row a:hover { text-decoration:underline; }

    /* Code SMS OTP */
    .otp-wrap { display:flex; gap:8px; justify-content:center; margin:6px 0 14px; }
    .otp-digit {
        width        : 48px;
        height       : 56px;
        border       : 1.5px solid var(--brd);
        border-radius: 9px;
        text-align   : center;
        font-size    : 1.5rem;
        font-family  : 'Nunito',sans-serif;
        font-weight  : 800;
        background   : #f9fbfa;
        color        : var(--dk);
        transition   : all .18s;
        outline      : none;
    }
    .otp-digit:focus { border-color:var(--v); box-shadow:0 0 0 3px rgba(26,107,58,.12); background:white; }
    .otp-digit.filled { border-color:var(--v); background:rgba(26,107,58,.05); }

    /* FOOTER PAGE */
    .page-footer {
        background: var(--dk);
        color     : rgba(255,255,255,.4);
        text-align: center;
        padding   : 10px 20px;
        font-size : .7rem;
        flex-shrink: 0;
    }
    .page-footer span { color:var(--o); }

    /* ══ RESPONSIVE ══ */
    @media (max-width: 700px) {
        .auth-card { grid-template-columns:1fr; }
        .panel-left { display:none; }
        .panel-right { padding:28px 22px; max-height:none; }
    }
    </style>
</head>
<body>

<div class="tricolor"></div>

<div class="auth-wrap">
    <div class="auth-card">

        {{-- ══ PANNEAU GAUCHE ══ --}}
        <div class="panel-left">
            {{-- Logo --}}
            <div class="p-logo">
                <div class="p-logo-img">
                    @if(file_exists(public_path('images/logo.jpeg')))
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo AGesp">
                    @elseif(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="Logo AGesp">
                    @else
                        <span>AG</span>
                    @endif
                </div>
                <div>
                    <div class="p-logo-name">A<em>G</em>esp</div>
                    <div class="p-logo-sub">CCI-BF · Burkina Faso</div>
                </div>
            </div>

            {{-- Badge --}}
            <div class="p-badge">
                <i class="bi bi-shield-fill-check"></i>
                @yield('panel-badge', 'Espace sécurisé')
            </div>

            {{-- Titre --}}
            <h2 class="p-title">@yield('panel-title', 'Bienvenue sur votre <em>espace</em> AGesp')</h2>

            <p class="p-desc">@yield('panel-desc', 'Accédez à la gestion complète de l\'Auto-École GESP — candidats, formations, examens et ressources en toute sécurité.')</p>

            {{-- Features --}}
            <div class="p-features">
                @yield('panel-features',
                    '<div class="p-feat"><i class="bi bi-people-fill"></i> Gestion des candidats et inscriptions</div>
                     <div class="p-feat"><i class="bi bi-book-fill"></i> Suivi des formations et sessions</div>
                     <div class="p-feat"><i class="bi bi-clipboard2-check-fill"></i> Programmation et résultats d\'examens</div>
                     <div class="p-feat"><i class="bi bi-award-fill"></i> Paiements, reçus et attestations</div>
                     <div class="p-feat"><i class="bi bi-lock-fill"></i> Accès sécurisé à votre espace</div>'
                )
            </div>
        </div>

        {{-- ══ PANNEAU DROIT ══ --}}
        <div class="panel-right">
            @yield('form')

            <div class="f-footer">
                <i class="bi bi-shield-lock" style="color:var(--v);margin-right:4px;"></i>
                Connexion sécurisée — © {{ date('Y') }} <strong style="color:var(--dk);">AGesp</strong> · Tous droits réservés
            </div>
        </div>

    </div>
</div>

<div class="page-footer">
    © {{ date('Y') }} <span>AGesp</span> — Auto-École GESP · CCI-BF · Burkina Faso
</div>

@stack('scripts')
</body>
</html>