<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Calendrier — NAJA7 HOST</title>
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

  .app{display:flex; align-items:flex-start; min-height:100vh; padding:16px 24px; gap:16px; max-width:1500px; margin:0 auto; overflow-x:hidden;}

  .sidebar{width:64px; flex:none; align-self:flex-start; position:sticky; top:16px; z-index:100; background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:32px; padding:14px 0 16px; display:flex; flex-direction:column; align-items:center; box-shadow:0 8px 32px rgba(0,0,0,.35); max-height:94vh;}
  .side-logo{width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; margin-bottom:12px; font-weight:700; overflow:hidden; flex:none;}
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

  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25);}

  .cal-toolbar{display:flex; align-items:center; justify-content:space-between; padding:16px 20px; flex-wrap:wrap; gap:12px; margin-bottom:16px;}
  .cal-nav{display:flex; align-items:center; gap:8px; flex:none;}
  .cal-nav-arrow{width:32px; height:32px; border-radius:10px; background:var(--panel-2); display:flex; align-items:center; justify-content:center;}
  .cal-nav-arrow:hover{background:rgba(255,255,255,.1);}
  .btn-today{position:relative; overflow:hidden; font-size:12.5px; font-weight:700; padding:8px 16px; border-radius:10px; color:#fff; white-space:nowrap; flex:none;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 14px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .btn-today:hover{filter:brightness(1.1);}
  .cal-label{font-size:16px; font-weight:800; margin:0 4px;}
  .cal-mois-select{display:flex; gap:8px;}
  .cal-mois-select select{background:var(--panel-2); border:1px solid var(--border); color:#fff; font-size:12.5px; font-weight:600; padding:8px 10px; border-radius:10px;}
  .cal-mois-select select option{background:#141b30; color:#fff;}

  .dept-badge{display:flex; align-items:center; gap:8px; padding:0 20px 16px; font-size:13px; color:var(--text-dim);}
  .dept-badge .puce{width:9px; height:9px; border-radius:50%; background:var(--blue-2); flex:none;}
  .dept-badge b{color:#fff;}

  .legend{display:flex; flex-wrap:wrap; gap:12px; padding:0 20px 18px; font-size:11.5px; color:var(--text-dim);}
  .legend .row{display:flex; align-items:center; gap:6px;}
  .legend .puce{width:9px; height:9px; border-radius:4px; flex:none;}

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
  .cal-item.moi{outline:1.5px solid rgba(255,255,255,.35);}
  .cal-item-more{font-size:10px; color:var(--text-dim); padding-left:2px;}

  .empty-dept{padding:40px 20px; text-align:center; color:var(--text-dim); font-size:13.5px;}

  @media (max-width:800px){ .sidebar{display:none;} }
  @media (max-width:700px){ .cal-grid{grid-template-columns:repeat(7, minmax(76px,1fr)); overflow-x:auto;} }
</style>
</head>
<body>

<div class="app">

  <aside class="sidebar">
    <div class="side-logo"><img src="{{ asset('images/logo-naja7host.png') }}" alt="NAJA7HOST"></div>
    <nav class="side-nav">
      <a href="{{ route('dashboard') }}" class="side-link"><i data-lucide="layout-dashboard" style="width:17px;height:17px;"></i><span class="tip">Tableau de bord</span></a>
      <a href="#" class="side-link"><i data-lucide="file-text" style="width:17px;height:17px;"></i><span class="tip">Mes demandes</span></a>
      <a href="{{ route('conges.create') }}" class="side-link"><i data-lucide="plus-circle" style="width:17px;height:17px;"></i><span class="tip">Nouvelle demande</span></a>
      <a href="{{ route('calendrier.equipe') }}" class="side-link active"><i data-lucide="calendar-days" style="width:17px;height:17px;"></i><span class="tip">Calendrier</span></a>
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

  <main class="main">

    <div class="header">
      <div class="header-left">
        <h1>Calendrier</h1>
        <p>Visualisez les congés et absences de votre équipe en un coup d'œil</p>
      </div>
      <button class="icon-btn"><i data-lucide="bell" style="width:16px;height:16px;"></i></button>
    </div>

    <div class="panel">

      <div class="cal-toolbar">
        <div class="cal-nav">
          <a href="{{ route('calendrier.equipe', ['mois' => $moisPrecedent]) }}" class="cal-nav-arrow"><i data-lucide="chevron-left" style="width:15px;height:15px;"></i></a>
          <a href="{{ route('calendrier.equipe') }}" class="btn-today">Aujourd'hui</a>
          <a href="{{ route('calendrier.equipe', ['mois' => $moisSuivant]) }}" class="cal-nav-arrow"><i data-lucide="chevron-right" style="width:15px;height:15px;"></i></a>
        </div>
        <div class="cal-label">{{ ucfirst($libelleMois) }}</div>
        <form method="GET" action="{{ route('calendrier.equipe') }}" class="cal-mois-select">
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
      </div>

      @if ($monDepartement)
        <div class="dept-badge"><span class="puce"></span> Équipe <b>{{ $monDepartement }}</b> · {{ $nbCollegues }} membre{{ $nbCollegues > 1 ? 's' : '' }}</div>

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

          @foreach ($semaines as $semaine)
            @foreach ($semaine as $jour)
              <div class="cal-cell {{ !$jour['dansMoisCourant'] ? 'hors-mois' : '' }} {{ $jour['estAujourdhui'] ? 'aujourdhui' : '' }}">
                <span class="num">{{ $jour['date']->day }}</span>
                @foreach ($jour['demandes']->take(2) as $item)
                  <div class="cal-item {{ $item['couleur'] }} {{ $item['estMoi'] ? 'moi' : '' }}" title="{{ $item['nom'] }} — {{ $item['libelle'] }}">
                    <span class="av">
                      @if ($item['photo'])
                        <img src="{{ asset('storage/'.$item['photo']) }}" alt="">
                      @else
                        {{ strtoupper(substr($item['nom'],0,1)) }}
                      @endif
                    </span>
                    <div class="txt">
                      <b>{{ $item['estMoi'] ? 'Moi' : $item['nom'] }}</b>
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
        <div class="empty-dept">Aucun département renseigné sur ton profil — contacte les RH pour voir le calendrier de ton équipe.</div>
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