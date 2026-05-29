@extends('layouts.auth')

@section('title', 'Créer un compte')

@section('form')
{{-- Définition du style local pour ne pas interférer avec le layout --}}
<style>
    .f-title { font-size: 1.5rem; font-weight: 800; color: var(--dk); margin-bottom: 20px; }
    .fg { margin-bottom: 15px; }
    .fg label { display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 5px; }
    .req { color: var(--r); }
    .inp { width: 100%; padding: 12px; border: 1px solid var(--brd); border-radius: 8px; }
    .btn-primary { width: 100%; padding: 12px; background: var(--v); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: 700; }
    .btn-primary:hover { background: var(--vc); }
</style>

{{-- ÉTAPE 1 — Informations --}}
<div id="reg-step1">
    <h1 class="f-title">Créer un compte</h1>
    
    <div id="js-err" class="alert alert-err" style="display:none; color:red; margin-bottom:10px;">
        <span id="js-err-msg"></span>
    </div>

    <div class="fg">
        <label>Nom <span class="req">*</span></label>
        <input type="text" id="r-nom" class="inp" value="{{ old('name','') }}">
    </div>
    <div class="fg">
        <label>Prénom(s) <span class="req">*</span></label>
        <input type="text" id="r-prenom" class="inp" value="{{ old('prenom','') }}">
    </div>
    <div class="fg">
        <label>Email <span class="req">*</span></label>
        <input type="email" id="r-email" class="inp" value="{{ old('email','') }}">
    </div>
    <div class="fg">
        <label>Mot de passe <span class="req">*</span></label>
        <input type="password" id="r-pwd" class="inp">
    </div>
    <div class="fg">
        <label>Confirmer <span class="req">*</span></label>
        <input type="password" id="r-pwd2" class="inp">
    </div>

    {{-- Bouton corrigé --}}
    <button type="button" class="btn-primary" onclick="toStep2()">
        Suivant — Vérifier mon e-mail
    </button>
</div>

{{-- ÉTAPE 2 — Vérification E-mail --}}
<div id="reg-step2" style="display:none;">
    <h1 class="f-title">Vérification E-mail</h1>
    <p style="margin-bottom:15px;">Un code a été envoyé à <strong id="mail-addr"></strong>.</p>
    <div class="fg">
        <input type="text" id="otp-input" class="inp" placeholder="Saisir le code à 6 chiffres" maxlength="6">
    </div>
    <button type="button" class="btn-primary" onclick="verifyOtp()">Vérifier</button>
</div>

{{-- ÉTAPE 3 — Succès --}}
<div id="reg-step3" style="display:none;">
    <h1 class="f-title">Compte créé !</h1>
    <form method="POST" action="{{ route('register') }}" id="final-form">
        @csrf
        <input type="hidden" name="name" id="h-name">
        <input type="hidden" name="prenom" id="h-prenom">
        <input type="hidden" name="email" id="h-email">
        <input type="hidden" name="password" id="h-pwd">
        <input type="hidden" name="password_confirmation" id="h-pwd2">
        <button type="submit" class="btn-primary">Terminer l'inscription</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function hide(id) { document.getElementById(id).style.display = 'none'; }
    function show(id) { document.getElementById(id).style.display = 'block'; }
    
    function toStep2() {
        const email = document.getElementById('r-email').value;
        const nom = document.getElementById('r-nom').value;
        
        if (!nom || !email) {
            alert('Veuillez remplir les champs obligatoires.');
            return;
        }
        
        document.getElementById('mail-addr').textContent = email;
        hide('reg-step1');
        show('reg-step2');
    }

    function verifyOtp() {
        document.getElementById('h-name').value = document.getElementById('r-nom').value;
        document.getElementById('h-prenom').value = document.getElementById('r-prenom').value;
        document.getElementById('h-email').value = document.getElementById('r-email').value;
        document.getElementById('h-pwd').value = document.getElementById('r-pwd').value;
        document.getElementById('h-pwd2').value = document.getElementById('r-pwd2').value;
        
        hide('reg-step2');
        show('reg-step3');
    }
</script>
@endpush