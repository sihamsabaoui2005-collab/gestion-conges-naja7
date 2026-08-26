<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Solde des congés — NAJA7 HOST</title>
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

  .header{display:flex; align-items:center; justify-content:space-between; margin-bottom:16px; flex-wrap:wrap; gap:14px;}
  .header-left h1{position:relative; font-size:14px; font-weight:800; color:#fff; display:inline-flex; align-items:center; gap:7px;
    padding:10px 22px; background:linear-gradient(180deg,#3D7BFF 0%,#1E4FC4 55%,#123591 100%); border-radius:999px;
    box-shadow:0 6px 14px rgba(23,73,176,.5), inset 0 2px 0 rgba(255,255,255,.4), inset 0 -4px 8px rgba(0,0,0,.3);}
  .header-left p{color:var(--text-dim); font-size:12px; margin-top:4px; text-shadow:0 2px 8px rgba(0,0,0,.5); max-width:520px;}
  .header-right{display:flex; align-items:center; gap:12px; position:relative;}

  .icon-btn{position:relative; width:38px; height:38px; border-radius:12px; background:var(--panel); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; flex:none;}
  .icon-btn .dot{position:absolute; top:-3px; right:-3px; background:var(--red); color:#fff; font-size:9px; font-weight:700; width:16px; height:16px; border-radius:50%; display:flex; align-items:center; justify-content:center;}
  .avatar{width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; overflow:hidden; flex:none;}
  .avatar img{width:100%; height:100%; object-fit:cover; object-position:center top;}

  .notif-panel{position:absolute; top:52px; right:0; background:rgba(18,24,42,.85); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:10px; width:290px; box-shadow:0 12px 30px rgba(0,0,0,.4); display:none; z-index:80;}
  .notif-panel.open{display:block;}
  .notif-panel h4{font-size:12.5px; padding:6px 8px 10px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.03em;}
  .notif-item{display:flex; align-items:flex-start; gap:10px; padding:9px 8px; border-radius:11px; font-size:12.5px;}
  .notif-item:hover{background:rgba(255,255,255,.05);}
  .notif-item .n-ico{width:28px; height:28px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex:none;}
  .notif-empty{padding:14px 8px; font-size:12.5px; color:var(--text-dim); text-align:center;}

  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25); padding:16px 18px;}

  .layout{display:grid; grid-template-columns:1fr 300px; gap:12px; align-items:stretch; margin-bottom:12px;}
  @media (max-width:1050px){ .layout{grid-template-columns:1fr;} }

  .panel-title{display:flex; align-items:center; gap:8px; font-size:14px; font-weight:700; color:#fff; margin-bottom:12px;}
  .panel-title .ico{width:28px; height:28px; border-radius:9px; display:flex; align-items:center; justify-content:center; background:rgba(245,158,11,.15); color:var(--orange); flex:none;}

  /* ---- Panel principal : solde annuel ---- */
  .solde-main{display:flex; align-items:center; gap:28px; flex-wrap:wrap;}
  .ring-wrap{position:relative; width:190px; height:190px; flex:none;}
  .ring-wrap .center{position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;}
  .ring-wrap .center b{font-size:42px; font-weight:800; color:#fff; line-height:1;}
  .ring-wrap .center span{font-size:13px; color:var(--text-dim); margin-top:4px;}
  .solde-info{flex:1; min-width:160px;}
  .solde-info .used{font-size:17px; font-weight:700; color:#fff;}
  .solde-info .used span{font-weight:400; color:var(--text-dim); font-size:14px;}
  .solde-info .year-tag{display:inline-flex; align-items:center; gap:6px; margin-top:14px; background:var(--panel-2); border:1px solid var(--border); padding:7px 15px; border-radius:999px; font-size:13px; color:var(--text-dim);}
  .solde-illu{position:relative; display:flex; align-items:center; gap:16px; margin-left:auto; max-width:400px;}
  .solde-illu img{height:190px; width:auto; max-width:280px; object-fit:contain; flex:none;}
  .solde-illu p{font-size:12.5px; color:var(--text-dim); line-height:1.5;}

  /* ---- Thème violet néon pour le panel Solde ---- */
  .solde-hero{position:relative; overflow:hidden; padding:22px 24px; border-radius:32px !important;
    box-shadow:0 8px 24px rgba(0,0,0,.25), 0 0 46px rgba(139,92,246,.14);
    border:1px solid rgba(139,92,246,.35) !important;
    background:
      radial-gradient(120% 160% at 12% -20%, rgba(139,92,246,.32), transparent 55%),
      radial-gradient(90% 120% at 105% 100%, rgba(59,130,246,.16), transparent 60%),
      linear-gradient(160deg, #0d0d20 0%, #08081a 100%);
    border:1px solid rgba(139,92,246,.25);}
  .solde-hero::before, .solde-hero::after{content:''; position:absolute; width:64px; height:44px;
    background-image:radial-gradient(rgba(139,92,246,.55) 1px, transparent 1.5px); background-size:9px 9px; pointer-events:none;}
  .solde-hero::before{top:14px; right:100px; opacity:.55;}
  .solde-hero::after{bottom:14px; left:16px; opacity:.4;}

  .hero-head{display:flex; align-items:flex-start; gap:14px; margin-bottom:20px;}
  .hero-icon{width:48px; height:48px; border-radius:15px; flex:none; display:flex; align-items:center; justify-content:center; color:#fff;
    background:linear-gradient(135deg,#8B5CF6,#3B82F6); box-shadow:0 8px 20px rgba(139,92,246,.4);}
  .hero-head h2{font-size:18px; font-weight:800; color:#fff;}
  .hero-head p{font-size:11.5px; color:var(--text-dim); margin-top:2px;}
  .hero-underline{width:40px; height:3px; border-radius:2px; margin-top:9px; background:linear-gradient(90deg,#8B5CF6,#3B82F6);}

  .hero-ring-wrap{position:relative; width:190px; height:190px; flex:none;}
  .hero-ring-wrap .center{position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center; text-align:center;}
  .hero-ring-wrap .center b{font-size:48px; font-weight:800; color:#fff; line-height:1;}
  .hero-ring-wrap .center span{font-size:12.5px; color:var(--text-dim); margin-top:4px;}

  .hero-used{font-size:16px; color:#fff; font-weight:400; line-height:1.5;}
  .hero-used b{color:#C4B5FD; font-weight:700;}
  .hero-used .par-an{display:block; font-size:14px; color:var(--text-dim);}
  .hero-used-line{width:70px; height:2px; border-radius:2px; margin-top:9px; background:linear-gradient(90deg,#8B5CF6,#3B82F6);}
  .hero-year-tag{display:inline-flex; align-items:center; gap:6px; margin-top:13px; background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.12); padding:7px 15px; border-radius:999px; font-size:12.5px; color:var(--text-dim);}
  .hero-year-tag b{color:#60A5FA;}

  .hero-illu{position:relative; flex:none; width:250px; min-width:200px; display:flex; align-items:center; justify-content:center;}
  .hero-illu .glow-plate{position:absolute; bottom:4px; width:190px; height:32px; border-radius:50%;
    background:radial-gradient(closest-side, rgba(139,92,246,.5), transparent 70%); filter:blur(5px);}
  .hero-illu img{position:relative; height:200px; width:auto; max-width:250px; object-fit:contain;}
  .hero-illu .ring-deco{position:absolute; top:6px; left:16%; width:24px; height:24px; border:2px solid rgba(139,92,246,.6); border-radius:50%;}
  .hero-illu .tri-deco{position:absolute; top:30px; right:22%; width:0; height:0; transform:rotate(15deg);
    border-left:8px solid transparent; border-right:8px solid transparent; border-bottom:15px solid rgba(139,92,246,.55);}

  .hero-quote{position:relative; flex:none; width:118px; align-self:stretch; background:rgba(255,255,255,.04);
    border:1px solid rgba(139,92,246,.2); border-radius:16px; padding:12px 10px; display:flex; flex-direction:column; justify-content:center;}
  .hero-quote .mark{font-size:18px; color:#8B5CF6; font-weight:800; line-height:1;}
  .hero-quote p{font-size:9.5px; color:var(--text-dim); line-height:1.4; margin-top:5px;}
  .hero-quote .quote-line{width:32px; height:2px; border-radius:2px; margin-top:8px; background:linear-gradient(90deg,#8B5CF6,#3B82F6);}
  @media (max-width:1200px){ .hero-quote{display:none;} }
  @media (max-width:900px){ .hero-illu{display:none;} }
  .deco-dot{position:absolute; color:var(--orange); opacity:.75;}
  .deco-dot.d1{top:-14px; left:14px; font-size:13px;}
  .deco-dot.d2{top:-6px; right:64px; font-size:10px;}
  .deco-dot.d3{bottom:-10px; left:-4px; font-size:9px;}

  /* ---- En résumé + activité ---- */
  .resume-row{display:flex; align-items:center; justify-content:space-between; padding:7px 0; border-bottom:1px solid var(--border); font-size:12.5px;}
  .resume-row:last-child{border-bottom:none;}
  .resume-row span:first-child{color:var(--text-dim);}
  .resume-row b{color:#fff; font-size:13.5px;}

  .activite-item{display:flex; align-items:center; gap:9px; padding:8px 0; border-bottom:1px solid var(--border);}
  .activite-item:last-child{border-bottom:none;}
  .activite-item .ico{width:27px; height:27px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex:none;}
  .activite-item .txt{flex:1; min-width:0;}
  .activite-item .txt b{display:block; font-size:12px; color:#fff;}
  .activite-item .txt span{font-size:10.5px; color:var(--text-dim);}
  .activite-item .jours{font-size:11px; color:var(--text-dim); flex:none; text-align:right;}
  .activite-item .badge-ok{display:block; margin-top:2px; font-size:9.5px; font-weight:700; color:var(--green);}
  .head-row{display:flex; align-items:center; justify-content:space-between; margin-bottom:10px;}
  .head-row a{font-size:11px; font-weight:600; color:var(--text-dim);}
  .head-row a:hover{color:#fff;}

  /* ---- Cartes types de congé (design glow) ---- */
  .type-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:16px;}
  @media (max-width:900px){ .type-grid{grid-template-columns:repeat(2,1fr);} }

  .type-card{position:relative; overflow:hidden; display:flex; flex-direction:column; min-height:270px;
    background:linear-gradient(165deg, rgba(255,255,255,.035), rgba(255,255,255,.01));
    border:1px solid rgba(var(--c-rgb),.4); border-radius:24px; padding:16px 16px 0;
    box-shadow:0 0 26px rgba(var(--c-rgb),.14), inset 0 0 30px rgba(var(--c-rgb),.025);}

  .type-card .dots-deco{position:absolute; top:76px; left:12px; width:44px; height:100px; pointer-events:none;
    background-image:radial-gradient(rgba(var(--c-rgb),.55) 1px, transparent 1.5px); background-size:8px 8px; opacity:.5;}

  .type-card .t-head{position:relative; z-index:1; display:flex; align-items:center; gap:9px; margin-bottom:14px;}
  .type-card .t-head .ico{width:30px; height:30px; border-radius:10px; background:rgba(var(--c-rgb),.18); color:var(--c);
    display:flex; align-items:center; justify-content:center; flex:none;}
  .type-card .t-head b{font-size:12.5px; font-weight:700; color:#fff; flex:1;}
  .type-card .t-head .dots3{color:var(--c); opacity:.75; font-weight:700; letter-spacing:1.5px; font-size:12px;}

  .type-mini-ring{position:relative; width:98px; height:98px; margin:2px auto 0; z-index:1;}
  .type-mini-ring .center{position:absolute; inset:0; display:flex; flex-direction:column; align-items:center; justify-content:center;}
  .type-mini-ring .center b{font-size:26px; font-weight:800; color:#fff;}
  .type-mini-ring .center span{font-size:9.5px; color:var(--text-dim);}

  .type-card .wave{position:relative; margin-top:12px;}
  .type-card .wave svg{display:block; width:100%; height:26px;}
  .type-card .foot{position:relative; z-index:1; background:rgba(var(--c-rgb),.09); margin:-1px -16px 0; padding:12px 10px 14px; text-align:center; flex:1;}
  .type-card .foot p{font-size:10.5px; color:#EAEDF7; line-height:1.5;}

  .type-bar{position:relative; height:5px; border-radius:3px; background:rgba(255,255,255,.1); margin:14px 2px 16px;}
  .type-bar span{display:block; height:100%; border-radius:3px; background:var(--c);}
  .type-bar .thumb{position:absolute; top:50%; width:12px; height:12px; border-radius:50%; background:var(--c);
    box-shadow:0 0 8px rgba(var(--c-rgb),.8); transform:translate(-50%,-50%);}

  /* ---- Prévision (graphique) ---- */
  .legend{display:flex; gap:16px; font-size:12px; color:var(--text-dim); margin-bottom:10px;}
  .legend span{display:inline-flex; align-items:center; gap:6px;}
  .legend i{width:9px; height:9px; border-radius:3px; display:inline-block;}
  .chart-wrap{width:100%; overflow-x:auto;}

  /* ---- Conseils & bien-être ---- */
  .conseil-box{background:var(--panel-2); border-radius:12px; padding:9px 10px; display:flex; gap:8px; align-items:flex-start; margin-bottom:8px;}
  .conseil-box .emoji{width:26px; height:26px; border-radius:50%; background:rgba(245,158,11,.15); display:flex; align-items:center; justify-content:center; flex:none; font-size:13px;}
  .conseil-box p{font-size:10px; color:var(--text-dim); line-height:1.4;}
  .conseil-btn{display:inline-block; margin-top:6px; font-size:10.5px; font-weight:700; color:var(--purple);}
  .astuce-grid{display:flex; flex-direction:column; gap:10px; margin-top:4px;}
  .infocard{position:relative; margin:5px 8px 5px 3px;}
  .infocard .frame{position:absolute; background:var(--c); border-radius:2px;}
  .infocard .tr-h{top:-5px; right:-8px; width:22px; height:2px;}
  .infocard .tr-v{top:-8px; right:-5px; width:2px; height:22px;}
  .infocard .bl-h{bottom:-5px; left:-8px; width:22px; height:2px;}
  .infocard .bl-v{bottom:-8px; left:-5px; width:2px; height:22px;}
  .infocard .ic-inner{position:relative; z-index:1; display:flex; align-items:center; gap:10px;
    background:rgba(255,255,255,.045); border:1px solid rgba(255,255,255,.08); border-radius:10px; padding:9px 12px;}
  .infocard .ic-inner .ico{width:26px; height:26px; flex:none; display:flex; align-items:center; justify-content:center; color:var(--c);
    background:rgba(255,255,255,.05); border-radius:8px;}
  .infocard .ic-inner b{display:block; font-size:11px; color:#fff; line-height:1.3;}
  .infocard .ic-inner span{font-size:9px; color:var(--text-dim); line-height:1.3; display:block; margin-top:2px;}

  /* ---- Bandeau info bas de page ---- */
  .info-bar{display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; padding:12px 18px;}
  .info-bar .txt{display:flex; align-items:flex-start; gap:10px; font-size:11px; color:var(--text-dim); line-height:1.45;}
  .info-bar .txt .ico{width:26px; height:26px; border-radius:8px; background:rgba(59,130,246,.15); color:var(--blue-2); display:flex; align-items:center; justify-content:center; flex:none;}
  .btn-contact{display:inline-flex; align-items:center; gap:6px; font-size:12px; font-weight:700; color:var(--blue-2); border:1px solid rgba(59,130,246,.4); padding:8px 14px; border-radius:999px; flex:none;}
  .btn-contact:hover{background:rgba(59,130,246,.1);}

  @media (max-width:800px){ .sidebar{display:none;} }
  /* ---- Agrandissement général du texte + gras (demande) ---- */
  .header-left p{font-size:14px; font-weight:600;}
  .panel-title{font-size:16px;}
  .hero-head h2{font-size:20px;}
  .hero-head p{font-size:13px; font-weight:600;}
  .hero-used{font-size:18px; font-weight:600;}
  .hero-year-tag{font-size:14px; font-weight:600;}
  .hero-quote p{font-size:12.5px; font-weight:600;}
  .resume-row{font-size:14.5px;}
  .resume-row span:first-child{font-weight:600;}
  .resume-row b{font-size:16px;}
  .activite-item .txt b{font-size:14px;}
  .activite-item .txt span{font-weight:600;}
  .activite-item .jours{font-weight:700; font-size:12.5px;}
  .type-card .t-head b{font-size:14px;}
  .type-card .foot p{font-size:12px; font-weight:600;}
  .conseil-box p{font-size:12px; font-weight:600;}
  .infocard .ic-inner b{font-size:12.5px;}
  .infocard .ic-inner span{font-size:10.5px; font-weight:600;}
  .legend{font-size:13px; font-weight:600;}

  /* Badges/pastilles façon bouton pilule du dashboard */
  .hero-year-tag, .year-tag{
    background:radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.25), rgba(255,255,255,0) 45%), linear-gradient(160deg, #8B5CF6, #3B82F6);
    border:none; color:#fff; box-shadow:0 6px 14px rgba(59,130,246,.35), inset 0 1px 0 rgba(255,255,255,.25);}
  .hero-year-tag b{color:#fff;}
</style>
</head>
<body>

<div class="app">

  @include('partials.sidebar')

  <main class="main">

    <div class="header">
      <div class="header-left">
        <h1>Bonjour, {{ auth()->user()->name }}</h1>
        <p>Voici le récapitulatif de vos congés et absences.</p>
      </div>
      <div class="header-right">
        @include('partials.notifications')

        <a href="{{ route('profile.edit') }}" class="avatar">
          @if (auth()->user()->photo_path)
            <img src="{{ asset('storage/'.auth()->user()->photo_path) }}" alt="">
          @else
            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
          @endif
        </a>
      </div>
    </div>

    {{-- Ligne 1 : solde annuel + en résumé/activité --}}
    <div class="layout">

      <div class="panel solde-hero" style="display:flex; flex-direction:column;">
        @php
          $rayon = 78; $circonf = 2 * pi() * $rayon;
          $pourcentage = $soldeAnnuelTotal > 0 ? min(100, ($joursUtilisesAnnuel / $soldeAnnuelTotal) * 100) : 0;
          $offset = $circonf - ($circonf * $pourcentage / 100);
          $angle = deg2rad(-90 + 360 * $pourcentage / 100);
          $dotX = 95 + $rayon * cos($angle);
          $dotY = 95 + $rayon * sin($angle);
        @endphp

        <div class="hero-head">
          <span class="hero-icon"><i data-lucide="calendar-clock" style="width:22px;height:22px;"></i></span>
          <div>
            <h2>Solde des congés annuels</h2>
            <p>Prenez soin de vous, nous prenons soin du reste.</p>
            <div class="hero-underline"></div>
          </div>
        </div>

        <div class="solde-main" style="flex:1;">
          <div class="hero-ring-wrap">
            <svg viewBox="0 0 190 190" style="width:100%; height:100%; overflow:visible;">
              <defs>
                <linearGradient id="ringGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                  <stop offset="0%" stop-color="#8B5CF6"/>
                  <stop offset="100%" stop-color="#22D3EE"/>
                </linearGradient>
                <filter id="ringGlow" x="-50%" y="-50%" width="200%" height="200%">
                  <feGaussianBlur stdDeviation="4" result="blur"/>
                  <feMerge><feMergeNode in="blur"/><feMergeNode in="SourceGraphic"/></feMerge>
                </filter>
              </defs>

              <circle cx="95" cy="95" r="{{ $rayon }}" fill="none" stroke="rgba(139,92,246,.18)" stroke-width="12" stroke-dasharray="2 8"/>

              @if ($pourcentage > 0)
                <circle cx="95" cy="95" r="{{ $rayon }}" fill="none" stroke="url(#ringGrad)" stroke-width="12" stroke-linecap="round"
                  stroke-dasharray="{{ $circonf }}" stroke-dashoffset="{{ $offset }}"
                  transform="rotate(-90 95 95)" filter="url(#ringGlow)"/>
                <circle cx="{{ $dotX }}" cy="{{ $dotY }}" r="6" fill="#fff" filter="url(#ringGlow)"/>
              @endif
            </svg>
            <div class="center"><b>{{ $joursRestantsAnnuel }}</b><span>jours restants</span></div>
          </div>

          <div class="solde-info">
            <div class="hero-used"><b>{{ $joursUtilisesAnnuel }} jours utilisés</b> / {{ $soldeAnnuelTotal }} jours<span class="par-an">par an</span></div>
            <div class="hero-used-line"></div>
            <div class="hero-year-tag"><i data-lucide="calendar" style="width:13px;height:13px;"></i> Année en cours : <b>{{ $anneeEnCours }}</b></div>
          </div>

          <div class="hero-illu">
            <span class="glow-plate"></span>
            <img src="{{ asset('images/illustration-calendrier.png') }}" alt="">
          </div>

          <div class="hero-quote">
            <span class="mark">&ldquo;</span>
            <p>Bien gérer ses congés, c'est aussi prendre soin de soi pour être plus productif au quotidien.</p>
            <div class="quote-line"></div>
          </div>
        </div>
      </div>

      <div style="display:flex; flex-direction:column; gap:12px;">

        <div class="panel">
          <div class="panel-title" style="margin-bottom:6px;">
            <span class="ico" style="background:rgba(59,130,246,.15); color:var(--blue-2);"><i data-lucide="pie-chart" style="width:15px;height:15px;"></i></span>
            En résumé
          </div>
          <div class="resume-row"><span>Total jours utilisés</span><b>{{ $totalJoursUtilises }} jours</b></div>
          <div class="resume-row"><span>Jours restants (annuels)</span><b style="color:var(--blue-2);">{{ $joursRestantsAnnuel }} jours</b></div>
          <div class="resume-row"><span>Total types de congés</span><b>{{ $totalTypesConges }}</b></div>
          <div class="resume-row"><span>Demandes en attente</span><b>{{ $demandesEnAttente }}</b></div>
        </div>

        <div class="panel">
          <div class="head-row">
            <div class="panel-title" style="margin-bottom:0;">
              <span class="ico" style="background:rgba(16,185,129,.15); color:var(--green);"><i data-lucide="activity" style="width:15px;height:15px;"></i></span>
              Activité récente
            </div>
            <a href="#">Voir tout</a>
          </div>
          @foreach ($activitesRecentes as $activite)
            <div class="activite-item">
              <span class="ico" style="background:rgba({{ $activite['rgb'] }},.15); color:{{ $activite['couleur'] }};">
                <i data-lucide="{{ $activite['icone'] }}" style="width:15px;height:15px;"></i>
              </span>
              <div class="txt">
                <b>{{ $activite['type'] }}</b>
                <span>{{ $activite['periode'] }}</span>
              </div>
              <div class="jours">
                {{ $activite['jours'] }} jour{{ $activite['jours'] > 1 ? 's' : '' }}
                <span class="badge-ok">{{ $activite['statut'] }}</span>
              </div>
            </div>
          @endforeach
        </div>

      </div>
    </div>

    {{-- Ligne 2 : détail par type de congé --}}
    <div class="panel" style="margin-bottom:12px;">
      <div class="panel-title" style="margin-bottom:16px;">
        <span class="ico" style="background:linear-gradient(135deg,#8B5CF6,#3B82F6); color:#fff;"><i data-lucide="layout-grid" style="width:16px;height:16px;"></i></span>
        <div>
          Utilisation détaillée par type de congé
          <div class="hero-underline" style="margin-top:6px;"></div>
        </div>
      </div>

      <div class="type-grid">
        @foreach ($typesConges as $t)
          @php
            $r = 42; $c = 2 * pi() * $r;
            $pct = $t['total'] ? min(100, ($t['utilise'] / $t['total']) * 100) : 15;
            $off = $c - ($c * $pct / 100);
          @endphp
          <div class="type-card" style="--c:{{ $t['couleur'] }}; --c-rgb:{{ $t['rgb'] }};">
            <span class="dots-deco"></span>

            <div class="t-head">
              <span class="ico"><i data-lucide="{{ $t['icone'] }}" style="width:15px;height:15px;"></i></span>
              <b>{{ $t['label'] }}</b>
              <span class="dots3">&bull;&bull;&bull;</span>
            </div>

            <div class="type-mini-ring">
              <svg viewBox="0 0 98 98" style="width:100%; height:100%; overflow:visible;">
                <defs>
                  <filter id="glow-{{ $loop->index }}" x="-50%" y="-50%" width="200%" height="200%">
                    <feGaussianBlur stdDeviation="2.5" result="b"/>
                    <feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge>
                  </filter>
                </defs>
                <circle cx="49" cy="49" r="{{ $r }}" fill="none" stroke="rgba(255,255,255,.08)" stroke-width="8"/>
                <circle cx="49" cy="49" r="{{ $r }}" fill="none" stroke="{{ $t['couleur'] }}" stroke-width="8" stroke-linecap="round"
                  stroke-dasharray="{{ $c }}" stroke-dashoffset="{{ $off }}" transform="rotate(-90 49 49)" filter="url(#glow-{{ $loop->index }})"/>
              </svg>
              <div class="center"><b>{{ $t['utilise'] }}</b><span>utilisés</span></div>
            </div>

            <div class="wave">
              <svg viewBox="0 0 300 30" preserveAspectRatio="none">
                <path d="M0,30 C90,0 210,0 300,30 L300,30 L0,30 Z" fill="rgba({{ $t['rgb'] }},.09)"/>
              </svg>
              <div class="foot">
                @if ($t['total'])
                  <p>{{ $t['restant'] }} jours restants<br>{{ $t['total'] }} jours par an</p>
                @else
                  <p>solde non précis<br>{{ $t['regle'] }}</p>
                @endif
              </div>
            </div>

            <div class="type-bar">
              <span style="width:{{ $pct }}%;"></span>
              <span class="thumb" style="left:{{ $pct }}%;"></span>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- Ligne 3 : prévision + conseils --}}
    <div class="layout" style="margin-bottom:0;">

      <div class="panel">
        <div class="head-row">
          <div class="panel-title" style="margin-bottom:0;">
            <span class="ico"><i data-lucide="trending-up" style="width:16px;height:16px;"></i></span>
            Prévision de vos congés
          </div>
        </div>
        <div class="legend">
          <span><i style="background:var(--orange);"></i> Congés utilisés</span>
          <span><i style="background:var(--blue-2);"></i> Congés restants (annuels)</span>
        </div>

        <div class="chart-wrap">
          <svg viewBox="0 0 760 260" style="width:100%; min-width:560px; height:auto;">
            @php
              $mois = ['Jan','Fév','Mar','Avr','Mai','Juin','Juil','Août','Sept','Oct','Nov','Déc'];
              $stepX = 700 / 11; $maxY = $soldeAnnuelTotal ?: 25;
              $toXY = fn($i,$v) => [30 + $i * $stepX, 230 - ($v / $maxY) * 210];
              $ptsUtilises = collect($previsionParMois)->map(fn($m,$i) => $toXY($i, $m['utilise']))->values();
              $ptsRestants = collect($previsionParMois)->map(fn($m,$i) => $toXY($i, $m['restant']))->values();
              $lineUtilises = $ptsUtilises->map(fn($p) => $p[0].','.$p[1])->implode(' ');
              $lineRestants = $ptsRestants->map(fn($p) => $p[0].','.$p[1])->implode(' ');
            @endphp

            @foreach ([0,5,10,15,20,25] as $g)
              @php $y = 230 - ($g / $maxY) * 210; @endphp
              <line x1="30" y1="{{ $y }}" x2="730" y2="{{ $y }}" stroke="rgba(255,255,255,.06)" stroke-width="1"/>
              <text x="10" y="{{ $y + 4 }}" font-size="10" fill="#C3CCE0">{{ $g }}</text>
            @endforeach

            <polyline points="{{ $lineRestants }}" fill="none" stroke="var(--blue-2)" stroke-width="2.5"/>
            <polyline points="{{ $lineUtilises }}" fill="none" stroke="var(--orange)" stroke-width="2.5"/>

            @foreach ($ptsRestants as $p)
              <circle cx="{{ $p[0] }}" cy="{{ $p[1] }}" r="3.5" fill="var(--blue-2)"/>
            @endforeach
            @foreach ($ptsUtilises as $p)
              <circle cx="{{ $p[0] }}" cy="{{ $p[1] }}" r="3.5" fill="var(--orange)"/>
            @endforeach

            @foreach ($mois as $i => $m)
              <text x="{{ 30 + $i * $stepX }}" y="250" font-size="10" fill="#C3CCE0" text-anchor="middle">{{ $m }}</text>
            @endforeach
          </svg>
        </div>
      </div>

      <div class="panel">
        <div class="panel-title">
          <span class="ico" style="background:rgba(139,92,246,.15); color:var(--purple);"><i data-lucide="leaf" style="width:15px;height:15px;"></i></span>
          Conseils &amp; bien-être
        </div>

        <div class="conseil-box">
          <span class="emoji">🙂</span>
          <div>
            <p>Vous avez utilisé {{ round($pourcentage) }}% de votre solde annuel. Il vous reste encore de beaux moments de repos à planifier !</p>
          </div>
        </div>

        <div class="astuce-grid">
          <div class="infocard" style="--c:#F59E0B;">
            <span class="frame tr-h"></span><span class="frame tr-v"></span>
            <span class="frame bl-h"></span><span class="frame bl-v"></span>
            <div class="ic-inner">
              <span class="ico"><i data-lucide="sun" style="width:15px;height:15px;"></i></span>
              <div><b>Équilibre vie pro/perso</b><span>Fixez des limites claires entre travail et repos</span></div>
            </div>
          </div>
          <div class="infocard" style="--c:#3B82F6;">
            <span class="frame tr-h"></span><span class="frame tr-v"></span>
            <span class="frame bl-h"></span><span class="frame bl-v"></span>
            <div class="ic-inner">
              <span class="ico"><i data-lucide="brain" style="width:15px;height:15px;"></i></span>
              <div><b>Gérer le stress</b><span>Accordez-vous 10 minutes de pause chaque jour</span></div>
            </div>
          </div>
          <div class="infocard" style="--c:#8B5CF6;">
            <span class="frame tr-h"></span><span class="frame tr-v"></span>
            <span class="frame bl-h"></span><span class="frame bl-v"></span>
            <div class="ic-inner">
              <span class="ico"><i data-lucide="moon" style="width:15px;height:15px;"></i></span>
              <div><b>Mieux dormir</b><span>Évitez les écrans avant le coucher</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </main>
</div>

<script>
  lucide.createIcons();

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