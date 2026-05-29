@extends('layouts.auth')

@section('title', 'Connexion')

{{-- ── Panneau gauche ── --}}
@section('panel-badge') Espace administrateur @endsection
@section('panel-title') Bienvenue sur votre <em>espace</em> AGesp @endsection
@section('panel-desc')
    Accédez à la gestion complète de l'Auto-École GESP —
    candidats, formations, examens et ressources en toute sécurité.
@endsection
@section('panel-features')
    <div class="p-feat"><i class="bi bi-people-fill"></i> Gestion des candidats et inscriptions</div>
    <div class="p-feat"><i class="bi bi-book-fill"></i> Suivi des formations et sessions</div>
    <div class="p-feat"><i class="bi bi-clipboard2-check-fill"></i> Résultats d'examens</div>
    <div class="p-feat"><i class="bi bi-credit-card-fill"></i> Paiements, reçus et attestations</div>
    <div class="p-feat"><i class="bi bi-lock-fill"></i> Tableau de bord sécurisé</div>
@endsection

{{-- ── Formulaire ── --}}
@section('form')

<div class="f-eyebrow">Accès sécurisé</div>
<h1 class="f-title">Connexion</h1>
<p class="f-sub">Entrez vos identifiants pour accéder à votre espace.</p>

@if ($errors->any())
    <div class="alert alert-err">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span>{{ $errors->first() }}</span>
    </div>
@endif

@if (session('status'))
    <div class="alert alert-ok">
        <i class="bi bi-check-circle-fill"></i>
        <span>{{ session('status') }}</span>
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    {{-- Email --}}
    <div class="fg">
        <label><i class="bi bi-envelope" style="color:var(--v);margin-right:4px;"></i>Email <span class="req">*</span></label>
        <div class="inp-wrap">
            <i class="bi bi-envelope inp-ico"></i>
            <input type="email" name="email"
                   class="inp @error('email') is-invalid @enderror"
                   value="{{ old('email') }}"
                   placeholder="votre@email.com"
                   required autofocus autocomplete="email">
        </div>
        @error('email')<span class="invalid-msg">{{ $message }}</span>@enderror
    </div>

    {{-- Mot de passe --}}
    <div class="fg">
        <label><i class="bi bi-lock" style="color:var(--v);margin-right:4px;"></i>Mot de passe <span class="req">*</span></label>
        <div class="inp-wrap">
            <i class="bi bi-lock inp-ico"></i>
            <input type="password" name="password" id="pwdLogin"
                   class="inp @error('password') is-invalid @enderror"
                   placeholder="••••••••"
                   required autocomplete="current-password">
            <button type="button" class="inp-eye" onclick="togglePwd('pwdLogin','eyeLogin')" tabindex="-1">
                <i class="bi bi-eye" id="eyeLogin"></i>
            </button>
        </div>
        @error('password')<span class="invalid-msg">{{ $message }}</span>@enderror
    </div>

    {{-- Remember + oublié --}}
    <div class="f-meta">
        <label class="remember-lbl">
            <input type="checkbox" name="remember"> Se souvenir de moi
        </label>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-lnk">Mot de passe oublié ?</a>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-box-arrow-in-right"></i> Se connecter
    </button>
</form>

<div class="sep"><hr> ou <hr></div>

<a href="{{ route('register') }}" class="btn btn-outline" style="text-decoration:none;">
    <i class="bi bi-person-plus"></i> Créer un compte candidat
</a>

@endsection

@push('scripts')
<script>
function togglePwd(inputId, iconId) {
    const f = document.getElementById(inputId);
    const i = document.getElementById(iconId);
    if (f.type === 'password') { f.type = 'text'; i.className = 'bi bi-eye-slash'; }
    else { f.type = 'password'; i.className = 'bi bi-eye'; }
}
</script>
@endpush
