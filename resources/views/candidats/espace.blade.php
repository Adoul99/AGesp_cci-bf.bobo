<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace — AGesp</title>
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
        --mid: #f0f4f1;
        --brd: #dde5e0;
        --sub: #6b7a70;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
        font-family: 'Source Sans 3', sans-serif;
        background: var(--mid);
        color: var(--dk);
        min-height: 100vh;
        font-size: 14px;
    }

    /* ── BARRE TRICOLORE ── */
    .tricolor {
        height: 5px;
        background: linear-gradient(90deg,
            var(--r) 0%, var(--r) 33%,
            var(--o) 33%, var(--o) 66%,
            var(--v) 66%, var(--v) 100%);
    }

    /* ── HEADER ── */
    .header {
        background: linear-gradient(135deg, #0a2415 0%, var(--v) 50%, #0d3520 100%);
        padding: 14px 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .header-left { display: flex; align-items: center; gap: 12px; }
    .logo-box {
        width: 44px; height: 44px; background: white;
        border-radius: 8px; display: flex; align-items: center;
        justify-content: center; overflow: hidden; flex-shrink: 0;
    }
    .logo-box img { width: 88%; height: 88%; object-fit: contain; }
    .logo-name { font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 1.25rem; color: white; }
    .logo-name em { color: var(--o); font-style: normal; }
    .logo-sub { font-size: .65rem; color: rgba(255,255,255,.55); }
    .header-right { display: flex; align-items: center; gap: 10px; }
    .user-pill {
        display: flex; align-items: center; gap: 8px;
        background: rgba(255,255,255,.12); border-radius: 20px;
        padding: 6px 14px; color: white; font-size: .8rem;
    }
    .user-pill i { color: var(--o); }
    .btn-logout {
        display: flex; align-items: center; gap: 6px;
        background: rgba(192,40,30,.25); border: 1px solid rgba(192,40,30,.4);
        color: white; border-radius: 8px; padding: 7px 14px;
        font-size: .78rem; font-family: 'Nunito', sans-serif;
        font-weight: 700; cursor: pointer; text-decoration: none;
        transition: background .2s;
    }
    .btn-logout:hover { background: rgba(192,40,30,.45); color: white; }

    /* ── NAV TABS ── */
    .nav-tabs-wrap {
        background: var(--v);
        padding: 0 28px;
        display: flex; gap: 2px;
    }
    .nav-tab {
        display: flex; align-items: center; gap: 7px;
        padding: 11px 18px;
        color: rgba(255,255,255,.75); font-size: .8rem;
        font-family: 'Nunito', sans-serif; font-weight: 700;
        border-bottom: 3px solid transparent;
        cursor: pointer; transition: all .2s; border: none;
        background: none; text-decoration: none;
    }
    .nav-tab:hover, .nav-tab.active {
        color: white; border-bottom-color: var(--o);
        background: rgba(255,255,255,.08);
    }

    /* ── CONTENU ── */
    .page-body { max-width: 1100px; margin: 24px auto; padding: 0 20px; }

    /* ── BANNIÈRE BIENVENUE ── */
    .welcome-banner {
        background: linear-gradient(135deg, var(--v) 0%, var(--vc) 100%);
        border-radius: 12px;
        padding: 22px 26px;
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px;
        color: white;
    }
    .welcome-banner h2 {
        font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 1.3rem;
        margin-bottom: 4px;
    }
    .welcome-banner p { font-size: .83rem; opacity: .8; }
    .welcome-icon { font-size: 3rem; opacity: .3; }

    /* ── CARTES STATUT ── */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 20px;
    }
    .stat-card {
        background: white; border-radius: 10px;
        padding: 18px 16px;
        box-shadow: 0 1px 6px rgba(26,107,58,.08);
        border-left: 4px solid var(--brd);
        display: flex; align-items: center; gap: 14px;
    }
    .stat-card.green  { border-left-color: var(--v); }
    .stat-card.orange { border-left-color: var(--o); }
    .stat-card.red    { border-left-color: var(--r); }
    .stat-card.blue   { border-left-color: #2563eb; }
    .stat-icon {
        width: 44px; height: 44px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.3rem; flex-shrink: 0;
    }
    .stat-icon.green  { background: var(--vp); color: var(--v); }
    .stat-icon.orange { background: var(--op); color: var(--o); }
    .stat-icon.red    { background: var(--rp); color: var(--r); }
    .stat-icon.blue   { background: #eff6ff; color: #2563eb; }
    .stat-val { font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 1.4rem; color: var(--dk); }
    .stat-lbl { font-size: .72rem; color: var(--sub); }

    /* ── SECTIONS ── */
    .section { display: none; }
    .section.active { display: block; }

    /* ── CARD ── */
    .card {
        background: white; border-radius: 10px;
        box-shadow: 0 1px 6px rgba(26,107,58,.08);
        overflow: hidden; margin-bottom: 16px;
    }
    .card-head {
        padding: 12px 18px;
        background: var(--vp);
        border-bottom: 2px solid var(--v);
        font-family: 'Nunito', sans-serif; font-weight: 700; font-size: .88rem;
        color: var(--v); display: flex; align-items: center; gap: 8px;
    }
    .card-body { padding: 18px; }

    /* ── BADGE STATUT ── */
    .badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 12px; border-radius: 20px;
        font-family: 'Nunito', sans-serif; font-weight: 700; font-size: .72rem;
    }
    .badge-attente  { background: var(--op); color: var(--o); }
    .badge-accepte  { background: var(--vp); color: var(--v); }
    .badge-refuse   { background: var(--rp); color: var(--r); }
    .badge-actif    { background: var(--vp); color: var(--v); }
    .badge-info     { background: #eff6ff; color: #2563eb; }

    /* ── GRANDE CARTE STATUT INSCRIPTION ── */
    .statut-card {
        border-radius: 12px; padding: 26px;
        margin-bottom: 16px; border: 2px solid;
        display: flex; align-items: flex-start; gap: 20px;
    }
    .statut-card.attente { background: var(--op); border-color: var(--o); }
    .statut-card.accepte { background: var(--vp); border-color: var(--v); }
    .statut-card.refuse  { background: var(--rp); border-color: var(--r); }
    .statut-icon { font-size: 2.5rem; flex-shrink: 0; }
    .statut-card.attente .statut-icon { color: var(--o); }
    .statut-card.accepte .statut-icon { color: var(--v); }
    .statut-card.refuse  .statut-icon { color: var(--r); }
    .statut-title {
        font-family: 'Nunito', sans-serif; font-weight: 900; font-size: 1.15rem;
        margin-bottom: 6px;
    }
    .statut-desc { font-size: .82rem; color: var(--sub); line-height: 1.6; }

    /* ── TIMELINE ── */
    .timeline { padding: 4px 0; }
    .tl-item {
        display: flex; gap: 14px; padding: 10px 0;
        border-bottom: 1px solid var(--brd);
        align-items: flex-start;
    }
    .tl-item:last-child { border-bottom: none; }
    .tl-dot {
        width: 32px; height: 32px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: .8rem; flex-shrink: 0; margin-top: 2px;
    }
    .tl-dot.done  { background: var(--vp); color: var(--v); }
    .tl-dot.wait  { background: var(--op); color: var(--o); }
    .tl-dot.todo  { background: #f1f5f9; color: #94a3b8; }
    .tl-dot.fail  { background: var(--rp); color: var(--r); }
    .tl-text strong { display: block; font-size: .82rem; font-weight: 700; }
    .tl-text span   { font-size: .75rem; color: var(--sub); }

    /* ── TABLE ── */
    .data-table { width: 100%; border-collapse: collapse; font-size: .82rem; }
    .data-table th {
        background: var(--vp); color: var(--v);
        font-family: 'Nunito', sans-serif; font-weight: 700;
        padding: 10px 12px; text-align: left; font-size: .72rem;
        text-transform: uppercase; letter-spacing: .05em;
    }
    .data-table td { padding: 10px 12px; border-bottom: 1px solid var(--brd); }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tr:hover td { background: #f9fbfa; }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align: center; padding: 36px 20px;
        color: var(--sub);
    }
    .empty-state i { font-size: 2.5rem; opacity: .3; margin-bottom: 10px; display: block; }
    .empty-state p { font-size: .82rem; }

    /* ── INFO ROW ── */
    .info-row {
        display: flex; justify-content: space-between;
        padding: 9px 0; border-bottom: 1px solid var(--brd);
        font-size: .82rem;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: var(--sub); font-weight: 600; }
    .info-val   { font-weight: 700; color: var(--dk); text-align: right; }

    /* ── DOCS GRID ── */
    .docs-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }
    .doc-item {
        border: 1px solid var(--brd); border-radius: 8px;
        padding: 12px; display: flex; align-items: center; gap: 10px;
        font-size: .78rem;
    }
    .doc-item i { font-size: 1.2rem; flex-shrink: 0; }
    .doc-item.ok   i { color: var(--v); }
    .doc-item.nok  i { color: var(--r); }
    .doc-name { font-weight: 700; display: block; font-size: .72rem; color: var(--dk); }
    .doc-label { font-size: .65rem; color: var(--sub); }

    /* FOOTER */
    .page-footer {
        background: var(--dk); color: rgba(255,255,255,.4);
        text-align: center; padding: 10px; font-size: .7rem; margin-top: 30px;
    }
    .page-footer span { color: var(--o); }

    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .docs-grid  { grid-template-columns: repeat(2, 1fr); }
        .welcome-icon { display: none; }
        .header { flex-direction: column; gap: 10px; }
    }
    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
        .docs-grid  { grid-template-columns: 1fr; }
    }
    </style>
</head>
<body>

<div class="tricolor"></div>

{{-- ── HEADER ── --}}
<div class="header">
    <div class="header-left">
        <div class="logo-box">
            @if(file_exists(public_path('images/logo.jpeg')))
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo">
            @elseif(file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
            @else
                <span style="font-family:'Nunito',sans-serif;font-weight:900;color:#1a6b3a;font-size:1rem;">AG</span>
            @endif
        </div>
        <div>
            <div class="logo-name">A<em>G</em>esp</div>
            <div class="logo-sub">Système de Gestion Auto-École · CCI-BF</div>
        </div>
    </div>
    <div class="header-right">
        <div class="user-pill">
            <i class="bi bi-person-circle"></i>
            {{ $user->name }}
        </div>
        @if($modePreviewAdmin ?? false)
            <a href="{{ route('candidats.show', $candidat->id) }}" class="btn-logout" style="text-decoration:none;">
                <i class="bi bi-arrow-left"></i> Retour à la fiche
            </a>
        @else
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </button>
            </form>
        @endif
    </div>
</div>

@if($modePreviewAdmin ?? false)
<div style="background:#FFF3CD; border-bottom:2px solid #E5B800; padding:0.75rem 1.5rem; text-align:center; font-size:0.85rem; font-weight:600; color:#7A5C00;">
    👁️ Vous consultez l'espace de <strong>{{ $candidat->nom ?? '' }} {{ $candidat->prenom ?? '' }}</strong> en tant qu'administrateur — lecture seule.
</div>
@endif

{{-- ── NAVIGATION TABS ── --}}
<div class="nav-tabs-wrap">
    <button class="nav-tab active" onclick="showTab('accueil', this)">
        <i class="bi bi-house"></i> Mon espace
    </button>
    <button class="nav-tab" onclick="showTab('inscription', this)">
        <i class="bi bi-pencil-square"></i> Mon inscription
    </button>
    <button class="nav-tab" onclick="showTab('examens', this)">
        <i class="bi bi-clipboard2-check"></i> Examens
    </button>
    <button class="nav-tab" onclick="showTab('paiements', this)">
        <i class="bi bi-credit-card"></i> Paiements
    </button>
    <button class="nav-tab" onclick="showTab('attestations', this)">
        <i class="bi bi-award"></i> Attestations
    </button>
    <button class="nav-tab" onclick="showTab('profil', this)">
        <i class="bi bi-person"></i> Mon profil
    </button>
</div>

<div class="page-body">

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- TAB : ACCUEIL                                         --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div id="tab-accueil" class="section active">

        {{-- Bannière bienvenue --}}
        <div class="welcome-banner">
            <div>
                <h2>Bonjour, {{ $user->name }} 👋</h2>
                <p>Bienvenue dans votre espace personnel AGesp. Suivez l'état de votre dossier en temps réel.</p>
            </div>
            <i class="bi bi-person-check welcome-icon"></i>
        </div>

        {{-- Stats rapides --}}
        <div class="stats-grid">
            <div class="stat-card green">
                <div class="stat-icon green"><i class="bi bi-pencil-square"></i></div>
                <div>
                    <div class="stat-val">{{ $candidat?->inscriptions->count() ?? 0 }}</div>
                    <div class="stat-lbl">Inscription(s)</div>
                </div>
            </div>
            <div class="stat-card orange">
                <div class="stat-icon orange"><i class="bi bi-clipboard2-check"></i></div>
                <div>
                    <div class="stat-val">{{ $examens->count() }}</div>
                    <div class="stat-lbl">Examen(s)</div>
                </div>
            </div>
            <div class="stat-card blue">
                <div class="stat-icon blue"><i class="bi bi-credit-card"></i></div>
                <div>
                    <div class="stat-val">{{ $paiements->count() }}</div>
                    <div class="stat-lbl">Paiement(s)</div>
                </div>
            </div>
            <div class="stat-card green">
                <div class="stat-icon green"><i class="bi bi-award"></i></div>
                <div>
                    <div class="stat-val">{{ $attestations->count() }}</div>
                    <div class="stat-lbl">Attestation(s)</div>
                </div>
            </div>
        </div>

        {{-- Statut inscription principal --}}
        @if($inscription)
            @php
                $statut = $inscription->statutInscription ?? 'en_attente';
                $cssStatut = match($statut) {
                    'actif', 'accepte', 'acceptée' => 'accepte',
                    'refuse', 'refusé', 'rejeté'   => 'refuse',
                    default                          => 'attente',
                };
                $iconStatut = match($cssStatut) {
                    'accepte' => 'bi-check-circle-fill',
                    'refuse'  => 'bi-x-circle-fill',
                    default   => 'bi-hourglass-split',
                };
                $titreStatut = match($cssStatut) {
                    'accepte' => 'Votre inscription est acceptée !',
                    'refuse'  => 'Votre inscription a été refusée.',
                    default   => 'Votre inscription est en cours de traitement.',
                };
                $descStatut = match($cssStatut) {
                    'accepte' => 'Félicitations ! Votre dossier a été validé. Vous pouvez vous présenter à l\'auto-école avec votre récépissé.',
                    'refuse'  => 'Votre dossier a été refusé. Veuillez contacter l\'administration pour plus d\'informations.',
                    default   => 'Votre dossier est en cours de vérification par l\'administration. Vous serez notifié dès qu\'une décision sera prise.',
                };
            @endphp
            <div class="statut-card {{ $cssStatut }}">
                <i class="bi {{ $iconStatut }} statut-icon"></i>
                <div>
                    <div class="statut-title">{{ $titreStatut }}</div>
                    <div class="statut-desc">{{ $descStatut }}</div>
                    <div style="margin-top:10px;">
                        <span class="badge badge-{{ $cssStatut === 'attente' ? 'attente' : ($cssStatut === 'accepte' ? 'accepte' : 'refuse') }}">
                            <i class="bi {{ $iconStatut }}"></i>
                            {{ strtoupper($statut) }}
                        </span>
                        <span style="font-size:.75rem;color:var(--sub);margin-left:10px;">
                            Catégorie : <strong>{{ $inscription->categoriePermis->pareCategorie ?? '—' }}</strong>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Timeline progression --}}
            <div class="card">
                <div class="card-head">
                    <i class="bi bi-list-check"></i> Progression de votre dossier
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="tl-item">
                            <div class="tl-dot done"><i class="bi bi-check"></i></div>
                            <div class="tl-text">
                                <strong>Compte créé</strong>
                                <span>Votre espace candidat a été créé avec succès</span>
                            </div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-dot done"><i class="bi bi-check"></i></div>
                            <div class="tl-text">
                                <strong>Formulaire soumis</strong>
                                <span>Le {{ $inscription->dateInscription ? \Carbon\Carbon::parse($inscription->dateInscription)->format('d/m/Y') : '—' }}</span>
                            </div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-dot {{ $cssStatut === 'attente' ? 'wait' : ($cssStatut === 'accepte' ? 'done' : 'fail') }}">
                                <i class="bi {{ $cssStatut === 'attente' ? 'bi-hourglass-split' : ($cssStatut === 'accepte' ? 'bi-check' : 'bi-x') }}"></i>
                            </div>
                            <div class="tl-text">
                                <strong>Vérification du dossier</strong>
                                <span>{{ $cssStatut === 'attente' ? 'En cours de vérification par l\'administration' : ($cssStatut === 'accepte' ? 'Dossier validé ✓' : 'Dossier refusé') }}</span>
                            </div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-dot {{ $cssStatut === 'accepte' ? 'done' : 'todo' }}">
                                <i class="bi bi-book"></i>
                            </div>
                            <div class="tl-text">
                                <strong>Formation</strong>
                                <span>
                                    @if($cssStatut === 'accepte')
                                        Début : {{ $inscription->dataDebut_formation ? \Carbon\Carbon::parse($inscription->dataDebut_formation)->format('d/m/Y') : '—' }}
                                    @else
                                        En attente de validation du dossier
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-dot {{ $examens->count() > 0 ? 'done' : 'todo' }}">
                                <i class="bi bi-clipboard2-check"></i>
                            </div>
                            <div class="tl-text">
                                <strong>Examen(s)</strong>
                                <span>{{ $examens->count() > 0 ? $examens->count().' examen(s) programmé(s)' : 'Pas encore programmé' }}</span>
                            </div>
                        </div>
                        <div class="tl-item">
                            <div class="tl-dot {{ $attestations->count() > 0 ? 'done' : 'todo' }}">
                                <i class="bi bi-award"></i>
                            </div>
                            <div class="tl-text">
                                <strong>Attestation / Permis</strong>
                                <span>{{ $attestations->count() > 0 ? 'Disponible' : 'Pas encore disponible' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @else
            {{-- Pas encore inscrit --}}
            <div class="card">
                <div class="card-body">
                    <div class="empty-state">
                        <i class="bi bi-pencil-square"></i>
                        <p style="font-size:.95rem;font-weight:700;margin-bottom:8px;">Vous n'avez pas encore soumis de dossier d'inscription.</p>
                        <p style="margin-bottom:20px;">Cliquez ci-dessous pour commencer votre inscription à l'auto-école GESP.</p>
                        <a href="{{ route('inscription.public') }}"
                           style="display:inline-flex;align-items:center;gap:8px;background:var(--v);color:white;
                                  padding:11px 24px;border-radius:8px;font-family:'Nunito',sans-serif;
                                  font-weight:700;font-size:.88rem;text-decoration:none;">
                            <i class="bi bi-pencil-square"></i> Commencer l'inscription
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- TAB : MON INSCRIPTION                                 --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div id="tab-inscription" class="section">
        @if($inscription)
            <div class="card">
                <div class="card-head">
                    <i class="bi bi-person-fill"></i> Informations personnelles
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">Nom complet</span>
                        <span class="info-val">{{ strtoupper($candidat->nom ?? '') }} {{ $candidat->prenom ?? '' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Date de naissance</span>
                        <span class="info-val">{{ $candidat->dateNaissance ? \Carbon\Carbon::parse($candidat->dateNaissance)->format('d/m/Y') : '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Lieu de naissance</span>
                        <span class="info-val">{{ $candidat->lieuNaissance ?? '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Téléphone</span>
                        <span class="info-val">{{ $candidat->telephone ?? '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Email</span>
                        <span class="info-val">{{ $candidat->email ?? '—' }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-head">
                    <i class="bi bi-pencil-square"></i> Détails de l'inscription
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <span class="info-label">Numéro de dossier</span>
                        <span class="info-val">{{ $inscription->reference ?? 'GESP-'.$inscription->id }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Catégorie de permis</span>
                        <span class="info-val">{{ $inscription->categoriePermis->pareCategorie ?? '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Date d'inscription</span>
                        <span class="info-val">{{ $inscription->dateInscription ? \Carbon\Carbon::parse($inscription->dateInscription)->format('d/m/Y') : '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Début de formation</span>
                        <span class="info-val">{{ $inscription->dataDebut_formation ? \Carbon\Carbon::parse($inscription->dataDebut_formation)->format('d/m/Y') : '—' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Statut</span>
                        <span class="info-val">
                            <span class="badge badge-{{ $cssStatut ?? 'attente' }}">
                                {{ strtoupper($inscription->statutInscription ?? 'en_attente') }}
                            </span>
                        </span>
                    </div>
                </div>
            </div>

            {{-- Documents --}}
            <div class="card">
                <div class="card-head">
                    <i class="bi bi-folder2-open"></i> Pièces jointes du dossier
                </div>
                <div class="card-body">
                    @php
                        $docs = [
                            ['label'=>'CNIB',               'field'=>'cnib',               'icon'=>'bi-person-vcard'],
                            ['label'=>'Photo Identité',     'field'=>'photo_identite',      'icon'=>'bi-person-circle'],
                            ['label'=>'Certificat Médical', 'field'=>'certificat_medical',  'icon'=>'bi-heart-pulse'],
                            ['label'=>'Acte de Naissance',  'field'=>'acte_naissance',      'icon'=>'bi-file-earmark-text'],
                            ['label'=>'Reçu de Paiement',   'field'=>'recu_paiement',       'icon'=>'bi-receipt'],
                            ['label'=>'Copie Permis C',     'field'=>'permis_c',            'icon'=>'bi-card-heading'],
                        ];
                    @endphp
                    <div class="docs-grid">
                        @foreach($docs as $doc)
                            @php $hasDoc = $dossier && !empty($dossier->{$doc['field']}); @endphp
                            <div class="doc-item {{ $hasDoc ? 'ok' : 'nok' }}">
                                <i class="bi {{ $hasDoc ? 'bi-check-circle-fill' : 'bi-x-circle-fill' }}"></i>
                                <div>
                                    <span class="doc-label">{{ $doc['label'] }}</span>
                                    <span class="doc-name">{{ $hasDoc ? 'Fourni ✓' : 'Non fourni' }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Décision administrative sur le dossier (pièces jointes) --}}
            @php
                $statutDossierActuel = $dossier->statutDossier ?? 'en_attente';
                $cssDossier = match($statutDossierActuel) {
                    'valide' => 'accepte',
                    'rejete' => 'refuse',
                    default  => 'attente',
                };
                $iconDossier = match($cssDossier) {
                    'accepte' => 'bi-check-circle-fill',
                    'refuse'  => 'bi-x-circle-fill',
                    default   => 'bi-hourglass-split',
                };
                $titreDossier = match($cssDossier) {
                    'accepte' => 'Votre dossier (pièces jointes) a été validé !',
                    'refuse'  => 'Votre dossier (pièces jointes) a été rejeté.',
                    default   => 'Votre dossier est en cours de vérification.',
                };
            @endphp
            <div class="statut-card {{ $cssDossier }}">
                <i class="bi {{ $iconDossier }} statut-icon"></i>
                <div>
                    <div class="statut-title">{{ $titreDossier }}</div>
                    @if($dossier && $dossier->commentaireAdmin)
                        <div class="statut-desc">💬 {{ $dossier->commentaireAdmin }}</div>
                    @else
                        <div class="statut-desc">
                            {{ $cssDossier === 'attente' ? 'L\'administration vérifie actuellement vos pièces. Vous serez notifié dès qu\'une décision sera prise.' : ($cssDossier === 'accepte' ? 'Toutes vos pièces ont été validées par l\'administration.' : 'Veuillez contacter l\'administration pour connaître le motif et corriger votre dossier.') }}
                        </div>
                    @endif
                </div>
            </div>
        @else
            <div class="card"><div class="card-body">
                <div class="empty-state">
                    <i class="bi bi-pencil-square"></i>
                    <p>Aucune inscription trouvée.</p>
                    <a href="{{ route('inscription.public') }}"
                       style="display:inline-flex;align-items:center;gap:8px;background:var(--v);color:white;
                              padding:10px 22px;border-radius:8px;font-family:'Nunito',sans-serif;
                              font-weight:700;font-size:.85rem;text-decoration:none;margin-top:14px;">
                        <i class="bi bi-pencil-square"></i> S'inscrire maintenant
                    </a>
                </div>
            </div></div>
        @endif
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- TAB : EXAMENS                                         --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div id="tab-examens" class="section">
        <div class="card">
            <div class="card-head"><i class="bi bi-clipboard2-check"></i> Mes examens</div>
            <div class="card-body" style="padding:0;">
                @if($examens->count() > 0)
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Lieu</th>
                                <th>Résultat</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($examens as $ex)
                            <tr>
                                <td>{{ $ex->typeExamen ?? $ex->type ?? '—' }}</td>
                                <td>{{ $ex->dateExamen ? \Carbon\Carbon::parse($ex->dateExamen)->format('d/m/Y') : '—' }}</td>
                                <td>{{ $ex->lieu ?? '—' }}</td>
                                <td>
                                    @php $res = strtolower($ex->resultat ?? ''); @endphp
                                    <span class="badge {{ $res === 'admis' || $res === 'reussi' ? 'badge-accepte' : ($res === 'echec' || $res === 'recale' ? 'badge-refuse' : 'badge-attente') }}">
                                        {{ $ex->resultat ?? 'En attente' }}
                                    </span>
                                </td>
                                <td>{{ $ex->note ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="bi bi-clipboard2-check"></i>
                        <p>Aucun examen programmé pour le moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- TAB : PAIEMENTS                                       --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div id="tab-paiements" class="section">
        <div class="card">
            <div class="card-head"><i class="bi bi-credit-card"></i> Mes paiements</div>
            <div class="card-body" style="padding:0;">
                @if($paiements->count() > 0)
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Référence</th>
                                <th>Montant</th>
                                <th>Date</th>
                                <th>Mode</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paiements as $p)
                            <tr>
                                <td>{{ $p->reference ?? 'PAY-'.$p->id }}</td>
                                <td><strong>{{ number_format($p->montant ?? 0, 0, ',', ' ') }} FCFA</strong></td>
                                <td>{{ $p->datePaiement ? \Carbon\Carbon::parse($p->datePaiement)->format('d/m/Y') : '—' }}</td>
                                <td>{{ $p->modePaiement ?? '—' }}</td>
                                <td>
                                    <span class="badge {{ ($p->statut ?? '') === 'payé' ? 'badge-accepte' : 'badge-attente' }}">
                                        {{ $p->statut ?? 'En attente' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="bi bi-credit-card"></i>
                        <p>Aucun paiement enregistré.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- TAB : ATTESTATIONS                                    --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div id="tab-attestations" class="section">
        <div class="card">
            <div class="card-head"><i class="bi bi-award"></i> Mes attestations</div>
            <div class="card-body" style="padding:0;">
                @if($attestations->count() > 0)
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>Type</th>
                                <th>Date délivrance</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attestations as $att)
                            <tr>
                                <td><strong>{{ $att->numero ?? 'ATT-'.$att->id }}</strong></td>
                                <td>{{ $att->type ?? $att->typeAttestation ?? '—' }}</td>
                                <td>{{ $att->dateDelivrance ? \Carbon\Carbon::parse($att->dateDelivrance)->format('d/m/Y') : '—' }}</td>
                                <td>
                                    <span class="badge badge-accepte">
                                        <i class="bi bi-check-circle"></i> Disponible
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="bi bi-award"></i>
                        <p>Aucune attestation disponible pour le moment.</p>
                        <p style="font-size:.75rem;margin-top:6px;">Les attestations seront disponibles après validation de votre formation.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════ --}}
    {{-- TAB : PROFIL                                          --}}
    {{-- ══════════════════════════════════════════════════════ --}}
    <div id="tab-profil" class="section">
        <div class="card">
            <div class="card-head"><i class="bi bi-person-circle"></i> Mon profil</div>
            <div class="card-body">
                <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px;">
                    <div style="width:64px;height:64px;background:var(--vp);border-radius:50%;
                                display:flex;align-items:center;justify-content:center;
                                font-size:1.8rem;color:var(--v);flex-shrink:0;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <div style="font-family:'Nunito',sans-serif;font-weight:900;font-size:1.1rem;">
                            {{ $user->name }}
                        </div>
                        <div style="font-size:.78rem;color:var(--sub);">Candidat · AGesp</div>
                        <span class="badge badge-info" style="margin-top:4px;">
                            <i class="bi bi-person"></i> {{ ucfirst($user->role ?? 'candidat') }}
                        </span>
                    </div>
                </div>

                <div class="info-row">
                    <span class="info-label">Nom complet</span>
                    <span class="info-val">{{ $user->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-val">{{ $user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Téléphone</span>
                    <span class="info-val">{{ $user->telephone ? '+226 '.$user->telephone : '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Membre depuis</span>
                    <span class="info-val">{{ $user->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
    </div>

</div>{{-- /page-body --}}

<div class="page-footer">
    © {{ date('Y') }} <span>AGesp</span> — Auto-École GESP · CCI-BF · Tous droits réservés
</div>

<script>
function showTab(name, btn) {
    // Cacher toutes les sections
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.nav-tab').forEach(b => b.classList.remove('active'));

    // Afficher la section cliquée
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}
</script>

</body>
</html>