<x-layouts::app :title="__('Créer un utilisateur')">

<style>
:root { --v:#1a6b3a; --vc:#22883f; --vp:#e8f2ec; --r:#c0281e; --rp:#fbeaea; --o:#d4a017; --dk:#1a2520; --sub:#6b7a70; --brd:#dde5e0; }
.ug-wrap { padding:14px 18px; font-family:'Source Sans 3',sans-serif; }
.page-header { display:flex; align-items:center; gap:12px; margin-bottom:18px; }
.page-title { font-family:'Nunito',sans-serif; font-weight:800; font-size:1rem; color:var(--dk); }
.btn-back { display:inline-flex; align-items:center; gap:6px; background:#f1f5f9; color:var(--sub); padding:7px 13px; border-radius:7px; font-family:'Nunito',sans-serif; font-weight:700; font-size:.78rem; text-decoration:none; border:1.5px solid var(--brd); }
.btn-back:hover { background:#e2e8f0; color:var(--dk); }

.form-card { background:white; border-radius:10px; box-shadow:0 2px 10px rgba(26,107,58,.08); overflow:hidden; max-width:680px; }
.form-head { background:linear-gradient(135deg,var(--v),var(--vc)); color:white; padding:14px 20px; font-family:'Nunito',sans-serif; font-weight:700; font-size:.92rem; display:flex; align-items:center; gap:9px; border-bottom:3px solid var(--o); }
.form-body { padding:24px; }

.alert-err { background:var(--rp); color:var(--r); border-left:4px solid var(--r); border-radius:7px; padding:9px 13px; font-size:.78rem; margin-bottom:14px; }
.alert-err ul { margin:5px 0 0 16px; }

.section-title { font-family:'Nunito',sans-serif; font-weight:800; font-size:.72rem; color:var(--dk); text-transform:uppercase; letter-spacing:.08em; margin-bottom:12px; margin-top:20px; padding-bottom:7px; border-bottom:2px solid var(--o); display:flex; align-items:center; gap:6px; }
.section-title:first-of-type { margin-top:0; }
.section-title i { color:var(--v); }

.fg { margin-bottom:12px; }
.fg label { display:flex; align-items:center; gap:4px; font-family:'Nunito',sans-serif; font-weight:700; font-size:.7rem; color:var(--dk); margin-bottom:5px; text-transform:uppercase; letter-spacing:.04em; }
.fg label .req { color:var(--r); }
.inp { width:100%; border:1.5px solid var(--brd); border-radius:7px; padding:9px 11px; font-size:.84rem; background:#f9fbfa; color:var(--dk); transition:all .18s; outline:none; font-family:'Source Sans 3',sans-serif; }
.inp:focus { border-color:var(--v); box-shadow:0 0 0 3px rgba(26,107,58,.1); background:white; }
.inp.is-invalid { border-color:var(--r); }
.invalid-msg { font-size:.68rem; color:var(--r); margin-top:3px; display:block; }

.phone-wrap { display:flex; }
.phone-prefix { padding:9px 11px; background:var(--v); color:var(--o); border-radius:7px 0 0 7px; font-family:'Nunito',sans-serif; font-weight:700; font-size:.82rem; border:1.5px solid var(--v); white-space:nowrap; display:flex; align-items:center; flex-shrink:0; }
.phone-wrap .inp { border-radius:0 7px 7px 0; border-left:none; }

.role-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:10px; }
.role-option { border:2px solid var(--brd); border-radius:9px; padding:13px 10px; text-align:center; cursor:pointer; transition:all .2s; position:relative; }
.role-option input[type="radio"] { position:absolute; opacity:0; }
.role-option:has(input:checked) { border-color:var(--v); background:var(--vp); }
.role-icon { font-size:1.5rem; display:block; margin-bottom:5px; }
.role-name { font-family:'Nunito',sans-serif; font-weight:800; font-size:.8rem; color:var(--dk); display:block; }
.role-desc { font-size:.66rem; color:var(--sub); display:block; margin-top:2px; }

.pwd-wrap { position:relative; }
.pwd-wrap .inp { padding-right:38px; }
.pwd-eye { position:absolute; right:10px; top:50%; transform:translateY(-50%); background:none; border:none; color:var(--sub); cursor:pointer; font-size:.88rem; padding:0; }
.pwd-eye:hover { color:var(--v); }

.btn-wrap { display:flex; gap:10px; margin-top:20px; padding-top:16px; border-top:1px solid var(--brd); }
.btn-submit { background:linear-gradient(135deg,var(--v),var(--vc)); color:white; border:none; border-radius:7px; padding:10px 22px; font-family:'Nunito',sans-serif; font-weight:700; font-size:.82rem; cursor:pointer; display:flex; align-items:center; gap:7px; transition:all .2s; margin-left:auto; }
.btn-submit:hover { transform:translateY(-1px); box-shadow:0 5px 14px rgba(26,107,58,.3); }
.btn-cancel { background:#f1f5f9; color:var(--sub); border:1.5px solid var(--brd); border-radius:7px; padding:10px 18px; font-family:'Nunito',sans-serif; font-weight:700; font-size:.82rem; cursor:pointer; text-decoration:none; display:flex; align-items:center; gap:6px; }
.btn-cancel:hover { background:#e2e8f0; color:var(--dk); }
.grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
</style>

<div class="ug-wrap">

    <div class="page-header">
        <a href="{{ route('users.index') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Retour
        </a>
        <div class="page-title">Créer un utilisateur</div>
    </div>

    <div class="form-card">
        <div class="form-head">
            <i class="bi bi-person-plus-fill"></i> Nouvel utilisateur
        </div>
        <div class="form-body">

            @if($errors->any())
                <div class="alert-err">
                    <i class="bi bi-exclamation-triangle-fill"></i> <strong>Erreurs :</strong>
                    <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif

            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <div class="section-title"><i class="bi bi-person"></i> Identité</div>
                <div class="grid-2">
                    <div class="fg" style="margin-bottom:0;">
                        <label>Nom <span class="req">*</span></label>
                        <input type="text" name="name" class="inp @error('name') is-invalid @enderror"
                               placeholder="Nom de famille" value="{{ old('name') }}" required>
                        @error('name')<span class="invalid-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="fg" style="margin-bottom:0;">
                        <label>Prénom(s) <span class="req">*</span></label>
                        <input type="text" name="prenom" class="inp @error('prenom') is-invalid @enderror"
                               placeholder="Prénom" value="{{ old('prenom') }}" required>
                        @error('prenom')<span class="invalid-msg">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="section-title" style="margin-top:16px;"><i class="bi bi-telephone"></i> Contact</div>
                <div class="grid-2">
                    <div class="fg" style="margin-bottom:0;">
                        <label>Email <span class="req">*</span></label>
                        <input type="email" name="email" class="inp @error('email') is-invalid @enderror"
                               placeholder="votre@email.com" value="{{ old('email') }}" required>
                        @error('email')<span class="invalid-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="fg" style="margin-bottom:0;">
                        <label>Téléphone</label>
                        <div class="phone-wrap">
                            <div class="phone-prefix">+226</div>
                            <input type="tel" name="telephone" class="inp @error('telephone') is-invalid @enderror"
                                   placeholder="XX XX XX XX" maxlength="8" value="{{ old('telephone') }}"
                                   oninput="this.value=this.value.replace(/\D/g,'')">
                        </div>
                        @error('telephone')<span class="invalid-msg">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="section-title" style="margin-top:16px;"><i class="bi bi-shield-check"></i> Rôle <span class="req">*</span></div>
                <div class="role-grid">
                    <label class="role-option">
                        <input type="radio" name="role" value="admin" {{ old('role')==='admin' ? 'checked' : '' }}>
                        <span class="role-icon">🛡️</span>
                        <span class="role-name">Administrateur</span>
                        <span class="role-desc">Accès complet au dashboard</span>
                    </label>
                    <label class="role-option">
                        <input type="radio" name="role" value="moniteur" {{ old('role')==='moniteur' ? 'checked' : '' }}>
                        <span class="role-icon">🚗</span>
                        <span class="role-name">Moniteur</span>
                        <span class="role-desc">Gestion formations & candidats</span>
                    </label>
                    <label class="role-option">
                        <input type="radio" name="role" value="superviseur" {{ old('role')==='superviseur' ? 'checked' : '' }}>
                        <span class="role-icon">🧭</span>
                        <span class="role-name">Superviseur</span>
                        <span class="role-desc">Candidats, inscriptions & groupes</span>
                    </label>
                    <label class="role-option">
                        <input type="radio" name="role" value="candidat" {{ old('role')==='candidat' ? 'checked' : '' }}>
                        <span class="role-icon">👤</span>
                        <span class="role-name">Candidat</span>
                        <span class="role-desc">Espace personnel uniquement</span>
                    </label>
                </div>
                @error('role')<span class="invalid-msg">{{ $message }}</span>@enderror

                <div class="section-title" style="margin-top:16px;"><i class="bi bi-lock"></i> Mot de passe</div>
                <div class="grid-2">
                    <div class="fg" style="margin-bottom:0;">
                        <label>Mot de passe <span class="req">*</span></label>
                        <div class="pwd-wrap">
                            <input type="password" name="password" id="pwd"
                                   class="inp @error('password') is-invalid @enderror"
                                   placeholder="Minimum 8 caractères" required>
                            <button type="button" class="pwd-eye" onclick="tgl('pwd','eye1')" tabindex="-1">
                                <i class="bi bi-eye" id="eye1"></i>
                            </button>
                        </div>
                        @error('password')<span class="invalid-msg">{{ $message }}</span>@enderror
                    </div>
                    <div class="fg" style="margin-bottom:0;">
                        <label>Confirmer <span class="req">*</span></label>
                        <div class="pwd-wrap">
                            <input type="password" name="password_confirmation" id="pwd2"
                                   class="inp" placeholder="Répéter le mot de passe" required>
                            <button type="button" class="pwd-eye" onclick="tgl('pwd2','eye2')" tabindex="-1">
                                <i class="bi bi-eye" id="eye2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="btn-wrap">
                    <a href="{{ route('users.index') }}" class="btn-cancel">
                        <i class="bi bi-x-circle"></i> Annuler
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-person-plus-fill"></i> Créer l'utilisateur
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function tgl(id, ico) {
    const f = document.getElementById(id), i = document.getElementById(ico);
    f.type = f.type === 'password' ? 'text' : 'password';
    i.className = f.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}
</script>

</x-layouts::app>
