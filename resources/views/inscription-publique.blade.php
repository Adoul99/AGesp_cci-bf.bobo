<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire — AGesp Auto-École GESP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --color-red: #CE1126; --color-green: #007A5E; --color-gold: #FCD116;
            --color-red-dark: #A00D20; --color-green-light: #00A572;
            --color-green-dark: #004D3A; --color-gold-dark: #E5B800;
            --color-dark: #1A1A1A; --color-light: #F8F8F8;
            --color-gray-100: #E8E8E8; --color-gray-200: #D1D1D1; --color-gray-500: #666666;
            --shadow-sm: 0 1px 2px rgba(0,0,0,.05); --shadow-md: 0 4px 12px rgba(0,0,0,.10);
            --transition: 300ms ease-in-out; --radius-md: 8px; --radius-lg: 12px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Source Sans 3', sans-serif; background: var(--color-light); color: var(--color-dark); font-size: 14px; }

        .tricolor { height: 5px; background: linear-gradient(90deg, var(--color-red) 0% 33%, var(--color-gold) 33% 66%, var(--color-green) 66% 100%); }

        .site-header { background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%); padding: 16px 30px; display: flex; align-items: center; justify-content: space-between; box-shadow: var(--shadow-md); }
        .logo-box { width: 48px; height: 48px; background: white; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; }
        .logo-box img { width: 88%; height: 88%; object-fit: contain; }
        .site-title { font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 1.3rem; color: white; margin: 0; }
        .site-title span { color: var(--color-gold); }
        .site-subtitle { font-size: .7rem; color: rgba(255,255,255,.7); margin: 0; }
        .header-return { color: rgba(255,255,255,.7); text-decoration: none; font-size: .78rem; transition: color var(--transition); }
        .header-return:hover { color: var(--color-gold); }

        .site-slogan { background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; text-align: center; padding: 12px 20px; font-family: 'Nunito', sans-serif; font-weight: 700; font-size: .9rem; }
        .site-slogan em { color: var(--color-gold); font-style: normal; }

        .site-nav { background: var(--color-green); padding: 0 30px; display: flex; align-items: center; box-shadow: var(--shadow-md); }
        .nav-lnk { display: flex; align-items: center; gap: 6px; padding: 12px 16px; color: rgba(255,255,255,.8); text-decoration: none; font-size: .8rem; font-weight: 600; font-family: 'Nunito', sans-serif; border-bottom: 3px solid transparent; transition: all var(--transition); }
        .nav-lnk:hover, .nav-lnk.active { color: white; border-bottom-color: var(--color-gold); background: rgba(0,0,0,.1); }

        .breadcrumb-bar { background: white; padding: 10px 30px; border-bottom: 1px solid rgba(0,122,94,.15); font-size: .75rem; color: #6b7a70; }
        .breadcrumb-bar a { color: var(--color-green); text-decoration: none; }

        /* STEPPER 5 étapes */
        .stepper-wrap { max-width: 960px; margin: 30px auto 0; padding: 0 20px; }
        .stepper { display: flex; align-items: center; margin-bottom: 30px; background: white; padding: 16px; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); overflow-x: auto; gap: 4px; }
        .step { display: flex; align-items: center; gap: 8px; flex: 1; min-width: 0; }
        .step-num { width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: 'Nunito', sans-serif; font-weight: 800; font-size: .8rem; flex-shrink: 0; transition: all var(--transition); }
        .step-num.done   { background: var(--color-green); color: white; }
        .step-num.active { background: var(--color-gold); color: var(--color-dark); box-shadow: 0 0 0 4px rgba(252,209,22,.25); }
        .step-num.todo   { background: var(--color-gray-100); color: #999; }
        .step-label { font-family: 'Nunito', sans-serif; font-weight: 700; font-size: .72rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .step-label.active { color: var(--color-green); }
        .step-label.done   { color: var(--color-green-dark); }
        .step-label.todo   { color: #999; }
        .step-line { flex: 1; height: 3px; background: var(--color-gray-100); border-radius: 2px; flex-shrink: 0; min-width: 12px; }
        .step-line.done { background: var(--color-green); }

        .form-wrap { max-width: 960px; margin: 0 auto 50px; padding: 0 20px; }
        .form-card { background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-md); overflow: hidden; border: 1px solid var(--color-gray-100); }
        .form-card-head { background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-light) 100%); color: white; padding: 16px 22px; font-family: 'Nunito', sans-serif; font-weight: 700; font-size: 1rem; display: flex; align-items: center; gap: 10px; border-bottom: 3px solid var(--color-gold); }
        .form-card-body { padding: 28px; }

        .section-title { font-family: 'Nunito', sans-serif; font-weight: 800; font-size: .78rem; color: var(--color-dark); text-transform: uppercase; letter-spacing: .1em; margin-bottom: 16px; margin-top: 24px; padding-bottom: 10px; border-bottom: 2px solid var(--color-gold); display: flex; align-items: center; gap: 8px; }
        .section-title:first-of-type { margin-top: 0; }
        .section-title i { color: var(--color-green); font-size: 1rem; }

        .lbl { font-family: 'Nunito', sans-serif; font-weight: 700; font-size: .73rem; color: var(--color-dark); margin-bottom: 6px; display: block; text-transform: uppercase; letter-spacing: .05em; }
        .lbl .req { color: var(--color-red); }

        .inp { width: 100%; border: 2px solid var(--color-gray-200); border-radius: var(--radius-md); padding: 10px 12px; font-size: .85rem; background: #f9fbfa; font-family: 'Source Sans 3', sans-serif; transition: all var(--transition); color: var(--color-dark); }
        .inp:focus { border-color: var(--color-green); box-shadow: 0 0 0 3px rgba(0,122,94,.1); background: white; outline: none; }
        .inp.is-invalid { border-color: var(--color-red); }
        .invalid-msg { font-size: .7rem; color: var(--color-red); margin-top: 4px; display: block; }

        .date-selects-group { display: flex; gap: 8px; }
        .date-selects-group .inp-jour { width: 80px; flex-shrink: 0; }
        .date-selects-group .inp-mois { flex: 1; }
        .date-selects-group .inp-annee { width: 100px; flex-shrink: 0; }

        /* UPLOAD */
        .upload-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 8px; }
        .upload-card { border: 2px dashed var(--color-gray-200); border-radius: var(--radius-lg); padding: 16px 12px; text-align: center; cursor: pointer; transition: all var(--transition); background: #f9fbfa; position: relative; overflow: hidden; }
        .upload-card:hover { border-color: var(--color-green); background: rgba(0,122,94,.04); }
        .upload-card.required-doc { border-color: rgba(206,17,38,.3); }
        .upload-card.has-file { border-color: var(--color-green); border-style: solid; background: rgba(0,122,94,.05); }
        .upload-card.has-error { border-color: var(--color-red); border-style: solid; }
        .upload-card input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%; }
        .upload-icon { font-size: 2rem; margin-bottom: 6px; display: block; color: var(--color-gray-500); transition: color var(--transition); }
        .upload-card:hover .upload-icon, .upload-card.has-file .upload-icon { color: var(--color-green); }
        .upload-card.has-error .upload-icon { color: var(--color-red); }
        .upload-title { font-family: 'Nunito', sans-serif; font-weight: 700; font-size: .75rem; color: var(--color-dark); display: block; margin-bottom: 4px; }
        .upload-badge-required { display: inline-block; font-size: .6rem; padding: 1px 6px; background: rgba(206,17,38,.1); color: var(--color-red); border-radius: 20px; font-weight: 700; margin-bottom: 4px; }
        .upload-badge-optional { display: inline-block; font-size: .6rem; padding: 1px 6px; background: rgba(0,122,94,.1); color: var(--color-green); border-radius: 20px; font-weight: 700; margin-bottom: 4px; }
        .upload-hint { font-size: .65rem; color: var(--color-gray-500); display: block; margin-top: 4px; }
        .upload-filename { font-size: .68rem; color: var(--color-green); margin-top: 6px; display: none; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; padding: 0 4px; }
        .upload-card.has-file .upload-filename { display: block; }
        .upload-check { position: absolute; top: 8px; right: 8px; width: 20px; height: 20px; background: var(--color-green); color: white; border-radius: 50%; display: none; align-items: center; justify-content: center; font-size: .7rem; }
        .upload-card.has-file .upload-check { display: flex; }

        /* ── PAIEMENT ─────────────────────────────────── */
        .paiement-summary {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 2px solid rgba(0,122,94,.25);
            border-radius: var(--radius-lg);
            padding: 20px 24px;
            margin-bottom: 24px;
        }
        .paiement-summary-title {
            font-family: 'Nunito', sans-serif; font-weight: 800; font-size: .9rem;
            color: var(--color-green-dark); margin-bottom: 14px;
            display: flex; align-items: center; gap: 8px;
        }
        .paiement-line {
            display: flex; justify-content: space-between; align-items: center;
            padding: 7px 0; border-bottom: 1px dashed rgba(0,122,94,.2); font-size: .85rem;
        }
        .paiement-line:last-child { border-bottom: none; }
        .paiement-line-label { color: #374151; font-weight: 500; }
        .paiement-line-val { font-weight: 700; color: var(--color-dark); }
        .paiement-total-line {
            display: flex; justify-content: space-between; align-items: center;
            margin-top: 12px; padding-top: 12px;
            border-top: 2px solid rgba(0,122,94,.3);
        }
        .paiement-total-label { font-family: 'Nunito', sans-serif; font-weight: 800; font-size: 1rem; color: var(--color-green-dark); }
        .paiement-total-val { font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 1.3rem; color: var(--color-green); }

        .mode-paiement-grid {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 20px;
        }
        .mode-card {
            border: 2px solid var(--color-gray-200); border-radius: var(--radius-lg);
            padding: 14px 10px; text-align: center; cursor: pointer;
            transition: all var(--transition); background: white; position: relative;
        }
        .mode-card:hover { border-color: var(--color-green); background: rgba(0,122,94,.04); }
        .mode-card.selected { border-color: var(--color-green); background: rgba(0,122,94,.08); }
        .mode-card input[type="radio"] { position: absolute; opacity: 0; width: 0; height: 0; }
        .mode-card-icon { font-size: 1.8rem; margin-bottom: 6px; display: block; color: var(--color-gray-500); }
        .mode-card.selected .mode-card-icon { color: var(--color-green); }
        .mode-card-label { font-family: 'Nunito', sans-serif; font-weight: 700; font-size: .75rem; color: var(--color-dark); display: block; }
        .mode-check { position: absolute; top: 6px; right: 6px; width: 18px; height: 18px; background: var(--color-green); color: white; border-radius: 50%; display: none; align-items: center; justify-content: center; font-size: .65rem; }
        .mode-card.selected .mode-check { display: flex; }

        /* Champs conditionnels selon le mode */
        .paiement-details { display: none; }
        .paiement-details.visible { display: block; }

        .tranche-box {
            background: rgba(252,209,22,.1); border: 1px solid rgba(252,209,22,.5);
            border-radius: var(--radius-md); padding: 14px 16px; margin-top: 12px;
        }
        .tranche-title { font-family: 'Nunito', sans-serif; font-weight: 700; font-size: .8rem; color: #92400E; margin-bottom: 10px; display: flex; align-items: center; gap: 6px; }
        .tranche-options { display: flex; gap: 10px; flex-wrap: wrap; }
        .tranche-btn {
            border: 2px solid rgba(252,209,22,.6); border-radius: 8px;
            padding: 8px 16px; cursor: pointer; font-family: 'Nunito', sans-serif;
            font-weight: 700; font-size: .78rem; background: white; transition: all .18s;
        }
        .tranche-btn:hover, .tranche-btn.selected { background: var(--color-gold); border-color: var(--color-gold-dark); color: var(--color-dark); }

        .info-box { background: rgba(0,122,94,.08); border: 1px solid rgba(0,122,94,.2); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); padding: 14px 16px; font-size: .8rem; color: var(--color-green-dark); margin-bottom: 20px; display: flex; gap: 12px; align-items: flex-start; }
        .info-box i { color: var(--color-green); font-size: 1.1rem; flex-shrink: 0; margin-top: 2px; }

        .info-box-gold { background: rgba(252,209,22,.1); border: 1px solid rgba(252,209,22,.4); border-left: 4px solid var(--color-gold-dark); color: #78350F; }
        .info-box-gold i { color: var(--color-gold-dark); }

        .alert-err { background: rgba(206,17,38,.08); color: var(--color-red-dark); border-left: 4px solid var(--color-red); border-radius: var(--radius-md); padding: 12px 16px; font-size: .8rem; margin-bottom: 18px; }
        .alert-err ul { margin: 6px 0 0 20px; padding: 0; }
        .alert-ok { background: rgba(0,122,94,.1); color: var(--color-green-dark); border-left: 4px solid var(--color-green); border-radius: var(--radius-md); padding: 12px 16px; font-size: .8rem; margin-bottom: 18px; }

        /* RECAP */
        .recap-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid rgba(0,122,94,.1); font-size: .8rem; }
        .recap-row:last-child { border-bottom: none; }
        .recap-label { color: #6b7a70; font-weight: 600; }
        .recap-val { font-weight: 700; color: var(--color-dark); }
        .recap-file-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 16px; }
        .recap-file-item { border: 1px solid var(--color-gray-100); border-radius: var(--radius-md); padding: 10px 12px; display: flex; align-items: center; gap: 8px; font-size: .78rem; }
        .recap-file-item i { font-size: 1.1rem; flex-shrink: 0; }
        .recap-file-item.ok i { color: var(--color-green); }
        .recap-file-item.nok i { color: var(--color-red); }
        .recap-file-name { font-weight: 700; color: var(--color-dark); display: block; font-size: .72rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .recap-file-label { font-size: .65rem; color: var(--color-gray-500); display: block; }

        /* Badge paiement dans récap */
        .recap-paiement-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: rgba(0,122,94,.1); color: var(--color-green-dark);
            padding: .3rem .8rem; border-radius: 20px;
            font-weight: 700; font-size: .8rem;
            border: 1px solid rgba(0,122,94,.2);
        }

        .confirm-box { background: rgba(252,209,22,.12); border: 1px solid var(--color-gold); border-radius: var(--radius-md); padding: 14px 16px; font-size: .8rem; color: var(--color-dark); margin-bottom: 20px; }
        .confirm-box label { display: flex; align-items: flex-start; gap: 10px; cursor: pointer; margin: 0; }
        .confirm-box input[type="checkbox"] { accent-color: var(--color-green); margin-top: 3px; flex-shrink: 0; }

        .btn-wrapper { display: flex; gap: 12px; margin-top: 24px; padding-top: 20px; border-top: 1px solid var(--color-gray-100); }
        .btn-prev, .btn-next, .btn-submit { border: none; border-radius: var(--radius-md); padding: 10px 22px; font-family: 'Nunito', sans-serif; font-weight: 700; font-size: .83rem; cursor: pointer; transition: all var(--transition); display: inline-flex; align-items: center; gap: 8px; text-transform: uppercase; letter-spacing: .05em; }
        .btn-next { background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%); color: white; border: 2px solid var(--color-red); box-shadow: var(--shadow-sm); margin-left: auto; }
        .btn-next:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(206,17,38,.3); }
        .btn-prev { background: var(--color-gray-100); color: var(--color-dark); border: 2px solid var(--color-gray-100); }
        .btn-prev:hover { transform: translateY(-2px); background: var(--color-gray-200); }
        .btn-submit { background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%); color: white; border: 2px solid var(--color-green); margin-left: auto; }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,122,94,.3); }
        .btn-submit:disabled { opacity: .6; cursor: not-allowed; transform: none; }
        .btn-next:disabled {
            opacity: .55; cursor: not-allowed; transform: none; box-shadow: none;
            background: var(--color-gray-200); border-color: var(--color-gray-200); color: var(--color-gray-500);
        }
        .btn-next:disabled:hover { transform: none; box-shadow: none; }

        .site-footer { background: var(--color-dark); color: rgba(255,255,255,.6); text-align: center; padding: 14px 20px; font-size: .75rem; margin-top: 30px; }
        .site-footer span { color: var(--color-gold); font-weight: 700; }

        @media (max-width: 768px) {
            .mode-paiement-grid { grid-template-columns: repeat(2, 1fr); }
            .upload-grid { grid-template-columns: repeat(2, 1fr); }
            .recap-file-grid { grid-template-columns: repeat(2, 1fr); }
            .step-label { display: none; }
        }
    </style>
</head>
<body>

<div class="tricolor"></div>

<div class="site-header">
    <div style="display:flex;align-items:center;gap:14px;">
        <div class="logo-box">
            @if(file_exists(public_path('images/logo.jpeg')))
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
            @elseif(file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            @else
                <span style="font-family:'Nunito',sans-serif;font-weight:900;font-size:1.1rem;color:#007A5E;">AG</span>
            @endif
        </div>
        <div>
            <div class="site-title">A<span>G</span>esp</div>
            <div class="site-subtitle">Système de Gestion Auto-École · CCI-BF</div>
        </div>
    </div>
    <a href="{{ url('/') }}" class="header-return"><i class="bi bi-arrow-left"></i> Retour à l'accueil</a>
</div>

<div class="site-slogan">
    Inscription en ligne — <em>Auto-École GESP</em> — Formulaire candidat
</div>

<div class="site-nav">
    <a href="{{ url('/') }}" class="nav-lnk"><i class="bi bi-house"></i> Accueil</a>
    <a href="#" class="nav-lnk active"><i class="bi bi-pencil-square"></i> S'inscrire</a>
    <a href="{{ route('login') }}" class="nav-lnk"><i class="bi bi-person-circle"></i> Connexion</a>
</div>

<div class="breadcrumb-bar">
    <a href="{{ url('/') }}">Accueil</a> › <strong>Inscription candidat</strong>
</div>

<!-- STEPPER 5 étapes -->
<div class="stepper-wrap">
    <div class="stepper">
        <div class="step">
            <div class="step-num active" id="snum1">1</div>
            <div class="step-label active" id="slbl1">Informations</div>
        </div>
        <div class="step-line" id="sline1"></div>
        <div class="step">
            <div class="step-num todo" id="snum2">2</div>
            <div class="step-label todo" id="slbl2">Inscription</div>
        </div>
        <div class="step-line" id="sline2"></div>
        <div class="step">
            <div class="step-num todo" id="snum3">3</div>
            <div class="step-label todo" id="slbl3">Pièces jointes</div>
        </div>
        <div class="step-line" id="sline3"></div>
        <div class="step">
            <div class="step-num todo" id="snum4">4</div>
            <div class="step-label todo" id="slbl4">Paiement</div>
        </div>
        <div class="step-line" id="sline4"></div>
        <div class="step">
            <div class="step-num todo" id="snum5">5</div>
            <div class="step-label todo" id="slbl5">Récapitulatif</div>
        </div>
    </div>
</div>

<div class="form-wrap">

    <div id="client-error-box" class="alert-err" style="display:none;">
        <i class="bi bi-exclamation-triangle"></i> <strong>Erreur :</strong> <span id="client-error-msg"></span>
    </div>

    @if($errors->any())
    <div class="alert-err">
        <i class="bi bi-exclamation-triangle"></i> <strong>Erreurs de validation :</strong>
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    <form method="POST" action="{{ route('inscription.public.store') }}" id="inscriptionForm" enctype="multipart/form-data">
        @csrf

        {{-- ══════════════════ ÉTAPE 1 — Informations personnelles ══════════════════ --}}
        <div id="step1">
            <div class="form-card">
                <div class="form-card-head"><i class="bi bi-person-fill"></i> Étape 1 — Informations personnelles</div>
                <div class="form-card-body">
                    <div class="info-box"><i class="bi bi-info-circle-fill"></i><div>Remplissez vos informations personnelles. Les champs marqués <strong>*</strong> sont obligatoires.</div></div>

                    <div class="section-title"><i class="bi bi-person"></i> Identité</div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="lbl">Nom <span class="req">*</span></label>
                            <input type="text" id="inp-nom" name="nom" class="inp @error('nom') is-invalid @enderror" value="{{ old('nom') }}" placeholder="Nom de famille" required oninput="updateStep1Button()">
                            @error('nom')<span class="invalid-msg">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="lbl">Prénom <span class="req">*</span></label>
                            <input type="text" id="inp-prenom" name="prenom" class="inp @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" placeholder="Prénom(s)" required oninput="updateStep1Button()">
                            @error('prenom')<span class="invalid-msg">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="lbl">Date de naissance <span class="req">*</span></label>
                            <div class="date-selects-group">
                                <select id="inp-ddn-jour" class="inp inp-jour" aria-label="Jour">
                                    <option value="">JJ</option>
                                    @for($j = 1; $j <= 31; $j++)
                                        <option value="{{ str_pad($j,2,'0',STR_PAD_LEFT) }}" {{ (old('dateNaissance') && intval(explode('-',old('dateNaissance'))[2]??0)===$j)?'selected':'' }}>{{ str_pad($j,2,'0',STR_PAD_LEFT) }}</option>
                                    @endfor
                                </select>
                                <select id="inp-ddn-mois" class="inp inp-mois" aria-label="Mois">
                                    <option value="">Mois</option>
                                    @php $moisNoms=['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre']; @endphp
                                    @foreach($moisNoms as $idx => $moisNom)
                                        <option value="{{ str_pad($idx+1,2,'0',STR_PAD_LEFT) }}" {{ (old('dateNaissance') && intval(explode('-',old('dateNaissance'))[1]??0)===($idx+1))?'selected':'' }}>{{ $moisNom }}</option>
                                    @endforeach
                                </select>
                                <select id="inp-ddn-annee" class="inp inp-annee" aria-label="Année">
                                    <option value="">AAAA</option>
                                    @for($a = date('Y')-21; $a >= date('Y')-80; $a--)
                                        <option value="{{ $a }}" {{ (old('dateNaissance') && intval(explode('-',old('dateNaissance'))[0]??0)===$a)?'selected':'' }}>{{ $a }}</option>
                                    @endfor
                                </select>
                            </div>
                            <input type="hidden" id="inp-ddn" name="dateNaissance" value="{{ old('dateNaissance') }}">
                            @error('dateNaissance')<span class="invalid-msg">{{ $message }}</span>@enderror
                            <span style="font-size:.68rem;color:var(--color-gray-500);margin-top:4px;display:block;"><i class="bi bi-info-circle"></i> Âge minimum requis : 21 ans</span>
                        </div>
                        <div class="col-md-6">
                            <label class="lbl">Lieu de naissance <span class="req">*</span></label>
                            <input type="text" id="inp-lieu" name="lieuNaissance" class="inp @error('lieuNaissance') is-invalid @enderror" value="{{ old('lieuNaissance') }}" placeholder="Ex: Bobo-Dioulasso" required oninput="updateStep1Button()">
                            @error('lieuNaissance')<span class="invalid-msg">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="section-title"><i class="bi bi-telephone"></i> Contact</div>
                    <div class="row g-3 mb-3">

                        {{-- TÉLÉPHONE — pré-rempli depuis le compte --}}
                        <div class="col-md-6">
                            <label class="lbl">
                                Téléphone <span class="req">*</span>
                                @auth
                                    @if(auth()->user()->telephone)
                                        <span style="font-weight:400;font-size:.68rem;color:var(--color-green);text-transform:none;">
                                            <i class="bi bi-lock-fill"></i> Issu de votre compte
                                        </span>
                                    @endif
                                @endauth
                            </label>
                            @auth
                                @if(auth()->user()->telephone)
                                    {{-- Champ grisé, non modifiable --}}
                                    <input type="tel" id="inp-tel" name="telephone"
                                           class="inp"
                                           value="+226 {{ auth()->user()->telephone }}"
                                           readonly
                                           style="background:#f0fdf4;border-color:rgba(0,122,94,.3);color:#374151;cursor:not-allowed;"
                                           required>
                                    <span style="font-size:.65rem;color:var(--color-green);margin-top:3px;display:flex;align-items:center;gap:4px;">
                                        <i class="bi bi-check-circle-fill"></i>
                                        Numéro enregistré lors de la création de votre compte
                                    </span>
                                @else
                                    <input type="tel" id="inp-tel" name="telephone"
                                           class="inp" placeholder="+226 XX XX XX XX"
                                           value="{{ old('telephone') }}" required oninput="updateStep1Button()">
                                @endif
                            @else
                                <input type="tel" id="inp-tel" name="telephone"
                                       class="inp" placeholder="+226 XX XX XX XX"
                                       value="{{ old('telephone') }}" required oninput="updateStep1Button()">
                            @endauth
                            @error('telephone')<span class="invalid-msg">{{ $message }}</span>@enderror
                        </div>

                        {{-- EMAIL — pré-rempli et grisé depuis le compte --}}
                        <div class="col-md-6">
                            <label class="lbl">
                                Email
                                @auth
                                    <span style="font-weight:400;font-size:.68rem;color:var(--color-green);text-transform:none;">
                                        <i class="bi bi-lock-fill"></i> Issu de votre compte
                                    </span>
                                @else
                                    <span style="font-weight:400;font-size:.68rem;color:var(--color-gray-500);text-transform:none;">(Facultatif)</span>
                                @endauth
                            </label>
                            <div style="position:relative;">
                                @auth
                                    {{-- Email du compte, grisé et non modifiable --}}
                                    <input type="email" id="inp-email" name="email"
                                           class="inp"
                                           value="{{ auth()->user()->email }}"
                                           readonly
                                           style="background:#f0fdf4;border-color:rgba(0,122,94,.3);color:#374151;cursor:not-allowed;padding-right:2.5rem;">
                                    <span style="position:absolute;right:.75rem;top:50%;transform:translateY(-50%);color:var(--color-green);font-size:.9rem;pointer-events:none;">
                                        <i class="bi bi-shield-lock-fill"></i>
                                    </span>
                                @else
                                    <input type="email" id="inp-email" name="email"
                                           class="inp" placeholder="votre@email.com"
                                           value="{{ old('email') }}">
                                @endauth
                            </div>
                            @auth
                                <span style="font-size:.65rem;color:var(--color-green);margin-top:3px;display:flex;align-items:center;gap:4px;">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Email de votre compte — ne peut pas être modifié ici
                                </span>
                            @endauth
                            @error('email')<span class="invalid-msg">{{ $message }}</span>@enderror
                        </div>

                    </div>

                    <div class="section-title"><i class="bi bi-credit-card"></i> Permis C actuel (si existant)</div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="lbl">Numéro Permis C</label>
                            {{-- Champ avec préfixe N° automatique --}}
                            <div style="position:relative;">
                                <span style="position:absolute;left:.75rem;top:50%;transform:translateY(-50%);
                                             font-weight:700;color:#374151;font-size:.88rem;pointer-events:none;
                                             z-index:1;">N°</span>
                                <input type="text"
                                       id="inp-num-permis"
                                       class="inp"
                                       value="{{ old('numeroPermisC') ? preg_replace('/^N°/i', '', old('numeroPermisC')) : '' }}"
                                       placeholder="XXXXXXXX"
                                       style="padding-left:2.2rem;"
                                       oninput="formatPermisC(this)">
                            </div>
                            {{-- Champ hidden qui envoie la valeur complète N°XXXX --}}
                            <input type="hidden" id="inp-num-permis-hidden" name="numeroPermisC"
                                   value="{{ old('numeroPermisC') }}">
                            <span style="font-size:.65rem;color:#6b7a70;margin-top:3px;display:block;">
                                <i class="bi bi-info-circle"></i> Le préfixe N° est automatique
                            </span>
                        </div>
                        <div class="col-md-4">
                            <label class="lbl">Date délivrance</label>
                            <input type="date" id="inp-date-permis" name="dateDelivrancePermisC" class="inp" value="{{ old('dateDelivrancePermisC') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="lbl">Lieu délivrance</label>
                            <input type="text" id="inp-lieu-permis" name="lieuDelivrancePermisC" class="inp" value="{{ old('lieuDelivrancePermisC') }}" placeholder="Ex: Bobo">
                        </div>
                    </div>

                    <div class="btn-wrapper" style="border-top:none;padding-top:0;">
                        <button type="button" class="btn-next" id="btn-next-1" onclick="goToStep(2)" disabled>Suivant <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════ ÉTAPE 2 — Inscription & Permis ══════════════════ --}}
        <div id="step2" style="display:none;">
            <div class="form-card">
                <div class="form-card-head"><i class="bi bi-pencil-square"></i> Étape 2 — Inscription & Catégorie de permis</div>
                <div class="form-card-body">
                    <div class="info-box"><i class="bi bi-info-circle-fill"></i><div>Choisissez la catégorie de permis souhaitée et la date de début de formation.</div></div>

                    <div class="section-title"><i class="bi bi-calendar-check"></i> Inscription</div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-12">
                            <label class="lbl">Catégorie de permis <span class="req">*</span></label>
                            <select id="inp-cat" name="categoriePermis_id" class="inp @error('categoriePermis_id') is-invalid @enderror" required onchange="updateStep2Button()">
                                <option value="">-- Choisir une catégorie --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('categoriePermis_id')==$cat->id?'selected':'' }}>
                                        {{ $cat->nomCategorie ?? 'Catégorie '.$cat->id }}
                                        @if($cat->description ?? false) — {{ $cat->description }} @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('categoriePermis_id')<span class="invalid-msg">{{ $message }}</span>@enderror
                        </div>
                        {{-- Date de début formation gérée automatiquement (date du jour) --}}
                        <input type="hidden" id="inp-debut" name="dataDebut_formation" value="{{ old('dataDebut_formation', date('Y-m-d')) }}">
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="lbl">Date d'inscription</label>
                            <input type="date" id="inp-dateinscr" name="dateInscription" class="inp" value="{{ old('dateInscription', date('Y-m-d')) }}">
                        </div>
                    </div>

                    <div class="btn-wrapper">
                        <button type="button" class="btn-prev" onclick="goToStep(1)"><i class="bi bi-arrow-left"></i> Précédent</button>
                        <button type="button" class="btn-next" id="btn-next-2" onclick="goToStep(3)" disabled>Suivant <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════ ÉTAPE 3 — Pièces jointes ══════════════════ --}}
        <div id="step3" style="display:none;">
            <div class="form-card">
                <div class="form-card-head"><i class="bi bi-folder2-open"></i> Étape 3 — Pièces jointes du dossier</div>
                <div class="form-card-body">
                    <div class="info-box"><i class="bi bi-info-circle-fill"></i><div>Formats acceptés : <strong>JPEG, PNG, PDF</strong>. Taille max : <strong>5 Mo</strong> par fichier.</div></div>

                    <div class="section-title"><i class="bi bi-files"></i> Documents à fournir</div>
                    <div class="upload-grid">
                        <div class="upload-card required-doc" id="card-cnib">
                            <div class="upload-check"><i class="bi bi-check"></i></div>
                            <i class="bi bi-person-vcard upload-icon"></i>
                            <span class="upload-title">CNIB</span>
                            <span class="upload-badge-required">Obligatoire</span>
                            <span class="upload-hint">Carte nationale d'identité</span>
                            <input type="file" id="file-cnib" name="cnib" accept=".jpeg,.jpg,.png,.pdf" onchange="handleFileChange(this,'card-cnib','name-cnib')">
                            <span class="upload-filename" id="name-cnib"></span>
                        </div>
                        <div class="upload-card required-doc" id="card-photo">
                            <div class="upload-check"><i class="bi bi-check"></i></div>
                            <i class="bi bi-person-circle upload-icon"></i>
                            <span class="upload-title">Photo Identité</span>
                            <span class="upload-badge-required">Obligatoire</span>
                            <span class="upload-hint">Fond blanc, récente</span>
                            <input type="file" id="file-photo" name="photo_identite" accept=".jpeg,.jpg,.png" onchange="handleFileChange(this,'card-photo','name-photo')">
                            <span class="upload-filename" id="name-photo"></span>
                        </div>
                        <div class="upload-card required-doc" id="card-certif">
                            <div class="upload-check"><i class="bi bi-check"></i></div>
                            <i class="bi bi-heart-pulse upload-icon"></i>
                            <span class="upload-title">Certificat Médical</span>
                            <span class="upload-badge-required">Obligatoire</span>
                            <span class="upload-hint">Apte à conduire</span>
                            <input type="file" id="file-certif" name="certificat_medical" accept=".jpeg,.jpg,.png,.pdf" onchange="handleFileChange(this,'card-certif','name-certif')">
                            <span class="upload-filename" id="name-certif"></span>
                        </div>
                        <div class="upload-card required-doc" id="card-acte">
                            <div class="upload-check"><i class="bi bi-check"></i></div>
                            <i class="bi bi-file-earmark-text upload-icon"></i>
                            <span class="upload-title">Acte de Naissance</span>
                            <span class="upload-badge-required">Obligatoire</span>
                            <span class="upload-hint">Extrait ou copie intégrale</span>
                            <input type="file" id="file-acte" name="acte_naissance" accept=".jpeg,.jpg,.png,.pdf" onchange="handleFileChange(this,'card-acte','name-acte')">
                            <span class="upload-filename" id="name-acte"></span>
                        </div>

                        <div class="upload-card" id="card-permisc">
                            <div class="upload-check"><i class="bi bi-check"></i></div>
                            <i class="bi bi-card-heading upload-icon"></i>
                            <span class="upload-title">Copie Permis C</span>
                            <span class="upload-badge-optional">Facultatif</span>
                            <span class="upload-hint">Si vous possédez un permis C</span>
                            <input type="file" id="file-permisc" name="permis_c" accept=".jpeg,.jpg,.png,.pdf" onchange="handleFileChange(this,'card-permisc','name-permisc')">
                            <span class="upload-filename" id="name-permisc"></span>
                        </div>
                    </div>
                    <div style="text-align:right;font-size:.72rem;color:var(--color-gray-500);margin-top:8px;">
                        <i class="bi bi-paperclip"></i> <span id="file-counter">0</span> / 4 fichiers obligatoires
                    </div>

                    <div class="btn-wrapper">
                        <button type="button" class="btn-prev" onclick="goToStep(2)"><i class="bi bi-arrow-left"></i> Précédent</button>
                        <button type="button" class="btn-next" id="btn-next-3" onclick="goToStep(4)" disabled>Suivant <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════ ÉTAPE 4 — PAIEMENT ══════════════════ --}}
        <div id="step4" style="display:none;">
            <div class="form-card">
                <div class="form-card-head" style="background:linear-gradient(135deg,#007A5E,#004D3A);border-bottom-color:#FCD116;">
                    <i class="bi bi-cash-coin"></i> Étape 4 — Paiement des frais d'inscription
                </div>
                <div class="form-card-body">

                    <div class="info-box info-box-gold">
                        <i class="bi bi-exclamation-circle-fill"></i>
                        <div>Le paiement peut être effectué en totalité ou par tranches. Un reçu officiel vous sera remis par l'auto-école à votre arrivée.</div>
                    </div>

                    <!-- Résumé des frais -->
                    <div class="paiement-summary">
                        <div class="paiement-summary-title">
                            <i class="bi bi-receipt" style="color:var(--color-green);"></i>
                            Détail des frais d'inscription
                        </div>

                        <div class="paiement-total-line">
                            <span class="paiement-total-label">Total à régler</span>
                            <span class="paiement-total-val">135 000 FCFA</span>
                        </div>
                    </div>

                    <!-- Mode de paiement -->
                    <div class="section-title"><i class="bi bi-wallet2"></i> Mode de paiement</div>
                    <div class="mode-paiement-grid">

                        <div class="mode-card" id="mode-especes" onclick="selectMode('especes')">
                            <div class="mode-check"><i class="bi bi-check"></i></div>
                            <input type="radio" name="modePaiement" value="especes">
                            <i class="bi bi-cash mode-card-icon"></i>
                            <span class="mode-card-label">Espèces</span>
                        </div>

                        <div class="mode-card" id="mode-mobile" onclick="selectMode('mobile')">
                            <div class="mode-check"><i class="bi bi-check"></i></div>
                            <input type="radio" name="modePaiement" value="mobile_money">
                            <i class="bi bi-phone mode-card-icon"></i>
                            <span class="mode-card-label">Mobile Money</span>
                        </div>

                        <div class="mode-card" id="mode-virement" onclick="selectMode('virement')">
                            <div class="mode-check"><i class="bi bi-check"></i></div>
                            <input type="radio" name="modePaiement" value="virement">
                            <i class="bi bi-bank mode-card-icon"></i>
                            <span class="mode-card-label">Virement bancaire</span>
                        </div>

                    </div>

                    <!-- Détails espèces -->
                    <div class="paiement-details" id="details-especes">
                        <div class="tranche-box">
                            <div class="tranche-title"><i class="bi bi-layers"></i> Choisissez votre modalité de paiement</div>
                            <div class="tranche-options">
                                <button type="button" class="tranche-btn" onclick="selectTranche(this,'total','135000')">Paiement total — 135 000 FCFA</button>
                                <button type="button" class="tranche-btn" onclick="selectTranche(this,'tranche1','75000')">1ère tranche — 75 000 FCFA</button>
                                <button type="button" class="tranche-btn" onclick="selectTranche(this,'tranche2','60000')">2ème tranche — 60 000 FCFA</button>
                            </div>
                        </div>
                    </div>

                    <!-- Détails mobile money -->
                    <div class="paiement-details" id="details-mobile">
                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="lbl">Opérateur <span class="req">*</span></label>
                                <select name="operateur" id="inp-operateur" class="inp" onchange="updateStep4Button()">
                                    <option value="">-- Choisir --</option>
                                    <option value="orange">Orange Money</option>
                                    <option value="moov">Moov Money</option>
                                    <option value="coris">Coris Money</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="lbl">Numéro de téléphone / Référence <span class="req">*</span></label>
                                <input type="text" name="numeroTransaction" id="inp-transaction" class="inp" placeholder="Ex: 70 12 34 56 ou TXN123456789" oninput="updateStep4Button()">
                                <span style="font-size:.65rem;color:var(--color-gray-500);margin-top:4px;display:block;"><i class="bi bi-info-circle"></i> Saisissez le numéro de téléphone utilisé pour le paiement, ou la référence de transaction</span>
                            </div>
                        </div>
                        <div class="tranche-box mt-3">
                            <div class="tranche-title"><i class="bi bi-layers"></i> Modalité</div>
                            <div class="tranche-options">
                                <button type="button" class="tranche-btn" onclick="selectTranche(this,'total','135000')">Total — 135 000 FCFA</button>
                                <button type="button" class="tranche-btn" onclick="selectTranche(this,'tranche1','75000')">1ère tranche — 75 000 FCFA</button>
                            </div>
                        </div>
                    </div>

                    <!-- Détails virement -->
                    <div class="paiement-details" id="details-virement">
                        <div class="info-box mt-2">
                            <i class="bi bi-info-circle-fill"></i>
                            <div>
                                <strong>Coordonnées bancaires CCI-BF :</strong><br>
                                Banque : BICIAB Bobo-Dioulasso<br>
                                IBAN : BF00 0000 0000 0000 0000 0000 000<br>
                                Motif : <em>Inscription GESP — [Votre Nom]</em>
                            </div>
                        </div>
                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label class="lbl">Référence du virement <span class="req">*</span></label>
                                <input type="text" name="referenceVirement" id="inp-virement" class="inp" placeholder="Ex: VIR-2026-00123" oninput="updateStep4Button()">
                            </div>
                            <div class="col-md-6">
                                <label class="lbl">Date du virement</label>
                                <input type="date" name="dateVirement" class="inp" max="{{ date('Y-m-d') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Champs hidden pour le controller -->
                    <input type="hidden" name="montantPaiement" id="inp-montant" value="">
                    <input type="hidden" name="tranchePaiement" id="inp-tranche" value="">
                    <input type="hidden" name="datePaiement" value="{{ date('Y-m-d') }}">

                    <div class="btn-wrapper">
                        <button type="button" class="btn-prev" onclick="goToStep(3)"><i class="bi bi-arrow-left"></i> Précédent</button>
                        <button type="button" class="btn-next" id="btn-next-4" onclick="goToStep(5)" disabled>Suivant <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════ ÉTAPE 5 — Récapitulatif ══════════════════ --}}
        <div id="step5" style="display:none;">
            <div class="form-card">
                <div class="form-card-head"><i class="bi bi-clipboard-check"></i> Étape 5 — Récapitulatif de vérification</div>
                <div class="form-card-body">

                    <div class="info-box" style="background:rgba(252,209,22,.1);border-left-color:var(--color-gold-dark);color:var(--color-dark);">
                        <i class="bi bi-exclamation-circle-fill" style="color:var(--color-gold-dark);"></i>
                        <div><strong>Vérifiez scrupuleusement vos données avant de soumettre.</strong> Un récépissé vous sera fourni après validation.</div>
                    </div>

                    <div class="section-title"><i class="bi bi-person"></i> Identité & Contacts</div>
                    <div style="margin-bottom:18px;">
                        <div class="recap-row"><span class="recap-label">Nom complet</span><span class="recap-val" id="r-nom">—</span></div>
                        <div class="recap-row"><span class="recap-label">Date & Lieu de naissance</span><span class="recap-val" id="r-naissance">—</span></div>
                        <div class="recap-row"><span class="recap-label">Téléphone</span><span class="recap-val" id="r-tel">—</span></div>
                        <div class="recap-row"><span class="recap-label">Email</span><span class="recap-val" id="r-email">—</span></div>
                    </div>

                    <div class="section-title"><i class="bi bi-pencil-square"></i> Détails Inscription</div>
                    <div style="margin-bottom:18px;">
                        <div class="recap-row"><span class="recap-label">Catégorie demandée</span><span class="recap-val" id="r-cat">—</span></div>
                        <div class="recap-row"><span class="recap-label">Date de soumission</span><span class="recap-val" id="r-dateinscr">—</span></div>
                    </div>

                    <!-- RECAP PAIEMENT -->
                    <div class="section-title"><i class="bi bi-cash-coin"></i> Paiement</div>
                    <div style="margin-bottom:18px;">
                        <div class="recap-row">
                            <span class="recap-label">Mode de paiement</span>
                            <span class="recap-val" id="r-mode">—</span>
                        </div>
                        <div class="recap-row">
                            <span class="recap-label">Montant réglé</span>
                            <span class="recap-val" id="r-montant">—</span>
                        </div>
                        <div class="recap-row" id="r-row-transaction" style="display:none;">
                            <span class="recap-label">Référence transaction</span>
                            <span class="recap-val" id="r-transaction">—</span>
                        </div>
                        <div class="recap-row">
                            <span class="recap-label">Statut paiement</span>
                            <span class="recap-val"><span class="recap-paiement-badge"><i class="bi bi-clock"></i> En attente de validation</span></span>
                        </div>
                    </div>

                    <div class="section-title"><i class="bi bi-folder2"></i> Pièces jointes</div>
                    <div class="recap-file-grid" id="recap-files-grid"></div>

                    <div class="confirm-box">
                        <label>
                            <input type="checkbox" id="confirmCheck" required>
                            <span>Je certifie que toutes les informations saisies sont exactes et que les documents fournis sont authentiques.</span>
                        </label>
                    </div>

                    <div class="btn-wrapper">
                        <button type="button" class="btn-prev" onclick="goToStep(4)"><i class="bi bi-arrow-left"></i> Précédent</button>
                        <button type="submit" class="btn-submit" id="btn-submit-final" disabled>
                            Confirmer et soumettre <i class="bi bi-check2-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

<div class="site-footer">
    © 2026 <span>AGesp</span> · Auto-École GESP · Chambre de Commerce et d'Industrie du Burkina Faso (CCI-BF)
</div>

<script>
// ── Numéro Permis C — force le préfixe N° ──────────────────────
function formatPermisC(input) {
    // Supprimer tout préfixe N° existant pour ne garder que le numéro
    let val = input.value.replace(/^N°\s*/i, '').replace(/[^a-zA-Z0-9\-]/g, '');
    // Stocker la valeur propre dans un champ hidden pour l'envoi
    const hidden = document.getElementById('inp-num-permis-hidden');
    if (hidden) hidden.value = val ? 'N°' + val : '';
    // Afficher la valeur sans préfixe dans le champ (le préfixe est affiché via le span)
    input.value = val;
}

// ── Date naissance ──────────────────────────────────────────────
function syncDateNaissance() {
    const j = document.getElementById('inp-ddn-jour').value;
    const m = document.getElementById('inp-ddn-mois').value;
    const a = document.getElementById('inp-ddn-annee').value;
    document.getElementById('inp-ddn').value = (j && m && a) ? `${a}-${m}-${j}` : '';
    updateStep1Button();
}
document.addEventListener('DOMContentLoaded', function () {
    ['inp-ddn-jour','inp-ddn-mois','inp-ddn-annee'].forEach(id => {
        document.getElementById(id).addEventListener('change', syncDateNaissance);
    });
    const oldVal = document.getElementById('inp-ddn').value;
    if (oldVal && /^\d{4}-\d{2}-\d{2}$/.test(oldVal)) {
        const [y,m,d] = oldVal.split('-');
        document.getElementById('inp-ddn-annee').value = y;
        document.getElementById('inp-ddn-mois').value  = m;
        document.getElementById('inp-ddn-jour').value  = d;
    }
    document.getElementById('confirmCheck').addEventListener('change', function () {
        document.getElementById('btn-submit-final').disabled = !this.checked;
    });

    // État initial des boutons "Suivant" (utile après un retour d'erreur serveur avec old())
    updateStep1Button();
    updateStep2Button();
    updateStep3Button();
    updateStep4Button();
});

// ── Validation temps réel — boutons "Suivant" grisés tant que l'étape n'est pas complète ──
function step1Valid() {
    const nom    = document.getElementById('inp-nom').value.trim();
    const prenom = document.getElementById('inp-prenom').value.trim();
    const lieu   = document.getElementById('inp-lieu').value.trim();
    const tel    = document.getElementById('inp-tel').value.trim();
    const ddn      = document.getElementById('inp-ddn').value;
    const ddnJour  = document.getElementById('inp-ddn-jour').value;
    const ddnMois  = document.getElementById('inp-ddn-mois').value;
    const ddnAnnee = document.getElementById('inp-ddn-annee').value;

    if (!nom || !prenom || !lieu || !tel) return false;
    if (!ddnJour || !ddnMois || !ddnAnnee) return false;
    if (calculerAge(ddn) < 21) return false;
    if (/\d/.test(lieu)) return false;
    if (/[a-zA-Z]/.test(tel)) return false;
    return true;
}
function updateStep1Button() {
    const btn = document.getElementById('btn-next-1');
    if (btn) btn.disabled = !step1Valid();
}

function step2Valid() {
    return !!document.getElementById('inp-cat').value;
}
function updateStep2Button() {
    const btn = document.getElementById('btn-next-2');
    if (btn) btn.disabled = !step2Valid();
}

function step3Valid() {
    const required = ['file-cnib','file-photo','file-certif','file-acte'];
    return required.every(id => {
        const el = document.getElementById(id);
        return el && el.files && el.files.length > 0;
    });
}
function updateStep3Button() {
    const btn = document.getElementById('btn-next-3');
    if (btn) btn.disabled = !step3Valid();
}

function step4Valid() {
    if (!modeSelectionne) return false;
    if (!document.getElementById('inp-montant').value) return false;
    if (modeSelectionne === 'mobile') {
        const op = document.getElementById('inp-operateur').value;
        const tx = document.getElementById('inp-transaction').value.trim();
        if (!op || !tx) return false;
    }
    if (modeSelectionne === 'virement') {
        const ref = document.getElementById('inp-virement').value.trim();
        if (!ref) return false;
    }
    return true;
}
function updateStep4Button() {
    const btn = document.getElementById('btn-next-4');
    if (btn) btn.disabled = !step4Valid();
}

// ── Upload fichiers ─────────────────────────────────────────────
function handleFileChange(input, cardId, nameId) {
    const card = document.getElementById(cardId);
    const nameSpan = document.getElementById(nameId);
    if (input.files && input.files.length > 0) {
        const file = input.files[0];
        if (file.size > 5 * 1024 * 1024) {
            showError(`Le fichier "${file.name}" dépasse 5 Mo.`);
            input.value = '';
            card.classList.remove('has-file'); card.classList.add('has-error');
            nameSpan.textContent = '';
            updateFileCounter(); updateStep3Button(); return;
        }
        card.classList.add('has-file'); card.classList.remove('has-error','required-doc');
        nameSpan.textContent = file.name;
    } else {
        card.classList.remove('has-file'); card.classList.add('required-doc');
        nameSpan.textContent = '';
    }
    updateFileCounter();
    updateStep3Button();
}
function updateFileCounter() {
    const required = ['file-cnib','file-photo','file-certif','file-acte'];
    const count = required.filter(id => { const el = document.getElementById(id); return el && el.files && el.files.length > 0; }).length;
    document.getElementById('file-counter').textContent = count;
}

// ── Mode paiement ───────────────────────────────────────────────
let modeSelectionne = '';
function selectMode(mode) {
    modeSelectionne = mode;
    document.querySelectorAll('.mode-card').forEach(c => c.classList.remove('selected'));
    document.querySelectorAll('.paiement-details').forEach(d => { d.classList.remove('visible'); });
    document.getElementById('mode-' + mode).classList.add('selected');
    document.getElementById('mode-' + mode).querySelector('input[type="radio"]').checked = true;
    document.getElementById('details-' + mode).classList.add('visible');
    // reset montant
    document.getElementById('inp-montant').value = '';
    document.getElementById('inp-tranche').value = '';
    document.querySelectorAll('.tranche-btn').forEach(b => b.classList.remove('selected'));
    updateStep4Button();
}

function selectTranche(btn, tranche, montant) {
    // Désélectionner les autres boutons dans le même groupe
    btn.closest('.tranche-options').querySelectorAll('.tranche-btn').forEach(b => b.classList.remove('selected'));
    btn.classList.add('selected');
    document.getElementById('inp-montant').value = montant;
    document.getElementById('inp-tranche').value = tranche;
    updateStep4Button();
}

// ── Utilitaires ──────────────────────────────────────────────────
function showError(msg) {
    const box = document.getElementById('client-error-box');
    document.getElementById('client-error-msg').innerText = msg;
    box.style.display = 'block';
    window.scrollTo({top: 0, behavior: 'smooth'});
}
function hideError() { document.getElementById('client-error-box').style.display = 'none'; }
function calculerAge(str) {
    if (!str) return 0;
    const today = new Date(), dob = new Date(str);
    let age = today.getFullYear() - dob.getFullYear();
    const m = today.getMonth() - dob.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) age--;
    return age;
}
function formatDate(str) { if (!str) return '—'; return new Date(str + 'T00:00:00').toLocaleDateString('fr-FR'); }
const modeLabels = { especes: 'Espèces', mobile: 'Mobile Money', virement: 'Virement bancaire' };

// ── Navigation ───────────────────────────────────────────────────
function goToStep(step) {
    hideError();

    // Validation étape 1
    if (step === 2) {
        const nom = document.getElementById('inp-nom').value.trim();
        const prenom = document.getElementById('inp-prenom').value.trim();
        const ddn = document.getElementById('inp-ddn').value;
        const lieu = document.getElementById('inp-lieu').value.trim();
        const tel = document.getElementById('inp-tel').value.trim();
        const ddnJour = document.getElementById('inp-ddn-jour').value;
        const ddnMois = document.getElementById('inp-ddn-mois').value;
        const ddnAnnee = document.getElementById('inp-ddn-annee').value;
        if (!nom || !prenom || !lieu || !tel) { showError("Remplissez tous les champs obligatoires (*)."); return; }
        if (!ddnJour || !ddnMois || !ddnAnnee) { showError("Sélectionnez le jour, mois et année de naissance."); return; }
        if (calculerAge(ddn) < 21) { showError("L'âge requis est supérieur ou égal à 21 ans."); return; }
        if (/\d/.test(lieu)) { showError("Le lieu de naissance ne doit pas contenir de chiffres."); return; }
        if (/[a-zA-Z]/.test(tel)) { showError("Le numéro de téléphone ne doit pas contenir de lettres."); return; }
    }

    // Validation étape 2
    if (step === 3) {
        const cat = document.getElementById('inp-cat').value;
        if (!cat) { showError("Choisissez une catégorie de permis."); return; }
    }

    // Validation étape 3 (fichiers)
    if (step === 4) {
        const required = [
            {id:'file-cnib',   card:'card-cnib',   label:'CNIB'},
            {id:'file-photo',  card:'card-photo',  label:'Photo Identité'},
            {id:'file-certif', card:'card-certif', label:'Certificat Médical'},
            {id:'file-acte',   card:'card-acte',   label:'Acte de Naissance'},
        ];
        const missing = [];
        required.forEach(f => {
            const el = document.getElementById(f.id);
            if (!el || !el.files || el.files.length === 0) {
                missing.push(f.label);
                document.getElementById(f.card).classList.add('has-error');
            }
        });
        if (missing.length > 0) { showError("Documents manquants : " + missing.join(', ')); return; }
    }

    // Validation étape 4 (paiement)
    if (step === 5) {
        if (!modeSelectionne) { showError("Veuillez choisir un mode de paiement."); return; }
        const montant = document.getElementById('inp-montant').value;
        if (!montant) { showError("Veuillez sélectionner une modalité de paiement (total ou tranche)."); return; }
        if (modeSelectionne === 'mobile') {
            const op = document.getElementById('inp-operateur').value;
            const tx = document.getElementById('inp-transaction').value.trim();
            if (!op || !tx) { showError("Veuillez renseigner l'opérateur et le numéro de transaction Mobile Money."); return; }
        }
        if (modeSelectionne === 'virement') {
            const ref = document.getElementById('inp-virement').value.trim();
            if (!ref) { showError("Veuillez saisir la référence du virement bancaire."); return; }
        }

        // Remplir le récapitulatif complet
        document.getElementById('r-nom').innerText = document.getElementById('inp-nom').value.toUpperCase() + ' ' + document.getElementById('inp-prenom').value;
        const ddnVal = document.getElementById('inp-ddn').value;
        document.getElementById('r-naissance').innerText = (ddnVal ? formatDate(ddnVal) : '—') + ' à ' + document.getElementById('inp-lieu').value;
        document.getElementById('r-tel').innerText = document.getElementById('inp-tel').value;
        document.getElementById('r-email').innerText = document.getElementById('inp-email').value || 'Non renseigné';
        const catSelect = document.getElementById('inp-cat');
        document.getElementById('r-cat').innerText = catSelect.options[catSelect.selectedIndex].text;
        document.getElementById('r-dateinscr').innerText = formatDate(document.getElementById('inp-dateinscr').value);

        // Paiement récap
        const tranche = document.getElementById('inp-tranche').value;
        const trancheLabel = {total: 'Paiement total', tranche1: '1ère tranche', tranche2: '2ème tranche'}[tranche] || tranche;
        document.getElementById('r-mode').innerText = (modeLabels[modeSelectionne] || modeSelectionne) + ' — ' + trancheLabel;
        document.getElementById('r-montant').innerText = parseInt(montant).toLocaleString('fr-FR') + ' FCFA';

        // Transaction ref si mobile/virement
        const refEl = document.getElementById('r-row-transaction');
        const refVal = document.getElementById('r-transaction');
        if (modeSelectionne === 'mobile') {
            refEl.style.display = 'flex';
            refVal.innerText = document.getElementById('inp-transaction').value;
        } else if (modeSelectionne === 'virement') {
            refEl.style.display = 'flex';
            refVal.innerText = document.getElementById('inp-virement').value;
        } else {
            refEl.style.display = 'none';
        }

        // Fichiers récap
        const allFiles = [
            {id:'file-cnib',    label:'CNIB',               req:true},
            {id:'file-photo',   label:'Photo Identité',     req:true},
            {id:'file-certif',  label:'Certificat Médical', req:true},
            {id:'file-acte',    label:'Acte de Naissance',  req:true},
            {id:'file-permisc', label:'Copie Permis C',     req:false},
        ];
        const grid = document.getElementById('recap-files-grid');
        grid.innerHTML = '';
        allFiles.forEach(f => {
            const el = document.getElementById(f.id);
            const hasFile = el && el.files && el.files.length > 0;
            const fname = hasFile ? el.files[0].name : (f.req ? 'Manquant' : 'Non fourni');
            const cls = hasFile ? 'ok' : (f.req ? 'nok' : 'ok');
            const ico = hasFile ? 'bi-check-circle-fill' : (f.req ? 'bi-x-circle-fill' : 'bi-dash-circle');
            const icoColor = hasFile ? 'var(--color-green)' : (f.req ? 'var(--color-red)' : 'var(--color-gray-500)');
            grid.innerHTML += `<div class="recap-file-item ${cls}"><i class="bi ${ico}" style="color:${icoColor};font-size:1.2rem;flex-shrink:0;"></i><div style="overflow:hidden;"><span class="recap-file-label">${f.label}</span><span class="recap-file-name" title="${fname}">${fname}</span></div></div>`;
        });
    }

    // Basculer les étapes
    [1,2,3,4,5].forEach(i => {
        const el = document.getElementById('step' + i);
        if (el) el.style.display = (i === step) ? 'block' : 'none';
    });

    // Mettre à jour le stepper
    for (let i = 1; i <= 5; i++) {
        const numNode = document.getElementById('snum' + i);
        const lblNode = document.getElementById('slbl' + i);
        const lineNode = document.getElementById('sline' + i);
        if (i < step) {
            numNode.className = 'step-num done'; numNode.innerHTML = '<i class="bi bi-check"></i>';
            if (lblNode) lblNode.className = 'step-label done';
            if (lineNode) lineNode.className = 'step-line done';
        } else if (i === step) {
            numNode.className = 'step-num active'; numNode.innerText = i;
            if (lblNode) lblNode.className = 'step-label active';
            if (lineNode) lineNode.className = 'step-line';
        } else {
            numNode.className = 'step-num todo'; numNode.innerText = i;
            if (lblNode) lblNode.className = 'step-label todo';
            if (lineNode) lineNode.className = 'step-line';
        }
    }
    window.scrollTo({top: 0, behavior: 'instant'});
}
</script>
</body>
</html>