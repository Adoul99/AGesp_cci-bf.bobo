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

    /* ===== DOCUMENT OFFICIEL — Format CFTRA ===== */
    .attestation-officielle {
        background:#fff; border:1.5px solid #000; padding:55px 65px 40px;
        color:#000; font-family:Georgia,'Times New Roman',serif; position:relative;
    }

    .att-letterhead { text-align:left; margin-bottom:35px; }
    .att-letterhead .lh-line {
        font-weight:700; font-size:0.95rem; line-height:1.45; display:inline-block;
        border-bottom:1px solid #000; padding-bottom:4px; margin-bottom:14px;
    }

    .att-title-box {
        display:block; width:fit-content; margin:0 auto 38px; padding:14px 34px;
        background:#e9e6f5; border:1px solid #6b6690; border-radius:10px;
        text-align:center; font-weight:700; font-size:1.05rem; letter-spacing:0.3px;
        color:#1a1a1a;
    }

    .att-body {
        font-size:1.02rem; line-height:2; text-align:justify; margin-bottom:28px;
    }
    .att-body strong { font-weight:700; }

    .att-table-intro { font-size:1.02rem; margin-bottom:14px; }
    .att-table {
        width:100%; border-collapse:collapse; margin-bottom:32px;
    }
    .att-table th, .att-table td {
        border:1px solid #000; padding:11px 16px; text-align:center;
        font-size:0.92rem; font-weight:700;
    }
    .att-table th { background:#f3f3f3; }

    .att-closing { font-size:1.02rem; line-height:1.8; margin-bottom:55px; }

    .att-signature-block {
        margin-left:auto; width:fit-content; text-align:center; font-size:0.98rem; line-height:2.1;
    }

    .att-doc-ref {
        position:absolute; bottom:14px; left:65px; font-size:0.68rem; color:#888; font-family:Georgia,serif;
    }

    .btn-group { display:flex; justify-content:center; gap:10px; margin-top: 10px;}
    .btn-print { background:var(--dk); color:white; border:none; border-radius:8px; padding:11px 24px; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.88rem; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-back { background:#e8f2ec; color:var(--v); border:none; border-radius:8px; padding:11px 24px; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.88rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }
    .btn-edit { background:rgba(212,160,23,0.15); color:#92400E; border:2px solid var(--o); border-radius:8px; padding:11px 24px; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.88rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }

    .footer { background:var(--dk); color:rgba(255,255,255,0.5); text-align:center; padding:15px; font-size:0.7rem; margin-top:20px; }
    .footer span { color:var(--o); }

    @media print {
        @page { size: A4; margin: 10mm 15mm; }

        /* Masquer TOUT ce qui n'est pas le document officiel, y compris la bande tricolore */
        .tricolor, .header, .btn-group, .footer, .no-print { display:none !important; }

        body { background:white; padding:0; margin:0; }
        .wrap { margin:0; padding:0; max-width:100%; width:100%; }
        .card { box-shadow:none; padding:0; margin:0; background:transparent; }

        /* Compression du contenu pour tenir sur une seule page A4 */
        .attestation-officielle {
            border:1.5px solid #000; margin:0; padding:22px 40px 18px; width:100%; box-sizing:border-box;
        }
        .att-letterhead { margin-bottom:18px; }
        .att-letterhead .lh-line { font-size:0.85rem; padding-bottom:2px; margin-bottom:8px; }

        .att-title-box { margin:0 auto 20px; padding:9px 22px; font-size:0.95rem; }

        .att-body { font-size:0.86rem; line-height:1.55; margin-bottom:16px; }

        .att-table-intro { font-size:0.86rem; margin-bottom:8px; }
        .att-table { margin-bottom:18px; }
        .att-table th, .att-table td { padding:6px 12px; font-size:0.76rem; }

        .att-closing { font-size:0.86rem; line-height:1.5; margin-bottom:22px; }

        .att-signature-block { font-size:0.82rem; line-height:1.6; }

        /* Référence document repositionnée en flux normal pour ne pas chevaucher */
        .att-doc-ref { position:static; margin-top:14px; text-align:left; }
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
    <a href="{{ (isset($modeCandidat) && $modeCandidat) ? route('candidat.espace') : route('attestations.index') }}" class="header-link"><i class="bi bi-arrow-left"></i> Retour</a>
</div>

<div class="wrap">
    <div class="card">

        <div class="attestation-officielle">
            <div class="att-letterhead">
                <span class="lh-line">Direction Régionale de Bobo-Dioulasso</span><br>
                <span class="lh-line">Service de la Formation Professionnelle</span><br>
                <span class="lh-line">Centre de Formation en Transport Routier<br>Et Activités Auxiliaires (CFTRA)</span>
            </div>

            <div class="att-title-box">
                ATTESTATION N°{{ $attestation->numeroAttestation }}
            </div>

            <div class="att-body">
                Je soussigné {{ $attestation->directeurCivilite ?? 'Monsieur' }} {{ $attestation->directeurNom ?? 'François DRABO' }}, Directeur Régional de Bobo-Dioulasso de
                la Chambre de Commerce et d'Industrie du Burkina Faso, atteste que {{ $attestation->civilite ?? 'Monsieur' }}
                <strong>{{ strtoupper($attestation->candidat->nom ?? '—') }} {{ $attestation->candidat->prenom ?? '' }}</strong>
                né(e) le <strong>{{ $attestation->candidat->dateNaissance ? \Carbon\Carbon::parse($attestation->candidat->dateNaissance)->format('d/m/Y') : '—' }}</strong>
                à <strong>{{ $attestation->candidat->lieuNaissance ?? '—' }}</strong>, titulaire du permis de conduire
                catégorie « C » N° <strong>{{ $attestation->candidat->numeroPermisC ?? '—' }}</strong>, délivré le
                <strong>{{ $attestation->candidat->dateDelivrancePermisC ? \Carbon\Carbon::parse($attestation->candidat->dateDelivrancePermisC)->format('d/m/Y') : '—' }}</strong>
                à <strong>{{ $attestation->candidat->lieuDelivrancePermisC ?? '—' }}</strong>, a suivi la formation relative
                au permis de conduire catégorie « {{ $attestation->categorieObtenue ?? 'E' }} » au Centre de
                Formation en Transport Routier et Activités Auxiliaires (CFTRA) du
                <strong>{{ $attestation->formationDateDebut ? \Carbon\Carbon::parse($attestation->formationDateDebut)->format('d/m/Y') : '—' }}</strong>
                au <strong>{{ $attestation->formationDateFin ? \Carbon\Carbon::parse($attestation->formationDateFin)->format('d/m/Y') : '—' }}</strong>
                et passé avec succès les examens y afférents, organisés par la Direction Régionale des Transports
                de la Mobilité Urbaine et de la Sécurité Routière des Hauts-Bassins.
            </div>

            <div class="att-table-intro">Les résultats des examens sont consignés dans le tableau ci-dessous :</div>

            <table class="att-table">
                <tr>
                    <th style="text-align:left;">EXAMENS DU PC/D</th>
                    <th>CODE</th>
                    <th>CONDUITE</th>
                </tr>
                <tr>
                    <td style="text-align:left;">DATES D'ADMISSION</td>
                    <td>{{ $attestation->dateAdmissionCode ? \Carbon\Carbon::parse($attestation->dateAdmissionCode)->format('d/m/Y') : '—' }}</td>
                    <td>{{ $attestation->dateAdmissionConduite ? \Carbon\Carbon::parse($attestation->dateAdmissionConduite)->format('d/m/Y') : '—' }}</td>
                </tr>
            </table>

            <div class="att-closing">
                La présente Attestation lui a été délivrée pour servir et valoir ce que de droit.
            </div>

            <div class="att-signature-block">
                Fait à Bobo-Dioulasso, {{ \Carbon\Carbon::parse($attestation->dateDelivrance)->format('d/m/Y') }}<br>
                Le Directeur Régional<br><br>
                <strong>{{ $attestation->directeurNom ?? 'François DRABO' }}</strong>
            </div>

            <div class="att-doc-ref">FOR/FR_02/NQ_02/V03</div>
        </div>

        <div class="btn-group no-print">
            <button onclick="window.print();" class="btn-print">
                <i class="bi bi-printer"></i> Imprimer l'attestation
            </button>
            @if(!isset($modeCandidat) || !$modeCandidat)
            <a href="{{ route('attestations.edit', $attestation->id) }}" class="btn-edit">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            @endif
            <a href="{{ (isset($modeCandidat) && $modeCandidat) ? route('candidat.espace') : route('attestations.index') }}" class="btn-back">
                <i class="bi bi-list"></i> Retour {{ (isset($modeCandidat) && $modeCandidat) ? 'à mon espace' : 'à la liste' }}
            </a>
        </div>

    </div>
</div>

<div class="footer">
    © {{ date('Y') }} <span>AGesp</span> — Auto-École GESP · CCI-BF · Tous droits réservés
</div>

</body>
</html>