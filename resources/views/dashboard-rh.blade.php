<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tableau de bord RH — NAJA7 HOST</title>
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

  .app{display:flex; align-items:flex-start; min-height:100vh; padding:16px 24px; gap:16px; max-width:1500px; margin:0 auto;}

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

  .main{flex:1; align-self:stretch; padding:6px 6px 40px; max-width:100%; overflow-x:hidden; position:relative;}

  .topbar{display:flex; align-items:center; justify-content:flex-end; margin-bottom:30px;}

  .top-right{display:flex; align-items:center; gap:14px; position:relative;}
  .icon-btn{position:relative; width:40px; height:40px; border-radius:14px; background:var(--panel); backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); display:flex; align-items:center; justify-content:center;}
  .icon-btn .dot{position:absolute; top:-3px; right:-3px; background:var(--red); color:#fff; font-size:9.5px; font-weight:700; width:17px; height:17px; border-radius:50%; display:flex; align-items:center; justify-content:center;}
  .user-chip{display:flex; align-items:center; gap:10px; cursor:pointer; background:var(--panel); backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:6px 14px 6px 6px;}
  .avatar{width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; overflow:hidden;}
  .avatar img{width:100%; height:100%; object-fit:cover; object-position:center top;}
  .user-chip p{font-size:13px; font-weight:600;}
  .user-chip span{font-size:11px; color:var(--text-dim);}

  .dropdown{position:absolute; top:52px; right:0; background:rgba(18,24,42,.85); backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:8px; width:230px; box-shadow:0 12px 30px rgba(0,0,0,.4); display:none; z-index:50;}
  .dropdown.open{display:block;}
  .dropdown-item{display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:11px; font-size:13px; width:100%; text-align:left;}
  .dropdown-item:hover{background:rgba(255,255,255,.05);}
  .notif-panel{position:absolute; top:52px; right:60px; background:rgba(18,24,42,.85); backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:10px; width:290px; box-shadow:0 12px 30px rgba(0,0,0,.4); display:none; z-index:50;}
  .notif-panel.open{display:block;}
  .notif-panel h4{font-size:12.5px; padding:6px 8px 10px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.03em;}
  .notif-item{display:flex; align-items:flex-start; gap:10px; padding:9px 8px; border-radius:11px; font-size:12.5px;}
  .notif-item:hover{background:rgba(255,255,255,.05);}
  .notif-item .n-ico{width:28px; height:28px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex:none; background:rgba(59,130,246,.15); color:var(--blue-2);}
  .notif-empty{padding:14px 8px; font-size:12.5px; color:var(--text-dim); text-align:center;}

  .greeting{margin-bottom:26px; position:relative;}
  .greeting h1{font-size:27px; font-weight:700; text-shadow:0 2px 12px rgba(0,0,0,.5);}
  .greeting p{color:var(--text-dim); font-size:13.5px; margin-top:4px; text-shadow:0 2px 8px rgba(0,0,0,.5); max-width:520px;}

  .kpi-row{display:grid; grid-template-columns:3fr 1.1fr; gap:16px; margin-bottom:16px; align-items:stretch;}
  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25);}
  .kpi-image-card{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:20px; box-shadow:0 8px 24px rgba(0,0,0,.25); display:flex; align-items:center; justify-content:center; overflow:hidden; min-height:100%;}
  .kpi-image-card img{width:100%; height:100%; object-fit:cover;}

  .stats-panel{display:flex; padding:28px 12px;}
  .stat-cell{flex:1; padding:0 14px; position:relative; display:flex; flex-direction:column; align-items:center; text-align:center;}
  .stat-cell + .stat-cell{border-left:1px solid var(--border);}
  .ring-wrap{position:relative; width:170px; height:170px; margin-bottom:12px; border-radius:50%; box-shadow:0 0 55px -8px var(--ring-c);}
  .ring-wrap svg circle.ring-glow{filter:drop-shadow(0 0 4px var(--ring-c));}
  .ring-center{position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center;}
  .ring-center b{font-size:27px; font-weight:700; color:#fff; line-height:1.05;}
  .ring-center .ring-sub1{font-size:12px; color:#fff; opacity:.9; margin-top:1px;}
  .ring-badge{width:24px; height:24px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:9px; margin-top:6px; box-shadow:0 0 10px var(--ring-c);}
  .stat-cell .foot-btn{display:inline-flex; align-items:center; gap:5px; font-size:12px; font-weight:700; color:#fff !important; padding:8px 16px; border-radius:999px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .stat-cell .foot-btn:hover{transform:translateY(-1px);}

  .triple-grid{display:grid; grid-template-columns:1.7fr 1.2fr 1fr; gap:12px; margin-bottom:12px; align-items:stretch;}
  .row2-grid{display:grid; grid-template-columns:0.9fr 1.5fr 0.8fr; gap:16px; margin-bottom:12px; height:180px;}
  .row2-grid > .panel{height:100%; padding:14px 16px; overflow:hidden; display:flex; flex-direction:column;}
  .insights-grid{display:grid; grid-template-columns:1.2fr 1.2fr 1.2fr 1fr; gap:16px;}
  @media (max-width:1100px){
    .triple-grid, .row2-grid, .insights-grid, .kpi-row{grid-template-columns:1fr;}
    .row2-grid{height:auto;}
  }

  .panel-pad{padding:20px;}
  .card-head{display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;}
  .card-head h2{position:relative; font-size:14px; font-weight:800; color:#fff; display:inline-flex; align-items:center; gap:8px;
    padding:11px 26px; background:linear-gradient(180deg,#3D7BFF 0%,#1E4FC4 55%,#123591 100%); border-radius:999px;
    box-shadow:0 6px 14px rgba(23,73,176,.5), inset 0 2px 0 rgba(255,255,255,.4), inset 0 -4px 8px rgba(0,0,0,.3);}
  .card-head .beta{position:relative; top:-2px;}
  .card-head a{font-size:12px; font-weight:700; color:#fff; display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:999px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .card-head a:hover{transform:translateY(-1px);}
  .card-head .beta{font-size:9px; background:var(--purple); padding:2px 6px; border-radius:8px; margin-left:6px; font-weight:700;}

  table{width:100%; border-collapse:collapse;}
  th{text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.03em; color:var(--text-dim); padding:0 8px 10px; font-weight:600;}
  td{padding:11px 8px; font-size:13px; border-top:1px solid var(--border); vertical-align:middle;}
  .emp-cell{display:flex; align-items:center; gap:9px;}
  .emp-avatar{width:30px; height:30px; border-radius:50%; background:var(--blue); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; flex:none; overflow:hidden;}
  .emp-avatar img{width:100%; height:100%; object-fit:cover; object-position:center top;}
  .emp-cell b{display:block; font-size:12.5px;}
  .emp-cell span{font-size:10.5px; color:var(--text-dim);}
  .badge{display:inline-flex; align-items:center; gap:5px; padding:4px 11px; border-radius:20px; font-size:11px; font-weight:600;}
  .badge-approved{background:rgba(16,185,129,.15); color:var(--green);}
  .badge-pending{background:rgba(245,158,11,.15); color:var(--orange);}
  .badge-rejected{background:rgba(239,68,68,.15); color:var(--red);}

  .cal-head{display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;}
  .cal-nav{display:flex; align-items:center; gap:8px;}
  .cal-nav button{width:26px; height:26px; border-radius:8px; background:var(--panel-2); display:flex; align-items:center; justify-content:center;}
  .cal-nav span{font-size:13px; font-weight:600; width:100px; text-align:center;}
  .btn-today{position:relative; overflow:hidden; font-size:11.5px; font-weight:700; padding:8px 14px; border-radius:999px; color:#fff;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .btn-today:hover{transform:translateY(-1px);}
  .cal-quickpick{display:flex; gap:8px; margin-bottom:8px;}
  .cal-quickpick select{background:#1a2338; border:1px solid var(--border); color:#fff; font-size:12px; padding:6px 8px; border-radius:8px; flex:1;}
  .cal-grid{display:grid; grid-template-columns:repeat(7,1fr); gap:4px; text-align:center;}
  .cal-grid .dow{font-size:10px; color:var(--text-dim); font-weight:600; padding-bottom:8px;}
  .cal-day{font-size:12px; padding:7px 0; border-radius:9px; color:var(--text);}
  .cal-day.approuve{background:var(--blue); color:#fff; font-weight:700;}
  .cal-day.absent{background:var(--red); color:#fff; font-weight:700;}
  .cal-day.en_attente{background:var(--orange); color:#fff; font-weight:700;}
  .cal-day.today{border:1.5px solid var(--purple); font-weight:700;}
  .cal-legend{display:flex; flex-wrap:wrap; gap:10px; margin-top:8px; font-size:10.5px; color:var(--text-dim);}
  .cal-legend .row{display:flex; align-items:center; gap:6px;}
  .dot{width:8px; height:8px; border-radius:50%; flex:none;}

  .donut-mini{display:flex; align-items:center; gap:16px;}
  .donut-legend{display:flex; flex-direction:column; gap:8px; font-size:11.5px;}
  .donut-legend .row{display:flex; align-items:center; gap:7px;}

  .action-tile{position:relative; overflow:hidden; display:flex; flex-direction:column; align-items:center; justify-content:center; gap:6px; height:70px; border-radius:20px; font-size:11px; font-weight:700; text-align:center; flex:1; color:#fff;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 8px 20px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .action-tile:hover{transform:translateY(-1px);}
  .action-tile .ico{width:26px; height:26px; border-radius:9px; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,.2); color:#fff;}

  .absence-row{display:flex; align-items:center; justify-content:space-between; background:var(--panel-2); border-radius:14px; padding:14px 16px; margin-bottom:10px;}
  .absence-row .left{display:flex; align-items:center; gap:12px;}
  .absence-row p{font-size:13.5px; font-weight:600;}
  .absence-row span{font-size:11.5px; color:var(--text-dim);}
  .badge-days{background:rgba(16,185,129,.15); color:var(--green); font-size:11px; font-weight:600; padding:5px 12px; border-radius:20px; white-space:nowrap;}

  .chart-select{background:#1a2338; border:1px solid var(--border); color:#fff; font-size:12px; padding:5px 10px; border-radius:8px;}
  select option{background:#1a2338; color:#fff;}
  .chart-months{display:grid; grid-template-columns:repeat(12,1fr); text-align:center; font-size:10px; color:var(--text-dim); margin-top:2px; padding-left:4.3%;}
  .chart-tip{position:absolute; background:#1a2338; border:1px solid var(--border); border-radius:9px; padding:5px 10px; font-size:11px; font-weight:600; white-space:nowrap; transform:translate(-50%,-130%); pointer-events:none;}

  .insight-item{display:flex; gap:10px; padding:10px 0; border-bottom:1px solid var(--border);}
  .insight-item:last-child{border-bottom:none;}
  .insight-item .ico{width:30px; height:30px; border-radius:9px; background:rgba(59,130,246,.15); color:var(--blue-2); display:flex; align-items:center; justify-content:center; flex:none;}
  .insight-item p{font-size:12px; line-height:1.4;}

  .dept-row{display:flex; align-items:center; gap:10px; padding:9px 0;}
  .dept-num{width:20px; height:20px; border-radius:50%; background:var(--panel-2); font-size:10px; font-weight:700; display:flex; align-items:center; justify-content:center; flex:none;}
  .dept-bar-track{flex:1; height:6px; border-radius:4px; background:var(--panel-2); overflow:hidden;}
  .dept-bar-fill{height:100%; background:linear-gradient(90deg,var(--blue),var(--purple));}
  .dept-row .val{font-size:11.5px; font-weight:600; white-space:nowrap;}

  .apercu-tile{background:var(--panel-2); border-radius:14px; padding:14px; text-align:center;}
  .apercu-tile .ico{width:30px; height:30px; border-radius:9px; background:rgba(59,130,246,.15); color:var(--blue-2); display:flex; align-items:center; justify-content:center; margin:0 auto 8px;}
  .apercu-tile b{display:block; font-size:19px; font-weight:700;}
  .apercu-tile span{font-size:9.5px; color:var(--text-dim);}
  .apercu-grid{display:grid; grid-template-columns:1fr 1fr; gap:10px;}

  @media (max-width:800px){
    .sidebar{display:none;}
    .search{width:220px;}
  }
</style>
</head>
<body>

<div class="app">

  <aside class="sidebar">
    <div class="side-logo">
      <img src="{{ asset('images/logo-naja7host.png') }}" alt="NAJA7HOST">
    </div>

    <nav class="side-nav">
      <a href="{{ route('dashboard') }}" class="side-link active"><i data-lucide="home" style="width:17px;height:17px;"></i><span class="tip">Tableau de bord</span></a>
      <a href="{{ route('conges.apercu') }}" class="side-link"><i data-lucide="calendar-heart" style="width:17px;height:17px;"></i><span class="tip">Congés &amp; Absences</span></a>
      <a href="{{ route('conges.index') }}" class="side-link"><i data-lucide="file-text" style="width:17px;height:17px;"></i><span class="tip">Demandes @if($demandesEnAttente>0)({{ $demandesEnAttente }})@endif</span></a>
      <a href="{{ route('employes.index') }}" class="side-link"><i data-lucide="users" style="width:17px;height:17px;"></i><span class="tip">Employés</span></a>
      <a href="{{ route('calendrier.index') }}" class="side-link"><i data-lucide="calendar-days" style="width:17px;height:17px;"></i><span class="tip">Calendrier équipe</span></a>
      <a href="{{ route('conges.index') }}" class="side-link"><i data-lucide="check-square" style="width:17px;height:17px;"></i><span class="tip">Validation @if($demandesEnAttente>0)({{ $demandesEnAttente }})@endif</span></a>
      <a href="{{ route('rapports.index') }}" class="side-link {{ request()->routeIs('rapports.*') ? 'active' : '' }}"><i data-lucide="file-bar-chart" style="width:17px;height:17px;"></i><span class="tip">Rapports</span></a>
      <a href="#" class="side-link"><i data-lucide="bar-chart-3" style="width:17px;height:17px;"></i><span class="tip">Statistiques</span></a>
      <a href="{{ route('profile.edit') }}" class="side-link"><i data-lucide="user" style="width:17px;height:17px;"></i><span class="tip">Mon profil</span></a>
      <a href="{{ route('settings.index') }}" class="side-link {{ request()->routeIs('settings.*') ? 'active' : '' }}"><i data-lucide="settings" style="width:17px;height:17px;"></i><span class="tip">Paramètres & Support</span></a>
    </nav>

    <div class="side-bottom">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="side-link"><i data-lucide="log-out" style="width:16px;height:16px;"></i><span class="tip">Déconnexion</span></button>
      </form>
    </div>
  </aside>

  <main class="main">

    <div class="topbar">
      <div class="top-right">
        <button class="icon-btn" id="notifBtn"><i data-lucide="bell" style="width:17px;height:17px;"></i>
          @if (auth()->user()->unreadNotifications->count() > 0)<span class="dot">{{ auth()->user()->unreadNotifications->count() }}</span>@endif
        </button>
        <div class="user-chip" id="userChip">
          <div class="avatar">
            @if (auth()->user()->photo_path)
              <img src="{{ asset('storage/'.auth()->user()->photo_path) }}" alt="">
            @else
              {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            @endif
          </div>
          <div>
            <p>{{ auth()->user()->name }}</p>
            <span>{{ auth()->user()->poste ?? 'Responsable RH' }}</span>
          </div>
          <i data-lucide="chevron-down" style="width:14px;height:14px; color:var(--text-dim);"></i>
        </div>

        <div class="notif-panel" id="notifPanel">
          <h4>Notifications</h4>
          @forelse (auth()->user()->unreadNotifications as $notification)
            <a href="{{ route('notifications.ouvrir', $notification->id) }}" class="notif-item">
              <span class="n-ico"><i data-lucide="{{ $notification->data['icone'] ?? 'bell' }}" style="width:14px;height:14px;"></i></span>
              <div>
                <b style="display:block;">{{ $notification->data['titre'] ?? '' }}</b>
                <span style="font-size:11px; color:var(--text-dim); display:block;">{{ $notification->data['message'] ?? '' }}</span>
              </div>
            </a>
          @empty
            <div class="notif-empty">Aucune notification récente.</div>
          @endforelse
        </div>

        <div class="dropdown" id="userMenu">
          <a href="{{ route('profile.edit') }}" class="dropdown-item"><i data-lucide="user" style="width:15px;height:15px;"></i> Mon profil</a>
          <a href="{{ route('settings.index') }}" class="dropdown-item"><i data-lucide="settings" style="width:15px;height:15px;"></i> Paramètres & Support</a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item"><i data-lucide="log-out" style="width:15px;height:15px;"></i> Se déconnecter</button>
          </form>
        </div>
      </div>
    </div>

    <div class="greeting">
      <h1>Bonjour, {{ explode(' ', auth()->user()->name)[0] }} !</h1>
      <p>Vue d'ensemble de l'activité de vos employés.</p>
    </div>

    <div class="kpi-row">
      <div class="panel stats-panel">
        @php
          $anneaux = [
            ['couleur' => '#3B82F6', 'icone' => 'users'],
            ['couleur' => '#F59E0B', 'icone' => 'clipboard-list'],
            ['couleur' => '#22C55E', 'icone' => 'calendar-check'],
            ['couleur' => '#8B5CF6', 'icone' => 'calendar-clock'],
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
              <circle class="ring-glow" cx="85" cy="85" r="74" fill="none" stroke="{{ $anneaux[0]['couleur'] }}" stroke-width="7" stroke-linecap="round" stroke-dasharray="{{ $motif }}" />
            </svg>
            <div class="ring-center">
              <div class="ring-badge" style="background:{{ $anneaux[0]['couleur'] }};"><i data-lucide="users" style="width:15px;height:15px; color:#fff;"></i></div>
              <b>{{ $totalEmployes }}</b>
              <div class="ring-sub1">employés</div>
            </div>
          </div>
          <a class="foot-btn" href="{{ route('employes.index') }}">Voir l'équipe</a>
        </div>

        <div class="stat-cell">
          <div class="ring-wrap" style="--ring-c: {{ $anneaux[1]['couleur'] }};">
            <svg viewBox="0 0 170 170" width="170" height="170" style="transform:rotate(-99deg); overflow:visible;">
              <circle cx="85" cy="85" r="74" fill="none" stroke="rgba(255,255,255,.06)" stroke-width="7" />
              <circle class="ring-glow" cx="85" cy="85" r="74" fill="none" stroke="{{ $anneaux[1]['couleur'] }}" stroke-width="7" stroke-linecap="round" stroke-dasharray="{{ $motif }}" />
            </svg>
            <div class="ring-center">
              <div class="ring-badge" style="background:{{ $anneaux[1]['couleur'] }};"><i data-lucide="clipboard-list" style="width:15px;height:15px; color:#fff;"></i></div>
              <b>{{ $demandesEnAttente }}</b>
              <div class="ring-sub1">en attente</div>
            </div>
          </div>
          <a class="foot-btn" href="{{ route('conges.index') }}">Voir les demandes</a>
        </div>

        <div class="stat-cell">
          <div class="ring-wrap" style="--ring-c: {{ $anneaux[2]['couleur'] }};">
            <svg viewBox="0 0 170 170" width="170" height="170" style="transform:rotate(-99deg); overflow:visible;">
              <circle cx="85" cy="85" r="74" fill="none" stroke="rgba(255,255,255,.06)" stroke-width="7" />
              <circle class="ring-glow" cx="85" cy="85" r="74" fill="none" stroke="{{ $anneaux[2]['couleur'] }}" stroke-width="7" stroke-linecap="round" stroke-dasharray="{{ $motif }}" />
            </svg>
            <div class="ring-center">
              <div class="ring-badge" style="background:{{ $anneaux[2]['couleur'] }};"><i data-lucide="calendar-check" style="width:15px;height:15px; color:#fff;"></i></div>
              <b>{{ $absencesAujourdhui }}</b>
              <div class="ring-sub1">absences aujourd'hui</div>
            </div>
          </div>
          <a class="foot-btn" href="{{ route('calendrier.index') }}">Voir le calendrier</a>
        </div>

        <div class="stat-cell">
          <div class="ring-wrap" style="--ring-c: {{ $anneaux[3]['couleur'] }};">
            <svg viewBox="0 0 170 170" width="170" height="170" style="transform:rotate(-99deg); overflow:visible;">
              <circle cx="85" cy="85" r="74" fill="none" stroke="rgba(255,255,255,.06)" stroke-width="7" />
              <circle class="ring-glow" cx="85" cy="85" r="74" fill="none" stroke="{{ $anneaux[3]['couleur'] }}" stroke-width="7" stroke-linecap="round" stroke-dasharray="{{ $motif }}" />
            </svg>
            <div class="ring-center">
              <div class="ring-badge" style="background:{{ $anneaux[3]['couleur'] }};"><i data-lucide="calendar-clock" style="width:15px;height:15px; color:#fff;"></i></div>
              <b>{{ $joursPrisCeMois }}</b>
              <div class="ring-sub1">jours pris ce mois</div>
            </div>
          </div>
          <a class="foot-btn" href="{{ route('rapports.index') }}">Voir les rapports</a>
        </div>
      </div>

      <div class="kpi-image-card">
        <img src="{{ asset('images/greeting-illustration.png') }}" alt="">
      </div>
    </div>

    <div class="triple-grid">
      <div class="panel panel-pad">
        <div class="card-head">
          <h2>Activité des employés</h2>
          <a href="{{ route('conges.index') }}">Voir tout</a>
        </div>
        <table>
          <thead>
            <tr><th>Employé</th><th>Type</th><th>Durée</th><th>Statut</th></tr>
          </thead>
          <tbody>
            @php
              $libellesType = ['paye' => 'Congé annuel', 'maladie' => 'Congé maladie', 'sans_solde' => 'Congé sans solde', 'exceptionnel' => 'Congé exceptionnel', 'rtt' => 'RTT / Récupération', 'autre' => 'Autre congé'];
              $badgeStatut = ['approuve' => 'badge-approved', 'en_attente' => 'badge-pending', 'refuse' => 'badge-rejected'];
              $labelStatut = ['approuve' => 'Approuvé', 'en_attente' => 'En attente', 'refuse' => 'Refusé'];
            @endphp
            @forelse ($activiteRecente as $demande)
              <tr>
                <td>
                  <div class="emp-cell">
                    <span class="emp-avatar">
                      @if ($demande->user && $demande->user->photo_path)
                        <img src="{{ asset('storage/'.$demande->user->photo_path) }}" alt="">
                      @else
                        {{ strtoupper(substr($demande->user->name ?? '?',0,1)) }}
                      @endif
                    </span>
                    <div>
                      <b>{{ $demande->user->name ?? 'Employé supprimé' }}</b>
                      <span>{{ $demande->user->poste ?? '' }}</span>
                    </div>
                  </div>
                </td>
                <td>{{ $libellesType[$demande->type] ?? $demande->type }}</td>
                <td>{{ $demande->jours }} jours</td>
                <td><span class="badge {{ $badgeStatut[$demande->statut] }}">{{ $labelStatut[$demande->statut] }}</span></td>
              </tr>
            @empty
              <tr><td colspan="4" style="padding:26px 0;">
                <div style="display:flex; flex-direction:column; align-items:center; gap:8px; color:var(--text-dim);">
                  <span style="width:42px; height:42px; border-radius:50%; background:rgba(255,255,255,.06); display:flex; align-items:center; justify-content:center;"><i data-lucide="inbox" style="width:20px;height:20px;"></i></span>
                  <span style="font-size:13px; font-weight:600; color:#fff;">Aucune activité pour l'instant</span>
                </div>
              </td></tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="panel panel-pad">
        <div class="cal-head">
          <h2 style="font-size:15.5px; font-weight:700;">Calendrier RH</h2>
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
          <span class="row"><span class="dot" style="background:var(--red);"></span> Absence (maladie)</span>
        </div>
      </div>

      <div style="display:flex; flex-direction:column; gap:12px;">
        <div class="panel panel-pad">
          <div class="card-head"><h2>Résumé des employés</h2></div>
          @php
            $totalPourDonut = max($totalEmployes, 1);
            $circonfResume = 2 * pi() * 34;
            $pctActifs = $actifsAujourdhui / $totalPourDonut;
            $pctConge = $congeAujourdhui / $totalPourDonut;
            $pctAbsent = $absentsAujourdhui / $totalPourDonut;
          @endphp
          <div class="donut-mini">
            <div style="position:relative; width:84px; height:84px; flex:none;">
              <svg viewBox="0 0 84 84" width="84" height="84" style="transform:rotate(-90deg);">
                <circle cx="42" cy="42" r="34" fill="none" stroke="var(--panel-2)" stroke-width="9" />
                <circle cx="42" cy="42" r="34" fill="none" stroke="var(--blue)" stroke-width="9"
                  stroke-dasharray="{{ $circonfResume * $pctActifs }} {{ $circonfResume }}" />
                <circle cx="42" cy="42" r="34" fill="none" stroke="var(--green)" stroke-width="9"
                  stroke-dasharray="{{ $circonfResume * $pctConge }} {{ $circonfResume }}"
                  stroke-dashoffset="{{ -$circonfResume * $pctActifs }}" />
                <circle cx="42" cy="42" r="34" fill="none" stroke="var(--red)" stroke-width="9"
                  stroke-dasharray="{{ $circonfResume * $pctAbsent }} {{ $circonfResume }}"
                  stroke-dashoffset="{{ -$circonfResume * ($pctActifs + $pctConge) }}" />
              </svg>
              <div style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <b style="font-size:18px; font-weight:700; line-height:1;">{{ $totalEmployes }}</b>
                <span style="font-size:8.5px; color:var(--text-dim);">total</span>
              </div>
            </div>
            <div class="donut-legend">
              <div class="row"><span class="dot" style="background:var(--blue);"></span> Actifs <b style="margin-left:auto;">{{ $actifsAujourdhui }}</b></div>
              <div class="row"><span class="dot" style="background:var(--green);"></span> En congé <b style="margin-left:auto;">{{ $congeAujourdhui }}</b></div>
              <div class="row"><span class="dot" style="background:var(--red);"></span> Absents <b style="margin-left:auto;">{{ $absentsAujourdhui }}</b></div>
            </div>
          </div>
        </div>

        <div class="panel panel-pad">
          <div class="card-head"><h2>Actions rapides</h2></div>
          <div style="display:flex; gap:10px;">
            <button type="button" id="genererRapport" class="action-tile tile-orange"><span class="ico"><i data-lucide="file-down" style="width:14px;height:14px;"></i></span> Générer rapport</button>
            <a href="{{ route('conges.index') }}" class="action-tile tile-blue"><span class="ico"><i data-lucide="check-square" style="width:14px;height:14px;"></i></span> Valider les demandes</a>
          </div>
        </div>
      </div>
    </div>

    <div class="row2-grid">
      <div class="panel">
        <div class="card-head"><h2>Statut de l'équipe</h2></div>
        <div style="display:flex; flex-direction:column; justify-content:center; gap:10px; flex:1;">
          <div style="display:flex; align-items:center; justify-content:space-between; font-size:12px;">
            <span style="color:var(--text-dim);">Actifs aujourd'hui</span><b>{{ $actifsAujourdhui }} / {{ $totalEmployes }}</b>
          </div>
          <div style="display:flex; align-items:center; justify-content:space-between; font-size:12px;">
            <span style="color:var(--text-dim);">En congé aujourd'hui</span><b>{{ $congeAujourdhui }}</b>
          </div>
          <div style="display:flex; align-items:center; justify-content:space-between; font-size:12px;">
            <span style="color:var(--text-dim);">Demandes en attente</span><b>{{ $demandesEnAttente }}</b>
          </div>
        </div>
      </div>

      <div class="panel" style="position:relative;">
        <div class="card-head">
          <h2>Congés utilisés par mois (équipe)</h2>
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

      <div class="panel">
        <div class="card-head"><h2>Prochaines absences</h2><a href="{{ route('conges.apercu') }}">Voir tout</a></div>
        @forelse ($prochainesAbsences as $absence)
          <div class="absence-row">
            <div class="left">
              <span class="emp-avatar">
                @if ($absence->user && $absence->user->photo_path)
                  <img src="{{ asset('storage/'.$absence->user->photo_path) }}" alt="">
                @else
                  {{ strtoupper(substr($absence->user->name ?? '?',0,1)) }}
                @endif
              </span>
              <div>
                <p>{{ $absence->user->name ?? '—' }}</p>
                <span>{{ $absence->date_debut->format('d M') }} - {{ $absence->date_fin->format('d M') }}</span>
              </div>
            </div>
            <span class="badge-days">Dans {{ now()->startOfDay()->diffInDays($absence->date_debut->copy()->startOfDay()) }} j</span>
          </div>
        @empty
          <p style="color:var(--text-dim); font-size:12px; text-align:center; padding:20px 0;">Aucune absence prévue.</p>
        @endforelse
      </div>
    </div>

    <div class="insights-grid">
      <div class="panel panel-pad">
        <div class="card-head"><h2>Insights intelligents <span class="beta">BETA</span></h2></div>

        @if (!is_null($variationDemandes))
          <div class="insight-item">
            <span class="ico"><i data-lucide="trending-up" style="width:14px;height:14px;"></i></span>
            <div>
              <p>Les demandes de congés ont {{ $variationDemandes >= 0 ? 'augmenté' : 'diminué' }} de {{ abs($variationDemandes) }}% par rapport au mois dernier.</p>
            </div>
          </div>
        @endif

        @if ($jourLePlusDemande)
          <div class="insight-item">
            <span class="ico"><i data-lucide="calendar-search" style="width:14px;height:14px;"></i></span>
            <div>
              <p>Le {{ $jourLePlusDemande['date'] }} est le jour le plus demandé ({{ $jourLePlusDemande['nombre'] }} demande(s)).</p>
            </div>
          </div>
        @endif

        @if ($departementPlusAbsences->isNotEmpty())
          <div class="insight-item">
            <span class="ico"><i data-lucide="building-2" style="width:14px;height:14px;"></i></span>
            <div>
              <p>Le département <b>{{ $departementPlusAbsences->keys()->first() }}</b> a le plus haut total de jours d'absence ({{ $departementPlusAbsences->first() }} j).</p>
            </div>
          </div>
        @endif

        @if (is_null($variationDemandes) && !$jourLePlusDemande && $departementPlusAbsences->isEmpty())
          <p style="color:var(--text-dim); font-size:12px;">Pas encore assez de données pour générer des insights.</p>
        @endif
      </div>

      <div class="panel panel-pad">
        <div class="card-head"><h2>Top départements <span style="font-size:10.5px; color:var(--text-dim); font-weight:400;">(jours d'absence)</span></h2></div>
        @forelse ($topDepartements as $departement => $jours)
          <div class="dept-row">
            <span class="dept-num">{{ $loop->iteration }}</span>
            <span style="flex:1; font-size:12px;">{{ $departement }}</span>
            <div class="dept-bar-track" style="max-width:70px;">
              <div class="dept-bar-fill" style="width:{{ $topDepartements->max() > 0 ? round(($jours / $topDepartements->max()) * 100) : 0 }}%;"></div>
            </div>
            <span class="val">{{ $jours }} j</span>
          </div>
        @empty
          <p style="color:var(--text-dim); font-size:12px;">Renseigne le département de tes employés pour voir ce classement.</p>
        @endforelse
      </div>

      <div class="panel panel-pad" style="grid-column: span 2;">
        <div class="card-head"><h2>Aperçu rapide</h2></div>
        <div class="apercu-grid">
          <div class="apercu-tile">
            <span class="ico"><i data-lucide="calendar-check" style="width:15px;height:15px;"></i></span>
            <b>{{ str_pad($congeAujourdhui, 2, '0', STR_PAD_LEFT) }}</b>
            <span>En congé aujourd'hui</span>
          </div>
          <div class="apercu-tile">
            <span class="ico"><i data-lucide="user-x" style="width:15px;height:15px;"></i></span>
            <b>{{ str_pad($absentsAujourdhui, 2, '0', STR_PAD_LEFT) }}</b>
            <span>Absents (maladie)</span>
          </div>
          <div class="apercu-tile">
            <span class="ico"><i data-lucide="clipboard-list" style="width:15px;height:15px;"></i></span>
            <b>{{ str_pad($demandesEnAttente, 2, '0', STR_PAD_LEFT) }}</b>
            <span>Demandes en attente</span>
          </div>
          <div class="apercu-tile">
            <span class="ico"><i data-lucide="calendar-days" style="width:15px;height:15px;"></i></span>
            <b>{{ str_pad($joursPrisCeMois, 2, '0', STR_PAD_LEFT) }}</b>
            <span>Jours pris ce mois</span>
          </div>
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

  document.getElementById('genererRapport').addEventListener('click', () => {
    alert('Rapport RH à générer (fonctionnalité PDF à venir)');
  });

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

    for (let i = 0; i < premierJour; i++) calGrid.appendChild(document.createElement('div'));

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

  document.getElementById('calPrev').addEventListener('click', () => { vueMois--; if (vueMois < 0) { vueMois = 11; vueAnnee--; } dessinerCalendrier(); });
  document.getElementById('calNext').addEventListener('click', () => { vueMois++; if (vueMois > 11) { vueMois = 0; vueAnnee++; } dessinerCalendrier(); });
  document.getElementById('calToday').addEventListener('click', () => { vueAnnee = new Date().getFullYear(); vueMois = new Date().getMonth(); dessinerCalendrier(); });
  calMoisSelect.addEventListener('change', () => { vueMois = parseInt(calMoisSelect.value); dessinerCalendrier(); });
  calAnneeSelect.addEventListener('change', () => { vueAnnee = parseInt(calAnneeSelect.value); dessinerCalendrier(); });
  dessinerCalendrier();

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
      cercles += `<circle cx="${p[0]}" cy="${p[1]}" r="4" fill="#3B82F6" data-mois="${moisAbrev[i]}" data-valeur="${valeurs[i]}" style="cursor:pointer;" />`;
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
          <stop offset="0%" stop-color="#3B82F6" stop-opacity="0.35" />
          <stop offset="100%" stop-color="#3B82F6" stop-opacity="0" />
        </linearGradient>
      </defs>
      ${axeY}
      <path d="${zone}" fill="url(#fillGrad)" />
      <path d="${chemin}" fill="none" stroke="#3B82F6" stroke-width="2.5" />
      ${cercles}
    `;

    svg.querySelectorAll('circle').forEach(c => {
      c.addEventListener('mouseenter', () => {
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
  document.getElementById('anneeSelect').addEventListener('change', (e) => dessinerGraphique(parseInt(e.target.value)));
</script>
</body>
</html>