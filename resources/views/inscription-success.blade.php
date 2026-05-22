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
    body { font-family:'Source Sans 3',sans-serif; background:#f3f6f4; margin:0; }
    .tricolor { height:5px; background:linear-gradient(90deg,var(--r) 0%,var(--r) 33%,var(--o) 33%,var(--o) 66%,var(--v) 66%,var(--v) 100%); }
    .header { background:linear-gradient(135deg,#0a1f0f,var(--v),#0f2e1c); padding:14px 30px; display:flex; align-items:center; gap:12px; }
    .logo-box { width:46px; height:46px; background:white; border-radius:8px; display:flex; align-items:center; justify-content:center; overflow:hidden; }
    .logo-box img { width:88%; height:88%; object-fit:contain; }
    .app-name { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.2rem; color:white; }
    .app-name span { color:var(--o); }
    .wrap { max-width:600px; margin:40px auto; padding:0 20px; text-align:center; }
    .success-card { background:white; border-radius:14px; box-shadow:0 4px 20px rgba(26,107,58,0.12); padding:40px 32px; }
    .check-circle { width:80px; height:80px; background:var(--v); border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 20px; box-shadow:0 4px 20px rgba(26,107,58,0.3); }
    .check-circle i { font-size:2.5rem; color:white; }
    h1 { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.5rem; color:var(--v); margin-bottom:8px; }
    .ref-box { background:#e8f2ec; border:2px solid var(--v); border-radius:10px; padding:14px 20px; margin:20px auto; display:inline-block; }
    .ref-label { font-size:0.72rem; color:#6b7a70; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; }
    .ref-val { font-family:'Nunito',sans-serif; font-weight:900; font-size:1.4rem; color:var(--v); }
    .info-text { font-size:0.85rem; color:#6b7a70; line-height:1.7; margin:16px 0 24px; }
    .steps-list { text-align:left; background:#fdf8e1; border:1px solid var(--o); border-radius:8px; padding:14px 18px; margin-bottom:24px; }
    .steps-list li { font-size:0.82rem; color:var(--dk); padding:4px 0; display:flex; align-items:flex-start; gap:8px; }
    .steps-list li i { color:var(--v); flex-shrink:0; margin-top:2px; }
    
    /* Boutons de navigation */
    .btn-home { background:var(--v); color:white; border:none; border-radius:8px; padding:11px 24px; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.88rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px; transition:background 0.18s; }
    .btn-home:hover { background:#22883f; color:white; }
    .btn-new { background:#e8f2ec; color:var(--v); border:none; border-radius:8px; padding:11px 24px; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.88rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px; transition:background 0.18s; margin-right:10px; }
    .btn-new:hover { background:#d0e8d8; color:var(--v); }
    .btn-print { background:#fff; color:var(--dk); border:1px solid #ccc; border-radius:8px; padding:11px 24px; font-family:'Nunito',sans-serif; font-weight:700; font-size:0.88rem; cursor:pointer; text-decoration:none; display:inline-flex; align-items:center; gap:7px; transition:background 0.18s; margin-right:10px; }
    .btn-print:hover { background:#f3f6f4; color:var(--dk); }
    
    .footer { background:var(--dk); color:rgba(255,255,255,0.5); text-align:center; padding:15px; font-size:0.7rem; margin-top:30px; }
    .footer span { color:var(--o); }
    
    /* Gestion de l'impression */
    @media print {
        .header, .btn-new, .btn-home, .btn-print, .footer { display: none !important; }
        body { background: white; }
        .wrap { margin: 0 auto; max-width: 100%; }
        .success-card { box-shadow: none; padding: 20px 0; }
    }

    @media (max-width: 768px) {
        .btn-group-responsive { display: flex; flex-direction: column; gap: 10px; }
        .btn-new, .btn-home, .btn-print { margin-right: 0 !important; width: 100%; justify-content: center; }
    }
    </style>
</head>
<body>

<div class="tricolor"></div>
<div class="header">
    <div class="logo-box">
        {{-- Vérification simplifiée et robuste de l'image --}}
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

        <h1>Inscription confirmée !</h1>
        <p style="font-size:0.9rem;color:#6b7a70;">
            Félicitations <strong style="color:var(--dk);">{{ session('candidat_nom') ?? 'Candidat' }}</strong>,
            votre inscription a été enregistrée avec succès.
        </p>

        <div class="ref-box">
            <div class="ref-label">Votre numéro de référence</div>
            <div class="ref-val">{{ session('reference') ?? 'GESP-XXXXX' }}</div>
        </div>

        <p class="info-text">
            Conservez précieusement ce numéro de référence — il vous sera demandé lors de vos démarches de validation à l'auto-école.
        </p>

        <div class="steps-list">
            <p style="font-family:'Nunito',sans-serif;font-weight:700;font-size:0.8rem;color:var(--dk);margin-bottom:8px;">
                <i class="bi bi-list-check" style="color:var(--v);"></i> Prochaines étapes :
            </p>
            <ul style="list-style:none;padding:0;margin:0;">
                <li class="mb-1"><i class="bi bi-1-circle-fill"></i> Se présenter à l'auto-école muni de votre référence</li>
                <li class="mb-1"><i class="bi bi-2-circle-fill"></i> Fournir les pièces justificatives manquantes (CNIB, Photos d'identité)</li>
                <li class="mb-1"><i class="bi bi-3-circle-fill"></i> Procéder au règlement des frais requis</li>
                <li><i class="bi bi-4-circle-fill"></i> Démarrer les sessions théoriques et pratiques à la date convenue</li>
            </ul>
        </div>

        <div class="btn-group-responsive">
            <button onclick="window.print();" class="btn-print">
                <i class="bi bi-printer"></i> Imprimer le reçu
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