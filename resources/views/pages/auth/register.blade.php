@extends('layouts.auth')

@section('title', 'Créer un compte')

{{-- ── Panneau gauche ── --}}
@section('panel-badge') Inscription candidat @endsection
@section('panel-title') Créez votre <em>compte</em> AGesp @endsection
@section('panel-desc')
    Créez votre espace personnel pour suivre votre dossier, consulter
    vos résultats d'examens et télécharger vos attestations en ligne.
@endsection
@section('panel-features')
    <div class="p-feat"><i class="bi bi-folder2-open"></i> Suivi de votre dossier en temps réel</div>
    <div class="p-feat"><i class="bi bi-calendar-check"></i> Dates de formation et d'examen</div>
    <div class="p-feat"><i class="bi bi-trophy"></i> Résultats d'examens</div>
    <div class="p-feat"><i class="bi bi-award"></i> Téléchargement des attestations</div>
    <div class="p-feat"><i class="bi bi-bell"></i> Notifications sur votre dossier</div>
@endsection

{{-- ── Formulaire ── --}}
@section('form')

{{-- ══════════════════════════════════════ --}}
{{-- ÉTAPE 1 — Informations du compte      --}}
{{-- ══════════════════════════════════════ --}}
<div id="reg-step1">
    <div class="f-eyebrow">Étape 1 sur 2</div>
    <h1 class="f-title">Créer un compte</h1>
    <p class="f-sub">Renseignez vos informations pour créer votre espace candidat.</p>

    @if ($errors->any())
        <div class="alert alert-err">
            <i class="bi bi-exclamation-triangle-fill"></i>
            <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
        </div>
    @endif

    <div id="js-err" class="alert alert-err" style="display:none;">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span id="js-err-msg"></span>
    </div>

    {{-- Nom + Prénom --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div class="fg" style="margin-bottom:0;">
            <label>Nom <span class="req">*</span></label>
            <div class="inp-wrap">
                <i class="bi bi-person inp-ico"></i>
                <input type="text" id="r-nom" class="inp" placeholder="Nom de famille"
                       value="{{ old('name','') }}" autocomplete="off">
            </div>
        </div>
        <div class="fg" style="margin-bottom:0;">
            <label>Prénom(s) <span class="req">*</span></label>
            <div class="inp-wrap">
                <i class="bi bi-person inp-ico"></i>
                <input type="text" id="r-prenom" class="inp" placeholder="Prénom"
                       value="{{ old('prenom','') }}" autocomplete="off">
            </div>
        </div>
    </div>

    {{-- Email --}}
    <div class="fg" style="margin-top:14px;">
        <label>
            <i class="bi bi-envelope" style="color:var(--v);margin-right:4px;"></i>
            Email <span class="req">*</span>
            <span style="font-weight:400;font-size:.68rem;color:var(--sub);text-transform:none;">(identifiant de connexion)</span>
        </label>
        <div class="inp-wrap">
            <i class="bi bi-envelope inp-ico"></i>
            <input type="email" id="r-email" class="inp"
                   placeholder="votre@email.com"
                   value="{{ old('email','') }}">
        </div>
    </div>

    {{-- Téléphone (facultatif) --}}
    <div class="fg">
        <label>
            <i class="bi bi-phone" style="color:var(--sub);margin-right:4px;"></i>
            Téléphone
            <span style="font-weight:400;font-size:.68rem;color:var(--sub);text-transform:none;">(facultatif)</span>
        </label>
        <div class="phone-wrap">
            <div class="phone-prefix"><i class="bi bi-flag"></i> +226</div>
            <input type="tel" id="r-tel" class="inp"
                   placeholder="XX XX XX XX" maxlength="8"
                   value="{{ old('telephone','') }}"
                   oninput="this.value=this.value.replace(/\D/g,'')">
        </div>
    </div>

    {{-- Mot de passe --}}
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
        <div class="fg" style="margin-bottom:0;">
            <label>Mot de passe <span class="req">*</span></label>
            <div class="inp-wrap">
                <i class="bi bi-lock inp-ico"></i>
                <input type="password" id="r-pwd" class="inp"
                       placeholder="Min. 8 caractères"
                       oninput="pwdStrength(this.value)">
                <button type="button" class="inp-eye" onclick="togglePwd('r-pwd','eye1')" tabindex="-1">
                    <i class="bi bi-eye" id="eye1"></i>
                </button>
            </div>
            <div class="pwd-bar-wrap" id="pwd-bar-wrap" style="display:none;">
                <div class="pwd-bar"><div class="pwd-fill" id="pwd-fill"></div></div>
                <span class="pwd-text" id="pwd-text"></span>
            </div>
        </div>
        <div class="fg" style="margin-bottom:0;">
            <label>Confirmer <span class="req">*</span></label>
            <div class="inp-wrap">
                <i class="bi bi-lock inp-ico"></i>
                <input type="password" id="r-pwd2" class="inp" placeholder="Répéter">
                <button type="button" class="inp-eye" onclick="togglePwd('r-pwd2','eye2')" tabindex="-1">
                    <i class="bi bi-eye" id="eye2"></i>
                </button>
            </div>
        </div>
    </div>

    <div style="margin-top:20px;">
        <button type="button" class="btn btn-primary" onclick="toStep2()">
            Suivant — Vérifier mon email <i class="bi bi-arrow-right"></i>
        </button>
    </div>

    <div class="f-link-row">
        Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a>
    </div>
</div>

{{-- ══════════════════════════════════════ --}}
{{-- ÉTAPE 2 — Vérification Email          --}}
{{-- ══════════════════════════════════════ --}}
<div id="reg-step2" style="display:none;">
    <div class="f-eyebrow">Étape 2 sur 2</div>
    <h1 class="f-title">Vérification Email</h1>
    <p class="f-sub">
        Un code à 6 chiffres a été envoyé à
        <strong id="email-addr">votre@email.com</strong>.
        Saisissez-le ci-dessous.
    </p>

    <div id="js-err2" class="alert alert-err" style="display:none;">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span id="js-err2-msg"></span>
    </div>

    <div class="otp-wrap">
        <input class="otp-digit" id="d1" maxlength="1" inputmode="numeric" oninput="dInput(this,1)" onkeydown="dBack(event,1)">
        <input class="otp-digit" id="d2" maxlength="1" inputmode="numeric" oninput="dInput(this,2)" onkeydown="dBack(event,2)">
        <input class="otp-digit" id="d3" maxlength="1" inputmode="numeric" oninput="dInput(this,3)" onkeydown="dBack(event,3)">
        <input class="otp-digit" id="d4" maxlength="1" inputmode="numeric" oninput="dInput(this,4)" onkeydown="dBack(event,4)">
        <input class="otp-digit" id="d5" maxlength="1" inputmode="numeric" oninput="dInput(this,5)" onkeydown="dBack(event,5)">
        <input class="otp-digit" id="d6" maxlength="1" inputmode="numeric" oninput="dInput(this,6)" onkeydown="dBack(event,6)">
    </div>
    <input type="hidden" id="otp-hidden">

    <div style="text-align:center;font-size:.78rem;color:var(--sub);margin-bottom:18px;">
        <span id="resend-timer">Renvoyer dans <strong id="cdown">03:00</strong></span>
        <button id="resend-btn" style="display:none;background:none;border:none;color:var(--v);font-weight:700;cursor:pointer;font-size:.78rem;" onclick="resend()">
            <i class="bi bi-arrow-clockwise"></i> Renvoyer le code
        </button>
    </div>

    <div style="display:flex;gap:10px;">
        <button type="button" class="btn btn-ghost" style="flex:1;" onclick="toStep1()">
            <i class="bi bi-arrow-left"></i> Précédent
        </button>
        <button type="button" class="btn btn-primary" style="flex:2;" onclick="verifyOtp()">
            <i class="bi bi-shield-check"></i> Vérifier et créer le compte
        </button>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════════ --}}
{{-- ÉTAPE 3 — Compte créé → Formulaire POST → /s-inscrire    --}}
{{-- ══════════════════════════════════════════════════════════ --}}
<div id="reg-step3" style="display:none;">
    <div style="text-align:center;padding:10px 0 24px;">
        <div style="width:68px;height:68px;background:var(--v);border-radius:50%;
                    display:flex;align-items:center;justify-content:center;
                    margin:0 auto 16px;box-shadow:0 6px 20px rgba(26,107,58,.3);">
            <i class="bi bi-check-lg" style="font-size:2rem;color:white;"></i>
        </div>
        <div class="f-eyebrow" style="justify-content:center;margin-bottom:6px;">Compte vérifié ✓</div>
        <h1 class="f-title" style="font-size:1.45rem;color:var(--v);">Compte créé avec succès !</h1>
        <p class="f-sub" style="margin-bottom:4px;">
            Bienvenue, <strong id="welcome-name">Candidat</strong> !
        </p>
        <p class="f-sub">Email confirmé : <strong id="welcome-email">votre@email.com</strong></p>
    </div>

    <div class="alert alert-warn" style="font-size:.78rem;">
        <i class="bi bi-info-circle-fill"></i>
        <span>
            Votre compte est prêt. Cliquez ci-dessous pour remplir votre
            <strong>formulaire d'inscription candidat</strong> (4 étapes).
        </span>
    </div>

    {{--
        ╔══════════════════════════════════════════════════════════╗
        ║  Ce formulaire POST crée le compte via Fortify           ║
        ║  Fortify redirige ensuite vers /s-inscrire               ║
        ║  (configuré dans FortifyServiceProvider.php)             ║
        ╚══════════════════════════════════════════════════════════╝
    --}}
    <form method="POST" action="{{ route('register') }}" id="final-form">
        @csrf
        <input type="hidden" name="name"                  id="h-name">
        <input type="hidden" name="prenom"                id="h-prenom">
        <input type="hidden" name="telephone"             id="h-tel">
        <input type="hidden" name="email"                 id="h-email">
        <input type="hidden" name="password"              id="h-pwd">
        <input type="hidden" name="password_confirmation" id="h-pwd2">
        <input type="hidden" name="email_verified"        value="1">

        {{-- ✅ Ce bouton soumet → register → Fortify → redirect /s-inscrire --}}
        <button type="submit" class="btn btn-primary" style="margin-bottom:10px;">
            <i class="bi bi-pencil-square"></i>
            Continuer vers l'inscription candidat
            <i class="bi bi-arrow-right"></i>
        </button>
    </form>

    <a href="{{ url('/') }}" class="btn btn-ghost" style="text-decoration:none;margin-top:4px;">
        <i class="bi bi-house"></i> Retour à l'accueil
    </a>
</div>

@endsection

@push('scripts')
<script>
/* ────────────────────────────────────────────────
   UTILS
──────────────────────────────────────────────── */
function togglePwd(id, ico) {
    const f = document.getElementById(id), i = document.getElementById(ico);
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
function showErr(boxId, msgId, msg) {
    document.getElementById(msgId).textContent = msg;
    document.getElementById(boxId).style.display = 'flex';
    window.scrollTo({top:0,behavior:'smooth'});
}
function hideErr(boxId) { document.getElementById(boxId).style.display = 'none'; }

/* ────────────────────────────────────────────────
   FORCE MOT DE PASSE
──────────────────────────────────────────────── */
function pwdStrength(v) {
    const wrap = document.getElementById('pwd-bar-wrap');
    if (!v) { wrap.style.display='none'; return; }
    wrap.style.display = 'block';
    let s = 0;
    if (v.length >= 8)          s++;
    if (/[A-Z]/.test(v))        s++;
    if (/[0-9]/.test(v))        s++;
    if (/[^A-Za-z0-9]/.test(v)) s++;
    const lvls = [
        {pct:'25%', col:'#c0281e', txt:'Très faible'},
        {pct:'50%', col:'#d4a017', txt:'Faible'},
        {pct:'75%', col:'#00A572', txt:'Moyen'},
        {pct:'100%',col:'#1a6b3a', txt:'Fort'},
    ];
    const l = lvls[s-1] || lvls[0];
    document.getElementById('pwd-fill').style.cssText = `width:${l.pct};background:${l.col}`;
    const tx = document.getElementById('pwd-text');
    tx.textContent = 'Force : ' + l.txt;
    tx.style.color = l.col;
}

/* ────────────────────────────────────────────────
   NAVIGATION ÉTAPES
──────────────────────────────────────────────── */
function show(id) { document.getElementById(id).style.display = 'block'; }
function hide(id) { document.getElementById(id).style.display = 'none'; }
function toStep1() { hide('reg-step2'); show('reg-step1'); window.scrollTo({top:0}); }

function toStep2() {
    hideErr('js-err');
    const nom   = document.getElementById('r-nom').value.trim();
    const prn   = document.getElementById('r-prenom').value.trim();
    const email = document.getElementById('r-email').value.trim();
    const pwd   = document.getElementById('r-pwd').value;
    const pwd2  = document.getElementById('r-pwd2').value;

    if (!nom || !prn)
        { showErr('js-err','js-err-msg','Veuillez saisir votre nom et prénom.'); return; }
    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email))
        { showErr('js-err','js-err-msg','Veuillez saisir une adresse email valide.'); return; }
    if (pwd.length < 8)
        { showErr('js-err','js-err-msg','Mot de passe trop court (min. 8 caractères).'); return; }
    if (pwd !== pwd2)
        { showErr('js-err','js-err-msg','Les mots de passe ne correspondent pas.'); return; }

    // Afficher l'email dans l'étape 2
    document.getElementById('email-addr').textContent = email;

    // Envoyer le code de vérification
    fetch('/verify-email/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ email })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            hide('reg-step1');
            show('reg-step2');
            startCountdown(180);
            document.getElementById('d1').focus();
            window.scrollTo({top:0});
        } else {
            showErr('js-err','js-err-msg', data.message || 'Erreur lors de l\'envoi du code.');
        }
    })
    .catch(() => showErr('js-err','js-err-msg','Erreur réseau. Veuillez réessayer.'));
}

/* ────────────────────────────────────────────────
   OTP — SAISIE CHIFFRES
──────────────────────────────────────────────── */
function dInput(el, pos) {
    el.value = el.value.replace(/\D/g, '');
    el.classList.toggle('filled', el.value.length === 1);
    if (el.value.length === 1) {
        const n = document.getElementById('d'+(pos+1));
        if (n) n.focus();
    }
    syncOtp();
}
function dBack(e, pos) {
    if (e.key === 'Backspace') {
        const el = document.getElementById('d'+pos);
        if (!el.value) {
            const p = document.getElementById('d'+(pos-1));
            if (p) { p.value=''; p.classList.remove('filled'); p.focus(); }
        }
    }
    syncOtp();
}
function syncOtp() {
    let c = '';
    for (let i=1; i<=6; i++) c += document.getElementById('d'+i).value;
    document.getElementById('otp-hidden').value = c;
}

/* ────────────────────────────────────────────────
   VÉRIFICATION OTP
──────────────────────────────────────────────── */
function verifyOtp() {
    hideErr('js-err2');
    const code  = document.getElementById('otp-hidden').value;
    const email = document.getElementById('email-addr').textContent;

    if (code.length < 6) {
        showErr('js-err2','js-err2-msg','Veuillez entrer le code complet à 6 chiffres.');
        return;
    }

    fetch('/verify-email/verify', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ email, code })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            toStep3();
        } else {
            showErr('js-err2','js-err2-msg', data.message || 'Code invalide. Réessayez.');
        }
    })
    .catch(() => showErr('js-err2','js-err2-msg','Erreur réseau. Veuillez réessayer.'));
}

/* ────────────────────────────────────────────────
   ÉTAPE 3 — Préparer et afficher
──────────────────────────────────────────────── */
function toStep3() {
    const nom   = document.getElementById('r-nom').value.trim();
    const prn   = document.getElementById('r-prenom').value.trim();
    const email = document.getElementById('r-email').value.trim();
    const tel   = document.getElementById('r-tel').value.trim();

    // Remplir les champs cachés du formulaire POST final
    document.getElementById('h-name').value   = nom;
    document.getElementById('h-prenom').value = prn;
    document.getElementById('h-tel').value    = tel;
    document.getElementById('h-email').value  = email;
    document.getElementById('h-pwd').value    = document.getElementById('r-pwd').value;
    document.getElementById('h-pwd2').value   = document.getElementById('r-pwd2').value;

    // Affichage de bienvenue
    document.getElementById('welcome-name').textContent  = nom + ' ' + prn;
    document.getElementById('welcome-email').textContent = email;

    hide('reg-step2');
    show('reg-step3');
    window.scrollTo({top:0});
}

/* ────────────────────────────────────────────────
   COUNTDOWN RENVOI CODE
──────────────────────────────────────────────── */
let timer = null;
function startCountdown(sec) {
    clearInterval(timer);
    document.getElementById('resend-btn').style.display  = 'none';
    document.getElementById('resend-timer').style.display = 'inline';
    let r = sec;
    tick(r);
    timer = setInterval(() => {
        r--; tick(r);
        if (r <= 0) {
            clearInterval(timer);
            document.getElementById('resend-timer').style.display = 'none';
            document.getElementById('resend-btn').style.display   = 'inline';
        }
    }, 1000);
}
function tick(s) {
    document.getElementById('cdown').textContent =
        String(Math.floor(s/60)).padStart(2,'0') + ':' + String(s%60).padStart(2,'0');
}
function resend() {
    const email = document.getElementById('email-addr').textContent;
    fetch('/verify-email/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ email })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            startCountdown(180);
            [1,2,3,4,5,6].forEach(i => {
                const d = document.getElementById('d'+i);
                d.value = ''; d.classList.remove('filled');
            });
            document.getElementById('d1').focus();
        } else {
            showErr('js-err2','js-err2-msg', data.message || 'Erreur lors du renvoi.');
        }
    })
    .catch(() => showErr('js-err2','js-err2-msg','Erreur réseau.'));
}
</script>
@endpush
