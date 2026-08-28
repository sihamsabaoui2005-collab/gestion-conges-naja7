<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Congés & Absences — NAJA7 HOST</title>
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
  select, input{font-family:inherit;}

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
  .header-right{display:flex; align-items:center; gap:12px; flex-wrap:wrap; position:relative;}

  .date-box{display:flex; align-items:center; gap:8px; height:40px; background:var(--panel); border:1px solid var(--border); border-radius:10px; padding:0 12px; font-size:13px; color:var(--text-dim);}
  .date-box input{background:transparent; border:none; color:#fff; font-size:13px; outline:none; width:110px;}

  .icon-btn{position:relative; width:38px; height:38px; border-radius:12px; background:var(--panel); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; flex:none;}
  .icon-btn .dot{position:absolute; top:-3px; right:-3px; background:var(--red); color:#fff; font-size:9px; font-weight:700; width:16px; height:16px; border-radius:50%; display:flex; align-items:center; justify-content:center;}
  .avatar{width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; overflow:hidden; flex:none;}
  .avatar img{width:100%; height:100%; object-fit:cover; object-position:center top;}

  .notif-panel{position:absolute; top:52px; right:0; background:rgba(18,24,42,.85); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:10px; width:290px; box-shadow:0 12px 30px rgba(0,0,0,.4); display:none; z-index:80;}
  .notif-panel.open{display:block;}
  .notif-panel h4{font-size:12.5px; padding:6px 8px 10px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.03em;}
  .notif-item{display:flex; align-items:flex-start; gap:10px; padding:9px 8px; border-radius:11px; font-size:12.5px;}
  .notif-item:hover{background:rgba(255,255,255,.05);}
  .notif-item .n-ico{width:28px; height:28px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex:none; background:rgba(59,130,246,.15); color:var(--blue-2);}
  .notif-empty{padding:14px 8px; font-size:12.5px; color:var(--text-dim); text-align:center;}

  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25);}

  .dept-tabs{display:flex; gap:8px; padding:18px; flex-wrap:wrap; align-items:center;}
  .dept-tab{font-size:13px; font-weight:600; padding:9px 16px; border-radius:999px; background:var(--panel-2); color:var(--text-dim); border:1px solid transparent;}
  .dept-tab:hover{background:rgba(255,255,255,.1); color:#fff;}
  .dept-tab.active{background:linear-gradient(160deg,#7C5CFF,#5B34E0); color:#fff;}
  .dept-tabs .reset{margin-left:auto; position:relative; overflow:hidden; font-size:13px; font-weight:700; color:#fff; display:flex; align-items:center; gap:6px; padding:9px 16px; border-radius:999px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}

  .dept-grid{display:grid; grid-template-columns:repeat(3, 1fr); gap:16px; padding:0 18px 18px;}
  @media (max-width:1150px){ .dept-grid{grid-template-columns:repeat(2, 1fr);} }
  @media (max-width:700px){ .dept-grid{grid-template-columns:1fr;} }

  .dept-card{background:var(--panel-2); border:1px solid var(--border); border-radius:18px; padding:16px; display:flex; flex-direction:column; gap:12px;}
  .dept-head{display:flex; align-items:center; gap:10px;}
  .dept-icon{width:38px; height:38px; border-radius:12px; background:var(--c,var(--purple)); display:flex; align-items:center; justify-content:center; flex:none; color:#fff;}
  .dept-icon i{width:18px; height:18px;}
  .dept-head b{display:block; font-size:15px;}
  .dept-head span{font-size:12px; color:var(--text-dim);}

  .dept-sub-head{display:flex; align-items:center; gap:6px; font-size:12.5px; font-weight:600; color:var(--text-dim); margin-bottom:6px;}
  .dept-sub-head b{margin-left:auto; color:#fff; font-size:12.5px;}
  .dept-sub-item{display:flex; align-items:center; gap:7px; font-size:12.5px; padding:3px 0; color:#fff;}
  .dept-sub-item .puce{width:6px; height:6px; border-radius:50%; flex:none;}
  .dept-sub-item span{margin-left:auto; color:var(--text-dim); font-size:11px; white-space:nowrap;}
  .dept-sub-empty, .dept-sub-more{font-size:11.5px; color:var(--text-dim); padding:2px 0;}

  .dept-detail{margin-top:auto; position:relative; overflow:hidden; font-size:12.5px; font-weight:700; color:#fff; display:flex; align-items:center; justify-content:center; gap:5px; padding:9px 14px; border-radius:11px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 14px rgba(194,65,12,.35), inset 0 1px 0 rgba(255,255,255,.25);}
  .dept-detail:hover{filter:brightness(1.1); transform:translateY(-1px);}

  .apercu-card{grid-column:span 1;}
  .apercu-card h3{font-size:14px; font-weight:800; margin-bottom:10px; display:flex; align-items:center; gap:6px;}
  .apercu-donut-wrap{position:relative; width:150px; height:150px; margin:6px auto 14px;}
  .apercu-donut-center{position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); text-align:center;}
  .apercu-donut-center b{display:block; font-size:26px; font-weight:800; color:#fff;}
  .apercu-donut-center span{font-size:10px; color:var(--text-dim);}
  .apercu-legend-item{display:flex; align-items:center; gap:8px; font-size:12px; padding:5px 0;}
  .apercu-legend-item .puce{width:9px; height:9px; border-radius:50%; flex:none;}
  .apercu-legend-item b{margin-left:auto; color:#fff;}
  .apercu-legend-item span.pct{color:var(--text-dim); font-size:11px;}

  .info-card{display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center; gap:8px; padding:20px;}
  .info-card i{color:var(--blue-2);}
  .info-card p{font-size:12.5px; color:var(--text-dim); line-height:1.5;}

  .absences-today{display:flex; flex-direction:column; gap:0; padding:0 18px 18px;}
  .absences-today .head-row{display:flex; align-items:center; justify-content:space-between; padding:0 0 10px;}
  .absences-today .head-row h3{font-size:14px; font-weight:800;}
  .absences-today .head-row a{font-size:12px; color:var(--blue-2); font-weight:600;}
  .today-row{display:flex; align-items:center; gap:10px; padding:9px 0; border-bottom:1px solid var(--border);}
  .today-row:last-child{border-bottom:none;}
  .today-avatar{width:32px; height:32px; border-radius:50%; background:var(--blue); display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:700; flex:none; overflow:hidden;}
  .today-avatar img{width:100%; height:100%; object-fit:cover; object-position:center top;}
  .today-info b{display:block; font-size:13px;}
  .today-info span{font-size:11px; color:var(--text-dim);}
  .today-right{margin-left:auto; text-align:right;}
  .today-right b{display:block; font-size:12px; color:#fff;}
  .today-right span{font-size:10.5px; color:var(--text-dim);}
  .today-empty{font-size:13px; color:var(--text-dim); text-align:center; padding:14px 0;}
</style>
</head>
<body>

<div class="app">

  @include('partials.sidebar')

  <main class="main">

    <div class="header">
      <div class="header-left">
        <h1>Congés &amp; Absences</h1>
        <p>Consultez les congés et absences par département</p>
      </div>
      <div class="header-right">
        <form method="GET" action="{{ route('conges.apercu') }}" class="date-box">
          @if ($departementFiltre) <input type="hidden" name="departement" value="{{ $departementFiltre }}"> @endif
          <i data-lucide="calendar" style="width:14px;height:14px;"></i>
          <input type="date" name="debut" value="{{ $debut->format('Y-m-d') }}" onchange="this.form.submit()">
          <span>—</span>
          <input type="date" name="fin" value="{{ $fin->format('Y-m-d') }}" onchange="this.form.submit()">
        </form>

        <button class="icon-btn" id="notifBtn"><i data-lucide="bell" style="width:16px;height:16px;"></i>
          @if (auth()->user()->unreadNotifications->count() > 0)<span class="dot">{{ auth()->user()->unreadNotifications->count() }}</span>@endif
        </button>

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

        <div class="avatar">
          @if (auth()->user()->photo_path)
            <img src="{{ asset('storage/'.auth()->user()->photo_path) }}" alt="">
          @else
            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
          @endif
        </div>
      </div>
    </div>

    <div class="panel" style="margin-bottom:16px;">
      <div class="dept-tabs">
        <a href="{{ route('conges.apercu', array_filter(['debut'=>$debut->format('Y-m-d'),'fin'=>$fin->format('Y-m-d')])) }}"
           class="dept-tab {{ !$departementFiltre ? 'active' : '' }}">Tous les départements</a>
        @foreach ($listeDepartements as $dep)
          <a href="{{ route('conges.apercu', array_filter(['departement'=>$dep,'debut'=>$debut->format('Y-m-d'),'fin'=>$fin->format('Y-m-d')])) }}"
             class="dept-tab {{ $departementFiltre === $dep ? 'active' : '' }}">{{ $dep }}</a>
        @endforeach
        <a href="{{ route('conges.apercu') }}" class="reset"><i data-lucide="rotate-ccw" style="width:13px;height:13px;"></i> Réinitialiser</a>
      </div>
    </div>

    @php
      $iconesDept = ['users','code-2','megaphone','wallet','handshake','factory','headphones'];
      $couleursDept = ['var(--purple)','var(--blue)','var(--pink)','var(--green)','var(--orange)','#F97316','var(--cyan)'];

      $libellesTypes = [
        'paye' => 'Congés payés', 'rtt' => 'RTT', 'exceptionnel' => 'Congé exceptionnel',
        'autre' => 'Autre congé', 'maladie' => 'Maladie', 'sans_solde' => 'Congé sans solde',
      ];
      $couleursTypes = [
        'paye' => 'var(--green)', 'rtt' => 'var(--orange)', 'exceptionnel' => 'var(--purple)',
        'autre' => 'var(--blue-2)', 'maladie' => 'var(--red)', 'sans_solde' => '#9CA3AF',
      ];

      $rayonDonut = 60; $circonfDonut = 2 * pi() * $rayonDonut; $offsetCumule = 0;
    @endphp

    <div class="dept-grid">
      @foreach ($departementsData as $i => $dept)

        <div class="dept-card">
          <div class="dept-head">
            <span class="dept-icon" style="--c:{{ $couleursDept[$i % count($couleursDept)] }}">
              <i data-lucide="{{ $iconesDept[$i % count($iconesDept)] }}"></i>
            </span>
            <div>
              <b>{{ $dept['nom'] }}</b>
              <span>{{ $dept['nb_employes'] }} employé{{ $dept['nb_employes'] > 1 ? 's' : '' }}</span>
            </div>
          </div>

          <div>
            <div class="dept-sub-head"><i data-lucide="palmtree" style="width:13px;height:13px;color:var(--green);"></i> Congés <b>{{ $dept['conges_jours'] }} jour{{ $dept['conges_jours'] > 1 ? 's' : '' }}</b></div>
            @forelse ($dept['conges_liste']->take(2) as $c)
              <div class="dept-sub-item">
                <span class="puce" style="background:{{ $couleursTypes[$c->type] ?? '#888' }}"></span>
                {{ $c->user->name ?? 'Employé supprimé' }}
                <span>{{ $c->date_debut->format('d M') }} - {{ $c->date_fin->format('d M') }}</span>
              </div>
            @empty
              <div class="dept-sub-empty">Aucun congé</div>
            @endforelse
            @if ($dept['conges_liste']->count() > 2)
              <div class="dept-sub-more">+{{ $dept['conges_liste']->count() - 2 }} autre{{ $dept['conges_liste']->count() - 2 > 1 ? 's' : '' }}</div>
            @endif
          </div>

          <div>
            <div class="dept-sub-head"><i data-lucide="user-round" style="width:13px;height:13px;color:var(--purple);"></i> Absences <b>{{ $dept['absences_jours'] }} jour{{ $dept['absences_jours'] > 1 ? 's' : '' }}</b></div>
            @forelse ($dept['absences_liste']->take(2) as $a)
              <div class="dept-sub-item">
                <span class="puce" style="background:{{ $couleursTypes[$a->type] ?? '#888' }}"></span>
                {{ $a->user->name ?? 'Employé supprimé' }}
                <span>{{ $a->date_debut->format('d M') }}</span>
              </div>
            @empty
              <div class="dept-sub-empty">Aucune absence</div>
            @endforelse
            @if ($dept['absences_liste']->count() > 2)
              <div class="dept-sub-more">+{{ $dept['absences_liste']->count() - 2 }} autre{{ $dept['absences_liste']->count() - 2 > 1 ? 's' : '' }}</div>
            @endif
          </div>

          <a href="{{ route('conges.departement', ['departement' => $dept['nom']]) }}" class="dept-detail">Voir le détail <i data-lucide="arrow-right" style="width:12px;height:12px;"></i></a>
        </div>

        @if ($i === 1 && !$departementFiltre)
          <div class="dept-card apercu-card">
            <h3><i data-lucide="pie-chart" style="width:15px;height:15px;color:var(--orange);"></i> Aperçu de l'année</h3>
            <div class="apercu-donut-wrap">
              <svg viewBox="0 0 150 150" width="150" height="150">
                <circle cx="75" cy="75" r="{{ $rayonDonut }}" fill="none" stroke="rgba(255,255,255,.08)" stroke-width="16" />
                <g transform="rotate(-90 75 75)">
                  @foreach ($repartitionParType as $type => $jours)
                    @php
                      $longueur = $totalJoursMois > 0 ? ($jours / $totalJoursMois) * $circonfDonut : 0;
                    @endphp
                    <circle cx="75" cy="75" r="{{ $rayonDonut }}" fill="none" stroke="{{ $couleursTypes[$type] ?? '#888' }}" stroke-width="16"
                      stroke-dasharray="{{ $longueur }} {{ $circonfDonut - $longueur }}" stroke-dashoffset="{{ -$offsetCumule }}" />
                    @php $offsetCumule += $longueur; @endphp
                  @endforeach
                </g>
              </svg>
              <div class="apercu-donut-center"><b>{{ $totalJoursMois }}</b><span>jours</span></div>
            </div>
            @forelse ($repartitionParType as $type => $jours)
              <div class="apercu-legend-item">
                <span class="puce" style="background:{{ $couleursTypes[$type] ?? '#888' }}"></span>
                {{ $libellesTypes[$type] ?? $type }}
                <b>{{ $jours }}j</b>
                <span class="pct">({{ $totalJoursMois > 0 ? round(($jours / $totalJoursMois) * 100) : 0 }}%)</span>
              </div>
            @empty
              <div class="today-empty">Aucun congé sur la période</div>
            @endforelse
          </div>
        @endif

        @if ($loop->last && !$departementFiltre)
          <div class="dept-card info-card">
            <i data-lucide="info" style="width:22px;height:22px;"></i>
            <p>Les données affichées concernent uniquement les congés et absences validés pour la période sélectionnée.</p>
          </div>
        @endif

      @endforeach
    </div>

    <div class="panel">
      <div class="absences-today">
        <div class="head-row">
          <h3>Absences aujourd'hui</h3>
          <a href="{{ route('conges.index', ['statut' => 'approuve']) }}">Voir tout →</a>
        </div>

        @forelse ($absencesAujourdhui as $abs)
          <div class="today-row">
            <span class="today-avatar">
              @if ($abs->user && $abs->user->photo_path)
                <img src="{{ asset('storage/'.$abs->user->photo_path) }}" alt="">
              @else
                {{ strtoupper(substr($abs->user->name ?? '?', 0, 1)) }}
              @endif
            </span>
            <div class="today-info">
              <b>{{ $abs->user->name ?? 'Employé supprimé' }}</b>
              <span>{{ $abs->user->departement ?? '' }}</span>
            </div>
            <div class="today-right">
              <b>{{ \Illuminate\Support\Str::limit($abs->motif ?: ($libellesTypes[$abs->type] ?? $abs->type), 28) }}</b>
              <span>{{ $abs->date_debut->format('d M') }} - {{ $abs->date_fin->format('d M') }}</span>
            </div>
          </div>
        @empty
          <div class="today-empty">Aucune absence aujourd'hui.</div>
        @endforelse
      </div>
    </div>

  </main>
</div>

<script>
  lucide.createIcons();
  document.querySelectorAll('a[href="#"]').forEach(l => l.addEventListener('click', e => e.preventDefault()));

  const notifBtn = document.getElementById('notifBtn');
  const notifPanel = document.getElementById('notifPanel');
  if (notifBtn && notifPanel) {
    notifBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      notifPanel.classList.toggle('open');
    });
    document.addEventListener('click', () => notifPanel.classList.remove('open'));
    notifPanel.addEventListener('click', (e) => e.stopPropagation());
  }
</script>
</body>
</html>