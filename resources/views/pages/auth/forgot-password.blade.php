{{-- ════════════════════════════════════════════════════════
     forgot-password.blade.php
     Remplace : resources/views/auth/forgot-password.blade.php
════════════════════════════════════════════════════════ --}}
@extends('layouts.auth')

@section('title', 'Mot de passe oublié')

@section('panel-badge') Récupération @endsection
@section('panel-title') Réinitialisez votre <em>mot de passe</em> @endsection
@section('panel-desc')
    Entrez votre adresse e-mail et nous vous enverrons un lien pour
    réinitialiser votre mot de passe en toute sécurité.
@endsection
@section('panel-features')
    <div class="p-feat"><i class="bi bi-envelope-fill"></i> Lien envoyé par e-mail</div>
    <div class="p-feat"><i class="bi bi-shield-lock-fill"></i> Lien sécurisé et temporaire</div>
    <div class="p-feat"><i class="bi bi-clock-fill"></i> Valable 60 minutes</div>
    <div class="p-feat"><i class="bi bi-arrow-left-circle-fill"></i> Retour rapide à la connexion</div>
@endsection

@section('form')

<div class="f-eyebrow">Mot de passe oublié</div>
<h1 class="f-title">Réinitialisation</h1>
<p class="f-sub">Entrez votre e-mail pour recevoir un lien de réinitialisation.</p>

@if (session('status'))
    <div class="alert alert-ok">
        <i class="bi bi-check-circle-fill"></i>
        <span>{{ session('status') }}</span>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-err">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span>{{ $errors->first() }}</span>
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="fg">
        <label><i class="bi bi-envelope" style="color:var(--v);margin-right:4px;"></i>Adresse e-mail <span class="req">*</span></label>
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

    <button type="submit" class="btn btn-primary" style="margin-bottom:12px;">
        <i class="bi bi-send-fill"></i> Envoyer le lien de réinitialisation
    </button>
</form>

<div class="f-link-row">
    <a href="{{ route('login') }}"><i class="bi bi-arrow-left"></i> Retour à la connexion</a>
</div>

@endsection
