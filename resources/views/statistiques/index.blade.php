<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Statistiques — NAJA7 HOST</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
@livewireStyles
<style>
  :root{
    --blue:#3B82F6; --blue-2:#60A5FA;
    --orange:#F59E0B; --orange-2:#FBBF24; --green:#10B981; --red:#EF4444; --purple:#8B5CF6; --cyan:#22D3EE;
    --bg:#05070F; --panel:rgba(18,24,42,.55); --panel-2:rgba(255,255,255,.06);
    --border:rgba(255,255,255,.12);
    --text:#F1F4FA; --text-dim:#C3CCE0;
    --radius:22px; --glass-blur:22px;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  html, body{height:100%; overflow-x:hidden;}
  body{
    font-family:'Poppins',sans-serif; color:var(--text); -webkit-font-smoothing:antialiased;
    background-color: #05070F;
    background-image: linear-gradient(180deg, rgba(4,6,14,.72), rgba(4,6,14,.88)), url('{{ asset('images/dashboard-bg.jpg') }}');
    background-repeat: no-repeat;
    background-position: top center;
    background-size: cover, contain;
    background-attachment: scroll;
  }
  a{text-decoration:none; color:inherit;}
  button{font-family:inherit; cursor:pointer; border:none; background:none; color:inherit;}
  select, input, textarea{font-family:inherit;}

  .app{display:flex; align-items:flex-start; min-height:100vh; padding:16px 24px; gap:16px; max-width:1700px; margin:0 auto; overflow-x:hidden;}

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
  .icon-btn{position:relative; width:38px; height:38px; border-radius:12px; background:var(--panel); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; flex:none;}
  .avatar{width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; overflow:hidden; flex:none;}

  .date-range-btn{display:flex; align-items:center; gap:8px; height:40px; padding:0 14px; background:var(--panel); border:1px solid var(--border); border-radius:12px; font-size:12.5px; color:var(--text-dim);}
  .date-range-btn input[type=date]{background:transparent; border:none; outline:none; color:#fff; font-size:12.5px; color-scheme:dark;}

  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25);}
  .panel-pad{padding:20px;}
  .card-head{margin-bottom:14px;}
  .card-head h3{position:relative; font-size:12.5px; font-weight:800; color:#fff; display:inline-flex; align-items:center; gap:8px;
    padding:9px 18px; background:linear-gradient(180deg,var(--orange-2) 0%,var(--orange) 55%,#B45309 100%); border-radius:999px;
    box-shadow:0 5px 12px rgba(245,158,11,.4), inset 0 2px 0 rgba(255,255,255,.35), inset 0 -4px 8px rgba(0,0,0,.25);}

  .kpi-grid{display:grid; grid-template-columns:repeat(5,1fr); gap:16px; margin-bottom:16px;}
  @media (max-width:1300px){ .kpi-grid{grid-template-columns:repeat(3,1fr);} }
  @media (max-width:800px){ .kpi-grid{grid-template-columns:repeat(2,1fr);} }
  .kpi-card{display:flex; flex-direction:column; align-items:center; text-align:center;}
  .kpi-title{font-size:12px; color:#fff; font-weight:600; margin-bottom:14px; min-height:32px;}
  .kpi-ring{
    --pct:0; width:100px; height:100px; border-radius:50%; display:flex; align-items:center; justify-content:center; position:relative; flex:none;
    background:conic-gradient(var(--ring-color) calc(var(--pct)*1%), rgba(255,255,255,.08) 0);
  }
  .kpi-ring::before{content:''; position:absolute; inset:9px; border-radius:50%; background:#0d1220;}
  .kpi-value{position:relative; font-size:19px; font-weight:800; color:#fff;}
  .kpi-blue{--ring-color:var(--blue);} .kpi-green{--ring-color:var(--green);} .kpi-red{--ring-color:var(--red);}
  .kpi-purple{--ring-color:var(--purple);} .kpi-orange{--ring-color:var(--orange);}
  .kpi-prev{font-size:11px; color:var(--text-dim); margin-top:12px;}
  .kpi-delta{font-size:11.5px; font-weight:700; margin-top:4px; display:flex; align-items:center; gap:4px;}
  .kpi-delta.up{color:var(--green);} .kpi-delta.down{color:var(--green);}

  .charts-row-3{display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:16px;}
  .charts-row-4{display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; margin-bottom:16px;}
  @media (max-width:1300px){ .charts-row-3{grid-template-columns:1fr;} .charts-row-4{grid-template-columns:1fr;} }

  .chart-box{position:relative; height:230px; width:100%;}
  .chart-box canvas{max-width:100%; max-height:100%;}
  .chart-box-sm{position:relative; height:190px; width:100%;}
  .chart-box-sm canvas{max-width:100%; max-height:100%;}

  .gauge-wrap{position:relative; display:flex; flex-direction:column; align-items:center; height:160px;}
  .gauge-value{position:absolute; top:56%; font-size:22px; font-weight:800; color:#fff;}

  @media (max-width:800px){ .sidebar{display:none;} }
</style>
</head>
<body>

<div class="app">

  @include('partials.sidebar')

  <main class="main">
    <livewire:stats-dashboard />
  </main>

</div>

@livewireScripts
<script>lucide.createIcons();</script>
@stack('scripts')
</body>
</html>