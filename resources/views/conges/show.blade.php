<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Détail de la demande — NAJA7 HOST</title>
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
  select, input, textarea{font-family:inherit;}

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
  .side-link:focus .tip{opacity:1;}
  .side-bottom{display:flex; flex-direction:column; gap:4px; padding-top:8px; margin-top:6px; border-top:1px solid var(--border); align-items:center; flex:none;}

  .main{flex:1; align-self:stretch; padding:6px 6px 40px; max-width:100%; overflow-x:hidden;}

  .back-link{
    display:inline-flex; align-items:center; gap:7px; font-size:13px; font-weight:700; color:#fff;
    margin-bottom:14px; padding:9px 18px; border-radius:11px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);
  }
  .back-link:hover{filter:brightness(1.1);}

  .header{display:flex; align-items:center; justify-content:space-between; margin-bottom:22px; flex-wrap:wrap; gap:14px;}
  .header-left h1{font-size:24px; font-weight:700; text-shadow:0 2px 12px rgba(0,0,0,.5);}
  .header-left p{color:var(--text-dim); font-size:13.5px; margin-top:4px; text-shadow:0 2px 8px rgba(0,0,0,.5); max-width:520px;}
  .header-right{display:flex; align-items:center; gap:12px; position:relative;}
  .icon-btn{position:relative; width:38px; height:38px; border-radius:12px; background:var(--panel); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; flex:none;}
  .icon-btn .dot{position:absolute; top:-3px; right:-3px; background:var(--red); color:#fff; font-size:9px; font-weight:700; width:16px; height:16px; border-radius:50%; display:flex; align-items:center; justify-content:center;}
  .avatar{width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; overflow:hidden; flex:none;}
  .avatar img{width:100%; height:100%; object-fit:cover; object-position:center top;}
  .user-mini p{font-size:13px; font-weight:600;}
  .user-mini span{font-size:11px; color:var(--text-dim);}
  .user-mini-wrap{display:flex; align-items:center; gap:9px;}

  .notif-panel{position:absolute; top:52px; right:0; background:rgba(18,24,42,.85); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:16px; padding:10px; width:290px; box-shadow:0 12px 30px rgba(0,0,0,.4); display:none; z-index:80;}
  .notif-panel.open{display:block;}
  .notif-panel h4{font-size:12.5px; padding:6px 8px 10px; color:var(--text-dim); text-transform:uppercase; letter-spacing:.03em;}
  .notif-item{display:flex; align-items:flex-start; gap:10px; padding:9px 8px; border-radius:11px; font-size:12.5px;}
  .notif-item:hover{background:rgba(255,255,255,.05);}
  .notif-item .n-ico{width:28px; height:28px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex:none; background:rgba(59,130,246,.15); color:var(--blue-2);}
  .notif-empty{padding:14px 8px; font-size:12.5px; color:var(--text-dim); text-align:center;}

  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25);}
  .panel-pad{padding:20px;}

  .card-head{display:flex; align-items:center; justify-content:space-between; margin-bottom:16px;}
  .card-head h2{position:relative; font-size:13px; font-weight:800; color:#fff; display:inline-flex; align-items:center; gap:8px;
    padding:10px 22px; background:linear-gradient(180deg,#3D7BFF 0%,#1E4FC4 55%,#123591 100%); border-radius:999px;
    box-shadow:0 6px 14px rgba(23,73,176,.5), inset 0 2px 0 rgba(255,255,255,.4), inset 0 -4px 8px rgba(0,0,0,.3);}
  .card-head a{font-size:11.5px; font-weight:700; color:#fff; display:inline-flex; align-items:center; gap:6px; padding:7px 15px; border-radius:999px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}

  .autres-scroll{display:flex; gap:12px; overflow-x:auto; padding-bottom:4px;}
  .autre-card{flex:none; width:190px; background:var(--panel-2); border-radius:16px; padding:14px; display:flex; flex-direction:column; align-items:center; text-align:center; gap:6px;}
  .autre-card .av{width:44px; height:44px; border-radius:50%; background:var(--blue); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:15px; overflow:hidden;}
  .autre-card .av img{width:100%; height:100%; object-fit:cover; object-position:center top;}
  .autre-card b{font-size:12.5px;}
  .autre-card span{font-size:11px; color:var(--text-dim);}
  .autre-card .badge-pending{margin-top:2px;}

  .employe-card{display:flex; align-items:center; gap:14px; padding:16px; background:var(--panel-2); border-radius:16px; margin-bottom:16px;}
  .employe-card .av{width:56px; height:56px; border-radius:50%; background:var(--blue); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:20px; flex:none; overflow:hidden;}
  .employe-card .av img{width:100%; height:100%; object-fit:cover; object-position:center 15%;}
  .employe-card b{display:block; font-size:15px;}
  .employe-card span{font-size:12px; color:var(--text-dim); display:block;}

  .details-grid{display:grid; grid-template-columns:1fr 1fr; gap:14px 20px; margin-bottom:16px;}
  .detail-item{display:flex; align-items:flex-start; gap:10px;}
  .detail-item .ico{width:32px; height:32px; border-radius:10px; background:rgba(59,130,246,.15); color:var(--blue-2); display:flex; align-items:center; justify-content:center; flex:none;}
  .detail-item b{display:block; font-size:13.5px;}
  .detail-item span{font-size:11.5px; color:var(--text-dim);}

  .motif-box{background:var(--panel-2); border-radius:14px; padding:14px 16px; font-size:13px; color:var(--text-dim); line-height:1.5; margin-bottom:14px;}
  .motif-box b{color:#fff; display:block; margin-bottom:4px; font-size:12.5px;}

  .fichier-row{display:flex; align-items:center; gap:10px; background:var(--panel-2); border-radius:12px; padding:10px 14px; font-size:12.5px;}
  .fichier-row .ico{color:var(--red); flex:none;}
  .fichier-row .name{flex:1;}
  .fichier-row span{color:var(--text-dim); font-size:11px;}
  .fichier-row a.btn-voir-fichier{color:var(--blue-2); font-weight:600; display:inline-flex; align-items:center; gap:4px;}

  .timeline{display:flex; flex-direction:column; gap:0;}
  .timeline-item{display:flex; gap:12px; position:relative; padding-bottom:20px;}
  .timeline-item:last-child{padding-bottom:0;}
  .timeline-item::before{content:''; position:absolute; left:11px; top:26px; bottom:0; width:2px; background:var(--border);}
  .timeline-item:last-child::before{display:none;}
  .timeline-dot{width:24px; height:24px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex:none; z-index:1;}
  .timeline-content b{display:block; font-size:12.5px;}
  .timeline-content span{font-size:11px; color:var(--text-dim);}

  .comment-item{display:flex; gap:10px; margin-bottom:14px;}
  .comment-item .av{width:32px; height:32px; border-radius:50%; background:var(--purple); display:flex; align-items:center; justify-content:center; font-size:12px; font-weight:700; flex:none; overflow:hidden;}
  .comment-item .av img{width:100%; height:100%; object-fit:cover; object-position:center top;}
  .comment-bubble{background:var(--panel-2); border-radius:12px; padding:10px 12px; flex:1;}
  .comment-bubble .top{display:flex; align-items:center; justify-content:space-between; margin-bottom:3px;}
  .comment-bubble b{font-size:12px;}
  .comment-bubble .time{font-size:10px; color:var(--text-dim);}
  .comment-bubble p{font-size:12.5px; color:var(--text-dim); line-height:1.4;}
  .comment-bubble .tag-interne{font-size:9.5px; color:var(--purple); font-weight:700; margin-left:6px;}

  .comment-form textarea{width:100%; background:var(--panel-2); border:1px solid var(--border); border-radius:12px; padding:10px 12px; color:#fff; font-size:12.5px; resize:vertical; min-height:60px;}
  .comment-form .row{display:flex; align-items:center; justify-content:space-between; margin-top:8px; gap:8px; flex-wrap:wrap;}
  .visi-toggle{display:flex; gap:6px; font-size:11px; color:var(--text-dim);}
  .visi-toggle label{display:flex; align-items:center; gap:4px; cursor:pointer;}
  .btn-send{background:var(--blue); color:#fff; font-size:12px; font-weight:700; padding:8px 16px; border-radius:999px; display:inline-flex; align-items:center; gap:6px;}

  .equipe-grid{display:grid; grid-template-columns:repeat(auto-fill, minmax(120px, 1fr)); gap:12px;}
  .equipe-card{background:var(--panel-2); border-radius:14px; padding:14px; text-align:center;}
  .equipe-card .av{width:40px; height:40px; border-radius:50%; background:var(--blue); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; margin:0 auto 8px; overflow:hidden;}
  .equipe-card .av img{width:100%; height:100%; object-fit:cover; object-position:center top;}
  .equipe-card b{display:block; font-size:12px;}
  .equipe-card span{font-size:10.5px; color:var(--text-dim);}

  .indic-grid{display:grid; grid-template-columns:1fr 1fr; gap:10px;}
  .indic-cell{background:var(--panel-2); border-radius:14px; padding:14px; text-align:center;}
  .indic-cell .ico{width:30px; height:30px; border-radius:9px; display:flex; align-items:center; justify-content:center; margin:0 auto 8px;}
  .indic-cell b{display:block; font-size:19px; font-weight:800;}
  .indic-cell span{font-size:10px; color:var(--text-dim);}
  .indic-center{text-align:center; padding:14px 0 6px;}
  .indic-center b{font-size:30px; font-weight:800; display:block;}
  .indic-center span{font-size:11px; color:var(--text-dim);}

  .decision-btns{display:flex; gap:10px; margin-bottom:14px;}
  .btn-decision{flex:1; display:flex; flex-direction:column; align-items:center; gap:6px; padding:14px 8px; border-radius:16px; font-size:12.5px; font-weight:700; color:#fff; border:2px solid transparent;}
  .btn-valider{background:rgba(16,185,129,.15); border-color:rgba(16,185,129,.4); color:var(--green);}
  .btn-valider.selected{background:var(--green); color:#fff;}
  .btn-refuser{background:rgba(239,68,68,.15); border-color:rgba(239,68,68,.4); color:var(--red);}
  .btn-refuser.selected{background:var(--red); color:#fff;}
  .btn-decision .ico-circle{width:34px; height:34px; border-radius:50%; background:rgba(255,255,255,.15); display:flex; align-items:center; justify-content:center;}

  .decision-form label{font-size:11.5px; color:var(--text-dim); display:block; margin-bottom:6px;}
  .decision-form textarea{width:100%; background:var(--panel-2); border:1px solid var(--border); border-radius:12px; padding:10px 12px; color:#fff; font-size:12.5px; resize:vertical; min-height:70px; margin-bottom:10px;}
  .decision-form .row{display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; flex-wrap:wrap; gap:8px;}
  .decision-actions{display:flex; gap:10px;}
  .btn-annuler{flex:1; background:var(--panel-2); border:1px solid var(--border); color:var(--text-dim); font-size:12.5px; font-weight:600; padding:11px; border-radius:12px; text-align:center;}
  .btn-enregistrer{flex:2; background:var(--blue); color:#fff; font-size:12.5px; font-weight:700; padding:11px; border-radius:12px; display:flex; align-items:center; justify-content:center; gap:6px;}

  .deja-traitee{background:var(--panel-2); border-radius:14px; padding:16px; text-align:center; font-size:13px; color:var(--text-dim); display:flex; flex-direction:column; align-items:center; gap:6px;}
  .deja-traitee .status-ico{width:38px; height:38px; border-radius:50%; display:flex; align-items:center; justify-content:center; margin-bottom:4px;}

  /* ===== Bouton "Annuler la décision" — orange, plus grand, cohérent avec le thème ===== */
  .btn-annuler-decision{
    width:100%; display:flex; align-items:center; justify-content:center; gap:9px;
    margin-top:16px; padding:15px 20px; border-radius:14px;
    font-size:14.5px; font-weight:700; color:#fff;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 8px 20px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);
    transition:transform .15s ease, box-shadow .15s ease, filter .15s ease;
  }
  .btn-annuler-decision:hover{transform:translateY(-2px); filter:brightness(1.08); box-shadow:0 12px 26px rgba(194,65,12,.5), inset 0 1px 0 rgba(255,255,255,.3);}
  .btn-annuler-decision:active{transform:translateY(0);}
  .btn-annuler-decision i{width:18px; height:18px;}

  .badge{display:inline-flex; align-items:center; gap:5px; padding:4px 11px; border-radius:20px; font-size:10.5px; font-weight:600;}
  .badge-approved{background:rgba(16,185,129,.15); color:var(--green);}
  .badge-pending{background:rgba(245,158,11,.15); color:var(--orange);}
  .badge-rejected{background:rgba(239,68,68,.15); color:var(--red);}

  /* ===== Modale moderne de confirmation (remplace le confirm() natif du navigateur) ===== */
  .modal-overlay{position:fixed; inset:0; background:rgba(2,4,10,.68); backdrop-filter:blur(5px); -webkit-backdrop-filter:blur(5px); z-index:300; display:none; align-items:center; justify-content:center; padding:20px;}
  .modal-overlay.open{display:flex;}
  .modal-box{
    position:relative; overflow:hidden; width:400px; max-width:100%;
    background: radial-gradient(120% 160% at 15% -10%, rgba(245,158,11,.14), transparent 55%), linear-gradient(165deg, #171d33, #0c1120 100%);
    border:1px solid rgba(245,158,11,.25); border-radius:24px; padding:30px 28px 26px;
    box-shadow:0 24px 60px rgba(0,0,0,.55), 0 0 40px rgba(245,158,11,.08);
    text-align:center; animation:modalPop .22s cubic-bezier(.2,.9,.3,1.1);
  }
  @keyframes modalPop{ from{ opacity:0; transform:translateY(10px) scale(.97);} to{ opacity:1; transform:translateY(0) scale(1);} }
  .modal-box .modal-ico-ring{
    width:64px; height:64px; border-radius:50%; margin:0 auto 18px; display:flex; align-items:center; justify-content:center;
    background:rgba(245,158,11,.15); box-shadow:0 0 0 8px rgba(245,158,11,.08);
    color:var(--orange);
  }
  .modal-box h3{font-size:18px; font-weight:800; color:#fff; margin-bottom:10px;}
  .modal-box p{font-size:13px; color:var(--text-dim); line-height:1.55; margin-bottom:26px;}
  .modal-box p b{color:#fff; font-weight:700;}
  .modal-actions{display:flex; gap:10px;}
  .modal-btn{flex:1; padding:13px; border-radius:13px; font-size:13.5px; font-weight:700; transition:transform .15s ease, filter .15s ease;}
  .modal-btn:hover{transform:translateY(-1px);}
  .modal-btn-cancel{background:var(--panel-2); border:1px solid var(--border); color:#fff;}
  .modal-btn-cancel:hover{background:rgba(255,255,255,.1);}
  .modal-btn-confirm{
    display:flex; align-items:center; justify-content:center; gap:7px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    color:#fff; box-shadow:0 8px 20px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);
  }
  .modal-btn-confirm:hover{filter:brightness(1.08);}

  @media (max-width:1100px){
    .content-grid{grid-template-columns:1fr;}
  }
  @media (max-width:800px){ .sidebar{display:none;} }
</style>
</head>
<body>

<div class="app">

  @include('partials.sidebar')

  <main class="main">

    <a href="{{ route('conges.index') }}" class="back-link"><i data-lucide="arrow-left" style="width:14px;height:14px;"></i> Retour aux demandes</a>

    <div class="header">
      <div class="header-left">
        <h1>Demande de {{ $employe->name }}</h1>
        <p>Voici le détail de la demande de congé à traiter.</p>
      </div>
      <div class="header-right">
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

        <div class="user-mini-wrap">
          <div class="avatar">
            @if (auth()->user()->photo_path)
              <img src="{{ asset('storage/'.auth()->user()->photo_path) }}" alt="">
            @else
              {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            @endif
          </div>
          <div class="user-mini"><p>{{ auth()->user()->name }}</p><span>{{ auth()->user()->poste ?? 'Responsable RH' }}</span></div>
        </div>
      </div>
    </div>

    @if (session('success'))
      <div style="margin-bottom:14px; padding:10px 14px; border-radius:10px; background:rgba(16,185,129,.15); color:var(--green); font-size:12.5px;">{{ session('success') }}</div>
    @endif
    @if ($errors->any())
      <div style="margin-bottom:14px; padding:10px 14px; border-radius:10px; background:rgba(239,68,68,.15); color:var(--red); font-size:12.5px;">{{ $errors->first() }}</div>
    @endif

    @if ($autresDemandesEnAttente->isNotEmpty())
      <div class="panel panel-pad" style="margin-bottom:16px;">
        <div class="card-head" style="margin-bottom:12px;"><h2>Autres demandes en attente</h2></div>
        <div class="autres-scroll">
          @foreach ($autresDemandesEnAttente as $autre)
            <a href="{{ route('conges.show', $autre->id) }}" class="autre-card">
              <span class="av">
                @if ($autre->user && $autre->user->photo_path)
                  <img src="{{ asset('storage/'.$autre->user->photo_path) }}" alt="">
                @else
                  {{ strtoupper(substr($autre->user->name ?? '?',0,1)) }}
                @endif
              </span>
              <b>{{ $autre->user->name ?? '—' }}</b>
              <span>{{ $libelles[$autre->type] ?? $autre->type }}</span>
              <span class="badge badge-pending">En attente</span>
            </a>
          @endforeach
        </div>
      </div>
    @endif

    <div class="content-grid" style="display:grid; grid-template-columns:1fr 320px; gap:16px; align-items:start;">

      <div style="display:flex; flex-direction:column; gap:16px; min-width:0;">

        <div class="panel panel-pad">
          <div class="card-head"><h2>Détails de la demande</h2></div>

          <div class="employe-card">
            <div class="av">
              @if ($employe->photo_path)
                <img src="{{ asset('storage/'.$employe->photo_path) }}" alt="">
              @else
                {{ strtoupper(substr($employe->name,0,1)) }}
              @endif
            </div>
            <div>
              <b>{{ $employe->name }}</b>
              <span>{{ $employe->poste ?? 'Employé' }}</span>
              <span>{{ $employe->departement ?? 'Département non renseigné' }}</span>
            </div>
          </div>

          <div class="details-grid">
            <div class="detail-item">
              <span class="ico"><i data-lucide="tag" style="width:15px;height:15px;"></i></span>
              <div><b>{{ $libelles[$leaveRequest->type] ?? $leaveRequest->type }}</b><span>Type de demande</span></div>
            </div>
            <div class="detail-item">
              <span class="ico"><i data-lucide="calendar-plus" style="width:15px;height:15px;"></i></span>
              <div><b>{{ $leaveRequest->created_at->format('d M Y à H:i') }}</b><span>Date de la demande</span></div>
            </div>
            <div class="detail-item">
              <span class="ico"><i data-lucide="calendar-range" style="width:15px;height:15px;"></i></span>
              <div><b>Du {{ $leaveRequest->date_debut->format('d M Y') }} au {{ $leaveRequest->date_fin->format('d M Y') }}</b><span>Période demandée</span></div>
            </div>
            <div class="detail-item">
              <span class="ico"><i data-lucide="hourglass" style="width:15px;height:15px;"></i></span>
              <div><b>{{ $leaveRequest->jours }} jours ouvrés</b><span>Durée</span></div>
            </div>
            <div class="detail-item">
              <span class="ico"><i data-lucide="info" style="width:15px;height:15px;"></i></span>
              <div>
                @php
                  $badge = ['approuve' => 'badge-approved', 'en_attente' => 'badge-pending', 'refuse' => 'badge-rejected'][$leaveRequest->statut];
                  $label = ['approuve' => 'Approuvée', 'en_attente' => 'En attente', 'refuse' => 'Refusée'][$leaveRequest->statut];
                @endphp
                <span class="badge {{ $badge }}">{{ $label }}</span>
                <span>Statut actuel</span>
              </div>
            </div>
            <div class="detail-item">
              <span class="ico"><i data-lucide="wallet" style="width:15px;height:15px;"></i></span>
              <div><b>{{ $employe->solde_conges_annuel }} jours</b><span>Solde actuel de l'employé</span></div>
            </div>
          </div>

          @if ($leaveRequest->motif)
            <div class="motif-box">
              <b>Motif de la demande</b>
              {{ $leaveRequest->motif }}
            </div>
          @endif

          <div class="fichier-row">
            <i data-lucide="paperclip" class="ico" style="width:15px;height:15px;"></i>
            @if ($leaveRequest->justificatif_path)
              <span class="name">{{ basename($leaveRequest->justificatif_path) }}</span>
              <a href="{{ asset('storage/'.$leaveRequest->justificatif_path) }}" target="_blank" class="btn-voir-fichier">
                <i data-lucide="external-link" style="width:12px;height:12px;"></i> Voir le fichier
              </a>
            @else
              <span class="name">Aucune pièce jointe</span>
              <span>—</span>
            @endif
          </div>
        </div>

        <div class="panel panel-pad">
          <div class="card-head"><h2>Historique de la demande</h2></div>
          <div class="timeline">
            <div class="timeline-item">
              <div class="timeline-dot" style="background:rgba(59,130,246,.2); color:var(--blue-2);"><i data-lucide="send" style="width:12px;height:12px;"></i></div>
              <div class="timeline-content">
                <b>Demande envoyée</b>
                <span>{{ $leaveRequest->created_at->format('d M Y à H:i') }} par {{ $employe->name }}</span>
              </div>
            </div>
            @if ($leaveRequest->statut !== 'en_attente')
              <div class="timeline-item">
                <div class="timeline-dot" style="background:{{ $leaveRequest->statut === 'approuve' ? 'rgba(16,185,129,.2)' : 'rgba(239,68,68,.2)' }}; color:{{ $leaveRequest->statut === 'approuve' ? 'var(--green)' : 'var(--red)' }};">
                  <i data-lucide="{{ $leaveRequest->statut === 'approuve' ? 'check' : 'x' }}" style="width:12px;height:12px;"></i>
                </div>
                <div class="timeline-content">
                  <b>Demande {{ $leaveRequest->statut === 'approuve' ? 'approuvée' : 'refusée' }}</b>
                  <span>{{ optional($leaveRequest->valide_le)->format('d M Y à H:i') }} par {{ $leaveRequest->validateur->name ?? 'RH' }}</span>
                </div>
              </div>
            @else
              <div class="timeline-item">
                <div class="timeline-dot" style="background:rgba(245,158,11,.2); color:var(--orange);"><i data-lucide="hourglass" style="width:12px;height:12px;"></i></div>
                <div class="timeline-content">
                  <b>En attente de décision</b>
                  <span>Aucune décision prise pour le moment</span>
                </div>
              </div>
            @endif
          </div>
        </div>

        <div class="panel panel-pad">
          <div class="card-head"><h2>Commentaires</h2></div>

          @forelse ($leaveRequest->comments as $commentaire)
            @if ($commentaire->visibilite === 'employe' || auth()->user()->role === 'rh')
              <div class="comment-item">
                <span class="av">
                  @if ($commentaire->user && $commentaire->user->photo_path)
                    <img src="{{ asset('storage/'.$commentaire->user->photo_path) }}" alt="">
                  @else
                    {{ strtoupper(substr($commentaire->user->name ?? '?',0,1)) }}
                  @endif
                </span>
                <div class="comment-bubble">
                  <div class="top">
                    <b>{{ $commentaire->user->name ?? '—' }}
                      @if ($commentaire->visibilite === 'interne')<span class="tag-interne">Interne RH</span>@endif
                    </b>
                    <span class="time">{{ $commentaire->created_at->diffForHumans() }}</span>
                  </div>
                  <p>{{ $commentaire->message }}</p>
                </div>
              </div>
            @endif
          @empty
            <p style="font-size:12.5px; color:var(--text-dim);">Aucun commentaire pour l'instant.</p>
          @endforelse

          <form method="POST" action="{{ route('conges.comment', $leaveRequest->id) }}" class="comment-form" style="margin-top:10px;">
            @csrf
            <textarea name="message" placeholder="Ajouter un commentaire..." required></textarea>
            <div class="row">
              <div class="visi-toggle">
                <label><input type="radio" name="visibilite" value="employe" checked> Visible par l'employé</label>
                <label><input type="radio" name="visibilite" value="interne"> Interne RH uniquement</label>
              </div>
              <button type="submit" class="btn-send"><i data-lucide="send" style="width:13px;height:13px;"></i> Envoyer</button>
            </div>
          </form>
        </div>

        @if ($equipe->isNotEmpty())
          <div class="panel panel-pad">
            <div class="card-head"><h2>Équipe — {{ $employe->departement ?? 'Département' }}</h2></div>
            <div class="equipe-grid">
              @foreach ($equipe as $membre)
                <div class="equipe-card">
                  <div class="av">
                    @if ($membre->photo_path)
                      <img src="{{ asset('storage/'.$membre->photo_path) }}" alt="">
                    @else
                      {{ strtoupper(substr($membre->name,0,1)) }}
                    @endif
                  </div>
                  <b>{{ $membre->name }}</b>
                  <span>{{ $membre->poste ?? 'Employé' }}</span>
                </div>
              @endforeach
            </div>
          </div>
        @endif

      </div>

      <div style="display:flex; flex-direction:column; gap:16px;">

        <div class="panel panel-pad">
          <div class="card-head"><h2>Indicateurs de congés</h2></div>
          <div class="indic-center">
            <b>{{ $employe->solde_conges_annuel }}</b>
            <span>jours — solde actuel de {{ explode(' ', $employe->name)[0] }}</span>
          </div>
          @php
            $infoJours = match ($leaveRequest->statut) {
                'approuve' => ['label' => 'Jours approuvés', 'icone' => 'check-circle-2', 'bg' => 'rgba(16,185,129,.15)', 'couleur' => 'var(--green)'],
                'refuse'   => ['label' => 'Jours refusés',   'icone' => 'x-circle',       'bg' => 'rgba(239,68,68,.15)',  'couleur' => 'var(--red)'],
                default    => ['label' => 'Demande en cours', 'icone' => 'hourglass',      'bg' => 'rgba(245,158,11,.15)', 'couleur' => 'var(--orange)'],
            };
          @endphp
          <div class="indic-grid">
            <div class="indic-cell">
              <span class="ico" style="background:rgba(139,92,246,.15); color:var(--purple);"><i data-lucide="wallet" style="width:15px;height:15px;"></i></span>
              <b>{{ $employe->solde_conges_annuel }}</b>
              <span>Solde disponible</span>
            </div>
            <div class="indic-cell">
              <span class="ico" style="background:{{ $infoJours['bg'] }}; color:{{ $infoJours['couleur'] }};"><i data-lucide="{{ $infoJours['icone'] }}" style="width:15px;height:15px;"></i></span>
              <b>{{ $leaveRequest->jours }}</b>
              <span>{{ $infoJours['label'] }}</span>
            </div>
            <div class="indic-cell">
              <span class="ico" style="background:rgba(59,130,246,.15); color:var(--blue-2);"><i data-lucide="calendar-check" style="width:15px;height:15px;"></i></span>
              <b>{{ $apresValidation }}</b>
              <span>{{ $leaveRequest->statut === 'en_attente' ? 'Après validation' : 'Solde après décision' }}</span>
            </div>
            <div class="indic-cell">
              <span class="ico" style="background:rgba(16,185,129,.15); color:var(--green);"><i data-lucide="check-circle-2" style="width:15px;height:15px;"></i></span>
              <b>{{ $joursUtilises }}</b>
              <span>Congés utilisés (cette année)</span>
            </div>
          </div>
        </div>

        <div class="panel panel-pad">
          <div class="card-head"><h2>Décision RH</h2></div>

          @if ($leaveRequest->statut !== 'en_attente')
            <div class="deja-traitee">
              <span class="status-ico" style="background:{{ $leaveRequest->statut === 'approuve' ? 'rgba(16,185,129,.15)' : 'rgba(239,68,68,.15)' }}; color:{{ $leaveRequest->statut === 'approuve' ? 'var(--green)' : 'var(--red)' }};">
                <i data-lucide="{{ $leaveRequest->statut === 'approuve' ? 'check' : 'x' }}" style="width:18px;height:18px;"></i>
              </span>
              Cette demande a déjà été
              <b style="color:{{ $leaveRequest->statut === 'approuve' ? 'var(--green)' : 'var(--red)' }};">
                {{ $leaveRequest->statut === 'approuve' ? 'approuvée' : 'refusée' }}
              </b>
              le {{ optional($leaveRequest->valide_le)->format('d M Y') }}.
            </div>

            <button type="button" class="btn-annuler-decision" id="btnOuvrirAnnulation">
              <i data-lucide="rotate-ccw"></i> Annuler la décision
            </button>

            <form method="POST" action="{{ route('conges.annulerDecision', $leaveRequest->id) }}" id="annulerDecisionForm">
              @csrf
            </form>
          @else
            <form method="POST" action="" id="decisionForm" class="decision-form">
              @csrf
              <div class="decision-btns">
                <button type="button" class="btn-decision btn-valider" id="btnValider">
                  <span class="ico-circle"><i data-lucide="check" style="width:16px;height:16px;"></i></span>
                  Valider la demande
                </button>
                <button type="button" class="btn-decision btn-refuser" id="btnRefuser">
                  <span class="ico-circle"><i data-lucide="x" style="width:16px;height:16px;"></i></span>
                  Refuser la demande
                </button>
              </div>

              <label>Commentaire du RH <span id="commentaireObligatoire" style="display:none; color:var(--red);">(obligatoire en cas de refus)</span></label>
              <textarea name="commentaire" id="commentaireInput" placeholder="Ajouter une précision pour l'employé..."></textarea>

              <div class="row">
                <div class="visi-toggle">
                  <label><input type="radio" name="visibilite" value="employe" checked> Visible par l'employé</label>
                  <label><input type="radio" name="visibilite" value="interne"> Interne uniquement</label>
                </div>
              </div>

              <div class="decision-actions">
                <a href="{{ route('conges.index') }}" class="btn-annuler">Annuler</a>
                <button type="submit" class="btn-enregistrer" id="btnEnregistrer" disabled>
                  <i data-lucide="save" style="width:14px;height:14px;"></i> Enregistrer la décision
                </button>
              </div>
            </form>
          @endif
        </div>

      </div>
    </div>

  </main>
</div>

@if ($leaveRequest->statut !== 'en_attente')
<div class="modal-overlay" id="confirmAnnulationOverlay">
  <div class="modal-box">
    <div class="modal-ico-ring"><i data-lucide="rotate-ccw" style="width:26px;height:26px;"></i></div>
    <h3>Annuler cette décision ?</h3>
    <p>
      La demande repassera en <b>attente de validation</b>.
      @if ($leaveRequest->statut === 'approuve' && $leaveRequest->type === 'paye')
        Le solde de <b>{{ $leaveRequest->jours }} jour{{ $leaveRequest->jours > 1 ? 's' : '' }}</b> déjà décompté sera recrédité automatiquement à {{ $employe->name }}.
      @endif
      {{ $employe->name }} recevra une notification.
    </p>
    <div class="modal-actions">
      <button type="button" class="modal-btn modal-btn-cancel" id="btnFermerAnnulation">Non, garder</button>
      <button type="button" class="modal-btn modal-btn-confirm" id="btnConfirmerAnnulation">
        <i data-lucide="rotate-ccw" style="width:14px;height:14px;"></i> Oui, annuler
      </button>
    </div>
  </div>
</div>
@endif

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

  const form = document.getElementById('decisionForm');
  const btnValider = document.getElementById('btnValider');
  const btnRefuser = document.getElementById('btnRefuser');
  const btnEnregistrer = document.getElementById('btnEnregistrer');
  const commentaireInput = document.getElementById('commentaireInput');
  const commentaireObligatoire = document.getElementById('commentaireObligatoire');

  if (form) {
    let choix = null;

    const approveUrl = "{{ route('conges.approve', $leaveRequest->id) }}";
    const rejectUrl = "{{ route('conges.reject', $leaveRequest->id) }}";

    btnValider.addEventListener('click', () => {
      choix = 'valider';
      btnValider.classList.add('selected');
      btnRefuser.classList.remove('selected');
      commentaireObligatoire.style.display = 'none';
      commentaireInput.required = false;
      form.action = approveUrl;
      btnEnregistrer.disabled = false;
    });

    btnRefuser.addEventListener('click', () => {
      choix = 'refuser';
      btnRefuser.classList.add('selected');
      btnValider.classList.remove('selected');
      commentaireObligatoire.style.display = 'inline';
      commentaireInput.required = true;
      form.action = rejectUrl;
      btnEnregistrer.disabled = false;
    });
  }

  // ===== Modale moderne "Annuler la décision" (remplace le confirm() natif) =====
  const btnOuvrirAnnulation = document.getElementById('btnOuvrirAnnulation');
  const confirmAnnulationOverlay = document.getElementById('confirmAnnulationOverlay');
  const btnFermerAnnulation = document.getElementById('btnFermerAnnulation');
  const btnConfirmerAnnulation = document.getElementById('btnConfirmerAnnulation');
  const annulerDecisionForm = document.getElementById('annulerDecisionForm');

  if (btnOuvrirAnnulation && confirmAnnulationOverlay) {
    btnOuvrirAnnulation.addEventListener('click', () => {
      confirmAnnulationOverlay.classList.add('open');
    });
    btnFermerAnnulation.addEventListener('click', () => {
      confirmAnnulationOverlay.classList.remove('open');
    });
    confirmAnnulationOverlay.addEventListener('click', (e) => {
      if (e.target === confirmAnnulationOverlay) confirmAnnulationOverlay.classList.remove('open');
    });
    btnConfirmerAnnulation.addEventListener('click', () => {
      annulerDecisionForm.submit();
    });
  }
</script>
</body>
</html>