<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Mes demandes — NAJA7 HOST</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<style>
  :root{
    --blue:#3B82F6; --blue-2:#60A5FA;
    --orange:#F59E0B; --orange-2:#FBBF24; --green:#10B981; --red:#EF4444; --purple:#8B5CF6;
    --bg:#05070F; --panel:rgba(18,24,42,.55); --panel-2:rgba(255,255,255,.06);
    --border:rgba(255,255,255,.12);
    --text:#F1F4FA; --text-dim:#C3CCE0;
    --radius:22px; --glass-blur:22px;
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  html, body{height:100%; overflow-x:hidden;}
  body{
    font-family:'Poppins',sans-serif; color:var(--text); -webkit-font-smoothing:antialiased;
    background: linear-gradient(180deg, rgba(4,6,14,.72), rgba(4,6,14,.88)), url('{{ asset('images/dashboard-bg.jpg') }}') center/cover no-repeat fixed;
  }
  a{text-decoration:none; color:inherit;}
  button{font-family:inherit; cursor:pointer; border:none; background:none; color:inherit;}
  select, input{font-family:inherit;}

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
  .side-link:focus .tip{opacity:1;}
  .side-bottom{display:flex; flex-direction:column; gap:4px; padding-top:8px; margin-top:6px; border-top:1px solid var(--border); align-items:center; flex:none;}

  .main{flex:1; align-self:stretch; padding:6px 6px 40px; max-width:100%; overflow-x:hidden; position:relative;}

  .header{display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; flex-wrap:wrap; gap:14px;}
  .header-left h1{font-size:26px; font-weight:800; color:#fff;}
  .header-left p{color:var(--text-dim); font-size:13.5px; margin-top:4px;}
  .header-right{display:flex; align-items:center; gap:12px;}

  .search-box{width:240px; height:40px; display:flex; align-items:center; gap:8px; background:var(--panel); border:1px solid var(--border); border-radius:10px; padding:0 12px;}
  .search-box input{flex:1; border:none; outline:none; background:transparent; color:#fff; font-size:14px;}
  .search-box input::placeholder{color:var(--text-dim);}

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

  .stats-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:22px;}
  @media (max-width:900px){ .stats-grid{grid-template-columns:1fr 1fr;} }
  .stat-card{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:18px; padding:18px; display:flex; align-items:center; gap:14px; box-shadow:0 8px 24px rgba(0,0,0,.25);}
  .stat-card .ico{width:46px; height:46px; border-radius:13px; display:flex; align-items:center; justify-content:center; flex:none;}
  .stat-card b{display:block; font-size:24px; font-weight:800; color:#fff; line-height:1.1;}
  .stat-card .lbl{font-size:13px; font-weight:600; color:#fff; margin-top:2px;}
  .stat-card span.sub{font-size:11px; color:var(--text-dim);}
  .stat-total .ico{background:rgba(59,130,246,.18); color:var(--blue-2);}
  .stat-approuve .ico{background:rgba(16,185,129,.18); color:var(--green);}
  .stat-attente .ico{background:rgba(245,158,11,.18); color:var(--orange);}
  .stat-refuse .ico{background:rgba(239,68,68,.18); color:var(--red);}

  .layout{display:grid; grid-template-columns:1fr 320px; gap:18px; align-items:start;}
  @media (max-width:1050px){ .layout{grid-template-columns:1fr;} }
  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25);}
  .panel-pad{padding:22px;}

  .panel-head{display:flex; align-items:center; justify-content:space-between; margin-bottom:18px; flex-wrap:wrap; gap:10px;}
  .panel-head h2{font-size:17px; font-weight:700; color:#fff; position:relative; padding-left:14px;}
  .panel-head h2::before{content:''; position:absolute; left:0; top:3px; bottom:3px; width:4px; border-radius:3px; background:var(--blue);}
  .sort-select{background:#141b30; border:1px solid var(--border); color:#fff; font-size:12.5px; padding:8px 12px; border-radius:9px;}

  .demande-card{display:flex; gap:14px; padding:16px; border-radius:16px; background:var(--panel-2); margin-bottom:12px; border-left:4px solid var(--c); align-items:flex-start; flex-wrap:wrap;}
  .demande-card .ico-wrap{width:44px; height:44px; border-radius:12px; background:var(--c); display:flex; align-items:center; justify-content:center; flex:none; opacity:.9;}
  .demande-body{flex:1; min-width:0;}
  .demande-top{display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-bottom:4px;}
  .demande-top b{font-size:16px; font-weight:700;}
  .demande-tag{font-size:10.5px; font-weight:700; padding:3px 10px; border-radius:20px; background:rgba(255,255,255,.08); color:var(--text-dim);}
  .demande-meta{display:flex; align-items:center; gap:14px; font-size:12.5px; color:var(--text-dim); flex-wrap:wrap; margin-bottom:6px;}
  .demande-meta span{display:inline-flex; align-items:center; gap:5px;}
  .demande-motif{font-size:12.5px; color:var(--text-dim);}

  .demande-right{display:flex; flex-direction:column; align-items:flex-end; gap:8px; flex:none;}
  .demande-date{font-size:11.5px; color:var(--text-dim); white-space:nowrap;}
  .badge{display:inline-flex; align-items:center; gap:5px; padding:5px 13px; border-radius:20px; font-size:12px; font-weight:600; white-space:nowrap;}
  .badge-approved{background:rgba(16,185,129,.15); color:var(--green);}
  .badge-pending{background:rgba(245,158,11,.15); color:var(--orange);}
  .badge-rejected{background:rgba(239,68,68,.15); color:var(--red);}
  .chev-btn{width:28px; height:28px; border-radius:9px; background:rgba(255,255,255,.06); display:flex; align-items:center; justify-content:center; color:var(--text-dim);}
  .chev-btn:hover{color:#fff; background:rgba(255,255,255,.1);}
  .btn-annuler-demande{display:inline-flex; align-items:center; gap:5px; font-size:11px; font-weight:700; color:var(--red); background:rgba(239,68,68,.12); border:1px solid rgba(239,68,68,.3); padding:6px 12px; border-radius:9px; white-space:nowrap;}
  .btn-annuler-demande:hover{background:rgba(239,68,68,.2);}

  .modal-overlay{position:fixed; inset:0; background:rgba(2,4,10,.65); backdrop-filter:blur(4px); z-index:300; display:none; align-items:center; justify-content:center;}
  .modal-overlay.open{display:flex;}
  .modal-box{background:rgba(20,27,48,.98); border:1px solid var(--border); border-radius:20px; padding:26px; width:360px; max-width:90vw; box-shadow:0 20px 50px rgba(0,0,0,.5); text-align:center;}
  .modal-box .modal-ico{width:52px; height:52px; border-radius:50%; background:rgba(239,68,68,.15); color:var(--red); display:flex; align-items:center; justify-content:center; margin:0 auto 16px;}
  .modal-box h3{font-size:16px; font-weight:700; color:#fff; margin-bottom:8px;}
  .modal-box p{font-size:13px; color:var(--text-dim); line-height:1.5; margin-bottom:22px;}
  .modal-actions{display:flex; gap:10px;}
  .modal-btn{flex:1; padding:11px; border-radius:11px; font-size:13px; font-weight:700;}
  .modal-btn-cancel{background:var(--panel-2); border:1px solid var(--border); color:#fff;}
  .modal-btn-cancel:hover{background:rgba(255,255,255,.1);}
  .modal-btn-confirm{background:linear-gradient(160deg, #EF4444, #7F1D1D 75%); color:#fff; box-shadow:0 8px 20px rgba(127,29,29,.4);}
  .modal-btn-confirm:hover{filter:brightness(1.1);}

  .empty-state{text-align:center; padding:44px 0; color:var(--text-dim);}
  .empty-state .ico{width:46px; height:46px; border-radius:50%; background:rgba(255,255,255,.06); display:flex; align-items:center; justify-content:center; margin:0 auto 12px;}

  .filtre-item{display:flex; align-items:center; justify-content:space-between; padding:12px 14px; border-radius:13px; margin-bottom:8px; font-size:13.5px; font-weight:600; border:1px solid var(--border);}
  .filtre-item.active{background:var(--blue); border-color:var(--blue); color:#fff;}
  .filtre-item .count{background:rgba(255,255,255,.18); padding:2px 10px; border-radius:20px; font-size:12px;}
  .filtre-item:not(.active) .count{background:var(--panel-2); color:var(--text-dim);}
  .filtre-dot{width:9px; height:9px; border-radius:50%; margin-right:9px; display:inline-block; flex:none;}
  .filtre-item span.lbl{display:flex; align-items:center;}

  .periode-row{display:flex; align-items:center; gap:8px; margin-top:12px;}
  .periode-row .champ{flex:1;}
  .periode-row label{display:block; font-size:11px; color:var(--text-dim); margin-bottom:5px;}
  .periode-row input{width:100%; background:#141b30; border:1px solid var(--border); border-radius:9px; padding:9px 10px; color:#fff; font-size:12.5px; color-scheme:dark;}

  .btn-appliquer{width:100%; margin-top:16px; background:var(--blue); color:#fff; font-size:13.5px; font-weight:700; padding:12px; border-radius:11px; text-align:center;}
  .btn-appliquer:hover{filter:brightness(1.1);}

  .cta-card{background:linear-gradient(135deg, rgba(59,130,246,.16), rgba(18,24,42,.4)); border:1px solid rgba(59,130,246,.25);}
  .cta-card b{display:block; font-size:15px; font-weight:700; color:#fff; margin-bottom:4px;}
  .cta-card p{font-size:12.5px; color:var(--text-dim); line-height:1.5; margin-bottom:14px;}
  .btn-nouvelle{display:inline-flex; align-items:center; gap:6px; background:var(--blue); color:#fff; font-size:12.5px; font-weight:700; padding:10px 16px; border-radius:10px;}
  .btn-nouvelle:hover{filter:brightness(1.1);}

  .rappel-card{background:rgba(59,130,246,.1); border:1px solid rgba(59,130,246,.2); position:relative;}
  .rappel-card b{display:flex; align-items:center; gap:8px; font-size:13.5px; color:#fff; margin-bottom:6px;}
  .rappel-card p{font-size:12px; color:var(--text-dim); line-height:1.5;}
  .rappel-close{position:absolute; top:14px; right:14px; color:var(--text-dim);}

  /* ===== Commentaires visibles par l'employé sur chaque demande ===== */
  .demande-comments{flex-basis:100%; width:100%; margin-top:10px; padding-top:10px; border-top:1px solid rgba(255,255,255,.08);}
  .demande-comment{display:flex; gap:8px; margin-bottom:8px;}
  .demande-comment:last-child{margin-bottom:0;}
  .demande-comment .c-ico{width:26px; height:26px; border-radius:50%; background:rgba(59,130,246,.15); color:var(--blue-2); display:flex; align-items:center; justify-content:center; flex:none;}
  .demande-comment .c-body{background:rgba(255,255,255,.04); border-radius:10px; padding:8px 10px; flex:1;}
  .demande-comment .c-top{display:flex; align-items:center; justify-content:space-between; margin-bottom:2px;}
  .demande-comment b{font-size:11.5px; color:#fff;}
  .demande-comment .c-time{font-size:10px; color:var(--text-dim);}
  .demande-comment p{font-size:12px; color:var(--text-dim); line-height:1.4; margin:0;}

  @media (max-width:800px){ .sidebar{display:none;} }
</style>
</head>
<body>

<div class="app">

  @include('partials.sidebar')

  <main class="main">

    <div class="header">
      <div class="header-left">
        <h1>Mes demandes</h1>
        <p>Suivez et gérez toutes vos demandes de congé.</p>
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
            <a href="{{ route('settings.index') }}"><i data-lucide="settings" style="width:15px;height:15px;"></i> Paramètres & support</a>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit"><i data-lucide="log-out" style="width:15px;height:15px;"></i> Déconnexion</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="stats-grid">
      <div class="stat-card stat-total">
        <div class="ico"><i data-lucide="file-text" style="width:20px;height:20px;"></i></div>
        <div><b>{{ $total }}</b><div class="lbl">Demandes totales</div><span class="sub">Tout temps</span></div>
      </div>
      <div class="stat-card stat-approuve">
        <div class="ico"><i data-lucide="check-circle-2" style="width:20px;height:20px;"></i></div>
        <div><b>{{ $approuvees }}</b><div class="lbl">Approuvées</div><span class="sub">Tout temps</span></div>
      </div>
      <div class="stat-card stat-attente">
        <div class="ico"><i data-lucide="clock" style="width:20px;height:20px;"></i></div>
        <div><b>{{ $enAttente }}</b><div class="lbl">En attente</div><span class="sub">Actuellement</span></div>
      </div>
      <div class="stat-card stat-refuse">
        <div class="ico"><i data-lucide="x-circle" style="width:20px;height:20px;"></i></div>
        <div><b>{{ $refusees }}</b><div class="lbl">Refusées</div><span class="sub">Tout temps</span></div>
      </div>
    </div>

    <div class="layout">

      <div class="panel panel-pad">
        <div class="panel-head">
          <h2>Mes demandes récentes</h2>
          <select class="sort-select" id="triSelect">
            <option value="recent" @selected($tri === 'recent')>Trier par : Plus récent</option>
            <option value="ancien" @selected($tri === 'ancien')>Trier par : Plus ancien</option>
            <option value="statut" @selected($tri === 'statut')>Trier par : Statut</option>
          </select>
        </div>

        @php
          $libelles = ['paye' => 'Congé annuel', 'maladie' => 'Congé maladie', 'sans_solde' => 'Congé sans solde', 'exceptionnel' => 'Congé exceptionnel', 'rtt' => 'RTT / Récupération', 'autre' => 'Autre congé'];
          $tags = ['paye' => 'Vacances', 'maladie' => 'Maladie', 'sans_solde' => 'Sans solde', 'exceptionnel' => 'Événement familial', 'rtt' => 'RTT', 'autre' => 'Personnel'];
          $icones = ['paye' => 'palmtree', 'maladie' => 'stethoscope', 'sans_solde' => 'ban', 'exceptionnel' => 'star', 'rtt' => 'refresh-ccw', 'autre' => 'user'];
          $couleurs = ['paye' => 'var(--blue)', 'maladie' => 'var(--red)', 'sans_solde' => 'var(--text-dim)', 'exceptionnel' => 'var(--purple)', 'rtt' => 'var(--blue-2)', 'autre' => 'var(--orange)'];
          $badgeStatut = ['approuve' => 'badge-approved', 'en_attente' => 'badge-pending', 'refuse' => 'badge-rejected'];
          $labelStatut = ['approuve' => 'Approuvée', 'en_attente' => 'En attente', 'refuse' => 'Refusée'];
          $icoStatut = ['approuve' => 'check', 'en_attente' => 'clock', 'refuse' => 'x'];
        @endphp

        @forelse ($demandes as $demande)
          <div class="demande-card" style="--c: {{ $couleurs[$demande->type] ?? 'var(--blue)' }};">
            <div class="ico-wrap"><i data-lucide="{{ $icones[$demande->type] ?? 'file-text' }}" style="width:20px;height:20px; color:#fff;"></i></div>
            <div class="demande-body">
              <div class="demande-top">
                <b>{{ $libelles[$demande->type] ?? $demande->type }}</b>
                <span class="demande-tag">{{ $tags[$demande->type] ?? '' }}</span>
              </div>
              <div class="demande-meta">
                <span><i data-lucide="calendar" style="width:13px;height:13px;"></i> {{ $demande->date_debut->format('d M') }} – {{ $demande->date_fin->format('d M Y') }}</span>
                <span><i data-lucide="clock" style="width:13px;height:13px;"></i> {{ $demande->jours }} jour{{ $demande->jours > 1 ? 's' : '' }}</span>
              </div>
              @if ($demande->motif)
                <div class="demande-motif">{{ $demande->motif }}</div>
              @endif
            </div>
            <div class="demande-right">
              <span class="demande-date">{{ $demande->created_at->format('d M Y') }}</span>
              <span class="badge {{ $badgeStatut[$demande->statut] ?? '' }}">
                <i data-lucide="{{ $icoStatut[$demande->statut] ?? 'circle' }}" style="width:12px;height:12px;"></i>
                {{ $labelStatut[$demande->statut] ?? $demande->statut }}
              </span>
              <a href="{{ route('conges.mesDemandes') }}#demande-{{ $demande->id }}" class="chev-btn"><i data-lucide="chevron-right" style="width:15px;height:15px;"></i></a>
              @if ($demande->statut === 'en_attente')
                <form method="POST" action="{{ route('conges.annuler', $demande->id) }}" id="annulerForm-{{ $demande->id }}">
                  @csrf
                  @method('delete')
                </form>
                <button type="button" class="btn-annuler-demande" onclick="ouvrirConfirmAnnulation({{ $demande->id }})"><i data-lucide="x" style="width:12px;height:12px;"></i> Annuler</button>
              @endif
            </div>

            @php
              $commentairesVisibles = $demande->comments->where('visibilite', 'employe');
            @endphp
            @if ($commentairesVisibles->isNotEmpty())
              <div class="demande-comments">
                @foreach ($commentairesVisibles as $commentaire)
                  <div class="demande-comment">
                    <span class="c-ico"><i data-lucide="message-circle" style="width:13px;height:13px;"></i></span>
                    <div class="c-body">
                      <div class="c-top">
                        <b>{{ $commentaire->user->name ?? 'RH' }}</b>
                        <span class="c-time">{{ $commentaire->created_at->diffForHumans() }}</span>
                      </div>
                      <p>{{ $commentaire->message }}</p>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        @empty
          <div class="empty-state">
            <div class="ico"><i data-lucide="inbox" style="width:22px;height:22px;"></i></div>
            <p style="font-size:15px; font-weight:600; color:#fff; margin-bottom:4px;">Aucune demande pour l'instant</p>
            <p style="font-size:13px;">Crée ta première demande de congé.</p>
          </div>
        @endforelse
      </div>

      <div style="display:flex; flex-direction:column; gap:16px;">

        <div class="panel panel-pad">
          <div class="panel-head" style="margin-bottom:14px;"><h2 style="padding-left:0;"><i data-lucide="sliders-horizontal" style="width:15px;height:15px; vertical-align:-2px; margin-right:6px;"></i>Filtrer les demandes</h2></div>

          <a href="{{ route('conges.mesDemandes') }}" class="filtre-item {{ !$statut ? 'active' : '' }}">
            <span class="lbl"><span class="filtre-dot" style="background:#fff;"></span> Toutes les demandes</span>
            <span class="count">{{ $total }}</span>
          </a>
          <a href="{{ route('conges.mesDemandes', ['statut' => 'en_attente']) }}" class="filtre-item {{ $statut === 'en_attente' ? 'active' : '' }}">
            <span class="lbl"><span class="filtre-dot" style="background:var(--orange);"></span> En attente</span>
            <span class="count">{{ $enAttente }}</span>
          </a>
          <a href="{{ route('conges.mesDemandes', ['statut' => 'approuve']) }}" class="filtre-item {{ $statut === 'approuve' ? 'active' : '' }}">
            <span class="lbl"><span class="filtre-dot" style="background:var(--green);"></span> Approuvées</span>
            <span class="count">{{ $approuvees }}</span>
          </a>
          <a href="{{ route('conges.mesDemandes', ['statut' => 'refuse']) }}" class="filtre-item {{ $statut === 'refuse' ? 'active' : '' }}">
            <span class="lbl"><span class="filtre-dot" style="background:var(--red);"></span> Refusées</span>
            <span class="count">{{ $refusees }}</span>
          </a>

          <form method="GET" action="{{ route('conges.mesDemandes') }}">
            <div class="periode-row">
              <div class="champ">
                <label>Du</label>
                <input type="date" name="du">
              </div>
              <div class="champ">
                <label>au</label>
                <input type="date" name="au">
              </div>
            </div>
            <button type="submit" class="btn-appliquer">Appliquer les filtres</button>
          </form>
        </div>

        <div class="panel panel-pad cta-card">
          <b>Besoin d'un congé ?</b>
          <p>Créez une nouvelle demande en quelques clics seulement.</p>
          <a href="{{ route('conges.create') }}" class="btn-nouvelle"><i data-lucide="plus" style="width:14px;height:14px;"></i> Nouvelle demande</a>
        </div>

        <div class="panel panel-pad rappel-card" id="rappelCard">
          <button class="rappel-close" id="rappelClose"><i data-lucide="x" style="width:15px;height:15px;"></i></button>
          <b><i data-lucide="bell" style="width:14px;height:14px;"></i> Rappel important</b>
          <p>Pensez à faire vos demandes à l'avance pour une meilleure planification.</p>
        </div>

      </div>
    </div>

  </main>
</div>

<div class="modal-overlay" id="confirmAnnulerOverlay">
  <div class="modal-box">
    <div class="modal-ico"><i data-lucide="triangle-alert" style="width:24px;height:24px;"></i></div>
    <h3>Annuler cette demande ?</h3>
    <p>Cette action est définitive. Ta demande de congé sera supprimée et tu devras en refaire une nouvelle si besoin.</p>
    <div class="modal-actions">
      <button type="button" class="modal-btn modal-btn-cancel" onclick="fermerConfirmAnnulation()">Non, garder</button>
      <button type="button" class="modal-btn modal-btn-confirm" id="btnConfirmAnnuler">Oui, annuler</button>
    </div>
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

  const rappelClose = document.getElementById('rappelClose');
  const rappelCard = document.getElementById('rappelCard');
  rappelClose.addEventListener('click', () => rappelCard.style.display = 'none');

  // ===== Tri "Mes demandes récentes" — recharge la page avec le paramètre ?tri=... =====
  const triSelect = document.getElementById('triSelect');
  triSelect.addEventListener('change', () => {
    const url = new URL(window.location.href);
    url.searchParams.set('tri', triSelect.value);
    window.location.href = url.toString();
  });

  // ===== Modale de confirmation d'annulation =====
  const confirmOverlay = document.getElementById('confirmAnnulerOverlay');
  const btnConfirmAnnuler = document.getElementById('btnConfirmAnnuler');
  let idDemandeAAnnuler = null;

  function ouvrirConfirmAnnulation(id) {
    idDemandeAAnnuler = id;
    confirmOverlay.classList.add('open');
  }
  function fermerConfirmAnnulation() {
    confirmOverlay.classList.remove('open');
    idDemandeAAnnuler = null;
  }
  btnConfirmAnnuler.addEventListener('click', () => {
    if (idDemandeAAnnuler) {
      document.getElementById('annulerForm-' + idDemandeAAnnuler).submit();
    }
  });
  confirmOverlay.addEventListener('click', (e) => {
    if (e.target === confirmOverlay) fermerConfirmAnnulation();
  });
</script>
</body>
</html>