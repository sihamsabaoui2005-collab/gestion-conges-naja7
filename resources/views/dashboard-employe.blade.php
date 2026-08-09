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
    --bg:#05070F; --panel:#0C1120; --panel-2:#111A2E;
    --border:rgba(255,255,255,.06);
    --text:#E5E9F0; --text-dim:#7C8AA5;
    --radius:20px;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  body{font-family:'Poppins',sans-serif; background:var(--bg); color:var(--text); -webkit-font-smoothing:antialiased;}
  a{text-decoration:none; color:inherit;}
  button{font-family:inherit; cursor:pointer; border:none; background:none; color:inherit;}
  ul{list-style:none;}

  .app{display:flex; min-height:100vh;}

  /* ===== SIDEBAR (icônes seules) ===== */
  .sidebar{width:84px; flex:none; background:var(--panel); border-right:1px solid var(--border); padding:22px 0; display:flex; flex-direction:column; align-items:center;}
  .side-logo{width:42px; height:42px; border-radius:13px; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; margin-bottom:28px; font-weight:700; overflow:hidden;}
  .side-logo img{width:100%; height:100%; object-fit:cover;}
  .side-nav{display:flex; flex-direction:column; gap:10px; flex:1;}
  .side-link{position:relative; width:46px; height:46px; border-radius:14px; display:flex; align-items:center; justify-content:center; color:var(--text-dim);}
  .side-link:hover{background:rgba(255,255,255,.04); color:#fff;}
  .side-link.active{background:var(--orange); color:#fff; box-shadow:0 0 0 4px rgba(245,158,11,.18);}
  .side-link .tip{position:absolute; left:58px; top:50%; transform:translateY(-50%); background:#1a2338; padding:6px 12px; border-radius:8px; font-size:12px; white-space:nowrap; opacity:0; pointer-events:none; transition:opacity .15s; z-index:20; display:flex; align-items:center; gap:6px;}
  .side-link:hover .tip{opacity:1;}
  /* L'item actif garde son étiquette visible en permanence, dans une pastille bleue */
  .side-link.active .tip{opacity:1; background:var(--orange); color:#fff; font-weight:600;}
  .side-link .tip .chevron{opacity:.6; font-size:11px;}
  .side-bottom{display:flex; flex-direction:column; gap:10px; padding-top:14px; border-top:1px solid var(--border); align-items:center;}

  /* ===== MAIN ===== */
  .main{flex:1; padding:26px 32px 40px; max-width:100%; overflow-x:hidden; position:relative;}

  /* ===== TOPBAR ===== */
  .topbar{display:flex; align-items:center; justify-content:space-between; margin-bottom:30px;}
  .search{position:relative; width:360px;}
  .search input{width:100%; background:var(--panel); border:1px solid var(--border); border-radius:14px; padding:11px 44px 11px 16px; color:#fff; font-size:13.5px;}
  .search input::placeholder{color:var(--text-dim);}
  .search i{position:absolute; left:14px; top:50%; transform:translateY(-50%); width:16px; height:16px; color:var(--text-dim);}
  .search .kbd{position:absolute; right:12px; top:50%; transform:translateY(-50%); font-size:10.5px; color:var(--text-dim); background:var(--panel-2); padding:3px 7px; border-radius:6px;}

  .top-right{display:flex; align-items:center; gap:16px; position:relative;}
  .icon-btn{position:relative; width:40px; height:40px; border-radius:13px; background:var(--panel); border:1px solid var(--border); display:flex; align-items:center; justify-content:center;}
  .icon-btn .dot{position:absolute; top:-3px; right:-3px; background:var(--red); color:#fff; font-size:9.5px; font-weight:700; width:17px; height:17px; border-radius:50%; display:flex; align-items:center; justify-content:center;}
  .user-chip{display:flex; align-items:center; gap:10px; cursor:pointer;}
  .avatar{width:40px; height:40px; border-radius:50%; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; overflow:hidden;}
  .avatar img{width:100%; height:100%; object-fit:cover;}
  .user-chip p{font-size:13.5px; font-weight:600;}
  .user-chip span{font-size:11.5px; color:var(--text-dim);}

  /* ===== DROPDOWNS (profil + notifications) ===== */
  .dropdown{position:absolute; top:52px; right:0; background:#131c30; border:1px solid var(--border); border-radius:16px; padding:8px; width:230px; box-shadow:0 12px 30px rgba(0,0,0,.4); display:none; z-index:50;}
  .dropdown.open{display:block;}
  .dropdown-item{display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:11px; font-size:13px; width:100%; text-align:left;}
  .dropdown-item:hover{background:rgba(255,255,255,.05);}
  .notif-panel{position:absolute; top:52px; right:60px; background:#131c30; border:1px solid var(--border); border-radius:16px; padding:10px; width:290px; box-shadow:0 12px 30px rgba(0,0,0,.4); display:none; z-index:50;}
  .notif-panel.open{display:block;}
  .notif-panel h4{font-size:12.5px; padding:6px 8px 10px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.03em;}
  .notif-item{display:flex; align-items:flex-start; gap:10px; padding:9px 8px; border-radius:11px; font-size:12.5px;}
  .notif-item:hover{background:rgba(255,255,255,.05);}
  .notif-item .n-ico{width:28px; height:28px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex:none;}
  .notif-empty{padding:14px 8px; font-size:12.5px; color:var(--text-dim); text-align:center;}

  /* ===== GREETING ===== */
  .greeting{margin-bottom:28px; position:relative;}
  .greeting h1{font-size:26px; font-weight:700;}
  .greeting p{color:var(--text-dim); font-size:13.5px; margin-top:4px;}
  .greeting-img{position:absolute; top:-30px; right:0; width:220px; height:150px; object-fit:cover; border-radius:16px; opacity:.9; z-index:0; pointer-events:none; mask-image:linear-gradient(to left, black 60%, transparent 100%); -webkit-mask-image:linear-gradient(to left, black 60%, transparent 100%);}

  /* ===== STAT CARDS ===== */
  .stats-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-bottom:22px;}
  .stat-card{background:var(--panel); border:1px solid var(--border); border-radius:var(--radius); padding:20px; position:relative;}
  .stat-card .top{display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;}
  .stat-card .ico{width:40px; height:40px; border-radius:12px; display:flex; align-items:center; justify-content:center;}
  .stat-card .dots{color:var(--text-dim); font-size:16px; letter-spacing:2px;}
  .stat-card b{display:block; font-size:26px; font-weight:700;}
  .stat-card b small{font-size:13px; font-weight:400; color:var(--text-dim);}
  .stat-card .label{font-size:12px; color:var(--text-dim); margin-top:2px;}
  .stat-card svg.spark{margin-top:12px; width:100%; height:26px; display:block;}
  .stat-card .foot{display:block; margin-top:10px; font-size:11.5px; font-weight:600;}
  .ico-blue{background:rgba(59,130,246,.15); color:var(--blue-2);}
  .ico-orange{background:rgba(245,158,11,.15); color:var(--orange);}
  .ico-green{background:rgba(16,185,129,.15); color:var(--green);}
  .ico-purple{background:rgba(139,92,246,.15); color:var(--purple);}
  .foot-blue{color:var(--blue-2);} .foot-orange{color:var(--orange);} .foot-green{color:var(--green);} .foot-purple{color:var(--purple);}

  /* ===== GRID LAYOUT ===== */
  .grid-2{display:grid; grid-template-columns:2fr 1.1fr; gap:20px; margin-bottom:20px;}
  .grid-2b{display:grid; grid-template-columns:1fr 1.4fr; gap:20px; margin-bottom:20px;}

  .card{background:var(--panel); border:1px solid var(--border); border-radius:var(--radius); padding:22px;}
  .card-head{display:flex; align-items:center; justify-content:space-between; margin-bottom:18px;}
  .card-head h2{font-size:15.5px; font-weight:700;}
  .card-head a{font-size:12.5px; color:var(--blue-2); font-weight:600;}

  /* ===== TABLE ===== */
  table{width:100%; border-collapse:collapse;}
  th{text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.03em; color:var(--text-dim); padding:0 8px 10px; font-weight:600;}
  td{padding:12px 8px; font-size:13px; border-top:1px solid var(--border); vertical-align:middle;}
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
  .cal-quickpick{display:flex; gap:8px; margin-bottom:14px;}
  .cal-quickpick select{background:var(--panel-2); border:1px solid var(--border); color:#fff; font-size:12px; padding:6px 8px; border-radius:8px; flex:1;}
  .cal-grid{display:grid; grid-template-columns:repeat(7,1fr); gap:4px; text-align:center;}
  .cal-grid .dow{font-size:10px; color:var(--text-dim); font-weight:600; padding-bottom:8px;}
  .cal-day{font-size:12px; padding:8px 0; border-radius:9px; color:var(--text);}
  .cal-day.muted{color:#374156;}
  .cal-day.approuve{background:var(--blue); color:#fff; font-weight:700;}
  .cal-day.en_attente{background:var(--orange); color:#fff; font-weight:700;}
  .cal-day.absent{background:var(--red); color:#fff; font-weight:700;}
  .cal-day.today{border:1.5px solid var(--purple); font-weight:700;}
  .cal-legend{display:flex; flex-wrap:wrap; gap:14px; margin-top:16px; font-size:11px; color:var(--text-dim);}
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
  .donut-foot{margin-top:18px; background:var(--panel-2); border-radius:13px; padding:12px 14px; font-size:11.5px; color:var(--text-dim); display:flex; align-items:center; gap:10px;}
  .donut-foot i{color:var(--green); flex:none;}

  /* ===== LINE CHART ===== */
  .chart-select{background:var(--panel-2); border:1px solid var(--border); color:#fff; font-size:12px; padding:5px 10px; border-radius:8px;}
  .chart-months{display:grid; grid-template-columns:repeat(12,1fr); text-align:center; font-size:10px; color:var(--text-dim); margin-top:2px;}
  .chart-tip{position:absolute; background:#1a2338; border:1px solid var(--border); border-radius:9px; padding:5px 10px; font-size:11px; font-weight:600; white-space:nowrap; transform:translate(-50%,-130%); pointer-events:none;}

  /* ===== PROCHAINES ABSENCES ===== */
  .absence-row{display:flex; align-items:center; justify-content:space-between; background:var(--panel-2); border-radius:14px; padding:14px 16px; margin-bottom:10px;}
  .absence-row .left{display:flex; align-items:center; gap:12px;}
  .absence-row .ico{width:38px; height:38px; border-radius:50%; background:rgba(139,92,246,.15); color:var(--purple); display:flex; align-items:center; justify-content:center;}
  .absence-row p{font-size:13.5px; font-weight:600;}
  .absence-row span{font-size:11.5px; color:var(--text-dim);}
  .badge-days{background:rgba(16,185,129,.15); color:var(--green); font-size:11px; font-weight:600; padding:5px 12px; border-radius:20px; white-space:nowrap;}

  /* ===== DOC CARD ===== */
  .doc-card{background:linear-gradient(155deg,var(--orange),#B45309); border-radius:var(--radius); padding:22px; display:flex; flex-direction:column; gap:12px; position:relative; overflow:hidden;}
  .doc-card .doc-ico{width:46px; height:46px; border-radius:13px; background:rgba(255,255,255,.18); display:flex; align-items:center; justify-content:center;}
  .doc-card h3{font-size:15px; font-weight:700;}
  .doc-card p{font-size:12px; opacity:.85; max-width:220px;}
  .btn-doc{background:#fff; color:#B45309; font-weight:700; font-size:13px; padding:10px 16px; border-radius:12px; display:inline-flex; align-items:center; gap:8px; width:fit-content;}

  @media (max-width:1100px){
    .stats-grid{grid-template-columns:1fr 1fr;}
    .grid-2, .grid-2b{grid-template-columns:1fr;}
  }
  @media (max-width:800px){
    .sidebar{display:none;}
    .search{width:220px;}
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
      <a href="{{ route('dashboard') }}" class="side-link active"><i data-lucide="layout-dashboard" style="width:19px;height:19px;"></i><span class="tip">Tableau de bord <span class="chevron">›</span></span></a>
      <a href="#" class="side-link"><i data-lucide="file-text" style="width:19px;height:19px;"></i><span class="tip">Mes demandes <span class="chevron">›</span></span></a>
      <a href="#" class="side-link"><i data-lucide="plus-circle" style="width:19px;height:19px;"></i><span class="tip">Nouvelle demande <span class="chevron">›</span></span></a>
      <a href="#" class="side-link"><i data-lucide="calendar-days" style="width:19px;height:19px;"></i><span class="tip">Calendrier <span class="chevron">›</span></span></a>
      <a href="#" class="side-link"><i data-lucide="wallet" style="width:19px;height:19px;"></i><span class="tip">Mon solde <span class="chevron">›</span></span></a>
      <a href="#" class="side-link"><i data-lucide="history" style="width:19px;height:19px;"></i><span class="tip">Historique <span class="chevron">›</span></span></a>
      <a href="{{ route('profile.edit') }}" class="side-link"><i data-lucide="user" style="width:19px;height:19px;"></i><span class="tip">Mon profil <span class="chevron">›</span></span></a>
      <a href="#" class="side-link"><i data-lucide="settings" style="width:19px;height:19px;"></i><span class="tip">Paramètres <span class="chevron">›</span></span></a>
    </nav>

    <div class="side-bottom">
      <a href="#" class="side-link"><i data-lucide="headphones" style="width:18px;height:18px;"></i><span class="tip">Support</span></a>
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
      <div class="search">
        <i data-lucide="search"></i>
        <input type="text" id="rechercheInput" placeholder="Rechercher une demande...">
        <span class="kbd">⌘K</span>
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
      <img src="{{ asset('images/dashboard-illustration.jpg') }}" alt="" class="greeting-img">
      <h1>Bonjour, {{ explode(' ', auth()->user()->name)[0] }} !</h1>
      <p>Vous êtes sur le tableau de bord : il réunit tous les résumés de vos congés, demandes et absences en un seul endroit.</p>
    </div>

    <!-- ===== STATS ===== -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="top"><span class="ico ico-blue"><i data-lucide="calendar-check" style="width:18px;height:18px;"></i></span><span class="dots">⋯</span></div>
        <b>{{ $soldeDisponible }} <small>jours</small></b>
        <div class="label">de congés restants</div>
        <svg class="spark" viewBox="0 0 100 26" preserveAspectRatio="none"><path d="M0,18 Q15,8 30,15 T60,10 T100,14" fill="none" stroke="var(--blue-2)" stroke-width="2"/></svg>
        <a class="foot foot-blue" href="#">Voir mon solde →</a>
      </div>
      <div class="stat-card">
        <div class="top"><span class="ico ico-orange"><i data-lucide="hourglass" style="width:18px;height:18px;"></i></span><span class="dots">⋯</span></div>
        <b>{{ $demandesEnAttente }}</b>
        <div class="label">demandes en cours</div>
        <svg class="spark" viewBox="0 0 100 26" preserveAspectRatio="none"><path d="M0,14 Q20,20 40,12 T80,16 T100,9" fill="none" stroke="var(--orange)" stroke-width="2"/></svg>
        <a class="foot foot-orange" href="#">Voir mes demandes →</a>
      </div>
      <div class="stat-card">
        <div class="top"><span class="ico ico-green"><i data-lucide="check-circle-2" style="width:18px;height:18px;"></i></span><span class="dots">⋯</span></div>
        <b>{{ $congesApprouves }} <small>jours</small></b>
        <div class="label">cette année</div>
        <svg class="spark" viewBox="0 0 100 26" preserveAspectRatio="none"><path d="M0,20 Q20,16 35,17 T70,6 T100,10" fill="none" stroke="var(--green)" stroke-width="2"/></svg>
        <a class="foot foot-green" href="#">Voir l'historique →</a>
      </div>
      <div class="stat-card">
        <div class="top"><span class="ico ico-purple"><i data-lucide="plane" style="width:18px;height:18px;"></i></span><span class="dots">⋯</span></div>
        @if ($prochaineAbsence)
          <b style="font-size:17px;">{{ $prochaineAbsence->date_debut->format('d M') }} → {{ $prochaineAbsence->date_fin->format('d M') }}</b>
          <div class="label">{{ $prochaineAbsence->jours }} jours de congé</div>
        @else
          <b style="font-size:17px;">Aucune</b>
          <div class="label">rien de prévu</div>
        @endif
        <svg class="spark" viewBox="0 0 100 26" preserveAspectRatio="none"><path d="M0,10 Q20,18 40,14 T75,20 T100,12" fill="none" stroke="var(--purple)" stroke-width="2"/></svg>
        <a class="foot foot-purple" href="#">Voir le calendrier →</a>
      </div>
    </div>

    <!-- ===== DEMANDES + CALENDRIER ===== -->
    <div class="grid-2">
      <div class="card">
        <div class="card-head">
          <h2>Mes demandes récentes</h2>
          <a href="#">Voir tout →</a>
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
              <tr><td colspan="5" style="text-align:center; color:var(--text-dim);">Aucune demande pour l'instant.</td></tr>
            @endforelse
          </tbody>
        </table>
        <p id="rechercheVide" style="display:none; text-align:center; color:var(--text-dim); font-size:13px; padding:14px 0;">Aucun résultat pour cette recherche.</p>
      </div>

      <div class="card">
        <div class="cal-head">
          <h2 style="font-size:15.5px; font-weight:700;">Calendrier</h2>
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
    </div>

    <!-- ===== DONUT + COURBE MENSUELLE ===== -->
    <div class="grid-2b">
      <div class="card">
        <div class="card-head"><h2>Utilisation de vos congés</h2></div>
        <div class="donut-wrap">
          <div class="donut-ring">
            <svg viewBox="0 0 120 120" width="120" height="120" style="transform:rotate(-90deg);">
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
          <div class="donut-legend">
            <div class="row"><span class="dot" style="background:var(--blue);"></span> Utilisés <b style="margin-left:auto;">{{ $joursUtilises }} jours</b></div>
            <div class="row"><span class="dot" style="background:var(--green);"></span> Restants <b style="margin-left:auto;">{{ $soldeDisponible }} jours</b></div>
            <div class="row"><span class="dot" style="background:#475569;"></span> Total annuel <b style="margin-left:auto;">{{ $soldeAnnuel }} jours</b></div>
          </div>
        </div>
        <div class="donut-foot">
          <i data-lucide="trending-up" style="width:15px;height:15px;"></i>
          Vous avez utilisé {{ $joursUtilises }} jours sur {{ $soldeAnnuel }}. Il vous reste {{ $soldeDisponible }} jours disponibles.
        </div>
      </div>

      <div class="card" style="position:relative;">
        <div class="card-head">
          <h2>Congés utilisés par mois</h2>
          <select class="chart-select" id="anneeSelect">
            @foreach (array_keys($congesParMoisParAnnee) as $annee)
              <option value="{{ $annee }}" @selected($annee === $anneeActuelle)>{{ $annee }}</option>
            @endforeach
          </select>
        </div>
        <div style="position:relative;">
          <svg id="chartSvg" viewBox="0 0 600 130" width="100%" height="130"></svg>
          <div class="chart-tip" id="chartTip" style="display:none;"></div>
        </div>
        <div class="chart-months">
          @foreach (['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Août','Sep','Oct','Nov','Déc'] as $m)
            <span>{{ $m }}</span>
          @endforeach
        </div>
      </div>
    </div>

    <!-- ===== PROCHAINES ABSENCES + DOCUMENT ===== -->
    <div class="grid-2">
      <div class="card">
        <div class="card-head"><h2>Prochaines absences</h2><a href="#">Voir tout →</a></div>
        @forelse ($prochainesAbsences as $absence)
          <div class="absence-row">
            <div class="left">
              <span class="ico"><i data-lucide="{{ $absence->type === 'maladie' ? 'stethoscope' : 'plane' }}" style="width:16px;height:16px;"></i></span>
              <div>
                <p>{{ $libelles[$absence->type] ?? $absence->type }}</p>
                <span>{{ $absence->date_debut->format('d M') }} - {{ $absence->date_fin->format('d M') }} · {{ $absence->jours }} jours</span>
              </div>
            </div>
            <span class="badge-days">Dans {{ now()->diffInDays($absence->date_debut) }} jours</span>
          </div>
        @empty
          <p style="color:var(--text-dim); font-size:13px;">Aucune absence prévue.</p>
        @endforelse
      </div>

      <div class="doc-card">
        <span class="doc-ico"><i data-lucide="file-text" style="width:22px;height:22px;"></i></span>
        <h3>Besoin d'un document ?</h3>
        <p>Générez une attestation de congé pour votre demande.</p>
        <button class="btn-doc" id="genererDoc"><i data-lucide="download" style="width:15px;height:15px;"></i> Générer une attestation</button>
      </div>
    </div>

  </main>
</div>

<script>
  lucide.createIcons();

  /* ===================== CALENDRIER NAVIGABLE ===================== */
  // Toutes les demandes de l'utilisateur, envoyées par le contrôleur.
  const demandes = {{ Js::from($demandesCalendrier) }};

  const calGrid = document.getElementById('calGrid');
  const calLabel = document.getElementById('calLabel');
  const moisNoms = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

  let vueAnnee = new Date().getFullYear();
  let vueMois = new Date().getMonth(); // 0 = janvier

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

  // Sélecteurs rapides mois / année (en plus des flèches ‹ ›)
  const calMoisSelect = document.getElementById('calMoisSelect');
  const calAnneeSelect = document.getElementById('calAnneeSelect');

  moisNoms.forEach((nom, i) => {
    const opt = document.createElement('option');
    opt.value = i;
    opt.textContent = nom;
    calMoisSelect.appendChild(opt);
  });

  // Toutes les années, de 2001 à 2030
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

    const premierJour = (new Date(vueAnnee, vueMois, 1).getDay() + 6) % 7; // lundi = 0
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
    const max = Math.max(...valeurs, 1);
    const largeur = 600, hauteur = 110, pas = largeur / 11;

    const points = valeurs.map((v, i) => [i * pas, hauteur - (v / max) * hauteur]);
    const chemin = points.map((p, i) => (i === 0 ? 'M' : 'L') + p[0] + ',' + p[1]).join(' ');
    const zone = chemin + ` L${largeur},${hauteur} L0,${hauteur} Z`;

    let cercles = '';
    points.forEach((p, i) => {
      cercles += `<circle cx="${p[0]}" cy="${p[1]}" r="4" fill="#F59E0B" data-mois="${moisAbrev[i]}" data-valeur="${valeurs[i]}" style="cursor:pointer;" />`;
    });

    svg.innerHTML = `
      <defs>
        <linearGradient id="fillGrad" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0%" stop-color="#F59E0B" stop-opacity="0.35" />
          <stop offset="100%" stop-color="#F59E0B" stop-opacity="0" />
        </linearGradient>
      </defs>
      <path d="${zone}" fill="url(#fillGrad)" />
      <path d="${chemin}" fill="none" stroke="#F59E0B" stroke-width="2.5" />
      ${cercles}
    `;

    svg.querySelectorAll('circle').forEach(c => {
      c.addEventListener('mouseenter', (e) => {
        const rect = svg.getBoundingClientRect();
        const x = (parseFloat(c.getAttribute('cx')) / largeur) * rect.width;
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