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
    :root { --v:#1a6b3a; --vc:#22883f; --vp:#e8f2ec; --r:#c0281e; --o:#d4a017; --dk:#1a2520; }
    *{box-sizing:border-box;margin:0;padding:0;}
    body{font-family:'Source Sans 3',sans-serif;background:#f3f6f4;color:var(--dk);font-size:14px;}
    .tricolor{height:5px;background:linear-gradient(90deg,var(--r) 0%,var(--r) 33%,var(--o) 33%,var(--o) 66%,var(--v) 66%,var(--v) 100%);}
    .site-header{background:linear-gradient(135deg,#0a1f0f,var(--v),#0f2e1c);padding:12px 30px;display:flex;align-items:center;justify-content:space-between;}
    .logo-box{width:48px;height:48px;background:white;border-radius:8px;display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;}
    .logo-box img{width:88%;height:88%;object-fit:contain;}
    .site-title{font-family:'Nunito',sans-serif;font-weight:900;font-size:1.3rem;color:white;}
    .site-title span{color:var(--o);}
    .site-subtitle{font-size:0.7rem;color:rgba(255,255,255,0.7);}
    .site-nav{background:var(--v);padding:0 30px;display:flex;align-items:center;justify-content:space-between;box-shadow:0 2px 8px rgba(0,0,0,0.2);}
    .nav-lnk{display:flex;align-items:center;gap:6px;padding:9px 14px;color:rgba(255,255,255,0.82);text-decoration:none;font-size:0.8rem;font-weight:600;font-family:'Nunito',sans-serif;border-bottom:3px solid transparent;transition:all 0.18s;}
    .nav-lnk:hover,.nav-lnk.active{color:white;border-bottom-color:var(--o);}
    .site-slogan{background:linear-gradient(90deg,var(--r),#8b1a12);color:white;text-align:center;padding:6px 20px;font-family:'Nunito',sans-serif;font-weight:700;font-size:0.85rem;}
    .site-slogan em{color:var(--o);font-style:normal;}
    .breadcrumb-bar{background:white;padding:8px 30px;border-bottom:1px solid rgba(26,107,58,0.1);font-size:0.75rem;color:#6b7a70;}
    .breadcrumb-bar a{color:var(--v);text-decoration:none;}
    .stepper-wrap{max-width:800px;margin:24px auto 0;padding:0 20px;}
    .stepper{display:flex;align-items:center;margin-bottom:24px;}
    .step{display:flex;align-items:center;gap:8px;flex:1;}
    .step-num{width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Nunito',sans-serif;font-weight:800;font-size:0.85rem;flex-shrink:0;transition:all 0.3s;}
    .step-num.done{background:var(--v);color:white;}
    .step-num.active{background:var(--o);color:var(--dk);}
    .step-num.todo{background:#e0e0e0;color:#999;}
    .step-label{font-family:'Nunito',sans-serif;font-weight:700;font-size:0.78rem;}
    .step-label.active{color:var(--v);}
    .step-label.todo{color:#999;}
    .step-line{flex:1;height:2px;background:#e0e0e0;margin:0 8px;}
    .step-line.done{background:var(--v);}
    .form-wrap{max-width:800px;margin:0 auto 30px;padding:0 20px;}
    .form-card{background:white;border-radius:10px;box-shadow:0 2px 12px rgba(26,107,58,0.1);overflow:hidden;}
    .form-card-head{background:var(--v);color:white;padding:12px 20px;font-family:'Nunito',sans-serif;font-weight:700;font-size:0.95rem;display:flex;align-items:center;gap:8px;}
    .form-card-body{padding:24px;}
    .section-title{font-family:'Nunito',sans-serif;font-weight:800;font-size:0.82rem;color:var(--r);text-transform:uppercase;letter-spacing:0.08em;margin-bottom:12px;padding-bottom:6px;border-bottom:2px solid var(--vp);display:flex;align-items:center;gap:6px;margin-top:16px;}
    .lbl{font-family:'Nunito',sans-serif;font-weight:700;font-size:0.75rem;color:var(--dk);margin-bottom:4px;display:block;}
    .lbl .req{color:var(--r);}
    .inp{width:100%;border:1.5px solid #cdd8d0;border-radius:6px;padding:8px 10px;font-size:0.82rem;background:#f9fbfa;font-family:'Source Sans 3',sans-serif;transition:border-color 0.18s;margin-bottom:0;}
    .inp:focus{border-color:var(--v);box-shadow:0 0 0 3px rgba(26,107,58,0.1);background:white;outline:none;}
    .inp.is-invalid{border-color:var(--r);}
    .invalid-msg{font-size:0.7rem;color:var(--r);margin-top:3px;}
    .form-row{display:grid;gap:14px;margin-bottom:14px;}
    .col-2{grid-template-columns:1fr 1fr;}
    .col-3{grid-template-columns:1fr 1fr 1fr;}
    .btn-next{background:var(--v);color:white;border:none;border-radius:6px;padding:10px 28px;font-family:'Nunito',sans-serif;font-weight:700;font-size:0.88rem;cursor:pointer;transition:background 0.18s;display:flex;align-items:center;gap:8px;}
    .btn-next:hover{background:var(--vc);}
    .btn-prev{background:#e0e0e0;color:var(--dk);border:none;border-radius:6px;padding:10px 28px;font-family:'Nunito',sans-serif;font-weight:700;font-size:0.88rem;cursor:pointer;transition:background 0.18s;display:flex;align-items:center;gap:8px;}
    .btn-prev:hover{background:#d0d0d0;}
    .btn-submit{background:var(--o);color:var(--dk);border:none;border-radius:6px;padding:10px 28px;font-family:'Nunito',sans-serif;font-weight:700;font-size:0.88rem;cursor:pointer;transition:background 0.18s;display:flex;align-items:center;gap:8px;}
    .btn-submit:hover{background:#e6b020;}
    .alert-err{background:#fbeaea;color:var(--r);border-left:4px solid var(--r);border-radius:6px;padding:10px 14px;font-size:0.78rem;margin-bottom:16px;}
    .alert-ok{background:var(--vp);color:var(--v);border-left:4px solid var(--v);border-radius:6px;padding:10px 14px;font-size:0.78rem;margin-bottom:16px;}
    .info-box{background:var(--vp);border:1px solid rgba(26,107,58,0.2);border-radius:8px;padding:12px 16px;font-size:0.78rem;color:#3a4a40;margin-bottom:20px;display:flex;gap:10px;align-items:flex-start;}
    .info-box i{color:var(--v);font-size:1rem;flex-shrink:0;margin-top:1px;}
    .recap-row{display:flex;justify-content:space-between;padding:6px 0;border-bottom:1px solid rgba(26,107,58,0.07);font-size:0.8rem;}
    .recap-row:last-child{border-bottom:none;}
    .recap-label{color:#6b7a70;font-weight:600;}
    .recap-val{font-weight:700;color:var(--dk);}
    .site-footer{background:var(--dk);color:rgba(255,255,255,0.55);text-align:center;padding:10px 20px;font-size:0.7rem;margin-top:20px;}
    .site-footer span{color:var(--o);}
    @media(max-width:600px){
        .col-2,.col-3{grid-template-columns:1fr;}
        .stepper-wrap,.form-wrap{padding:0 12px;}
    }
    </style>
</head>
<body>

<div class="tricolor"></div>

{{-- HEADER --}}
<div class="site-header">
    <div style="display:flex;align-items:center;gap:12px;">
        <div class="logo-box">
            @if(file_exists(public_path('images/logo.jpeg')))
                <img src="{{ asset('images/logo.jpeg') }}" alt="Logo" onerror="this.style.display='none'">
            @elseif(file_exists(public_path('images/logo.png')))
                <img src="{{ asset('images/logo.png') }}" alt="Logo" onerror="this.style.display='none'">
            @else
                <span style="font-family:'Nunito',sans-serif;font-weight:900;font-size:1rem;color:#1a6b3a;">AG</span>
            @endif
        </div>
        <div>
            <div class="site-title">A<span>G</span>esp</div>
            <div class="site-subtitle">Système de Gestion Auto-École · CCI-BF</div>
        </div>
    </div>
    <a href="{{ url('/') }}" style="color:rgba(255,255,255,0.7);text-decoration:none;font-size:0.78rem;">
        <i class="bi bi-arrow-left me-1"></i> Retour à l'accueil
    </a>
</div>

<div class="site-slogan">
    Inscription en ligne — <em>Auto-École GESP</em> — Formulaire candidat
</div>

<div class="site-nav">
    <div style="display:flex;">
        <a href="{{ url('/') }}" class="nav-lnk"><i class="bi bi-house"></i> Accueil</a>
        <a href="#" class="nav-lnk active"><i class="bi bi-pencil-square"></i> S'inscrire</a>
        <a href="{{ route('login') }}" class="nav-lnk"><i class="bi bi-person-circle"></i> Connexion</a>
    </div>
</div>

<div class="breadcrumb-bar">
    <a href="{{ url('/') }}">Accueil</a> › <strong>Inscription candidat</strong>
</div>

{{-- STEPPER --}}
<div class="stepper-wrap">
    <div class="stepper">
        <div class="step">
            <div class="step-num active" id="snum1">1</div>
            <div class="step-label active" id="slbl1">Informations personnelles</div>
        </div>
        <div class="step-line" id="sline1"></div>
        <div class="step">
            <div class="step-num todo" id="snum2">2</div>
            <div class="step-label todo" id="slbl2">Inscription & Permis</div>
        </div>
        <div class="step-line" id="sline2"></div>
        <div class="step">
            <div class="step-num todo" id="snum3">3</div>
            <div class="step-label todo" id="slbl3">Récapitulatif</div>
        </div>
    </div>
</div>

<div class="form-wrap">

    @if($errors->any())
    <div class="alert-err">
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Erreurs :</strong>
        <ul style="margin:4px 0 0 16px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="alert-ok">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
    </div>
    @endif

    <form method="POST" action="{{ route('inscription.public.store') }}" id="inscriptionForm">
        @csrf

        {{-- ÉTAPE 1 --}}
        <div id="step1">
            <div class="form-card">
                <div class="form-card-head">
                    <i class="bi bi-person-fill"></i> Étape 1 — Informations personnelles
                </div>
                <div class="form-card-body">

                    <div class="info-box">
                        <i class="bi bi-info-circle-fill"></i>
                        <div>Remplissez vos informations personnelles. Les champs marqués <strong style="color:var(--r);">*</strong> sont obligatoires.</div>
                    </div>

                    <div class="section-title" style="margin-top:0;"><i class="bi bi-person"></i> Identité</div>

                    <div class="form-row col-2">
                        <div>
                            <label class="lbl">Nom <span class="req">*</span></label>
                            <input type="text" name="nom" class="inp @error('nom') is-invalid @enderror"
                                   value="{{ old('nom') }}" placeholder="Nom de famille" required>
                            @error('nom')<div class="invalid-msg">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="lbl">Prénom <span class="req">*</span></label>
                            <input type="text" name="prenom" class="inp @error('prenom') is-invalid @enderror"
                                   value="{{ old('prenom') }}" placeholder="Prénom(s)" required>
                            @error('prenom')<div class="invalid-msg">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-row col-2">
                        <div>
                            <label class="lbl">Date de naissance <span class="req">*</span></label>
                            <input type="date" name="dateNaissance" class="inp @error('dateNaissance') is-invalid @enderror"
                                   value="{{ old('dateNaissance') }}" required>
                            @error('dateNaissance')<div class="invalid-msg">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="lbl">Lieu de naissance <span class="req">*</span></label>
                            <input type="text" name="lieuNaissance" class="inp @error('lieuNaissance') is-invalid @enderror"
                                   value="{{ old('lieuNaissance') }}" placeholder="Ex: Ouagadougou" required>
                            @error('lieuNaissance')<div class="invalid-msg">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="section-title"><i class="bi bi-telephone"></i> Contact</div>

                    <div class="form-row col-2">
                        <div>
                            <label class="lbl">Téléphone <span class="req">*</span></label>
                            <input type="tel" name="telephone" class="inp @error('telephone') is-invalid @enderror"
                                   value="{{ old('telephone') }}" placeholder="+226 XX XX XX XX" required>
                            @error('telephone')<div class="invalid-msg">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="lbl">Email</label>
                            <input type="email" name="email" class="inp @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" placeholder="votre@email.com">
                            @error('email')<div class="invalid-msg">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="section-title"><i class="bi bi-card-text"></i> Permis actuel (si vous en avez un)</div>

                    <div class="form-row col-3">
                        <div>
                            <label class="lbl">Numéro permis</label>
                            <input type="text" name="numeroPermisC" class="inp" value="{{ old('numeroPermisC') }}" placeholder="N° permis">
                        </div>
                        <div>
                            <label class="lbl">Date délivrance</label>
                            <input type="date" name="dateDelivrancePermisC" class="inp" value="{{ old('dateDelivrancePermisC') }}">
                        </div>
                        <div>
                            <label class="lbl">Lieu délivrance</label>
                            <input type="text" name="lieuDelivrancePermisC" class="inp" value="{{ old('lieuDelivrancePermisC') }}" placeholder="Ex: Bobo-Dioulasso">
                        </div>
                    </div>

                    <div style="display:flex;justify-content:flex-end;margin-top:20px;">
                        <button type="button" class="btn-next" onclick="goToStep(2)">
                            Suivant <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ÉTAPE 2 --}}
        <div id="step2" style="display:none;">
            <div class="form-card">
                <div class="form-card-head">
                    <i class="bi bi-pencil-square"></i> Étape 2 — Inscription & Catégorie de permis
                </div>
                <div class="form-card-body">

                    <div class="info-box">
                        <i class="bi bi-info-circle-fill"></i>
                        <div>Choisissez la catégorie de permis souhaitée et la date de début de formation.</div>
                    </div>

                    <div class="section-title" style="margin-top:0;"><i class="bi bi-calendar-check"></i> Inscription</div>

                    <div class="form-row col-2">
                        <div>
                            <label class="lbl">Catégorie de permis <span class="req">*</span></label>
                            <select name="categoriePermis_id" class="inp @error('categoriePermis_id') is-invalid @enderror" required>
                                <option value="">-- Choisir une catégorie --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('categoriePermis_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->pareCategorie ?? $cat->nom ?? 'Catégorie '.$cat->id }}
                                        @if($cat->description ?? false) — {{ $cat->description }} @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('categoriePermis_id')<div class="invalid-msg">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="lbl">Date de début formation <span class="req">*</span></label>
                            <input type="date" name="dataDebut_formation" class="inp @error('dataDebut_formation') is-invalid @enderror"
                                   value="{{ old('dataDebut_formation') }}" required>
                            @error('dataDebut_formation')<div class="invalid-msg">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="form-row col-2">
                        <div>
                            <label class="lbl">Date d'inscription</label>
                            <input type="date" name="dateInscription" class="inp" value="{{ old('dateInscription', date('Y-m-d')) }}">
                        </div>
                        <div>
                            <label class="lbl">Statut</label>
                            <select name="statutInscription" class="inp">
                                <option value="en_attente">En attente</option>
                                <option value="actif">Actif</option>
                            </select>
                        </div>
                    </div>

                    <div class="section-title"><i class="bi bi-folder2"></i> Dossier (optionnel)</div>

                    <div class="form-row col-2">
                        <div>
                            <label class="lbl">Nom du dossier</label>
                            <input type="text" name="nomDossier" class="inp" value="{{ old('nomDossier') }}" placeholder="Ex: Dossier Permis B">
                        </div>
                        <div>
                            <label class="lbl">Description</label>
                            <input type="text" name="descriptionDossier" class="inp" value="{{ old('descriptionDossier') }}" placeholder="Description optionnelle">
                        </div>
                    </div>

                    <div style="display:flex;justify-content:space-between;margin-top:20px;">
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

        {{-- ÉTAPE 3 --}}
        <div id="step3" style="display:none;">
            <div class="form-card">
                <div class="form-card-head">
                    <i class="bi bi-clipboard-check"></i> Étape 3 — Récapitulatif
                </div>
                <div class="form-card-body">

                    <div class="info-box">
                        <i class="bi bi-check-circle-fill"></i>
                        <div>Vérifiez vos informations avant de soumettre. Cliquez <strong>Précédent</strong> pour corriger.</div>
                    </div>

                    <div class="section-title" style="margin-top:0;"><i class="bi bi-person"></i> Identité</div>
                    <div style="margin-bottom:16px;">
                        <div class="recap-row"><span class="recap-label">Nom complet</span><span class="recap-val" id="r-nom">—</span></div>
                        <div class="recap-row"><span class="recap-label">Date de naissance</span><span class="recap-val" id="r-ddn">—</span></div>
                        <div class="recap-row"><span class="recap-label">Lieu de naissance</span><span class="recap-val" id="r-lieu">—</span></div>
                        <div class="recap-row"><span class="recap-label">Téléphone</span><span class="recap-val" id="r-tel">—</span></div>
                        <div class="recap-row"><span class="recap-label">Email</span><span class="recap-val" id="r-email">—</span></div>
                    </div>

                    <div class="section-title"><i class="bi bi-pencil-square"></i> Inscription</div>
                    <div style="margin-bottom:16px;">
                        <div class="recap-row"><span class="recap-label">Catégorie permis</span><span class="recap-val" id="r-cat">—</span></div>
                        <div class="recap-row"><span class="recap-label">Date début formation</span><span class="recap-val" id="r-debut">—</span></div>
                        <div class="recap-row"><span class="recap-label">Date inscription</span><span class="recap-val" id="r-dateinscr">—</span></div>
                    </div>

                    <div style="background:#fdf8e1;border:1px solid var(--o);border-radius:8px;padding:12px 16px;font-size:0.78rem;color:#3a4a40;margin-bottom:20px;">
                        <label style="display:flex;align-items:flex-start;gap:8px;cursor:pointer;">
                            <input type="checkbox" id="confirmCheck" style="accent-color:var(--v);margin-top:2px;">
                            <span>Je certifie que les informations fournies sont exactes et complètes. Je m'engage à fournir les pièces justificatives demandées lors de mon inscription.</span>
                        </label>
                    </div>

                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <button type="button" class="btn-prev" onclick="goToStep(2)">
                            <i class="bi bi-arrow-left"></i> Précédent
                        </button>
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i class="bi bi-send-fill"></i> Soumettre mon inscription
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </form>
</div>

<div class="site-footer">
    © {{ date('Y') }} <span>AGesp</span> — Auto-École GESP · CCI-BF · Tous droits réservés
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function goToStep(step) {
    if (step === 2) {
        const nom   = document.querySelector('[name="nom"]').value.trim();
        const prenom= document.querySelector('[name="prenom"]').value.trim();
        const ddn   = document.querySelector('[name="dateNaissance"]').value;
        const lieu  = document.querySelector('[name="lieuNaissance"]').value.trim();
        const tel   = document.querySelector('[name="telephone"]').value.trim();
        if (!nom || !prenom || !ddn || !lieu || !tel) {
            alert('Veuillez remplir tous les champs obligatoires (*)');
            return;
        }
    }

    if (step === 3) {
        const cat   = document.querySelector('[name="categoriePermis_id"]').value;
        const debut = document.querySelector('[name="dataDebut_formation"]').value;
        if (!cat || !debut) {
            alert('Veuillez choisir une catégorie de permis et une date de début');
            return;
        }
        // Remplir récapitulatif
        const nom   = document.querySelector('[name="nom"]').value;
        const prenom= document.querySelector('[name="prenom"]').value;
        document.getElementById('r-nom').textContent      = nom + ' ' + prenom;
        document.getElementById('r-ddn').textContent      = document.querySelector('[name="dateNaissance"]').value;
        document.getElementById('r-lieu').textContent     = document.querySelector('[name="lieuNaissance"]').value;
        document.getElementById('r-tel').textContent      = document.querySelector('[name="telephone"]').value;
        document.getElementById('r-email').textContent    = document.querySelector('[name="email"]').value || '—';
        const catSelect = document.querySelector('[name="categoriePermis_id"]');
        document.getElementById('r-cat').textContent      = catSelect.options[catSelect.selectedIndex].text;
        document.getElementById('r-debut').textContent    = debut;
        document.getElementById('r-dateinscr').textContent= document.querySelector('[name="dateInscription"]').value;
    }

    document.getElementById('step1').style.display = step === 1 ? 'block' : 'none';
    document.getElementById('step2').style.display = step === 2 ? 'block' : 'none';
    document.getElementById('step3').style.display = step === 3 ? 'block' : 'none';

    for (let i = 1; i <= 3; i++) {
        const num = document.getElementById('snum' + i);
        const lbl = document.getElementById('slbl' + i);
        if (i < step) {
            num.className = 'step-num done';
            num.innerHTML = '<i class="bi bi-check"></i>';
            lbl.className = 'step-label active';
        } else if (i === step) {
            num.className = 'step-num active';
            num.textContent = i;
            lbl.className = 'step-label active';
        } else {
            num.className = 'step-num todo';
            num.textContent = i;
            lbl.className = 'step-label todo';
        }
        if (i < 3) {
            document.getElementById('sline' + i).className = i < step ? 'step-line done' : 'step-line';
        }
    }

    window.scrollTo({top: 0, behavior: 'smooth'});
}

// Si erreurs de validation Laravel → revenir à l'étape 1
@if($errors->any())
    goToStep(1);
@endif
</script>
</body>
</html>
