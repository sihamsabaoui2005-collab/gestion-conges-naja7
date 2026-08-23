<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Paramètres & Support — NAJA7 HOST</title>
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
  .side-link:focus .tip{opacity:1;}
  .side-bottom{display:flex; flex-direction:column; gap:4px; padding-top:8px; margin-top:6px; border-top:1px solid var(--border); align-items:center; flex:none;}

  .main{flex:1; align-self:stretch; padding:6px 6px 40px; max-width:100%; overflow-x:hidden;}

  .header{display:flex; align-items:center; justify-content:space-between; margin-bottom:22px; flex-wrap:wrap; gap:14px;}
  .header-left h1{position:relative; font-size:16px; font-weight:800; color:#fff; display:inline-flex; align-items:center; gap:8px;
    padding:12px 28px; background:linear-gradient(180deg,#3D7BFF 0%,#1E4FC4 55%,#123591 100%); border-radius:999px;
    box-shadow:0 6px 14px rgba(23,73,176,.5), inset 0 2px 0 rgba(255,255,255,.4), inset 0 -4px 8px rgba(0,0,0,.3);}
  .header-left p{color:var(--text-dim); font-size:13.5px; margin-top:4px; text-shadow:0 2px 8px rgba(0,0,0,.5); max-width:520px;}

  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25);}
  .side-panel{padding:22px;}
  .side-panel h3{position:relative; font-size:14px; font-weight:800; color:#fff; display:inline-flex; align-items:center; gap:8px;
    padding:11px 22px; background:linear-gradient(180deg,#3D7BFF 0%,#1E4FC4 55%,#123591 100%); border-radius:999px;
    box-shadow:0 6px 14px rgba(23,73,176,.5), inset 0 2px 0 rgba(255,255,255,.4), inset 0 -4px 8px rgba(0,0,0,.3);}
  .side-panel p.desc{color:var(--text-dim); font-size:13px; margin:10px 0 4px;}

  .settings-grid{display:grid; grid-template-columns:1.3fr 1fr; gap:18px; align-items:start;}
  @media (max-width:1050px){ .settings-grid{grid-template-columns:1fr;} }

  .sec-label{color:var(--orange); font-size:11.5px; text-transform:uppercase; letter-spacing:.06em; font-weight:700; margin:22px 0 8px;}
  .sec-label:first-of-type{margin-top:6px;}

  .set-row{display:flex; align-items:center; justify-content:space-between; padding:11px 0; border-bottom:1px solid var(--border); gap:12px; flex-wrap:wrap;}
  .set-row:last-child{border-bottom:none;}
  .set-label{display:flex; align-items:center; gap:10px; font-size:14px; flex-wrap:wrap;}
  .set-label i{color:var(--text-dim); width:17px; flex:none;}
  .set-label .sub{display:block; color:var(--text-dim); font-size:12px; font-weight:400; margin-top:1px;}

  .set-select, .set-value{background:var(--panel-2); border:1px solid var(--border); border-radius:10px; color:#fff; padding:8px 12px; font-size:13px;}
  .set-select{min-width:170px;}
  .set-select option{background:#161c30; color:#fff;}

  .toggle{width:42px; height:23px; border-radius:20px; background:var(--panel-2); border:1px solid var(--border); position:relative; cursor:pointer; flex:none;}
  .toggle.on{background:var(--orange); border-color:var(--orange);}
  .toggle::after{content:''; position:absolute; top:2px; left:2px; width:17px; height:17px; border-radius:50%; background:#fff; transition:.15s;}
  .toggle.on::after{left:21px;}

  .btn-save{position:relative; overflow:hidden; font-size:13.5px; font-weight:700; color:#fff; display:inline-flex; align-items:center; gap:8px; padding:12px 22px; border-radius:999px; margin-top:18px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .btn-save:hover{transform:translateY(-1px);}

  .support-grid{display:grid; grid-template-columns:repeat(3,1fr); gap:10px; margin:14px 0 20px;}
  .support-tile{background:var(--panel-2); border:1px solid var(--border); border-radius:16px; padding:14px;}
  .support-tile:hover{background:rgba(255,255,255,.1);}
  .tile-ico{width:32px; height:32px; border-radius:9px; display:flex; align-items:center; justify-content:center; margin-bottom:9px; color:#fff;}
  .tile-ico.blue{background:var(--blue);}
  .tile-ico.green{background:var(--green);}
  .tile-ico.purple{background:var(--purple);}
  .support-tile b{display:block; font-size:12.5px; margin-bottom:2px;}
  .support-tile span{font-size:11px; color:var(--text-dim); line-height:1.4;}
  .tile-arrow{margin-top:8px; color:var(--orange); font-size:12px;}

  .faq-item{display:flex; justify-content:space-between; align-items:center; background:var(--panel-2); border:1px solid var(--border); border-radius:12px; padding:11px 14px; margin-bottom:7px; font-size:13px;}
  .faq-item:hover{background:rgba(255,255,255,.1);}
  .faq-ans{font-size:12px; color:var(--text-dim); padding:0 14px 12px; margin-top:-5px; display:none; line-height:1.5;}

  .contact-row{display:flex; align-items:center; gap:10px; font-size:13px; padding:7px 0;}
  .contact-row i{color:var(--orange); width:17px; flex:none;}

  .footer-note{text-align:center; color:var(--text-dim); font-size:11.5px; margin-top:24px; display:flex; align-items:center; justify-content:center; gap:6px;}
</style>
@livewireStyles
</head>
<body>

<div class="app">

  @include('partials.sidebar')

  <main class="main">

    <div class="header">
      <div class="header-left">
        <h1>Paramètres & Support</h1>
        <p>Gérez vos préférences et obtenez de l'aide facilement.</p>
      </div>
    </div>

    @if (session('success'))
      <div style="margin:0 0 16px; padding:11px 16px; border-radius:12px; background:rgba(16,185,129,.15); color:var(--green); font-size:13px;">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
      <div style="margin:0 0 16px; padding:11px 16px; border-radius:12px; background:rgba(239,68,68,.15); color:var(--red); font-size:13px;">
        <strong>Erreur :</strong>
        <ul style="margin:6px 0 0 18px;">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @php $user = auth()->user(); @endphp

    <div class="settings-grid">

      <!-- PARAMETRES -->
      <div class="panel side-panel">
        <h3><i data-lucide="settings" style="width:14px;height:14px;"></i> Paramètres</h3>
        <p class="desc">Gérez vos préférences personnelles et les paramètres de votre compte.</p>

        <form method="POST" action="{{ route('settings.update') }}">
          @csrf
          @method('PATCH')

          <div class="sec-label">Général</div>
          <div class="set-row">
            <div class="set-label"><i data-lucide="clock"></i> Fuseau horaire</div>
            <select name="fuseau_horaire" class="set-select">
              <option value="Africa/Casablanca" @selected(($user->fuseau_horaire ?? 'Africa/Casablanca') === 'Africa/Casablanca')>(GMT+01:00) Casablanca</option>
            </select>
          </div>
          <div class="set-row">
            <div class="set-label"><i data-lucide="calendar"></i> Format de la date</div>
            <span class="set-value">DD/MM/YYYY</span>
            <input type="hidden" name="format_date" value="d/m/Y">
          </div>

          <div class="sec-label">Compte</div>
          <div class="set-row">
            <div class="set-label"><i data-lucide="user"></i> Adresse e-mail</div>
            <span class="set-value">{{ $user->email }}</span>
          </div>
          <a href="{{ route('profile.edit') }}" class="set-row" style="cursor:pointer;">
            <div class="set-label"><i data-lucide="lock"></i> Changer le mot de passe</div>
            <i data-lucide="chevron-right"></i>
          </a>

          <div class="sec-label">Notifications</div>
          <div class="set-row">
            <div class="set-label">
              <i data-lucide="bell"></i> Recevoir les notifications par e-mail
              <span class="sub">Être informé des mises à jour et validations</span>
            </div>
            {{-- FIX : la valeur initiale reflète maintenant l'état réel en base, plus de "0" codé en dur --}}
            <input type="hidden" name="notif_email" value="{{ $user->notif_email ? 1 : 0 }}">
            <div class="toggle {{ $user->notif_email ? 'on' : '' }}" onclick="this.classList.toggle('on'); this.previousElementSibling.value = this.classList.contains('on') ? 1 : 0;"></div>
          </div>

          @if ($user->role === 'rh')
            <div class="set-row">
              <div class="set-label">
                <i data-lucide="bell"></i> Nouvelles demandes de congé
                <span class="sub">Être alerté quand un employé soumet une demande</span>
              </div>
              {{-- FIX : idem, valeur initiale = vraie valeur en base --}}
              <input type="hidden" name="notif_demandes" value="{{ $user->notif_demandes ? 1 : 0 }}">
              <div class="toggle {{ $user->notif_demandes ? 'on' : '' }}" onclick="this.classList.toggle('on'); this.previousElementSibling.value = this.classList.contains('on') ? 1 : 0;"></div>
            </div>
            <input type="hidden" name="notif_solde" value="{{ $user->notif_solde ? 1 : 0 }}">
          @else
            <div class="set-row">
              <div class="set-label">
                <i data-lucide="bell"></i> Rappels de solde de congés
                <span class="sub">Recevoir un rappel lorsque votre solde est faible</span>
              </div>
              {{-- FIX : idem, valeur initiale = vraie valeur en base --}}
              <input type="hidden" name="notif_solde" value="{{ $user->notif_solde ? 1 : 0 }}">
              <div class="toggle {{ $user->notif_solde ? 'on' : '' }}" onclick="this.classList.toggle('on'); this.previousElementSibling.value = this.classList.contains('on') ? 1 : 0;"></div>
            </div>
            <input type="hidden" name="notif_demandes" value="{{ $user->notif_demandes ? 1 : 0 }}">
          @endif

          <button type="submit" class="btn-save"><i data-lucide="save" style="width:14px;height:14px;"></i> Enregistrer les modifications</button>
        </form>
      </div>

      <!-- SUPPORT -->
      <div class="panel side-panel">
        <h3><i data-lucide="headphones" style="width:14px;height:14px;"></i> Support</h3>
        <p class="desc">Nous sommes là pour vous aider.</p>

        <div class="support-grid">
          <a href="tel:0539714232" class="support-tile" style="display:block;">
            <div class="tile-ico blue"><i data-lucide="phone" style="width:16px;height:16px;"></i></div>
            <b>Appeler le support</b><span>05 39 71 42 32</span>
            <div class="tile-arrow">→</div>
          </a>
          <a href="mailto:info@naja7host.com?subject=Demande de support" class="support-tile" style="display:block;">
            <div class="tile-ico green"><i data-lucide="mail" style="width:16px;height:16px;"></i></div>
            <b>Envoyer un e-mail</b><span>info@naja7host.com</span>
            <div class="tile-arrow">→</div>
          </a>
          <a href="https://www.google.com/maps/search/?api=1&query=Avenue+Youssef+Ibn+Tachefine+Imm+6+T%C3%A9touan" target="_blank" rel="noopener" class="support-tile" style="display:block;">
            <div class="tile-ico purple"><i data-lucide="map-pin" style="width:16px;height:16px;"></i></div>
            <b>Nous localiser</b><span>Tétouan, 93000</span>
            <div class="tile-arrow">→</div>
          </a>
        </div>

        <div class="sec-label" id="faq-section" style="margin-top:4px;">Questions fréquentes</div>

        @php
          if ($user->role === 'rh') {
            $faqs = [
              ['q' => 'Comment valider ou refuser une demande de congé ?', 'a' => "Depuis \"Validation\" ou \"Congés & Absences\", ouvrez la demande, ajoutez un commentaire si besoin, puis cliquez sur Approuver ou Refuser."],
              ['q' => 'Comment voir le solde de congés d\'un employé ?', 'a' => "Ouvrez la fiche de l'employé depuis \"Employés\" : son solde et son historique y sont affichés."],
              ['q' => 'Comment gérer un conflit d\'équipe (dates qui se chevauchent) ?', 'a' => "Les conflits apparaissent dans le bloc \"Alertes & conflits\" sur la page Congés & Absences, avec le département concerné."],
              ['q' => 'Comment ajouter un nouvel employé ?', 'a' => "Depuis \"Employés\", cliquez sur \"Ajouter un employé\" et remplissez sa fiche (poste, département, solde initial)."],
              ['q' => 'Comment générer un rapport ?', 'a' => "Depuis \"Rapports\", choisissez la période, le département et le format (PDF, Excel, CSV), puis générez."],
            ];
          } else {
            $faqs = [
              ['q' => 'Comment faire une nouvelle demande de congé ?', 'a' => "Cliquez sur \"Nouvelle demande\" dans le menu, choisissez le type de congé, la période et le motif, puis validez. Elle sera envoyée à votre RH."],
              ['q' => 'Comment est calculé mon solde de congés ?', 'a' => "Le solde correspond aux jours acquis selon votre contrat, moins les jours déjà pris ou en attente de validation."],
              ['q' => 'Quels sont les délais de validation ?', 'a' => "Le service RH traite généralement les demandes sous 2 à 5 jours ouvrés."],
              ['q' => 'Comment modifier ou annuler une demande ?', 'a' => "Tant qu'elle n'est pas validée, ouvrez la demande depuis \"Mes demandes\" pour la modifier ou l'annuler."],
            ];
          }
        @endphp

        @foreach ($faqs as $i => $faq)
          <div class="faq-item" onclick="document.getElementById('faq-a-{{ $i }}').style.display = document.getElementById('faq-a-{{ $i }}').style.display === 'block' ? 'none' : 'block'">
            {{ $faq['q'] }} <i data-lucide="chevron-right" style="width:15px;height:15px;"></i>
          </div>
          <div id="faq-a-{{ $i }}" class="faq-ans">{{ $faq['a'] }}</div>
        @endforeach

        <div class="sec-label">Contacter le support</div>
        <div class="contact-row"><i data-lucide="mail"></i> <a href="mailto:info@naja7host.com">info@naja7host.com</a></div>
        <div class="contact-row"><i data-lucide="phone"></i> <a href="tel:0539714232">05 39 71 42 32</a></div>
        <div class="contact-row"><i data-lucide="map-pin"></i> Avenue Youssef Ibn Tachefine, Imm 6, Étage 1, Tétouan 93000</div>
        <div class="contact-row"><i data-lucide="calendar"></i> Lun - Ven : 09:00–18:00 · Sam : 09:00–14:00 · Dim : fermé</div>
      </div>

    </div>

    <div class="footer-note"><i data-lucide="shield" style="width:13px;height:13px;"></i> Vos données sont sécurisées et confidentielles.</div>

  </main>
</div>

<script>
  lucide.createIcons();
  document.querySelectorAll('a[href="#"]').forEach(l => l.addEventListener('click', e => e.preventDefault()));
</script>
</body>
</html>