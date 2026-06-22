@extends('layouts.auth')

@section('title', 'Créer un compte')

@section('form')
<style>
    /* STEPPER — Indicateur d'étapes */
    .reg-stepper {
        display: flex;
        justify-content: space-between;
        margin-bottom: 2rem;
        gap: 1rem;
    }
    .reg-step-dot {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
        background: #e0e0e0;
        color: #666;
        transition: all 0.3s ease;
    }
    .reg-step-dot.active {
        background: linear-gradient(135deg, #1a6b3a, #22883f);
        color: white;
        box-shadow: 0 4px 12px rgba(26, 107, 58, 0.3);
    }
    .reg-step-dot.completed {
        background: #4caf50;
        color: white;
    }
    
    /* FORM CONTAINER */
    .reg-form-container {
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* HEADER */
    .reg-header {
        margin-bottom: 1.5rem;
        text-align: center;
    }
    .reg-header h1 {
        font-size: 28px;
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.5rem;
    }
    .reg-header p {
        font-size: 14px;
        color: #666;
    }
    
    /* ALERTS */
    .reg-alert {
        padding: 12px 16px;
        border-radius: 8px;
        margin-bottom: 1.5rem;
        font-size: 14px;
        display: none;
    }
    .reg-alert.error {
        background: #fee;
        border: 1px solid #fcc;
        color: #c33;
        display: block;
    }
    .reg-alert.success {
        background: #efe;
        border: 1px solid #cfc;
        color: #3c3;
        display: block;
    }
    
    /* FORM GROUPS */
    .reg-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }
    .reg-form-row.full {
        grid-template-columns: 1fr;
    }
    .reg-form-group {
        display: flex;
        flex-direction: column;
    }
    .reg-form-group label {
        font-size: 13px;
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
    }
    .reg-form-group label .req {
        color: #e74c3c;
    }
    .reg-form-group input {
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
        font-family: inherit;
        transition: all 0.3s ease;
    }
    .reg-form-group input:focus {
        outline: none;
        border-color: #1a6b3a;
        box-shadow: 0 0 0 3px rgba(26, 107, 58, 0.1);
    }
    .reg-form-group input.error {
        border-color: #e74c3c;
    }
    
    /* OTP INPUT */
    .reg-otp-input {
        font-size: 24px;
        letter-spacing: 8px;
        text-align: center;
        font-weight: 600;
        padding: 12px !important;
        tracking: 4px;
    }
    
    /* BUTTONS */
    .reg-button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }
    .reg-btn {
        flex: 1;
        padding: 12px 20px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .reg-btn-primary {
        background: linear-gradient(135deg, #1a6b3a, #22883f);
        color: white;
    }
    .reg-btn-primary:hover {
        box-shadow: 0 6px 20px rgba(26, 107, 58, 0.3);
        transform: translateY(-2px);
    }
    .reg-btn-primary:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .reg-btn-secondary {
        background: #f0f0f0;
        color: #333;
        border: 1px solid #ddd;
    }
    .reg-btn-secondary:hover {
        background: #e8e8e8;
    }
    
    /* SUCCESS MESSAGE */
    .reg-success {
        text-align: center;
        padding: 2rem;
        background: linear-gradient(135deg, rgba(76, 175, 80, 0.1), rgba(26, 107, 58, 0.1));
        border-radius: 12px;
        margin-bottom: 1.5rem;
    }
    .reg-success-icon {
        font-size: 48px;
        margin-bottom: 1rem;
    }
    .reg-success h2 {
        color: #1a6b3a;
        margin-bottom: 0.5rem;
    }
    .reg-success p {
        color: #666;
        font-size: 14px;
    }
</style>

{{-- STEPPER --}}
<div class="reg-stepper">
    <div class="reg-step-dot active" id="dot-1">1</div>
    <div class="reg-step-dot" id="dot-2">2</div>
    <div class="reg-step-dot" id="dot-3">3</div>
</div>

{{-- ÉTAPE 1 — Informations --}}
<div id="reg-step1" class="reg-form-container">
    <div class="reg-header">
        <h1>Créer votre compte</h1>
        <p>Rejoignez AGesp pour commencer votre formation de conducteur</p>
    </div>
    
    <div id="js-err" class="reg-alert error">
        <span id="js-err-msg"></span>
    </div>

    <div class="reg-form-row">
        <div class="reg-form-group">
            <label>Nom de famille <span class="req">*</span></label>
            <input type="text" id="r-nom" value="{{ old('name','') }}" placeholder="Ex: Dupont">
        </div>
        <div class="reg-form-group">
            <label>Prénom(s) <span class="req">*</span></label>
            <input type="text" id="r-prenom" value="{{ old('prenom','') }}" placeholder="Ex: Jean">
        </div>
    </div>

    <div class="reg-form-row full">
        <div class="reg-form-group">
            <label>Adresse Email <span class="req">*</span></label>
            <input type="email" id="r-email" value="{{ old('email','') }}" placeholder="votremail@exemple.com">
        </div>
    </div>

    <div class="reg-form-row">
        <div class="reg-form-group">
            <label>Mot de passe <span class="req">*</span></label>
            <input type="password" id="r-pwd" placeholder="Min. 8 caractères">
        </div>
        <div class="reg-form-group">
            <label>Confirmer le mot de passe <span class="req">*</span></label>
            <input type="password" id="r-pwd2" placeholder="Répéter le mot de passe">
        </div>
    </div>

    <div class="reg-button-group">
        <button type="button" class="reg-btn reg-btn-primary" onclick="toStep2()">
            Suivant →
        </button>
    </div>
</div>

{{-- ÉTAPE 2 — Vérification E-mail --}}
<div id="reg-step2" style="display:none;" class="reg-form-container">
    <div class="reg-header">
        <h1>Vérifier votre email</h1>
        <p>Nous avons envoyé un code de confirmation</p>
    </div>
    
    <div class="reg-form-row full">
        <p style="text-align: center; color: #666; font-size: 14px; margin-bottom: 1.5rem;">
            Un code à 6 chiffres a été envoyé à <strong id="mail-addr"></strong>
        </p>
        <div class="reg-form-group">
            <label>Code de vérification <span class="req">*</span></label>
            <input type="text" id="otp-input" class="reg-otp-input" placeholder="000000" maxlength="6" inputmode="numeric">
        </div>
    </div>

    <div class="reg-button-group">
        <button type="button" class="reg-btn reg-btn-secondary" onclick="backToStep1()">← Retour</button>
        <button type="button" class="reg-btn reg-btn-primary" onclick="verifyOtp()">Vérifier</button>
    </div>
</div>

{{-- ÉTAPE 3 — Succès --}}
<div id="reg-step3" style="display:none;" class="reg-form-container">
    <div class="reg-success">
        <div class="reg-success-icon">✓</div>
        <h2>Compte créé avec succès !</h2>
        <p>Bienvenue sur AGesp</p>
    </div>

    <form method="POST" action="{{ route('register') }}" id="final-form">
        @csrf
        <input type="hidden" name="name" id="h-name">
        <input type="hidden" name="prenom" id="h-prenom">
        <input type="hidden" name="email" id="h-email">
        <input type="hidden" name="password" id="h-pwd">
        <input type="hidden" name="password_confirmation" id="h-pwd2">
        
        <div class="reg-button-group">
            <button type="submit" class="reg-btn reg-btn-primary">
                Accéder à mon tableau de bord →
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    // Fonctions utilitaires
    function hide(id) { document.getElementById(id).style.display = 'none'; }
    function show(id) { document.getElementById(id).style.display = 'block'; }
    function setDot(step, state) {
        const dot = document.getElementById(`dot-${step}`);
        dot.classList.remove('active', 'completed');
        dot.classList.add(state);
    }
    
    // Afficher erreur
    function showError(msg) {
        const errDiv = document.getElementById('js-err');
        const errMsg = document.getElementById('js-err-msg');
        errMsg.textContent = msg;
        errDiv.style.display = 'block';
    }
    
    function hideError() {
        document.getElementById('js-err').style.display = 'none';
    }
    
    // Validation
    function validateStep1() {
        hideError();
        const nom = document.getElementById('r-nom').value.trim();
        const prenom = document.getElementById('r-prenom').value.trim();
        const email = document.getElementById('r-email').value.trim();
        const pwd = document.getElementById('r-pwd').value;
        const pwd2 = document.getElementById('r-pwd2').value;
        
        if (!nom) {
            showError('Veuillez entrer votre nom de famille');
            return false;
        }
        if (!prenom) {
            showError('Veuillez entrer votre prénom');
            return false;
        }
        if (!email) {
            showError('Veuillez entrer une adresse email');
            return false;
        }
        if (!email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
            showError('Veuillez entrer une adresse email valide');
            return false;
        }
        if (!pwd) {
            showError('Veuillez entrer un mot de passe');
            return false;
        }
        if (pwd.length < 8) {
            showError('Le mot de passe doit contenir au moins 8 caractères');
            return false;
        }
        if (pwd !== pwd2) {
            showError('Les mots de passe ne correspondent pas');
            return false;
        }
        return true;
    }
    
    function toStep2() {
        if (!validateStep1()) return;
        
        const email = document.getElementById('r-email').value;
        document.getElementById('mail-addr').textContent = email;
        
        setDot(1, 'completed');
        setDot(2, 'active');
        
        hide('reg-step1');
        show('reg-step2');
        
        // Auto-focus sur l'input OTP
        document.getElementById('otp-input').focus();
    }

    function backToStep1() {
        setDot(2, 'active');
        setDot(1, 'active');
        
        hide('reg-step2');
        show('reg-step1');
    }

    function verifyOtp() {
        const otp = document.getElementById('otp-input').value.trim();
        
        if (!otp) {
            alert('Veuillez entrer le code de vérification');
            return;
        }
        
        if (otp.length !== 6) {
            alert('Le code doit contenir 6 chiffres');
            return;
        }
        
        // Transfert des données vers le formulaire caché
        document.getElementById('h-name').value = document.getElementById('r-nom').value;
        document.getElementById('h-prenom').value = document.getElementById('r-prenom').value;
        document.getElementById('h-email').value = document.getElementById('r-email').value;
        document.getElementById('h-pwd').value = document.getElementById('r-pwd').value;
        document.getElementById('h-pwd2').value = document.getElementById('r-pwd2').value;
        
        setDot(2, 'completed');
        setDot(3, 'active');
        
        hide('reg-step2');
        show('reg-step3');
    }
    
    // Restriction d'entrée numérique pour OTP
    document.getElementById('otp-input')?.addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    });
</script>
@endpush