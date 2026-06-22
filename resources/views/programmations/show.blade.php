<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste DGTTM — {{ $programmation->typeSession->type ?? 'Examen' }}</title>
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
    .wrap { max-width:900px; margin:30px auto; padding:0 20px; }
    .card { background:white; border-radius:14px; box-shadow:0 4px 20px rgba(26,107,58,0.12); padding:30px 32px; margin-bottom:20px; }

    .doc-officiel { background:#fff; border:2px solid #000; padding:35px; position:relative; overflow:hidden; }
    .doc-header { display:flex; justify-content:space-between; align-items:flex-start; font-size:0.82rem; font-weight:bold; line-height:1.4; border-bottom:2px double #000; padding-bottom:15px; margin-bottom:25px; }
    .doc-header-left { text-transform:uppercase; width:35%; }
    .doc-header-center { width:25%; text-align:center; }
    .doc-header-center img { max-height:60px; object-fit:contain; }
    .doc-header-right { text-align:right; width:35%; }
    .doc-meta-box { border:1px solid #000; padding:6px 10px; font-size:0.8rem; display:inline-block; text-align:left; margin-top:8px; line-height:1.4; background:#fafafa; }
    .doc-title-box { text-align:center; margin-bottom:25px; }
    .doc-title { font-family:'Nunito',sans-serif; font-size:1.4rem; font-weight:900; text-decoration:underline; text-transform:uppercase; letter-spacing:1px; margin-bottom:4px; }
    .doc-subtitle { font-size:0.9rem; font-style:italic; color:#111; }

    .info-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:24px; font-size:0.85rem; }
    .info-item { background:#f7f9f8; border:1px solid #ddd; border-radius:6px; padding:10px 14px; }
    .info-label { font-weight:700; color:#555; font-size:0.7rem; text-transform:uppercase; letter-spacing:0.04em; }
    .info-value { font-weight:800; color:#111; margin-top:3px; }

    table.liste-candidats { width:100%; border-collapse:collapse; font-size:0.88rem; margin-bottom:25px; }
    table.liste-candidats th { background:var(--v); color:white; padding:10px 12px; text-align:left; font-size:0.75rem; text-transform:uppercase; }
    table.liste-candidats td { padding:9px 12px; border-bottom:1px solid #ddd; }
    table.liste-candidats tr:nth-child(even) { background:#f7f9f8; }
    .rank-cell { font-weight:800; text-align:center; width:40px; }
    .note-cell { font-weight:800; text-align:center; color:var(--v); }

    .doc-signatures { display:flex; justify-content:space-between; font-size:0.9rem; font-weight:bold; margin-top:40px; }
    .doc-signatures div { text-align:center; width:45%; }
    .sig-line { margin-top:50px; border-top:1px solid #000; padding-top:6px; font-size:0.8rem; font-weight:400; }

    .btn-group { display:flex; justify-content:center; gap:10px; margin-top:20px; }
    .btn-print { background:var(--dk); color:white; border:none; border-radius:8px; padding:11px 24px; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.88rem; cursor:pointer; display:inline-flex; align-items:center; gap:7px; }
    .btn-back { background:#e8f2ec; color:var(--v); border:none; border-radius:8px; padding:11px 24px; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.88rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px; }

    @media print {
        @page { size: A4; margin: 10mm 15mm; }
        .header, .btn-group { display:none !important; }
        body { background:white; padding:0; margin:0; }
        .wrap { margin:0; padding:0; max-width:100%; }
        .card { box-shadow:none; padding:0; margin:0; }
        .doc-officiel { page-break-inside:avoid; }
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
    <a href="{{ route('programmations.index') }}" class="header-link"><i class="bi bi-arrow-left"></i> Retour à la liste</a>
</div>

<div class="wrap">
    <div class="card">

        @if(session('success'))
        <div style="margin-bottom:20px; padding:12px 16px; background:rgba(26,107,58,0.1); border-left:4px solid var(--v); border-radius:8px; color:var(--v); font-weight:600; font-size:0.85rem;">
            {{ session('success') }}
        </div>
        @endif

        <div class="doc-officiel">
            <div class="doc-header">
                <div class="doc-header-left">
                    CHAMBRE DE COMMERCE<br>
                    ET D'INDUSTRIE<br>
                    DU BURKINA FASO (CCI-BF)<br>
                    <span style="font-size:0.72rem; font-weight:normal; text-transform:none; color:#333;">Auto-École : GESP — Bobo-Dioulasso</span>
                </div>
                <div class="doc-header-center">
                    @if(file_exists(public_path('images/logo.jpeg')))
                        <img src="{{ asset('images/logo.jpeg') }}" alt="CCI-BF">
                    @elseif(file_exists(public_path('images/logo.png')))
                        <img src="{{ asset('images/logo.png') }}" alt="CCI-BF">
                    @endif
                </div>
                <div class="doc-header-right">
                    BURKINA FASO<br>
                    <span style="font-size:0.68rem; font-weight:normal; font-style:italic;">La Patrie ou la Mort, nous vaincrons</span>
                    <div class="doc-meta-box">
                        <strong>Réf. Programmation :</strong> #{{ str_pad($programmation->id, 5, '0', STR_PAD_LEFT) }}<br>
                        <strong>Date d'édition :</strong> {{ now()->format('d/m/Y') }}
                    </div>
                </div>
            </div>

            <div class="doc-title-box">
                <div class="doc-title">Liste des Candidats Programmés</div>
                <div class="doc-subtitle">
                    À transmettre à la Direction Générale des Transports Terrestres et Maritimes (DGTTM)
                </div>
            </div>

            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Type d'examen</div>
                    <div class="info-value">
                        @switch($programmation->typeSession->type ?? '')
                            @case('code') 📋 Code @break
                            @case('creneau') 🔧 Créneau @break
                            @case('conduite') 🚗 Conduite @break
                            @default —
                        @endswitch
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Période</div>
                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($programmation->dateDebut)->format('d/m/Y') }}
                        @if($programmation->dateFin && $programmation->dateFin != $programmation->dateDebut)
                            – {{ \Carbon\Carbon::parse($programmation->dateFin)->format('d/m/Y') }}
                        @endif
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Moniteur responsable</div>
                    <div class="info-value">
                        {{ $programmation->moniteur ? $programmation->moniteur->nom.' '.$programmation->moniteur->prenom : '—' }}
                    </div>
                </div>
            </div>

            <table class="liste-candidats">
                <thead>
                    <tr>
                        <th class="rank-cell">N°</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th class="note-cell">Note /30</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($candidats as $i => $c)
                    <tr>
                        <td class="rank-cell">{{ $i + 1 }}</td>
                        <td style="font-weight:700;">{{ $c->nom }}</td>
                        <td>{{ $c->prenom }}</td>
                        <td class="note-cell">{{ $c->meilleure_note ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="font-size:0.8rem; color:#555; margin-bottom:10px;">
                <strong>Total :</strong> {{ $candidats->count() }} candidat(s) programmé(s) pour cet examen.
            </div>

            <div class="doc-signatures">
                <div>
                    <div class="sig-line">Le Responsable Pédagogique</div>
                </div>
                <div>
                    <div class="sig-line">Le Chef de Centre GESP (CCI-BF)</div>
                </div>
            </div>
        </div>

        <div class="btn-group">
            <button onclick="window.print();" class="btn-print">
                <i class="bi bi-printer"></i> Imprimer la liste DGTTM
            </button>
            <a href="{{ route('programmations.edit', $programmation->id) }}" class="btn-back">
                <i class="bi bi-pencil"></i> Modifier
            </a>
            <a href="{{ route('programmations.index') }}" class="btn-back">
                <i class="bi bi-list"></i> Retour à la liste
            </a>
        </div>

    </div>
</div>

</body>
</html>