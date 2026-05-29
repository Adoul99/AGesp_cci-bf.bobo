{{-- ════════════════════════════════════════════════════════
     two-factor-challenge.blade.php
     Remplace : resources/views/auth/two-factor-challenge.blade.php
     (compatible Jetstream / Fortify)
════════════════════════════════════════════════════════ --}}
@extends('layouts.auth')

@section('title', 'Authentification à deux facteurs')

@section('panel-badge') Double sécurité @endsection
@section('panel-title') Authentification <em>deux facteurs</em> @endsection
@section('panel-desc')
    Entrez le code généré par votre application d'authentification
    ou utilisez un code de récupération d'urgence.
@endsection
@section('panel-features')
    <div class="p-feat"><i class="bi bi-phone-fill"></i> Code de votre application authenticator</div>
    <div class="p-feat"><i class="bi bi-key-fill"></i> Code de récupération d'urgence</div>
    <div class="p-feat"><i class="bi bi-shield-fill-check"></i> Couche de sécurité supplémentaire</div>
    <div class="p-feat"><i class="bi bi-lock-fill"></i> Votre compte est protégé</div>
@endsection

@section('form')

<div class="f-eyebrow">Authentification 2FA</div>
<h1 class="f-title" id="2fa-title">Code d'authentification</h1>
<p class="f-sub" id="2fa-desc">Entrez le code fourni par votre application d'authentification.</p>

@if ($errors->any())
    <div class="alert alert-err">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span>{{ $errors->first() }}</span>
    </div>
@endif

<form method="POST" action="{{ route('two-factor.login.store') }}" id="tf-form">
    @csrf

    {{-- Code OTP --}}
    <div id="otp-section">
        <div class="fg">
            <label style="justify-content:center;"><i class="bi bi-grid-3x3-gap" style="color:var(--v);margin-right:4px;"></i>Code à 6 chiffres</label>
        </div>

        <div class="otp-wrap">
            <input class="otp-digit" id="d1" name="_d1" maxlength="1" inputmode="numeric" oninput="dIn(this,1)" onkeydown="dBk(event,1)">
            <input class="otp-digit" id="d2" name="_d2" maxlength="1" inputmode="numeric" oninput="dIn(this,2)" onkeydown="dBk(event,2)">
            <input class="otp-digit" id="d3" name="_d3" maxlength="1" inputmode="numeric" oninput="dIn(this,3)" onkeydown="dBk(event,3)">
            <input class="otp-digit" id="d4" name="_d4" maxlength="1" inputmode="numeric" oninput="dIn(this,4)" onkeydown="dBk(event,4)">
            <input class="otp-digit" id="d5" name="_d5" maxlength="1" inputmode="numeric" oninput="dIn(this,5)" onkeydown="dBk(event,5)">
            <input class="otp-digit" id="d6" name="_d6" maxlength="1" inputmode="numeric" oninput="dIn(this,6)" onkeydown="dBk(event,6)">
        </div>
        <input type="hidden" name="code" id="tf-code">
    </div>

    {{-- Code récupération --}}
    <div id="recovery-section" style="display:none;">
        <div class="fg">
            <label>Code de récupération d'urgence <span class="req">*</span></label>
            <div class="inp-wrap">
                <i class="bi bi-key inp-ico"></i>
                <input type="text" name="recovery_code" id="tf-recovery"
                       class="inp @error('recovery_code') is-invalid @enderror"
                       placeholder="XXXX-XXXX-XXXX"
                       autocomplete="one-time-code">
            </div>
            @error('recovery_code')<span class="invalid-msg">{{ $message }}</span>@enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary" style="margin-bottom:12px;">
        <i class="bi bi-arrow-right-circle"></i> Continuer
    </button>
</form>

<div class="sep"><hr> ou <hr></div>

<button type="button" class="btn btn-ghost" onclick="toggleMode()">
    <i class="bi bi-arrow-repeat" id="toggle-icon"></i>
    <span id="toggle-label">Utiliser un code de récupération</span>
</button>

@endsection

@push('scripts')
<script>
let useRecovery = false;

/* ── OTP input ── */
function dIn(el, pos) {
    el.value = el.value.replace(/\D/g,'');
    el.classList.toggle('filled', el.value.length===1);
    if (el.value.length===1) { const n=document.getElementById('d'+(pos+1)); if(n) n.focus(); }
    syncCode();
}
function dBk(e, pos) {
    if (e.key==='Backspace') {
        const el=document.getElementById('d'+pos);
        if (!el.value) { const p=document.getElementById('d'+(pos-1)); if(p){p.value='';p.classList.remove('filled');p.focus();} }
    }
    syncCode();
}
function syncCode() {
    let c='';
    for(let i=1;i<=6;i++) c+=document.getElementById('d'+i).value;
    document.getElementById('tf-code').value = c;
}

/* ── Toggle mode ── */
function toggleMode() {
    useRecovery = !useRecovery;
    document.getElementById('otp-section').style.display      = useRecovery ? 'none'  : 'block';
    document.getElementById('recovery-section').style.display = useRecovery ? 'block' : 'none';
    document.getElementById('2fa-title').textContent = useRecovery ? 'Code de récupération' : 'Code d\'authentification';
    document.getElementById('2fa-desc').textContent  = useRecovery
        ? 'Entrez l\'un de vos codes de récupération d\'urgence.'
        : 'Entrez le code fourni par votre application d\'authentification.';
    document.getElementById('toggle-label').textContent = useRecovery ? 'Utiliser le code d\'authentification' : 'Utiliser un code de récupération';
    document.getElementById('toggle-icon').className   = 'bi bi-arrow-repeat';

    if (useRecovery) {
        document.getElementById('tf-recovery').focus();
        document.getElementById('tf-code').removeAttribute('required');
    } else {
        document.getElementById('d1').focus();
        document.getElementById('tf-code').setAttribute('required','');
    }
}

/* Focus auto au chargement */
document.addEventListener('DOMContentLoaded', () => {
    const d1 = document.getElementById('d1');
    if (d1) d1.focus();
});
</script>
@endpush
