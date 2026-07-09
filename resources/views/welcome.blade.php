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
    html { scroll-behavior: smooth; }
    body { font-family:'Source Sans 3',sans-serif; background:#f3f6f4; color:var(--dk); font-size:14px; }

    .tricolor {
        height    : 5px;
        background: linear-gradient(90deg,
            var(--r) 0%,var(--r) 33%,
            var(--o) 33%,var(--o) 66%,
            var(--v) 66%,var(--v) 100%);
    }

    .top-bar {
        background : var(--v);
        box-shadow : 0 2px 10px rgba(0,0,0,0.15);
    }

    .top-bar-inner {
        max-width      : 1300px;
        margin         : 0 auto;
        display        : flex;
        align-items    : center;
        justify-content: space-between;
        gap            : 20px;
        padding        : 10px 24px;
    }

    .top-logo {
        display        : flex;
        align-items    : center;
        gap            : 12px;
        text-decoration: none;
        flex-shrink    : 0;
    }

    .logo-img-box {
        width          : 46px;
        height         : 46px;
        background     : white;
        border-radius  : 50%;
        display        : flex;
        align-items    : center;
        justify-content: center;
        overflow       : hidden;
        flex-shrink    : 0;
    }

    .logo-img-box img { width:82%; height:82%; object-fit:contain; }

    .top-logo-text {
        color      : white;
        font-family: 'Nunito',sans-serif;
        font-weight: 800;
        font-size  : 0.78rem;
        line-height: 1.35;
        letter-spacing: 0.01em;
    }

    .top-nav-links {
        display : flex;
        align-items: center;
        gap     : 30px;
    }

    .top-nav-links a {
        color          : rgba(255,255,255,0.92);
        text-decoration: none;
        font-family    : 'Nunito',sans-serif;
        font-weight    : 700;
        font-size      : 0.78rem;
        letter-spacing : 0.03em;
        white-space    : nowrap;
        transition     : color 0.15s;
    }

    .top-nav-links a:hover { color:var(--o); }

    .top-actions { display:flex; align-items:center; gap:10px; flex-shrink:0; }

    .btn-pill {
        display        : inline-flex;
        align-items    : center;
        gap            : 8px;
        padding        : 9px 20px;
        border-radius  : 999px;
        font-family    : 'Nunito',sans-serif;
        font-weight    : 700;
        font-size      : 0.76rem;
        letter-spacing : 0.02em;
        text-decoration: none;
        white-space    : nowrap;
        transition     : all 0.2s;
        border         : 1.5px solid transparent;
    }

    .btn-pill-solid  { background:white; color:var(--v); }
    .btn-pill-solid:hover { background:var(--op); }

    .btn-pill-outline { background:transparent; color:white; border-color:rgba(255,255,255,0.7); }
    .btn-pill-outline:hover { background:rgba(255,255,255,0.12); }

    .btn-pill-lg { padding:13px 26px; font-size:0.86rem; }

    .btn-pill-outline-light { background:rgba(255,255,255,0.06); color:white; border-color:rgba(255,255,255,0.65); }
    .btn-pill-outline-light:hover { background:rgba(255,255,255,0.18); }

    .btn-pill-disabled {
        opacity     : 0.5;
        cursor      : not-allowed;
        pointer-events: auto;
    }
    .btn-pill-disabled:hover { background:inherit; }

    .hero-banner {
        background-size    : cover;
        background-position: center;
        min-height         : 520px;
        display            : flex;
        align-items        : center;
        padding            : 40px 24px;
    }

    .hero-banner-inner {
        max-width: 900px;
        margin: 0 auto;
        background: rgba(11,47,29,0.28);
        backdrop-filter: blur(2px);
        border-radius: 16px;
        padding: 28px 32px;
    }

    .hero-banner-title {
        font-family: 'Nunito',sans-serif;
        font-weight: 900;
        font-size  : 2.5rem;
        line-height: 1.25;
        color      : white;
        margin-bottom: 20px;
        text-shadow: 0 2px 12px rgba(0,0,0,0.35);
    }

    .hero-banner-title span { color:var(--o); }

    .hero-banner-sub {
        color      : rgba(255,255,255,0.95);
        font-size  : 1rem;
        line-height: 1.7;
        max-width  : 680px;
        margin-bottom: 30px;
        text-shadow: 0 1px 6px rgba(0,0,0,0.3);
    }

    .hero-banner-actions { display:flex; gap:14px; flex-wrap:wrap; }

    .steps-strip {
        max-width : 1100px;
        margin    : -34px auto 0;
        position  : relative;
        z-index   : 2;
        background: white;
        border-radius: 10px;
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        display   : grid;
        grid-template-columns: repeat(3, 1fr);
        padding   : 0 24px;
    }

    .step-item {
        display    : flex;
        align-items: center;
        gap        : 14px;
        padding    : 22px 14px;
    }

    .step-item + .step-item { border-left:1px solid rgba(0,0,0,0.08); }

    .step-num {
        font-family: 'Nunito',sans-serif;
        font-weight: 900;
        font-size  : 1.7rem;
        color      : var(--r);
        flex-shrink: 0;
    }

    .step-label { font-size:0.85rem; color:#3a4a40; font-weight:600; }

    .faq-item {
        border       : 1px solid rgba(26,107,58,0.15);
        border-radius: 8px;
        margin-bottom: 10px;
        overflow     : hidden;
    }

    .faq-item:last-child { margin-bottom:0; }

    .faq-item summary {
        list-style   : none;
        cursor       : pointer;
        padding      : 13px 16px;
        display      : flex;
        align-items  : center;
        justify-content: space-between;
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : 0.85rem;
        color        : var(--dk);
    }

    .faq-item summary::-webkit-details-marker { display:none; }

    .faq-item summary i { color:var(--v); transition:transform 0.2s; flex-shrink:0; }
    .faq-item[open] summary i { transform:rotate(180deg); }

    .faq-item p {
        padding   : 0 16px 15px;
        font-size : 0.8rem;
        line-height: 1.65;
        color     : #5a6b60;
    }

    .help-banner {
        max-width : 1180px;
        margin    : 24px auto 0;
        background: linear-gradient(120deg, var(--v), var(--vc));
        border-radius: 10px;
        padding   : 26px 30px;
        display   : flex;
        align-items: center;
        justify-content: space-between;
        gap       : 20px;
        flex-wrap : wrap;
    }

    .help-banner-text { display:flex; align-items:center; gap:16px; color:white; }

    .help-banner-icon {
        width          : 46px;
        height         : 46px;
        border-radius  : 50%;
        background     : rgba(255,255,255,0.15);
        display        : flex;
        align-items    : center;
        justify-content: center;
        font-size      : 1.3rem;
        flex-shrink    : 0;
    }

    .help-banner-title { font-family:'Nunito',sans-serif; font-weight:800; font-size:1.05rem; margin-bottom:4px; }
    .help-banner-desc  { font-size:0.82rem; opacity:0.92; max-width:520px; line-height:1.55; }

    .site-body {
        max-width: 1180px;
        margin   : 0 auto;
        padding  : 28px 20px;
        display  : grid;
        grid-template-columns: 1fr 300px;
        gap      : 22px;
        align-items: start;
    }

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

    .col-center { display:flex; flex-direction:column; gap:14px; }

    .main-card {
        background   : white;
        border-radius: 8px;
        box-shadow   : 0 1px 6px rgba(26,107,58,0.1);
        overflow     : hidden;
        scroll-margin-top: 20px;
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

    .col-right { display:flex; flex-direction:column; gap:12px; }

    .login-card {
        background   : white;
        border-radius: 8px;
        box-shadow   : 0 1px 6px rgba(26,107,58,0.1);
        overflow     : hidden;
    }

    .login-head {
        background   : var(--r);
        color        : white;
        padding      : 12px 16px;
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : 0.95rem;
        display      : flex;
        align-items  : center;
        gap          : 6px;
    }

    .login-body { padding:22px; }

    .lbl {
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : 0.85rem;
        color        : var(--dk);
        margin-bottom: 6px;
        display      : block;
    }

    .inp {
        width        : 100%;
        border       : 1.5px solid #cdd8d0;
        border-radius: 6px;
        padding      : 12px 14px;
        font-size    : 0.95rem;
        background   : #f9fbfa;
        font-family  : 'Source Sans 3',sans-serif;
        margin-bottom: 16px;
        transition   : border-color 0.2s;
    }

    .inp:focus {
        border-color: var(--v);
        box-shadow  : 0 0 0 2px rgba(26,107,58,0.1);
        background  : white;
        outline     : none;
    }

    textarea.inp { resize:vertical; min-height:80px; }

    .btn-connexion {
        width        : 100%;
        background   : var(--v);
        color        : white;
        border       : none;
        border-radius: 6px;
        padding      : 13px;
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : 0.9rem;
        cursor       : pointer;
        transition   : background 0.2s;
        display      : flex;
        align-items  : center;
        justify-content: center;
        gap          : 6px;
    }

    .btn-connexion:hover { background:var(--vc); }

    .site-footer {
        background : var(--dk);
        color      : rgba(255,255,255,0.6);
        text-align : center;
        padding    : 12px 20px;
        font-size  : 0.72rem;
        margin-top : 20px;
    }

    .site-footer span { color:var(--o); }

    html, body { overflow-x: hidden; }

    .col-center, .main-card, .main-card-body { min-width: 0; }

    .gallery-frame {
        margin       : 0;
        padding      : 10px;
        background   : var(--vp);
        border       : 1px solid rgba(26,107,58,0.15);
        border-radius: 10px;
    }

    .gallery-viewport {
        overflow     : hidden;
        min-width    : 0;
        -webkit-mask-image: linear-gradient(90deg, transparent 0, #000 24px, #000 calc(100% - 24px), transparent 100%);
                mask-image: linear-gradient(90deg, transparent 0, #000 24px, #000 calc(100% - 24px), transparent 100%);
    }

    .gallery-track {
        display    : flex;
        gap        : 14px;
        width      : max-content;
        animation  : gallery-scroll 34s linear infinite;
    }

    .gallery-viewport:hover .gallery-track { animation-play-state: paused; }

    .gallery-item {
        position     : relative;
        flex-shrink  : 0;
        width        : 260px;
        height       : 170px;
        border-radius: 8px;
        overflow     : hidden;
        background   : #ffffff;
        border       : 1px solid rgba(26,107,58,0.15);
    }

    .gallery-item img {
        width     : 100%;
        height    : 100%;
        object-fit: cover;
        display   : block;
    }

    .gallery-caption {
        position  : absolute;
        left:0; right:0; bottom:0;
        padding   : 16px 10px 7px;
        background: linear-gradient(0deg, rgba(10,20,15,0.82) 0%, transparent 100%);
        color     : #fff;
        font-family: 'Nunito',sans-serif;
        font-weight: 700;
        font-size : 0.72rem;
        letter-spacing: 0.02em;
    }

    .gallery-empty {
        display        : flex;
        flex-direction : column;
        align-items    : center;
        justify-content: center;
        gap            : 8px;
        width          : 100%;
        padding        : 28px 10px;
        color          : #6b7a70;
        font-size      : 0.8rem;
        text-align     : center;
    }

    .gallery-empty i { font-size:1.6rem; color:var(--v); opacity:0.5; }

    @keyframes gallery-scroll {
        from { transform: translateX(0); }
        to   { transform: translateX(-50%); }
    }

    .contact-cards {
        display              : grid;
        grid-template-columns: repeat(2, 1fr);
        gap                   : 10px;
        margin-bottom         : 16px;
    }

    .contact-card {
        background   : var(--vp);
        border       : 1px solid rgba(26,107,58,0.15);
        border-radius: 8px;
        padding      : 16px 12px;
        text-align   : center;
        transition   : transform 0.15s, box-shadow 0.15s;
    }

    .contact-card:hover { transform:translateY(-2px); box-shadow:0 4px 12px rgba(26,107,58,0.12); }

    .contact-card i {
        font-size    : 1.4rem;
        color        : var(--v);
        margin-bottom: 6px;
        display      : block;
    }

    .contact-card-title {
        font-family: 'Nunito',sans-serif;
        font-weight: 800;
        font-size  : 0.8rem;
        color      : var(--dk);
        margin-bottom: 4px;
    }

    .contact-card-detail { font-size:0.75rem; color:#5a6b60; line-height:1.5; }

    .contact-form-title {
        font-family  : 'Nunito',sans-serif;
        font-weight  : 800;
        font-size    : 0.88rem;
        color        : var(--v);
        margin-bottom: 12px;
    }

    @media (max-width:900px) {
        .steps-strip {
            grid-template-columns: 1fr;
            margin: -20px 14px 0;
        }
        .step-item + .step-item { border-left:none; border-top:1px solid rgba(0,0,0,0.08); }

        .help-banner { margin:20px 14px 0; padding:20px; }
        .help-banner-desc { max-width:100%; }
        .site-body {
            grid-template-columns: 1fr;
            padding: 16px 14px;
            gap: 16px;
        }

        .top-bar-inner { padding:10px 14px; gap:12px; flex-wrap:wrap; }
        .top-nav-links { display:none; }
        .top-logo-text { font-size:0.68rem; }
        .logo-img-box { width:38px; height:38px; }
        .btn-pill { padding:7px 14px; font-size:0.7rem; }

        .hero-banner { min-height:420px; padding:32px 18px; }
        .hero-banner-inner { padding:20px 22px; }
        .hero-banner-title { font-size:1.7rem; }
        .hero-banner-sub { font-size:0.88rem; }
        .btn-pill-lg { padding:11px 18px; font-size:0.78rem; }

        .gallery-item { width:210px; height:140px; }
        .contact-cards { grid-template-columns:1fr; }
    }

    @media (max-width:420px) {
        .hero-banner-title { font-size:1.4rem; }
        .gallery-item { width:180px; height:120px; }
    }
    </style>
</head>
<body>

{{-- Barre tricolore --}}
<div class="tricolor"></div>

{{-- ══ BANDEAU / NAVIGATION ══ --}}
<div class="top-bar">
    <div class="top-bar-inner">
        <a href="#" class="top-logo">
            <div class="logo-img-box">
                @if(file_exists(public_path('images/logo.jpeg')))
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo CCI-BF"
                         onerror="this.style.display='none'">
                @else
                    <span style="font-family:'Nunito',sans-serif;font-weight:900;font-size:1.1rem;color:#1a6b3a;">AG</span>
                @endif
            </div>
            <div class="top-logo-text">
                <div>CHAMBRE DE COMMERCE</div>
                <div>ET D'INDUSTRIE DU BURKINA FASO</div>
            </div>
        </a>

        <div class="top-nav-links">
            <a href="#presentation">À PROPOS</a>
            <a href="#galerie">GALERIE</a>
            <a href="#faq">FAQ</a>
        </div>

        <div class="top-actions">
            <a href="#" onclick="return false;" class="btn-pill btn-pill-outline btn-pill-disabled"
               title="Les inscriptions sont temporairement fermées">S'INSCRIRE</a>
            <a href="{{ route('login') }}" class="btn-pill btn-pill-solid">CONNEXION</a>
        </div>
    </div>
</div>

{{-- ══ HERO ══ --}}
{{--
    Overlay allégé : dégradé teinté vert CCI-BF (au lieu de noir), concentré
    surtout à gauche/en bas là où le texte se trouve, pour laisser le reste
    de la photo (le camion, le décor) bien visible et lumineux.
    Le bloc de texte a en plus son propre fond semi-transparent avec léger
    flou (backdrop-filter) pour rester parfaitement lisible sans assombrir
    toute l'image.
--}}
<div class="hero-banner" style="background-image:
    linear-gradient(100deg, rgba(11,47,29,0.55) 0%, rgba(11,47,29,0.32) 40%, rgba(11,47,29,0.08) 65%, rgba(11,47,29,0.02) 85%),
    linear-gradient(0deg, rgba(11,47,29,0.25) 0%, rgba(11,47,29,0.02) 40%),
    url('{{ $heroImage }}');">
    <div class="hero-banner-inner">
        <h1 class="hero-banner-title">
            AGesP — la plateforme de gestion de
            <span>l'Auto-École GESP</span>
        </h1>
        <p class="hero-banner-sub">
            Inscription, formation, examens et certification des candidats aux
            permis professionnels D et E, sous l'égide de la Chambre de Commerce
            et d'Industrie du Burkina Faso (CCI-BF).
        </p>
        <div class="hero-banner-actions">
            <a href="#" onclick="return false;" class="btn-pill btn-pill-solid btn-pill-lg btn-pill-disabled"
               title="Les inscriptions sont temporairement fermées">
                S'inscrire maintenant <i class="bi bi-arrow-right"></i>
            </a>
            <a href="#galerie" class="btn-pill btn-pill-outline-light btn-pill-lg">
                Voir la galerie <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

{{-- ══ 3 ÉTAPES ══ --}}
<div class="steps-strip">
    <div class="step-item">
        <div class="step-num">1</div>
        <div class="step-label">S'inscrire gratuitement en ligne</div>
    </div>
    <div class="step-item">
        <div class="step-num">2</div>
        <div class="step-label">Constituer rapidement son dossier</div>
    </div>
    <div class="step-item">
        <div class="step-num">3</div>
        <div class="step-label">Suivre sa formation et ses résultats</div>
    </div>
</div>

{{-- ══ CORPS ══ --}}
<div class="site-body">

    {{-- ── CENTRE ── --}}
    <div class="col-center" id="presentation">

        {{-- Présentation --}}
        <div class="main-card">
            <div class="main-card-head">
                <i class="bi bi-info-circle"></i>
                À propos de la plateforme
            </div>
            <div class="main-card-body">
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

        {{-- Galerie : candidats en formation (créneau / conduite) --}}
        <div class="main-card" id="galerie">
            <div class="main-card-head">
                <i class="bi bi-images"></i>
                Nos candidats en formation
            </div>
            <div class="main-card-body">
                @if(count($galleryImages) > 0)
                    <div class="gallery-frame">
                        <div class="gallery-viewport">
                            <div class="gallery-track">
                                @foreach ([...$galleryImages, ...$galleryImages] as $photo)
                                    <div class="gallery-item">
                                        <img src="{{ $photo['url'] }}" alt="{{ $photo['caption'] }}" loading="lazy">
                                        <div class="gallery-caption">{{ $photo['caption'] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="gallery-empty">
                        <i class="bi bi-camera"></i>
                        <span>
                            Les photos des candidats en séance de créneau et de conduite
                            seront bientôt affichées ici.
                        </span>
                    </div>
                @endif
            </div>
        </div>

        {{-- FAQ --}}
        <div class="main-card" id="faq">
            <div class="main-card-head">
                <i class="bi bi-question-circle"></i>
                Questions fréquentes
            </div>
            <div class="main-card-body">
                <details class="faq-item">
                    <summary>Comment m'inscrire sur AGesP ? <i class="bi bi-chevron-down"></i></summary>
                    <p>Cliquez sur « S'inscrire », remplissez le formulaire en plusieurs étapes et joignez les pièces demandées (CNIB, photo d'identité, certificat médical, acte de naissance).</p>
                </details>
                <details class="faq-item">
                    <summary>Puis-je modifier mon dossier après l'avoir soumis ? <i class="bi bi-chevron-down"></i></summary>
                    <p>Contactez l'administration via la rubrique Contact ci-dessous ; certaines modifications restent possibles tant que le dossier n'est pas validé.</p>
                </details>
                <details class="faq-item">
                    <summary>Comment se déroulent les paiements ? <i class="bi bi-chevron-down"></i></summary>
                    <p>Les frais de formation doivent être réglés avant le début des cours ; un reçu est généré automatiquement après confirmation du paiement.</p>
                </details>
                <details class="faq-item">
                    <summary>La plateforme est-elle sécurisée ? <i class="bi bi-chevron-down"></i></summary>
                    <p>Oui, l'accès à l'espace administrateur et aux espaces candidats est protégé par authentification, et toute tentative non autorisée est enregistrée.</p>
                </details>
                <details class="faq-item">
                    <summary>Quand connaître les résultats d'examen ? <i class="bi bi-chevron-down"></i></summary>
                    <p>Les résultats du code, du créneau et de la conduite sont communiqués par votre moniteur et disponibles depuis votre espace candidat.</p>
                </details>
            </div>
        </div>

    </div>

    {{-- ── DROITE ── --}}
    <div class="col-right">

        {{-- Info sécurité --}}
        <div class="side-card">
            <div class="side-card-head" style="background:var(--o);color:var(--dk);">
                <i class="bi bi-shield-check"></i> Accès sécurisé
            </div>
            <div class="side-card-body">
                <p style="font-size:0.75rem;color:#3a4a40;line-height:1.6;">
                    Cet espace est réservé au personnel autorisé de l'Auto-École GESP.
                    Toute tentative d'accès non autorisé est enregistrée.
                    Utilisez le bouton « Connexion » en haut de la page pour accéder à votre espace.
                </p>
            </div>
        </div>

    </div>

</div>

{{-- ══ HORAIRES D'OUVERTURE ══ --}}
<div class="help-banner">
    <div class="help-banner-text">
        <div class="help-banner-icon"><i class="bi bi-clock-history"></i></div>
        <div>
            <div class="help-banner-title">Horaires d'ouverture</div>
            <div class="help-banner-desc">
                Nos bureaux sont ouverts du lundi au vendredi, de 7h30 à 16h00.
                Les inscriptions et le suivi des dossiers se font uniquement sur ces créneaux.
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