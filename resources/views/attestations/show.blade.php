<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attestation — {{ $attestation->numeroAttestation }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700;800;900&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
    :root { --v:#1a6b3a; --o:#d4a017; --r:#c0281e; --dk:#1a2520; }
    body { font-family:'Source Sans 3',sans-serif; background:#f3f6f4; margin:0; padding-bottom:40px; }
    .tricolor { height:5px; background:linear-gradient(90deg,var(--r) 0%,var(--r) 33%,var(--o) 33%,var(--o) 66%,var(--v) 66%,var(--v) 100%); }
    .header { background:linear-gradient(135deg,#0a1f0f,var(--v),#0f2e1c); padding:14px 30px; display:flex; align-items:center; justify-content:space-between; }
    .header-left { display:flex; align-items:center; gap:12px; }
    .logo-box { width:46px; height:46px; background:white; border-radius:8px; display:flex; align-items:center; justify-content:center; overflow:hidden; }
    .logo-box img { width:88%; height:88%; object-fit:contain; }
    .app-name { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.2rem; color:white; }
    .app-name span { color:var(--o); }
    .header-link { color:rgba(255,255,255,.75); text-decoration:none; font-size:.8rem; }

    .wrap { max-width:850px; margin:30px auto; padding:0 20px; }
    .card { background:white; border-radius:14px; box-shadow:0 4px 20px rgba(26,107,58,0.12); padding:30px 32px; margin-bottom:20px; }

    /* DOCUMENT OFFICIEL avec filigrane */
    .attestation-officielle {
        background:#fff; border:2px solid #000; padding:40px; margin:0; text-align:left;
        color:#000; position:relative; z-index:1; overflow:hidden;
    }
    .attestation-officielle::before {
        content:""; position:absolute; top:53%; left:50%; transform:translate(-50%,-50%);
        width:420px; height:420px;
        background-image: url("{{ file_exists(public_path('images/logo.jpeg')) ? asset('images/logo.jpeg') : (file_exists(public_path('images/logo.png')) ? asset('images/logo.png') : '') }}");
        background-size:contain; background-repeat:no-repeat; background-position:center;
        opacity:0.07; z-index:-1;
    }
    .att-header {
        display:flex; justify-content:space-between; align-items:flex-start;
        font-size:0.82rem; font-weight:bold; line-height:1.4;
        border-bottom:2px double #000; padding-bottom:15px; margin-bottom:25px;
    }
    .att-header-left { text-transform:uppercase; width:35%; }
    .att-header-center { width:25%; text-align:center; }
    .att-header-center img { max-height:65px; object-fit:contain; }
    .att-header-right { text-align:right; width:35%; }
    .att-meta-box {
        border:1px solid #000; padding:6px 10px; font-size:0.82rem;
        display:inline-block; text-align:left; margin-top:8px; line-height:1.4; background:#fafafa;
    }
    .att-title-box { text-align:center; margin-bottom:30px; }
    .att-title {
        font-family:'Nunito',sans-serif; font-size:1.75rem; font-weight:900;
        text-decoration:underline; text-transform:uppercase; letter-spacing:1px; margin-bottom:6px;
        color: var(--v);
    }
    .att-subtitle { font-size:1rem; font-style:italic; color:#111; }

    .att-body {
        font-size:1.05rem; line-height:1.9; text-align:justify; margin-bottom:30px;
        padding: 0 10px;
    }
    .att-body .highlight {
        font-weight:900; text-transform:uppercase; text-decoration:underline;
    }
    .att-body .highlight-cat {
        font-weight:900; color:var(--v);
    }

    .att-result-box {
        background: rgba(26,107,58,0.08);
        border: 2px solid var(--v);
        border-radius: 8px;
        padding: 16px 20px;
        margin-bottom: 30px;
        text-align: center;
    }
    .att-result-label { font-size:0.78rem; text-transform:uppercase; letter-spacing:0.05em; color:#444; font-weight:700; margin-bottom:6px; }
    .att-result-value { font-family:'Nunito',sans-serif; font-size:1.4rem; font-weight:900; color:var(--v); }

    .att-nb {
        font-size:0.82rem; border-top:1px dashed #000; padding-top:10px;
        margin-bottom:45px; line-height:1.5; color:#111;
    }
    .att-signatures {
        display:flex; justify-content:space-between; font-size:0.95rem; font-weight:bold; padding-bottom:10px;
    }
    .att-signatures div { text-align:center; width:45%; }
    .att-signature-line { margin-top:50px; border-top:1px solid #000; padding-top:6px; font-size:0.8rem; font-weight:400; }

    .btn-group { display:flex; justify-content:center; gap:10px; margin-top: 10px;}
    .btn-print { background:var(--dk); color:white; border:none; border-radius:8px; padding:11px 24px; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.88rem; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-back { background:#e8f2ec; color:var(--v); border:none; border-radius:8px; padding:11px 24px; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.88rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-edit { background:rgba(212,160,23,0.15); color:#92400E; border:2px solid var(--o); border-radius:8px; padding:11px 24px; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.88rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }

    .footer { background:var(--dk); color:rgba(255,255,255,0.5); text-align:center; padding:15px; font-size:0.7rem; margin-top:20px; }
    .footer span { color:var(--o); }

    @media print {
        @page { size: A4; margin: 10mm 15mm; }
        .header, .btn-group, .footer, .no-print { display:none !important; }
        body { background:white; padding:0; margin:0; }
        .wrap { margin:0; padding:0; max-width:100%; width:100%; }
        .card { box-shadow:none; padding:0; margin:0; background:transparent; }
        .attestation-officielle {
            border:2px solid #000; margin:0; padding:25px; width:100%; box-sizing:border-box;
            page-break-inside: avoid;
        }
        .attestation-officielle::before { opacity:0.06; -webkit-print-color-adjust:exact; print-color-adjust:exact; }
    }
    </style>
</head>
<body>

<div class="tricolor"></div>
<div class="header">
    <div class="header-left">
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
    <a href="{{ route('attestations.index') }}" class="header-link"><i class="bi bi-arrow-left"></i> Retour à la liste</a>
</div>

<div class="wrap">
    <div class="card">

        <div class="attestation-officielle">
            <div class="att-header">
                <div class="att-header-left">
                    CHAMBRE DE COMMERCE<br>
                    ET D'INDUSTRIE<br>
                    DU BURKINA FASO (CCI-BF)<br>
                    <span style="font-size:0.75rem; font-weight:normal; text-transform:none; color:#333;">Auto-École : GESP — Bobo-Dioulasso</span>
                </div>

                <div class="att-header-center">
                    @if(file_exists(public_path('images/logo.jpeg')))
                        <img src="{{ asset('images/logo.jpeg') }}" alt="CCI-BF">
                    @elseif(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="CCI-BF">
                    @endif
                </div>

                <div class="att-header-right">
                    BURKINA FASO<br>
                    <span style="font-size:0.7rem; font-weight:normal; font-style:italic;">La Patrie ou la Mort, nous vaincrons</span>
                    <br>
                    <div class="att-meta-box">
                        <strong>N° Attestation :</strong> {{ $attestation->numeroAttestation }}<br>
                        <strong>Date de délivrance :</strong> {{ \Carbon\Carbon::parse($attestation->dateDelivrance)->format('d/m/Y') }}
                    </div>
                </div>
            </div>

            <div class="att-title-box">
                <div class="att-title">Attestation de Réussite</div>
                <div class="att-subtitle">Formation théorique et pratique au permis de conduire</div>
            </div>

            <div class="att-body">
                Le Chef de Centre de l'Auto-École <strong>GESP</strong>, agréée par la Chambre de Commerce
                et d'Industrie du Burkina Faso (CCI-BF), atteste par la présente que :
                <br><br>
                <span class="highlight">{{ $attestation->candidat->nom ?? '—' }} {{ $attestation->candidat->prenom ?? '' }}</span>,
                né(e) le <strong>{{ $attestation->candidat->dateNaissance ? \Carbon\Carbon::parse($attestation->candidat->dateNaissance)->format('d/m/Y') : '—' }}</strong>
                à <strong>{{ $attestation->candidat->lieuNaissance ?? '—' }}</strong>,
                titulaire du permis de conduire catégorie C n°
                <strong>{{ $attestation->candidat->numeroPermisC ?? '—' }}</strong>,
                a suivi avec assiduité l'ensemble de la formation théorique (Code de la route)
                et pratique (Créneaux et Conduite) au sein de notre établissement, et a satisfait
                avec succès à l'ensemble des évaluations requises pour l'obtention du
                <span class="highlight-cat">Permis E (catégorie poids lourd / transport professionnel)</span>.
            </div>

            <div class="att-result-box">
                <div class="att-result-label">Résultat Final</div>
                <div class="att-result-value">✅ ADMIS — Code, Créneau & Conduite validés</div>
            </div>

            @if($attestation->examen)
            <div style="margin-bottom:25px; font-size:0.9rem; color:#333;">
                <strong>Examen de référence :</strong> {{ $attestation->examen->libelle }}
                ({{ \Carbon\Carbon::parse($attestation->examen->dateDebut)->format('d/m/Y') }})
            </div>
            @endif

            <div class="att-nb">
                <strong>NB :</strong><br>
                - La présente attestation est délivrée à titre de justificatif de formation et ne saurait
                se substituer au permis de conduire officiel délivré par les services compétents de l'État.<br>
                - Toute falsification ou altération de ce document expose son auteur à des poursuites réglementaires.<br>
                - Ce document est valable sur présentation conjointe avec une pièce d'identité.
            </div>

            <div class="att-signatures">
                <div>
                    Fait à Bobo-Dioulasso, le {{ \Carbon\Carbon::parse($attestation->dateDelivrance)->format('d/m/Y') }}
                    <div class="att-signature-line">Le Candidat</div>
                </div>
                <div>
                    &nbsp;
                    <div class="att-signature-line">Le Chef de Centre GESP (CCI-BF)</div>
                </div>
            </div>
        </div>

        <div class="btn-group no-print">
            <button onclick="window.print();" class="btn-print">
                <i class="bi bi-printer"></i> Imprimer l'attestation
            </button>
            <a href="{{ route('attestations.edit', $attestation->id) }}" class="btn-edit">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <a href="{{ route('attestations.index') }}" class="btn-back">
                <i class="bi bi-list"></i> Retour à la liste
            </a>
        </div>

    </div>
</div>

<div class="footer">
    © {{ date('Y') }} <span>AGesp</span> — Auto-École GESP · CCI-BF · Tous droits réservés
</div>

</body>
</html>
