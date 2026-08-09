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
    --blue:#0EA5E9; --blue-dark:#0284C7;
    --orange:#F59E0B; --green:#22C55E; --red:#EF4444; --purple:#A78BFA;
    --bg:#0A1730; --panel:#101F3D; --panel-2:#14284A;
    --border:rgba(255,255,255,.08);
    --text:#E2E8F0; --text-dim:#94A3B8;
    --radius:18px;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  body{font-family:'Poppins',sans-serif; background:var(--bg); color:var(--text); -webkit-font-smoothing:antialiased;}
  a{text-decoration:none; color:inherit;}
  button{font-family:inherit; cursor:pointer; border:none; background:none; color:inherit;}

  .app{display:flex; min-height:100vh;}

  .sidebar{width:250px; flex:none; background:var(--panel); border-right:1px solid var(--border); padding:24px 18px; display:flex; flex-direction:column;}
  .side-logo{display:flex; align-items:center; gap:10px; margin-bottom:34px; padding:0 6px;}
  .side-logo .badge{width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg,var(--orange),#FCD34D); display:flex; align-items:center; justify-content:center; font-weight:700; color:#78350F;}
  .side-logo span{font-weight:700; font-size:14px;}
  .side-logo small{display:block; font-weight:400; font-size:10px; color:var(--text-dim);}

  .side-nav{display:flex; flex-direction:column; gap:4px; flex:1;}
  .side-link{display:flex; align-items:center; gap:12px; padding:11px 14px; border-radius:12px; font-size:13.5px; font-weight:500; color:var(--text-dim); transition:background .2s, color .2s;}
  .side-link i{width:18px; height:18px;}
  .side-link:hover{background:rgba(255,255,255,.04); color:#fff;}
  .side-link.active{background:var(--orange); color:#3A1D00;}

  .side-footer{padding-top:16px; border-top:1px solid var(--border); display:flex; align-items:center; gap:10px;}
  .avatar-sm{width:34px; height:34px; border-radius:50%; background:var(--orange); color:#3A1D00; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px;}
  .side-footer div p{font-size:12.5px; font-weight:600;}
  .side-footer div span{font-size:11px; color:var(--text-dim);}

  .main{flex:1; padding:28px 34px; max-width:100%; overflow-x:hidden;}
  .topbar{display:flex; align-items:center; justify-content:space-between; margin-bottom:26px;}
  .topbar h1{font-size:22px; font-weight:700;}
  .topbar p{color:var(--text-dim); font-size:13.5px; margin-top:2px;}
  .top-actions{display:flex; align-items:center; gap:14px;}
  .icon-btn{width:38px; height:38px; border-radius:12px; background:var(--panel); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; position:relative;}
  .icon-btn .dot-alert{position:absolute; top:6px; right:7px; width:7px; height:7px; border-radius:50%; background:var(--red);}

  .stats-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-bottom:26px;}
  .stat-card{background:var(--panel); border:1px solid var(--border); border-radius:var(--radius); padding:20px;}
  .stat-card .ico{width:38px; height:38px; border-radius:11px; display:flex; align-items:center; justify-content:center; margin-bottom:14px;}
  .stat-card b{display:block; font-size:26px; font-weight:700;}
  .stat-card span{font-size:12.5px; color:var(--text-dim);}
  .ico-orange{background:rgba(245,158,11,.15); color:var(--orange);}
  .ico-green{background:rgba(34,197,94,.15); color:var(--green);}
  .ico-red{background:rgba(239,68,68,.15); color:var(--red);}
  .ico-purple{background:rgba(167,139,250,.15); color:var(--purple);}

  .card{background:var(--panel); border:1px solid var(--border); border-radius:var(--radius); padding:22px; margin-bottom:20px;}
  .card-head{display:flex; align-items:center; justify-content:space-between; margin-bottom:18px;}
  .card-head h2{font-size:16px; font-weight:700;}
  .card-head a{font-size:12.5px; color:var(--blue); font-weight:600;}

  table{width:100%; border-collapse:collapse;}
  th{text-align:left; font-size:11px; text-transform:uppercase; letter-spacing:.03em; color:var(--text-dim); padding:0 10px 10px; font-weight:600;}
  td{padding:12px 10px; font-size:13.5px; border-top:1px solid var(--border); vertical-align:middle;}
  .emp-cell{display:flex; align-items:center; gap:10px;}
  .emp-avatar{width:32px; height:32px; border-radius:50%; background:var(--blue); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex:none;}
  .emp-cell div p{font-weight:600; font-size:13px;}
  .emp-cell div span{font-size:11.5px; color:var(--text-dim);}

  .row-actions{display:flex; gap:8px;}
  .btn-approve{background:rgba(34,197,94,.15); color:var(--green); font-size:12px; font-weight:700; padding:7px 12px; border-radius:9px; display:flex; align-items:center; gap:5px;}
  .btn-reject{background:rgba(239,68,68,.15); color:var(--red); font-size:12px; font-weight:700; padding:7px 12px; border-radius:9px; display:flex; align-items:center; gap:5px;}
  .btn-approve:hover{background:var(--green); color:#052e12;}
  .btn-reject:hover{background:var(--red); color:#450a0a;}
  tr.row-done{opacity:.35; text-decoration:line-through; pointer-events:none;}

  .grid-2b{display:grid; grid-template-columns:1.2fr 1fr; gap:20px;}
  .cal-head{display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;}
  .cal-head button{width:28px; height:28px; border-radius:8px; background:var(--panel-2); display:flex; align-items:center; justify-content:center;}
  .cal-grid{display:grid; grid-template-columns:repeat(7,1fr); gap:6px; text-align:center;}
  .cal-grid .dow{font-size:10.5px; color:var(--text-dim); font-weight:600; padding-bottom:6px;}
  .cal-day{font-size:12.5px; padding:8px 0; border-radius:8px; position:relative;}
  .cal-day.today{border:1.5px solid var(--orange);}
  .cal-day .pip{position:absolute; bottom:2px; left:50%; transform:translateX(-50%); width:4px; height:4px; border-radius:50%; background:var(--blue);}

  .donut-wrap{display:flex; align-items:center; gap:20px;}
  .donut{width:110px; height:110px; border-radius:50%; flex:none;}
  .donut-legend{display:flex; flex-direction:column; gap:10px;}
  .donut-legend .row{display:flex; align-items:center; gap:8px; font-size:12.5px;}
  .dot{width:9px; height:9px; border-radius:50%;}

  .kpi-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:18px;}
  .kpi{text-align:center; background:var(--panel-2); border-radius:14px; padding:18px 10px;}
  .kpi b{display:block; font-size:20px; font-weight:700; color:var(--orange);}
  .kpi span{font-size:11.5px; color:var(--text-dim);}

  @media (max-width:1100px){
    .stats-grid{grid-template-columns:1fr 1fr;}
    .grid-2b{grid-template-columns:1fr;}
    .kpi-grid{grid-template-columns:1fr 1fr;}
  }
  @media (max-width:800px){ .sidebar{display:none;} }
</style>
</head>
<body>

<div class="app">

  <!-- ===== SIDEBAR RH ===== -->
  <aside class="sidebar">
    <div class="side-logo">
      <span class="badge">N</span>
      <span>NAJA7HOST<br><small>Espace RH</small></span>
    </div>

    <nav class="side-nav">
      <a href="#" class="side-link active"><i data-lucide="layout-dashboard"></i> Tableau de bord</a>
      <a href="#" class="side-link"><i data-lucide="inbox"></i> Demandes en attente</a>
      <a href="#" class="side-link"><i data-lucide="list-checks"></i> Toutes les demandes</a>
      <a href="#" class="side-link"><i data-lucide="calendar-range"></i> Calendrier d'équipe</a>
      <a href="#" class="side-link"><i data-lucide="users"></i> Employés</a>
      <a href="#" class="side-link"><i data-lucide="wallet"></i> Soldes & compteurs</a>
      <a href="#" class="side-link"><i data-lucide="bar-chart-3"></i> Rapports</a>
      <a href="#" class="side-link"><i data-lucide="download"></i> Exports</a>
      <a href="#" class="side-link"><i data-lucide="settings"></i> Paramètres</a>
    </nav>

    <div class="side-footer">
      <div class="avatar-sm">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      <div>
        <p>{{ auth()->user()->name }}</p>
        <span>Responsable RH</span>
      </div>
    </div>
  </aside>

  <!-- ===== MAIN ===== -->
  <main class="main">

    <div class="topbar">
      <div>
        <h1>Bonjour, {{ explode(' ', auth()->user()->name)[0] }} ! 👋</h1>
        <p>Voici un aperçu des congés et absences de votre équipe.</p>
      </div>
      <div class="top-actions">
        <button class="icon-btn"><span class="dot-alert"></span><i data-lucide="bell" style="width:17px;height:17px;"></i></button>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="icon-btn" title="Se déconnecter"><i data-lucide="log-out" style="width:17px;height:17px;"></i></button>
        </form>
      </div>
    </div>

    <!-- ===== STATS ===== -->
    <div class="stats-grid">
      <div class="stat-card"><span class="ico ico-orange"><i data-lucide="inbox" style="width:18px;height:18px;"></i></span><b id="pendingCount">5</b><span>Demandes en attente</span></div>
      <div class="stat-card"><span class="ico ico-green"><i data-lucide="check-circle" style="width:18px;height:18px;"></i></span><b>34</b><span>Demandes approuvées</span></div>
      <div class="stat-card"><span class="ico ico-red"><i data-lucide="x-circle" style="width:18px;height:18px;"></i></span><b>4</b><span>Demandes refusées</span></div>
      <div class="stat-card"><span class="ico ico-purple"><i data-lucide="activity" style="width:18px;height:18px;"></i></span><b>3.2%</b><span>Taux d'absentéisme</span></div>
    </div>

    <!-- ===== DEMANDES EN ATTENTE ===== -->
    <div class="card">
      <div class="card-head">
        <h2>Demandes en attente</h2>
        <a href="#">Voir toutes les demandes</a>
      </div>
      <table>
        <thead>
          <tr><th>Employé</th><th>Type</th><th>Période</th><th>Demandé le</th><th>Action</th></tr>
        </thead>
        <tbody id="pendingTable">
          <tr>
            <td><div class="emp-cell"><span class="emp-avatar">SA</span><div><p>Sara Amrani</p><span>Développement</span></div></div></td>
            <td>Congé payé</td><td>12 → 16 août</td><td>02 août 2026</td>
            <td><div class="row-actions"><button class="btn-approve"><i data-lucide="check" style="width:12px;height:12px;"></i> Valider</button><button class="btn-reject"><i data-lucide="x" style="width:12px;height:12px;"></i> Refuser</button></div></td>
          </tr>
          <tr>
            <td><div class="emp-cell"><span class="emp-avatar">KM</span><div><p>Karim Moussaoui</p><span>Design</span></div></div></td>
            <td>RTT</td><td>20 août</td><td>05 août 2026</td>
            <td><div class="row-actions"><button class="btn-approve"><i data-lucide="check" style="width:12px;height:12px;"></i> Valider</button><button class="btn-reject"><i data-lucide="x" style="width:12px;height:12px;"></i> Refuser</button></div></td>
          </tr>
          <tr>
            <td><div class="emp-cell"><span class="emp-avatar">LH</span><div><p>Layla Hassani</p><span>Support</span></div></div></td>
            <td>Congé sans solde</td><td>03 → 05 sept.</td><td>08 août 2026</td>
            <td><div class="row-actions"><button class="btn-approve"><i data-lucide="check" style="width:12px;height:12px;"></i> Valider</button><button class="btn-reject"><i data-lucide="x" style="width:12px;height:12px;"></i> Refuser</button></div></td>
          </tr>
          <tr>
            <td><div class="emp-cell"><span class="emp-avatar">YB</span><div><p>Youssef Bakr</p><span>Ventes</span></div></div></td>
            <td>Maladie</td><td>10 août</td><td>10 août 2026</td>
            <td><div class="row-actions"><button class="btn-approve"><i data-lucide="check" style="width:12px;height:12px;"></i> Valider</button><button class="btn-reject"><i data-lucide="x" style="width:12px;height:12px;"></i> Refuser</button></div></td>
          </tr>
          <tr>
            <td><div class="emp-cell"><span class="emp-avatar">NF</span><div><p>Nadia Fassi</p><span>Développement</span></div></div></td>
            <td>Congé payé</td><td>28 → 30 août</td><td>11 août 2026</td>
            <td><div class="row-actions"><button class="btn-approve"><i data-lucide="check" style="width:12px;height:12px;"></i> Valider</button><button class="btn-reject"><i data-lucide="x" style="width:12px;height:12px;"></i> Refuser</button></div></td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- ===== CALENDRIER EQUIPE + REPARTITION ===== -->
    <div class="grid-2b">
      <div class="card">
        <div class="cal-head">
          <h2 style="font-size:16px; font-weight:700;">Calendrier d'équipe — Août 2026</h2>
          <div style="display:flex; gap:6px;">
            <button><i data-lucide="chevron-left" style="width:14px;height:14px;"></i></button>
            <button><i data-lucide="chevron-right" style="width:14px;height:14px;"></i></button>
          </div>
        </div>
        <div class="cal-grid" id="calGrid"></div>
      </div>

      <div class="card">
        <div class="card-head"><h2>Répartition des absences</h2></div>
        <div class="donut-wrap">
          <div class="donut" style="background:conic-gradient(#38BDF8 0% 45%, #4ADE80 45% 70%, #FBBF24 70% 88%, #F87171 88% 100%);"></div>
          <div class="donut-legend">
            <div class="row"><span class="dot" style="background:#38BDF8;"></span> Congé payé — 45%</div>
            <div class="row"><span class="dot" style="background:#4ADE80;"></span> RTT — 25%</div>
            <div class="row"><span class="dot" style="background:#FBBF24;"></span> Maladie — 18%</div>
            <div class="row"><span class="dot" style="background:#F87171;"></span> Sans solde — 12%</div>
          </div>
        </div>
      </div>
    </div>

    <!-- ===== STATS CLES ===== -->
    <div class="card">
      <div class="card-head"><h2>Statistiques clés</h2></div>
      <div class="kpi-grid">
        <div class="kpi"><b>48</b><span>Employés au total</span></div>
        <div class="kpi"><b>312</b><span>Jours de congé utilisés</span></div>
        <div class="kpi"><b>14.5</b><span>Solde moyen / employé</span></div>
        <div class="kpi"><b>9</b><span>Absences prévues (30j)</span></div>
      </div>
    </div>

  </main>
</div>

<script>
  lucide.createIcons();

  // Boutons Valider / Refuser : mettent a jour l'affichage immediatement.
  // NOTE : la vraie mise a jour en base de donnees (table leave_requests +
  // deduction du solde) sera branchee a la prochaine etape du projet.
  const pendingCountEl = document.getElementById('pendingCount');
  let pendingCount = parseInt(pendingCountEl.textContent);

  document.querySelectorAll('.btn-approve, .btn-reject').forEach(btn => {
    btn.addEventListener('click', () => {
      const row = btn.closest('tr');
      row.classList.add('row-done');
      pendingCount = Math.max(0, pendingCount - 1);
      pendingCountEl.textContent = pendingCount;
    });
  });

  // Calendrier d'equipe (identique en structure a celui de l'employe,
  // avec un petit point pour indiquer une absence ce jour-la)
  const calGrid = document.getElementById('calGrid');
  const leaveDays = [12,13,14,15,16,20,10];
  const dows = ['L','M','M','J','V','S','D'];
  dows.forEach(d => { const el = document.createElement('div'); el.className='dow'; el.textContent=d; calGrid.appendChild(el); });

  const today = new Date();
  const year = today.getFullYear(), month = today.getMonth();
  const firstDay = (new Date(year, month, 1).getDay() + 6) % 7;
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  for(let i=0; i<firstDay; i++){ const el = document.createElement('div'); calGrid.appendChild(el); }
  for(let d=1; d<=daysInMonth; d++){
    const el = document.createElement('div');
    el.className = 'cal-day';
    el.textContent = d;
    if(d === today.getDate()) el.classList.add('today');
    if(leaveDays.includes(d)){
      const pip = document.createElement('div');
      pip.className = 'pip';
      el.appendChild(pip);
    }
    calGrid.appendChild(el);
  }
</script>
</body>
</html>
