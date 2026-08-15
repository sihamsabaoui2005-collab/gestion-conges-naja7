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
    --blue:#3B82F6; --blue-2:#60A5FA;
    --orange:#F59E0B; --orange-2:#FBBF24; --green:#10B981; --red:#EF4444; --purple:#8B5CF6;
    --bg:#05070F; --panel:rgba(18,24,42,.55); --panel-2:rgba(255,255,255,.06);
    --border:rgba(255,255,255,.12);
    --text:#F1F4FA; --text-dim:#C3CCE0;
    --radius:22px; --glass-blur:22px;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  html, body{height:100%;}
  body{
    font-family:'Poppins',sans-serif; color:var(--text); -webkit-font-smoothing:antialiased;
    background: linear-gradient(180deg, rgba(4,6,14,.72), rgba(4,6,14,.88)), url('{{ asset('images/dashboard-bg.jpg') }}') center/cover no-repeat fixed;
  }
  a{text-decoration:none; color:inherit;}
  button{font-family:inherit; cursor:pointer; border:none; background:none; color:inherit;}

  .app{display:flex; align-items:flex-start; min-height:100vh; padding:16px 24px; gap:16px; max-width:1500px; margin:0 auto;}

  /* ===== SIDEBAR (identique aux dashboards) ===== */
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

  /* ===== TOPBAR ===== */
  .topbar{display:flex; align-items:center; justify-content:flex-end; margin-bottom:22px; gap:14px;}
  .icon-btn{position:relative; width:40px; height:40px; border-radius:999px; display:flex; align-items:center; justify-content:center; color:#fff;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.15), rgba(255,255,255,0) 45%), linear-gradient(160deg, #2A3350, #12141F 75%);
    box-shadow:0 6px 16px rgba(0,0,0,.4), inset 0 1px 0 rgba(255,255,255,.1);}
  .icon-btn .dot{position:absolute; top:-3px; right:-3px; background:var(--red); color:#fff; font-size:9.5px; font-weight:700; width:17px; height:17px; border-radius:50%; display:flex; align-items:center; justify-content:center;}
  .user-chip{display:flex; align-items:center; gap:10px; background:var(--panel); backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:6px 14px 6px 6px;}
  .avatar-sm{width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; overflow:hidden; flex:none;}
  .avatar-sm img{width:100%; height:100%; object-fit:cover; object-position:center top; border-radius:50%;}
  .user-chip{cursor:pointer; position:relative;}
  .user-dropdown{position:absolute; top:52px; right:0; background:rgba(18,24,42,.92); backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:8px; width:200px; box-shadow:0 12px 30px rgba(0,0,0,.5); display:none; z-index:50;}
  .user-dropdown.open{display:block;}
  .user-dropdown a, .user-dropdown button{display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:11px; font-size:13px; width:100%; text-align:left; color:#fff;}
  .user-dropdown a:hover, .user-dropdown button:hover{background:rgba(255,255,255,.06);}
  .user-chip p{font-size:13px; font-weight:600;}
  .user-chip span{font-size:11px; color:var(--text-dim);}

  /* ===== GREETING ===== */
  .page-head{margin-bottom:22px;}
  .page-head h1{position:relative; display:inline-flex; align-items:center; font-size:20px; font-weight:800; color:#0C2340;
    padding:12px 32px; margin-bottom:2px;
    background:linear-gradient(160deg,#7DD3FC,#38BDF8);
    clip-path: polygon(4% 0%, 96% 0%, 100% 50%, 96% 100%, 4% 100%, 0% 50%);
    box-shadow:0 6px 14px rgba(56,189,248,.35);}
  .page-head p{color:var(--text-dim); font-size:13.5px; margin-top:4px; text-shadow:0 2px 10px rgba(0,0,0,.7), 0 1px 2px rgba(0,0,0,.9);}

  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25);}

  /* ===== CARTE PROFIL (haut) ===== */
  .profile-hero{display:grid; grid-template-columns:1.6fr 1fr; gap:16px; margin-bottom:18px;}
  .hero-left{display:flex; align-items:center; gap:20px; padding:26px;}
  .avatar-wrap{position:relative; width:140px; height:140px; flex:none;}
  .hero-avatar{width:140px; height:140px; border-radius:50%; background:#fff; display:flex; align-items:center; justify-content:center; font-size:26px; font-weight:700; overflow:hidden;}
  .hero-avatar img{width:100%; height:100%; object-fit:cover; object-position:center top;}
  .cam-btn{position:absolute; bottom:-2px; right:-2px; width:42px; height:42px; border-radius:50%; background:var(--orange); border:3px solid #0b1120; display:flex; align-items:center; justify-content:center; color:#fff; cursor:pointer; z-index:5;}
  .hero-name-row{display:flex; align-items:center; gap:10px; margin-bottom:6px;}
  .hero-name-row h2{font-size:19px; font-weight:700;}
  .role-badge{background:rgba(245,158,11,.18); color:var(--orange-2); font-size:11px; font-weight:600; padding:3px 12px; border-radius:20px;}
  .hero-meta{display:flex; flex-direction:column; gap:6px; font-size:12.5px; color:var(--text-dim);}
  .hero-meta .row{display:flex; align-items:center; gap:8px;}
  .hero-meta .row i{width:14px; height:14px; flex:none; color:var(--text-dim);}

  .hero-right{padding:22px; display:flex; align-items:center; gap:14px;}
  .dept-ico{width:44px; height:44px; border-radius:13px; background:rgba(245,158,11,.15); color:var(--orange); display:flex; align-items:center; justify-content:center; flex:none;}
  .hero-right h3{position:relative; display:inline-block; font-size:11px; font-weight:800; color:#0C2340; margin-bottom:8px;
    padding:6px 20px; background:linear-gradient(160deg,#7DD3FC,#38BDF8);
    clip-path: polygon(6% 0%, 94% 0%, 100% 50%, 94% 100%, 6% 100%, 0% 50%);
    box-shadow:0 5px 12px rgba(56,189,248,.35);}
  .hero-right b{display:block; font-size:16px; font-weight:700; color:var(--orange); margin-bottom:4px;}
  .hero-right p{font-size:11.5px; color:var(--text-dim); line-height:1.4; margin-bottom:8px;}
  .hero-right a{font-size:12px; font-weight:700; color:#fff; display:inline-flex; align-items:center; gap:6px; padding:9px 16px; border-radius:999px; margin-top:2px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .hero-right a:hover{transform:translateY(-1px);}

  /* ===== INFOS / SECURITE (toujours affichées, plus d'onglets) ===== */
  .info-security-grid{display:grid; grid-template-columns:1fr 1fr; gap:16px;}
  .panel-pad{padding:22px;}
  .card-head{display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;}
  .card-head h2{position:relative; font-size:14px; font-weight:800; color:#0C2340; display:inline-flex; align-items:center; gap:8px;
    padding:9px 26px; background:linear-gradient(160deg,#7DD3FC,#38BDF8);
    clip-path: polygon(4% 0%, 96% 0%, 100% 50%, 96% 100%, 4% 100%, 0% 50%);
    box-shadow:0 6px 14px rgba(56,189,248,.35);}
  .card-head h2 i{color:#0C2340;}
  .card-head{align-items:center;}
  .card-head a{font-size:12px; color:var(--orange); font-weight:600; display:flex; align-items:center; gap:5px;}
  .card-head button{font-size:12px; font-weight:700; color:#fff; display:flex; align-items:center; gap:6px; padding:8px 16px; border-radius:999px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .card-head button:hover{transform:translateY(-1px);}

  .info-row{display:flex; align-items:center; gap:12px; padding:11px 0; border-bottom:1px solid var(--border); font-size:13px;}
  .info-row:last-child{border-bottom:none;}
  .info-row i{width:15px; height:15px; color:var(--text-dim); flex:none;}
  .info-row .lbl{color:var(--text-dim); width:150px; flex:none;}
  .info-row .val{font-weight:600;}

  .field-group{margin-bottom:14px;}
  .field-group label{display:block; font-size:12px; font-weight:600; color:var(--text-dim); margin-bottom:6px;}
  .field-group .input-wrap{position:relative;}
  .field-group input{width:100%; background:var(--panel-2); border:1.5px solid var(--border); border-radius:12px; padding:11px 42px 11px 14px; color:#fff; font-size:13.5px; font-family:inherit;}
  .field-group input:focus{outline:none; border-color:var(--orange); box-shadow:0 0 0 3px rgba(245,158,11,.15);}
  .field-group input::placeholder{color:var(--text-dim);}

  /* ===== MENU DEROULANT PERSONNALISE (reste sombre, contrairement au <select> natif) ===== */
  .custom-select{position:relative;}
  .custom-select-btn{width:100%; display:flex; align-items:center; justify-content:space-between; background:var(--panel-2); border:1.5px solid var(--border); border-radius:12px; padding:11px 14px; color:#fff; font-size:13.5px; font-family:inherit; text-align:left;}
  .custom-select-btn:hover, .custom-select-btn.open{border-color:var(--orange);}
  .custom-select-list{position:absolute; top:calc(100% + 6px); left:0; right:0; background:#151B2E; border:1.5px solid var(--border); border-radius:12px; padding:6px; box-shadow:0 12px 28px rgba(0,0,0,.5); z-index:40; display:none; max-height:220px; overflow-y:auto;}
  .custom-select-list.open{display:block;}
  .custom-select-option{padding:10px 12px; border-radius:9px; font-size:13.5px; color:#fff; cursor:pointer;}
  .custom-select-option:hover{background:rgba(245,158,11,.15); color:var(--orange);}
  .custom-select-option.selected{background:rgba(245,158,11,.15); color:var(--orange); font-weight:600;}
  .field-group .toggle-eye{position:absolute; right:13px; top:50%; transform:translateY(-50%); color:var(--text-dim); cursor:pointer; width:16px; height:16px; display:flex; align-items:center; justify-content:center;}
  .field-group .toggle-eye i{width:16px; height:16px; pointer-events:none;}
  .field-group .toggle-eye:hover{color:var(--orange);}
  .btn-primary{width:100%; position:relative; overflow:hidden; background:
      radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.35), rgba(255,255,255,0) 45%),
      linear-gradient(160deg, #F59E0B, #C2410C 75%);
    color:#fff; font-weight:700; font-size:13.5px; padding:13px; border-radius:999px; margin-top:6px;
    box-shadow:0 10px 24px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .btn-primary:hover{transform:translateY(-1px); box-shadow:0 14px 28px rgba(194,65,12,.5), inset 0 1px 0 rgba(255,255,255,.3);}

  .btn-secondary{width:100%; position:relative; overflow:hidden; background:
      radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.12), rgba(255,255,255,0) 45%),
      linear-gradient(160deg, #2A3350, #12141F 75%);
    color:#fff; font-weight:700; font-size:13.5px; padding:13px; border-radius:999px; margin-top:6px;
    box-shadow:0 8px 20px rgba(0,0,0,.45), inset 0 1px 0 rgba(255,255,255,.1);}
  .btn-secondary:hover{transform:translateY(-1px);}

  .btn-danger{width:100%; position:relative; overflow:hidden; background:
      radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.18), rgba(255,255,255,0) 45%),
      linear-gradient(160deg, #EF4444, #7F1D1D 75%);
    color:#fff; border:none; font-weight:700; font-size:13px; padding:12px; border-radius:999px; display:flex; align-items:center; justify-content:center; gap:8px;
    box-shadow:0 10px 24px rgba(127,29,29,.4), inset 0 1px 0 rgba(255,255,255,.2);}
  .btn-danger:hover{transform:translateY(-1px); box-shadow:0 14px 28px rgba(127,29,29,.5), inset 0 1px 0 rgba(255,255,255,.25);}

  .danger-zone{margin-top:22px; padding-top:18px; border-top:1px solid var(--border);}
  .danger-zone h3{font-size:13px; font-weight:700; color:var(--red); margin-bottom:4px;}
  .danger-zone p{font-size:11.5px; color:var(--text-dim); margin-bottom:12px;}


  .page-footer{display:flex; align-items:center; justify-content:space-between; margin-top:20px; font-size:11.5px; color:var(--text-dim);}
  .page-footer .badge-live{display:inline-flex; align-items:center; gap:6px; color:var(--orange); font-weight:600;}
  .page-footer .badge-live .dot-live{width:7px; height:7px; border-radius:50%; background:var(--orange);}

  @media (max-width:1000px){
    .profile-hero, .info-security-grid{grid-template-columns:1fr;}
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
    <div class="side-logo">
      <img src="{{ asset('images/logo-naja7host.png') }}" alt="NAJA7HOST">
    </div>
    <nav class="side-nav">
      @if (auth()->user()->role === 'rh')
        <a href="{{ route('dashboard') }}" class="side-link"><i data-lucide="home" style="width:17px;height:17px;"></i><span class="tip">Tableau de bord</span></a>
        <a href="#" class="side-link"><i data-lucide="calendar-heart" style="width:17px;height:17px;"></i><span class="tip">Congés &amp; Absences</span></a>
        <a href="#" class="side-link"><i data-lucide="file-text" style="width:17px;height:17px;"></i><span class="tip">Demandes</span></a>
        <a href="#" class="side-link"><i data-lucide="users" style="width:17px;height:17px;"></i><span class="tip">Employés</span></a>
        <a href="#" class="side-link"><i data-lucide="calendar-days" style="width:17px;height:17px;"></i><span class="tip">Calendrier équipe</span></a>
        <a href="#" class="side-link"><i data-lucide="check-square" style="width:17px;height:17px;"></i><span class="tip">Validation</span></a>
        <a href="#" class="side-link"><i data-lucide="file-bar-chart" style="width:17px;height:17px;"></i><span class="tip">Rapports</span></a>
        <a href="#" class="side-link"><i data-lucide="bar-chart-3" style="width:17px;height:17px;"></i><span class="tip">Statistiques</span></a>
        <a href="{{ route('profile.edit') }}" class="side-link active"><i data-lucide="user" style="width:17px;height:17px;"></i><span class="tip">Mon profil</span></a>
        <a href="#" class="side-link"><i data-lucide="settings" style="width:17px;height:17px;"></i><span class="tip">Paramètres</span></a>
      @else
        <a href="{{ route('dashboard') }}" class="side-link"><i data-lucide="layout-dashboard" style="width:17px;height:17px;"></i><span class="tip">Tableau de bord</span></a>
        <a href="#" class="side-link"><i data-lucide="file-text" style="width:17px;height:17px;"></i><span class="tip">Mes demandes</span></a>
        <a href="{{ route('conges.create') }}" class="side-link"><i data-lucide="plus-circle" style="width:17px;height:17px;"></i><span class="tip">Nouvelle demande</span></a>
        <a href="#" class="side-link"><i data-lucide="calendar-days" style="width:17px;height:17px;"></i><span class="tip">Calendrier</span></a>
        <a href="#" class="side-link"><i data-lucide="wallet" style="width:17px;height:17px;"></i><span class="tip">Mon solde</span></a>
        <a href="#" class="side-link"><i data-lucide="history" style="width:17px;height:17px;"></i><span class="tip">Historique</span></a>
        <a href="{{ route('profile.edit') }}" class="side-link active"><i data-lucide="user" style="width:17px;height:17px;"></i><span class="tip">Mon profil</span></a>
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

    <div class="topbar">
      <button class="icon-btn"><i data-lucide="bell" style="width:17px;height:17px;"></i>
        @if (($demandesEnAttente ?? 0) > 0)<span class="dot">{{ $demandesEnAttente }}</span>@endif
      </button>
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

    <div class="page-head">
      <h1>Mon profil</h1>
      <p>Gérez vos informations personnelles et votre compte.</p>
    </div>

    <!-- ===== CARTE PROFIL ===== -->
    <div class="profile-hero">
      <div class="panel hero-left">
        <form id="photoForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" style="display:contents;">
          @csrf
          @method('patch')
          <input type="hidden" name="name" value="{{ auth()->user()->name }}">
          <input type="hidden" name="email" value="{{ auth()->user()->email }}">
          <div class="avatar-wrap">
            <div class="hero-avatar">
              @if (auth()->user()->photo_path)
                <img id="avatarPreview" src="{{ asset('storage/'.auth()->user()->photo_path) }}" alt="">
              @else
                <i data-lucide="user-round" id="avatarInitials" style="width:76px; height:76px; color:#9CA3AF; stroke-width:1.5;"></i>
                <img id="avatarPreview" src="" alt="" style="display:none;">
              @endif
            </div>
            <input type="file" name="photo" id="photoInput" accept="image/png,image/jpeg,image/webp" style="display:none;">
            <button type="button" class="cam-btn" id="btnPhoto" title="Changer la photo"><i data-lucide="camera" style="width:18px;height:18px;"></i></button>
          </div>
        </form>
        <div>
          <div class="hero-name-row">
            <h2>{{ explode(' ', auth()->user()->name)[0] }}</h2>
            <span class="role-badge">{{ auth()->user()->role === 'rh' ? 'Responsable RH' : 'Employé' }}</span>
          </div>
          <div class="hero-meta">
            <div class="row"><i data-lucide="mail"></i> {{ auth()->user()->email }}</div>
            <div class="row"><i data-lucide="phone"></i> {{ auth()->user()->telephone ?? 'Non renseigné' }}</div>
            <div class="row"><i data-lucide="calendar"></i> Membre depuis {{ auth()->user()->created_at->translatedFormat('F Y') }}</div>
            <div class="row"><i data-lucide="map-pin"></i> {{ auth()->user()->lieu ?? 'Tétouan, Maroc' }}</div>
          </div>
        </div>
      </div>

      <div class="panel hero-right">
        <div class="dept-ico"><i data-lucide="building-2" style="width:20px;height:20px;"></i></div>
        <div>
          <h3>Mon département</h3>
          <b>{{ auth()->user()->departement ?? 'Non assigné' }}</b>
          <p>Vous faites partie du département {{ auth()->user()->departement ?? '—' }}.</p>
          <a href="#">Voir les membres du département <i data-lucide="arrow-right" style="width:12px;height:12px;"></i></a>
        </div>
      </div>
    </div>

    <!-- ===== INFORMATIONS + SECURITE (affichées en permanence, plus d'onglets) ===== -->
    <div class="info-security-grid">
      <div class="panel panel-pad">
        <div class="card-head">
          <h2><i data-lucide="user" style="width:16px;height:16px;"></i> Informations personnelles</h2>
          <button type="button" id="btnModifier"><i data-lucide="pencil" style="width:13px;height:13px;"></i> Modifier</button>
        </div>

        <!-- ===== MODE AFFICHAGE ===== -->
        <div id="infosView">
          <div class="info-row"><i data-lucide="user"></i><span class="lbl">Nom complet</span><span class="val">{{ auth()->user()->name }}</span></div>
          <div class="info-row"><i data-lucide="mail"></i><span class="lbl">Email professionnel</span><span class="val">{{ auth()->user()->email }}</span></div>
          <div class="info-row"><i data-lucide="phone"></i><span class="lbl">Téléphone</span><span class="val">{{ auth()->user()->telephone ?? '—' }}</span></div>
          <div class="info-row"><i data-lucide="briefcase"></i><span class="lbl">Poste</span><span class="val">{{ auth()->user()->poste ?? '—' }}</span></div>
          <div class="info-row"><i data-lucide="building-2"></i><span class="lbl">Département</span><span class="val">{{ auth()->user()->departement ?? '—' }}</span></div>
          <div class="info-row"><i data-lucide="id-card"></i><span class="lbl">CIN</span><span class="val">{{ auth()->user()->cin ?? '—' }}</span></div>
          <div class="info-row"><i data-lucide="cake"></i><span class="lbl">Date de naissance</span><span class="val">{{ auth()->user()->date_naissance ? \Carbon\Carbon::parse(auth()->user()->date_naissance)->format('d/m/Y') : '—' }}</span></div>
          <div class="info-row"><i data-lucide="map-pin"></i><span class="lbl">Lieu de naissance</span><span class="val">{{ auth()->user()->lieu_naissance ?? '—' }}</span></div>
          <div class="info-row"><i data-lucide="flag"></i><span class="lbl">Nationalité</span><span class="val">{{ auth()->user()->nationalite ?? '—' }}</span></div>
          <div class="info-row"><i data-lucide="home"></i><span class="lbl">Adresse</span><span class="val">{{ auth()->user()->adresse ?? '—' }}</span></div>
          <div class="info-row"><i data-lucide="heart"></i><span class="lbl">Situation familiale</span><span class="val">{{ auth()->user()->situation_familiale ?? '—' }}</span></div>
        </div>

        <!-- ===== MODE EDITION ===== -->
        <form id="infosEdit" method="POST" action="{{ route('profile.update') }}" style="display:none;">
          @csrf
          @method('patch')
          <div class="field-group"><label>Nom complet</label><input type="text" name="name" value="{{ auth()->user()->name }}"></div>
          <div class="field-group"><label>Email professionnel</label><input type="email" name="email" value="{{ auth()->user()->email }}"></div>
          <div class="field-group"><label>Téléphone</label><input type="text" name="telephone" value="{{ auth()->user()->telephone }}"></div>
          <div class="field-group"><label>Poste</label><input type="text" name="poste" value="{{ auth()->user()->poste }}"></div>
          <div class="field-group"><label>Département</label><input type="text" name="departement" value="{{ auth()->user()->departement }}"></div>
          <div class="field-group"><label>CIN</label><input type="text" name="cin" value="{{ auth()->user()->cin }}"></div>
          <div class="field-group"><label>Date de naissance</label><input type="date" name="date_naissance" value="{{ auth()->user()->date_naissance ? \Carbon\Carbon::parse(auth()->user()->date_naissance)->format('Y-m-d') : '' }}"></div>
          <div class="field-group"><label>Lieu de naissance</label><input type="text" name="lieu_naissance" value="{{ auth()->user()->lieu_naissance }}"></div>
          <div class="field-group"><label>Nationalité</label><input type="text" name="nationalite" value="{{ auth()->user()->nationalite }}"></div>
          <div class="field-group"><label>Adresse</label><input type="text" name="adresse" value="{{ auth()->user()->adresse }}"></div>
          <div class="field-group">
            <label>Situation familiale</label>
            <div class="custom-select" id="situationSelect">
              <button type="button" class="custom-select-btn" id="situationBtn">
                <span id="situationLabel">{{ auth()->user()->situation_familiale ?? '— Sélectionner —' }}</span>
                <i data-lucide="chevron-down" style="width:15px;height:15px;"></i>
              </button>
              <div class="custom-select-list" id="situationList">
                <div class="custom-select-option" data-value="">— Sélectionner —</div>
                @foreach (['Célibataire','Marié(e)','Divorcé(e)','Veuf/Veuve'] as $situation)
                  <div class="custom-select-option" data-value="{{ $situation }}">{{ $situation }}</div>
                @endforeach
              </div>
              <input type="hidden" name="situation_familiale" id="situationInput" value="{{ auth()->user()->situation_familiale }}">
            </div>
          </div>
          <div style="display:flex; gap:10px; margin-top:8px;">
            <button type="submit" class="btn-primary" style="margin-top:0;">Enregistrer</button>
            <button type="button" id="btnAnnuler" class="btn-secondary" style="margin-top:0;">Annuler</button>
          </div>
        </form>
      </div>

      <div class="panel panel-pad">
        <div class="card-head">
          <h2><i data-lucide="shield" style="width:16px;height:16px;"></i> Sécurité du compte</h2>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
          @csrf
          @method('put')
          <div class="field-group">
            <label>Mot de passe actuel</label>
            <div class="input-wrap">
              <input type="password" name="current_password" id="pwd1" placeholder="Entrez votre mot de passe actuel">
              <span class="toggle-eye" data-target="pwd1"><i data-lucide="eye"></i></span>
            </div>
            @error('current_password', 'updatePassword') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
          </div>
          <div class="field-group">
            <label>Nouveau mot de passe</label>
            <div class="input-wrap">
              <input type="password" name="password" id="pwd2" placeholder="Entrez le nouveau mot de passe">
              <span class="toggle-eye" data-target="pwd2"><i data-lucide="eye"></i></span>
            </div>
            @error('password', 'updatePassword') <span style="color:var(--red); font-size:11px;">{{ $message }}</span> @enderror
          </div>
          <div class="field-group">
            <label>Confirmer le nouveau mot de passe</label>
            <div class="input-wrap">
              <input type="password" name="password_confirmation" id="pwd3" placeholder="Confirmez le nouveau mot de passe">
              <span class="toggle-eye" data-target="pwd3"><i data-lucide="eye"></i></span>
            </div>
          </div>
          <button type="submit" class="btn-primary">Enregistrer le nouveau mot de passe</button>
        </form>

        <div class="danger-zone">
          <h3>Supprimer mon compte</h3>
          <p>Cette action est irréversible. Toutes vos données seront supprimées.</p>
          <button type="button" class="btn-danger" onclick="document.getElementById('deleteAccountForm').submit();">
            <i data-lucide="trash-2" style="width:14px;height:14px;"></i> Supprimer mon compte
          </button>
          <form id="deleteAccountForm" method="POST" action="{{ route('profile.destroy') }}" style="display:none;">
            @csrf
            @method('delete')
          </form>
        </div>
      </div>
    </div>

    <div class="page-footer">
      <span>© {{ date('Y') }} Naja7Host. Tous droits réservés.</span>
      <span class="badge-live"><span class="dot-live"></span> Plateforme RH intelligente</span>
    </div>

  </main>
</div>

<script>
  lucide.createIcons();

  document.querySelectorAll('.sidebar a[href="#"]').forEach(lien => {
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

  /* ===== MENU DEROULANT PERSONNALISE (situation familiale) ===== */
  const situationBtn = document.getElementById('situationBtn');
  const situationList = document.getElementById('situationList');
  const situationInput = document.getElementById('situationInput');
  const situationLabel = document.getElementById('situationLabel');

  situationBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    situationList.classList.toggle('open');
    situationBtn.classList.toggle('open');
  });

  situationList.querySelectorAll('.custom-select-option').forEach(opt => {
    if (opt.dataset.value === situationInput.value) opt.classList.add('selected');
    opt.addEventListener('click', () => {
      situationInput.value = opt.dataset.value;
      situationLabel.textContent = opt.textContent;
      situationList.querySelectorAll('.custom-select-option').forEach(o => o.classList.remove('selected'));
      opt.classList.add('selected');
      situationList.classList.remove('open');
      situationBtn.classList.remove('open');
    });
  });

  document.addEventListener('click', () => {
    situationList.classList.remove('open');
    situationBtn.classList.remove('open');
  });

  /* ===== MODIFIER / ANNULER LES INFOS ===== */
  const infosView = document.getElementById('infosView');
  const infosEdit = document.getElementById('infosEdit');
  const btnModifier = document.getElementById('btnModifier');
  const btnAnnuler = document.getElementById('btnAnnuler');

  btnModifier.addEventListener('click', () => {
    infosView.style.display = 'none';
    infosEdit.style.display = 'block';
  });
  btnAnnuler.addEventListener('click', () => {
    infosEdit.style.display = 'none';
    infosView.style.display = 'block';
  });

  /* ===== UPLOAD PHOTO DE PROFIL ===== */
  const btnPhoto = document.getElementById('btnPhoto');
  const photoInput = document.getElementById('photoInput');
  const photoForm = document.getElementById('photoForm');

  btnPhoto.addEventListener('click', () => photoInput.click());
  photoInput.addEventListener('change', () => {
    if (photoInput.files && photoInput.files[0]) {
      photoForm.submit();
    }
  });

  /* ===== AFFICHER / MASQUER LES MOTS DE PASSE ===== */
  document.querySelectorAll('.toggle-eye').forEach(wrap => {
    wrap.addEventListener('click', () => {
      const input = document.getElementById(wrap.dataset.target);
      const showing = input.type === 'text';
      input.type = showing ? 'password' : 'text';
      wrap.innerHTML = `<i data-lucide="${showing ? 'eye' : 'eye-off'}"></i>`;
      lucide.createIcons();
    });
  });
</script>
</body>
</html>