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
            --color-red: #CE1126;
            --color-green: #007A5E;
            --color-gold: #FCD116;
            --color-red-dark: #A00D20;
            --color-green-light: #00A572;
            --color-green-dark: #004D3A;
            --color-gold-dark: #E5B800;
            --color-dark: #1A1A1A;
            --color-light: #F8F8F8;
            --color-gray-100: #E8E8E8;
            --color-gray-200: #D1D1D1;
            --color-gray-500: #666666;
            --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 12px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
            --transition-normal: 300ms ease-in-out;
            --radius-md: 8px;
            --radius-lg: 12px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Source Sans 3', sans-serif;
            background: var(--color-light);
            color: var(--color-dark);
            font-size: 14px;
        }

        /* Barre tricolore */
        .tricolor {
            height: 5px;
            background: linear-gradient(90deg, var(--color-red) 0%, var(--color-red) 33%, var(--color-gold) 33%, var(--color-gold) 66%, var(--color-green) 66%, var(--color-green) 100%);
        }

        /* HEADER */
        .site-header {
            background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%);
            padding: 16px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: var(--shadow-md);
        }

        .logo-box {
            width: 48px;
            height: 48px;
            background: white;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            flex-shrink: 0;
        }

        .logo-box img {
            width: 88%;
            height: 88%;
            object-fit: contain;
        }

        .site-title {
            font-family: 'Nunito', sans-serif;
            font-weight: 900;
            font-size: 1.3rem;
            color: white;
            margin: 0;
        }

        .site-title span {
            color: var(--color-gold);
        }

        .site-subtitle {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
        }

        .header-return {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 0.78rem;
            transition: color var(--transition-normal);
        }

        .header-return:hover {
            color: var(--color-gold);
        }

        /* SLOGAN */
        .site-slogan {
            background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%);
            color: white;
            text-align: center;
            padding: 12px 20px;
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 0.9rem;
        }

        .site-slogan em {
            color: var(--color-gold);
            font-style: normal;
        }

        /* NAV */
        .site-nav {
            background: var(--color-green);
            padding: 0 30px;
            display: flex;
            align-items: center;
            gap: 0;
            box-shadow: var(--shadow-md);
        }

        .nav-lnk {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 12px 16px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 600;
            font-family: 'Nunito', sans-serif;
            border-bottom: 3px solid transparent;
            transition: all var(--transition-normal);
        }

        .nav-lnk:hover,
        .nav-lnk.active {
            color: white;
            border-bottom-color: var(--color-gold);
            background: rgba(0, 0, 0, 0.1);
        }

        /* BREADCRUMB */
        .breadcrumb-bar {
            background: white;
            padding: 10px 30px;
            border-bottom: 1px solid rgba(0, 122, 94, 0.15);
            font-size: 0.75rem;
            color: #6b7a70;
        }

        .breadcrumb-bar a {
            color: var(--color-green);
            text-decoration: none;
        }

        /* STEPPER */
        .stepper-wrap {
            max-width: 900px;
            margin: 30px auto 0;
            padding: 0 20px;
        }

        .stepper {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            background: white;
            padding: 16px;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
        }

        .step {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .step-num {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 0.9rem;
            flex-shrink: 0;
            transition: all var(--transition-normal);
        }

        .step-num.done {
            background: var(--color-green);
            color: white;
        }

        .step-num.active {
            background: var(--color-gold);
            color: var(--color-dark);
            box-shadow: 0 0 0 4px rgba(252, 209, 22, 0.2);
        }

        .step-num.todo {
            background: var(--color-gray-100);
            color: #999;
        }

        .step-label {
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .step-label.active {
            color: var(--color-green);
        }

        .step-label.done {
            color: var(--color-green-dark);
        }

        .step-label.todo {
            color: #999;
        }

        .step-line {
            flex: 1;
            height: 3px;
            background: var(--color-gray-100);
            margin: 0 8px;
            border-radius: 2px;
        }

        .step-line.done {
            background: var(--color-green);
        }

        /* FORM */
        .form-wrap {
            max-width: 900px;
            margin: 0 auto 40px;
            padding: 0 20px;
        }

        .form-card {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-md);
            overflow: hidden;
            border: 1px solid var(--color-gray-100);
        }

        .form-card-head {
            background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-light) 100%);
            color: white;
            padding: 16px 20px;
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            border-bottom: 3px solid var(--color-gold);
        }

        .form-card-body {
            padding: 28px;
        }

        .section-title {
            font-family: 'Nunito', sans-serif;
            font-weight: 800;
            font-size: 0.8rem;
            color: var(--color-dark);
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 16px;
            margin-top: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--color-gold);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title:first-of-type {
            margin-top: 0;
        }

        .section-title i {
            color: var(--color-green);
            font-size: 1rem;
        }

        .lbl {
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 0.75rem;
            color: var(--color-dark);
            margin-bottom: 6px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .lbl .req {
            color: var(--color-red);
        }

        .inp {
            width: 100%;
            border: 2px solid var(--color-gray-200);
            border-radius: var(--radius-md);
            padding: 10px 12px;
            font-size: 0.85rem;
            background: #f9fbfa;
            font-family: 'Source Sans 3', sans-serif;
            transition: all var(--transition-normal);
            margin-bottom: 0;
            color: var(--color-dark);
        }

        .inp:focus {
            border-color: var(--color-green);
            box-shadow: 0 0 0 3px rgba(0, 122, 94, 0.1);
            background: white;
            outline: none;
        }

        .inp.is-invalid {
            border-color: var(--color-red);
        }

        .inp.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(206, 17, 38, 0.1);
        }

        .invalid-msg {
            font-size: 0.7rem;
            color: var(--color-red);
            margin-top: 4px;
            display: block;
        }

        /* Groupe de sélecteurs de date */
        .date-selects-group {
            display: flex;
            gap: 8px;
        }

        .date-selects-group .inp-jour {
            width: 80px;
            flex-shrink: 0;
        }

        .date-selects-group .inp-mois {
            flex: 1;
        }

        .date-selects-group .inp-annee {
            width: 100px;
            flex-shrink: 0;
        }

        /* INFO BOX */
        .info-box {
            background: rgba(0, 122, 94, 0.1);
            border: 1px solid rgba(0, 122, 94, 0.2);
            border-left: 4px solid var(--color-green);
            border-radius: var(--radius-md);
            padding: 14px 16px;
            font-size: 0.8rem;
            color: var(--color-green-dark);
            margin-bottom: 20px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        .info-box i {
            color: var(--color-green);
            font-size: 1.1rem;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* ALERTS */
        .alert-err {
            background: rgba(206, 17, 38, 0.1);
            color: var(--color-red-dark);
            border-left: 4px solid var(--color-red);
            border-radius: var(--radius-md);
            padding: 12px 16px;
            font-size: 0.8rem;
            margin-bottom: 18px;
        }

        .alert-err ul {
            margin: 6px 0 0 20px;
            padding: 0;
        }

        .alert-ok {
            background: rgba(0, 122, 94, 0.1);
            color: var(--color-green-dark);
            border-left: 4px solid var(--color-green);
            border-radius: var(--radius-md);
            padding: 12px 16px;
            font-size: 0.8rem;
            margin-bottom: 18px;
        }

        /* RECAP */
        .recap-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid rgba(0, 122, 94, 0.1);
            font-size: 0.8rem;
        }

        .recap-row:last-child {
            border-bottom: none;
        }

        .recap-label {
            color: #6b7a70;
            font-weight: 600;
        }

        .recap-val {
            font-weight: 700;
            color: var(--color-dark);
        }

        /* CONFIRM BOX */
        .confirm-box {
            background: rgba(252, 209, 22, 0.15);
            border: 1px solid var(--color-gold);
            border-radius: var(--radius-md);
            padding: 14px 16px;
            font-size: 0.8rem;
            color: var(--color-dark);
            margin-bottom: 20px;
        }

        .confirm-box label {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            cursor: pointer;
            margin: 0;
        }

        .confirm-box input[type="checkbox"] {
            accent-color: var(--color-green);
            margin-top: 3px;
            flex-shrink: 0;
        }

        /* BUTTONS */
        .btn-wrapper {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--color-gray-100);
        }

        .btn-prev,
        .btn-next,
        .btn-submit {
            border: none;
            border-radius: var(--radius-md);
            padding: 10px 24px;
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            cursor: pointer;
            transition: all var(--transition-normal);
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .btn-next {
            background: linear-gradient(135deg, var(--color-red) 0%, var(--color-red-dark) 100%);
            color: white;
            border: 2px solid var(--color-red);
            box-shadow: var(--shadow-sm);
            margin-left: auto;
        }

        .btn-next:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(206, 17, 38, 0.3);
        }

        .btn-prev {
            background: var(--color-gray-100);
            color: var(--color-dark);
            border: 2px solid var(--color-gray-100);
            box-shadow: var(--shadow-sm);
        }

        .btn-prev:hover {
            transform: translateY(-2px);
            background: var(--color-gray-200);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--color-green) 0%, var(--color-green-dark) 100%);
            color: white;
            border: 2px solid var(--color-green);
            box-shadow: var(--shadow-sm);
            margin-left: auto;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 122, 94, 0.3);
        }

        /* FOOTER */
        .site-footer {
            background: var(--color-dark);
            color: rgba(255, 255, 255, 0.6);
            text-align: center;
            padding: 14px 20px;
            font-size: 0.75rem;
            margin-top: 30px;
        }

        .site-footer span {
            color: var(--color-gold);
            font-weight: 700;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .site-header {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }

            .site-nav {
                flex-wrap: wrap;
                gap: 0;
            }

            .stepper {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .step {
                width: 100%;
            }

            .step-line {
                display: none;
            }

            .btn-wrapper {
                flex-direction: column;
            }

            .btn-next,
            .btn-submit {
                margin-left: 0;
                width: 100%;
                justify-content: center;
            }

            .date-selects-group {
                flex-wrap: wrap;
            }

            .date-selects-group .inp-jour,
            .date-selects-group .inp-annee {
                width: calc(50% - 4px);
            }

            .date-selects-group .inp-mois {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="tricolor"></div>

    <div class="site-header">
        <div style="display: flex; align-items: center; gap: 14px;">
            <div class="logo-box">
                @if(file_exists(public_path('images/logo.jpeg')))
                    <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
                @elseif(file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                @else
                    <span style="font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 1.1rem; color: #007A5E;">AG</span>
                @endif
            </div>
            <div>
                <div class="site-title">A<span>G</span>esp</div>
                <div class="site-subtitle">Système de Gestion Auto-École · CCI-BF</div>
            </div>
        </div>
        <a href="{{ url('/') }}" class="header-return">
            <i class="bi bi-arrow-left"></i> Retour à l'accueil
        </a>
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

    <div class="stepper-wrap">
        <div class="stepper">
            <div class="step" id="step-h1">
                <div class="step-num active" id="snum1">1</div>
                <div class="step-label active" id="slbl1">Informations personnelles</div>
            </div>
            <div class="step-line" id="sline1"></div>
            <div class="step" id="step-h2">
                <div class="step-num todo" id="snum2">2</div>
                <div class="step-label todo" id="slbl2">Inscription & Permis</div>
            </div>
            <div class="step-line" id="sline2"></div>
            <div class="step" id="step-h3">
                <div class="step-num todo" id="snum3">3</div>
                <div class="step-label todo" id="slbl3">Récapitulatif</div>
            </div>
        </div>
    </div>

    <div class="form-wrap">

        <div id="client-error-box" class="alert-err" style="display: none;">
            <i class="bi bi-exclamation-triangle"></i> <strong>Erreur de saisie :</strong> <span id="client-error-msg"></span>
        </div>

        @if($errors->any())
        <div class="alert-err">
            <i class="bi bi-exclamation-triangle"></i> <strong>Erreurs de validation :</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if(session('success'))
        <div class="alert-ok">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('inscription.public.store') }}" id="inscriptionForm">
            @csrf

            {{-- ══════════════════════════════════════════════ --}}
            {{-- ÉTAPE 1 — Informations personnelles           --}}
            {{-- ══════════════════════════════════════════════ --}}
            <div id="step1">
                <div class="form-card">
                    <div class="form-card-head">
                        <i class="bi bi-person-fill"></i> Étape 1 — Informations personnelles
                    </div>
                    <div class="form-card-body">

                        <div class="info-box">
                            <i class="bi bi-info-circle-fill"></i>
                            <div>Remplissez vos informations personnelles. Les champs marqués <strong>*</strong> sont obligatoires.</div>
                        </div>

                        <div class="section-title"><i class="bi bi-person"></i> Identité</div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="lbl">Nom <span class="req">*</span></label>
                                <input type="text" id="inp-nom" name="nom" class="inp @error('nom') is-invalid @enderror" value="{{ old('nom') }}" placeholder="Nom de famille" required>
                                @error('nom')<span class="invalid-msg">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="lbl">Prénom <span class="req">*</span></label>
                                <input type="text" id="inp-prenom" name="prenom" class="inp @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" placeholder="Prénom(s)" required>
                                @error('prenom')<span class="invalid-msg">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            {{-- ── DATE DE NAISSANCE : 3 listes déroulantes ── --}}
                            <div class="col-md-6">
                                <label class="lbl">Date de naissance <span class="req">*</span></label>
                                <div class="date-selects-group">
                                    {{-- Jour --}}
                                    <select id="inp-ddn-jour" class="inp inp-jour" aria-label="Jour de naissance">
                                        <option value="">JJ</option>
                                        @for($j = 1; $j <= 31; $j++)
                                            <option value="{{ str_pad($j, 2, '0', STR_PAD_LEFT) }}"
                                                {{ (old('dateNaissance') && intval(explode('-', old('dateNaissance'))[2] ?? 0) === $j) ? 'selected' : '' }}>
                                                {{ str_pad($j, 2, '0', STR_PAD_LEFT) }}
                                            </option>
                                        @endfor
                                    </select>
                                    {{-- Mois --}}
                                    <select id="inp-ddn-mois" class="inp inp-mois" aria-label="Mois de naissance">
                                        <option value="">Mois</option>
                                        @php
                                            $moisNoms = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
                                        @endphp
                                        @foreach($moisNoms as $idx => $moisNom)
                                            <option value="{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}"
                                                {{ (old('dateNaissance') && intval(explode('-', old('dateNaissance'))[1] ?? 0) === ($idx + 1)) ? 'selected' : '' }}>
                                                {{ $moisNom }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- Année : de (année courante - 21) jusqu'à (année courante - 80) --}}
                                    <select id="inp-ddn-annee" class="inp inp-annee" aria-label="Année de naissance">
                                        <option value="">AAAA</option>
                                        @for($a = date('Y') - 21; $a >= date('Y') - 80; $a--)
                                            <option value="{{ $a }}"
                                                {{ (old('dateNaissance') && intval(explode('-', old('dateNaissance'))[0] ?? 0) === $a) ? 'selected' : '' }}>
                                                {{ $a }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                {{-- Champ caché alimenté par JS, soumis au serveur --}}
                                <input type="hidden" id="inp-ddn" name="dateNaissance" value="{{ old('dateNaissance') }}">
                                @error('dateNaissance')<span class="invalid-msg">{{ $message }}</span>@enderror
                                <span style="font-size:0.68rem; color: var(--color-gray-500); margin-top:4px; display:block;">
                                    <i class="bi bi-info-circle"></i> Âge minimum requis : 21 ans
                                </span>
                            </div>
                            <div class="col-md-6">
                                <label class="lbl">Lieu de naissance <span class="req">*</span></label>
                                <input type="text" id="inp-lieu" name="lieuNaissance" class="inp @error('lieuNaissance') is-invalid @enderror" value="{{ old('lieuNaissance') }}" placeholder="Ex: Bobo-Dioulasso" required>
                                @error('lieuNaissance')<span class="invalid-msg">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="section-title"><i class="bi bi-telephone"></i> Contact</div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="lbl">Téléphone <span class="req">*</span></label>
                                <input type="tel" id="inp-tel" name="telephone" class="inp @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}" placeholder="+226 XX XX XX XX" required>
                                @error('telephone')<span class="invalid-msg">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="lbl">Email <span style="color: var(--color-gray-500); font-weight: 400; font-size: 0.7rem;">(Facultatif)</span></label>
                                <input type="email" id="inp-email" name="email" class="inp @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="votre@email.com">
                                @error('email')<span class="invalid-msg">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="section-title"><i class="bi bi-credit-card"></i> Permis actuel (si existant)</div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label class="lbl">Numéro permis</label>
                                <input type="text" id="inp-num-permis" name="numeroPermisC" class="inp" value="{{ old('numeroPermisC') }}" placeholder="N° permis">
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

                        <div class="btn-wrapper" style="border-top: none; margin-top: 28px; padding-top: 0;">
                            <button type="button" class="btn-next" onclick="goToStep(2)">
                                Suivant <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════ --}}
            {{-- ÉTAPE 2 — Inscription & Catégorie de permis   --}}
            {{-- ══════════════════════════════════════════════ --}}
            <div id="step2" style="display: none;">
                <div class="form-card">
                    <div class="form-card-head">
                        <i class="bi bi-pencil-square"></i> Étape 2 — Inscription & Catégorie de permis
                    </div>
                    <div class="form-card-body">

                        <div class="info-box">
                            <i class="bi bi-info-circle-fill"></i>
                            <div>Choisissez la catégorie de permis souhaitée et la date de début de formation.</div>
                        </div>

                        <div class="section-title"><i class="bi bi-calendar-check"></i> Inscription</div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="lbl">Catégorie de permis <span class="req">*</span></label>
                                <select id="inp-cat" name="categoriePermis_id" class="inp @error('categoriePermis_id') is-invalid @enderror" required>
                                    <option value="">-- Choisir une catégorie --</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('categoriePermis_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->pareCategorie ?? $cat->nom ?? 'Catégorie '.$cat->id }}
                                            @if($cat->description ?? false) — {{ $cat->description }} @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('categoriePermis_id')<span class="invalid-msg">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6">
                                {{-- ── DATE DÉBUT FORMATION : min = aujourd'hui ── --}}
                                <label class="lbl">Date de début formation <span class="req">*</span></label>
                                <input type="date"
                                       id="inp-debut"
                                       name="dataDebut_formation"
                                       class="inp @error('dataDebut_formation') is-invalid @enderror"
                                       value="{{ old('dataDebut_formation') }}"
                                       min="{{ date('Y-m-d') }}"
                                       required>
                                @error('dataDebut_formation')<span class="invalid-msg">{{ $message }}</span>@enderror
                                <span style="font-size:0.68rem; color: var(--color-gray-500); margin-top:4px; display:block;">
                                    <i class="bi bi-info-circle"></i> La date doit être à partir d'aujourd'hui ({{ date('d/m/Y') }})
                                </span>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="lbl">Date d'inscription</label>
                                <input type="date" id="inp-dateinscr" name="dateInscription" class="inp" value="{{ old('dateInscription', date('Y-m-d')) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="lbl">Statut</label>
                                <select name="statutInscription" class="inp">
                                    <option value="en_attente">En attente</option>
                                    <option value="actif">Actif</option>
                                </select>
                            </div>
                        </div>

                        <div class="section-title"><i class="bi bi-folder2"></i> Dossier (optionnel)</div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="lbl">Nom du dossier</label>
                                <input type="text" id="inp-nom-dossier" name="nomDossier" class="inp" value="{{ old('nomDossier') }}" placeholder="Ex: Dossier Permis Heavy">
                            </div>
                            <div class="col-md-6">
                                <label class="lbl">Description</label>
                                <input type="text" name="descriptionDossier" class="inp" value="{{ old('descriptionDossier') }}" placeholder="Description optionnelle">
                            </div>
                        </div>

                        <div class="btn-wrapper">
                            <button type="button" class="btn-prev" onclick="goToStep(1)">
                                <i class="bi bi-arrow-left"></i> Précédent
                            </button>
                            <button type="button" class="btn-next" onclick="goToStep(3)">
                                Suivant <i class="bi bi-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════ --}}
            {{-- ÉTAPE 3 — Récapitulatif                       --}}
            {{-- ══════════════════════════════════════════════ --}}
            <div id="step3" style="display: none;">
                <div class="form-card">
                    <div class="form-card-head">
                        <i class="bi bi-clipboard-check"></i> Étape 3 — Récapitulatif de vérification
                    </div>
                    <div class="form-card-body">

                        <div class="info-box" style="background: rgba(252, 209, 22, 0.1); border-left-color: var(--color-gold-dark); color: var(--color-dark);">
                            <i class="bi bi-exclamation-circle-fill" style="color: var(--color-gold-dark);"></i>
                            <div><strong>Récépissé d'inscription :</strong> Après validation, un récépissé d'inscription officiel vous sera automatiquement proposé en téléchargement. Veuillez vérifier scrupuleusement vos données.</div>
                        </div>

                        <div class="section-title"><i class="bi bi-person"></i> Identité & Contacts</div>
                        <div style="margin-bottom: 18px;">
                            <div class="recap-row"><span class="recap-label">Nom complet</span><span class="recap-val" id="r-nom">—</span></div>
                            <div class="recap-row"><span class="recap-label">Date & Lieu de naissance</span><span class="recap-val" id="r-naissance">—</span></div>
                            <div class="recap-row"><span class="recap-label">Téléphone</span><span class="recap-val" id="r-tel">—</span></div>
                            <div class="recap-row"><span class="recap-label">Email</span><span class="recap-val" id="r-email">—</span></div>
                        </div>

                        <div id="recap-permis-section" style="display: none;">
                            <div class="section-title"><i class="bi bi-credit-card"></i> Permis de Conduire Actuel</div>
                            <div style="margin-bottom: 18px;">
                                <div class="recap-row"><span class="recap-label">Numéro du permis</span><span class="recap-val" id="r-num-permis">—</span></div>
                                <div class="recap-row"><span class="recap-label">Délivré le (Lieu)</span><span class="recap-val" id="r-deliv-permis">—</span></div>
                            </div>
                        </div>

                        <div class="section-title"><i class="bi bi-pencil-square"></i> Détails Inscription</div>
                        <div style="margin-bottom: 18px;">
                            <div class="recap-row"><span class="recap-label">Catégorie demandée</span><span class="recap-val" id="r-cat">—</span></div>
                            <div class="recap-row"><span class="recap-label">Date début formation</span><span class="recap-val" id="r-debut">—</span></div>
                            <div class="recap-row"><span class="recap-label">Date de soumission</span><span class="recap-val" id="r-dateinscr">—</span></div>
                            <div class="recap-row"><span class="recap-label">Nom du dossier</span><span class="recap-val" id="r-nom-dossier">—</span></div>
                        </div>

                        <div class="confirm-box">
                            <label>
                                <input type="checkbox" id="confirmCheck" required>
                                <span>Je certifie que toutes les informations saisies sont exactes. Je comprends qu'un récépissé me sera délivré immédiatement après soumission.</span>
                            </label>
                        </div>

                        <div class="btn-wrapper">
                            <button type="button" class="btn-prev" onclick="goToStep(2)">
                                <i class="bi bi-arrow-left"></i> Précédent
                            </button>
                            <button type="submit" class="btn-submit">
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
        // ══════════════════════════════════════════════════════════════
        // SYNCHRONISATION DES LISTES DÉROULANTES → champ hidden dateNaissance
        // ══════════════════════════════════════════════════════════════
        function syncDateNaissance() {
            const j = document.getElementById('inp-ddn-jour').value;
            const m = document.getElementById('inp-ddn-mois').value;
            const a = document.getElementById('inp-ddn-annee').value;
            if (j && m && a) {
                document.getElementById('inp-ddn').value = a + '-' + m + '-' + j;
            } else {
                document.getElementById('inp-ddn').value = '';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Écoute des changements sur les 3 sélecteurs
            ['inp-ddn-jour', 'inp-ddn-mois', 'inp-ddn-annee'].forEach(function (id) {
                document.getElementById(id).addEventListener('change', syncDateNaissance);
            });

            // Pré-remplissage si old() existe (retour erreur serveur Laravel)
            const oldVal = document.getElementById('inp-ddn').value;
            if (oldVal && oldVal.match(/^\d{4}-\d{2}-\d{2}$/)) {
                const parts = oldVal.split('-');
                document.getElementById('inp-ddn-annee').value = parts[0];
                document.getElementById('inp-ddn-mois').value  = parts[1];
                document.getElementById('inp-ddn-jour').value  = parts[2];
            }

            // Bloquer la date début formation dans le passé (sécurité JS en plus du min="")
            const inputDebut = document.getElementById('inp-debut');
            if (inputDebut) {
                inputDebut.setAttribute('min', new Date().toISOString().split('T')[0]);
            }
        });

        // ══════════════════════════════════════════════════════════════
        // UTILITAIRES
        // ══════════════════════════════════════════════════════════════
        function showError(message) {
            const errorBox = document.getElementById('client-error-box');
            const errorMsg = document.getElementById('client-error-msg');
            errorMsg.innerText = message;
            errorBox.style.display = 'block';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function hideError() {
            document.getElementById('client-error-box').style.display = 'none';
        }

        function calculerAge(dateNaissanceStr) {
            if (!dateNaissanceStr) return 0;
            const aujourdhui = new Date();
            const dateNaissance = new Date(dateNaissanceStr);
            let age = aujourdhui.getFullYear() - dateNaissance.getFullYear();
            const mois = aujourdhui.getMonth() - dateNaissance.getMonth();
            if (mois < 0 || (mois === 0 && aujourdhui.getDate() < dateNaissance.getDate())) {
                age--;
            }
            return age;
        }

        // ══════════════════════════════════════════════════════════════
        // NAVIGATION ENTRE LES ÉTAPES
        // ══════════════════════════════════════════════════════════════
        function goToStep(step) {
            hideError();

            // ── VALIDATION ÉTAPE 1 → ÉTAPE 2 ──────────────────────────
            if (step === 2) {
                const nom      = document.getElementById('inp-nom').value.trim();
                const prenom   = document.getElementById('inp-prenom').value.trim();
                const ddn      = document.getElementById('inp-ddn').value;   // valeur du champ hidden
                const lieu     = document.getElementById('inp-lieu').value.trim();
                const tel      = document.getElementById('inp-tel').value.trim();
                const numPermis  = document.getElementById('inp-num-permis').value.trim();
                const lieuPermis = document.getElementById('inp-lieu-permis').value.trim();

                // Vérification que les 3 sélecteurs DDN sont remplis
                const ddnJour  = document.getElementById('inp-ddn-jour').value;
                const ddnMois  = document.getElementById('inp-ddn-mois').value;
                const ddnAnnee = document.getElementById('inp-ddn-annee').value;

                if (!nom || !prenom || !lieu || !tel) {
                    showError("Veuillez remplir tous les champs obligatoires (*) de l'étape 1.");
                    return;
                }

                if (!ddnJour || !ddnMois || !ddnAnnee) {
                    showError("Veuillez sélectionner le jour, le mois et l'année de naissance.");
                    return;
                }

                // Contrôle de l'âge >= 21 (redondant avec les listes mais sécurité supplémentaire)
                if (calculerAge(ddn) < 21) {
                    showError("L'âge requis doit être supérieur ou égal à 21 ans.");
                    return;
                }

                // Lieu de naissance : pas de chiffres
                if (/\d/.test(lieu)) {
                    showError("Le lieu de naissance ne doit pas contenir de chiffres.");
                    return;
                }

                // Téléphone : pas de lettres
                if (/[a-zA-Z]/.test(tel)) {
                    showError("Le numéro de téléphone ne doit pas contenir de lettres.");
                    return;
                }

                // Numéro permis : pas de lettres
                if (numPermis && /[a-zA-Z]/.test(numPermis)) {
                    showError("Le numéro de permis ne doit contenir que des chiffres.");
                    return;
                }

                // Lieu délivrance permis : pas de chiffres
                if (lieuPermis && /\d/.test(lieuPermis)) {
                    showError("Le lieu de délivrance du permis ne doit pas contenir de chiffres.");
                    return;
                }
            }

            // ── VALIDATION ÉTAPE 2 → ÉTAPE 3 ──────────────────────────
            if (step === 3) {
                const catSelect  = document.getElementById('inp-cat');
                const dateDebut  = document.getElementById('inp-debut').value;
                const dateInscr  = document.getElementById('inp-dateinscr').value;
                const nomDossier = document.getElementById('inp-nom-dossier').value.trim();
                const today      = new Date().toISOString().split('T')[0];

                if (!catSelect.value || !dateDebut) {
                    showError("Veuillez choisir une catégorie de permis et spécifier une date de début de formation.");
                    return;
                }

                // Contrôle : date début ne peut pas être dans le passé
                if (dateDebut < today) {
                    showError("La date de début de formation ne peut pas être une date passée.");
                    return;
                }

                // Contrôle syntaxique du format de date (AAAA-MM-JJ)
                const regexDate = /^\d{4}-\d{2}-\d{2}$/;
                if (!regexDate.test(dateDebut) || !regexDate.test(dateInscr)) {
                    showError("Le format des dates saisies est invalide.");
                    return;
                }

                // Sécurisation du nom de dossier
                if (nomDossier && !/^[a-zA-Z0-9_\-\sÀ-ÿ]+$/.test(nomDossier)) {
                    showError("Le nom du dossier contient des caractères non autorisés.");
                    return;
                }

                // ── Remplissage du récapitulatif ──
                document.getElementById('r-nom').innerText =
                    document.getElementById('inp-nom').value.toUpperCase() + ' ' +
                    document.getElementById('inp-prenom').value;

                // Formatage lisible de la date de naissance depuis le champ hidden
                const ddnVal = document.getElementById('inp-ddn').value;
                const ddnFormatee = ddnVal
                    ? new Date(ddnVal + 'T00:00:00').toLocaleDateString('fr-FR')
                    : '—';
                document.getElementById('r-naissance').innerText =
                    ddnFormatee + ' à ' + document.getElementById('inp-lieu').value;

                document.getElementById('r-tel').innerText =
                    document.getElementById('inp-tel').value;
                document.getElementById('r-email').innerText =
                    document.getElementById('inp-email').value || 'Non renseigné';

                // Permis existant
                const numP = document.getElementById('inp-num-permis').value;
                if (numP) {
                    document.getElementById('recap-permis-section').style.display = 'block';
                    document.getElementById('r-num-permis').innerText = numP;
                    const dateP = document.getElementById('inp-date-permis').value;
                    const datePFormatee = dateP
                        ? new Date(dateP + 'T00:00:00').toLocaleDateString('fr-FR')
                        : '—';
                    document.getElementById('r-deliv-permis').innerText =
                        datePFormatee + ' (' + (document.getElementById('inp-lieu-permis').value || '—') + ')';
                } else {
                    document.getElementById('recap-permis-section').style.display = 'none';
                }

                // Inscription
                document.getElementById('r-cat').innerText =
                    catSelect.options[catSelect.selectedIndex].text;
                document.getElementById('r-debut').innerText =
                    new Date(dateDebut + 'T00:00:00').toLocaleDateString('fr-FR');
                document.getElementById('r-dateinscr').innerText =
                    new Date(dateInscr + 'T00:00:00').toLocaleDateString('fr-FR');
                document.getElementById('r-nom-dossier').innerText =
                    nomDossier || 'Généré automatiquement';
            }

            // ── Bascule visuelle des blocs d'étapes ───────────────────
            document.getElementById('step1').style.display = (step === 1) ? 'block' : 'none';
            document.getElementById('step2').style.display = (step === 2) ? 'block' : 'none';
            document.getElementById('step3').style.display = (step === 3) ? 'block' : 'none';

            // ── Mise à jour de la barre de progression (Stepper) ──────
            for (let i = 1; i <= 3; i++) {
                const numNode = document.getElementById('snum' + i);
                const lblNode = document.getElementById('slbl' + i);

                if (i < step) {
                    numNode.className = 'step-num done';
                    numNode.innerHTML = '<i class="bi bi-check"></i>';
                    if (lblNode) lblNode.className = 'step-label done';
                } else if (i === step) {
                    numNode.className = 'step-num active';
                    numNode.innerText = i;
                    if (lblNode) lblNode.className = 'step-label active';
                } else {
                    numNode.className = 'step-num todo';
                    numNode.innerText = i;
                    if (lblNode) lblNode.className = 'step-label todo';
                }
            }

            window.scrollTo({ top: 0, behavior: 'instant' });
        }
    </script>
</body>
</html>
