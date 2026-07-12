<x-layouts::app title="Nouveau Candidat">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
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
*, *::before, *::after { box-sizing: border-box; }
.stepper { display:flex; align-items:center; margin-bottom:24px; background:white; padding:16px; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); overflow-x:auto; gap:4px; }
.step { display:flex; align-items:center; gap:8px; flex:1; min-width:0; }
.step-num { width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:800; font-size:.8rem; flex-shrink:0; transition:all var(--transition); }
.step-num.done   { background:var(--color-green); color:white; }
.step-num.active { background:var(--color-gold); color:var(--color-dark); box-shadow:0 0 0 4px rgba(252,209,22,.25); }
.step-num.todo   { background:var(--color-gray-100); color:#999; }
.step-label { font-weight:700; font-size:.72rem; white-space:nowrap; }
.step-label.active { color:var(--color-green); }
.step-label.done   { color:var(--color-green-dark); }
.step-label.todo   { color:#999; }
.step-line { flex:1; height:3px; background:var(--color-gray-100); border-radius:2px; min-width:12px; }
.step-line.done { background:var(--color-green); }
.form-card { background:white; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); overflow:hidden; border:1px solid var(--color-gray-100); }
.form-card-head { background:linear-gradient(135deg,var(--color-green) 0%,var(--color-green-light) 100%); color:white; padding:16px 22px; font-weight:700; font-size:1rem; display:flex; align-items:center; gap:10px; border-bottom:3px solid var(--color-gold); }
.form-card-body { padding:28px; }
.section-title { font-weight:800; font-size:.78rem; color:var(--color-dark); text-transform:uppercase; letter-spacing:.1em; margin-bottom:16px; margin-top:24px; padding-bottom:10px; border-bottom:2px solid var(--color-gold); display:flex; align-items:center; gap:8px; }
.section-title:first-of-type { margin-top:0; }
.section-title i { color:var(--color-green); font-size:1rem; }
.lbl { font-weight:700; font-size:.73rem; color:var(--color-dark); margin-bottom:6px; display:block; text-transform:uppercase; letter-spacing:.05em; }
.lbl .req { color:var(--color-red); }
.inp { width:100%; border:2px solid var(--color-gray-200); border-radius:var(--radius-md); padding:10px 12px; font-size:.85rem; background:#f9fbfa; transition:all var(--transition); color:var(--color-dark); font-family:inherit; }
.inp:focus { border-color:var(--color-green); box-shadow:0 0 0 3px rgba(0,122,94,.1); background:white; outline:none; }
.inp.is-invalid { border-color:var(--color-red); }
.invalid-msg { font-size:.7rem; color:var(--color-red); margin-top:4px; display:block; }
.date-selects-group { display:flex; gap:8px; }
.inp-jour { width:80px; flex-shrink:0; }
.inp-mois { flex:1; }
.inp-annee { width:100px; flex-shrink:0; }
.info-box { background:rgba(0,122,94,.08); border:1px solid rgba(0,122,94,.2); border-left:4px solid var(--color-green); border-radius:var(--radius-md); padding:14px 16px; font-size:.8rem; color:var(--color-green-dark); margin-bottom:20px; display:flex; gap:12px; align-items:flex-start; }
.info-box i { color:var(--color-green); font-size:1.1rem; flex-shrink:0; margin-top:2px; }
.alert-err { background:rgba(206,17,38,.08); color:#A00D20; border-left:4px solid var(--color-red); border-radius:var(--radius-md); padding:12px 16px; font-size:.8rem; margin-bottom:18px; }
.alert-err ul { margin:6px 0 0 20px; padding:0; }
.btn-wrapper { display:flex; gap:12px; margin-top:24px; padding-top:20px; border-top:1px solid var(--color-gray-100); }
.btn-prev { background:var(--color-gray-100); color:var(--color-dark); border:2px solid var(--color-gray-100); border-radius:var(--radius-md); padding:10px 22px; font-weight:700; font-size:.83rem; cursor:pointer; transition:all var(--transition); display:inline-flex; align-items:center; gap:8px; text-transform:uppercase; }
.btn-prev:hover { transform:translateY(-2px); background:var(--color-gray-200); }
.btn-next { background:linear-gradient(135deg,var(--color-red) 0%,var(--color-red-dark) 100%); color:white; border:2px solid var(--color-red); border-radius:var(--radius-md); padding:10px 22px; font-weight:700; font-size:.83rem; cursor:pointer; transition:all var(--transition); display:inline-flex; align-items:center; gap:8px; text-transform:uppercase; margin-left:auto; }
.btn-next:hover { transform:translateY(-2px); box-shadow:0 6px 16px rgba(206,17,38,.3); }
.btn-submit { background:linear-gradient(135deg,var(--color-green) 0%,var(--color-green-dark) 100%); color:white; border:2px solid var(--color-green); border-radius:var(--radius-md); padding:10px 22px; font-weight:700; font-size:.83rem; cursor:pointer; transition:all var(--transition); display:inline-flex; align-items:center; gap:8px; text-transform:uppercase; margin-left:auto; }
.btn-submit:hover { transform:translateY(-2px); box-shadow:0 6px 16px rgba(0,122,94,.3); }
/* Upload */
.upload-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:8px; }
.upload-card { border:2px dashed var(--color-gray-200); border-radius:var(--radius-lg); padding:16px 12px; text-align:center; cursor:pointer; transition:all var(--transition); background:#f9fbfa; position:relative; overflow:hidden; }
.upload-card:hover { border-color:var(--color-green); background:rgba(0,122,94,.04); }
.upload-card.required-doc { border-color:rgba(206,17,38,.3); }
.upload-card.has-file { border-color:var(--color-green); border-style:solid; background:rgba(0,122,94,.05); }
.upload-card.has-error { border-color:var(--color-red); border-style:solid; }
.upload-card input[type="file"] { position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%; }
.upload-icon { font-size:2rem; margin-bottom:6px; display:block; color:var(--color-gray-500); transition:color var(--transition); }
.upload-card:hover .upload-icon, .upload-card.has-file .upload-icon { color:var(--color-green); }
.upload-card.has-error .upload-icon { color:var(--color-red); }
.upload-title { font-weight:700; font-size:.75rem; color:var(--color-dark); display:block; margin-bottom:4px; }
.upload-badge-required { display:inline-block; font-size:.6rem; padding:1px 6px; background:rgba(206,17,38,.1); color:var(--color-red); border-radius:20px; font-weight:700; margin-bottom:4px; }
.upload-badge-optional { display:inline-block; font-size:.6rem; padding:1px 6px; background:rgba(0,122,94,.1); color:var(--color-green); border-radius:20px; font-weight:700; margin-bottom:4px; }
.upload-hint { font-size:.65rem; color:var(--color-gray-500); display:block; margin-top:4px; }
.upload-filename { font-size:.68rem; color:var(--color-green); margin-top:6px; display:none; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:100%; padding:0 4px; }
.upload-card.has-file .upload-filename { display:block; }
.upload-check { position:absolute; top:8px; right:8px; width:20px; height:20px; background:var(--color-green); color:white; border-radius:50%; display:none; align-items:center; justify-content:center; font-size:.7rem; }
.upload-card.has-file .upload-check { display:flex; }
/* Récap */
.recap-row { display:flex; justify-content:space-between; padding:8px 0; border-bottom:1px solid rgba(0,122,94,.1); font-size:.85rem; }
.recap-row:last-child { border-bottom:none; }
.recap-label { color:#6b7a70; font-weight:600; }
.recap-val { font-weight:700; color:var(--color-dark); }
.recap-file-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:10px; margin-bottom:16px; }
.recap-file-item { border:1px solid var(--color-gray-100); border-radius:var(--radius-md); padding:10px 12px; display:flex; align-items:center; gap:8px; font-size:.78rem; }
.recap-file-item i { font-size:1.1rem; flex-shrink:0; }
.recap-file-item.ok i { color:var(--color-green); }
.recap-file-item.nok i { color:var(--color-red); }
.recap-file-name { font-weight:700; color:var(--color-dark); display:block; font-size:.72rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; }
.recap-file-label { font-size:.65rem; color:var(--color-gray-500); display:block; }
.confirm-box { background:rgba(252,209,22,.12); border:1px solid var(--color-gold); border-radius:var(--radius-md); padding:14px 16px; font-size:.8rem; color:var(--color-dark); margin-bottom:20px; }
.confirm-box label { display:flex; align-items:flex-start; gap:10px; cursor:pointer; margin:0; }
.confirm-box input[type="checkbox"] { accent-color:var(--color-green); margin-top:3px; flex-shrink:0; }
.row { display:flex; flex-wrap:wrap; margin:0 -8px; }
.col-md-4 { flex:0 0 33.333%; padding:0 8px; max-width:33.333%; }
.col-md-6 { flex:0 0 50%; padding:0 8px; max-width:50%; }
.mb-3 { margin-bottom:16px; }
@media(max-width:768px){ .col-md-4,.col-md-6 { flex:0 0 100%; max-width:100%; } .step-label { display:none; } .upload-grid { grid-template-columns:repeat(2,1fr); } .recap-file-grid { grid-template-columns:repeat(2,1fr); } }
</style>

<div class="content-wrapper" style="padding:2rem;">

    {{-- En-tête --}}
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.5rem; background:white; padding:1.25rem 2rem; border-radius:var(--radius-lg); box-shadow:var(--shadow-md); border-left:4px solid var(--color-red);">
        <h1 style="font-size:1.5rem; font-weight:700; color:var(--color-dark); margin:0; display:flex; align-items:center; gap:12px;">
            <span style="width:5px; height:30px; background:linear-gradient(180deg,var(--color-red) 0%,var(--color-green) 50%,var(--color-gold) 100%); border-radius:2px;"></span>
            Nouveau Candidat
        </h1>
        <a href="{{ route('candidats.index') }}" style="color:var(--color-gray-500); text-decoration:none; font-size:.85rem;">
            <i class="bi bi-arrow-left"></i> Retour à la liste
        </a>
    </div>

    {{-- STEPPER --}}
    <div class="stepper">
        <div class="step"><div class="step-num active" id="snum1">1</div><div class="step-label active" id="slbl1">Informations</div></div>
        <div class="step-line" id="sline1"></div>
        <div class="step"><div class="step-num todo" id="snum2">2</div><div class="step-label todo" id="slbl2">Permis C</div></div>
        <div class="step-line" id="sline2"></div>
        <div class="step"><div class="step-num todo" id="snum3">3</div><div class="step-label todo" id="slbl3">Pièces jointes</div></div>
        <div class="step-line" id="sline3"></div>
        <div class="step"><div class="step-num todo" id="snum4">4</div><div class="step-label todo" id="slbl4">Récapitulatif</div></div>
    </div>

    @if($errors->any())
    <div class="alert-err">
        <i class="bi bi-exclamation-triangle"></i> <strong>Erreurs :</strong>
        <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div id="client-error-box" class="alert-err" style="display:none;">
        <i class="bi bi-exclamation-triangle"></i> <strong>Erreur :</strong> <span id="client-error-msg"></span>
    </div>

    <form method="POST" action="{{ route('candidats.store') }}" id="candidatForm" enctype="multipart/form-data">
        @csrf

        {{-- ══════ ÉTAPE 1 — Informations personnelles ══════ --}}
        <div id="step1">
            <div class="form-card">
                <div class="form-card-head"><i class="bi bi-person-fill"></i> Étape 1 — Informations personnelles</div>
                <div class="form-card-body">
                    <div class="info-box"><i class="bi bi-info-circle-fill"></i><div>Remplissez les informations personnelles du candidat. Les champs <strong>*</strong> sont obligatoires.</div></div>

                    <div class="section-title"><i class="bi bi-person"></i> Identité</div>
                    <div class="row mb-3">
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
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="lbl">Date de naissance <span class="req">*</span></label>
                            <div class="date-selects-group">
                                <select id="inp-ddn-jour" class="inp inp-jour">
                                    <option value="">JJ</option>
                                    @for($j=1;$j<=31;$j++)<option value="{{ str_pad($j,2,'0',STR_PAD_LEFT) }}">{{ str_pad($j,2,'0',STR_PAD_LEFT) }}</option>@endfor
                                </select>
                                <select id="inp-ddn-mois" class="inp inp-mois">
                                    <option value="">Mois</option>
                                    @foreach(['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'] as $idx=>$m)
                                        <option value="{{ str_pad($idx+1,2,'0',STR_PAD_LEFT) }}">{{ $m }}</option>
                                    @endforeach
                                </select>
                                <select id="inp-ddn-annee" class="inp inp-annee">
                                    <option value="">AAAA</option>
                                    @for($a=date('Y')-18;$a>=date('Y')-80;$a--)<option value="{{ $a }}">{{ $a }}</option>@endfor
                                </select>
                            </div>
                            <input type="hidden" id="inp-ddn" name="dateNaissance" value="{{ old('dateNaissance') }}">
                            @error('dateNaissance')<span class="invalid-msg">{{ $message }}</span>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="lbl">Lieu de naissance <span class="req">*</span></label>
                            <input type="text" id="inp-lieu" name="lieuNaissance" class="inp @error('lieuNaissance') is-invalid @enderror" value="{{ old('lieuNaissance') }}" placeholder="Ex: Bobo-Dioulasso" required>
                            @error('lieuNaissance')<span class="invalid-msg">{{ $message }}</span>@enderror
                        </div>
                    </div>

                    <div class="section-title"><i class="bi bi-telephone"></i> Contact</div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="lbl">Téléphone <span class="req">*</span></label>
                            <input type="tel" id="inp-tel" name="telephone" class="inp" value="{{ old('telephone') }}" placeholder="+226 XX XX XX XX" required>
                        </div>
                        <div class="col-md-6">
                            <label class="lbl">Email <span style="font-weight:400;font-size:.68rem;color:var(--color-gray-500);text-transform:none;">(Facultatif)</span></label>
                            <input type="email" id="inp-email" name="email" class="inp" value="{{ old('email') }}" placeholder="candidat@email.com">
                        </div>
                    </div>

                    <div class="btn-wrapper" style="border-top:none;padding-top:0;">
                        <a href="{{ route('candidats.index') }}" class="btn-prev" style="text-decoration:none;"><i class="bi bi-x"></i> Annuler</a>
                        <button type="button" class="btn-next" onclick="goToStep(2)">Suivant <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════ ÉTAPE 2 — Permis C ══════ --}}
        <div id="step2" style="display:none;">
            <div class="form-card">
                <div class="form-card-head"><i class="bi bi-credit-card"></i> Étape 2 — Permis C actuel</div>
                <div class="form-card-body">
                    <div class="info-box"><i class="bi bi-info-circle-fill"></i><div>Renseignez les informations du permis C du candidat.</div></div>
                    <div class="section-title"><i class="bi bi-credit-card"></i> Informations Permis C</div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="lbl">Numéro Permis C <span class="req">*</span></label>
                            <div style="position:relative;">
                                <span style="position:absolute;left:.75rem;top:50%;transform:translateY(-50%);font-weight:700;color:#374151;font-size:.88rem;pointer-events:none;z-index:1;">N°</span>
                                <input type="text" id="inp-num-permis" class="inp" placeholder="XXXXXXXX" style="padding-left:2.2rem;" oninput="formatPermisC(this)">
                            </div>
                            <input type="hidden" id="inp-num-permis-hidden" name="numeroPermisC" value="{{ old('numeroPermisC') }}">
                            <span style="font-size:.65rem;color:#6b7a70;margin-top:3px;display:block;"><i class="bi bi-info-circle"></i> Le préfixe N° est automatique</span>
                        </div>
                        <div class="col-md-4">
                            <label class="lbl">Date délivrance <span class="req">*</span></label>
                            <input type="date" id="inp-date-permis" name="dateDelivrancePermisC" class="inp" value="{{ old('dateDelivrancePermisC') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="lbl">Lieu délivrance <span class="req">*</span></label>
                            <input type="text" id="inp-lieu-permis" name="lieuDelivrancePermisC" class="inp" value="{{ old('lieuDelivrancePermisC') }}" placeholder="Ex: Bobo-Dioulasso" required>
                        </div>
                    </div>
                    <div class="btn-wrapper">
                        <button type="button" class="btn-prev" onclick="goToStep(1)"><i class="bi bi-arrow-left"></i> Précédent</button>
                        <button type="button" class="btn-next" onclick="goToStep(3)">Suivant <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════ ÉTAPE 3 — Pièces jointes ══════ --}}
        <div id="step3" style="display:none;">
            <div class="form-card">
                <div class="form-card-head"><i class="bi bi-folder2-open"></i> Étape 3 — Pièces jointes du dossier</div>
                <div class="form-card-body">
                    <div class="info-box"><i class="bi bi-info-circle-fill"></i><div>Formats acceptés : <strong>JPEG, PNG, PDF</strong>. Taille max : <strong>5 Mo</strong> par fichier. Les 4 premiers documents sont obligatoires.</div></div>

                    <div class="section-title"><i class="bi bi-files"></i> Documents à fournir</div>
                    <div class="upload-grid">
                        <div class="upload-card required-doc" id="card-cnib">
                            <div class="upload-check"><i class="bi bi-check"></i></div>
                            <i class="bi bi-person-vcard upload-icon"></i>
                            <span class="upload-title">CNIB</span>
                            <span class="upload-badge-required">Obligatoire</span>
                            <span class="upload-hint">Carte nationale d'identité</span>
                            <input type="file" id="file-cnib" name="cnib" accept=".jpeg,.jpg,.png,.pdf" onchange="handleFile(this,'card-cnib','name-cnib')">
                            <span class="upload-filename" id="name-cnib"></span>
                        </div>
                        <div class="upload-card required-doc" id="card-photo">
                            <div class="upload-check"><i class="bi bi-check"></i></div>
                            <i class="bi bi-person-circle upload-icon"></i>
                            <span class="upload-title">Photo Identité</span>
                            <span class="upload-badge-required">Obligatoire</span>
                            <span class="upload-hint">Fond blanc, récente</span>
                            <input type="file" id="file-photo" name="photo_identite" accept=".jpeg,.jpg,.png" onchange="handleFile(this,'card-photo','name-photo')">
                            <span class="upload-filename" id="name-photo"></span>
                        </div>
                        <div class="upload-card required-doc" id="card-certif">
                            <div class="upload-check"><i class="bi bi-check"></i></div>
                            <i class="bi bi-heart-pulse upload-icon"></i>
                            <span class="upload-title">Certificat Médical</span>
                            <span class="upload-badge-required">Obligatoire</span>
                            <span class="upload-hint">Apte à conduire</span>
                            <input type="file" id="file-certif" name="certificat_medical" accept=".jpeg,.jpg,.png,.pdf" onchange="handleFile(this,'card-certif','name-certif')">
                            <span class="upload-filename" id="name-certif"></span>
                        </div>
                        <div class="upload-card required-doc" id="card-acte">
                            <div class="upload-check"><i class="bi bi-check"></i></div>
                            <i class="bi bi-file-earmark-text upload-icon"></i>
                            <span class="upload-title">Acte de Naissance</span>
                            <span class="upload-badge-required">Obligatoire</span>
                            <span class="upload-hint">Extrait ou copie intégrale</span>
                            <input type="file" id="file-acte" name="acte_naissance" accept=".jpeg,.jpg,.png,.pdf" onchange="handleFile(this,'card-acte','name-acte')">
                            <span class="upload-filename" id="name-acte"></span>
                        </div>
                        <div class="upload-card" id="card-permisc">
                            <div class="upload-check"><i class="bi bi-check"></i></div>
                            <i class="bi bi-card-heading upload-icon"></i>
                            <span class="upload-title">Copie Permis C</span>
                            <span class="upload-badge-optional">Facultatif</span>
                            <span class="upload-hint">Si vous possédez un permis C</span>
                            <input type="file" id="file-permisc" name="permis_c" accept=".jpeg,.jpg,.png,.pdf" onchange="handleFile(this,'card-permisc','name-permisc')">
                            <span class="upload-filename" id="name-permisc"></span>
                        </div>
                    </div>
                    <div style="text-align:right;font-size:.72rem;color:var(--color-gray-500);margin-top:8px;">
                        <i class="bi bi-paperclip"></i> <span id="file-counter">0</span> / 4 fichiers obligatoires
                    </div>
                    <div class="btn-wrapper">
                        <button type="button" class="btn-prev" onclick="goToStep(2)"><i class="bi bi-arrow-left"></i> Précédent</button>
                        <button type="button" class="btn-next" onclick="goToStep(4)">Suivant <i class="bi bi-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════ ÉTAPE 4 — Récapitulatif ══════ --}}
        <div id="step4" style="display:none;">
            <div class="form-card">
                <div class="form-card-head"><i class="bi bi-clipboard-check"></i> Étape 4 — Récapitulatif</div>
                <div class="form-card-body">
                    <div class="info-box" style="background:rgba(252,209,22,.1);border-left-color:var(--color-gold-dark);color:var(--color-dark);">
                        <i class="bi bi-exclamation-circle-fill" style="color:var(--color-gold-dark);"></i>
                        <div><strong>Vérifiez les informations avant d'enregistrer.</strong></div>
                    </div>

                    <div class="section-title"><i class="bi bi-person"></i> Identité & Contact</div>
                    <div style="margin-bottom:18px;">
                        <div class="recap-row"><span class="recap-label">Nom complet</span><span class="recap-val" id="r-nom">—</span></div>
                        <div class="recap-row"><span class="recap-label">Date de naissance</span><span class="recap-val" id="r-ddn">—</span></div>
                        <div class="recap-row"><span class="recap-label">Lieu de naissance</span><span class="recap-val" id="r-lieu">—</span></div>
                        <div class="recap-row"><span class="recap-label">Téléphone</span><span class="recap-val" id="r-tel">—</span></div>
                        <div class="recap-row"><span class="recap-label">Email</span><span class="recap-val" id="r-email">—</span></div>
                    </div>

                    <div class="section-title"><i class="bi bi-credit-card"></i> Permis C</div>
                    <div style="margin-bottom:18px;">
                        <div class="recap-row"><span class="recap-label">Numéro</span><span class="recap-val" id="r-permis">—</span></div>
                        <div class="recap-row"><span class="recap-label">Date délivrance</span><span class="recap-val" id="r-date-permis">—</span></div>
                        <div class="recap-row"><span class="recap-label">Lieu délivrance</span><span class="recap-val" id="r-lieu-permis">—</span></div>
                    </div>

                    <div class="section-title"><i class="bi bi-folder2"></i> Pièces jointes</div>
                    <div class="recap-file-grid" id="recap-files-grid"></div>

                    <div class="confirm-box">
                        <label>
                            <input type="checkbox" id="confirmCheck">
                            <span>Je certifie que toutes les informations saisies sont exactes et que les documents fournis sont authentiques.</span>
                        </label>
                    </div>

                    <div class="btn-wrapper">
                        <button type="button" class="btn-prev" onclick="goToStep(3)"><i class="bi bi-arrow-left"></i> Précédent</button>
                        <button type="submit" class="btn-submit" id="btn-submit-final" disabled>
                            <i class="bi bi-check2-circle"></i> Enregistrer le candidat
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

<script>
function formatPermisC(input) {
    let val = input.value.replace(/^N°\s*/i,'').replace(/[^a-zA-Z0-9\-]/g,'');
    const h = document.getElementById('inp-num-permis-hidden');
    if (h) h.value = val ? 'N°' + val : '';
    input.value = val;
}

function syncDDN() {
    const j = document.getElementById('inp-ddn-jour').value;
    const m = document.getElementById('inp-ddn-mois').value;
    const a = document.getElementById('inp-ddn-annee').value;
    document.getElementById('inp-ddn').value = (j && m && a) ? `${a}-${m}-${j}` : '';
}
['inp-ddn-jour','inp-ddn-mois','inp-ddn-annee'].forEach(id => {
    document.getElementById(id)?.addEventListener('change', syncDDN);
});

document.getElementById('confirmCheck').addEventListener('change', function() {
    document.getElementById('btn-submit-final').disabled = !this.checked;
});

function showError(msg) {
    const box = document.getElementById('client-error-box');
    document.getElementById('client-error-msg').innerText = msg;
    box.style.display = 'block';
    window.scrollTo({top:0,behavior:'smooth'});
}
function hideError() { document.getElementById('client-error-box').style.display='none'; }
function formatDate(str) { if (!str) return '—'; return new Date(str+'T00:00:00').toLocaleDateString('fr-FR'); }

function handleFile(input, cardId, nameId) {
    const card = document.getElementById(cardId);
    const nameSpan = document.getElementById(nameId);
    if (input.files && input.files[0]) {
        if (input.files[0].size > 5*1024*1024) {
            showError(`Le fichier "${input.files[0].name}" dépasse 5 Mo.`);
            input.value = '';
            card.classList.remove('has-file'); card.classList.add('has-error');
            nameSpan.textContent = '';
            updateCounter(); return;
        }
        card.classList.add('has-file'); card.classList.remove('has-error','required-doc');
        nameSpan.textContent = input.files[0].name;
    } else {
        card.classList.remove('has-file'); card.classList.add('required-doc');
        nameSpan.textContent = '';
    }
    updateCounter();
}

function updateCounter() {
    const ids = ['file-cnib','file-photo','file-certif','file-acte'];
    const count = ids.filter(id => { const el=document.getElementById(id); return el && el.files && el.files.length>0; }).length;
    document.getElementById('file-counter').textContent = count;
}

function goToStep(step) {
    hideError();

    if (step === 2) {
        const nom = document.getElementById('inp-nom').value.trim();
        const prenom = document.getElementById('inp-prenom').value.trim();
        const ddn = document.getElementById('inp-ddn').value;
        const lieu = document.getElementById('inp-lieu').value.trim();
        const tel = document.getElementById('inp-tel').value.trim();
        if (!nom || !prenom || !lieu || !tel) { showError("Remplissez tous les champs obligatoires (*)."); return; }
        if (!ddn) { showError("Sélectionnez la date de naissance complète (jour, mois, année)."); return; }
    }

    if (step === 3) {
        const permis = document.getElementById('inp-num-permis-hidden').value.trim();
        const date = document.getElementById('inp-date-permis').value;
        const lieu = document.getElementById('inp-lieu-permis').value.trim();
        if (!permis || !date || !lieu) { showError("Remplissez tous les champs du Permis C."); return; }
    }

    if (step === 4) {
        const required = [
            {id:'file-cnib', card:'card-cnib', label:'CNIB'},
            {id:'file-photo', card:'card-photo', label:'Photo Identité'},
            {id:'file-certif', card:'card-certif', label:'Certificat Médical'},
            {id:'file-acte', card:'card-acte', label:'Acte de Naissance'},
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

        // Remplir le récap
        document.getElementById('r-nom').innerText = document.getElementById('inp-nom').value.toUpperCase() + ' ' + document.getElementById('inp-prenom').value;
        document.getElementById('r-ddn').innerText = formatDate(document.getElementById('inp-ddn').value);
        document.getElementById('r-lieu').innerText = document.getElementById('inp-lieu').value;
        document.getElementById('r-tel').innerText = document.getElementById('inp-tel').value;
        document.getElementById('r-email').innerText = document.getElementById('inp-email').value || 'Non renseigné';
        document.getElementById('r-permis').innerText = document.getElementById('inp-num-permis-hidden').value;
        document.getElementById('r-date-permis').innerText = formatDate(document.getElementById('inp-date-permis').value);
        document.getElementById('r-lieu-permis').innerText = document.getElementById('inp-lieu-permis').value;

        const allFiles = [
            {id:'file-cnib', label:'CNIB', req:true},
            {id:'file-photo', label:'Photo Identité', req:true},
            {id:'file-certif', label:'Certificat Médical', req:true},
            {id:'file-acte', label:'Acte de Naissance', req:true},
            {id:'file-permisc', label:'Copie Permis C', req:false},
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

    [1,2,3,4].forEach(i => {
        const el = document.getElementById('step'+i);
        if (el) el.style.display = (i===step) ? 'block' : 'none';
    });

    for (let i=1; i<=4; i++) {
        const num = document.getElementById('snum'+i);
        const lbl = document.getElementById('slbl'+i);
        const line = document.getElementById('sline'+i);
        if (i < step) {
            num.className='step-num done'; num.innerHTML='<i class="bi bi-check"></i>';
            if (lbl) lbl.className='step-label done';
            if (line) line.className='step-line done';
        } else if (i===step) {
            num.className='step-num active'; num.innerText=i;
            if (lbl) lbl.className='step-label active';
            if (line) line.className='step-line';
        } else {
            num.className='step-num todo'; num.innerText=i;
            if (lbl) lbl.className='step-label todo';
            if (line) line.className='step-line';
        }
    }
    window.scrollTo({top:0,behavior:'instant'});
}
</script>
</x-layouts::app>
