<x-guest-layout>
<style>
  .reg-wrap{min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px;
    background:#0A1730;}
  .reg-card{width:100%; max-width:420px; background:#fff; border-radius:26px; box-shadow:0 30px 70px rgba(2,50,80,.35); padding:32px 30px; position:relative;}
  .reg-icon{width:52px; height:52px; border-radius:50%; margin:0 auto 14px; background:#0EA5E9; display:flex; align-items:center; justify-content:center; color:#fff; box-shadow:0 8px 20px rgba(14,165,233,.4);}
  .reg-card h1{font-size:19px; font-weight:700; text-align:center; color:#0F172A; margin-bottom:3px;}
  .reg-card p.sub{color:#64748B; font-weight:500; font-size:12.5px; text-align:center; margin-bottom:22px;}
  .reg-field{margin-bottom:14px; text-align:left;}
  .reg-field label{display:block; font-size:12px; font-weight:700; margin-bottom:6px; color:#334155;}
  .reg-input-wrap{position:relative;}
  .reg-input-wrap input, .reg-input-wrap select{width:100%; padding:10px 38px 10px 38px; border-radius:12px; border:1.5px solid #CBD5E1; background:#F8FAFC; font-family:inherit; font-size:13.5px; outline:none; transition:border-color .2s;}
  .reg-input-wrap input:focus{border-color:#0EA5E9; box-shadow:0 0 0 3px rgba(14,165,233,.15);}
  .reg-input-wrap .field-ico-left{position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#94A3B8; width:16px; height:16px;}
  .reg-input-wrap .field-ico-right{position:absolute; right:12px; top:50%; transform:translateY(-50%); color:#94A3B8; width:16px; height:16px; cursor:pointer;}
  .reg-error{color:#DC2626; font-size:11.5px; margin-top:4px;}
  .role-grid{display:grid; grid-template-columns:1fr 1fr; gap:10px; margin-top:6px;}
  .role-option{cursor:pointer;}
  .role-option input{position:absolute; opacity:0; pointer-events:none;}
  .role-box{border:1.5px solid #E2E8F0; border-radius:14px; padding:12px; text-align:center; transition:all .2s;}
  .role-box .role-ico{width:30px; height:30px; border-radius:9px; margin:0 auto 6px; display:flex; align-items:center; justify-content:center; background:#F1F5F9; color:#475569;}
  .role-box b{display:block; font-size:12.5px; color:#0F172A;}
  .role-box span{display:block; font-size:10.5px; color:#94A3B8; margin-top:1px;}
  .role-option input:checked + .role-box{border-color:#0EA5E9; background:#E6F6FE;}
  .role-option input:checked + .role-box .role-ico{background:#0EA5E9; color:#fff;}
  .btn-reg-submit{width:100%; background:linear-gradient(135deg,#0EA5E9,#0284C7); color:#fff; font-weight:700; font-size:14px; padding:13px; border-radius:12px; margin-top:18px; border:none; cursor:pointer; box-shadow:0 8px 20px rgba(14,165,233,.35);}
  .btn-reg-submit:hover{opacity:.94;}
  .reg-footer{text-align:center; font-size:12.5px; color:#64748B; margin-top:16px;}
  .reg-footer a{color:#0284C7; font-weight:600;}
</style>

<div class="reg-wrap">
  <div class="reg-card">
    <div class="reg-icon"><i data-lucide="user-plus" style="width:22px;height:22px;"></i></div>
    <h1>Créer votre compte</h1>
    <p class="sub">Rejoignez NAJA7HOST et simplifiez la gestion des congés</p>

    <form method="POST" action="{{ route('register') }}" autocomplete="off">
        @csrf

        {{-- Nom --}}
        <div class="reg-field">
            <label for="name">Nom complet</label>
            <div class="reg-input-wrap">
                <i data-lucide="user" class="field-ico-left"></i>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="off" placeholder="Entrez votre nom complet">
            </div>
            @error('name') <div class="reg-error">{{ $message }}</div> @enderror
        </div>

        {{-- Email --}}
        <div class="reg-field">
            <label for="email">Email professionnel</label>
            <div class="reg-input-wrap">
                <i data-lucide="mail" class="field-ico-left"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="off" placeholder="Entrez votre email professionnel">
            </div>
            @error('email') <div class="reg-error">{{ $message }}</div> @enderror
        </div>

        {{-- Mot de passe --}}
        <div class="reg-field">
            <label for="password">Mot de passe</label>
            <div class="reg-input-wrap">
                <i data-lucide="lock" class="field-ico-left"></i>
                <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Créez un mot de passe">
                <i data-lucide="eye" class="field-ico-right toggle-pwd" data-target="password"></i>
            </div>
            @error('password') <div class="reg-error">{{ $message }}</div> @enderror
        </div>

        {{-- Confirmation --}}
        <div class="reg-field">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <div class="reg-input-wrap">
                <i data-lucide="lock" class="field-ico-left"></i>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmez votre mot de passe">
                <i data-lucide="eye" class="field-ico-right toggle-pwd" data-target="password_confirmation"></i>
            </div>
            @error('password_confirmation') <div class="reg-error">{{ $message }}</div> @enderror
        </div>

        {{-- Rôle --}}
        <div class="reg-field">
            <label>Vous êtes</label>
            <div class="role-grid">
                <label class="role-option">
                    <input type="radio" name="role" value="employe" {{ old('role', 'employe') === 'employe' ? 'checked' : '' }}>
                    <div class="role-box">
                        <span class="role-ico"><i data-lucide="user" style="width:15px;height:15px;"></i></span>
                        <b>Employé</b>
                        <span>Je demande des congés</span>
                    </div>
                </label>
                <label class="role-option">
                    <input type="radio" name="role" value="rh" {{ old('role') === 'rh' ? 'checked' : '' }}>
                    <div class="role-box">
                        <span class="role-ico"><i data-lucide="user-check" style="width:15px;height:15px;"></i></span>
                        <b>Responsable RH</b>
                        <span>Je valide les congés</span>
                    </div>
                </label>
            </div>
            @error('role') <div class="reg-error">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn-reg-submit">S'inscrire</button>

        <p class="reg-footer">
            Vous avez déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
        </p>
    </form>
  </div>
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
  lucide.createIcons();
  document.querySelectorAll('.toggle-pwd').forEach(icon => {
    icon.addEventListener('click', () => {
      const input = document.getElementById(icon.dataset.target);
      input.type = input.type === 'text' ? 'password' : 'text';
    });
  });
</script>
</x-guest-layout>