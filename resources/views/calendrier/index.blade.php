<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $estRh ? 'Calendrier équipe' : 'Mon calendrier' }} — NAJA7 HOST</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<style>
  :root{
    --blue:#3B82F6; --blue-2:#60A5FA;
    --orange:#F59E0B; --amber:#FBBF24; --green:#10B981; --red:#EF4444; --purple:#8B5CF6; --pink:#EC4899; --cyan:#22D3EE;
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
  select{font-family:inherit;}

  .app{display:flex; align-items:flex-start; min-height:100vh; padding:16px 24px; gap:16px; max-width:1500px; margin:0 auto; overflow-x:hidden;}

  .sidebar{width:64px; flex:none; align-self:flex-start; position:sticky; top:16px; z-index:100; background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:32px; padding:14px 0 16px; display:flex; flex-direction:column; align-items:center; box-shadow:0 8px 32px rgba(0,0,0,.35); max-height:94vh;}
  .side-logo{width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; margin-bottom:12px; font-weight:700; font-size:15px; color:#fff; overflow:hidden; flex:none;}
  .side-logo img{width:100%; height:100%; object-fit:cover;}
  .side-nav{display:flex; flex-direction:column; gap:3px; flex:1;}
  .side-link{position:relative; width:36px; height:36px; border-radius:11px; display:flex; align-items:center; justify-content:center; color:var(--text-dim); flex:none;}
  .side-link:hover{background:rgba(255,255,255,.08); color:#fff;}
  .side-link.active{background:var(--orange); color:#fff;}
  .side-link .tip{position:absolute; left:48px; top:50%; transform:translateY(-50%); background:rgba(20,26,46,.92); backdrop-filter:blur(10px); padding:6px 12px; border-radius:8px; font-size:12px; white-space:nowrap; opacity:0; pointer-events:none; transition:opacity .15s; z-index:30; border:1px solid var(--border);}
  .side-link:hover .tip{opacity:1;}
  .side-bottom{display:flex; flex-direction:column; gap:4px; padding-top:8px; margin-top:6px; border-top:1px solid var(--border); align-items:center; flex:none;}

  .main{flex:1; align-self:stretch; padding:6px 6px 40px; max-width:100%; overflow-x:hidden;}

  .header{display:flex; align-items:center; justify-content:space-between; margin-bottom:22px; flex-wrap:wrap; gap:14px;}
  .header-left h1{position:relative; font-size:16px; font-weight:800; color:#fff; display:inline-flex; align-items:center; gap:8px;
    padding:12px 28px; background:linear-gradient(180deg,#3D7BFF 0%,#1E4FC4 55%,#123591 100%); border-radius:999px;
    box-shadow:0 6px 14px rgba(23,73,176,.5), inset 0 2px 0 rgba(255,255,255,.4), inset 0 -4px 8px rgba(0,0,0,.3);}
  .header-left p{color:var(--text-dim); font-size:13.5px; margin-top:4px; text-shadow:0 2px 8px rgba(0,0,0,.5); max-width:520px;}
  .icon-btn{position:relative; width:38px; height:38px; border-radius:12px; background:var(--panel); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; flex:none;}
  .icon-btn .dot{position:absolute; top:-3px; right:-3px; background:var(--red); color:#fff; font-size:9px; font-weight:700; width:16px; height:16px; border-radius:50%; display:flex; align-items:center; justify-content:center;}

  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25);}

  .cal-toolbar{display:flex; align-items:center; justify-content:space-between; padding:16px 20px; flex-wrap:wrap; gap:12px; margin-bottom:16px;}
  .cal-nav{display:flex; align-items:center; gap:8px; flex:none;}
  .cal-nav-arrow{width:32px; height:32px; border-radius:10px; background:var(--panel-2); display:flex; align-items:center; justify-content:center;}
  .cal-nav-arrow:hover{background:rgba(255,255,255,.1);}
  .btn-today{position:relative; overflow:hidden; font-size:12.5px; font-weight:700; padding:8px 16px; border-radius:10px; color:#fff; white-space:nowrap; flex:none;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 14px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .btn-today:hover{filter:brightness(1.1);}
  .cal-label{font-size:16px; font-weight:800; margin:0 4px; display:flex; align-items:center; gap:8px;}

  .cal-right-controls{display:flex; align-items:center; gap:10px; flex-wrap:wrap;}
  .type-select{background:var(--panel-2); border:1px solid var(--border); color:#fff; font-size:12.5px; font-weight:600; padding:9px 12px; border-radius:10px;}
  .type-select option{background:#141b30; color:#fff;}
  .cal-mois-select{display:flex; gap:8px;}
  .cal-mois-select select{background:var(--panel-2); border:1px solid var(--border); color:#fff; font-size:12.5px; font-weight:600; padding:8px 10px; border-radius:10px;}
  .cal-mois-select select option{background:#141b30; color:#fff;}

  .layout{display:grid; grid-template-columns:230px 1fr; gap:16px; align-items:start;}
  .layout.employe-layout{grid-template-columns:1fr 300px;}
  @media (max-width:1050px){ .layout, .layout.employe-layout{grid-template-columns:1fr;} }

  .dept-title{font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.04em; margin-bottom:10px; display:flex; justify-content:space-between;}
  .dept-list-item{display:flex; align-items:center; gap:9px; padding:9px 10px; border-radius:11px; font-size:13px; color:var(--text-dim); margin-bottom:2px;}
  .dept-list-item:hover{background:rgba(255,255,255,.06); color:#fff;}
  .dept-list-item.active{background:rgba(59,130,246,.18); color:var(--blue-2); font-weight:700;}
  .dept-list-item .puce{width:8px; height:8px; border-radius:50%; flex:none;}
  .dept-list-item .count{margin-left:auto; font-size:11.5px; color:var(--text-dim);}
  .dept-list-item.active .count{color:var(--blue-2);}

  .apercu-rapide h3{font-size:13px; font-weight:800; margin-bottom:14px;}
  .apercu-donut-wrap{position:relative; width:104px; height:104px; margin:0 auto 16px;}
  .apercu-donut-center{position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center;}
  .apercu-donut-center b{font-size:24px; font-weight:800; color:#fff;}
  .apercu-stat-row{display:flex; align-items:center; gap:8px; font-size:12.5px; padding:6px 0;}
  .apercu-stat-row .puce{width:9px; height:9px; border-radius:3px; flex:none;}
  .apercu-stat-row b{margin-left:auto;}

  .legend{display:flex; flex-wrap:wrap; gap:12px; padding:0 20px 18px; font-size:11.5px; color:var(--text-dim);}
  .legend .row{display:flex; align-items:center; gap:6px;}
  .legend .puce{width:9px; height:9px; border-radius:4px; flex:none;}

  /* ===== Grille RH (puces par jour, inchangée) ===== */
  .cal-grid{display:grid; grid-template-columns:repeat(7, minmax(0, 1fr)); border-top:1px solid var(--border); border-left:1px solid var(--border); width:100%; overflow:hidden;}
  .cal-dow{font-size:11px; font-weight:700; color:var(--text-dim); text-align:center; padding:9px 0; border-right:1px solid var(--border); border-bottom:1px solid var(--border); text-transform:uppercase; letter-spacing:.03em;}
  .cal-cell{min-height:128px; min-width:0; border-right:1px solid var(--border); border-bottom:1px solid var(--border); padding:8px; display:flex; flex-direction:column; gap:6px; overflow:hidden;}
  .cal-cell.hors-mois{opacity:.35;}
  .cal-cell .num{font-size:12px; color:var(--text-dim); width:22px; height:22px; display:flex; align-items:center; justify-content:center;}
  .cal-cell.aujourdhui .num{background:var(--blue); color:#fff; border-radius:50%; font-weight:700;}
  .cal-item{display:flex; align-items:center; gap:7px; padding:6px 7px; border-radius:10px; overflow:hidden; min-width:0;}
  .cal-item .av{width:22px; height:22px; border-radius:50%; background:var(--blue); display:flex; align-items:center; justify-content:center; font-size:9px; font-weight:700; color:#fff; flex:none; overflow:hidden;}
  .cal-item .av img{width:100%; height:100%; object-fit:cover; object-position:center top;}
  .cal-item .txt{min-width:0; flex:1; line-height:1.25;}
  .cal-item .txt b{display:block; font-size:10.5px; font-weight:700; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
  .cal-item .txt span{display:flex; align-items:center; gap:3px; font-size:9px; font-weight:600; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
  .cal-item .txt span i{width:9px; height:9px; flex:none;}
  .cal-item.conge{background:rgba(16,185,129,.16);} .cal-item.conge .txt span{color:var(--green);}
  .cal-item.maladie{background:rgba(239,68,68,.16);} .cal-item.maladie .txt span{color:var(--red);}
  .cal-item.attente{background:rgba(245,158,11,.16);} .cal-item.attente .txt span{color:var(--orange);}
  .cal-item.autre{background:rgba(96,165,250,.16);} .cal-item.autre .txt span{color:var(--blue-2);}
  .cal-item-more{font-size:10px; color:var(--text-dim); padding-left:2px;}

  /* ===== Grille employé (barres façon maquette) ===== */
  .week-dow-row{display:grid; grid-template-columns:repeat(7, minmax(0, 1fr)); border-top:1px solid var(--border); border-left:1px solid var(--border);}
  .week-row{position:relative; display:grid; grid-template-columns:repeat(7, minmax(0, 1fr)); border-left:1px solid var(--border);}
  .week-daycell{min-height:96px; border-right:1px solid var(--border); border-bottom:1px solid var(--border); padding:8px;}
  .week-daycell.hors-mois{opacity:.35;}
  .week-daycell .num{font-size:12px; color:var(--text-dim); width:22px; height:22px; display:flex; align-items:center; justify-content:center;}
  .week-daycell.aujourdhui .num{background:var(--blue); color:#fff; border-radius:50%; font-weight:700;}
  .week-bars{position:absolute; left:0; right:0; top:32px; height:0; pointer-events:none;}
  .week-bar{position:absolute; height:24px; border-radius:8px; display:flex; align-items:center; padding:0 10px; font-size:11px; font-weight:700; color:#fff; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; box-shadow:0 4px 10px rgba(0,0,0,.25);}

  /* ===== Panneau droit employé ===== */
  .side-stack{display:flex; flex-direction:column; gap:16px;}
  .stats-card{padding:20px;}
  .stats-card h3{font-size:14px; font-weight:800; color:#fff; margin-bottom:14px;}
  .stat-line{display:flex; align-items:center; gap:12px; padding:11px 0; border-bottom:1px solid var(--border);}
  .stat-line:last-child{border-bottom:none;}
  .stat-line .ico{width:38px; height:38px; border-radius:12px; display:flex; align-items:center; justify-content:center; flex:none;}
  .stat-line b{display:block; font-size:19px; font-weight:800; color:#fff; line-height:1.1;}
  .stat-line span{font-size:11.5px; color:var(--text-dim);}

  .prochains-card{padding:18px;}
  .prochains-head{display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;}
  .prochains-head h3{font-size:14px; font-weight:800; color:#fff;}
  .prochain-item{display:flex; align-items:center; gap:12px; padding:10px 0; border-left:3px solid var(--c); padding-left:12px; margin-bottom:8px;}
  .prochain-item b{display:block; font-size:13px; font-weight:700;}
  .prochain-item span{font-size:11.5px; color:var(--text-dim);}
  .prochain-badge{margin-left:auto; background:var(--panel-2); color:var(--text-dim); font-size:11px; font-weight:700; padding:4px 10px; border-radius:20px; flex:none;}
  .voir-tout-link{display:block; text-align:center; font-size:12.5px; font-weight:700; color:var(--blue-2); margin-top:6px;}
  .prochains-empty{font-size:12.5px; color:var(--text-dim); text-align:center; padding:14px 0;}

  .note-card{padding:18px; display:flex; align-items:center; gap:14px;}
  .note-card img{width:64px; height:64px; object-fit:contain; flex:none; opacity:.85;}
  .note-card p{font-size:12px; color:var(--text-dim); line-height:1.5;}

  @media (max-width:800px){ .sidebar{display:none;} }
  @media (max-width:700px){ .cal-grid, .week-dow-row, .week-row{grid-template-columns:repeat(7, minmax(76px,1fr)); overflow-x:auto;} }
</style>
</head>
<body>

<div class="app">

  <aside class="sidebar">
    <div class="side-logo"><img src="{{ asset('images/logo-naja7host.png') }}" alt="NAJA7HOST"></div>
    <nav class="side-nav">
      @if ($estRh)
        <a href="{{ route('dashboard') }}" class="side-link"><i data-lucide="home" style="width:17px;height:17px;"></i><span class="tip">Tableau de bord</span></a>
        <a href="{{ route('conges.apercu') }}" class="side-link"><i data-lucide="calendar-heart" style="width:17px;height:17px;"></i><span class="tip">Congés &amp; Absences</span></a>
        <a href="{{ route('conges.index') }}" class="side-link"><i data-lucide="file-text" style="width:17px;height:17px;"></i><span class="tip">Demandes</span></a>
        <a href="{{ route('employes.index') }}" class="side-link"><i data-lucide="users" style="width:17px;height:17px;"></i><span class="tip">Employés</span></a>
        <a href="{{ route('calendrier.index') }}" class="side-link active"><i data-lucide="calendar-days" style="width:17px;height:17px;"></i><span class="tip">Calendrier équipe</span></a>
        <a href="{{ route('conges.index') }}" class="side-link"><i data-lucide="check-square" style="width:17px;height:17px;"></i><span class="tip">Validation</span></a>
        <a href="#" class="side-link"><i data-lucide="file-bar-chart" style="width:17px;height:17px;"></i><span class="tip">Rapports</span></a>
        <a href="#" class="side-link"><i data-lucide="bar-chart-3" style="width:17px;height:17px;"></i><span class="tip">Statistiques</span></a>
        <a href="{{ route('profile.edit') }}" class="side-link"><i data-lucide="user" style="width:17px;height:17px;"></i><span class="tip">Mon profil</span></a>
        <a href="#" class="side-link"><i data-lucide="settings" style="width:17px;height:17px;"></i><span class="tip">Paramètres</span></a>
      @else
        <a href="{{ route('dashboard') }}" class="side-link"><i data-lucide="layout-dashboard" style="width:17px;height:17px;"></i><span class="tip">Tableau de bord</span></a>
        <a href="{{ route('conges.mesDemandes') }}" class="side-link"><i data-lucide="file-text" style="width:17px;height:17px;"></i><span class="tip">Mes demandes</span></a>
        <a href="{{ route('conges.create') }}" class="side-link"><i data-lucide="plus-circle" style="width:17px;height:17px;"></i><span class="tip">Nouvelle demande</span></a>
        <a href="{{ route('calendrier.index') }}" class="side-link active"><i data-lucide="calendar-days" style="width:17px;height:17px;"></i><span class="tip">Calendrier</span></a>
        <a href="#" class="side-link"><i data-lucide="wallet" style="width:17px;height:17px;"></i><span class="tip">Mon solde</span></a>
        <a href="#" class="side-link"><i data-lucide="history" style="width:17px;height:17px;"></i><span class="tip">Historique</span></a>
        <a href="{{ route('profile.edit') }}" class="side-link"><i data-lucide="user" style="width:17px;height:17px;"></i><span class="tip">Mon profil</span></a>
        <a href="#" class="side-link"><i data-lucide="settings" style="width:17px;height:17px;"></i><span class="tip">Paramètres</span></a>
      @endif
    </nav>
    <div class="side-bottom">
      <a href="#" class="side-link"><i data-lucide="headphones" style="width:16px;height:16px;"></i><span class="tip">Support{{ $estRh ? ' RH' : '' }}</span></a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="side-link"><i data-lucide="log-out" style="width:16px;height:16px;"></i><span class="tip">Déconnexion</span></button>
      </form>
    </div>
  </aside>

  <main class="main">

    <div class="header">
      <div class="header-left">
        <h1>{{ $estRh ? 'Calendrier équipe' : 'Mon calendrier' }}</h1>
        <p>{{ $estRh ? "Visualisez les congés et absences de votre équipe en un coup d'œil" : 'Consultez uniquement vos congés et absences' }}</p>
      </div>
      <button class="icon-btn"><i data-lucide="bell" style="width:16px;height:16px;"></i></button>
    </div>

    <div class="layout {{ $estRh ? '' : 'employe-layout' }}">

      @if ($estRh)
      <!-- ===== COLONNE GAUCHE : départements + aperçu rapide (RH uniquement) ===== -->
      <div style="display:flex; flex-direction:column; gap:16px;">

        <div class="panel" style="padding:20px;">
          <div class="dept-title"><span>Départements</span><span>{{ $totalEmployes }}</span></div>

          @php $couleursDept = ['var(--blue)','var(--purple)','var(--green)','var(--orange)','#F97316','var(--cyan)','var(--pink)']; @endphp

          <a href="{{ route('calendrier.index', array_filter(['mois' => $moisParam])) }}"
             class="dept-list-item {{ !$departementFiltre ? 'active' : '' }}">
            <span class="puce" style="background:var(--text-dim);"></span> Tous les départements
            <span class="count">{{ $totalEmployes }}</span>
          </a>

          @foreach ($departements as $dep => $total)
            <a href="{{ route('calendrier.index', array_filter(['departement' => $dep, 'mois' => $moisParam])) }}"
               class="dept-list-item {{ $departementFiltre === $dep ? 'active' : '' }}">
              <span class="puce" style="background:{{ $couleursDept[$loop->index % count($couleursDept)] }};"></span>
              {{ $dep }}
              <span class="count">{{ $total }}</span>
            </a>
          @endforeach
        </div>

        <div class="panel apercu-rapide" style="padding:20px;">
          <h3>Aperçu rapide</h3>
          @php
            $totalApercu = max($congesApprouvesMois + $enAttenteMois + $refuseesMois, 1);
            $circonfApercu = 2 * pi() * 40;
            $pctApprouves = $congesApprouvesMois / $totalApercu;
            $pctAttente = $enAttenteMois / $totalApercu;
            $pctRefuses = $refuseesMois / $totalApercu;
          @endphp
          <div class="apercu-donut-wrap">
            <svg viewBox="0 0 104 104" width="104" height="104" style="transform:rotate(-90deg);">
              <circle cx="52" cy="52" r="40" fill="none" stroke="var(--panel-2)" stroke-width="11" />
              <circle cx="52" cy="52" r="40" fill="none" stroke="var(--blue)" stroke-width="11"
                stroke-dasharray="{{ $circonfApercu * $pctApprouves }} {{ $circonfApercu }}" />
              <circle cx="52" cy="52" r="40" fill="none" stroke="var(--orange)" stroke-width="11"
                stroke-dasharray="{{ $circonfApercu * $pctAttente }} {{ $circonfApercu }}"
                stroke-dashoffset="{{ -$circonfApercu * $pctApprouves }}" />
              <circle cx="52" cy="52" r="40" fill="none" stroke="var(--red)" stroke-width="11"
                stroke-dasharray="{{ $circonfApercu * $pctRefuses }} {{ $circonfApercu }}"
                stroke-dashoffset="{{ -$circonfApercu * ($pctApprouves + $pctAttente) }}" />
            </svg>
            <div class="apercu-donut-center"><b>{{ $totalDemandesMois }}</b></div>
          </div>
          <div class="apercu-stat-row"><span class="puce" style="background:var(--blue);"></span> Congés approuvés <b>{{ $congesApprouvesMois }}</b></div>
          <div class="apercu-stat-row"><span class="puce" style="background:var(--orange);"></span> En attente <b>{{ $enAttenteMois }}</b></div>
          <div class="apercu-stat-row"><span class="puce" style="background:var(--red);"></span> Refusés <b>{{ $refuseesMois }}</b></div>
          <div class="apercu-stat-row"><span class="puce" style="background:var(--text-dim);"></span> Total demandes <b>{{ $totalDemandesMois }}</b></div>
        </div>

      </div>
      @endif

      <!-- ===== CALENDRIER ===== -->
      <div class="panel">

        <div class="cal-toolbar">
          <div class="cal-nav">
            <a href="{{ route('calendrier.index', array_filter(['mois' => $moisPrecedent, 'departement' => $departementFiltre, 'type' => $typeFiltre])) }}" class="cal-nav-arrow"><i data-lucide="chevron-left" style="width:15px;height:15px;"></i></a>
            <span class="cal-label"><i data-lucide="calendar" style="width:15px;height:15px; color:var(--text-dim);"></i> {{ ucfirst($libelleMois) }}</span>
            <a href="{{ route('calendrier.index', array_filter(['mois' => $moisSuivant, 'departement' => $departementFiltre, 'type' => $typeFiltre])) }}" class="cal-nav-arrow"><i data-lucide="chevron-right" style="width:15px;height:15px;"></i></a>
          </div>

          <div class="cal-right-controls">
            @if (!$estRh)
              <form method="GET" action="{{ route('calendrier.index') }}">
                <input type="hidden" name="mois" value="{{ $moisParam }}">
                <select name="type" class="type-select" onchange="this.form.submit()">
                  <option value="">Type : Tous</option>
                  @foreach ($libellesType as $val => $label)
                    <option value="{{ $val }}" @selected($typeFiltre === $val)>{{ $label }}</option>
                  @endforeach
                </select>
              </form>
            @endif
            <form method="GET" action="{{ route('calendrier.index') }}" class="cal-mois-select">
              @if ($departementFiltre) <input type="hidden" name="departement" value="{{ $departementFiltre }}"> @endif
              @if ($typeFiltre) <input type="hidden" name="type" value="{{ $typeFiltre }}"> @endif
              <select name="moisNum" onchange="this.form.submit()">
                @foreach (['01'=>'Janvier','02'=>'Février','03'=>'Mars','04'=>'Avril','05'=>'Mai','06'=>'Juin','07'=>'Juillet','08'=>'Août','09'=>'Septembre','10'=>'Octobre','11'=>'Novembre','12'=>'Décembre'] as $num => $nom)
                  <option value="{{ $num }}" @selected($moisNumActuel === $num)>{{ $nom }}</option>
                @endforeach
              </select>
              <select name="anneeNum" onchange="this.form.submit()">
                @for ($a = 2020; $a <= 2030; $a++)
                  <option value="{{ $a }}" @selected($anneeActuelle == $a)>{{ $a }}</option>
                @endfor
              </select>
            </form>
            <a href="{{ route('calendrier.index', array_filter(['departement' => $departementFiltre, 'type' => $typeFiltre])) }}" class="btn-today"><i data-lucide="calendar-check" style="width:13px;height:13px;"></i> Aujourd'hui</a>
          </div>
        </div>

        @if ($estRh)
          <!-- ===== Grille RH : puces par jour (inchangée) ===== -->
          <div class="legend">
            <span class="row"><span class="puce" style="background:var(--green);"></span> Congé annuel</span>
            <span class="row"><span class="puce" style="background:var(--red);"></span> Congé maladie</span>
            <span class="row"><span class="puce" style="background:var(--orange);"></span> En attente</span>
            <span class="row"><span class="puce" style="background:var(--blue-2);"></span> Autre congé</span>
          </div>

          <div class="cal-grid">
            @foreach (['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'] as $nomJour)
              <div class="cal-dow">{{ $nomJour }}</div>
            @endforeach

            @foreach ($semaines as $semaineData)
              @foreach ($semaineData['jours'] as $jour)
                <div class="cal-cell {{ !$jour['dansMoisCourant'] ? 'hors-mois' : '' }} {{ $jour['estAujourdhui'] ? 'aujourdhui' : '' }}">
                  <span class="num">{{ $jour['date']->day }}</span>
                  @foreach ($jour['demandes']->take(2) as $item)
                    <div class="cal-item {{ $item['couleur'] }}" title="{{ $item['nom'] }} — {{ $item['libelle'] }}">
                      <span class="av">
                        @if ($item['photo'])
                          <img src="{{ asset('storage/'.$item['photo']) }}" alt="">
                        @else
                          {{ strtoupper(substr($item['nom'],0,1)) }}
                        @endif
                      </span>
                      <div class="txt">
                        <b>{{ $item['nom'] }}</b>
                        <span><i data-lucide="{{ $item['icone'] }}"></i> {{ $item['libelle'] }}{{ $item['premierJour'] && $item['jours'] > 1 ? ' ('.$item['jours'].' jours)' : '' }}</span>
                      </div>
                    </div>
                  @endforeach
                  @if ($jour['demandes']->count() > 2)
                    <span class="cal-item-more">+{{ $jour['demandes']->count() - 2 }} autre(s)</span>
                  @endif
                </div>
              @endforeach
            @endforeach
          </div>
        @else
          <!-- ===== Grille employé : barres façon maquette ===== -->
          <div class="week-dow-row">
            @foreach (['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'] as $nomJour)
              <div class="cal-dow">{{ $nomJour }}</div>
            @endforeach
          </div>

          @foreach ($semaines as $semaineData)
            <div class="week-row">
              @foreach ($semaineData['jours'] as $jour)
                <div class="week-daycell {{ !$jour['dansMoisCourant'] ? 'hors-mois' : '' }} {{ $jour['estAujourdhui'] ? 'aujourdhui' : '' }}">
                  <span class="num">{{ $jour['date']->day }}</span>
                </div>
              @endforeach
              <div class="week-bars">
                @foreach ($semaineData['barres'] as $barre)
                  <div class="week-bar" style="
                    left: calc({{ $barre['colDebut'] - 1 }} * (100% / 7) + 4px);
                    width: calc({{ $barre['largeur'] }} * (100% / 7) - 8px);
                    top: {{ $barre['rowIndex'] * 28 }}px;
                    background: {{ $barre['bg'] }};
                  ">{{ $barre['libelle'] }}{{ $barre['jours'] > 1 ? ' ('.$barre['jours'].'j)' : '' }}</div>
                @endforeach
              </div>
            </div>
          @endforeach

          <div class="legend" style="padding-top:18px;">
            <span class="row"><span class="puce" style="background:var(--orange);"></span> Congé</span>
            <span class="row"><span class="puce" style="background:var(--blue);"></span> Congé maladie</span>
            <span class="row"><span class="puce" style="background:var(--purple);"></span> En attente</span>
            <span class="row"><span class="puce" style="background:var(--blue-2);"></span> Autre</span>
          </div>
        @endif

      </div>

      @if (!$estRh)
      <!-- ===== COLONNE DROITE employé : stats + prochains congés ===== -->
      <div class="side-stack">

        <div class="panel stats-card">
          <h3>Mes congés et absences</h3>

          <div class="stat-line">
            <span class="ico" style="background:rgba(245,158,11,.15); color:var(--orange);"><i data-lucide="calendar-clock" style="width:18px;height:18px;"></i></span>
            <div><b>{{ $congesPlanifies }}</b><span>Congés planifiés</span></div>
          </div>
          <div class="stat-line">
            <span class="ico" style="background:rgba(59,130,246,.15); color:var(--blue-2);"><i data-lucide="calendar-check" style="width:18px;height:18px;"></i></span>
            <div><b>{{ $joursApprouvesAnnee }}</b><span>Jours de congé (cette année)</span></div>
          </div>
          <div class="stat-line">
            <span class="ico" style="background:rgba(139,92,246,.15); color:var(--purple);"><i data-lucide="heart-pulse" style="width:18px;height:18px;"></i></span>
            <div><b>{{ $joursAbsenceMaladie }}</b><span>Jours d'absence maladie</span></div>
          </div>
          <div class="stat-line">
            <span class="ico" style="background:rgba(239,68,68,.15); color:var(--red);"><i data-lucide="x-circle" style="width:18px;height:18px;"></i></span>
            <div><b>{{ $demandesRefuseesTotal }}</b><span>Demandes refusées</span></div>
          </div>
        </div>

        <div class="panel prochains-card">
          <div class="prochains-head">
            <h3>Prochains congés</h3>
          </div>

          @php
            $libellesProchains = ['paye' => 'Congé annuel', 'maladie' => 'Congé maladie', 'sans_solde' => 'Congé sans solde', 'exceptionnel' => 'Congé exceptionnel', 'rtt' => 'RTT', 'autre' => 'Autre congé'];
            $couleursProchains = ['paye' => 'var(--orange)', 'maladie' => 'var(--blue)', 'sans_solde' => 'var(--text-dim)', 'exceptionnel' => 'var(--purple)', 'rtt' => 'var(--blue-2)', 'autre' => 'var(--orange)'];
          @endphp

          @forelse ($prochainsConges as $conge)
            <div class="prochain-item" style="--c: {{ $couleursProchains[$conge->type] ?? 'var(--orange)' }};">
              <div>
                <b>{{ $libellesProchains[$conge->type] ?? $conge->type }}</b>
                <span>Du {{ $conge->date_debut->format('d M') }} au {{ $conge->date_fin->format('d M Y') }}</span>
              </div>
              <span class="prochain-badge">{{ $conge->jours }} jour{{ $conge->jours > 1 ? 's' : '' }}</span>
            </div>
          @empty
            <p class="prochains-empty">Aucun congé à venir.</p>
          @endforelse

          <a href="{{ route('conges.mesDemandes') }}" class="voir-tout-link">Voir tout</a>
        </div>

        <div class="panel note-card">
          <img src="{{ asset('images/greeting-illustration.png') }}" alt="">
          <p>Ici, vous pouvez consulter uniquement vos congés et absences.</p>
        </div>

      </div>
      @endif

    </div>

  </main>
</div>

<script>
  lucide.createIcons();
  document.querySelectorAll('a[href="#"]').forEach(l => l.addEventListener('click', e => e.preventDefault()));
</script>
</body>
</html>