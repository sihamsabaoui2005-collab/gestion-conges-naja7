<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mon profil — NAJA7 HOST</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<style>
  :root{
    --navy:#0B1730; --navy-2:#111F3D;
    --blue:#3B82F6; --blue-light:#EFF4FF;
    --orange:#F59E0B; --green:#10B981; --red:#EF4444;
    --border:#E7EBF3; --text:#1E2A45; --text-dim:#8A93A6;
    --radius:18px;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  body{font-family:'Poppins',sans-serif; background:#F5F7FB; color:var(--text); -webkit-font-smoothing:antialiased;}
  a{text-decoration:none; color:inherit;}
  button{font-family:inherit; cursor:pointer; border:none; background:none; color:inherit;}

  .app{display:flex; min-height:100vh;}

  /* ===== SIDEBAR ===== */
  .sidebar{width:84px; flex:none; background:var(--navy); padding:22px 0; display:flex; flex-direction:column; align-items:center;}
  .side-logo{width:42px; height:42px; border-radius:13px; background:linear-gradient(135deg,#3B82F6,#8B5CF6); display:flex; align-items:center; justify-content:center; margin-bottom:28px; font-weight:700; color:#fff;}
  .side-nav{display:flex; flex-direction:column; gap:10px; flex:1;}
  .side-link{position:relative; width:46px; height:46px; border-radius:14px; display:flex; align-items:center; justify-content:center; color:#7E8BAE;}
  .side-link:hover{background:rgba(255,255,255,.06); color:#fff;}
  .side-link.active{background:var(--blue); color:#fff; box-shadow:0 0 0 4px rgba(59,130,246,.2);}
  .side-bottom{display:flex; flex-direction:column; gap:10px; padding-top:14px; border-top:1px solid rgba(255,255,255,.08); align-items:center;}

  /* ===== MAIN ===== */
  .main{flex:1; padding:26px 34px 50px; max-width:100%;}

  /* ===== TOPBAR ===== */
  .topbar{display:flex; align-items:center; justify-content:space-between; margin-bottom:26px;}
  .search{position:relative; width:340px;}
  .search input{width:100%; background:#fff; border:1px solid var(--border); border-radius:14px; padding:11px 16px 11px 40px; font-size:13.5px;}
  .search i{position:absolute; left:14px; top:50%; transform:translateY(-50%); width:16px; height:16px; color:var(--text-dim);}
  .top-right{display:flex; align-items:center; gap:16px;}
  .icon-btn{position:relative; width:40px; height:40px; border-radius:13px; background:#fff; border:1px solid var(--border); display:flex; align-items:center; justify-content:center; color:var(--text);}
  .icon-btn .dot{position:absolute; top:-3px; right:-3px; background:var(--red); color:#fff; font-size:9.5px; font-weight:700; width:17px; height:17px; border-radius:50%; display:flex; align-items:center; justify-content:center;}
  .user-chip{display:flex; align-items:center; gap:10px;}
  .avatar{width:40px; height:40px; border-radius:50%; background:var(--blue); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; color:#fff; overflow:hidden;}
  .avatar img{width:100%; height:100%; object-fit:cover;}
  .user-chip p{font-size:13.5px; font-weight:600;}
  .user-chip span{font-size:11.5px; color:var(--text-dim);}

  /* ===== HEADER PAGE ===== */
  .page-head{margin-bottom:22px;}
  .page-head h1{font-size:24px; font-weight:700;}
  .breadcrumb{font-size:12.5px; color:var(--text-dim); margin-top:4px;}
  .breadcrumb a{color:var(--blue); font-weight:600;}

  /* ===== LAYOUT ===== */
  .grid-profil{display:grid; grid-template-columns:320px 1fr; gap:20px; margin-bottom:20px;}
  .grid-2{display:grid; grid-template-columns:1fr 1fr; gap:20px;}

  .card{background:#fff; border:1px solid var(--border); border-radius:var(--radius); padding:24px; box-shadow:0 1px 3px rgba(20,30,60,.04);}
  .card h2{font-size:15.5px; font-weight:700; margin-bottom:18px; display:flex; align-items:center; justify-content:space-between;}
  .card h2 a{font-size:12.5px; color:var(--blue); font-weight:600; display:flex; align-items:center; gap:5px;}

  /* ===== CARTE PROFIL ===== */
  .profil-card{text-align:center;}
  .photo-wrap{position:relative; width:110px; height:110px; margin:0 auto 16px;}
  .photo-wrap img, .photo-wrap .initiale{width:110px; height:110px; border-radius:50%; object-fit:cover; background:var(--blue); color:#fff; display:flex; align-items:center; justify-content:center; font-size:34px; font-weight:700;}
  .photo-cam{position:absolute; bottom:2px; right:2px; width:32px; height:32px; border-radius:50%; background:var(--blue); color:#fff; display:flex; align-items:center; justify-content:center; border:3px solid #fff; cursor:pointer;}
  .profil-card h3{font-size:17px; font-weight:700;}
  .profil-card .poste{font-size:13px; color:var(--text-dim); margin-top:2px;}
  .badge-actif{display:inline-flex; align-items:center; gap:5px; background:rgba(16,185,129,.12); color:var(--green); font-size:11.5px; font-weight:600; padding:5px 12px; border-radius:20px; margin-top:10px;}
  .profil-infos{text-align:left; margin-top:20px; display:flex; flex-direction:column; gap:12px;}
  .profil-infos .row{display:flex; align-items:center; gap:10px; font-size:13px;}
  .profil-infos .row i{color:var(--blue); flex:none;}
  .btn-primary{width:100%; background:var(--blue); color:#fff; font-weight:600; font-size:13.5px; padding:12px; border-radius:12px; margin-top:20px; display:flex; align-items:center; justify-content:center; gap:8px;}

  /* ===== INFOS PERSONNELLES (formulaire) ===== */
  .field-row{display:flex; align-items:center; gap:12px; padding:13px 0; border-bottom:1px solid var(--border);}
  .field-row:last-child{border-bottom:none;}
  .field-ico{width:34px; height:34px; border-radius:10px; background:var(--blue-light); color:var(--blue); display:flex; align-items:center; justify-content:center; flex:none;}
  .field-row label{display:block; font-size:11.5px; color:var(--text-dim); margin-bottom:3px;}
  .field-row input, .field-row select{width:100%; border:none; font-size:13.5px; font-weight:500; color:var(--text); font-family:inherit; background:transparent; padding:2px 0;}
  .field-row input:focus, .field-row select:focus{outline:none; border-bottom:1.5px solid var(--blue);}

  /* ===== CONTACT ===== */
  .contact-row{display:flex; align-items:center; justify-content:space-between; padding:12px 0; border-bottom:1px solid var(--border);}
  .contact-row:last-child{border-bottom:none;}
  .contact-row .left{display:flex; align-items:center; gap:12px;}
  .contact-row label{display:block; font-size:11.5px; color:var(--text-dim);}
  .contact-row .val{font-size:13.5px; font-weight:600;}
  .badge-verifie{background:rgba(16,185,129,.12); color:var(--green); font-size:10.5px; font-weight:600; padding:3px 9px; border-radius:20px;}

  /* ===== SÉCURITÉ ===== */
  .secu-row{display:flex; align-items:center; justify-content:space-between; padding:14px 0; border-bottom:1px solid var(--border);}
  .secu-row:last-child{border-bottom:none;}
  .secu-row .left{display:flex; align-items:center; gap:12px;}
  .secu-row .ico{width:34px; height:34px; border-radius:10px; background:var(--blue-light); color:var(--blue); display:flex; align-items:center; justify-content:center;}
  .secu-row label{display:block; font-size:13.5px; font-weight:600;}
  .secu-row span{font-size:11.5px; color:var(--text-dim);}
  .btn-link{color:var(--blue); font-size:12.5px; font-weight:600;}
  .switch{width:38px; height:22px; border-radius:20px; background:var(--green); position:relative; flex:none;}
  .switch::after{content:''; position:absolute; top:2px; right:2px; width:18px; height:18px; border-radius:50%; background:#fff;}

  /* ===== MODAL MOT DE PASSE ===== */
  .modal-overlay{position:fixed; inset:0; background:rgba(10,15,30,.5); display:none; align-items:center; justify-content:center; z-index:100;}
  .modal-overlay.open{display:flex;}
  .modal-box{background:#fff; border-radius:18px; padding:26px; width:100%; max-width:400px;}
  .modal-box h3{font-size:16px; font-weight:700; margin-bottom:16px;}
  .modal-field{margin-bottom:12px;}
  .modal-field label{display:block; font-size:12px; color:var(--text-dim); margin-bottom:5px;}
  .modal-field input{width:100%; border:1px solid var(--border); border-radius:10px; padding:9px 12px; font-size:13px; font-family:inherit;}
  .modal-actions{display:flex; gap:10px; margin-top:16px;}
  .btn-cancel{flex:1; border:1px solid var(--border); border-radius:10px; padding:10px; font-size:13px; font-weight:600;}
  .btn-submit{flex:1; background:var(--blue); color:#fff; border-radius:10px; padding:10px; font-size:13px; font-weight:600;}
  .error-text{color:var(--red); font-size:11.5px; margin-top:4px;}
  .status-ok{color:var(--green); font-size:12.5px; margin-top:10px;}

  @media (max-width:1000px){
    .grid-profil{grid-template-columns:1fr;}
    .grid-2{grid-template-columns:1fr;}
  }
  @media (max-width:800px){
    .sidebar{display:none;}
  }
</style>
</head>
<body>

<div class="app">

  <!-- ===== SIDEBAR ===== -->
  <aside class="sidebar">
    <div class="side-logo"><img src="{{ asset('images/logo-naja7host.png') }}" alt="NAJA7HOST" style="width:100%;height:100%;object-fit:cover;border-radius:13px;"></div>
    <nav class="side-nav">
      <a href="{{ route('dashboard') }}" class="side-link" title="Tableau de bord"><i data-lucide="layout-dashboard" style="width:19px;height:19px;"></i></a>
      <a href="#" class="side-link" title="Mes demandes"><i data-lucide="file-text" style="width:19px;height:19px;"></i></a>
      <a href="#" class="side-link" title="Nouvelle demande"><i data-lucide="plus-circle" style="width:19px;height:19px;"></i></a>
      <a href="#" class="side-link" title="Calendrier"><i data-lucide="calendar-days" style="width:19px;height:19px;"></i></a>
      <a href="#" class="side-link" title="Mon solde"><i data-lucide="wallet" style="width:19px;height:19px;"></i></a>
      <a href="#" class="side-link" title="Historique"><i data-lucide="history" style="width:19px;height:19px;"></i></a>
      <a href="{{ route('profile.edit') }}" class="side-link active" title="Mon profil"><i data-lucide="user" style="width:19px;height:19px;"></i></a>
      <a href="#" class="side-link" title="Paramètres"><i data-lucide="settings" style="width:19px;height:19px;"></i></a>
    </nav>
    <div class="side-bottom">
      <a href="#" class="side-link" title="Aide"><i data-lucide="headphones" style="width:18px;height:18px;"></i></a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="side-link" title="Se déconnecter"><i data-lucide="log-out" style="width:18px;height:18px;"></i></button>
      </form>
    </div>
  </aside>

  <!-- ===== MAIN ===== -->
  <main class="main">

    <!-- ===== TOPBAR ===== -->
    <div class="topbar">
      <div></div>
      <div class="top-right">
        <button class="icon-btn"><i data-lucide="bell" style="width:17px;height:17px;"></i></button>
        <button class="icon-btn"><i data-lucide="message-square" style="width:17px;height:17px;"></i></button>
        <div class="user-chip">
          <div class="avatar">
            @if ($user->photo_path)
              <img src="{{ asset('storage/'.$user->photo_path) }}" alt="Photo de profil">
            @else
              {{ strtoupper(substr($user->name,0,1)) }}
            @endif
          </div>
          <div>
            <p>{{ $user->name }}</p>
            <span>{{ $user->poste ?? 'Employé' }}</span>
          </div>
          <i data-lucide="chevron-down" style="width:14px;height:14px; color:var(--text-dim);"></i>
        </div>
      </div>
    </div>

    <!-- ===== HEADER PAGE ===== -->
    <div class="page-head">
      <h1>Mon profil</h1>
      <div class="breadcrumb"><a href="{{ route('dashboard') }}">Accueil</a> › Mon profil</div>
    </div>

    @if (session('status') === 'profile-updated')
      <div class="status-ok" style="margin-bottom:16px;">✓ Profil mis à jour.</div>
    @endif

    <!-- ===== FORMULAIRE PRINCIPAL (une seule soumission pour tout) ===== -->
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="profilForm">
      @csrf
      @method('patch')

      <div class="grid-profil">
        <!-- ===== CARTE PROFIL ===== -->
        <div class="card profil-card">
          <div class="photo-wrap">
            @if ($user->photo_path)
              <img src="{{ asset('storage/'.$user->photo_path) }}" alt="Photo de profil">
            @else
              <div class="initiale">{{ strtoupper(substr($user->name,0,1)) }}</div>
            @endif
            <label for="photo" class="photo-cam"><i data-lucide="camera" style="width:15px;height:15px;"></i></label>
            <input type="file" name="photo" id="photo" accept="image/*" style="display:none;">
          </div>

          <h3>{{ $user->name }}</h3>
          <p class="poste">{{ $user->poste ?? 'Employé' }}</p>
          <span class="badge-actif"><i data-lucide="check-circle" style="width:12px;height:12px;"></i> Compte actif</span>

          <div class="profil-infos">
            <div class="row"><i data-lucide="mail" style="width:15px;height:15px;"></i> {{ $user->email }}</div>
            @if ($user->telephone)
              <div class="row"><i data-lucide="phone" style="width:15px;height:15px;"></i> {{ $user->telephone }}</div>
            @endif
            @if ($user->adresse)
              <div class="row"><i data-lucide="map-pin" style="width:15px;height:15px;"></i> {{ $user->adresse }}</div>
            @endif
          </div>

          <button type="submit" class="btn-primary"><i data-lucide="pencil" style="width:14px;height:14px;"></i> Enregistrer les modifications</button>
          <x-input-error class="mt-2" :messages="$errors->get('photo')" />
        </div>

        <!-- ===== INFORMATIONS PERSONNELLES ===== -->
        <div class="card">
          <h2>Informations personnelles</h2>

          <div class="field-row">
            <span class="field-ico"><i data-lucide="user" style="width:16px;height:16px;"></i></span>
            <div style="flex:1;">
              <label>Nom complet</label>
              <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
          </div>
          <x-input-error class="mt-1" :messages="$errors->get('name')" />

          <div class="field-row">
            <span class="field-ico"><i data-lucide="cake" style="width:16px;height:16px;"></i></span>
            <div style="flex:1;">
              <label>Date de naissance</label>
              <input type="date" name="date_naissance" value="{{ old('date_naissance', optional($user->date_naissance)->format('Y-m-d')) }}">
            </div>
          </div>

          <div class="field-row">
            <span class="field-ico"><i data-lucide="map-pin" style="width:16px;height:16px;"></i></span>
            <div style="flex:1;">
              <label>Lieu de naissance</label>
              <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance', $user->lieu_naissance) }}">
            </div>
          </div>

          <div class="field-row">
            <span class="field-ico"><i data-lucide="flag" style="width:16px;height:16px;"></i></span>
            <div style="flex:1;">
              <label>Nationalité</label>
              <input type="text" name="nationalite" value="{{ old('nationalite', $user->nationalite) }}">
            </div>
          </div>

          <div class="field-row">
            <span class="field-ico"><i data-lucide="id-card" style="width:16px;height:16px;"></i></span>
            <div style="flex:1;">
              <label>Numéro CIN</label>
              <input type="text" name="cin" value="{{ old('cin', $user->cin) }}">
            </div>
          </div>

          <div class="field-row">
            <span class="field-ico"><i data-lucide="home" style="width:16px;height:16px;"></i></span>
            <div style="flex:1;">
              <label>Adresse</label>
              <input type="text" name="adresse" value="{{ old('adresse', $user->adresse) }}">
            </div>
          </div>

          <div class="field-row">
            <span class="field-ico"><i data-lucide="heart" style="width:16px;height:16px;"></i></span>
            <div style="flex:1;">
              <label>Situation familiale</label>
              <select name="situation_familiale">
                <option value="">—</option>
                @foreach (['Célibataire', 'Marié(e)', 'Divorcé(e)', 'Veuf(ve)'] as $option)
                  <option value="{{ $option }}" @selected(old('situation_familiale', $user->situation_familiale) === $option)>{{ $option }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>

      <div class="grid-2">
        <!-- ===== CONTACT ===== -->
        <div class="card">
          <h2>Informations de contact</h2>

          <div class="contact-row">
            <div class="left">
              <span class="field-ico"><i data-lucide="mail" style="width:16px;height:16px;"></i></span>
              <div>
                <label>Email professionnel</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       style="border:none; font-size:13.5px; font-weight:600; font-family:inherit; background:transparent;">
              </div>
            </div>
            @if ($user->hasVerifiedEmail())
              <span class="badge-verifie">Vérifié ✓</span>
            @endif
          </div>
          <x-input-error class="mt-1" :messages="$errors->get('email')" />

          <div class="contact-row">
            <div class="left">
              <span class="field-ico"><i data-lucide="phone" style="width:16px;height:16px;"></i></span>
              <div>
                <label>Téléphone</label>
                <input type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}" placeholder="+212 6 00 00 00 00"
                       style="border:none; font-size:13.5px; font-weight:600; font-family:inherit; background:transparent;">
              </div>
            </div>
          </div>

          <div class="contact-row">
            <div class="left">
              <span class="field-ico"><i data-lucide="map-pin" style="width:16px;height:16px;"></i></span>
              <div>
                <label>Adresse</label>
                <div class="val">{{ $user->adresse ?? '—' }}</div>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== SÉCURITÉ (bouton "Modifier" ouvre une modale séparée) ===== -->
        <div class="card">
          <h2>Sécurité du compte</h2>

          <div class="secu-row">
            <div class="left">
              <span class="ico"><i data-lucide="lock" style="width:16px;height:16px;"></i></span>
              <div>
                <label>Mot de passe</label>
                <span>••••••••••</span>
              </div>
            </div>
            <button type="button" class="btn-link" id="ouvrirMotDePasse">Modifier</button>
          </div>

          <div class="secu-row">
            <div class="left">
              <span class="ico"><i data-lucide="shield-check" style="width:16px;height:16px;"></i></span>
              <div>
                <label>Authentification à deux facteurs</label>
                <span>Non disponible pour l'instant</span>
              </div>
            </div>
          </div>

          <div class="secu-row">
            <div class="left">
              <span class="ico"><i data-lucide="monitor-smartphone" style="width:16px;height:16px;"></i></span>
              <div>
                <label>Sessions actives</label>
                <span>Cette session uniquement</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>

  </main>
</div>

<!-- ===== MODAL MOT DE PASSE ===== -->
<div class="modal-overlay" id="pwdModal">
  <div class="modal-box">
    <h3>Modifier le mot de passe</h3>
    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      @method('put')

      <div class="modal-field">
        <label>Mot de passe actuel</label>
        <input type="password" name="current_password">
        <x-input-error class="mt-1" :messages="$errors->updatePassword->get('current_password')" />
      </div>
      <div class="modal-field">
        <label>Nouveau mot de passe</label>
        <input type="password" name="password">
        <x-input-error class="mt-1" :messages="$errors->updatePassword->get('password')" />
      </div>
      <div class="modal-field">
        <label>Confirmer le nouveau mot de passe</label>
        <input type="password" name="password_confirmation">
      </div>

      <div class="modal-actions">
        <button type="button" class="btn-cancel" id="fermerMotDePasse">Annuler</button>
        <button type="submit" class="btn-submit">Enregistrer</button>
      </div>
    </form>
  </div>
</div>

<script>
  lucide.createIcons();

  // Aperçu + soumission automatique quand on choisit une nouvelle photo
  document.getElementById('photo').addEventListener('change', () => {
    document.getElementById('profilForm').submit();
  });

  // Modal mot de passe
  const pwdModal = document.getElementById('pwdModal');
  document.getElementById('ouvrirMotDePasse').addEventListener('click', () => pwdModal.classList.add('open'));
  document.getElementById('fermerMotDePasse').addEventListener('click', () => pwdModal.classList.remove('open'));
  pwdModal.addEventListener('click', (e) => { if (e.target === pwdModal) pwdModal.classList.remove('open'); });
</script>
</body>
</html>