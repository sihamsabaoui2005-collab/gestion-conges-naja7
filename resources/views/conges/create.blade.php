<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nouvelle demande de congé — NAJA7 HOST</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<style>
  :root{
    --blue:#3B82F6; --blue-2:#60A5FA;
    --orange:#F59E0B; --orange-2:#FBBF24; --green:#10B981; --red:#EF4444; --purple:#8B5CF6;
    --bg:#05070F; --panel:rgba(18,24,42,.55); --panel-2:rgba(255,255,255,.06);
    --border:rgba(255,255,255,.12);
    --text:#F1F4FA; --text-dim:#C3CCE0;
    --radius:22px; --glass-blur:22px;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  html, body{height:100%; overflow-x:hidden;}
  body{
    font-family:'Poppins',sans-serif; color:var(--text); -webkit-font-smoothing:antialiased;
    background: linear-gradient(180deg, rgba(4,6,14,.72), rgba(4,6,14,.88)), url('{{ asset('images/dashboard-bg.jpg') }}') center/cover no-repeat fixed;
  }
  a{text-decoration:none; color:inherit;}
  button{font-family:inherit; cursor:pointer; border:none; background:none; color:inherit;}
  select, input, textarea{font-family:inherit;}

  .app{display:flex; align-items:flex-start; min-height:100vh; padding:16px 24px; gap:16px; max-width:1500px; margin:0 auto; overflow-x:hidden;}

  /* ===== SIDEBAR (identique à Mon profil / dashboards) ===== */
  .sidebar{width:64px; flex:none; align-self:flex-start; position:sticky; top:16px; z-index:100; background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:32px; padding:14px 0 16px; display:flex; flex-direction:column; align-items:center; box-shadow:0 8px 32px rgba(0,0,0,.35); max-height:94vh;}
  .side-logo{width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; margin-bottom:12px; font-weight:700; overflow:hidden; flex:none;}
  .side-logo img{width:100%; height:100%; object-fit:cover;}
  .side-nav{display:flex; flex-direction:column; gap:3px; flex:1;}
  .side-link{position:relative; width:36px; height:36px; border-radius:11px; display:flex; align-items:center; justify-content:center; color:var(--text-dim); flex:none;}
  .side-link:hover{background:rgba(255,255,255,.08); color:#fff;}
  .side-link.active{background:var(--orange); color:#fff;}
  .side-link .tip{position:absolute; left:48px; top:50%; transform:translateY(-50%); background:rgba(20,26,46,.92); backdrop-filter:blur(10px); padding:6px 12px; border-radius:8px; font-size:12px; white-space:nowrap; opacity:0; pointer-events:none; transition:opacity .15s; z-index:30; border:1px solid var(--border);}
  .side-link:hover .tip{opacity:1;}
  .side-link:focus .tip{opacity:1;}
  .side-bottom{display:flex; flex-direction:column; gap:4px; padding-top:8px; margin-top:6px; border-top:1px solid var(--border); align-items:center; flex:none;}

  .main{flex:1; align-self:stretch; padding:6px 6px 40px; max-width:100%; overflow-x:hidden;}

  /* ===== TOPBAR (identique à Mon profil) ===== */
  .topbar{display:flex; align-items:center; justify-content:flex-end; margin-bottom:22px; gap:14px;}
  .icon-btn{position:relative; width:40px; height:40px; border-radius:999px; display:flex; align-items:center; justify-content:center; color:#fff;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.15), rgba(255,255,255,0) 45%), linear-gradient(160deg, #2A3350, #12141F 75%);
    box-shadow:0 6px 16px rgba(0,0,0,.4), inset 0 1px 0 rgba(255,255,255,.1);}
  .icon-btn .dot{position:absolute; top:-3px; right:-3px; background:var(--red); color:#fff; font-size:9.5px; font-weight:700; width:17px; height:17px; border-radius:50%; display:flex; align-items:center; justify-content:center;}
  .user-chip{display:flex; align-items:center; gap:10px; background:var(--panel); backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:6px 14px 6px 6px; cursor:pointer; position:relative;}
  .avatar-sm{width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; overflow:hidden; flex:none;}
  .avatar-sm img{width:100%; height:100%; object-fit:cover; object-position:center top; border-radius:50%;}
  .user-dropdown{position:absolute; top:52px; right:0; background:rgba(18,24,42,.92); backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:8px; width:200px; box-shadow:0 12px 30px rgba(0,0,0,.5); display:none; z-index:50;}
  .user-dropdown.open{display:block;}
  .user-dropdown a, .user-dropdown button{display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:11px; font-size:13px; width:100%; text-align:left; color:#fff;}
  .user-dropdown a:hover, .user-dropdown button:hover{background:rgba(255,255,255,.06);}
  .user-chip p{font-size:13px; font-weight:600;}
  .user-chip span{font-size:11px; color:var(--text-dim);}

  .fil{font-size:12.5px; color:var(--text-dim); margin-bottom:10px;}
  .fil b{color:#fff;}

  .header{margin-bottom:22px;}
  .header h1{font-size:26px; font-weight:800; color:#fff;}
  .header p{color:var(--text-dim); font-size:14px; margin-top:4px;}

  /* ===== LAYOUT (rendu par le composant Livewire) ===== */
  .layout{display:grid; grid-template-columns:1fr 320px; gap:18px; align-items:start;}
  .layout > .panel{min-width:0;}
  @media (max-width:1050px){ .layout{grid-template-columns:1fr;} }

  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25);}

  /* ===== FORMULAIRE (colonne principale) ===== */
  .form-panel{padding:22px;}

  .banniere{position:relative; display:flex; align-items:center; gap:24px; padding:22px; border-radius:18px; margin-bottom:24px; flex-wrap:wrap;
    background:linear-gradient(120deg, rgba(245,158,11,.14), rgba(18,24,42,.3));border:1px solid rgba(245,158,11,.25);}
  .banniere-img{width:120px; height:90px; object-fit:contain; flex:none;}
  .banniere-texte{flex:1; min-width:180px;}
  .banniere-texte span{display:block; font-size:14px; color:var(--text-dim);}
  .banniere-texte b{display:block; font-size:22px; font-weight:800; color:var(--orange); font-style:italic;}
  .banniere-avantages{display:flex; gap:18px; flex-wrap:wrap;}
  .avantage{display:flex; align-items:center; gap:8px;}
  .avantage .ico{width:30px; height:30px; border-radius:50%; background:rgba(245,158,11,.15); color:var(--orange); display:flex; align-items:center; justify-content:center; flex:none;}
  .avantage b{display:block; font-size:12.5px;}
  .avantage span{font-size:10.5px; color:var(--text-dim);}

  .section{margin-bottom:24px;}
  .section-title{display:flex; align-items:center; gap:8px; font-size:15px; font-weight:700; color:#fff; margin-bottom:12px;}
  .section-title .num{width:22px; height:22px; border-radius:7px; background:var(--orange); color:#111; font-size:11px; font-weight:800; display:flex; align-items:center; justify-content:center; flex:none;}
  .section-title .optionnel{font-size:12px; font-weight:500; color:var(--text-dim);}

  .type-grid{display:grid; grid-template-columns:repeat(5,1fr); gap:10px;}
  @media (max-width:900px){ .type-grid{grid-template-columns:repeat(3,1fr);} }
  @media (max-width:560px){ .type-grid{grid-template-columns:repeat(2,1fr);} }
  .type-card{position:relative; background:var(--panel-2); border:1.5px solid var(--border); border-radius:14px; padding:16px 8px; display:flex; flex-direction:column; align-items:center; gap:8px; text-align:center;}
  .type-card:hover{border-color:rgba(245,158,11,.4);}
  .type-card.active{border-color:var(--orange); background:rgba(245,158,11,.1);}
  .type-ico{color:var(--text-dim);}
  .type-card.active .type-ico{color:var(--orange);}
  .type-label{font-size:12px; font-weight:600; line-height:1.25;}
  .type-check{position:absolute; top:8px; right:8px; width:16px; height:16px; border-radius:50%; background:var(--orange); color:#111; display:flex; align-items:center; justify-content:center;}

  .periode-grid{display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px;}
  @media (max-width:700px){ .periode-grid{grid-template-columns:1fr;} }
  .champ label{display:block; font-size:12.5px; color:var(--text-dim); margin-bottom:6px;}
  .champ-input{display:flex; align-items:center; gap:8px; background:#141b30; border:1px solid var(--border); border-radius:10px; padding:10px 12px;}
  .champ-input i{color:var(--text-dim); flex:none;}
  .champ-input input{flex:1; background:transparent; border:none; outline:none; color:#fff; font-size:14px; color-scheme:dark;}
  .champ-readonly{background:#141b30; border:1px solid var(--border); border-radius:10px; padding:11px 12px; font-size:14px; font-weight:600; color:var(--orange);}

  .info-bloc{display:flex; align-items:center; gap:8px; margin-top:12px; padding:10px 14px; border-radius:10px; background:rgba(59,130,246,.1); color:var(--blue-2); font-size:12.5px;}

  .motif-wrap{position:relative;}
  .motif-wrap textarea{width:100%; min-height:90px; resize:vertical; background:#141b30; border:1px solid var(--border); border-radius:12px; padding:12px 14px 24px; color:#fff; font-size:14px; outline:none;}
  .motif-wrap textarea::placeholder{color:var(--text-dim);}
  .motif-count{position:absolute; bottom:10px; right:14px; font-size:11px; color:var(--text-dim);}

  .dropzone{position:relative; display:flex; align-items:center; gap:14px; border:1.5px dashed var(--border); border-radius:14px; padding:16px 18px; cursor:pointer; color:var(--text-dim);}
  .dropzone:hover{border-color:rgba(245,158,11,.4);}
  .dropzone div{flex:1;}
  .dropzone span{display:block; font-size:13.5px; color:#fff;}
  .dropzone small{font-size:11.5px; color:var(--text-dim);}
  .btn-parcourir{background:var(--panel-2); border:1px solid var(--border); padding:8px 16px; border-radius:9px; font-size:12.5px; font-weight:600; color:#fff; flex:none;}
  .input-fichier-cache{position:absolute; inset:0; opacity:0; cursor:pointer;}
  .upload-loading{font-size:12px; color:var(--orange); margin-top:6px;}

  .err{font-size:12px; color:var(--red); margin-top:6px;}

  .form-actions{display:flex; align-items:center; justify-content:flex-end; gap:12px; margin-top:28px; flex-wrap:wrap;}
  .btn-annuler{background:var(--panel-2); border:1px solid var(--border); color:var(--text-dim); font-size:13.5px; font-weight:600; padding:11px 22px; border-radius:11px;}
  .btn-soumettre{display:inline-flex; align-items:center; gap:7px; font-size:13.5px; font-weight:700; color:#fff; padding:11px 22px; border-radius:11px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .btn-soumettre:hover, .btn-annuler:hover{filter:brightness(1.1);}
  .btn-soumettre[disabled]{opacity:.6; cursor:default;}

  /* ===== SIDEBAR DROITE ===== */
  .side-panel{padding:20px;}
  .side-panel h3{font-size:15px; font-weight:800; color:#fff; margin-bottom:14px;}

  .solde-wrap{position:relative; width:150px; height:150px; margin:0 auto 16px;}
  .solde-center{position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;}
  .solde-center b{font-size:32px; font-weight:800; color:#fff;}
  .solde-center span{font-size:11px; color:var(--text-dim);}

  .calendrier-nav{display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;}
  .calendrier-nav button{width:26px; height:26px; border-radius:8px; background:var(--panel-2); display:flex; align-items:center; justify-content:center; color:var(--text-dim);}
  .calendrier-nav b{font-size:13px; text-transform:capitalize;}
  .cal-grid{display:grid; grid-template-columns:repeat(7,1fr); gap:3px; text-align:center;}
  .cal-jour-nom{font-size:9.5px; color:var(--text-dim); padding-bottom:4px;}
  .cal-jour{position:relative; font-size:11.5px; padding:6px 0; border-radius:8px; color:var(--text-dim);}
  .cal-jour.hors-mois{opacity:.3;}
  .cal-jour.aujourdhui{border:1px solid var(--orange); color:#fff;}
  .cal-jour.dans-range{background:rgba(245,158,11,.18); color:#fff; border-radius:0;}
  .cal-jour.debut, .cal-jour.fin{background:var(--orange); color:#111; font-weight:700; border-radius:8px;}

  .apercu-legende{display:flex; flex-direction:column; gap:8px; margin-top:14px; font-size:12px;}
  .apercu-legende .item{display:flex; align-items:center; justify-content:space-between;}
  .apercu-legende .puce{width:8px; height:8px; border-radius:50%; margin-right:6px; display:inline-block;}

  .bon-a-savoir{display:flex; gap:10px; align-items:flex-start;}
  .bon-a-savoir .ico{width:32px; height:32px; border-radius:10px; background:rgba(245,158,11,.15); color:var(--orange); display:flex; align-items:center; justify-content:center; flex:none;}
  .bon-a-savoir p{font-size:13px; color:var(--text-dim); line-height:1.5;}

  @media (max-width:800px){ .sidebar{display:none;} }
</style>
@livewireStyles
</head>
<body>

<div class="app">

  <!-- ===== SIDEBAR (identique à Mon profil) ===== -->
  <aside class="sidebar">
    <div class="side-logo">
      <img src="{{ asset('images/logo-naja7host.png') }}" alt="NAJA7HOST">
    </div>
    <nav class="side-nav">
      @if (auth()->user()->role === 'rh')
        <a href="{{ route('dashboard') }}" class="side-link"><i data-lucide="home" style="width:17px;height:17px;"></i><span class="tip">Tableau de bord</span></a>
        <a href="#" class="side-link"><i data-lucide="calendar-heart" style="width:17px;height:17px;"></i><span class="tip">Congés &amp; Absences</span></a>
        <a href="{{ route('conges.index') }}" class="side-link"><i data-lucide="file-text" style="width:17px;height:17px;"></i><span class="tip">Demandes</span></a>
        <a href="#" class="side-link"><i data-lucide="users" style="width:17px;height:17px;"></i><span class="tip">Employés</span></a>
        <a href="#" class="side-link"><i data-lucide="calendar-days" style="width:17px;height:17px;"></i><span class="tip">Calendrier équipe</span></a>
        <a href="#" class="side-link"><i data-lucide="check-square" style="width:17px;height:17px;"></i><span class="tip">Validation</span></a>
        <a href="#" class="side-link"><i data-lucide="file-bar-chart" style="width:17px;height:17px;"></i><span class="tip">Rapports</span></a>
        <a href="#" class="side-link"><i data-lucide="bar-chart-3" style="width:17px;height:17px;"></i><span class="tip">Statistiques</span></a>
        <a href="{{ route('profile.edit') }}" class="side-link"><i data-lucide="user" style="width:17px;height:17px;"></i><span class="tip">Mon profil</span></a>
        <a href="#" class="side-link"><i data-lucide="settings" style="width:17px;height:17px;"></i><span class="tip">Paramètres</span></a>
      @else
        <a href="{{ route('dashboard') }}" class="side-link"><i data-lucide="layout-dashboard" style="width:17px;height:17px;"></i><span class="tip">Tableau de bord</span></a>
        <a href="#" class="side-link"><i data-lucide="file-text" style="width:17px;height:17px;"></i><span class="tip">Mes demandes</span></a>
        <a href="{{ route('conges.create') }}" class="side-link active"><i data-lucide="plus-circle" style="width:17px;height:17px;"></i><span class="tip">Nouvelle demande</span></a>
        <a href="#" class="side-link"><i data-lucide="calendar-days" style="width:17px;height:17px;"></i><span class="tip">Calendrier</span></a>
        <a href="#" class="side-link"><i data-lucide="wallet" style="width:17px;height:17px;"></i><span class="tip">Mon solde</span></a>
        <a href="#" class="side-link"><i data-lucide="history" style="width:17px;height:17px;"></i><span class="tip">Historique</span></a>
        <a href="{{ route('profile.edit') }}" class="side-link"><i data-lucide="user" style="width:17px;height:17px;"></i><span class="tip">Mon profil</span></a>
        <a href="#" class="side-link"><i data-lucide="settings" style="width:17px;height:17px;"></i><span class="tip">Paramètres</span></a>
      @endif
    </nav>
    <div class="side-bottom">
      <a href="#" class="side-link"><i data-lucide="headphones" style="width:16px;height:16px;"></i><span class="tip">Support</span></a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="side-link"><i data-lucide="log-out" style="width:16px;height:16px;"></i><span class="tip">Déconnexion</span></button>
      </form>
    </div>
  </aside>

  <!-- ===== MAIN ===== -->
  <main class="main">

    <!-- ===== TOPBAR (identique à Mon profil) ===== -->
    <div class="topbar">
      <button class="icon-btn"><i data-lucide="bell" style="width:17px;height:17px;"></i><span class="dot">3</span></button>
      <button class="icon-btn"><i data-lucide="mail" style="width:17px;height:17px;"></i></button>
      <div class="user-chip" id="userChip">
        <div class="avatar-sm">
          @if (auth()->user()->photo_path)
            <img src="{{ asset('storage/'.auth()->user()->photo_path) }}" alt="">
          @else
            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
          @endif
        </div>
        <div>
          <p>{{ auth()->user()->name }}</p>
          <span>{{ auth()->user()->role === 'rh' ? 'Responsable RH' : 'Employé' }}</span>
        </div>
        <i data-lucide="chevron-down" style="width:14px;height:14px; color:var(--text-dim);"></i>

        <div class="user-dropdown" id="userDropdown">
          <a href="{{ route('profile.edit') }}"><i data-lucide="user" style="width:15px;height:15px;"></i> Mon profil</a>
          <a href="#"><i data-lucide="settings" style="width:15px;height:15px;"></i> Paramètres</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"><i data-lucide="log-out" style="width:15px;height:15px;"></i> Déconnexion</button>
          </form>
        </div>
      </div>
    </div>

    <div class="fil">Congés &amp; Absences &nbsp;›&nbsp; <b>Nouvelle demande</b></div>

    <div class="header">
      <h1>Nouvelle demande de congé</h1>
      <p>Créez votre demande en quelques étapes simples et rapides.</p>
    </div>

    @livewire('conges.nouvelle-demande')

  </main>
</div>

<script>
  lucide.createIcons();

  document.querySelectorAll('.sidebar a[href="#"], .user-dropdown a[href="#"]').forEach(lien => {
    lien.addEventListener('click', (e) => e.preventDefault());
  });

  /* ===== MENU DEROULANT PROFIL (topbar) ===== */
  const userChip = document.getElementById('userChip');
  const userDropdown = document.getElementById('userDropdown');
  userChip.addEventListener('click', (e) => {
    e.stopPropagation();
    userDropdown.classList.toggle('open');
  });
  document.addEventListener('click', () => userDropdown.classList.remove('open'));
  userDropdown.addEventListener('click', (e) => e.stopPropagation());

  document.addEventListener('livewire:navigated', () => lucide.createIcons());
  Livewire.hook('morph.updated', () => lucide.createIcons());
</script>
@livewireScripts
</body>
</html>