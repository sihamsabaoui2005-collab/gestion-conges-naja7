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
    --blue:#0EA5E9; --blue-dark:#0284C7;
    --orange:#F59E0B; --green:#22C55E; --red:#EF4444; --purple:#A78BFA;
    --bg:#0A1730; --panel:#101F3D; --panel-2:#14284A;
    --border:rgba(255,255,255,.08);
    --text:#E2E8F0; --text-dim:#94A3B8;
    --radius:18px;
    --ease:cubic-bezier(.22,1,.36,1);
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  body{font-family:'Poppins',sans-serif; background:var(--bg); color:var(--text); -webkit-font-smoothing:antialiased;}
  a{text-decoration:none; color:inherit;}
  button{font-family:inherit; cursor:pointer; border:none; background:none; color:inherit;}
  ul{list-style:none;}

  .app{display:flex; min-height:100vh;}

  /* ===== SIDEBAR ===== */
  .sidebar{width:250px; flex:none; background:var(--panel); border-right:1px solid var(--border); padding:24px 18px; display:flex; flex-direction:column;}
  .side-logo{display:flex; align-items:center; gap:10px; margin-bottom:34px; padding:0 6px;}
  .side-logo .badge{width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg,var(--blue),#7DD3FC); display:flex; align-items:center; justify-content:center; font-weight:700;}
  .side-logo span{font-weight:700; font-size:14px;}
  .side-logo small{display:block; font-weight:400; font-size:10px; color:var(--text-dim);}

  .side-nav{display:flex; flex-direction:column; gap:4px; flex:1;}
  .side-link{display:flex; align-items:center; gap:12px; padding:11px 14px; border-radius:12px; font-size:13.5px; font-weight:500; color:var(--text-dim); transition:background .2s, color .2s;}
  .side-link i{width:18px; height:18px;}
  .side-link:hover{background:rgba(255,255,255,.04); color:#fff;}
  .side-link.active{background:var(--blue); color:#fff;}

  .side-footer{padding-top:16px; border-top:1px solid var(--border); display:flex; align-items:center; gap:10px;}
  .avatar-sm{width:34px; height:34px; border-radius:50%; background:var(--blue); display:flex; align-items:center; justify-content:center; font-weight:600; font-size:13px;}
  .side-footer div p{font-size:12.5px; font-weight:600;}
  .side-footer div span{font-size:11px; color:var(--text-dim);}

  /* ===== MAIN ===== */
  .main{flex:1; padding:28px 34px; max-width:100%; overflow-x:hidden;}
  .topbar{display:flex; align-items:center; justify-content:space-between; margin-bottom:26px;}
  .topbar h1{font-size:22px; font-weight:700;}
  .topbar p{color:var(--text-dim); font-size:13.5px; margin-top:2px;}
  .top-actions{display:flex; align-items:center; gap:14px;}
  .icon-btn{width:38px; height:38px; border-radius:12px; background:var(--panel); border:1px solid var(--border); display:flex; align-items:center; justify-content:center;}

  /* ===== STAT CARDS ===== */
  .stats-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-bottom:26px;}
  .stat-card{background:var(--panel); border:1px solid var(--border); border-radius:var(--radius); padding:20px;}
  .stat-card .top{display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;}
  .stat-card .ico{width:38px; height:38px; border-radius:11px; display:flex; align-items:center; justify-content:center;}
  .stat-card b{display:block; font-size:26px; font-weight:700;}
  .stat-card span{font-size:12.5px; color:var(--text-dim);}
  .ico-blue{background:rgba(14,165,233,.15); color:#38BDF8;}
  .ico-orange{background:rgba(245,158,11,.15); color:var(--orange);}
  .ico-green{background:rgba(34,197,94,.15); color:var(--green);}
  .ico-red{background:rgba(239,68,68,.15); color:var(--red);}

  /* ===== GRID LAYOUT ===== */
  .grid-2{display:grid; grid-template-columns:2fr 1fr; gap:20px; margin-bottom:20px;}
  .grid-2b{display:grid; grid-template-columns:1.2fr 1fr; gap:20px;}

  .card{background:var(--panel); border:1px solid var(--border); border-radius:var(--radius); padding:22px;}
  .card-head{display:flex; align-items:center; justify-content:space-between; margin-bottom:18px;}
  .card-head h2{font-size:16px; font-weight:700;}
  .card-head a{font-size:12.5px; color:var(--blue); font-weight:600;}

  /* ===== TABLE ===== */
  table{width:100%; border-collapse:collapse;}
  th{text-align:left; font-size:11.5px; text-transform:uppercase; letter-spacing:.03em; color:var(--text-dim); padding:0 10px 10px; font-weight:600;}
  td{padding:12px 10px; font-size:13.5px; border-top:1px solid var(--border);}
  .badge{display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:20px; font-size:11.5px; font-weight:600;}
  .badge-approved{background:rgba(34,197,94,.15); color:var(--green);}
  .badge-pending{background:rgba(245,158,11,.15); color:var(--orange);}
  .badge-rejected{background:rgba(239,68,68,.15); color:var(--red);}

  /* ===== NOUVELLE DEMANDE CARD ===== */
  .new-request-card{background:linear-gradient(160deg,var(--blue),var(--blue-dark)); border-radius:var(--radius); padding:24px; display:flex; flex-direction:column; align-items:flex-start; gap:14px;}
  .new-request-card .ico{width:44px; height:44px; border-radius:12px; background:rgba(255,255,255,.18); display:flex; align-items:center; justify-content:center;}
  .new-request-card h3{font-size:16px; font-weight:700;}
  .new-request-card p{font-size:12.5px; opacity:.85;}
  .btn-new{background:#fff; color:var(--blue-dark); font-weight:700; font-size:13.5px; padding:10px 18px; border-radius:12px; display:flex; align-items:center; gap:8px; width:100%; justify-content:center;}

  /* ===== CALENDAR ===== */
  .cal-head{display:flex; align-items:center; justify-content:space-between; margin-bottom:14px;}
  .cal-head button{width:28px; height:28px; border-radius:8px; background:var(--panel-2); display:flex; align-items:center; justify-content:center;}
  .cal-grid{display:grid; grid-template-columns:repeat(7,1fr); gap:6px; text-align:center;}
  .cal-grid .dow{font-size:10.5px; color:var(--text-dim); font-weight:600; padding-bottom:6px;}
  .cal-day{font-size:12.5px; padding:8px 0; border-radius:8px;}
  .cal-day.muted{color:#475569;}
  .cal-day.leave{background:var(--blue); color:#fff; font-weight:700;}
  .cal-day.today{border:1.5px solid var(--orange);}

  /* ===== DONUT ===== */
  .donut-wrap{display:flex; align-items:center; gap:20px;}
  .donut{width:110px; height:110px; border-radius:50%; flex:none;}
  .donut-legend{display:flex; flex-direction:column; gap:10px;}
  .donut-legend .row{display:flex; align-items:center; gap:8px; font-size:12.5px;}
  .dot{width:9px; height:9px; border-radius:50%;}

  /* ===== INFO / HELP ===== */
  .info-list li{display:flex; gap:10px; font-size:12.5px; color:var(--text-dim); margin-bottom:10px; align-items:flex-start;}
  .info-list i{width:15px; height:15px; color:var(--blue); flex:none; margin-top:1px;}
  .help-box{background:var(--panel-2); border-radius:14px; padding:16px; margin-top:16px; text-align:center;}
  .help-box p{font-size:12px; color:var(--text-dim); margin-bottom:10px;}
  .help-box a{display:inline-flex; align-items:center; gap:6px; font-size:12.5px; font-weight:600; color:var(--blue);}

  /* ===== MODAL NOUVELLE DEMANDE ===== */
  .modal-overlay{position:fixed; inset:0; background:rgba(0,0,0,.5); backdrop-filter:blur(4px); display:none; align-items:center; justify-content:center; z-index:200;}
  .modal-overlay.open{display:flex;}
  .modal-box{background:var(--panel); border:1px solid var(--border); border-radius:20px; padding:28px; width:100%; max-width:420px;}
  .modal-box h3{font-size:17px; font-weight:700; margin-bottom:18px;}
  .field{margin-bottom:14px;}
  .field label{display:block; font-size:12px; color:var(--text-dim); margin-bottom:6px;}
  .field select, .field input, .field textarea{width:100%; padding:10px 12px; border-radius:10px; border:1px solid var(--border); background:var(--panel-2); color:#fff; font-family:inherit; font-size:13px;}
  .modal-actions{display:flex; gap:10px; margin-top:18px;}
  .btn-cancel{flex:1; padding:10px; border-radius:10px; border:1px solid var(--border); font-size:13px; font-weight:600;}
  .btn-submit{flex:1; padding:10px; border-radius:10px; background:var(--blue); font-size:13px; font-weight:600;}

  @media (max-width:1100px){
    .stats-grid{grid-template-columns:1fr 1fr;}
    .grid-2, .grid-2b{grid-template-columns:1fr;}
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
      <span class="badge">N</span>
      <span>NAJA7HOST<br><small>Espace Employé</small></span>
    </div>

    <nav class="side-nav">
      <a href="#" class="side-link active"><i data-lucide="layout-dashboard"></i> Tableau de bord</a>
      <a href="#" class="side-link"><i data-lucide="send"></i> Mes demandes</a>
      <a href="#" class="side-link"><i data-lucide="calendar-days"></i> Calendrier</a>
      <a href="#" class="side-link"><i data-lucide="pie-chart"></i> Mes soldes</a>
      <a href="#" class="side-link"><i data-lucide="user-x"></i> Mes absences</a>
      <a href="#" class="side-link"><i data-lucide="file-text"></i> Documents</a>
      <a href="{{ route('profile.edit') }}" class="side-link"><i data-lucide="user"></i> Profil</a>
      <a href="#" class="side-link"><i data-lucide="settings"></i> Paramètres</a>
    </nav>

    <div class="side-footer">
      <div class="avatar-sm">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</div>
      <div>
        <p>{{ auth()->user()->name }}</p>
        <span>Employé</span>
      </div>
    </div>
  </aside>

  <!-- ===== MAIN ===== -->
  <main class="main">

    <div class="topbar">
      <div>
        <h1>Bonjour, {{ explode(' ', auth()->user()->name)[0] }} ! 👋</h1>
        <p>Voici un aperçu de vos congés et absences.</p>
      </div>
      <div class="top-actions">
        <button class="icon-btn"><i data-lucide="bell" style="width:17px;height:17px;"></i></button>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="icon-btn" title="Se déconnecter"><i data-lucide="log-out" style="width:17px;height:17px;"></i></button>
        </form>
      </div>
    </div>

    <!-- ===== STATS ===== -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="top"><span class="ico ico-blue"><i data-lucide="calendar-check" style="width:18px;height:18px;"></i></span></div>
        <b>18</b><span>Jours de congé restants</span>
      </div>
      <div class="stat-card">
        <div class="top"><span class="ico ico-orange"><i data-lucide="clock" style="width:18px;height:18px;"></i></span></div>
        <b>2</b><span>Congés en attente</span>
      </div>
      <div class="stat-card">
        <div class="top"><span class="ico ico-green"><i data-lucide="check-circle" style="width:18px;height:18px;"></i></span></div>
        <b>7</b><span>Congés approuvés</span>
      </div>
      <div class="stat-card">
        <div class="top"><span class="ico ico-red"><i data-lucide="x-circle" style="width:18px;height:18px;"></i></span></div>
        <b>1</b><span>Congés refusés</span>
      </div>
    </div>

    <!-- ===== DEMANDES + NOUVELLE DEMANDE ===== -->
    <div class="grid-2">
      <div class="card">
        <div class="card-head">
          <h2>Mes demandes récentes</h2>
          <a href="#">Voir tout</a>
        </div>
        <table>
          <thead>
            <tr><th>Type</th><th>Période</th><th>Demandé le</th><th>Statut</th></tr>
          </thead>
          <tbody>
            <tr><td>Congé payé</td><td>12 → 16 août</td><td>02 août 2026</td><td><span class="badge badge-approved"><i data-lucide="check" style="width:11px;height:11px;"></i> Approuvée</span></td></tr>
            <tr><td>Maladie</td><td>25 juillet</td><td>25 juillet 2026</td><td><span class="badge badge-approved"><i data-lucide="check" style="width:11px;height:11px;"></i> Approuvée</span></td></tr>
            <tr><td>Congé sans solde</td><td>03 → 05 sept.</td><td>08 août 2026</td><td><span class="badge badge-pending"><i data-lucide="clock" style="width:11px;height:11px;"></i> En attente</span></td></tr>
            <tr><td>Congé payé</td><td>20 → 22 juin</td><td>10 juin 2026</td><td><span class="badge badge-rejected"><i data-lucide="x" style="width:11px;height:11px;"></i> Refusée</span></td></tr>
          </tbody>
        </table>
      </div>

      <div class="new-request-card">
        <span class="ico"><i data-lucide="plus-circle" style="width:22px;height:22px;"></i></span>
        <h3>Nouvelle demande</h3>
        <p>Besoin de poser un congé ? Envoyez votre demande en 30 secondes.</p>
        <button class="btn-new" id="openNewRequest"><i data-lucide="plus" style="width:15px;height:15px;"></i> Nouvelle demande</button>
      </div>
    </div>

    <!-- ===== CALENDRIER + SOLDES ===== -->
    <div class="grid-2b" style="margin-bottom:20px;">
      <div class="card">
        <div class="cal-head">
          <h2 style="font-size:16px; font-weight:700;">Mon calendrier — Août 2026</h2>
          <div style="display:flex; gap:6px;">
            <button><i data-lucide="chevron-left" style="width:14px;height:14px;"></i></button>
            <button><i data-lucide="chevron-right" style="width:14px;height:14px;"></i></button>
          </div>
        </div>
        <div class="cal-grid" id="calGrid"></div>
      </div>

      <div class="card">
        <div class="card-head"><h2>Mes soldes par type</h2></div>
        <div class="donut-wrap">
          <div class="donut" style="background:conic-gradient(#38BDF8 0% 60%, #4ADE80 60% 80%, #FBBF24 80% 100%);"></div>
          <div class="donut-legend">
            <div class="row"><span class="dot" style="background:#38BDF8;"></span> Congé payé — 18j</div>
            <div class="row"><span class="dot" style="background:#4ADE80;"></span> RTT — 6j</div>
            <div class="row"><span class="dot" style="background:#FBBF24;"></span> Sans solde — 3j</div>
          </div>
        </div>
      </div>
    </div>

    <!-- ===== INFOS + AIDE ===== -->
    <div class="grid-2">
      <div class="card">
        <div class="card-head"><h2>Informations utiles</h2></div>
        <ul class="info-list">
          <li><i data-lucide="info"></i> Les demandes doivent être soumises au moins 5 jours avant la date de début.</li>
          <li><i data-lucide="info"></i> Le solde de congés payés se renouvelle chaque 1er janvier.</li>
          <li><i data-lucide="info"></i> Les jours non pris ne sont pas reportés au-delà du 31 mars.</li>
        </ul>
      </div>
      <div class="card">
        <div class="card-head"><h2>Besoin d'aide ?</h2></div>
        <div class="help-box">
          <p>Une question sur vos congés ? Contactez l'équipe RH.</p>
          <a href="#"><i data-lucide="mail" style="width:14px;height:14px;"></i> contact@naja7host.com</a>
        </div>
      </div>
    </div>

  </main>
</div>

<!-- ===== MODAL NOUVELLE DEMANDE ===== -->
<div class="modal-overlay" id="requestModal">
  <div class="modal-box">
    <h3>Nouvelle demande de congé</h3>
    <div class="field">
      <label>Type de congé</label>
      <select>
        <option>Congé payé</option>
        <option>RTT</option>
        <option>Congé sans solde</option>
        <option>Maladie</option>
      </select>
    </div>
    <div class="field">
      <label>Date de début</label>
      <input type="date">
    </div>
    <div class="field">
      <label>Date de fin</label>
      <input type="date">
    </div>
    <div class="field">
      <label>Motif (optionnel)</label>
      <textarea rows="3" placeholder="Précisez si besoin..."></textarea>
    </div>
    <div class="modal-actions">
      <button class="btn-cancel" id="cancelRequest">Annuler</button>
      <button class="btn-submit" id="submitRequest">Envoyer la demande</button>
    </div>
  </div>
</div>

<script>
  lucide.createIcons();

  // Modal nouvelle demande
  const modal = document.getElementById('requestModal');
  document.getElementById('openNewRequest').addEventListener('click', () => modal.classList.add('open'));
  document.getElementById('cancelRequest').addEventListener('click', () => modal.classList.remove('open'));
  modal.addEventListener('click', e => { if(e.target === modal) modal.classList.remove('open'); });
  document.getElementById('submitRequest').addEventListener('click', () => {
    // NOTE : ici on ferme juste le popup. La vraie sauvegarde en base de
    // donnees (table leave_requests) sera branchee a l'etape suivante du projet.
    modal.classList.remove('open');
    alert('Demande envoyée ! (l\'enregistrement réel arrivera à la prochaine étape)');
  });

  // Petit calendrier du mois (genere dynamiquement, avec quelques jours de conge simules)
  const calGrid = document.getElementById('calGrid');
  const leaveDays = [12,13,14,15,16]; // jours simules en conge, a relier plus tard a la base de donnees
  const dows = ['L','M','M','J','V','S','D'];
  dows.forEach(d => { const el = document.createElement('div'); el.className='dow'; el.textContent=d; calGrid.appendChild(el); });

  const today = new Date();
  const year = today.getFullYear(), month = today.getMonth();
  const firstDay = (new Date(year, month, 1).getDay() + 6) % 7; // lundi = 0
  const daysInMonth = new Date(year, month + 1, 0).getDate();

  for(let i=0; i<firstDay; i++){ const el = document.createElement('div'); calGrid.appendChild(el); }
  for(let d=1; d<=daysInMonth; d++){
    const el = document.createElement('div');
    el.className = 'cal-day';
    el.textContent = d;
    if(leaveDays.includes(d)) el.classList.add('leave');
    if(d === today.getDate()) el.classList.add('today');
    calGrid.appendChild(el);
  }
</script>
</body>
</html>
