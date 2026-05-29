<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AGesp') — Auto-École GESP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root { --v : #1a6b3a; --vc : #22883f; --vd : #0e4525; --vp : #e8f2ec; --r : #c0281e; --rd : #8b1a12; --rp : #fbeaea; --o : #d4a017; --od : #a87c10; --op : #fdf8e1; --dk : #1a2520; --mid: #f0f4f1; --brd: #dde5e0; --txt: #3a4a40; --sub: #6b7a70; --rad: 14px; --sha: 0 20px 60px rgba(0,0,0,.18); }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family : 'Source Sans 3', sans-serif; background : var(--mid); min-height : 100vh; display : flex; flex-direction: column; color : var(--dk); }
        .tricolor { height : 5px; background: linear-gradient(90deg, var(--r) 0%,var(--r) 33%, var(--o) 33%,var(--o) 66%, var(--v) 66%,var(--v) 100%); flex-shrink: 0; }
        .auth-wrap { flex : 1; display : flex; align-items : center; justify-content: center; padding : 28px 16px; }
        .auth-card { display : grid; grid-template-columns: 1fr 1fr; width : 920px; max-width : 100%; border-radius : var(--rad); overflow : hidden; box-shadow : var(--sha); }
        .panel-left { background : linear-gradient(155deg, #0a2415 0%, var(--v) 45%, #0d3520 100%); padding : 44px 38px; display : flex; flex-direction: column; position : relative; overflow : hidden; }
        .panel-left::before { content : ''; position : absolute; top : -70px; right : -70px; width : 240px; height : 240px; border-radius: 50%; background : rgba(255,255,255,.04); pointer-events: none; }
        .panel-left::after { content : ''; position : absolute; bottom : -50px; left : -50px; width : 180px; height : 180px; border-radius: 50%; background : rgba(255,255,255,.03); pointer-events: none; }
        .p-logo { display : flex; align-items: center; gap : 12px; margin-bottom: 32px; position : relative; z-index : 1; }
        .p-logo-img { width : 52px; height : 52px; background : white; border-radius : 10px; display : flex; align-items : center; justify-content: center; overflow : hidden; box-shadow : 0 4px 14px rgba(0,0,0,.22); flex-shrink : 0; }
        .p-logo-img img { width:88%; height:88%; object-fit:contain; }
        .p-logo-img span { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.1rem; color:var(--v); }
        .p-logo-name { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.4rem; color:white; line-height:1.1; }
        .p-logo-name em { color:var(--o); font-style:normal; }
        .p-logo-sub { font-size:.68rem; color:rgba(255,255,255,.55); margin-top:2px; letter-spacing:.05em; }
        .p-badge { display : inline-flex; align-items : center; gap : 7px; background : rgba(212,160,23,.18); border : 1px solid rgba(212,160,23,.4); color : var(--o); padding : 5px 14px; border-radius : 20px; font-family : 'Nunito',sans-serif; font-weight : 700; font-size : .7rem; letter-spacing: .08em; text-transform: uppercase; margin-bottom: 22px; width : fit-content; position : relative; z-index : 1; }
        .p-title { font-family : 'Nunito',sans-serif; font-weight : 900; font-size : 1.75rem; color : white; line-height : 1.2; margin-bottom: 12px; position : relative; z-index : 1; }
        .p-title em { color:var(--o); font-style:normal; }
        .p-desc { font-size : .83rem; color : rgba(255,255,255,.68); line-height : 1.7; margin-bottom: 28px; position : relative; z-index : 1; }
        .p-features { display : flex; flex-direction: column; gap : 11px; margin-top : auto; position : relative; z-index : 1; }
        .p-feat { display : flex; align-items: center; gap : 10px; font-size : .8rem; color : rgba(255,255,255,.82); }
        .p-feat i { font-size : .85rem; color : var(--o); }
        .panel-right { background : white; padding : 40px 38px; display : flex; flex-direction: column; overflow-y : auto; max-height : 90vh; }
        .f-footer { margin-top : auto; padding-top: 18px; text-align : center; font-size : .7rem; color : #b0bdb5; }
        .page-footer { background: var(--dk); color : rgba(255,255,255,.4); text-align: center; padding : 10px 20px; font-size : .7rem; flex-shrink: 0; }
        @media (max-width: 700px) { .auth-card { grid-template-columns:1fr; } .panel-left { display:none; } .panel-right { padding:28px 22px; max-height:none; } }
    </style>
</head>
<body>

<div class="tricolor"></div>

<div class="auth-wrap">
    <div class="auth-card">
        <div class="panel-left">
            <div class="p-logo">
                <div class="p-logo-img">
                    @if(file_exists(public_path('images/logo.jpeg')))<img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
                    @elseif(file_exists(public_path('images/logo.png')))<img src="{{ asset('images/logo.png') }}" alt="Logo">
                    @else<span>AG</span>@endif
                </div>
                <div>
                    <div class="p-logo-name">A<em>G</em>esp</div>
                    <div class="p-logo-sub">CCI-BF · Burkina Faso</div>
                </div>
            </div>

            <div class="p-badge">
                <i class="bi bi-shield-fill-check"></i>
                {!! View::hasSection('panel-badge') ? $__env->yieldContent('panel-badge') : 'Espace sécurisé' !!}
            </div>

            <h2 class="p-title">
                {!! View::hasSection('panel-title') ? $__env->yieldContent('panel-title') : 'Bienvenue sur votre <em>espace</em> AGesp' !!}
            </h2>

            <p class="p-desc">
                {!! View::hasSection('panel-desc') ? $__env->yieldContent('panel-desc') : 'Accédez à la gestion complète de l\'Auto-École GESP — candidats, formations, examens et ressources en toute sécurité.' !!}
            </p>

            <div class="p-features">
                {!! View::hasSection('panel-features') ? $__env->yieldContent('panel-features') : 
                    '<div class="p-feat"><div class="p-feat-dot"></div><i class="bi bi-people-fill"></i> Gestion des candidats et inscriptions</div>
                     <div class="p-feat"><div class="p-feat-dot"></div><i class="bi bi-book-fill"></i> Suivi des formations et sessions</div>
                     <div class="p-feat"><div class="p-feat-dot"></div><i class="bi bi-clipboard2-check-fill"></i> Programmation et résultats d\'examens</div>
                     <div class="p-feat"><div class="p-feat-dot"></div><i class="bi bi-award-fill"></i> Paiements, reçus et attestations</div>' 
                !!}
            </div>
        </div>

        <div class="panel-right">
            @yield('form')
            <div class="f-footer">
                <i class="bi bi-shield-lock" style="color:var(--v);margin-right:4px;"></i>
                Connexion sécurisée — © {{ date('Y') }} <strong>AGesp</strong>
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