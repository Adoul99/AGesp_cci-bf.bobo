{{-- ════════════════════════════════════════════════════════
     confirm-password.blade.php
     Remplace : resources/views/auth/confirm-password.blade.php
════════════════════════════════════════════════════════ --}}
@extends('layouts.auth')

@section('title', 'Confirmer le mot de passe')

@section('panel-badge') Zone sécurisée @endsection
@section('panel-title') Confirmez votre <em>identité</em> @endsection
@section('panel-desc')
    Cette zone est sécurisée. Veuillez confirmer votre mot de passe
    avant de continuer vers cette fonctionnalité sensible.
@endsection
@section('panel-features')
    <div class="p-feat"><i class="bi bi-shield-fill-check"></i> Zone à accès restreint</div>
    <div class="p-feat"><i class="bi bi-lock-fill"></i> Confirmation de sécurité requise</div>
    <div class="p-feat"><i class="bi bi-eye-slash-fill"></i> Votre session reste active</div>
@endsection

@section('form')

<div class="f-eyebrow">Zone sécurisée</div>
<h1 class="f-title">Confirmation requise</h1>
<p class="f-sub">Saisissez votre mot de passe pour accéder à cette zone protégée de l'application.</p>

@if ($errors->any())
    <div class="alert alert-err">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span>{{ $errors->first() }}</span>
    </div>
@endif

<form method="POST" action="{{ route('password.confirm.store') }}">
    @csrf

    <div class="fg">
        <label><i class="bi bi-lock" style="color:var(--v);margin-right:4px;"></i>Mot de passe <span class="req">*</span></label>
        <div class="inp-wrap">
            <i class="bi bi-lock inp-ico"></i>
            <input type="password" name="password" id="cpwd"
                   class="inp @error('password') is-invalid @enderror"
                   placeholder="Votre mot de passe actuel"
                   required autocomplete="current-password" autofocus>
            <button type="button" class="inp-eye" onclick="tgl()" tabindex="-1">
                <i class="bi bi-eye" id="ceye"></i>
            </button>
        </div>
        @error('password')<span class="invalid-msg">{{ $message }}</span>@enderror
    </div>

    <button type="submit" class="btn btn-primary" data-test="confirm-password-button">
        <i class="bi bi-shield-check"></i> Confirmer et continuer
    </button>
</form>

@endsection

@push('scripts')
<script>
function tgl() {
    const f = document.getElementById('cpwd'), i = document.getElementById('ceye');
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>
@endpush
