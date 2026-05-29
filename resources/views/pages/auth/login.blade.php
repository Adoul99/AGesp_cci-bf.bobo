<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion — AGesp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
    :root { --v:#1a6b3a; --vc:#22883f; --vp:#e8f2ec; --r:#c0281e; --o:#d4a017; --dk:#1a2520; }
    *{box-sizing:border-box;margin:0;padding:0;}

    body {
        font-family  : 'Source Sans 3', sans-serif;
        background   : #f0f4f1;
        min-height   : 100vh;
        display      : flex;
        flex-direction: column;
    }

    /* ── BARRE TRICOLORE ── */
    .tricolor {
        height    : 4px;
        background: linear-gradient(90deg,
            var(--r) 0%,var(--r) 33%,
            var(--o) 33%,var(--o) 66%,
            var(--v) 66%,var(--v) 100%);
    }

    /* ── WRAPPER PRINCIPAL ── */
    .login-wrap {
        flex            : 1;
        display         : flex;
        align-items     : center;
        justify-content : center;
        padding         : 30px 20px;
    }

    .login-box {
        display         : grid;
        grid-template-columns: 1fr 1fr;
        width           : 900px;
        max-width       : 100%;
        border-radius   : 16px;
        overflow        : hidden;
        box-shadow      : 0 20px 60px rgba(0,0,0,0.18);
    }

    /* ── CÔTÉ GAUCHE ── */
    .left {
        background      : linear-gradient(160deg, #0a2415 0%, #1a6b3a 40%, #0f3d22 100%);
        padding         : 40px 36px;
        display         : flex;
        flex-direction  : column;
        position        : relative;
        overflow        : hidden;
    }

    /* Motif de fond */
    .left::before {
        content    : '';
        position   : absolute;
        top        : -60px;
        right      : -60px;
        width      : 220px;
        height     : 220px;
        border-radius: 50%;
        background : rgba(255,255,255,0.04);
    }

    .left::after {
        content    : '';
        position   : absolute;
        bottom     : -40px;
        left       : -40px;
        width      : 160px;
        height     : 160px;
        border-radius: 50%;
        background : rgba(255,255,255,0.03);
    }

    /* Logo */
    .left-logo {
        display    : flex;
        align-items: center;
        gap        : 12px;
        margin-bottom: 36px;
        position   : relative;
        z-index    : 1;
    }

    .logo-img {
        width          : 52px;
        height         : 52px;
        background     : white;
        border-radius  : 10px;
        display        : flex;
        align-items    : center;
        justify-content: center;
        overflow       : hidden;
        box-shadow     : 0 4px 12px rgba(0,0,0,0.2);
        flex-shrink    : 0;
    }

    .logo-img img { width:88%; height:88%; object-fit:contain; }
    .logo-img span { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.1rem; color:var(--v); }

    .logo-txt-main {
        font-family: 'Nunito',sans-serif;
        font-weight: 900;
        font-size  : 1.4rem;
        color      : white;
        line-height: 1.1;
    }

    .logo-txt-main span { color:var(--o); }
    .logo-txt-sub { font-size:0.7rem; color:rgba(255,255,255,0.6); margin-top:2px; letter-spacing:0.05em; }

    /* Badge espace */
    .space-badge {
        display        : inline-flex;
        align-items    : center;
        gap            : 7px;
        background     : rgba(212,160,23,0.18);
        border         : 1px solid rgba(212,160,23,0.4);
        color          : var(--o);
        padding        : 6px 14px;
        border-radius  : 20px;
        font-family    : 'Nunito',sans-serif;
        font-weight    : 700;
        font-size      : 0.72rem;
        letter-spacing : 0.08em;
        text-transform : uppercase;
        margin-bottom  : 24px;
        width          : fit-content;
        position       : relative;
        z-index        : 1;
    }

    /* Titre principal gauche */
    .left-title {
        font-family: 'Nunito',sans-serif;
        font-weight: 900;
        font-size  : 1.8rem;
        color      : white;
        line-height: 1.2;
        margin-bottom: 12px;
        position   : relative;
        z-index    : 1;
    }

    .left-title span { color:var(--o); }

    .left-desc {
        font-size    : 0.85rem;
        color        : rgba(255,255,255,0.7);
        line-height  : 1.7;
        margin-bottom: 30px;
        position     : relative;
        z-index      : 1;
    }

    /* Liste features */
    .features {
        display       : flex;
        flex-direction: column;
        gap           : 12px;
        position      : relative;
        z-index       : 1;
        margin-top    : auto;
    }

    .feature-item {
        display    : flex;
        align-items: center;
        gap        : 10px;
        color      : rgba(255,255,255,0.85);
        font-size  : 0.82rem;
    }

    .feature-dot {
        width        : 8px;
        height       : 8px;
        border-radius: 50%;
        background   : var(--o);
        flex-shrink  : 0;
    }

    /* ── CÔTÉ DROIT ── */
    .right {
        background : white;
        padding    : 40px 36px;
        display    : flex;
        flex-direction: column;
    }

    .right-badge {
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : 0.7rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color        : var(--v);
        margin-bottom: 8px;
        display      : flex;
        align-items  : center;
        gap          : 6px;
    }

    .right-badge::before {
        content      : '';
        display      : inline-block;
        width        : 20px;
        height       : 2px;
        background   : var(--v);
        border-radius: 1px;
    }

    .right-title {
        font-family  : 'Nunito',sans-serif;
        font-weight  : 900;
        font-size    : 1.8rem;
        color        : var(--dk);
        margin-bottom: 6px;
    }

    .right-sub {
        font-size    : 0.82rem;
        color        : #6b7a70;
        margin-bottom: 28px;
        line-height  : 1.5;
    }

    /* Formulaire */
    .form-group { margin-bottom:18px; }

    .form-lbl {
        font-family  : 'Nunito',sans-serif;
        font-weight  : 700;
        font-size    : 0.75rem;
        color        : var(--dk);
        margin-bottom: 6px;
        display      : flex;
        align-items  : center;
        gap          : 4px;
    }

    .form-lbl .req { color:var(--r); }

    .inp-wrap {
        position     : relative;
        display      : flex;
        align-items  : center;
    }

    .inp-icon {
        position   : absolute;
        left       : 12px;
        color      : #aab5b0;
        font-size  : 0.9rem;
        pointer-events: none;
    }

    .inp {
        width        : 100%;
        border       : 1.5px solid #dde5e0;
        border-radius: 8px;
        padding      : 11px 12px 11px 36px;
        font-size    : 0.88rem;
        font-family  : 'Source Sans 3',sans-serif;
        background   : #f9fbfa;
        color        : var(--dk);
        transition   : all 0.18s;
    }

    .inp:focus {
        border-color: var(--v);
        box-shadow  : 0 0 0 3px rgba(26,107,58,0.1);
        background  : white;
        outline     : none;
    }

    .inp.is-invalid { border-color:var(--r); }

    /* Mot de passe avec œil */
    .inp-eye {
        position   : absolute;
        right      : 12px;
        background : none;
        border     : none;
        color      : #aab5b0;
        cursor     : pointer;
        padding    : 0;
        font-size  : 0.9rem;
        transition : color 0.15s;
    }

    .inp-eye:hover { color:var(--v); }

    /* Ligne remember + oublié */
    .form-meta {
        display        : flex;
        justify-content: space-between;
        align-items    : center;
        margin-bottom  : 20px;
    }

    .remember-label {
        display    : flex;
        align-items: center;
        gap        : 6px;
        font-size  : 0.78rem;
        color      : #6b7a70;
        cursor     : pointer;
    }

    .remember-label input { accent-color:var(--v); }

    .forgot-link {
        font-size      : 0.78rem;
        color          : var(--v);
        text-decoration: none;
        font-weight    : 600;
    }

    .forgot-link:hover { text-decoration:underline; }

    /* Bouton connexion */
    .btn-login {
        width          : 100%;
        background     : linear-gradient(135deg, var(--v), var(--vc));
        color          : white;
        border         : none;
        border-radius  : 8px;
        padding        : 12px;
        font-family    : 'Nunito',sans-serif;
        font-weight    : 800;
        font-size      : 0.95rem;
        cursor         : pointer;
        transition     : all 0.2s;
        display        : flex;
        align-items    : center;
        justify-content: center;
        gap            : 8px;
        box-shadow     : 0 4px 14px rgba(26,107,58,0.3);
        letter-spacing : 0.02em;
    }

    .btn-login:hover {
        background : linear-gradient(135deg, #155730, var(--v));
        box-shadow : 0 6px 20px rgba(26,107,58,0.4);
        transform  : translateY(-1px);
    }

    /* Séparateur */
    .sep {
        display    : flex;
        align-items: center;
        gap        : 10px;
        margin     : 18px 0;
        color      : #b0bdb5;
        font-size  : 0.72rem;
    }

    .sep hr { flex:1; border:none; border-top:1px solid #e5ede8; }

    /* Bouton s'inscrire */
    .btn-register {
        width          : 100%;
        background     : transparent;
        color          : var(--v);
        border         : 1.5px solid var(--v);
        border-radius  : 8px;
        padding        : 11px;
        font-family    : 'Nunito',sans-serif;
        font-weight    : 700;
        font-size      : 0.88rem;
        cursor         : pointer;
        transition     : all 0.2s;
        display        : flex;
        align-items    : center;
        justify-content: center;
        gap            : 7px;
        text-decoration: none;
    }

    .btn-register:hover {
        background: var(--vp);
        color     : var(--v);
    }

    /* Alerte erreur */
    .alert-err {
        background   : #fbeaea;
        color        : var(--r);
        border-left  : 4px solid var(--r);
        border-radius: 7px;
        padding      : 9px 12px;
        font-size    : 0.78rem;
        margin-bottom: 16px;
        display      : flex;
        align-items  : center;
        gap          : 7px;
    }

    /* Footer */
    .login-footer {
        margin-top   : auto;
        padding-top  : 20px;
        text-align   : center;
        font-size    : 0.68rem;
        color        : #b0bdb5;
    }

    /* FOOTER PAGE */
    .page-footer {
        background  : var(--dk);
        color       : rgba(255,255,255,0.45);
        text-align  : center;
        padding     : 10px 20px;
        font-size   : 0.7rem;
    }

    .page-footer span { color:var(--o); }

    @media (max-width:700px) {
        .login-box { grid-template-columns:1fr; }
        .left { display:none; }
    }
    </style>
</head>
<body>

<div class="tricolor"></div>

<div class="login-wrap">
    <div class="login-box">

        {{-- ── GAUCHE ── --}}
        <div class="left">
            <div class="left-logo">
                <div class="logo-img">
                    @if(file_exists(public_path('images/logo.jpeg')))
                        <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" onerror="this.style.display='none'">
                    @elseif(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" onerror="this.style.display='none'">
                    @else
                        <span>AG</span>
                    @endif
                </div>
                <div>
                    <div class="logo-txt-main">A<span>G</span>esp</div>
                    <div class="logo-txt-sub">CCI-BF · Burkina Faso</div>
                </div>
            </div>

            <div class="space-badge">
                <i class="bi bi-star-fill"></i> ESPACE ADMINISTRATEUR
            </div>

            <h2 class="left-title">
                Bienvenue sur votre<br>
                <span>espace personnel</span>
            </h2>

            <p class="left-desc">
                Accédez à la gestion complète de l'Auto-École GESP —
                candidats, formations, examens et ressources en toute sécurité.
            </p>

            <div class="features">
                <div class="feature-item">
                    <div class="feature-dot"></div>
                    Gestion des candidats et inscriptions
                </div>
                <div class="feature-item">
                    <div class="feature-dot"></div>
                    Suivi des formations et sessions
                </div>
                <div class="feature-item">
                    <div class="feature-dot"></div>
                    Programmation et résultats d'examens
                </div>
                <div class="feature-item">
                    <div class="feature-dot"></div>
                    Paiements, reçus et attestations
                </div>
                <div class="feature-item">
                    <div class="feature-dot"></div>
                    Accès sécurisé à votre tableau de bord
                </div>
            </div>
        </div>

        {{-- ── DROITE ── --}}
        <div class="right">

            <div class="right-badge">Accès sécurisé</div>
            <h1 class="right-title">Connexion</h1>
            <p class="right-sub">Entrez vos identifiants pour accéder à votre espace.</p>

            {{-- Erreurs --}}
            @if ($errors->any())
                <div class="alert-err">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div style="background:#e8f2ec;color:#1a6b3a;border-left:4px solid #1a6b3a;border-radius:7px;padding:9px 12px;font-size:0.78rem;margin-bottom:16px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-lbl">
                        Email <span class="req">*</span>
                    </label>
                    <div class="inp-wrap">
                        <i class="bi bi-envelope inp-icon"></i>
                        <input type="email"
                               name="email"
                               class="inp @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="votre@email.com"
                               required autofocus autocomplete="email">
                    </div>
                </div>

                {{-- Mot de passe --}}
                <div class="form-group">
                    <label class="form-lbl">
                        Mot de passe <span class="req">*</span>
                    </label>
                    <div class="inp-wrap">
                        <i class="bi bi-lock inp-icon"></i>
                        <input type="password"
                               name="password"
                               id="passwordField"
                               class="inp @error('password') is-invalid @enderror"
                               placeholder="••••••••"
                               required autocomplete="current-password">
                        <button type="button" class="inp-eye" onclick="togglePassword()">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                {{-- Remember + oublié --}}
                <div class="form-meta">
                    <label class="remember-label">
                        <input type="checkbox" name="remember"> Se souvenir de moi
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    Se connecter <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <div class="sep">
                <hr> ou <hr>
            </div>

            <a href="{{ route('inscription.public') }}" class="btn-register">
                <i class="bi bi-pencil-square"></i> Vous n'avez pas de compte ? S'inscrire
            </a>

            <div class="login-footer">
                <i class="bi bi-shield-lock me-1" style="color:#1a6b3a;"></i>
                Connexion sécurisée — © {{ date('Y') }} AGesp — Tous droits réservés
            </div>

        </div>
    </div>
</div>

<div class="page-footer">
    © {{ date('Y') }} <span>AGesp</span> — Auto-École GESP · CCI-BF · Burkina Faso
</div>

<script>
function togglePassword() {
    const field = document.getElementById('passwordField');
    const icon  = document.getElementById('eyeIcon');
    if (field.type === 'password') {
        field.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        field.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
</body>
</html>
