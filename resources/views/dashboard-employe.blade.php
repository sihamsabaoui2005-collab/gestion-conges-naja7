<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mon tableau de bord — NAJA7 HOST</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<style>
  :root{
    --blue:#3B82F6; --blue-2:#60A5FA;
    --orange:#F59E0B; --green:#10B981; --red:#EF4444; --purple:#8B5CF6;
    --bg:#05070F; --panel:rgba(18,24,42,.55); --panel-2:rgba(255,255,255,.06);
    --border:rgba(255,255,255,.12);
    --text:#F1F4FA; --text-dim:#C3CCE0;
    --radius:22px;
    --glass-blur:22px;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  html, body{height:100%;}
  body{
    font-family:'Poppins',sans-serif; color:var(--text); -webkit-font-smoothing:antialiased;
    background:
      linear-gradient(180deg, rgba(4,6,14,.72), rgba(4,6,14,.88)),
      url('{{ asset('images/dashboard-bg.jpg') }}') center/cover no-repeat fixed;
  }
  a{text-decoration:none; color:inherit;}
  button{font-family:inherit; cursor:pointer; border:none; background:none; color:inherit;}
  ul{list-style:none;}

  .app{display:flex; align-items:center; min-height:100vh; padding:16px 24px; gap:16px; max-width:1500px; margin:0 auto;}

  /* ===== SIDEBAR (icônes seules, petite pilule flottante, comme la maquette) ===== */
  .sidebar{width:64px; flex:none; align-self:center; position:relative; z-index:100; background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:999px; padding:16px 0; display:flex; flex-direction:column; align-items:center; box-shadow:0 8px 32px rgba(0,0,0,.35); max-height:82vh;}
  .side-logo{width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; margin-bottom:18px; font-weight:700; overflow:hidden; flex:none;}
  .side-logo img{width:100%; height:100%; object-fit:cover;}
  .side-nav{display:flex; flex-direction:column; gap:6px; flex:1;}
  .side-link{position:relative; width:38px; height:38px; border-radius:12px; display:flex; align-items:center; justify-content:center; color:var(--text-dim);}
  .side-link:hover{background:rgba(255,255,255,.08); color:#fff;}
  .side-link.active{background:var(--orange); color:#fff;}
  .side-link .tip{position:absolute; left:48px; top:50%; transform:translateY(-50%); background:rgba(20,26,46,.92); backdrop-filter:blur(10px); padding:6px 12px; border-radius:8px; font-size:12px; white-space:nowrap; opacity:0; pointer-events:none; transition:opacity .15s; z-index:30; border:1px solid var(--border);}
  .side-link:hover .tip{opacity:1;}
  .side-bottom{display:flex; flex-direction:column; gap:6px; padding-top:10px; margin-top:8px; border-top:1px solid var(--border); align-items:center;}
  .side-link:focus .tip{opacity:1;}

  /* ===== MAIN ===== */
  .main{flex:1; align-self:stretch; padding:6px 6px 40px; max-width:100%; overflow-x:hidden; position:relative;}

  /* ===== TOPBAR ===== */
  .brand-lockup{display:flex; align-items:center; gap:10px;}
  .brand-lockup .side-logo{margin-bottom:0;}
  .brand-lockup .brand-text b{display:block; font-size:15px; font-weight:800; letter-spacing:.02em;}
  .brand-lockup .brand-text b span{color:var(--orange);}
  .brand-lockup .brand-text small{display:block; font-size:9.5px; color:var(--text-dim); line-height:1.2;}
  .topbar{display:flex; align-items:center; justify-content:space-between; margin-bottom:30px;}

  /* ===== RECHERCHE (rectangle sombre + bloc blanc + icône, style simple demandé) ===== */
  .search-box{width:340px; height:44px; display:flex; align-items:stretch; background:#0F2A47; border-radius:8px; padding:5px; gap:8px;}
  .search-box input{flex:1; border:none; outline:none; background:#fff; border-radius:4px; color:#0F2A47; font-size:13.5px; padding:0 14px; font-family:inherit;}
  .search-box input::placeholder{color:#8896A8;}
  .search-btn{width:34px; border:none; background:transparent; color:#CFE0F0; cursor:pointer; display:flex; align-items:center; justify-content:center; flex:none;}

  .top-right{display:flex; align-items:center; gap:14px; position:relative;}
  .icon-btn{position:relative; width:40px; height:40px; border-radius:14px; background:var(--panel); backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); display:flex; align-items:center; justify-content:center;}
  .icon-btn .dot{position:absolute; top:-3px; right:-3px; background:var(--red); color:#fff; font-size:9.5px; font-weight:700; width:17px; height:17px; border-radius:50%; display:flex; align-items:center; justify-content:center;}
  .user-chip{display:flex; align-items:center; gap:10px; cursor:pointer; background:var(--panel); backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:6px 14px 6px 6px;}
  .avatar{width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; overflow:hidden;}
  .avatar img{width:100%; height:100%; object-fit:cover; object-position:center top;}
  .user-chip p{font-size:13px; font-weight:600;}
  .user-chip span{font-size:11px; color:var(--text-dim);}

  /* ===== DROPDOWNS (profil + notifications) ===== */
  .dropdown{position:absolute; top:52px; right:0; background:rgba(18,24,42,.85); backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:8px; width:230px; box-shadow:0 12px 30px rgba(0,0,0,.4); display:none; z-index:50;}
  .dropdown.open{display:block;}
  .dropdown-item{display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:11px; font-size:13px; width:100%; text-align:left;}
  .dropdown-item:hover{background:rgba(255,255,255,.05);}
  .notif-panel{position:absolute; top:52px; right:60px; background:rgba(18,24,42,.85); backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:10px; width:290px; box-shadow:0 12px 30px rgba(0,0,0,.4); display:none; z-index:50;}
  .notif-panel.open{display:block;}
  .notif-panel h4{font-size:12.5px; padding:6px 8px 10px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.03em;}
  .notif-item{display:flex; align-items:flex-start; gap:10px; padding:9px 8px; border-radius:11px; font-size:12.5px;}
  .notif-item:hover{background:rgba(255,255,255,.05);}
  .notif-item .n-ico{width:28px; height:28px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex:none;}
  .notif-empty{padding:14px 8px; font-size:12.5px; color:var(--text-dim); text-align:center;}

  /* ===== GREETING ===== */
  .greeting{margin-bottom:26px; position:relative;}
  .greeting h1{font-size:27px; font-weight:700; text-shadow:0 2px 12px rgba(0,0,0,.5);}
  .greeting p{color:var(--text-dim); font-size:13.5px; margin-top:4px; text-shadow:0 2px 10px rgba(0,0,0,.7), 0 1px 2px rgba(0,0,0,.9); max-width:520px;}
  .kpi-row{display:grid; grid-template-columns:3fr 1.1fr; gap:16px; margin-bottom:16px; align-items:stretch;}
  .kpi-image-card{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:20px; box-shadow:0 8px 24px rgba(0,0,0,.25); display:flex; align-items:center; justify-content:center; overflow:hidden; min-height:100%;}
  .kpi-image-card img{width:100%; height:100%; object-fit:cover;}

  /* ===== GRID LAYOUT ===== */
  .row2-grid{display:grid; grid-template-columns:0.9fr 1.5fr 0.8fr; gap:16px; margin-bottom:12px; height:210px;}
  .row2-grid > .panel{height:100%; padding:16px; overflow:visible; display:flex; flex-direction:column;}
  @media (max-width:1100px){
    .row2-grid{grid-template-columns:1fr;}
  }

  /* ===== TITRES DE SECTION (pilule bleu glossy) ===== */
  .card-head{display:flex; align-items:center; justify-content:space-between; margin-bottom:14px; flex-wrap:wrap; gap:8px;}
  .card-head h2{position:relative; font-size:13px; font-weight:800; color:#fff; display:inline-flex; align-items:center; gap:8px; flex:none; line-height:1.4;
    padding:9px 18px; background:linear-gradient(180deg,#3D7BFF 0%,#1E4FC4 55%,#123591 100%); border-radius:999px; white-space:nowrap;
    box-shadow:0 6px 14px rgba(23,73,176,.5), inset 0 2px 0 rgba(255,255,255,.4), inset 0 -4px 8px rgba(0,0,0,.3);}
  .card-head a{font-size:11.5px; font-weight:700; color:#fff; display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:999px; white-space:nowrap;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .card-head a:hover{transform:translateY(-1px);}

  /* ===== TABLE ===== */
  table{width:100%; border-collapse:collapse;}
  th{text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.03em; color:var(--text-dim); padding:0 8px 10px; font-weight:600;}
  td{padding:11px 8px; font-size:13px; border-top:1px solid var(--border); vertical-align:middle;}
  .type-cell{display:flex; align-items:center; gap:9px;}
  .type-ico{width:30px; height:30px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex:none;}
  .badge{display:inline-flex; align-items:center; gap:5px; padding:4px 11px; border-radius:20px; font-size:11px; font-weight:600;}
  .badge-approved{background:rgba(16,185,129,.15); color:var(--green);}
  .badge-pending{background:rgba(245,158,11,.15); color:var(--orange);}
  .badge-rejected{background:rgba(239,68,68,.15); color:var(--red);}
  .action-dots{color:var(--text-dim); font-size:16px; letter-spacing:2px; cursor:pointer;}

  /* ===== CALENDAR ===== */
  .cal-head{display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;}
  .cal-nav{display:flex; align-items:center; gap:8px;}
  .cal-nav button{width:26px; height:26px; border-radius:8px; background:var(--panel-2); display:flex; align-items:center; justify-content:center;}
  .cal-nav span{font-size:13px; font-weight:600; width:100px; text-align:center;}
  .btn-today{background:var(--blue); font-size:11.5px; font-weight:600; padding:6px 12px; border-radius:9px;}
  .cal-quickpick{display:flex; gap:8px; margin-bottom:8px;}
  .cal-quickpick select{background:#1a2338; border:1px solid var(--border); color:#fff; font-size:12px; padding:6px 8px; border-radius:8px; flex:1;}
  select option{background:#1a2338; color:#fff;}
  .cal-grid{display:grid; grid-template-columns:repeat(7,1fr); gap:4px; text-align:center;}
  .cal-grid .dow{font-size:10px; color:var(--text-dim); font-weight:600; padding-bottom:8px;}
  .cal-day{font-size:12px; padding:7px 0; border-radius:9px; color:var(--text);}
  .cal-day.muted{color:#374156;}
  .cal-day.approuve{background:var(--blue); color:#fff; font-weight:700;}
  .cal-day.en_attente{background:var(--orange); color:#fff; font-weight:700;}
  .cal-day.absent{background:var(--red); color:#fff; font-weight:700;}
  .cal-day.today{border:1.5px solid var(--purple); font-weight:700;}
  .cal-legend{display:flex; flex-wrap:wrap; gap:10px; margin-top:8px; font-size:10.5px; color:var(--text-dim);}
  .cal-legend .row{display:flex; align-items:center; gap:6px;}
  .dot{width:8px; height:8px; border-radius:50%; flex:none;}

  /* ===== DONUT ===== */
  .donut-wrap{display:flex; align-items:center; gap:22px;}
  .donut-ring{position:relative; width:120px; height:120px; flex:none;}
  .donut-ring .center{position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center;}
  .donut-ring .center b{font-size:24px; font-weight:700;}
  .donut-ring .center span{font-size:10.5px; color:var(--text-dim);}
  .donut-legend{display:flex; flex-direction:column; gap:11px;}
  .donut-legend .row{display:flex; align-items:center; gap:8px; font-size:12.5px;}
  .donut-legend .row b{font-weight:600;}

  /* ===== LINE CHART ===== */
  .chart-select{background:#1a2338; border:1px solid var(--border); color:#fff; font-size:12px; padding:5px 10px; border-radius:8px;}
  .chart-months{display:grid; grid-template-columns:repeat(12,1fr); text-align:center; font-size:10px; color:var(--text-dim); margin-top:2px; padding-left:4.3%;}
  .chart-tip{position:absolute; background:#1a2338; border:1px solid var(--border); border-radius:9px; padding:5px 10px; font-size:11px; font-weight:600; white-space:nowrap; transform:translate(-50%,-130%); pointer-events:none;}

  /* ===== PROCHAINES ABSENCES ===== */
  .absence-row{display:flex; align-items:center; justify-content:space-between; background:var(--panel-2); border-radius:14px; padding:14px 16px; margin-bottom:10px;}
  .absence-row .left{display:flex; align-items:center; gap:12px;}
  .absence-row .ico{width:38px; height:38px; border-radius:50%; background:rgba(139,92,246,.15); color:var(--purple); display:flex; align-items:center; justify-content:center;}
  .absence-row p{font-size:13.5px; font-weight:600;}
  .absence-row span{font-size:11.5px; color:var(--text-dim);}
  .badge-days{background:rgba(16,185,129,.15); color:var(--green); font-size:11px; font-weight:600; padding:5px 12px; border-radius:20px; white-space:nowrap;}

  /* ===== MISE EN PAGE ===== */
  .dash-left{display:flex; flex-direction:column; gap:16px;}
  .triple-grid{display:grid; grid-template-columns:1.7fr 1.2fr 1fr; gap:12px; margin-bottom:12px; align-items:stretch;}
  @media (max-width:1100px){
    .triple-grid{grid-template-columns:1fr;}
    .kpi-row{grid-template-columns:1fr;}
  }

  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:20px; padding:20px; box-shadow:0 8px 24px rgba(0,0,0,.25);}

  /* Rangée des 4 statistiques, dans UN SEUL panneau avec séparateurs verticaux */
  .stats-panel{display:flex; padding:28px 12px;}
  .stat-cell{flex:1; padding:0 14px; position:relative; display:flex; flex-direction:column; align-items:center; text-align:center;}
  .stat-cell + .stat-cell{border-left:1px solid var(--border);}
  .ring-wrap{position:relative; width:170px; height:170px; margin-bottom:12px; border-radius:50%; box-shadow:0 0 55px -8px var(--ring-c);}
  .ring-wrap svg circle.ring-glow{filter:drop-shadow(0 0 4px var(--ring-c));}
  .ring-center{position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center;}
  .ring-center b{font-size:27px; font-weight:700; color:#fff; line-height:1.05;}
  .ring-center .ring-sub1{font-size:12px; color:#fff; opacity:.9; margin-top:1px;}
  .ring-center .ring-sub2{font-size:10.5px; color:rgba(255,255,255,.65); margin-top:1px;}
  .ring-badge{width:24px; height:24px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:9px; margin-top:6px; box-shadow:0 0 10px var(--ring-c);}

  /* ===== BOUTONS SOUS LES ANNEAUX (pilule orange glossy, sans flèche) ===== */
  .stat-cell .foot-btn{display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; color:#fff !important; padding:8px 16px; border-radius:999px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .stat-cell .foot-btn:hover{transform:translateY(-1px);}

  /* ===== ACTIONS RAPIDES (pilule orange glossy) ===== */
  .action-tile{position:relative; overflow:hidden; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px; height:70px; border-radius:20px; font-size:11px; font-weight:700; text-align:center; flex:1; color:#fff;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 8px 20px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .action-tile:hover{transform:translateY(-1px);}
  .action-tile .ico{width:26px; height:26px; border-radius:9px; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,.2); color:#fff;}

  @media (max-width:1100px){
    .stats-panel{flex-wrap:wrap;}
    .stat-cell{flex:1 1 50%; margin-bottom:16px;}
  }
  @media (max-width:800px){
    .sidebar{display:none;}
    .search-box{width:220px;}
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
      <a href="{{ route('dashboard') }}" class="side-link active"><i data-lucide="layout-dashboard" style="width:17px;height:17px;"></i><span class="tip">Tableau de bord</span></a>
      <a href="#" class="side-link"><i data-lucide="file-text" style="width:17px;height:17px;"></i><span class="tip">Mes demandes</span></a>
      <a href="#" class="side-link"><i data-lucide="plus-circle" style="width:17px;height:17px;"></i><span class="tip">Nouvelle demande</span></a>
      <a href="#" class="side-link"><i data-lucide="calendar-days" style="width:17px;height:17px;"></i><span class="tip">Calendrier</span></a>
      <a href="#" class="side-link"><i data-lucide="wallet" style="width:17px;height:17px;"></i><span class="tip">Mon solde</span></a>
      <a href="#" class="side-link"><i data-lucide="history" style="width:17px;height:17px;"></i><span class="tip">Historique</span></a>
      <a href="{{ route('profile.edit') }}" class="side-link"><i data-lucide="user" style="width:17px;height:17px;"></i><span class="tip">Mon profil</span></a>
      <a href="#" class="side-link"><i data-lucide="settings" style="width:17px;height:17px;"></i><span class="tip">Paramètres</span></a>
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

    <!-- ===== TOPBAR ===== -->
    <div class="topbar">
      <div class="search-box">
        <input type="text" id="rechercheInput" placeholder="Rechercher une demande...">
        <button type="button" class="search-btn"><i data-lucide="search" style="width:18px;height:18px;"></i></button>
      </div>
      <div class="top-right">
        <button class="icon-btn" id="notifBtn"><i data-lucide="bell" style="width:17px;height:17px;"></i>
          @if ($demandesEnAttente > 0)<span class="dot">{{ $demandesEnAttente }}</span>@endif
        </button>
        <button class="icon-btn"><i data-lucide="message-square" style="width:17px;height:17px;"></i></button>
        <div class="user-chip" id="userChip">
          <div class="avatar">
            @if (auth()->user()->photo_path)
              <img src="{{ asset('storage/'.auth()->user()->photo_path) }}" alt="Photo de profil">
            @else
              {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            @endif
          </div>
          <div>
            <p>{{ auth()->user()->name }}</p>
            <span>{{ auth()->user()->poste ?? 'Employé' }}</span>
          </div>
          <i data-lucide="chevron-down" style="width:14px;height:14px; color:var(--text-dim);"></i>
        </div>

        <!-- ===== Panneau notifications ===== -->
        <div class="notif-panel" id="notifPanel">
          <h4>Notifications</h4>
          @if ($demandesEnAttente > 0)
            <div class="notif-item">
              <span class="n-ico" style="background:rgba(245,158,11,.15); color:var(--orange);"><i data-lucide="hourglass" style="width:14px;height:14px;"></i></span>
              <div>{{ $demandesEnAttente }} demande(s) en attente de validation</div>
            </div>
          @endif
          @forelse ($notifications as $notif)
            <div class="notif-item">
              <span class="n-ico" style="background:{{ $notif->statut === 'approuve' ? 'rgba(16,185,129,.15)' : 'rgba(239,68,68,.15)' }}; color:{{ $notif->statut === 'approuve' ? 'var(--green)' : 'var(--red)' }};">
                <i data-lucide="{{ $notif->statut === 'approuve' ? 'check' : 'x' }}" style="width:14px;height:14px;"></i>
              </span>
              <div>Votre demande du {{ $notif->date_debut->format('d M') }} a été {{ $notif->statut === 'approuve' ? 'approuvée' : 'refusée' }}</div>
            </div>
          @empty
            @if ($demandesEnAttente === 0)
              <div class="notif-empty">Aucune notification récente.</div>
            @endif
          @endforelse
        </div>

        <!-- ===== Menu profil ===== -->
        <div class="dropdown" id="userMenu">
          <a href="{{ route('profile.edit') }}" class="dropdown-item"><i data-lucide="user" style="width:15px;height:15px;"></i> Mon profil</a>
          <a href="#" class="dropdown-item"><i data-lucide="settings" style="width:15px;height:15px;"></i> Mes paramètres</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item"><i data-lucide="log-out" style="width:15px;height:15px;"></i> Se déconnecter</button>
          </form>
        </div>
      </div>
    </div>

    <!-- ===== GREETING ===== -->
    <div class="greeting">
      <h1>Bonjour, {{ explode(' ', auth()->user()->name)[0] }} !</h1>
      <p>Vous êtes sur le tableau de bord : il réunit tous les résumés de vos congés, demandes et absences en un seul endroit.</p>
    </div>

    <!-- ===== MISE EN PAGE FUSIONNÉE (2 colonnes, panneaux internes) ===== -->
    <div class="dash-left">

        <!-- ===== KPI (4 anneaux) + image, même hauteur ===== -->
        <div class="kpi-row">
        <div class="panel stats-panel">
          @php
            $anneaux = [
                ['couleur' => '#2F8CFF', 'icone' => 'wallet'],
                ['couleur' => '#FF9F1C', 'icone' => 'hourglass'],
                ['couleur' => '#12E19D', 'icone' => 'check-circle-2'],
                ['couleur' => '#A855F7', 'icone' => 'plane'],
            ];
            $circonf = 2 * pi() * 74;
            $segment = $circonf * 0.44;
            $espace = $circonf * 0.06;
            $motif = $segment.' '.$espace.' '.$segment.' '.$espace;
          @endphp

          <div class="stat-cell">
            <div class="ring-wrap" style="--ring-c: {{ $anneaux[0]['couleur'] }};">
              <svg viewBox="0 0 170 170" width="170" height="170" style="transform:rotate(-99deg); overflow:visible;">
                <circle cx="85" cy="85" r="74" fill="none" stroke="rgba(255,255,255,.06)" stroke-width="7" />
                <circle class="ring-glow" cx="85" cy="85" r="74" fill="none" stroke="{{ $anneaux[0]['couleur'] }}" stroke-width="7" stroke-linecap="round"
                  stroke-dasharray="{{ $motif }}" />
              </svg>
              <div class="ring-center">
                <div class="ring-badge" style="background:{{ $anneaux[0]['couleur'] }};"><i data-lucide="wallet" style="width:15px;height:15px; color:#fff;"></i></div>
                <b>{{ $soldeDisponible }}</b>
                <div class="ring-sub1">jours</div>
                <div class="ring-sub2">de congés restants</div>
              </div>
            </div>
            <a class="foot-btn" href="#">Voir mon solde</a>
          </div>

          <div class="stat-cell">
            <div class="ring-wrap" style="--ring-c: {{ $anneaux[1]['couleur'] }};">
              <svg viewBox="0 0 170 170" width="170" height="170" style="transform:rotate(-99deg); overflow:visible;">
                <circle cx="85" cy="85" r="74" fill="none" stroke="rgba(255,255,255,.06)" stroke-width="7" />
                <circle class="ring-glow" cx="85" cy="85" r="74" fill="none" stroke="{{ $anneaux[1]['couleur'] }}" stroke-width="7" stroke-linecap="round"
                  stroke-dasharray="{{ $motif }}" />
              </svg>
              <div class="ring-center">
                <div class="ring-badge" style="background:{{ $anneaux[1]['couleur'] }};"><i data-lucide="hourglass" style="width:15px;height:15px; color:#fff;"></i></div>
                <b>{{ $demandesEnAttente }}</b>
                <div class="ring-sub1">demandes</div>
                <div class="ring-sub2">en cours</div>
              </div>
            </div>
            <a class="foot-btn" href="#">Voir mes demandes</a>
          </div>

          <div class="stat-cell">
            <div class="ring-wrap" style="--ring-c: {{ $anneaux[2]['couleur'] }};">
              <svg viewBox="0 0 170 170" width="170" height="170" style="transform:rotate(-99deg); overflow:visible;">
                <circle cx="85" cy="85" r="74" fill="none" stroke="rgba(255,255,255,.06)" stroke-width="7" />
                <circle class="ring-glow" cx="85" cy="85" r="74" fill="none" stroke="{{ $anneaux[2]['couleur'] }}" stroke-width="7" stroke-linecap="round"
                  stroke-dasharray="{{ $motif }}" />
              </svg>
              <div class="ring-center">
                <div class="ring-badge" style="background:{{ $anneaux[2]['couleur'] }};"><i data-lucide="check-circle-2" style="width:15px;height:15px; color:#fff;"></i></div>
                <b>{{ $congesApprouves }}</b>
                <div class="ring-sub1">jours</div>
                <div class="ring-sub2">cette année</div>
              </div>
            </div>
            <a class="foot-btn" href="#">Voir l'historique</a>
          </div>

          <div class="stat-cell">
            <div class="ring-wrap" style="--ring-c: {{ $anneaux[3]['couleur'] }};">
              <svg viewBox="0 0 170 170" width="170" height="170" style="transform:rotate(-99deg); overflow:visible;">
                <circle cx="85" cy="85" r="74" fill="none" stroke="rgba(255,255,255,.06)" stroke-width="7" />
                <circle class="ring-glow" cx="85" cy="85" r="74" fill="none" stroke="{{ $anneaux[3]['couleur'] }}" stroke-width="7" stroke-linecap="round"
                  stroke-dasharray="{{ $motif }}" />
              </svg>
              <div class="ring-center">
                <div class="ring-badge" style="background:{{ $anneaux[3]['couleur'] }};"><i data-lucide="plane" style="width:15px;height:15px; color:#fff;"></i></div>
                @if ($prochaineAbsence)
                  <b style="font-size:16px;">{{ $prochaineAbsence->date_debut->format('d M') }} → {{ $prochaineAbsence->date_fin->format('d M') }}</b>
                  <div class="ring-sub2" style="margin-top:4px;">{{ $prochaineAbsence->jours }} jours de congé</div>
                @else
                  <b style="font-size:18px;">Aucune</b>
                  <div class="ring-sub2" style="margin-top:4px;">rien de prévu</div>
                @endif
              </div>
            </div>
            <a class="foot-btn" href="#">Voir le calendrier</a>
          </div>
        </div>

        <div class="kpi-image-card">
          <img src="{{ asset('images/greeting-illustration.png') }}" alt="">
        </div>
        </div>

        <!-- ===== RANGÉE 1 : Demandes / Calendrier / Solde moyen ===== -->
        <div class="triple-grid">
          <div class="panel">
            <div class="card-head">
              <h2>Mes demandes récentes</h2>
              <a href="#">Voir tout</a>
            </div>
            <table id="demandesTable">
              <thead>
                <tr><th>Type</th><th>Date</th><th>Durée</th><th>Statut</th><th></th></tr>
              </thead>
              <tbody>
                @php
                  $icones = ['paye' => ['plane', 'ico-blue'], 'maladie' => ['plus', 'ico-green'], 'sans_solde' => ['calendar-x', 'ico-orange']];
                  $libelles = ['paye' => 'Congé payé', 'maladie' => 'Congé maladie', 'sans_solde' => 'Congé sans solde'];
                @endphp
                @forelse ($demandesRecentes as $demande)
                  @php
                    [$icone, $iconeClasse] = $icones[$demande->type] ?? ['calendar', 'ico-blue'];
                    $badge = ['approuve' => 'badge-approved', 'en_attente' => 'badge-pending', 'refuse' => 'badge-rejected'][$demande->statut];
                    $statutLabel = ['approuve' => 'Approuvé', 'en_attente' => 'En attente', 'refuse' => 'Refusé'][$demande->statut];
                    $texteRecherche = strtolower(($libelles[$demande->type] ?? $demande->type).' '.$statutLabel.' '.$demande->date_debut->format('d M'));
                  @endphp
                  <tr data-recherche="{{ $texteRecherche }}">
                    <td>
                      <div class="type-cell">
                        <span class="type-ico {{ $iconeClasse }}"><i data-lucide="{{ $icone }}" style="width:14px;height:14px;"></i></span>
                        {{ $libelles[$demande->type] ?? $demande->type }}
                      </div>
                    </td>
                    <td>{{ $demande->date_debut->format('d M') }} - {{ $demande->date_fin->format('d M') }}</td>
                    <td>{{ $demande->jours }} jours</td>
                    <td><span class="badge {{ $badge }}">{{ $statutLabel }}</span></td>
                    <td><span class="action-dots">⋯</span></td>
                  </tr>
                @empty
                  <tr><td colspan="5" style="padding:26px 0;">
                    <div style="display:flex; flex-direction:column; align-items:center; gap:8px; color:var(--text-dim);">
                      <span style="width:42px; height:42px; border-radius:50%; background:rgba(255,255,255,.06); display:flex; align-items:center; justify-content:center;"><i data-lucide="inbox" style="width:20px;height:20px;"></i></span>
                      <span style="font-size:13px; font-weight:600; color:#fff;">Aucune demande pour le moment</span>
                      <span style="font-size:11.5px;">Vous n'avez pas encore fait de demande de congé.</span>
                    </div>
                  </td></tr>
                @endforelse
              </tbody>
            </table>
            <p id="rechercheVide" style="display:none; text-align:center; color:var(--text-dim); font-size:13px; padding:14px 0;">Aucun résultat pour cette recherche.</p>
          </div>

          <div class="panel">
            <div class="cal-head">
              <h2 style="font-size:15.5px; font-weight:700; background:none; box-shadow:none; padding:0; border-radius:0; color:var(--text);">Mon calendrier</h2>
              <div class="cal-nav">
                <button id="calPrev"><i data-lucide="chevron-left" style="width:14px;height:14px;"></i></button>
                <span id="calLabel"></span>
                <button id="calNext"><i data-lucide="chevron-right" style="width:14px;height:14px;"></i></button>
              </div>
            </div>
            <div class="cal-quickpick">
              <select id="calMoisSelect"></select>
              <select id="calAnneeSelect"></select>
              <button class="btn-today" id="calToday">Aujourd'hui</button>
            </div>
            <div class="cal-grid" id="calGrid"></div>
            <div class="cal-legend">
              <span class="row"><span class="dot" style="background:var(--blue);"></span> Congé approuvé</span>
              <span class="row"><span class="dot" style="background:var(--orange);"></span> En attente</span>
              <span class="row"><span class="dot" style="background:var(--red);"></span> Absent(e)</span>
              <span class="row"><span class="dot" style="border:1.5px solid var(--purple); background:transparent;"></span> Aujourd'hui</span>
            </div>
          </div>

          <div style="display:flex; flex-direction:column; gap:12px;">
            <div class="panel" style="position:relative; overflow:hidden;">
              <div class="card-head" style="position:relative; z-index:1;"><h2>Solde moyen de congés</h2></div>
              <div style="display:flex; align-items:center; gap:14px; position:relative; z-index:1;">
                <div style="position:relative; width:90px; height:90px; flex:none;">
                  <svg viewBox="0 0 90 90" width="90" height="90" style="transform:rotate(-90deg);">
                    <circle cx="45" cy="45" r="36" fill="none" stroke="var(--panel-2)" stroke-width="9" />
                    <circle cx="45" cy="45" r="36" fill="none" stroke="url(#soldeGrad)" stroke-width="9" stroke-linecap="round"
                      stroke-dasharray="{{ 2 * pi() * 36 * ($pourcentageUtilise / 100) }} {{ 2 * pi() * 36 }}" />
                    <defs>
                      <linearGradient id="soldeGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#3B82F6" />
                        <stop offset="100%" stop-color="#22C55E" />
                      </linearGradient>
                    </defs>
                  </svg>
                  <div style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                    <b style="font-size:19px; font-weight:700; line-height:1;">{{ $soldeDisponible }}</b>
                    <span style="font-size:9px; color:var(--text-dim); text-align:center;">jours<br>restants</span>
                  </div>
                </div>
                <div style="display:flex; flex-direction:column; gap:7px; font-size:11.5px;">
                  <div style="display:flex; align-items:center; gap:6px;"><span class="dot" style="background:var(--blue);"></span> Utilisés <b style="margin-left:auto;">{{ $joursUtilises }}j</b></div>
                  <div style="display:flex; align-items:center; gap:6px;"><span class="dot" style="background:var(--green);"></span> Restants <b style="margin-left:auto;">{{ $soldeDisponible }}j</b></div>
                  <div style="display:flex; align-items:center; gap:6px;"><span class="dot" style="background:#64748b;"></span> Total <b style="margin-left:auto;">{{ $soldeAnnuel }}j</b></div>
                </div>
              </div>
              <img src="{{ asset('images/greeting-illustration.png') }}" alt=""
                style="position:absolute; top:6px; right:-6px; width:76px; height:76px; object-fit:contain; opacity:.4; pointer-events:none; z-index:0;">
            </div>

            <div class="panel">
              <div class="card-head"><h2>Actions rapides</h2></div>
              <div style="display:flex; gap:10px;">
                <a href="#" class="action-tile" style="width:auto; flex:1;"><span class="ico"><i data-lucide="plus" style="width:16px;height:16px;"></i></span> Nouvelle demande</a>
                <button type="button" id="genererDoc" class="action-tile" style="width:auto; flex:1;"><span class="ico"><i data-lucide="download" style="width:16px;height:16px;"></i></span> Exporter rapport</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ===== RANGÉE 2 : Utilisation / Courbe / Prochaines absences ===== -->
        <div class="row2-grid">
          <div class="panel" style="display:flex; flex-direction:column; justify-content:center;">
            <div class="card-head"><h2>Utilisation de vos congés</h2></div>
            <div class="donut-wrap">
              <div class="donut-ring">
                <svg viewBox="0 0 120 120" width="90" height="90" style="transform:rotate(-90deg);">
                  <circle cx="60" cy="60" r="50" fill="none" stroke="var(--panel-2)" stroke-width="13" />
                  <circle cx="60" cy="60" r="50" fill="none" stroke="url(#grad)" stroke-width="13" stroke-linecap="round"
                    stroke-dasharray="{{ 2 * pi() * 50 * ($pourcentageUtilise / 100) }} {{ 2 * pi() * 50 }}" />
                  <defs>
                    <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
                      <stop offset="0%" stop-color="#F59E0B" />
                      <stop offset="100%" stop-color="#10B981" />
                    </linearGradient>
                  </defs>
                </svg>
                <div class="center"><b>{{ $pourcentageUtilise }}%</b><span>utilisé</span></div>
              </div>
              <div class="donut-legend" style="margin-top:0;">
                <div class="row"><span class="dot" style="background:var(--blue);"></span> Utilisés <b style="margin-left:auto;">{{ $joursUtilises }} j</b></div>
                <div class="row"><span class="dot" style="background:var(--green);"></span> Restants <b style="margin-left:auto;">{{ $soldeDisponible }} j</b></div>
                <div class="row"><span class="dot" style="background:#475569;"></span> Total <b style="margin-left:auto;">{{ $soldeAnnuel }} j</b></div>
              </div>
            </div>
          </div>

          <div class="panel" style="position:relative; display:flex; flex-direction:column; justify-content:center;">
            <div class="card-head">
              <h2>Congés utilisés par mois</h2>
              <select class="chart-select" id="anneeSelect">
                @foreach (array_keys($congesParMoisParAnnee) as $annee)
                  <option value="{{ $annee }}" @selected($annee === $anneeActuelle)>{{ $annee }}</option>
                @endforeach
              </select>
            </div>
            <div style="position:relative;">
              <svg id="chartSvg" viewBox="0 0 600 130" width="100%" height="92" style="margin-top:8px; overflow:visible;"></svg>
              <div class="chart-tip" id="chartTip" style="display:none;"></div>
            </div>
            <div class="chart-months">
              @foreach (['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Août','Sep','Oct','Nov','Déc'] as $m)
                <span>{{ $m }}</span>
              @endforeach
            </div>
          </div>

          <div class="panel" style="display:flex; flex-direction:column; justify-content:center;">
            <div class="card-head"><h2>Prochaines absences</h2><a href="#">Voir tout</a></div>
            @forelse ($prochainesAbsences as $absence)
              <div class="absence-row">
                <div class="left">
                  <span class="ico"><i data-lucide="{{ $absence->type === 'maladie' ? 'stethoscope' : 'plane' }}" style="width:16px;height:16px;"></i></span>
                  <div>
                    <p>{{ $libelles[$absence->type] ?? $absence->type }}</p>
                    <span>{{ $absence->date_debut->format('d M') }} - {{ $absence->date_fin->format('d M') }} · {{ $absence->jours }} jours</span>
                  </div>
                </div>
                <span class="badge-days">Dans {{ now()->diffInDays($absence->date_debut) }} j</span>
              </div>
            @empty
              <p style="color:var(--text-dim); font-size:13px; text-align:center; padding:16px 0; margin:0;">
                <span style="width:42px; height:42px; border-radius:50%; background:rgba(255,255,255,.06); display:flex; align-items:center; justify-content:center; margin:0 auto 8px;"><i data-lucide="calendar-x" style="width:20px;height:20px;"></i></span>
                <span style="display:block; font-size:13px; font-weight:600; color:#fff; margin-bottom:2px;">Aucune absence à venir</span>
                Aucune demande de congé prévue.
              </p>
            @endforelse
          </div>
        </div>

    </div>

  </main>
</div>

<script>
  lucide.createIcons();

  document.querySelectorAll('.sidebar a[href="#"]').forEach(lien => {
    lien.addEventListener('click', (e) => e.preventDefault());
  });

  /* ===================== CALENDRIER NAVIGABLE ===================== */
  const demandes = {{ Js::from($demandesCalendrier) }};

  const calGrid = document.getElementById('calGrid');
  const calLabel = document.getElementById('calLabel');
  const moisNoms = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

  let vueAnnee = new Date().getFullYear();
  let vueMois = new Date().getMonth();

  function statutDuJour(dateStr) {
    for (const d of demandes) {
      if (dateStr >= d.debut && dateStr <= d.fin) {
        if (d.statut === 'en_attente') return 'en_attente';
        if (d.type === 'maladie') return 'absent';
        return 'approuve';
      }
    }
    return null;
  }

  const calMoisSelect = document.getElementById('calMoisSelect');
  const calAnneeSelect = document.getElementById('calAnneeSelect');

  moisNoms.forEach((nom, i) => {
    const opt = document.createElement('option');
    opt.value = i;
    opt.textContent = nom;
    calMoisSelect.appendChild(opt);
  });

  for (let a = 2001; a <= 2030; a++) {
    const opt = document.createElement('option');
    opt.value = a;
    opt.textContent = a;
    calAnneeSelect.appendChild(opt);
  }

  function dessinerCalendrier() {
    calLabel.textContent = moisNoms[vueMois] + ' ' + vueAnnee;
    calMoisSelect.value = vueMois;
    calAnneeSelect.value = vueAnnee;
    calGrid.innerHTML = '';

    ['L','M','M','J','V','S','D'].forEach(d => {
      const el = document.createElement('div');
      el.className = 'dow';
      el.textContent = d;
      calGrid.appendChild(el);
    });

    const premierJour = (new Date(vueAnnee, vueMois, 1).getDay() + 6) % 7;
    const joursDansMois = new Date(vueAnnee, vueMois + 1, 0).getDate();
    const aujourdHui = new Date();

    for (let i = 0; i < premierJour; i++) {
      calGrid.appendChild(document.createElement('div'));
    }

    for (let jour = 1; jour <= joursDansMois; jour++) {
      const el = document.createElement('div');
      el.className = 'cal-day';
      el.textContent = jour;

      const dateStr = vueAnnee + '-' + String(vueMois + 1).padStart(2, '0') + '-' + String(jour).padStart(2, '0');
      const statut = statutDuJour(dateStr);
      if (statut) el.classList.add(statut);

      if (jour === aujourdHui.getDate() && vueMois === aujourdHui.getMonth() && vueAnnee === aujourdHui.getFullYear()) {
        el.classList.add('today');
      }

      calGrid.appendChild(el);
    }
  }

  document.getElementById('calPrev').addEventListener('click', () => {
    vueMois--;
    if (vueMois < 0) { vueMois = 11; vueAnnee--; }
    dessinerCalendrier();
  });
  document.getElementById('calNext').addEventListener('click', () => {
    vueMois++;
    if (vueMois > 11) { vueMois = 0; vueAnnee++; }
    dessinerCalendrier();
  });
  document.getElementById('calToday').addEventListener('click', () => {
    vueAnnee = new Date().getFullYear();
    vueMois = new Date().getMonth();
    dessinerCalendrier();
  });
  calMoisSelect.addEventListener('change', () => { vueMois = parseInt(calMoisSelect.value); dessinerCalendrier(); });
  calAnneeSelect.addEventListener('change', () => { vueAnnee = parseInt(calAnneeSelect.value); dessinerCalendrier(); });

  dessinerCalendrier();

  /* ===================== RECHERCHE (filtre le tableau des demandes) ===================== */
  const rechercheInput = document.getElementById('rechercheInput');
  const lignesDemandes = document.querySelectorAll('#demandesTable tbody tr[data-recherche]');
  const rechercheVide = document.getElementById('rechercheVide');

  rechercheInput.addEventListener('input', () => {
    const terme = rechercheInput.value.trim().toLowerCase();
    let visibles = 0;

    lignesDemandes.forEach(ligne => {
      const correspond = ligne.dataset.recherche.includes(terme);
      ligne.style.display = correspond ? '' : 'none';
      if (correspond) visibles++;
    });

    rechercheVide.style.display = (terme && visibles === 0) ? 'block' : 'none';
  });

  /* ===================== MENUS DÉROULANTS (profil + notifications) ===================== */
  const userChip = document.getElementById('userChip');
  const userMenu = document.getElementById('userMenu');
  const notifBtn = document.getElementById('notifBtn');
  const notifPanel = document.getElementById('notifPanel');

  userChip.addEventListener('click', (e) => {
    e.stopPropagation();
    userMenu.classList.toggle('open');
    notifPanel.classList.remove('open');
  });
  notifBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    notifPanel.classList.toggle('open');
    userMenu.classList.remove('open');
  });
  document.addEventListener('click', () => {
    userMenu.classList.remove('open');
    notifPanel.classList.remove('open');
  });

  /* ===================== GRAPHIQUE MENSUEL ===================== */
  const donneesParAnnee = {{ Js::from($congesParMoisParAnnee) }};
  const svg = document.getElementById('chartSvg');
  const tip = document.getElementById('chartTip');
  const moisAbrev = ['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Août','Sep','Oct','Nov','Déc'];

  function dessinerGraphique(annee) {
    const valeurs = donneesParAnnee[annee] || new Array(12).fill(0);
    const axisMax = Math.max(...valeurs, 5);
    const largeurTotale = 600, largeurAxe = 26, largeur = largeurTotale - largeurAxe, hauteur = 110, pas = largeur / 11;

    const points = valeurs.map((v, i) => [largeurAxe + i * pas, hauteur - (v / axisMax) * hauteur]);
    const chemin = points.map((p, i) => (i === 0 ? 'M' : 'L') + p[0] + ',' + p[1]).join(' ');
    const zone = chemin + ` L${largeurAxe + largeur},${hauteur} L${largeurAxe},${hauteur} Z`;

    let cercles = '';
    points.forEach((p, i) => {
      cercles += `<circle cx="${p[0]}" cy="${p[1]}" r="4" fill="#F59E0B" data-mois="${moisAbrev[i]}" data-valeur="${valeurs[i]}" style="cursor:pointer;" />`;
    });

    let axeY = '';
    for (let i = 0; i <= 5; i++) {
      const valeur = Math.round((axisMax / 5) * i);
      const y = hauteur - (i / 5) * hauteur;
      axeY += `<text x="${largeurAxe - 8}" y="${y + 3}" text-anchor="end" font-size="10.5" font-weight="600" fill="#B8C2D9">${valeur}</text>`;
      axeY += `<line x1="${largeurAxe}" y1="${y}" x2="${largeurAxe + largeur}" y2="${y}" stroke="rgba(255,255,255,.05)" stroke-width="1" />`;
    }

    svg.innerHTML = `
      <defs>
        <linearGradient id="fillGrad" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0%" stop-color="#F59E0B" stop-opacity="0.35" />
          <stop offset="100%" stop-color="#F59E0B" stop-opacity="0" />
        </linearGradient>
      </defs>
      ${axeY}
      <path d="${zone}" fill="url(#fillGrad)" />
      <path d="${chemin}" fill="none" stroke="#F59E0B" stroke-width="2.5" />
      ${cercles}
    `;

    svg.querySelectorAll('circle').forEach(c => {
      c.addEventListener('mouseenter', (e) => {
        const rect = svg.getBoundingClientRect();
        const x = (parseFloat(c.getAttribute('cx')) / largeurTotale) * rect.width;
        const y = (parseFloat(c.getAttribute('cy')) / hauteur) * rect.height;
        tip.style.display = 'block';
        tip.style.left = x + 'px';
        tip.style.top = y + 'px';
        tip.textContent = c.dataset.valeur + ' j · ' + c.dataset.mois;
      });
      c.addEventListener('mouseleave', () => { tip.style.display = 'none'; });
    });
  }

  dessinerGraphique({{ $anneeActuelle }});
  document.getElementById('anneeSelect').addEventListener('change', (e) => {
    dessinerGraphique(parseInt(e.target.value));
  });

  document.getElementById('genererDoc').addEventListener('click', () => {
    // NOTE : génération réelle du PDF à brancher à une étape suivante du projet
    alert('Attestation à générer (fonctionnalité PDF à venir)');
  });
</script>
</body>
</html>