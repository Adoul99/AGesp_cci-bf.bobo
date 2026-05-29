{{-- ════════════════════════════════════════════════════════
     verify-email.blade.php
     Remplace : resources/views/auth/verify-email.blade.php
════════════════════════════════════════════════════════ --}}
@extends('layouts.auth')

@section('title', 'Vérification e-mail')

@section('panel-badge') Vérification @endsection
@section('panel-title') Vérifiez votre <em>adresse e-mail</em> @endsection
@section('panel-desc')
    Un lien de vérification a été envoyé à votre adresse e-mail.
    Cliquez sur ce lien pour activer votre compte AGesp.
@endsection
@section('panel-features')
    <div class="p-feat"><i class="bi bi-envelope-check-fill"></i> Vérifiez votre boîte de réception</div>
    <div class="p-feat"><i class="bi bi-folder2"></i> Vérifiez aussi vos spams</div>
    <div class="p-feat"><i class="bi bi-arrow-clockwise"></i> Renvoi disponible si besoin</div>
    <div class="p-feat"><i class="bi bi-shield-fill-check"></i> Étape nécessaire pour sécuriser votre compte</div>
@endsection

@section('form')

<div style="text-align:center;margin-bottom:22px;">
    <div style="width:68px;height:68px;background:linear-gradient(135deg,var(--v),var(--vc));border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;box-shadow:0 6px 20px rgba(26,107,58,.25);">
        <i class="bi bi-envelope-fill" style="font-size:1.8rem;color:white;"></i>
    </div>
    <div class="f-eyebrow" style="justify-content:center;">Vérification du compte</div>
    <h1 class="f-title" style="font-size:1.5rem;">Vérifiez votre e-mail</h1>
</div>

<p class="f-sub" style="text-align:center;margin-bottom:18px;">
    Nous avons envoyé un lien de vérification à votre adresse e-mail.
    Cliquez dessus pour activer votre compte.
</p>

@if (session('status') == 'verification-link-sent')
    <div class="alert alert-ok">
        <i class="bi bi-check-circle-fill"></i>
        <span>Un nouveau lien de vérification a été envoyé à votre adresse e-mail.</span>
    </div>
@endif

<form method="POST" action="{{ route('verification.send') }}" style="margin-bottom:10px;">
    @csrf
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-send-fill"></i> Renvoyer le lien de vérification
    </button>
</form>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-ghost" data-test="logout-button">
        <i class="bi bi-box-arrow-right"></i> Se déconnecter
    </button>
</form>

@endsection
