<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Demandes de congé — NAJA7 HOST</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<style>
  :root{
    --blue:#3B82F6; --blue-2:#60A5FA;
    --orange:#F59E0B; --amber:#FBBF24; --green:#10B981; --red:#EF4444; --purple:#8B5CF6;
    --bg:#05070F; --panel:rgba(18,24,42,.55); --panel-2:rgba(255,255,255,.06);
    --border:rgba(255,255,255,.12);
    --text:#F1F4FA; --text-dim:#C3CCE0;
    --radius:22px; --glass-blur:22px;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  html, body{height:100%; overflow-x:hidden;}
  body{
    font-family:'Poppins',sans-serif; color:var(--text); -webkit-font-smoothing:antialiased;
    background:
      linear-gradient(180deg, rgba(4,6,14,.72), rgba(4,6,14,.88)),
      url('{{ asset('images/dashboard-bg.jpg') }}') center/cover no-repeat fixed;
  }
  a{text-decoration:none; color:inherit;}
  button{font-family:inherit; cursor:pointer; border:none; background:none; color:inherit;}
  select, input{font-family:inherit;}

  .app{display:flex; align-items:flex-start; min-height:100vh; padding:16px 24px; gap:16px; max-width:1500px; margin:0 auto; overflow-x:hidden;}

  /* ===== SIDEBAR (identique au reste de l'app) ===== */
  .sidebar{width:64px; flex:none; align-self:flex-start; position:sticky; top:16px; z-index:100; background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:32px; padding:14px 0 16px; display:flex; flex-direction:column; align-items:center; box-shadow:0 8px 32px rgba(0,0,0,.35); max-height:94vh;}
  .side-logo{width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; margin-bottom:12px; font-weight:700; font-size:15px; color:#fff; overflow:hidden; flex:none;}
  .side-logo img{width:100%; height:100%; object-fit:cover;}
  .side-nav{display:flex; flex-direction:column; gap:3px; flex:1;}
  .side-link{position:relative; width:36px; height:36px; border-radius:11px; display:flex; align-items:center; justify-content:center; color:var(--text-dim); flex:none;}
  .side-link:hover{background:rgba(255,255,255,.08); color:#fff;}
  .side-link.active{background:var(--orange); color:#fff;}
  .side-link .tip{position:absolute; left:48px; top:50%; transform:translateY(-50%); background:rgba(20,26,46,.92); backdrop-filter:blur(10px); padding:6px 12px; border-radius:8px; font-size:12px; white-space:nowrap; opacity:0; pointer-events:none; transition:opacity .15s; z-index:30; border:1px solid var(--border);}
  .side-link:hover .tip{opacity:1;}
  .side-link:focus .tip{opacity:1;}
  .side-bottom{display:flex; flex-direction:column; gap:4px; padding-top:8px; margin-top:6px; border-top:1px solid var(--border); align-items:center; flex:none;}

  /* ===== MAIN ===== */
  .main{flex:1; align-self:stretch; padding:6px 6px 40px; max-width:100%; overflow-x:hidden;}

  /* ===== HEADER ===== */
  .header{display:flex; align-items:center; justify-content:space-between; margin-bottom:22px; flex-wrap:wrap; gap:14px;}
  .header-left h1{position:relative; font-size:16px; font-weight:800; color:#fff; display:inline-flex; align-items:center; gap:8px;
    padding:12px 28px; background:linear-gradient(180deg,#3D7BFF 0%,#1E4FC4 55%,#123591 100%); border-radius:999px;
    box-shadow:0 6px 14px rgba(23,73,176,.5), inset 0 2px 0 rgba(255,255,255,.4), inset 0 -4px 8px rgba(0,0,0,.3);}
  .header-left p{color:var(--text-dim); font-size:13.5px; margin-top:4px; text-shadow:0 2px 8px rgba(0,0,0,.5); max-width:520px;}
  .header-right{display:flex; align-items:center; gap:12px;}

  .search-box{width:260px; height:40px; display:flex; align-items:center; gap:8px; background:var(--panel); border:1px solid var(--border); border-radius:10px; padding:0 12px;}
  .search-box input{flex:1; border:none; outline:none; background:transparent; color:#fff; font-size:14px;}
  .search-box input::placeholder{color:var(--text-dim);}

  .icon-btn{position:relative; width:38px; height:38px; border-radius:12px; background:var(--panel); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; flex:none;}
  .icon-btn .dot{position:absolute; top:-3px; right:-3px; background:var(--red); color:#fff; font-size:9px; font-weight:700; width:16px; height:16px; border-radius:50%; display:flex; align-items:center; justify-content:center;}
  .avatar{width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; overflow:hidden; flex:none;}
  .avatar img{width:100%; height:100%; object-fit:cover; object-position:center top;}

  /* ===== LAYOUT ===== */
  .layout{display:grid; grid-template-columns:1fr 320px; gap:18px; align-items:start;}
  .layout > .panel{min-width:0;}
  @media (max-width:1050px){ .layout{grid-template-columns:1fr;} }

  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25);}

  /* ===== TABS ===== */
  .tabs{display:flex; gap:8px; padding:22px 22px 8px; flex-wrap:nowrap;}
  .hex-item{position:relative; display:flex; align-items:center; text-decoration:none; flex:1; min-width:0;}
  .hex-num{width:32px; height:32px; border-radius:50%; background:var(--c); color:#fff; font-weight:800; font-size:13px;
    display:flex; align-items:center; justify-content:center; flex:none; z-index:2; box-shadow:0 4px 10px rgba(0,0,0,.35); border:2px solid #0c1120;}
  .hex-card{margin-left:-14px; background:var(--panel-2); border:1.5px solid var(--c); clip-path:polygon(20% 0,100% 0,100% 100%,20% 100%,0 50%);
    padding:9px 12px 9px 24px; display:flex; align-items:center; gap:7px; flex:1; min-width:0; transition:background .15s;}
  .hex-card .ico{width:22px; height:22px; border-radius:50%; background:#0c1120; display:flex; align-items:center; justify-content:center; color:var(--c); flex:none;}
  .hex-card .txt{display:flex; flex-direction:column; line-height:1.2; min-width:0; overflow:hidden;}
  .hex-card .txt b{font-size:12px; color:#fff; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
  .hex-card .txt span{font-size:10px; color:var(--text-dim); white-space:nowrap;}
  .hex-item.active .hex-card{background:var(--c);}
  .hex-item.active .hex-card .ico{background:rgba(255,255,255,.25); color:#fff;}
  .hex-item.active .hex-card .txt b, .hex-item.active .hex-card .txt span{color:#fff;}
  .hex-item:hover .hex-card{filter:brightness(1.12);}

  /* ===== FILTRES ===== */
  .filters{display:flex; gap:8px; padding:16px 18px 12px; flex-wrap:nowrap; align-items:center;}
  .filters select{background:#141b30; border:1px solid var(--border); color:#fff; font-size:14px; padding:9px 10px; border-radius:10px; flex:1; min-width:0;}
  .sort-wrap{position:relative; flex:1.3; min-width:0;}
  .sort-trigger{width:100%; justify-content:flex-start; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;}
  .filters .reset{flex:none; white-space:nowrap;}
  .filters .reset{margin-left:auto; position:relative; overflow:hidden; font-size:13px; font-weight:700; color:#fff; display:flex; align-items:center; gap:6px; padding:9px 16px; border-radius:999px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .filters .reset:hover{transform:translateY(-1px);}

  /* ===== TRI (pilule + menu déroulant) ===== */
  .sort-wrap{position:relative;}
  .sort-trigger{background:#141b30; border:1px solid var(--border); color:#fff; font-size:13.5px; font-weight:600; display:inline-flex; align-items:center; gap:8px; padding:9px 16px; border-radius:999px;}
  .sort-trigger:hover{background:#182140;}
  .sort-trigger .chev{color:var(--text-dim); margin-left:2px; transition:transform .15s;}
  .sort-wrap.open .sort-trigger .chev{transform:rotate(180deg);}
  .sort-menu{position:absolute; top:calc(100% + 8px); left:0; background:#161c30; border:1px solid var(--border); border-radius:14px; padding:8px; width:230px; box-shadow:0 14px 32px rgba(0,0,0,.45); display:none; z-index:70;}
  .sort-wrap.open .sort-menu{display:block;}
  .sort-item{display:flex; align-items:center; gap:10px; padding:9px 10px; border-radius:10px; font-size:13px; color:#fff;}
  .sort-item:hover{background:rgba(255,255,255,.06);}
  .sort-item.active{color:var(--purple); font-weight:600;}
  .sort-item .ico{color:var(--text-dim); flex:none;}
  .sort-item.active .ico{color:var(--purple);}
  .sort-item .check{margin-left:auto; color:var(--purple); flex:none;}

  /* ===== GROUPES DE DEMANDES ===== */
  .group{padding:6px 18px 18px;}
  .group-title{display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; text-transform:uppercase; letter-spacing:.04em; margin:16px 0 10px;}
  .group-title .tag{width:8px; height:8px; border-radius:50%;}
  .title-attente{color:var(--orange);} .tag-attente{background:var(--orange);}
  .title-avalider{color:var(--amber);} .tag-avalider{background:var(--amber);}
  .title-approuve{color:var(--green);} .tag-approuve{background:var(--green);}
  .title-refuse{color:var(--red);} .tag-refuse{background:var(--red);}

  .demande-row{display:flex; align-items:center; gap:14px; padding:13px 14px; border-radius:16px; margin-bottom:8px; background:var(--panel-2); flex-wrap:wrap;}
  .demande-row .emp{display:flex; align-items:center; gap:10px; width:190px; flex:none;}
  .emp-avatar{width:34px; height:34px; border-radius:50%; background:var(--blue); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex:none;}
  .emp-info b{display:block; font-size:16px;}
  .emp-info span{font-size:13.5px; color:var(--text-dim);}

  .demande-dates{width:150px; flex:none; font-size:15px;}
  .demande-dates span{display:block; font-size:13.5px; color:var(--text-dim); margin-top:1px;}

  .demande-type{width:150px; flex:none; font-size:15px; display:flex; align-items:center; gap:6px;}

  .badge{display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:20px; font-size:13px; font-weight:600; flex:none;}
  .badge-approved{background:rgba(16,185,129,.15); color:var(--green);}
  .badge-pending{background:rgba(245,158,11,.15); color:var(--orange);}
  .badge-avalider{background:rgba(251,191,36,.15); color:var(--amber);}
  .badge-rejected{background:rgba(239,68,68,.15); color:var(--red);}

  .demande-solde{width:90px; flex:none; font-size:14.5px; color:var(--text-dim);}

  .demande-actions{margin-left:auto; display:flex; gap:8px; flex:none;}
  .btn-approve{background:rgba(16,185,129,.15); color:var(--green); font-size:13.5px; font-weight:700; padding:7px 13px; border-radius:9px;}
  .btn-reject{background:rgba(239,68,68,.15); color:var(--red); font-size:13.5px; font-weight:700; padding:7px 13px; border-radius:9px;}
  .btn-approve:hover, .btn-reject:hover{filter:brightness(1.2);}
  .btn-voir{background:var(--panel-2); color:var(--text-dim); font-size:12px; font-weight:600; padding:7px 13px; border-radius:9px; display:inline-flex; align-items:center; gap:5px;}
  .btn-voir:hover{color:#fff; background:rgba(255,255,255,.1);}

  .empty-state{text-align:center; padding:40px 0; color:var(--text-dim);}
  .empty-state .ico{width:44px; height:44px; border-radius:50%; background:rgba(255,255,255,.06); display:flex; align-items:center; justify-content:center; margin:0 auto 10px;}

  /* ===== SIDEBAR DROITE ===== */
  .side-panel{padding:20px;}
  .side-panel h3{position:relative; font-size:14px; font-weight:800; color:#fff; display:inline-flex; align-items:center; gap:8px;
    padding:11px 22px; background:linear-gradient(180deg,#3D7BFF 0%,#1E4FC4 55%,#123591 100%); border-radius:999px;
    box-shadow:0 6px 14px rgba(23,73,176,.5), inset 0 2px 0 rgba(255,255,255,.4), inset 0 -4px 8px rgba(0,0,0,.3);}
  .side-panel .head-row{display:flex; align-items:center; justify-content:space-between; margin-bottom:6px;}
  .side-panel .head-row a{position:relative; overflow:hidden; font-size:11.5px; font-weight:700; color:#fff; display:inline-flex; align-items:center; padding:6px 13px; border-radius:999px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 5px 13px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .side-panel .head-row a:hover{transform:translateY(-1px);}

  /* ===== APERÇU RADIAL (anneau + 4 badges aux coins) ===== */
  .apercu-wrap{position:relative; width:100%; max-width:330px; aspect-ratio:1 / 1; margin:12px auto 8px;}
  .apercu-center{position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); width:44%; height:44%; border-radius:50%;
    display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; pointer-events:none;
    background:radial-gradient(circle at 50% 40%, rgba(245,158,11,.16), rgba(18,24,42,.4) 70%);
    border:1px solid rgba(255,255,255,.1); box-shadow:inset 0 0 34px rgba(245,158,11,.12), 0 0 46px rgba(245,158,11,.08);}
  .apercu-center b{display:block; font-size:42px; font-weight:800; color:#fff; text-shadow:0 0 26px rgba(245,158,11,.4);}
  .apercu-center span{font-size:12px; font-weight:600; color:#fff; opacity:.8; margin-top:3px; letter-spacing:.02em;}
  .apercu-badge{position:absolute; width:31%; background:linear-gradient(160deg, rgba(255,255,255,.07), rgba(255,255,255,.02)); border:1px solid rgba(255,255,255,.09); border-radius:14px; padding:11px 8px 10px; text-align:center; box-shadow:0 6px 16px rgba(0,0,0,.3); overflow:hidden;}
  .apercu-badge::before{content:''; position:absolute; top:0; left:0; right:0; height:2.5px; background:var(--orange);}
  .apercu-badge .ico{width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 6px; background:rgba(245,158,11,.18); color:var(--orange); box-shadow:0 0 14px rgba(245,158,11,.4);}
  .apercu-badge b{display:block; font-size:19px; font-weight:800; color:#fff; line-height:1.1;}
  .apercu-badge span{font-size:11px; font-weight:600; color:#fff; opacity:.75;}
  .apercu-badge.nw{top:0; left:0;}
  .apercu-badge.ne{top:0; right:0;}
  .apercu-badge.sw{bottom:0; left:0;}
  .apercu-badge.se{bottom:0; right:0;}

  @keyframes apercu-pulse{
    0%, 100% { opacity:1; }
    50% { opacity:.55; }
  }

  .stat-mini-grid{display:grid; grid-template-columns:1fr 1fr; gap:8px; margin-top:10px;}
  .stat-mini{background:var(--panel-2); border-radius:12px; padding:10px; text-align:center;}
  .stat-mini b{display:block; font-size:16px; font-weight:700;}
  .stat-mini span{font-size:9.5px; color:var(--text-dim);}

  /* ===== ALERTES ===== */
  .alert-item{display:flex; align-items:flex-start; gap:10px; padding:12px 0; border-bottom:1px solid var(--border);}
  .alert-item:last-child{border-bottom:none;}
  .alert-item .ico{width:32px; height:32px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex:none;}
  .alert-item b{display:block; font-size:15.5px; margin-bottom:2px;}
  .alert-item p{font-size:14px; color:var(--text-dim); line-height:1.4;}
  .alert-item .count{margin-left:auto; font-size:14px; font-weight:700; color:var(--text-dim); flex:none;}
  .alert-empty{font-size:14.5px; color:var(--text-dim); text-align:center; padding:14px 0;}

  @media (max-width:800px){ .sidebar{display:none;} }
  @media (max-width:700px){ .demande-actions{margin-left:0; width:100%; justify-content:flex-end;} }
</style>
@livewireStyles
</head>
<body>

<div class="app">

  <!-- ===== SIDEBAR ===== -->
  <aside class="sidebar">
    <div class="side-logo">
      <img src="{{ asset('images/logo-naja7host.png') }}" alt="NAJA7HOST">
    </div>

    <nav class="side-nav">
      <a href="{{ route('dashboard') }}" class="side-link"><i data-lucide="home" style="width:17px;height:17px;"></i><span class="tip">Tableau de bord</span></a>
      <a href="#" class="side-link"><i data-lucide="calendar-heart" style="width:17px;height:17px;"></i><span class="tip">Congés &amp; Absences</span></a>
      <a href="{{ route('conges.index') }}" class="side-link active"><i data-lucide="file-text" style="width:17px;height:17px;"></i><span class="tip">Demandes</span></a>
      <a href="#" class="side-link"><i data-lucide="users" style="width:17px;height:17px;"></i><span class="tip">Employés</span></a>
      <a href="#" class="side-link"><i data-lucide="calendar-days" style="width:17px;height:17px;"></i><span class="tip">Calendrier équipe</span></a>
      <a href="{{ route('conges.index') }}" class="side-link"><i data-lucide="check-square" style="width:17px;height:17px;"></i><span class="tip">Validation</span></a>
      <a href="#" class="side-link"><i data-lucide="file-bar-chart" style="width:17px;height:17px;"></i><span class="tip">Rapports</span></a>
      <a href="#" class="side-link"><i data-lucide="bar-chart-3" style="width:17px;height:17px;"></i><span class="tip">Statistiques</span></a>
      <a href="{{ route('profile.edit') }}" class="side-link"><i data-lucide="user" style="width:17px;height:17px;"></i><span class="tip">Mon profil</span></a>
      <a href="#" class="side-link"><i data-lucide="settings" style="width:17px;height:17px;"></i><span class="tip">Paramètres</span></a>
    </nav>

    <div class="side-bottom">
      <a href="#" class="side-link"><i data-lucide="headphones" style="width:16px;height:16px;"></i><span class="tip">Support RH</span></a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="side-link"><i data-lucide="log-out" style="width:16px;height:16px;"></i><span class="tip">Déconnexion</span></button>
      </form>
    </div>
  </aside>

  <!-- ===== MAIN ===== -->
  <main class="main">

    <!-- ===== HEADER ===== -->
    <div class="header">
      <div class="header-left">
        <h1>Demandes de congé</h1>
        <p>Gérez, suivez et validez les demandes de congé de vos collaborateurs</p>
      </div>
      <div class="header-right">
        <div class="search-box">
          <i data-lucide="search" style="width:15px;height:15px; color:var(--text-dim);"></i>
          <form method="GET" action="{{ route('conges.index') }}" style="flex:1; display:flex;">
            <input type="text" name="q" value="{{ $recherche }}" placeholder="Rechercher un employé...">
          </form>
        </div>
        <button class="icon-btn"><i data-lucide="bell" style="width:16px;height:16px;"></i>
          @if ($countAValider > 0)<span class="dot">{{ $countAValider }}</span>@endif
        </button>
        <div class="avatar">
          @if (auth()->user()->photo_path)
            <img src="{{ asset('storage/'.auth()->user()->photo_path) }}" alt="">
          @else
            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
          @endif
        </div>
      </div>
    </div>

    <div class="layout">

      <!-- ===== COLONNE PRINCIPALE ===== -->
      <div class="panel">

        <div class="tabs">
          <a href="{{ route('conges.index', array_filter(['departement'=>$departement,'type'=>$type,'q'=>$recherche])) }}"
             class="hex-item {{ !$statut || $statut === 'toutes' ? 'active' : '' }}" style="--c:var(--orange);">
            <span class="hex-num">1</span>
            <span class="hex-card"><span class="ico"><i data-lucide="list" style="width:13px;height:13px;"></i></span>
              <span class="txt"><b>Toutes</b><span>{{ $toutes }} demande{{ $toutes > 1 ? 's' : '' }}</span></span></span>
          </a>
          <a href="{{ route('conges.index', array_filter(['statut'=>'en_attente','departement'=>$departement,'type'=>$type,'q'=>$recherche])) }}"
             class="hex-item {{ $statut === 'en_attente' ? 'active' : '' }}" style="--c:var(--orange);">
            <span class="hex-num">2</span>
            <span class="hex-card"><span class="ico"><i data-lucide="hourglass" style="width:13px;height:13px;"></i></span>
              <span class="txt"><b>En attente</b><span>{{ $countEnAttente }} demande{{ $countEnAttente > 1 ? 's' : '' }}</span></span></span>
          </a>
          <a href="{{ route('conges.index', array_filter(['statut'=>'a_valider','departement'=>$departement,'type'=>$type,'q'=>$recherche])) }}"
             class="hex-item {{ $statut === 'a_valider' ? 'active' : '' }}" style="--c:var(--orange);">
            <span class="hex-num">3</span>
            <span class="hex-card"><span class="ico"><i data-lucide="clock" style="width:13px;height:13px;"></i></span>
              <span class="txt"><b>À valider</b><span>{{ $countAValider }} demande{{ $countAValider > 1 ? 's' : '' }}</span></span></span>
          </a>
          <a href="{{ route('conges.index', array_filter(['statut'=>'approuve','departement'=>$departement,'type'=>$type,'q'=>$recherche])) }}"
             class="hex-item {{ $statut === 'approuve' ? 'active' : '' }}" style="--c:var(--orange);">
            <span class="hex-num">4</span>
            <span class="hex-card"><span class="ico"><i data-lucide="check" style="width:13px;height:13px;"></i></span>
              <span class="txt"><b>Approuvées</b><span>{{ $countApprouvees }} demande{{ $countApprouvees > 1 ? 's' : '' }}</span></span></span>
          </a>
          <a href="{{ route('conges.index', array_filter(['statut'=>'refuse','departement'=>$departement,'type'=>$type,'q'=>$recherche])) }}"
             class="hex-item {{ $statut === 'refuse' ? 'active' : '' }}" style="--c:var(--orange);">
            <span class="hex-num">5</span>
            <span class="hex-card"><span class="ico"><i data-lucide="x" style="width:13px;height:13px;"></i></span>
              <span class="txt"><b>Refusées</b><span>{{ $countRefusees }} demande{{ $countRefusees > 1 ? 's' : '' }}</span></span></span>
          </a>
        </div>

        <form method="GET" action="{{ route('conges.index') }}" class="filters">
          @if ($statut) <input type="hidden" name="statut" value="{{ $statut }}"> @endif

          <select name="departement" onchange="this.form.submit()">
            <option value="">Tous les départements</option>
            @foreach ($departements as $dep)
              <option value="{{ $dep }}" @selected($departement === $dep)>{{ $dep }}</option>
            @endforeach
          </select>

          <select name="type" onchange="this.form.submit()">
            <option value="">Tous les types</option>
            <option value="paye" @selected($type === 'paye')>Congé payé</option>
            <option value="maladie" @selected($type === 'maladie')>Congé maladie</option>
            <option value="sans_solde" @selected($type === 'sans_solde')>Congé sans solde</option>
          </select>

          <div class="sort-wrap" id="sortWrap">
            <button type="button" class="sort-trigger" id="sortTrigger">
              <i data-lucide="arrow-up-down" style="width:14px;height:14px;"></i>
              Trier par : {{ $triOptions[$tri] ?? 'Date (plus récente)' }}
              <i data-lucide="chevron-down" class="chev" style="width:14px;height:14px;"></i>
            </button>
            <div class="sort-menu" id="sortMenu">
              @foreach ($triOptions as $valeur => $libelle)
                @php
                  $icone = str_starts_with($valeur, 'date') ? 'calendar' : (str_starts_with($valeur, 'statut') ? 'flag' : 'tag');
                @endphp
                <a href="{{ route('conges.index', array_filter(array_merge(request()->except('page'), ['tri' => $valeur]))) }}"
                   class="sort-item {{ $tri === $valeur ? 'active' : '' }}">
                  <i data-lucide="{{ $icone }}" class="ico" style="width:14px;height:14px;"></i>
                  {{ $libelle }}
                  @if ($tri === $valeur)
                    <i data-lucide="check" class="check" style="width:14px;height:14px;"></i>
                  @endif
                </a>
              @endforeach
            </div>
          </div>

          <a href="{{ route('conges.index') }}" class="reset"><i data-lucide="rotate-ccw" style="width:13px;height:13px;"></i> Réinitialiser</a>
        </form>

        @if (session('success'))
          <div style="margin:0 18px 10px; padding:10px 14px; border-radius:10px; background:rgba(16,185,129,.15); color:var(--green); font-size:12.5px;">{{ session('success') }}</div>
        @endif
        @if (session('error'))
          <div style="margin:0 18px 10px; padding:10px 14px; border-radius:10px; background:rgba(239,68,68,.15); color:var(--red); font-size:12.5px;">{{ session('error') }}</div>
        @endif

        @php
          $libelles = ['paye' => 'Congé payé', 'maladie' => 'Congé maladie', 'sans_solde' => 'Congé sans solde'];
          $sections = [
            'en_attente' => ['label' => 'En attente', 'title' => 'title-attente', 'tag' => 'tag-attente', 'badge' => 'badge-pending', 'statutLabel' => 'En attente'],
            'a_valider'  => ['label' => 'À valider', 'title' => 'title-avalider', 'tag' => 'tag-avalider', 'badge' => 'badge-avalider', 'statutLabel' => 'À valider'],
            'approuve'   => ['label' => 'Approuvées', 'title' => 'title-approuve', 'tag' => 'tag-approuve', 'badge' => 'badge-approved', 'statutLabel' => 'Approuvée'],
            'refuse'     => ['label' => 'Refusées', 'title' => 'title-refuse', 'tag' => 'tag-refuse', 'badge' => 'badge-rejected', 'statutLabel' => 'Refusée'],
          ];
        @endphp

        <div class="group">
          @foreach ($sections as $cle => $section)
            @if ($demandes->has($cle) && $demandes[$cle]->count() > 0)
              <div class="group-title {{ $section['title'] }}"><span class="tag {{ $section['tag'] }}"></span> {{ $section['label'] }} ({{ $demandes[$cle]->count() }})</div>

              @foreach ($demandes[$cle] as $demande)
                <div class="demande-row">
                  <div class="emp">
                    <span class="emp-avatar">{{ strtoupper(substr($demande->user->name ?? '?',0,1)) }}</span>
                    <div class="emp-info">
                      <b>{{ $demande->user->name ?? 'Employé supprimé' }}</b>
                      <span>{{ $demande->user->poste ?? '' }}</span>
                    </div>
                  </div>
                  <div class="demande-dates">
                    {{ $demande->date_debut->format('d M') }} - {{ $demande->date_fin->format('d M Y') }}
                    <span>{{ $demande->jours }} jours</span>
                  </div>
                  <div class="demande-type">
                    {{ $libelles[$demande->type] ?? $demande->type }}
                    @if ($demande->user->departement ?? false)
                      <span style="color:var(--text-dim); font-size:10.5px;">· {{ $demande->user->departement }}</span>
                    @endif
                  </div>
                  <span class="badge {{ $section['badge'] }}">{{ $section['statutLabel'] }}</span>
                  <div class="demande-solde">{{ $demande->user->solde_conges_annuel ?? '—' }} j restants</div>

                  <div class="demande-actions">
                    <a href="{{ route('conges.show', $demande->id) }}" class="btn-voir"><i data-lucide="eye" style="width:13px;height:13px;"></i> Voir la demande</a>
                    @if ($demande->statut === 'en_attente')
                      <form method="POST" action="{{ route('conges.approve', $demande->id) }}">
                        @csrf
                        <button type="submit" class="btn-approve">Approuver</button>
                      </form>
                      <form method="POST" action="{{ route('conges.reject', $demande->id) }}">
                        @csrf
                        <button type="submit" class="btn-reject">Refuser</button>
                      </form>
                    @endif
                  </div>
                </div>
              @endforeach
            @endif
          @endforeach

          @if ($demandes->isEmpty() || $demandes->every(fn($g) => $g->count() === 0))
            <div class="empty-state">
              <div class="ico"><i data-lucide="inbox" style="width:20px;height:20px;"></i></div>
              <p style="font-size:15px; font-weight:600; color:#fff; margin-bottom:2px;">Aucune demande trouvée</p>
              <p style="font-size:13px;">Essaie de modifier tes filtres.</p>
            </div>
          @endif
        </div>
      </div>

      <!-- ===== SIDEBAR DROITE ===== -->
      <div style="display:flex; flex-direction:column; gap:16px;">

        <!-- ===== Aperçu des congés (style radial) ===== -->
        <div class="panel side-panel">
          <div class="head-row"><h3>Aperçu des congés</h3></div>

          @php
            $totalPourPourcentage = max($toutes, 1);
            $rayon = 110;
            $circonf = 2 * pi() * $rayon;
            $pctEnAttente = $countEnAttente / $totalPourPourcentage;
            $pctAValider  = $countAValider / $totalPourPourcentage;
            $pctApprouve  = $countApprouvees / $totalPourPourcentage;
            $pctRefuse    = $countRefusees / $totalPourPourcentage;
          @endphp

          <div class="apercu-wrap">
            <svg viewBox="0 0 320 320" preserveAspectRatio="xMidYMid meet" style="position:absolute; top:0; left:0; width:100%; height:100%;">
              <defs>
                <filter id="apercuGlow" x="-60%" y="-60%" width="220%" height="220%">
                  <feGaussianBlur stdDeviation="5" result="blur" />
                  <feMerge>
                    <feMergeNode in="blur" />
                    <feMergeNode in="SourceGraphic" />
                  </feMerge>
                </filter>
                <radialGradient id="apercuBg" cx="50%" cy="42%" r="65%">
                  <stop offset="0%" stop-color="#F59E0B" stop-opacity="0.12" />
                  <stop offset="100%" stop-color="#F59E0B" stop-opacity="0" />
                </radialGradient>
              </defs>

              <!-- halo de fond -->
              <circle cx="160" cy="160" r="150" fill="url(#apercuBg)" />

              <!-- lignes de connexion vers les badges (orange uniquement) -->
              <line x1="85" y1="85" x2="45" y2="42" stroke="rgba(245,158,11,.4)" stroke-width="1.5" filter="url(#apercuGlow)" />
              <line x1="235" y1="85" x2="275" y2="42" stroke="rgba(245,158,11,.4)" stroke-width="1.5" filter="url(#apercuGlow)" />
              <line x1="85" y1="235" x2="45" y2="278" stroke="rgba(245,158,11,.4)" stroke-width="1.5" filter="url(#apercuGlow)" />
              <line x1="235" y1="235" x2="275" y2="278" stroke="rgba(245,158,11,.4)" stroke-width="1.5" filter="url(#apercuGlow)" />

              <!-- piste de fond de l'anneau, bien visible même sans données -->
              <circle cx="160" cy="160" r="{{ $rayon }}" fill="none" stroke="rgba(255,255,255,.12)" stroke-width="18" />
              <circle cx="160" cy="160" r="{{ $rayon }}" fill="none" stroke="rgba(245,158,11,.18)" stroke-width="18" stroke-dasharray="2 10" stroke-linecap="round" />

              <!-- anneau (segments réels, uniquement si valeur > 0, tous en orange) -->
              <g transform="rotate(-90 160 160)">
                @if ($toutes > 0)
                  <circle cx="160" cy="160" r="{{ $rayon }}" fill="none" stroke="var(--orange)" stroke-width="18" stroke-linecap="round"
                    stroke-dasharray="{{ $circonf }} {{ $circonf }}" filter="url(#apercuGlow)" />
                @endif
              </g>

              <!-- points sur l'anneau, avec halo et pulsation douce (orange uniquement) -->
              <circle cx="85" cy="85" r="6" fill="var(--orange)" filter="url(#apercuGlow)" style="animation:apercu-pulse 2.6s ease-in-out infinite;" />
              <circle cx="235" cy="85" r="6" fill="var(--orange)" filter="url(#apercuGlow)" style="animation:apercu-pulse 2.6s ease-in-out .3s infinite;" />
              <circle cx="85" cy="235" r="6" fill="var(--orange)" filter="url(#apercuGlow)" style="animation:apercu-pulse 2.6s ease-in-out .6s infinite;" />
              <circle cx="235" cy="235" r="6" fill="var(--orange)" filter="url(#apercuGlow)" style="animation:apercu-pulse 2.6s ease-in-out .9s infinite;" />
            </svg>

            <div class="apercu-center"><b>{{ $toutes }}</b><span>demandes globales</span></div>

            <div class="apercu-badge nw">
              <span class="ico"><i data-lucide="hourglass" style="width:17px;height:17px;"></i></span>
              <b>{{ $countEnAttente }}</b><span>En attente</span>
            </div>
            <div class="apercu-badge ne">
              <span class="ico"><i data-lucide="clock" style="width:17px;height:17px;"></i></span>
              <b>{{ $countAValider }}</b><span>À valider</span>
            </div>
            <div class="apercu-badge sw">
              <span class="ico"><i data-lucide="check" style="width:17px;height:17px;"></i></span>
              <b>{{ $countApprouvees }}</b><span>Approuvées</span>
            </div>
            <div class="apercu-badge se">
              <span class="ico"><i data-lucide="x" style="width:17px;height:17px;"></i></span>
              <b>{{ $countRefusees }}</b><span>Refusées</span>
            </div>
          </div>
        </div>

        <!-- ===== Alertes & conflits ===== -->
        <div class="panel side-panel">
          <div class="head-row"><h3>Alertes &amp; conflits</h3><a href="#">Voir tout</a></div>

          @if ($nombreConflits === 0 && $soldeFaibleCount === 0 && $congesLongsCount === 0)
            <div class="alert-empty">Aucune alerte pour le moment.</div>
          @else
            @if ($nombreConflits > 0)
              <div class="alert-item">
                <span class="ico" style="background:rgba(245,158,11,.15); color:var(--orange);"><i data-lucide="triangle-alert" style="width:15px;height:15px;"></i></span>
                <div>
                  <b style="color:var(--orange);">Conflit d'équipe</b>
                  <p>{{ $nombreConflits }} département(s) ont plusieurs demandes en attente sur des dates qui se chevauchent</p>
                </div>
                <span class="count">{{ $nombreConflits }}</span>
              </div>
            @endif

            @if ($soldeFaibleCount > 0)
              <div class="alert-item">
                <span class="ico" style="background:rgba(59,130,246,.15); color:var(--blue-2);"><i data-lucide="info" style="width:15px;height:15px;"></i></span>
                <div>
                  <b style="color:var(--blue-2);">Solde faible</b>
                  <p>{{ $soldeFaibleCount }} employé(s) auront moins de 5 jours de solde après ce congé</p>
                </div>
                <span class="count">{{ $soldeFaibleCount }}</span>
              </div>
            @endif

            @if ($congesLongsCount > 0)
              <div class="alert-item">
                <span class="ico" style="background:rgba(139,92,246,.15); color:var(--purple);"><i data-lucide="calendar-clock" style="width:15px;height:15px;"></i></span>
                <div>
                  <b style="color:var(--purple);">Congés longs</b>
                  <p>{{ $congesLongsCount }} congé(s) de plus de 10 jours en attente</p>
                </div>
                <span class="count">{{ $congesLongsCount }}</span>
              </div>
            @endif
          @endif
        </div>

      </div>
    </div>

  </main>
</div>

<script>
  lucide.createIcons();
  document.querySelectorAll('a[href="#"]').forEach(l => l.addEventListener('click', e => e.preventDefault()));

  /* ===================== MENU DE TRI ===================== */
  const sortWrap = document.getElementById('sortWrap');
  const sortTrigger = document.getElementById('sortTrigger');
  if (sortWrap && sortTrigger) {
    sortTrigger.addEventListener('click', (e) => {
      e.stopPropagation();
      sortWrap.classList.toggle('open');
    });
    document.addEventListener('click', () => sortWrap.classList.remove('open'));
  }
</script>
@livewireScripts
</body>
</html>