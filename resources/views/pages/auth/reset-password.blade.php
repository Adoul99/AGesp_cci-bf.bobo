{{-- ════════════════════════════════════════════════════════
     reset-password.blade.php
     Remplace : resources/views/auth/reset-password.blade.php
════════════════════════════════════════════════════════ --}}
@extends('layouts.auth')

@section('title', 'Nouveau mot de passe')

@section('panel-badge') Sécurité @endsection
@section('panel-title') Définissez votre <em>nouveau</em> mot de passe @endsection
@section('panel-desc')
    Choisissez un mot de passe sécurisé pour protéger votre compte AGesp.
    Minimum 8 caractères, incluez lettres, chiffres et symboles.
@endsection
@section('panel-features')
    <div class="p-feat"><i class="bi bi-shield-check-fill"></i> Mot de passe chiffré et sécurisé</div>
    <div class="p-feat"><i class="bi bi-key-fill"></i> Minimum 8 caractères requis</div>
    <div class="p-feat"><i class="bi bi-lock-fill"></i> Connexion sécurisée après réinitialisation</div>
@endsection

@section('form')

<div class="f-eyebrow">Réinitialisation</div>
<h1 class="f-title">Nouveau mot de passe</h1>
<p class="f-sub">Entrez et confirmez votre nouveau mot de passe ci-dessous.</p>

@if ($errors->any())
    <div class="alert alert-err">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}">
    @csrf
    <input type="hidden" name="token" value="{{ request()->route('token') }}">

    <div class="fg">
        <label>E-mail <span class="req">*</span></label>
        <div class="inp-wrap">
            <i class="bi bi-envelope inp-ico"></i>
            <input type="email" name="email"
                   class="inp @error('email') is-invalid @enderror"
                   value="{{ request('email') }}"
                   required autocomplete="email">
        </div>
        @error('email')<span class="invalid-msg">{{ $message }}</span>@enderror
    </div>

    <div class="fg">
        <label>Nouveau mot de passe <span class="req">*</span></label>
        <div class="inp-wrap">
            <i class="bi bi-lock inp-ico"></i>
            <input type="password" name="password" id="rpwd"
                   class="inp @error('password') is-invalid @enderror"
                   placeholder="Minimum 8 caractères"
                   required autocomplete="new-password"
                   oninput="pwdStr(this.value)">
            <button type="button" class="inp-eye" onclick="tgl('rpwd','reye1')" tabindex="-1">
                <i class="bi bi-eye" id="reye1"></i>
            </button>
        </div>
        <div class="pwd-bar-wrap" id="rpwd-bar" style="display:none;">
            <div class="pwd-bar"><div class="pwd-fill" id="rpwd-fill"></div></div>
            <span class="pwd-text" id="rpwd-text"></span>
        </div>
        @error('password')<span class="invalid-msg">{{ $message }}</span>@enderror
    </div>

    <div class="fg">
        <label>Confirmer le mot de passe <span class="req">*</span></label>
        <div class="inp-wrap">
            <i class="bi bi-lock inp-ico"></i>
            <input type="password" name="password_confirmation" id="rpwd2"
                   class="inp"
                   placeholder="Répéter le mot de passe"
                   required autocomplete="new-password">
            <button type="button" class="inp-eye" onclick="tgl('rpwd2','reye2')" tabindex="-1">
                <i class="bi bi-eye" id="reye2"></i>
            </button>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle"></i> Réinitialiser le mot de passe
    </button>
</form>

<div class="f-link-row" style="margin-top:14px;">
    <a href="{{ route('login') }}"><i class="bi bi-arrow-left"></i> Retour à la connexion</a>
</div>

@endsection

@push('scripts')
<script>
function tgl(id, ico) {
    const f = document.getElementById(id), i = document.getElementById(ico);
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
function pwdStr(v) {
    const bar = document.getElementById('rpwd-bar');
    if (!v) { bar.style.display='none'; return; }
    bar.style.display = 'block';
    let s = 0;
    if (v.length>=8) s++; if(/[A-Z]/.test(v)) s++; if(/[0-9]/.test(v)) s++; if(/[^A-Za-z0-9]/.test(v)) s++;
    const lvls = [{p:'25%',c:'#c0281e',t:'Très faible'},{p:'50%',c:'#d4a017',t:'Faible'},{p:'75%',c:'#00A572',t:'Moyen'},{p:'100%',c:'#1a6b3a',t:'Fort'}];
    const l = lvls[s-1]||lvls[0];
    document.getElementById('rpwd-fill').style.cssText=`width:${l.p};background:${l.c}`;
    const tx = document.getElementById('rpwd-text');
    tx.textContent='Force : '+l.t; tx.style.color=l.c;
}
</script>
@endpush
