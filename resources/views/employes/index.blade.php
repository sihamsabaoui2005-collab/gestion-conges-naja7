<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestion des employés — NAJA7 HOST</title>
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
  input{font-family:inherit;}

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
  .header-right{display:flex; align-items:center; gap:12px; flex-wrap:wrap;}

  .btn-ajouter{position:relative; overflow:hidden; font-size:13px; font-weight:700; color:#fff; display:inline-flex; align-items:center; gap:7px; padding:11px 20px; border-radius:12px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .btn-ajouter:hover{transform:translateY(-1px);}

  .icon-btn{position:relative; width:38px; height:38px; border-radius:12px; background:var(--panel); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; flex:none;}
  .icon-btn .dot{position:absolute; top:-3px; right:-3px; background:var(--red); color:#fff; font-size:9px; font-weight:700; width:16px; height:16px; border-radius:50%; display:flex; align-items:center; justify-content:center;}

  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25);}
  .panel-pad{padding:20px;}

  .layout{display:grid; grid-template-columns:220px 1fr 300px; gap:16px; align-items:start;}
  @media (max-width:1150px){ .layout{grid-template-columns:1fr; } }

  /* ===== Colonne gauche : départements ===== */
  .dept-list-item{display:flex; align-items:center; gap:9px; padding:9px 10px; border-radius:11px; font-size:13px; color:var(--text-dim); margin-bottom:2px;}
  .dept-list-item:hover{background:rgba(255,255,255,.06); color:#fff;}
  .dept-list-item.active{background:rgba(245,158,11,.15); color:var(--orange); font-weight:700;}
  .dept-list-item .puce{width:8px; height:8px; border-radius:50%; flex:none;}
  .dept-list-item .count{margin-left:auto; font-size:11.5px; color:var(--text-dim);}
  .dept-list-item.active .count{color:var(--orange);}
  .dept-title{font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.04em; margin-bottom:10px; display:flex; justify-content:space-between;}

  /* ===== Colonne centrale ===== */
  .search-box{width:100%; height:42px; display:flex; align-items:center; gap:8px; background:var(--panel-2); border:1px solid var(--border); border-radius:11px; padding:0 14px; margin-bottom:18px;}
  .search-box input{flex:1; border:none; outline:none; background:transparent; color:#fff; font-size:14px;}
  .search-box input::placeholder{color:var(--text-dim);}

  .dept-section{margin-bottom:22px;}
  .dept-section-head{display:flex; align-items:center; gap:8px; margin-bottom:12px; flex-wrap:wrap;}
  .dept-section-head .puce{width:9px; height:9px; border-radius:50%; flex:none;}
  .dept-section-head b{font-size:14.5px; font-weight:700;}
  .dept-section-head span{font-size:12px; color:var(--text-dim);}
  .dept-section-stats{margin-left:auto; display:flex; gap:14px; font-size:11.5px; font-weight:600;}
  .dept-section-stats span{color:var(--text-dim); font-weight:400;}

  .employe-grid{display:grid; grid-template-columns:repeat(auto-fill, minmax(110px, 1fr)); gap:12px;}
  .employe-card{background:var(--panel-2); border-radius:16px; padding:14px 10px; text-align:center;}
  .employe-card .av{position:relative; width:52px; height:52px; margin:0 auto 8px;}
  .employe-card .av-img{width:52px; height:52px; border-radius:50%; background:var(--blue); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:17px; overflow:hidden;}
  .employe-card .av-img img{width:100%; height:100%; object-fit:cover; object-position:center top;}
  .employe-card .av .statut-dot{position:absolute; bottom:1px; right:1px; width:13px; height:13px; border-radius:50%; border:2.5px solid #141a2e;}
  .employe-card b{display:block; font-size:12.5px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
  .employe-card .poste{display:block; font-size:10.5px; color:var(--text-dim); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
  .employe-card .statut-label{display:block; font-size:10.5px; font-weight:600; margin-top:3px;}
  .employe-card .jusquau{display:block; font-size:9.5px; color:var(--text-dim); margin-top:1px;}

  .empty-state{text-align:center; padding:40px 0; color:var(--text-dim); font-size:13.5px;}

  /* ===== Colonne droite ===== */
  .side-panel h3{font-size:13.5px; font-weight:800; display:flex; align-items:center; gap:7px; margin-bottom:14px;}
  .anniv-item{display:flex; align-items:center; gap:10px; padding:8px 0;}
  .anniv-avatar{width:32px; height:32px; border-radius:50%; background:var(--pink); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; flex:none; overflow:hidden;}
  .anniv-avatar img{width:100%; height:100%; object-fit:cover; object-position:center top;}
  .anniv-item b{display:block; font-size:12.5px;}
  .anniv-item span{margin-left:auto; font-size:11px; color:var(--text-dim); white-space:nowrap;}
  .anniv-empty{font-size:12.5px; color:var(--text-dim); text-align:center; padding:10px 0;}

  .stats-donut-wrap{display:flex; align-items:center; gap:16px;}
  .stats-legend{display:flex; flex-direction:column; gap:7px; font-size:12px;}
  .stats-legend .row{display:flex; align-items:center; gap:7px;}
  .stats-legend .puce{width:8px; height:8px; border-radius:50%; flex:none;}
  .stats-legend b{margin-left:auto;}

  .rh-intelligent{background:linear-gradient(135deg, rgba(59,130,246,.18), rgba(139,92,246,.14)); border:1px solid rgba(139,92,246,.3); border-radius:16px; padding:16px;}
  .rh-intelligent .ico{width:34px; height:34px; border-radius:11px; background:rgba(139,92,246,.25); color:var(--purple); display:flex; align-items:center; justify-content:center; margin-bottom:10px;}
  .rh-intelligent b{display:block; font-size:13px; margin-bottom:4px;}
  .rh-intelligent p{font-size:11.5px; color:var(--text-dim); line-height:1.4; margin-bottom:10px;}
  .rh-intelligent a{font-size:12px; font-weight:700; color:var(--blue-2); display:inline-flex; align-items:center; gap:4px;}

  @media (max-width:800px){ .sidebar{display:none;} }
</style>
</head>
<body>

<div class="app">

  <aside class="sidebar">
    <div class="side-logo"><img src="{{ asset('images/logo-naja7host.png') }}" alt="NAJA7HOST"></div>
    <nav class="side-nav">
      <a href="{{ route('dashboard') }}" class="side-link"><i data-lucide="home" style="width:17px;height:17px;"></i><span class="tip">Tableau de bord</span></a>
      <a href="{{ route('conges.apercu') }}" class="side-link"><i data-lucide="calendar-heart" style="width:17px;height:17px;"></i><span class="tip">Congés &amp; Absences</span></a>
      <a href="{{ route('conges.index') }}" class="side-link"><i data-lucide="file-text" style="width:17px;height:17px;"></i><span class="tip">Demandes</span></a>
      <a href="{{ route('employes.index') }}" class="side-link active"><i data-lucide="users" style="width:17px;height:17px;"></i><span class="tip">Employés</span></a>
      <a href="{{ route('calendrier.index') }}" class="side-link"><i data-lucide="calendar-days" style="width:17px;height:17px;"></i><span class="tip">Calendrier équipe</span></a>
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

  <main class="main">

    <div class="header">
      <div class="header-left">
        <h1>Gestion des employés</h1>
        <p>Gérez vos équipes et suivez leur présence en temps réel</p>
      </div>
      <div class="header-right">
        <a href="{{ route('employes.create') }}" class="btn-ajouter"><i data-lucide="plus" style="width:15px;height:15px;"></i> Ajouter un employé</a>
        <button class="icon-btn"><i data-lucide="bell" style="width:16px;height:16px;"></i>
          @if ($absentsAujourdhui > 0)<span class="dot">{{ $absentsAujourdhui }}</span>@endif
        </button>
      </div>
    </div>

    <div class="layout">

      @if (session('success'))
        <div style="grid-column:1/-1; padding:11px 16px; border-radius:12px; background:rgba(16,185,129,.15); color:var(--green); font-size:12.5px;">{{ session('success') }}</div>
      @endif

      <!-- ===== COLONNE GAUCHE : départements ===== -->
      <div class="panel panel-pad">
        <div class="dept-title"><span>Départements</span><span>{{ $totalEmployes }}</span></div>

        @php
          $couleursDept = ['var(--blue)','var(--purple)','var(--green)','var(--orange)','#F97316','var(--cyan)','var(--pink)'];
        @endphp

        <a href="{{ route('employes.index') }}" class="dept-list-item {{ !$departementFiltre ? 'active' : '' }}">
          <span class="puce" style="background:var(--text-dim);"></span> Tous les départements
          <span class="count">{{ $totalEmployes }}</span>
        </a>

        @foreach ($departements as $dep => $total)
          <a href="{{ route('employes.index', ['departement' => $dep]) }}"
             class="dept-list-item {{ $departementFiltre === $dep ? 'active' : '' }}">
            <span class="puce" style="background:{{ $couleursDept[$loop->index % count($couleursDept)] }};"></span>
            {{ $dep }}
            <span class="count">{{ $total }}</span>
          </a>
        @endforeach
      </div>

      <!-- ===== COLONNE CENTRALE : liste des employés ===== -->
      <div class="panel panel-pad">
        <form method="GET" action="{{ route('employes.index') }}" class="search-box">
          @if ($departementFiltre) <input type="hidden" name="departement" value="{{ $departementFiltre }}"> @endif
          <i data-lucide="search" style="width:15px;height:15px; color:var(--text-dim);"></i>
          <input type="text" name="q" value="{{ $recherche }}" placeholder="Rechercher un employé...">
        </form>

        @php
          $couleursDept = ['var(--blue)','var(--purple)','var(--green)','var(--orange)','#F97316','var(--cyan)','var(--pink)'];
        @endphp

        @forelse ($employesParDepartement as $dep => $employes)
          <div class="dept-section">
            <div class="dept-section-head">
              <span class="puce" style="background:{{ $couleursDept[$loop->index % count($couleursDept)] }};"></span>
              <b>{{ $dep }}</b>
              <span>{{ $employes->count() }} employé{{ $employes->count() > 1 ? 's' : '' }}</span>
              <div class="dept-section-stats">
                <span style="color:var(--green); font-weight:600;">Présents : {{ $statsParDepartement[$dep]['presents'] }}</span>
                <span style="color:var(--amber); font-weight:600;">En congé : {{ $statsParDepartement[$dep]['conge'] }}</span>
                <span style="color:var(--red); font-weight:600;">Absents : {{ $statsParDepartement[$dep]['absents'] }}</span>
              </div>
            </div>
            <div class="employe-grid">
              @foreach ($employes as $e)
                @php
                  $couleurStatut = ['present' => 'var(--green)', 'conge' => 'var(--amber)', 'absent' => 'var(--red)'][$e->statut];
                  $labelStatut = ['present' => 'Présent', 'conge' => 'En congé', 'absent' => 'Absent'][$e->statut];
                @endphp
                <div class="employe-card">
                  <div class="av">
                    <div class="av-img">
                      @if ($e->user->photo_path)
                        <img src="{{ asset('storage/'.$e->user->photo_path) }}" alt="">
                      @else
                        {{ strtoupper(substr($e->user->name,0,1)) }}
                      @endif
                    </div>
                    <span class="statut-dot" style="background:{{ $couleurStatut }};"></span>
                  </div>
                  <b>{{ $e->user->name }}</b>
                  <span class="poste">{{ $e->user->poste ?? 'Employé' }}</span>
                  <span class="statut-label" style="color:{{ $couleurStatut }};">{{ $labelStatut }}</span>
                  @if ($e->jusquau)
                    <span class="jusquau">jusqu'au {{ $e->jusquau->format('d/m') }}</span>
                  @endif
                </div>
              @endforeach
            </div>
          </div>
        @empty
          <div class="empty-state">Aucun employé trouvé.</div>
        @endforelse
      </div>

      <!-- ===== COLONNE DROITE ===== -->
      <div style="display:flex; flex-direction:column; gap:16px;">

        <div class="panel panel-pad">
          <h3><i data-lucide="gift" style="width:15px;height:15px; color:var(--pink);"></i> Anniversaires du mois</h3>
          @forelse ($anniversaires->take(4) as $employe)
            <div class="anniv-item">
              <span class="anniv-avatar">
                @if ($employe->photo_path)
                  <img src="{{ asset('storage/'.$employe->photo_path) }}" alt="">
                @else
                  {{ strtoupper(substr($employe->name,0,1)) }}
                @endif
              </span>
              <b>{{ $employe->name }}</b>
              <span>{{ $employe->date_naissance->format('d M') }}</span>
            </div>
          @empty
            <div class="anniv-empty">Aucun anniversaire ce mois-ci.</div>
          @endforelse
        </div>

        <div class="panel panel-pad">
          <h3><i data-lucide="pie-chart" style="width:15px;height:15px; color:var(--blue-2);"></i> Statistiques aujourd'hui</h3>
          @php
            $totalPourDonut = max($totalEmployes, 1);
            $circonf = 2 * pi() * 34;
            $pctPresents = $presentsAujourdhui / $totalPourDonut;
            $pctConge = $congeAujourdhui / $totalPourDonut;
            $pctAbsent = $absentsAujourdhui / $totalPourDonut;
          @endphp
          <div class="stats-donut-wrap">
            <div style="position:relative; width:84px; height:84px; flex:none;">
              <svg viewBox="0 0 84 84" width="84" height="84" style="transform:rotate(-90deg);">
                <circle cx="42" cy="42" r="34" fill="none" stroke="var(--panel-2)" stroke-width="9" />
                <circle cx="42" cy="42" r="34" fill="none" stroke="var(--green)" stroke-width="9"
                  stroke-dasharray="{{ $circonf * $pctPresents }} {{ $circonf }}" />
                <circle cx="42" cy="42" r="34" fill="none" stroke="var(--amber)" stroke-width="9"
                  stroke-dasharray="{{ $circonf * $pctConge }} {{ $circonf }}"
                  stroke-dashoffset="{{ -$circonf * $pctPresents }}" />
                <circle cx="42" cy="42" r="34" fill="none" stroke="var(--red)" stroke-width="9"
                  stroke-dasharray="{{ $circonf * $pctAbsent }} {{ $circonf }}"
                  stroke-dashoffset="{{ -$circonf * ($pctPresents + $pctConge) }}" />
              </svg>
              <div style="position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center;">
                <b style="font-size:16px; font-weight:800; line-height:1;">{{ $totalEmployes }}</b>
                <span style="font-size:8px; color:var(--text-dim);">total</span>
              </div>
            </div>
            <div class="stats-legend">
              <div class="row"><span class="puce" style="background:var(--green);"></span> Présents <b>{{ $presentsAujourdhui }}</b></div>
              <div class="row"><span class="puce" style="background:var(--amber);"></span> En congé <b>{{ $congeAujourdhui }}</b></div>
              <div class="row"><span class="puce" style="background:var(--red);"></span> Absents <b>{{ $absentsAujourdhui }}</b></div>
            </div>
          </div>
        </div>

      </div>
    </div>

  </main>
</div>

<script>
  lucide.createIcons();
  document.querySelectorAll('a[href="#"]').forEach(l => l.addEventListener('click', e => e.preventDefault()));
</script>
</body>
</html>