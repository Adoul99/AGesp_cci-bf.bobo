<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription confirmée — AGesp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
    :root { 
        --v:#1a6b3a; 
        --o:#d4a017; 
        --r:#c0281e; 
        --dk:#1a2520; 
    }
    body { font-family:'Source Sans 3',sans-serif; background:#f3f6f4; margin:0; padding-bottom: 40px; }
    .tricolor { height:5px; background:linear-gradient(90deg,var(--r) 0%,var(--r) 33%,var(--o) 33%,var(--o) 66%,var(--v) 66%,var(--v) 100%); }
    .header { background:linear-gradient(135deg,#0a1f0f,var(--v),#0f2e1c); padding:14px 30px; display:flex; align-items:center; gap:12px; }
    .logo-box { width:46px; height:46px; background:white; border-radius:8px; display:flex; align-items:center; justify-content:center; overflow:hidden; }
    .logo-box img { width:88%; height:88%; object-fit:contain; }
    .app-name { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.2rem; color:white; }
    .app-name span { color:var(--o); }
    
    .wrap { max-width:850px; margin:40px auto; padding:0 20px; }
    .success-card { background:white; border-radius:14px; box-shadow:0 4px 20px rgba(26,107,58,0.12); padding:35px 32px; text-align:center; margin-bottom: 30px; }
    .check-circle { width:70px; height:70px; background:var(--v); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 15px; box-shadow:0 4px 20px rgba(26,107,58,0.3); }
    .check-circle i { font-size:2.2rem; color:white; }
    h1 { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.4rem; color:var(--v); margin-bottom:8px; }
    
    /* STRUCTURE DU RÉCÉPISSÉ AVEC FILIGRANE CCI-BF */
    .recepisse-officiel {
        background: #ffffff;
        border: 2px solid #000000;
        padding: 40px;
        margin: 25px 0;
        text-align: left;
        color: #000000;
        position: relative;
        z-index: 1;
        overflow: hidden;
    }

    /* FILIGRANE TRANSPARENT CCI-BF EN ARRIÈRE-PLAN */
    .recepisse-officiel::before {
        content: "";
        position: absolute;
        top: 53%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 440px;
        height: 440px;
        background-image: url("{{ file_exists(public_path('images/logo.jpeg')) ? asset('images/logo.jpeg') : (file_exists(public_path('images/logo.png')) ? asset('images/logo.png') : '') }}");
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        opacity: 0.08;
        z-index: -1;
    }

    .recepisse-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        font-size: 0.82rem;
        font-weight: bold;
        line-height: 1.4;
        border-bottom: 2px double #000;
        padding-bottom: 15px;
        margin-bottom: 25px;
    }
    .recepisse-header-left {
        text-transform: uppercase;
        width: 35%;
    }
    .recepisse-header-center {
        width: 25%;
        text-align: center;
    }
    .recepisse-header-center img {
        max-height: 65px;
        object-fit: contain;
    }
    .recepisse-header-right {
        text-align: right;
        width: 35%;
    }
    .recepisse-meta-box {
        border: 1px solid #000;
        padding: 6px 10px;
        font-size: 0.82rem;
        display: inline-block;
        text-align: left;
        margin-top: 8px;
        line-height: 1.4;
        background: #fafafa;
    }
    .recepisse-title-box {
        text-align: center;
        margin-bottom: 25px;
    }
    .recepisse-title {
        font-family: 'Nunito', sans-serif;
        font-size: 1.6rem;
        font-weight: 900;
        text-decoration: underline;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 4px;
    }
    .recepisse-subtitle {
        font-size: 0.95rem;
        font-style: italic;
        color: #111;
    }
    .recepisse-grid {
        display: grid;
        grid-template-columns: 240px 1fr;
        row-gap: 16px;
        font-size: 1.15rem;
        margin-bottom: 30px;
        align-items: center;
    }
    .recepisse-label {
        font-weight: bold;
    }
    .recepisse-value {
        border-bottom: 1px dashed #000;
        padding-left: 8px;
        padding-bottom: 2px;
    }
    .recepisse-value.highlight {
        font-weight: 900;
        text-transform: uppercase;
    }
    .recepisse-nb {
        font-size: 0.82rem;
        border-top: 1px dashed #000;
        padding-top: 10px;
        margin-bottom: 40px;
        line-height: 1.5;
        color: #111;
    }
    .recepisse-signatures {
        display: flex;
        justify-content: space-between;
        font-size: 0.95rem;
        font-weight: bold;
        padding-bottom: 10px;
    }

    .steps-list { text-align:left; background:#fdf8e1; border:1px solid var(--o); border-radius:8px; padding:14px 18px; margin-bottom:24px; }
    .steps-list li { font-size:0.82rem; color:var(--dk); padding:4px 0; display:flex; align-items:flex-start; gap:8px; }
    .steps-list li i { color:var(--v); flex-shrink:0; margin-top:2px; }
    
    .btn-group-responsive { display: flex; justify-content: center; gap: 10px; }
    .btn-home { background:var(--v); color:white; border:none; border-radius:8px; padding:11px 24px; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.88rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px; transition:background 0.18s; }
    .btn-home:hover { background:#22883f; color:white; }
    .btn-new { background:#e8f2ec; color:var(--v); border:none; border-radius:8px; padding:11px 24px; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.88rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px; transition:background 0.18s; }
    .btn-new:hover { background:#d0e8d8; color:var(--v); }
    .btn-print { background:var(--dk); color:white; border:none; border-radius:8px; padding:11px 24px; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.88rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px; transition:opacity 0.18s; }
    .btn-print:hover { opacity: 0.9; color: white; }
    
    .footer { background:var(--dk); color:rgba(255,255,255,0.5); text-align:center; padding:15px; font-size:0.7rem; margin-top:30px; }
    .footer span { color:var(--o); }
    
    @media print {
        @page {
            size: A4;
            margin: 10mm 15mm;
        }
        .header, .check-circle, h1, .success-card > p, .steps-list, .btn-group-responsive, .footer { display: none !important; }
        body { background: white; padding: 0; margin: 0; }
        .wrap { margin: 0; padding: 0; max-width: 100%; width: 100%; }
        .success-card { box-shadow: none; padding: 0; margin: 0; background: transparent; }
        
        .recepisse-officiel { 
            border: 2px solid #000000;
            margin: 0; 
            padding: 25px;
            width: 100%;
            box-sizing: border-box;
            page-break-inside: avoid;
        }
        .recepisse-officiel::before { 
            opacity: 0.07; 
            -webkit-print-color-adjust: exact; 
            print-color-adjust: exact; 
        }
        .recepisse-grid { row-gap: 12px; }
    }

    @media (max-width: 768px) {
        .btn-group-responsive { flex-direction: column; gap: 10px; }
        .btn-new, .btn-home, .btn-print { width: 100%; justify-content: center; }
    }
    </style>
</head>
<body>

<div class="tricolor"></div>
<div class="header">
    <div class="logo-box">
        @if(file_exists(public_path('images/logo.jpeg')))
            <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
        @elseif(file_exists(public_path('images/logo.png')))
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
        @else
            <span style="font-family:'Nunito',sans-serif;font-weight:900;color:#1a6b3a;">AG</span>
        @endif
    </div>
    <div>
        <div class="app-name">A<span>G</span>esp</div>
        <div style="font-size:0.68rem;color:rgba(255,255,255,0.6);">Système de Gestion Auto-École · CCI-BF</div>
    </div>
</div>

<div class="wrap">
    <div class="success-card">

        <div class="check-circle">
            <i class="bi bi-check-lg"></i>
        </div>

        <h1>Inscription confirmée avec succès !</h1>
        <p style="font-size:0.95rem;color:#6b7a70;">
            Félicitations, votre dossier en ligne a été transmis. Un dossier lié à votre inscription a bien été créé et pourra être vérifié par l'administration.
            Veuillez imprimer votre récépissé officiel ci-dessous.
        </p>

        <div class="recepisse-officiel">
            <div class="recepisse-header">
                <div class="recepisse-header-left">
                    CHAMBRE DE COMMERCE<br>
                    ET D'INDUSTRIE<br>
                    DU BURKINA FASO (CCI-BF)<br>
                    <span style="font-size:0.75rem; font-weight:normal; text-transform:none; color:#333;">Auto-École : GESP — Bobo-Dioulasso</span>
                </div>
                
                <div class="recepisse-header-center">
                    @if(file_exists(public_path('images/logo.jpeg')))
                        <img src="{{ asset('images/logo.jpeg') }}" alt="CCI-BF">
                    @elseif(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="CCI-BF">
                    @endif
                </div>

                <div class="recepisse-header-right">
                    BURKINA FASO<br>
                    <span style="font-size:0.7rem; font-weight:normal; font-style:italic;">La Patrie ou la Mort, nous vaincrons</span>
                    <br>
                    <div class="recepisse-meta-box">
                        <strong>N° Récépissé :</strong> {{ session('reference') ?? 'GESP-2026-00005' }}<br>
                        <strong>Date d'inscription :</strong> {{ session('dateInscription') ? \Carbon\Carbon::parse(session('dateInscription'))->format('d/m/Y') : date('d/m/Y') }}
                    </div>
                </div>
            </div>

            <div class="recepisse-title-box">
                <div class="recepisse-title">Récépissé d'Inscription</div>
                <div class="recepisse-subtitle">Candidat à la formation théorique et pratique du permis de conduire</div>
            </div>

            <div class="recepisse-grid">
                <div class="recepisse-label">Nom du candidat :</div>
                <div class="recepisse-value highlight">{{ session('nom') ?? (explode(' ', session('candidat_nom'))[0] ?? '—') }}</div>

                <div class="recepisse-label">Prénom(s) :</div>
                <div class="recepisse-value" style="text-transform: capitalize;">{{ session('prenom') ?? (substr(strstr(session('candidat_nom'), ' '), 1) ?? '—') }}</div>

                <div class="recepisse-label">Téléphone :</div>
                <div class="recepisse-value">{{ session('telephone', '—') }}</div>

                <div class="recepisse-label">Date de naissance :</div>
                <div class="recepisse-value">
                    {{ session('dateNaissance') ? \Carbon\Carbon::parse(session('dateNaissance'))->format('d/m/Y') : '—' }}
                </div>

                <div class="recepisse-label">Lieu de naissance :</div>
                <div class="recepisse-value" style="text-transform: capitalize;">{{ session('lieuNaissance', '—') }}</div>

                <div class="recepisse-label">Catégorie sollicitée :</div>
                <div class="recepisse-value highlight" style="color: var(--v);">{{ session('categorie_nom', '—') }}</div>
            </div>

            <div class="recepisse-nb">
                <strong>NB :</strong><br>
                - Le candidat est tenu de se présenter à l'auto-école muni de ce récépissé imprimé et de sa pièce d'identité (CNIB).<br>
                - Ce document officiel n'est valable qu'après vérification des pièces physiques et règlement complet ou partiel des frais.<br>
                - Toute falsification ou altération de ce document l'expose à des poursuites réglementaires.
            </div>

            <div class="recepisse-signatures">
                <div><u>Signature du candidat</u></div>
                <div><u>Le Chef de Centre GESP (CCI-BF)</u></div>
            </div>
        </div>

        <div class="steps-list">
            <p style="font-family:'Nunito',sans-serif;font-weight:700;font-size:0.8rem;color:var(--dk);margin-bottom:8px;">
                <i class="bi bi-list-check" style="color:var(--v);"></i> Rappel des étapes suivantes :
            </p>
            <ul style="list-style:none;padding:0;margin:0;">
                <li class="mb-1"><i class="bi bi-1-circle-fill"></i> Présentez ce récépissé imprimé au guichet de l'auto-école.</li>
                <li class="mb-1"><i class="bi bi-2-circle-fill"></i> Fournissez une photocopie de votre pièce d'identité (CNIB/Passeport).</li>
                <li class="mb-1"><i class="bi bi-3-circle-fill"></i> Validez votre inscription via le règlement de la formule choisie.</li>
            </ul>
        </div>

        <div class="btn-group-responsive">
            <button onclick="window.print();" class="btn-print">
                <i class="bi bi-printer"></i> Imprimer le récépissé
            </button>
            <a href="{{ url('/s-inscrire') }}" class="btn-new">
                <i class="bi bi-plus-circle"></i> Nouvelle inscription
            </a>
            <a href="{{ url('/') }}" class="btn-home">
                <i class="bi bi-house"></i> Retour à l'accueil
            </a>
        </div>

    </div>
</div>

<div class="footer">
    © {{ date('Y') }} <span>AGesp</span> — Auto-École GESP · CCI-BF · Tous droits réservés
</div>

</body>
</html>