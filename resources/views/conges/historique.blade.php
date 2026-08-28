<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Historique de mes demandes — NAJA7 HOST</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<style>
  :root{
    --blue:#3B82F6; --blue-2:#60A5FA;
    --orange:#F59E0B; --orange-2:#FBBF24; --green:#10B981; --red:#EF4444; --purple:#8B5CF6;
    --bg:#05070F; --panel:rgba(18,24,42,.55); --panel-2:rgba(255,255,255,.06);
    --border:rgba(255,255,255,.12);
    --text:#F1F4FA; --text-dim:#E3E8F5;
    --radius:22px; --glass-blur:22px;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  html, body{height:100%; overflow-x:hidden;}
  body{
    font-family:'Poppins',sans-serif; color:var(--text); -webkit-font-smoothing:antialiased;
    background:
      radial-gradient(900px 500px at 85% -10%, rgba(245,158,11,.10), transparent 60%),
      radial-gradient(700px 500px at -10% 30%, rgba(59,130,246,.08), transparent 60%),
      linear-gradient(180deg, rgba(4,6,14,.78), rgba(4,6,14,.92)), url('{{ asset('images/dashboard-bg.jpg') }}') center/cover no-repeat fixed;
  }
  a{text-decoration:none; color:inherit;}
  button{font-family:inherit; cursor:pointer; border:none; background:none; color:inherit;}
  select, input{font-family:inherit;}

  .app{display:flex; align-items:flex-start; min-height:100vh; padding:16px 24px; gap:16px; max-width:1500px; margin:0 auto; overflow-x:hidden;}

  .sidebar{width:64px; flex:none; align-self:flex-start; position:sticky; top:16px; z-index:100; background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:32px; padding:14px 0 16px; display:flex; flex-direction:column; align-items:center; box-shadow:0 8px 32px rgba(0,0,0,.35); max-height:94vh;}
  .side-logo{width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; margin-bottom:12px; font-weight:700; overflow:hidden; flex:none;}
  .side-logo img{width:100%; height:100%; object-fit:cover;}
  .side-nav{display:flex; flex-direction:column; gap:3px; flex:1;}
  .side-link{position:relative; width:36px; height:36px; border-radius:11px; display:flex; align-items:center; justify-content:center; color:var(--text-dim); flex:none; transition:background .15s, color .15s;}
  .side-link:hover{background:rgba(255,255,255,.08); color:#fff;}
  .side-link.active{background:var(--orange); color:#fff; box-shadow:0 0 0 4px rgba(245,158,11,.18), 0 0 18px rgba(245,158,11,.55); animation:sideGlow 2.4s ease-in-out infinite;}
  @keyframes sideGlow{
    0%,100%{ box-shadow:0 0 0 4px rgba(245,158,11,.18), 0 0 12px rgba(245,158,11,.4); }
    50%{ box-shadow:0 0 0 6px rgba(245,158,11,.14), 0 0 22px rgba(245,158,11,.7); }
  }
  .side-link .tip{position:absolute; left:48px; top:50%; transform:translateY(-50%); background:rgba(20,26,46,.92); backdrop-filter:blur(10px); padding:6px 12px; border-radius:8px; font-size:12px; white-space:nowrap; opacity:0; pointer-events:none; transition:opacity .15s; z-index:30; border:1px solid var(--border);}
  .side-link:hover .tip{opacity:1;}
  .side-link:focus .tip{opacity:1;}
  .side-bottom{display:flex; flex-direction:column; gap:4px; padding-top:8px; margin-top:6px; border-top:1px solid var(--border); align-items:center; flex:none;}

  .main{flex:1; align-self:stretch; padding:6px 6px 40px; max-width:100%; overflow-x:hidden; position:relative;}

  .header{display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:22px; flex-wrap:wrap; gap:14px;}
  .header-left h1{position:relative; font-size:19px; font-weight:800; color:#fff; display:inline-flex; align-items:center; line-height:1.4;
    padding:12px 26px; background:linear-gradient(180deg,#3D7BFF 0%,#1E4FC4 55%,#123591 100%); border-radius:999px; white-space:nowrap;
    box-shadow:0 6px 14px rgba(23,73,176,.5), inset 0 2px 0 rgba(255,255,255,.4), inset 0 -4px 8px rgba(0,0,0,.3);}
  .header-left p{color:var(--text-dim); font-size:13.5px; margin-top:10px; text-shadow:0 2px 10px rgba(0,0,0,.7), 0 1px 2px rgba(0,0,0,.9); max-width:520px;}
  .header-right{display:flex; align-items:center; gap:12px;}

  .icon-btn{position:relative; width:38px; height:38px; border-radius:12px; background:var(--panel); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; flex:none;}
  .icon-btn .dot{position:absolute; top:-3px; right:-3px; background:var(--red); color:#fff; font-size:9px; font-weight:700; width:16px; height:16px; border-radius:50%; display:flex; align-items:center; justify-content:center;}
  .avatar{width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; overflow:hidden; flex:none;}
  .avatar img{width:100%; height:100%; object-fit:cover; object-position:center top;}
  .user-chip{display:flex; align-items:center; gap:8px; cursor:pointer; position:relative;}
  .user-chip .txt{display:flex; flex-direction:column; line-height:1.15;}
  .user-chip b{font-size:13px; font-weight:600;}
  .user-chip span{font-size:11px; color:var(--text-dim);}

  .notif-panel{position:absolute; top:52px; right:96px; background:rgba(18,24,42,.85); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:10px; width:290px; box-shadow:0 12px 30px rgba(0,0,0,.4); display:none; z-index:80;}
  .notif-panel.open{display:block;}
  .notif-panel h4{font-size:12.5px; padding:6px 8px 10px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.03em;}
  .notif-item{display:flex; align-items:flex-start; gap:10px; padding:9px 8px; border-radius:11px; font-size:12.5px;}
  .notif-item:hover{background:rgba(255,255,255,.05);}
  .notif-item .n-ico{width:28px; height:28px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex:none;}
  .notif-empty{padding:14px 8px; font-size:12.5px; color:var(--text-dim); text-align:center;}

  .user-dropdown{position:absolute; top:52px; right:0; background:rgba(18,24,42,.92); backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:8px; width:200px; box-shadow:0 12px 30px rgba(0,0,0,.5); display:none; z-index:80;}
  .user-dropdown.open{display:block;}
  .user-dropdown a, .user-dropdown button{display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:11px; font-size:13px; width:100%; text-align:left; color:#fff;}
  .user-dropdown a:hover, .user-dropdown button:hover{background:rgba(255,255,255,.06);}

  /* ===== Barre de filtres compacte ===== */
  .toolbar{display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px;}
  .tabs{display:flex; align-items:center; gap:6px; background:var(--panel); border:1px solid var(--border); border-radius:14px; padding:5px;}
  .tab{padding:8px 16px; border-radius:10px; font-size:13px; font-weight:600; color:var(--text-dim); transition:background .15s,color .15s;}
  .tab:hover{color:#fff;}
  .tab.active{background:var(--orange); color:#fff;}
  .toolbar-right{display:flex; align-items:center; gap:10px;}
  .sort-select{background:#141b30; border:1px solid var(--border); color:#fff; font-size:12.5px; padding:9px 12px; border-radius:9px;}
  .view-toggle{display:flex; align-items:center; background:var(--panel); border:1px solid var(--border); border-radius:10px; overflow:hidden;}
  .view-toggle button{width:36px; height:36px; display:flex; align-items:center; justify-content:center; color:var(--text-dim); transition:background .15s,color .15s;}
  .view-toggle button.active{background:var(--orange); color:#fff;}

  .layout{display:grid; grid-template-columns:1fr 300px; gap:18px; align-items:start;}
  @media (max-width:1050px){ .layout{grid-template-columns:1fr;} }
  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25);}
  .panel-head h2{position:relative; font-size:13px; font-weight:800; color:#fff; display:inline-flex; align-items:center; gap:8px; line-height:1.4;
    padding:9px 18px; background:linear-gradient(180deg,#3D7BFF 0%,#1E4FC4 55%,#123591 100%); border-radius:999px; white-space:nowrap;
    box-shadow:0 6px 14px rgba(23,73,176,.5), inset 0 2px 0 rgba(255,255,255,.4), inset 0 -4px 8px rgba(0,0,0,.3);}

  /* ===== Timeline "Mon parcours de congés" ===== */
  .timeline-panel{padding:20px 8px 4px;}
  .timeline-title{display:flex; align-items:center; justify-content:space-between; padding:0 22px 14px;}
  .timeline-title h2{position:relative; font-size:13px; font-weight:800; color:#fff; display:inline-flex; align-items:center; gap:8px; line-height:1.4;
    padding:9px 18px; background:linear-gradient(180deg,#3D7BFF 0%,#1E4FC4 55%,#123591 100%); border-radius:999px; white-space:nowrap;
    box-shadow:0 6px 14px rgba(23,73,176,.5), inset 0 2px 0 rgba(255,255,255,.4), inset 0 -4px 8px rgba(0,0,0,.3);}
  .timeline-title span{font-size:11.5px; color:var(--text-dim); font-weight:700;}

  .timeline-scroll{overflow-x:auto; padding:10px 4px 4px;}
  .timeline-track{position:relative; display:flex; gap:50px; padding:0 30px; min-width:max-content; height:500px;
    background-image: radial-gradient(rgba(255,255,255,.05) 1px, transparent 1px);
    background-size: 22px 22px;}
  .t-item{position:relative; width:230px; flex:none; height:500px; z-index:1; opacity:0; transform:translateY(14px); animation:tFadeIn .5s ease forwards;}
  @keyframes tFadeIn{ to{ opacity:1; transform:translateY(0); } }
  .t-card{background:var(--panel-2); border:1px solid var(--border); border-radius:16px; padding:16px; position:absolute; left:0; right:0; height:150px; overflow:hidden; cursor:pointer; z-index:3; transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;}
  .t-card:hover{transform:translateY(-4px) scale(1.03); border-color:rgba(255,255,255,.28); box-shadow:0 14px 30px rgba(0,0,0,.4), 0 0 0 1px rgba(255,255,255,.05);}
  .t-top .t-card{top:0;}
  .t-bottom .t-card{top:342px;}
  .t-card b{font-size:15.5px; font-weight:700; display:block; margin-bottom:4px;}
  .t-ico{display:inline-flex; align-items:center; justify-content:center; width:26px; height:26px; border-radius:8px; margin-right:6px; vertical-align:-7px;}
  .t-card .t-sub{font-size:12.5px; color:var(--text-dim); font-weight:600; margin-bottom:10px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;}
  .t-badge{display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:20px; font-size:12px; font-weight:600;}
  .badge-approved{background:rgba(16,185,129,.15); color:var(--green);}
  .badge-approved-purple{background:rgba(139,92,246,.16); color:var(--purple);}
  .badge-pending{background:rgba(245,158,11,.15); color:var(--orange);}
  .badge-rejected{background:rgba(239,68,68,.15); color:var(--red);}
  .t-card .t-req{font-size:11.5px; color:var(--text-dim); font-weight:700; margin-top:10px;}
  .t-connector{position:absolute; left:50%; width:2px; transform:translateX(-1px); background-image:linear-gradient(rgba(255,255,255,.35) 50%, transparent 0%); background-size:2px 8px; z-index:1;}
  .t-top .t-connector{top:150px; height:40px;}
  .t-bottom .t-connector{top:318px; height:24px;}
  .t-dot{position:absolute; left:50%; transform:translate(-50%,-50%); width:58px; height:58px; border-radius:50%; display:flex; flex-direction:column; align-items:center; justify-content:center; border:3px solid rgba(5,7,15,.9); cursor:pointer; z-index:3; transition:box-shadow .18s ease, transform .18s ease;}
  .t-top .t-dot{top:190px;}
  .t-bottom .t-dot{top:290px;}
  .t-dot .d-num{font-size:14.5px; font-weight:800; color:#fff; line-height:1.1;}
  .t-dot .d-month{font-size:8px; font-weight:700; color:#fff; text-transform:uppercase; letter-spacing:.03em; line-height:1.2;}
  .t-dot .d-year{font-size:6.5px; font-weight:600; color:rgba(255,255,255,.75); line-height:1.2;}
  .t-item:hover .t-dot{transform:translate(-50%,-50%) scale(1.12); box-shadow:0 0 0 6px rgba(255,255,255,.06), 0 0 24px var(--dc);}
  .dot-approuve{background:var(--green); --dc:rgba(16,185,129,.7);}
  .dot-attente{background:var(--orange); --dc:rgba(245,158,11,.7);}
  .dot-refuse{background:var(--red); --dc:rgba(239,68,68,.7);}
  .dot-important{background:var(--purple); --dc:rgba(139,92,246,.7);}
  /* ligne en zigzag pointillé reliant chaque point au suivant */
  .t-item:not(:last-child) .t-dot::after{
    content:''; position:absolute; left:100%; top:50%; width:298px; height:2px; z-index:0;
    background-image:repeating-linear-gradient(90deg, rgba(255,255,255,.32) 0 6px, transparent 6px 14px);
    transform-origin:left center;
  }
  .t-top .t-dot::after{ transform:translateY(-1px) rotate(19.65deg); }
  .t-bottom .t-dot::after{ transform:translateY(-1px) rotate(-19.65deg); }

  .timeline-empty{text-align:center; padding:60px 0; color:var(--text-dim);}
  .timeline-empty .ico{width:46px; height:46px; border-radius:50%; background:rgba(255,255,255,.06); display:flex; align-items:center; justify-content:center; margin:0 auto 12px;}

  .voir-plus-wrap{text-align:center; padding:18px 0 22px;}
  .btn-voir-plus{display:inline-flex; align-items:center; gap:6px; background:var(--orange); border:1px solid var(--orange); color:#fff; font-size:12.5px; font-weight:700; padding:11px 22px; border-radius:12px; transition:filter .15s, transform .15s; box-shadow:0 8px 20px rgba(245,158,11,.25);}
  .btn-voir-plus:hover{filter:brightness(1.1); transform:translateY(-1px);}
  .t-item.t-hidden{display:none;}

  /* ===== Colonne droite : widgets ===== */
  .side-card{padding:18px 20px;}
  .side-card .panel-head{margin-bottom:14px;}

  .ring-wrap{display:flex; align-items:center; gap:12px; position:relative;}
  .ring{width:96px; height:96px; border-radius:50%; display:flex; align-items:center; justify-content:center; position:relative; flex:none;}
  .ring::before{content:''; position:absolute; inset:11px; border-radius:50%; background:#0c1120;}
  .ring-txt{position:relative; z-index:1; text-align:center;}
  .ring-txt b{font-size:22px; font-weight:800; color:#fff; display:block; line-height:1.1;}
  .ring-txt span{font-size:10px; color:var(--text-dim); font-weight:700;}
  .ring-legend{font-size:12.5px; color:var(--text-dim); font-weight:600; line-height:1.6; flex:1;}
  .ring-legend b{color:#fff;}
  .ring-deco{margin-top:12px; display:flex; align-items:center; gap:8px; padding:9px 12px; background:rgba(245,158,11,.08); border:1px solid rgba(245,158,11,.18); border-radius:12px; font-size:11.5px; color:var(--text-dim);}
  .ring-deco i{color:var(--orange); flex:none;}
  .ring-illustration{width:76px; height:auto; flex:none; filter:drop-shadow(0 6px 14px rgba(0,0,0,.4));}

  .donut-wrap{display:flex; align-items:center; gap:14px;}
  .donut{width:88px; height:88px; border-radius:50%; position:relative; flex:none;}
  .donut::before{content:''; position:absolute; inset:22px; border-radius:50%; background:#0c1120;}
  .donut-legend{flex:1; display:flex; flex-direction:column; gap:6px;}
  .donut-legend .row{display:flex; align-items:center; justify-content:space-between; font-size:11.5px; color:var(--text-dim); font-weight:600;}
  .donut-legend .row .lbl{display:flex; align-items:center; gap:6px;}
  .donut-legend .dot{width:7px; height:7px; border-radius:50%; flex:none;}
  .donut-legend .row b{color:#fff; font-weight:700;}

  .statut-mini{display:flex; align-items:center; justify-content:space-between; gap:8px;}
  .statut-pill{flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; padding:12px 6px; border-radius:14px; background:var(--panel-2); border:1px solid var(--border);}
  .statut-pill .pt-dot{width:10px; height:10px; border-radius:50%;}
  .statut-pill b{font-size:18px; font-weight:800; color:#fff;}
  .statut-pill span{font-size:10px; color:var(--text-dim); font-weight:700; text-align:center;}

  .mini-chart-row{display:flex; gap:8px; margin-top:14px;}
  .mini-axis{display:flex; flex-direction:column; justify-content:space-between; align-items:flex-end; height:70px; width:16px; font-size:9px; font-weight:600; color:var(--text-dim); flex:none;}
  .mini-chart{flex:1; display:flex; align-items:flex-end; gap:2px; height:70px; position:relative;
    background-image:linear-gradient(to top, rgba(255,255,255,.12) 1px, transparent 1px);
    background-size:100% 50%; background-repeat:repeat-y; background-position:bottom;}
  .mini-chart .bar-wrap{flex:1; display:flex; flex-direction:column; align-items:center; gap:5px; height:100%; justify-content:flex-end; position:relative; z-index:1;}
  .mini-chart .bar-value{position:absolute; top:-15px; font-size:9.5px; font-weight:700; color:#fff;}
  .mini-chart .bar-wrap.is-empty .bar-value{color:var(--text-dim); font-weight:600;}
  .mini-chart .bar{width:100%; max-width:16px; border-radius:4px 4px 2px 2px; background:var(--blue-2); opacity:.85; transform:scaleY(0); transform-origin:bottom; animation:barGrow .6s ease forwards;}
  .mini-chart .bar.empty{background:rgba(255,255,255,.08);}
  .mini-labels{display:flex; gap:2px; padding-left:24px; margin-top:4px;}
  .mini-labels span{flex:1; text-align:center; font-size:9px; color:var(--text-dim); font-weight:700; white-space:nowrap;}
  @keyframes barGrow{ to{ transform:scaleY(1); } }
  .mini-chart .m-lbl{font-size:8.5px; color:var(--text-dim);}

  .cta-card{background:linear-gradient(135deg, rgba(245,158,11,.16), rgba(18,24,42,.4)); border:1px solid rgba(245,158,11,.25); padding:18px 20px;}
  .cta-card b{display:block; font-size:15px; font-weight:700; color:#fff; margin-bottom:4px;}
  .cta-card p{font-size:12.5px; color:var(--text-dim); font-weight:600; line-height:1.5; margin-bottom:14px;}
  .btn-nouvelle{display:inline-flex; align-items:center; gap:6px; background:var(--orange); color:#fff; font-size:12.5px; font-weight:700; padding:10px 16px; border-radius:10px;}
  .btn-nouvelle:hover{filter:brightness(1.1);}

  /* ===== Drawer de détail ===== */
  .drawer-overlay{position:fixed; inset:0; background:rgba(2,4,10,.6); backdrop-filter:blur(3px); z-index:200; opacity:0; pointer-events:none; transition:opacity .2s ease;}
  .drawer-overlay.open{opacity:1; pointer-events:auto;}
  .drawer{position:fixed; top:0; right:0; height:100vh; width:380px; max-width:92vw; background:rgba(14,19,36,.98); border-left:1px solid var(--border); box-shadow:-16px 0 40px rgba(0,0,0,.5); z-index:201; padding:26px 24px; transform:translateX(100%); transition:transform .25s ease; overflow-y:auto;}
  .drawer.open{transform:translateX(0);}
  .drawer-close{position:absolute; top:20px; right:20px; width:32px; height:32px; border-radius:10px; background:var(--panel-2); display:flex; align-items:center; justify-content:center; color:var(--text-dim);}
  .drawer-close:hover{color:#fff;}
  .drawer-ico{width:52px; height:52px; border-radius:16px; display:flex; align-items:center; justify-content:center; margin-bottom:16px; background:var(--orange);}
  .drawer h3{font-size:19px; font-weight:800; color:#fff; margin-bottom:4px;}
  .drawer .d-sub{font-size:13px; color:var(--text-dim); font-weight:600; margin-bottom:14px;}
  .drawer .d-row{display:flex; align-items:center; gap:10px; padding:11px 0; border-top:1px solid var(--border); font-size:13px;}
  .drawer .d-row i{color:var(--text-dim); flex:none;}
  .drawer .d-row b{color:#fff; margin-left:auto; font-weight:600; text-align:right;}

  .drawer-comments{margin-top:16px; padding-top:14px; border-top:1px solid var(--border);}
  .drawer-comments h4{font-size:12px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.03em; margin-bottom:10px;}
  .drawer-comment{display:flex; gap:8px; margin-bottom:10px;}
  .drawer-comment .c-ico{width:26px; height:26px; border-radius:50%; background:rgba(59,130,246,.15); color:var(--blue-2); display:flex; align-items:center; justify-content:center; flex:none;}
  .drawer-comment .c-body{background:rgba(255,255,255,.04); border-radius:10px; padding:8px 10px; flex:1;}
  .drawer-comment .c-top{display:flex; align-items:center; justify-content:space-between; margin-bottom:2px;}
  .drawer-comment b{font-size:11.5px; color:#fff;}
  .drawer-comment .c-time{font-size:10px; color:var(--text-dim);}
  .drawer-comment p{font-size:12px; color:var(--text-dim); line-height:1.4; margin:0;}
  .drawer-comments-empty{font-size:12px; color:var(--text-dim);}

  @media (max-width:800px){
    .sidebar{display:none;}
  }
  @media (max-width:760px){
    .timeline-track{flex-direction:column; height:auto; gap:0; padding:0 8px 8px; min-width:0; background:none;}
    .timeline-track::before{content:''; position:absolute; top:0; bottom:0; left:29px; width:2px; background:repeating-linear-gradient(180deg, rgba(255,255,255,.22) 0 8px, transparent 8px 16px); z-index:0;}
    .t-item{width:100%; height:auto; padding-left:64px; margin-bottom:22px;}
    .t-top .t-dot, .t-bottom .t-dot{top:0; left:29px; transform:translate(-50%,0); width:46px; height:46px;}
    .t-item:hover .t-dot{transform:translate(-50%,0) scale(1.1);}
    .t-dot::after{display:none;}
    .t-connector{display:none;}
    .t-top .t-card, .t-bottom .t-card{position:static; height:auto; margin-top:4px;}
  }

  /* ===== Bascule manuelle en timeline verticale (bouton de la barre d'outils) ===== */
  .timeline-panel.force-vertical .timeline-scroll{overflow-x:visible;}
  .timeline-panel.force-vertical .timeline-track{flex-direction:column; height:auto; gap:0; padding:10px 20px 10px 40px; min-width:0; background:none; position:relative;}
  .timeline-panel.force-vertical .timeline-track::before{content:''; position:absolute; top:0; bottom:0; left:29px; width:2px; background:repeating-linear-gradient(180deg, rgba(255,255,255,.28) 0 8px, transparent 8px 16px); z-index:0;}
  .timeline-panel.force-vertical .t-item{width:100%; height:auto; padding-left:44px; margin-bottom:24px;}
  .timeline-panel.force-vertical .t-top .t-dot, .timeline-panel.force-vertical .t-bottom .t-dot{position:absolute; top:0; left:29px; transform:translate(-50%,0); width:48px; height:48px;}
  .timeline-panel.force-vertical .t-item:hover .t-dot{transform:translate(-50%,0) scale(1.1);}
  .timeline-panel.force-vertical .t-dot::after{display:none;}
  .timeline-panel.force-vertical .t-connector{display:none;}
  .timeline-panel.force-vertical .t-top .t-card, .timeline-panel.force-vertical .t-bottom .t-card{position:static; height:auto; margin-top:4px;}
</style>
</head>
<body>

<div class="app">

  @include('partials.sidebar')

  <main class="main">

    <div class="header">
      <div class="header-left">
        <h1>Historique de mes demandes</h1>
        <p>Trace, suis et revis toutes tes demandes de congés.</p>
      </div>
      <div class="header-right">
        @include('partials.notifications')

        <div class="user-chip" id="userChip">
          <div class="avatar">
            @if (auth()->user()->photo_path)
              <img src="{{ asset('storage/'.auth()->user()->photo_path) }}" alt="">
            @else
              {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            @endif
          </div>
          <div class="txt">
            <b>{{ auth()->user()->name }}</b>
            <span>Employé</span>
          </div>
          <div class="user-dropdown" id="userDropdown">
            <a href="{{ route('profile.edit') }}"><i data-lucide="user" style="width:15px;height:15px;"></i> Mon profil</a>
            <a href="{{ route('settings.index') }}"><i data-lucide="settings" style="width:15px;height:15px;"></i> Paramètres</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit"><i data-lucide="log-out" style="width:15px;height:15px;"></i> Déconnexion</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="toolbar">
      <div class="tabs">
        <a href="{{ route('conges.historique') }}" class="tab {{ !$statut ? 'active' : '' }}">Toutes</a>
        <a href="{{ route('conges.historique', ['statut' => 'approuve']) }}" class="tab {{ $statut === 'approuve' ? 'active' : '' }}">Approuvées</a>
        <a href="{{ route('conges.historique', ['statut' => 'en_attente']) }}" class="tab {{ $statut === 'en_attente' ? 'active' : '' }}">En attente</a>
        <a href="{{ route('conges.historique', ['statut' => 'refuse']) }}" class="tab {{ $statut === 'refuse' ? 'active' : '' }}">Refusées</a>
      </div>
      <div class="toolbar-right">
        <select class="sort-select" id="triSelect">
          <option value="recent">Plus récent</option>
          <option value="ancien">Plus ancien</option>
        </select>
        <div class="view-toggle">
          <button class="active" id="viewHorizontal" title="Timeline horizontale"><i data-lucide="git-commit-horizontal" style="width:15px;height:15px;"></i></button>
          <button id="viewVertical" title="Timeline verticale"><i data-lucide="list" style="width:15px;height:15px;"></i></button>
        </div>
      </div>
    </div>

    <div class="layout">

      <div class="panel timeline-panel" id="timelinePanel">
        <div class="timeline-title">
          <h2>Mon parcours de congés</h2>
          <span>{{ $demandes->count() }} demande(s)</span>
        </div>

        @php
          $libelles = ['paye' => 'Congé annuel', 'maladie' => 'Congé maladie', 'sans_solde' => 'Congé sans solde', 'exceptionnel' => 'Congé exceptionnel', 'rtt' => 'RTT / Récupération', 'autre' => 'Autre congé'];
          $tags = ['paye' => 'Vacances', 'maladie' => 'Maladie', 'sans_solde' => 'Sans solde', 'exceptionnel' => 'Événement familial', 'rtt' => 'RTT', 'autre' => 'Personnel'];
          $icones = ['paye' => 'palmtree', 'maladie' => 'stethoscope', 'sans_solde' => 'ban', 'exceptionnel' => 'star', 'rtt' => 'refresh-ccw', 'autre' => 'user'];
          $couleursIco = ['paye' => 'var(--orange)', 'maladie' => 'var(--red)', 'sans_solde' => '#9CA3AF', 'exceptionnel' => 'var(--purple)', 'rtt' => 'var(--blue-2)', 'autre' => 'var(--blue)'];
          $labelStatut = ['approuve' => 'Approuvée', 'en_attente' => 'En attente', 'refuse' => 'Refusée'];
          $moisAbr = [1=>'JANV',2=>'FÉVR',3=>'MARS',4=>'AVR',5=>'MAI',6=>'JUIN',7=>'JUIL',8=>'AOÛT',9=>'SEPT',10=>'OCT',11=>'NOV',12=>'DÉC'];
          $moisCourt = [1=>'Jan',2=>'Fév',3=>'Mar',4=>'Avr',5=>'Mai',6=>'Juin',7=>'Juil',8=>'Août',9=>'Sept',10=>'Oct',11=>'Nov',12=>'Déc'];
          $seuilAffiche = 6;
        @endphp

        @if ($demandes->count())
          <div class="timeline-scroll">
            <div class="timeline-track" id="timelineTrack" data-seuil="{{ $seuilAffiche }}">
              @foreach ($demandes as $i => $demande)
                @php
                  // Couleur pilotée par le statut ; le congé annuel approuvé se distingue en violet,
                  // mais un refus reste toujours rouge (priorité à la lisibilité du refus).
                  if ($demande->statut === 'refuse') {
                      $dotClass = 'dot-refuse'; $badgeClass = 'badge-rejected';
                  } elseif ($demande->statut === 'en_attente') {
                      $dotClass = 'dot-attente'; $badgeClass = 'badge-pending';
                  } elseif ($demande->type === 'paye') {
                      $dotClass = 'dot-important'; $badgeClass = 'badge-approved-purple';
                  } else {
                      $dotClass = 'dot-approuve'; $badgeClass = 'badge-approved';
                  }

                  $commentairesJson = $demande->comments->where('visibilite', 'employe')->map(function ($c) {
                      return [
                          'auteur' => $c->user->name ?? 'RH',
                          'message' => $c->message,
                          'temps' => $c->created_at->diffForHumans(),
                      ];
                  })->values()->toJson();
                @endphp
                <div class="t-item {{ $i % 2 === 0 ? 't-top' : 't-bottom' }} {{ $i >= $seuilAffiche ? 't-hidden' : '' }}"
                     style="animation-delay: {{ min($i, $seuilAffiche) * 0.06 }}s;"
                     data-nom="{{ $libelles[$demande->type] ?? $demande->type }}"
                     data-motif="{{ $demande->motif ?: '—' }}"
                     data-statut="{{ $labelStatut[$demande->statut] ?? $demande->statut }}"
                     data-statut-classe="{{ $badgeClass }}"
                     data-debut="{{ $demande->date_debut->format('d M Y') }}"
                     data-fin="{{ $demande->date_fin->format('d M Y') }}"
                     data-jours="{{ $demande->jours }}"
                     data-demande="{{ $demande->created_at->format('d M Y') }}"
                     data-timestamp="{{ $demande->date_debut->timestamp }}"
                     data-comments="{{ $commentairesJson }}">
                  <div class="t-card" onclick="ouvrirDrawer(this.parentElement)">
                    <b><span class="t-ico" style="background:{{ $couleursIco[$demande->type] ?? 'var(--orange)' }};"><i data-lucide="{{ $icones[$demande->type] ?? 'file-text' }}" style="width:14px;height:14px; color:#fff;"></i></span>{{ $libelles[$demande->type] ?? $demande->type }}</b>
                    <div class="t-sub">{{ $demande->motif ?: ($tags[$demande->type] ?? '') }}</div>
                    <span class="t-badge {{ $badgeClass }}">{{ $labelStatut[$demande->statut] ?? $demande->statut }}</span>
                    <div class="t-req">Demandé le {{ $demande->created_at->format('d M Y') }}</div>
                  </div>
                  <div class="t-connector"></div>
                  <div class="t-dot {{ $dotClass }}" onclick="ouvrirDrawer(this.parentElement)">
                    <span class="d-num">{{ $demande->date_debut->format('d') }}</span>
                    <span class="d-month">{{ $moisAbr[(int) $demande->date_debut->format('n')] }}</span>
                    <span class="d-year">{{ $demande->date_debut->format('Y') }}</span>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          @if ($demandes->count() > $seuilAffiche)
            <div class="voir-plus-wrap">
              <button class="btn-voir-plus" id="btnVoirPlus"><i data-lucide="chevron-down" style="width:14px;height:14px;"></i> Voir toutes mes demandes</button>
            </div>
          @endif
        @else
          <div class="timeline-empty">
            <div class="ico"><i data-lucide="inbox" style="width:22px;height:22px;"></i></div>
            <p style="font-size:15px; font-weight:600; color:#fff; margin-bottom:4px;">Aucune demande pour l'instant</p>
            <p style="font-size:13px;">Crée ta première demande de congé.</p>
          </div>
        @endif
      </div>

      <div style="display:flex; flex-direction:column; gap:16px;">

        <div class="panel side-card">
          <div class="panel-head"><h2>Mon solde de congés</h2></div>
          <div class="ring-wrap">
            <div class="ring" style="background:conic-gradient(var(--orange) {{ $soldeUtilisePct }}%, rgba(255,255,255,.08) 0);">
              <div class="ring-txt"><b>{{ $soldeRestant }}</b><span>jours restants</span></div>
            </div>
            <div class="ring-legend">Sur <b>{{ $soldeMax }}</b> jours/an<br>{{ $soldeUtilisePct }}% utilisés</div>
            <img src="{{ asset('images/conges-illustration.png') }}" alt="" class="ring-illustration">
          </div>
        </div>

        <div class="panel side-card">
          <div class="panel-head"><h2>Répartition par type</h2></div>
          @if ($repartitionParType->sum())
            @php
              $couleursType = ['paye' => 'var(--blue)', 'maladie' => 'var(--red)', 'sans_solde' => '#9CA3AF', 'exceptionnel' => 'var(--purple)', 'rtt' => 'var(--blue-2)', 'autre' => 'var(--orange)'];
              $cursor = 0; $segments = [];
              foreach ($repartitionParType as $type => $count) {
                  $pct = round(($count / $repartitionParType->sum()) * 100);
                  $segments[] = ['color' => $couleursType[$type] ?? 'var(--blue)', 'from' => $cursor, 'to' => $cursor + $pct, 'label' => $libelles[$type] ?? $type, 'count' => $count, 'pct' => $pct];
                  $cursor += $pct;
              }
            @endphp
            <div class="donut-wrap">
              <div class="donut" style="background:conic-gradient({{ implode(', ', array_map(fn($s) => "{$s['color']} {$s['from']}% {$s['to']}%", $segments)) }});"></div>
              <div class="donut-legend">
                @foreach ($segments as $s)
                  <div class="row">
                    <span class="lbl"><span class="dot" style="background:{{ $s['color'] }};"></span>{{ $s['label'] }}</span>
                    <b>{{ $s['count'] }} ({{ $s['pct'] }}%)</b>
                  </div>
                @endforeach
              </div>
            </div>
          @else
            <p style="font-size:12.5px; color:var(--text-dim); font-weight:600;">Pas encore de demande à répartir.</p>
          @endif
        </div>

        <div class="panel side-card">
          <div class="panel-head"><h2>Activité {{ $anneeActuelle }}</h2></div>
          @php $maxMois = max($activiteMensuelle->max(), 1); @endphp
          <div class="mini-chart-row">
            <div class="mini-axis">
              <span>{{ $maxMois }}</span>
              <span>{{ $maxMois > 2 ? round($maxMois / 2) : '' }}</span>
              <span>0</span>
            </div>
            <div class="mini-chart">
              @foreach ($activiteMensuelle as $mois => $count)
                <div class="bar-wrap {{ $count === 0 ? 'is-empty' : '' }}">
                  <span class="bar-value">{{ $count > 0 ? $count : '' }}</span>
                  <div class="bar {{ $count === 0 ? 'empty' : '' }}" style="height:{{ $count > 0 ? max(round(($count / $maxMois) * 100), 12) : 6 }}%; animation-delay:{{ $mois * 0.04 }}s;" title="{{ $count }} demande(s)"></div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="mini-labels">
            @foreach ($activiteMensuelle as $mois => $count)
              <span>{{ $moisCourt[$mois] }}</span>
            @endforeach
          </div>
        </div>


        <div class="panel cta-card">
          <b>Besoin d'un congé ?</b>
          <p>Crée une nouvelle demande en quelques clics seulement.</p>
          <a href="{{ route('conges.create') }}" class="btn-nouvelle"><i data-lucide="plus" style="width:14px;height:14px;"></i> Nouvelle demande</a>
        </div>

      </div>
    </div>

  </main>
</div>

<div class="drawer-overlay" id="drawerOverlay" onclick="fermerDrawer()"></div>
<div class="drawer" id="drawer">
  <button class="drawer-close" onclick="fermerDrawer()"><i data-lucide="x" style="width:16px;height:16px;"></i></button>
  <div class="drawer-ico" id="drawerIco"><i data-lucide="calendar" style="width:24px;height:24px; color:#fff;"></i></div>
  <h3 id="drawerTitre">—</h3>
  <div class="d-sub" id="drawerMotif">—</div>
  <span class="t-badge" id="drawerStatut">—</span>
  <div class="d-row"><i data-lucide="calendar-range" style="width:15px;height:15px;"></i> Période <b id="drawerPeriode">—</b></div>
  <div class="d-row"><i data-lucide="clock" style="width:15px;height:15px;"></i> Durée <b id="drawerDuree">—</b></div>
  <div class="d-row"><i data-lucide="send" style="width:15px;height:15px;"></i> Demandé le <b id="drawerDemande">—</b></div>

  <div class="drawer-comments">
    <h4>Commentaires du RH</h4>
    <div id="drawerCommentsList"></div>
  </div>
</div>

<script>
  lucide.createIcons();

  document.querySelectorAll('.sidebar a[href="#"], .user-dropdown a[href="#"]').forEach(lien => {
    lien.addEventListener('click', (e) => e.preventDefault());
  });

  const notifBtn = document.getElementById('notifBtn');
  const notifPanel = document.getElementById('notifPanel');
  const userChip = document.getElementById('userChip');
  const userDropdown = document.getElementById('userDropdown');

  notifBtn.addEventListener('click', (e) => { e.stopPropagation(); notifPanel.classList.toggle('open'); userDropdown.classList.remove('open'); });
  userChip.addEventListener('click', (e) => { e.stopPropagation(); userDropdown.classList.toggle('open'); notifPanel.classList.remove('open'); });
  document.addEventListener('click', () => { notifPanel.classList.remove('open'); userDropdown.classList.remove('open'); });
  notifPanel.addEventListener('click', (e) => e.stopPropagation());
  userDropdown.addEventListener('click', (e) => e.stopPropagation());

  // ===== Voir toutes mes demandes =====
  const btnVoirPlus = document.getElementById('btnVoirPlus');
  let toutesReveleees = false;
  if (btnVoirPlus) {
    btnVoirPlus.addEventListener('click', () => {
      document.querySelectorAll('.t-hidden').forEach(el => el.classList.remove('t-hidden'));
      btnVoirPlus.parentElement.style.display = 'none';
      toutesReveleees = true;
    });
  }

  // ===== Tri (Plus récent / Plus ancien) =====
  const triSelect = document.getElementById('triSelect');
  const timelineTrack = document.getElementById('timelineTrack');
  if (triSelect && timelineTrack) {
    const seuilAffiche = parseInt(timelineTrack.dataset.seuil || '6', 10);

    triSelect.addEventListener('change', () => {
      const items = Array.from(timelineTrack.querySelectorAll('.t-item'));

      items.sort((a, b) => {
        const ta = parseInt(a.dataset.timestamp, 10);
        const tb = parseInt(b.dataset.timestamp, 10);
        return triSelect.value === 'ancien' ? ta - tb : tb - ta;
      });

      items.forEach((item, i) => {
        item.classList.remove('t-top', 't-bottom');
        item.classList.add(i % 2 === 0 ? 't-top' : 't-bottom');

        if (!toutesReveleees) {
          item.classList.toggle('t-hidden', i >= seuilAffiche);
        }

        timelineTrack.appendChild(item);
      });
    });
  }

  // ===== Toggle horizontal / vertical =====
  const viewHorizontal = document.getElementById('viewHorizontal');
  const viewVertical = document.getElementById('viewVertical');
  const timelinePanel = document.getElementById('timelinePanel');
  if (viewHorizontal && viewVertical) {
    viewHorizontal.addEventListener('click', () => {
      timelinePanel.classList.remove('force-vertical');
      viewHorizontal.classList.add('active');
      viewVertical.classList.remove('active');
    });
    viewVertical.addEventListener('click', () => {
      timelinePanel.classList.add('force-vertical');
      viewVertical.classList.add('active');
      viewHorizontal.classList.remove('active');
    });
  }

  // ===== Drawer de détail =====
  const drawer = document.getElementById('drawer');
  const drawerOverlay = document.getElementById('drawerOverlay');

  function ouvrirDrawer(item) {
    document.getElementById('drawerTitre').textContent = item.dataset.nom;
    document.getElementById('drawerMotif').textContent = item.dataset.motif;
    const statutEl = document.getElementById('drawerStatut');
    statutEl.textContent = item.dataset.statut;
    statutEl.className = 't-badge ' + item.dataset.statutClasse;
    document.getElementById('drawerPeriode').textContent = item.dataset.debut + ' – ' + item.dataset.fin;
    document.getElementById('drawerDuree').textContent = item.dataset.jours + ' jour(s)';
    document.getElementById('drawerDemande').textContent = item.dataset.demande;

    const commentsList = document.getElementById('drawerCommentsList');
    commentsList.innerHTML = '';
    let commentaires = [];
    try { commentaires = JSON.parse(item.dataset.comments || '[]'); } catch (e) { commentaires = []; }

    if (commentaires.length === 0) {
      commentsList.innerHTML = '<p class="drawer-comments-empty">Aucun commentaire pour l&#39;instant.</p>';
    } else {
      commentaires.forEach(c => {
        const div = document.createElement('div');
        div.className = 'drawer-comment';
        div.innerHTML = `
          <span class="c-ico"><i data-lucide="message-circle" style="width:13px;height:13px;"></i></span>
          <div class="c-body">
            <div class="c-top"><b></b><span class="c-time"></span></div>
            <p></p>
          </div>`;
        div.querySelector('b').textContent = c.auteur;
        div.querySelector('.c-time').textContent = c.temps;
        div.querySelector('p').textContent = c.message;
        commentsList.appendChild(div);
      });
      lucide.createIcons();
    }

    drawer.classList.add('open');
    drawerOverlay.classList.add('open');
  }

  function fermerDrawer() {
    drawer.classList.remove('open');
    drawerOverlay.classList.remove('open');
  }
</script>
</body>
</html>