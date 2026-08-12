<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NAJA7 HOST — Gestion des congés RH</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<style>
  :root{
    --blue:#0EA5E9;
    --blue-dark:#0284C7;
    --blue-deep:#075985;
    --blue-soft:#E6F6FE;
    --green:#22C55E; --green-soft:#E9FBF0;
    --purple:#8B5CF6; --purple-soft:#F3EEFF;
    --orange:#F59E0B; --orange-soft:#FFF4E0;
    --white:#FFFFFF;
    --gray-50:#F8FAFC; --gray-100:#F1F5F9;
    --gray-400:#94A3B8; --gray-600:#64748B; --ink:#0F172A;
    --radius-lg:24px;
    --shadow-soft:0 10px 30px rgba(15,23,42,.06);
    --shadow-card:0 20px 50px rgba(14,165,233,.18);
    --ease:cubic-bezier(.22,1,.36,1);
  }
  *{box-sizing:border-box; margin:0; padding:0;}
  html{scroll-behavior:smooth;}
  body{font-family:'Poppins', sans-serif; color:#E2E8F0; background:#0A1730; -webkit-font-smoothing:antialiased;}
  img{max-width:100%; display:block;}
  a{text-decoration:none; color:inherit;}
  button{font-family:inherit; cursor:pointer; border:none; background:none;}
  .container{max-width:1220px; margin:0 auto; padding:0 28px;}

  header{position:sticky; top:0; z-index:100; background:rgba(10,23,48,.9); backdrop-filter:blur(10px); border-bottom:1px solid rgba(255,255,255,.08);}
  .nav-wrap{display:flex; align-items:center; justify-content:space-between; height:74px;}
  .logo{display:flex; align-items:center; gap:9px; font-weight:700; font-size:15px; color:#fff;}
  .logo-badge{width:34px; height:34px; border-radius:10px; background:linear-gradient(135deg, var(--blue), #7DD3FC); display:flex; align-items:center; justify-content:center; color:#fff;}
  .logo span.brand{color:var(--orange);}
  .logo small{display:block; font-weight:400; font-size:10.5px; color:var(--gray-400);}
  .nav-links{display:flex; gap:30px; position:absolute; left:50%; transform:translateX(-50%);}
  .nav-links a{font-weight:500; font-size:14px; color:#CBD5E1;}
  .nav-links a.active{color:var(--orange); font-weight:600;}

  .btn{display:inline-flex; align-items:center; gap:8px; font-weight:600; font-size:13.5px; padding:10px 22px; border-radius:50px; transition:all .25s var(--ease);}
  .btn-primary{background:var(--blue); color:#fff; box-shadow:0 6px 16px rgba(14,165,233,.3);}
  .btn-primary:hover{background:var(--blue-dark); transform:translateY(-2px);}
  .btn-outline-pill{background:transparent; color:#fff; border:1.5px solid rgba(255,255,255,.35);}
  .btn-outline-pill:hover{background:rgba(255,255,255,.08); border-color:#fff;}

  .page-section{display:none;}
  .page-section.active{display:block; animation:fadeIn .5s var(--ease);}
  @keyframes fadeIn{from{opacity:0; transform:translateY(10px);} to{opacity:1; transform:translateY(0);}}

  /* ===== HERO (pleine largeur, carrousel a droite) ===== */
  .hero-wrap{
    position:relative; overflow:hidden; background:#071426;
  }
  .hero-wave{position:absolute; top:-40px; left:-120px; width:620px; opacity:.35; z-index:0; pointer-events:none;}

  .hero-row{display:flex; align-items:stretch; min-height:560px; position:relative; z-index:1; max-width:1600px; margin:0 auto;}
  .hero-left{flex:0 0 44%; max-width:44%; padding:56px 0 40px 28px; display:flex; flex-direction:column; justify-content:center;}

  .hero-photo{
    flex:1; position:relative; overflow:hidden;
    -webkit-mask-image:linear-gradient(90deg, transparent 0%, black 100%);
    mask-image:linear-gradient(90deg, transparent 0%, black 100%);
  }
  .hero-photo .carousel-slide{position:absolute; inset:0; opacity:0; transform:scale(1); transition:opacity 1.4s ease;}
  .hero-photo .carousel-slide.active{opacity:1; z-index:1; animation:kenburns 6s linear forwards;}
  .hero-photo .carousel-slide img{width:100%; height:100%; object-fit:cover;}
  @keyframes kenburns{from{transform:scale(1);} to{transform:scale(1.12);}}


  .eyebrow{display:inline-flex; align-items:center; gap:8px; background:rgba(56,189,248,.12); color:var(--orange); font-weight:600; font-size:12.5px; padding:7px 16px; border-radius:50px; margin-bottom:16px; width:fit-content;}
  .eyebrow i{width:13px; height:13px;}
  .hero-left h1{font-size:48px; font-weight:700; line-height:1.2; margin-bottom:14px; color:#fff;}
  .hero-left h1 span{color:var(--orange);}
  .hero-left p.lead{color:#94A3B8; font-size:14.5px; line-height:1.7; margin-bottom:24px; max-width:420px;}

  .feature-list{display:grid; grid-template-columns:1fr 1fr; gap:18px 24px; max-width:440px; margin-bottom:26px;}
  .feature-item{display:flex; gap:10px;}
  .feature-item .ico{width:34px; height:34px; border-radius:10px; flex:none; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 12px rgba(0,0,0,.3);}
  .feature-item b{display:block; font-size:13.5px; font-weight:600; color:#fff;}
  .feature-item span{font-size:11.5px; color:#94A3B8;}
  .ico-blue{background:#38BDF8; color:#0C4A6E;}
  .ico-green{background:#4ADE80; color:#14532D;}
  .ico-purple{background:#A78BFA; color:#3B0764;}
  .ico-orange{background:#FBBF24; color:#78350F;}

  .signup-row{
    display:flex; align-items:center; justify-content:space-between; gap:16px;
    background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.1); border-radius:16px; padding:16px 20px; max-width:460px;
  }
  .signup-row p{font-size:12.5px; color:#CBD5E1; font-weight:500; max-width:230px;}

  /* ===== STATS ===== */
  .stats{max-width:1220px; margin:0 auto; padding:0 28px;}
  .stats-inner{background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.1); border-radius:var(--radius-lg); padding:28px 36px; margin-top:-40px; position:relative; z-index:3; display:grid; grid-template-columns:repeat(4,1fr); gap:18px; text-align:center; backdrop-filter:blur(10px);}
  .stat .ico{width:36px; height:36px; border-radius:11px; margin:0 auto 8px; display:flex; align-items:center; justify-content:center;}
  .stat b{display:block; font-size:20px; font-weight:700; color:var(--orange);}
  .stat span{color:#94A3B8; font-size:12px;}

  .home-spacer{height:70px;}

  /* ===== FEATURES PAGE ===== */
  .page-title{text-align:center; margin:44px 0 46px;}
  .page-title h1{font-size:30px; font-weight:700; margin-bottom:8px; color:#fff;}
  .page-title p{color:#94A3B8; font-size:14.5px;}
  .feat-layout{display:grid; grid-template-columns:0.9fr 1.1fr; gap:40px; align-items:start; padding-bottom:80px;}
  .feat-layout img{border-radius:var(--radius-lg); box-shadow:0 20px 50px rgba(0,0,0,.35); width:100%; height:100%; object-fit:cover;}
  .feat-cards{display:grid; grid-template-columns:1fr 1fr; gap:16px;}
  .feat-card{background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.1); border-radius:16px; padding:20px; transition:transform .25s var(--ease), box-shadow .25s var(--ease), border-color .25s;}
  .feat-card:hover{transform:translateY(-4px); box-shadow:0 20px 40px rgba(0,0,0,.3); border-color:#38BDF8;}
  .feat-card .ico{width:34px; height:34px; border-radius:10px; display:flex; align-items:center; justify-content:center; margin-bottom:10px;}
  .feat-card h3{font-size:14.5px; font-weight:700; margin-bottom:4px; color:#fff;}
  .feat-card p{font-size:12.5px; color:#94A3B8; line-height:1.55;}

  /* ===== CONTACT ===== */
  .contact-dark{
    background:#0A1730;
    padding:56px 0 60px;
  }
  .contact-flex{display:flex; gap:60px; align-items:stretch; position:relative; min-height:340px; max-width:1000px; margin:0 auto;}

  .contact-photo-card{
    position:relative; flex:1.25; border-radius:28px; overflow:hidden;
    box-shadow:0 30px 60px rgba(0,0,0,.4);
  }
  .contact-photo-card img{position:absolute; inset:0; width:100%; height:100%; object-fit:cover;}
  .photo-overlay{position:absolute; inset:0; background:linear-gradient(90deg, rgba(6,15,35,.88) 0%, rgba(6,15,35,.55) 32%, rgba(6,15,35,.1) 60%), linear-gradient(0deg, rgba(6,15,35,.7) 0%, transparent 30%);}
  .photo-caption{position:relative; z-index:2; height:100%; display:flex; flex-direction:column; justify-content:space-between; padding:34px;}
  .photo-caption h1{color:#fff; font-size:28px; font-weight:700; line-height:1.25; max-width:340px;}
  .photo-caption h1 span{color:var(--orange);}
  .photo-caption p{color:#CBD5E1; font-size:14.5px; line-height:1.7; max-width:320px; margin-top:16px;}
  .caption-rule{width:32px; height:3px; background:var(--blue); border-radius:3px; margin-top:22px;}
  .contact-socials{display:flex; gap:12px;}
  .contact-socials a{
    width:38px; height:38px; border-radius:50%; background:rgba(15,23,42,.55); border:1px solid rgba(255,255,255,.15);
    display:flex; align-items:center; justify-content:center; color:#fff; transition:background .25s, transform .25s;
  }
  .contact-socials a:hover{background:var(--blue); transform:translateY(-3px);}

  .contact-connector{
    flex:none; align-self:center; z-index:5;
    width:60px; height:60px; border-radius:50%; background:#fff;
    display:flex; align-items:center; justify-content:center; color:var(--blue-dark);
    box-shadow:0 14px 30px rgba(0,0,0,.3);
  }

  .contact-title{text-align:center; margin-bottom:32px;}
  .contact-title h1{color:#fff; font-size:32px; font-weight:700;}
  .contact-title h1 span{color:var(--orange);}
  .contact-title .caption-rule{margin:14px auto 0;}

  .contact-info-card{
    flex:1; border-radius:28px; padding:36px 34px;
    background:linear-gradient(160deg, #1D4ED8, #1E3A8A);
    box-shadow:0 30px 60px rgba(0,0,0,.4);
    display:flex; flex-direction:column; justify-content:center;
  }
  .info-num-row{display:flex; align-items:flex-start; gap:16px; margin-bottom:34px; position:relative;}
  .info-num-row:last-child{margin-bottom:0;}
  .info-num-row .row-ico{
    width:44px; height:44px; border-radius:50%; background:rgba(255,255,255,.14); flex:none;
    display:flex; align-items:center; justify-content:center; color:#fff;
  }
  .num-badge{
    width:30px; height:30px; border-radius:9px; background:#fff; color:var(--blue-dark);
    font-weight:700; font-size:13px; display:flex; align-items:center; justify-content:center; flex:none;
    position:relative; z-index:2;
  }
  .info-num-row::before{
    content:''; position:absolute; left:66px; top:44px; bottom:-34px; width:2px;
    background:repeating-linear-gradient(to bottom, rgba(255,255,255,.6) 0 4px, transparent 4px 9px);
  }
  .info-num-row:last-child::before{display:none;}
  .info-text b{display:block; color:#fff; font-size:17px; font-weight:700; margin-bottom:3px;}
  .info-text span{color:#BFDBFE; font-size:14px;}

  .guarantee-bar{
    margin-top:26px; border:1px solid rgba(125,211,252,.2); border-radius:22px;
    padding:26px 30px; display:grid; grid-template-columns:repeat(4,1fr); gap:20px;
  }
  .guarantee-item{display:flex; align-items:center; gap:14px;}
  .guarantee-item .g-ico{
    width:42px; height:42px; border-radius:50%; background:var(--blue); flex:none;
    display:flex; align-items:center; justify-content:center; color:#fff;
  }
  .guarantee-item b{display:block; color:#fff; font-size:14px; font-weight:700;}
  .guarantee-item span{color:#94A3B8; font-size:12px;}
  .contact-social-bar .brand-mini{display:flex; align-items:center; gap:10px; color:#fff; font-size:12.5px; font-weight:600;}
  .contact-social-bar .brand-mini .logo-badge{width:28px; height:28px; font-size:11px;}
  .contact-social-bar .socials{display:flex; align-items:center; gap:14px;}
  .contact-social-bar .socials a{color:#7DD3FC;}
  .contact-social-bar .phone{color:#fff; font-weight:600; font-size:13px; display:flex; align-items:center; gap:8px;}

  footer{border-top:1px solid rgba(255,255,255,.08); padding:24px 0; text-align:center; color:#64748B; font-size:13px; background:#0A1730;}

  /* ===== MODAL (fidele a la reference, transparent) ===== */
  .modal-overlay{position:fixed; inset:0; z-index:1000; background:rgba(7,89,133,.45); backdrop-filter:blur(6px); display:none; align-items:center; justify-content:center; opacity:0; transition:opacity .3s var(--ease);}
  .modal-overlay.open{display:flex;}
  .modal-overlay.show{opacity:1;}
  .modal-card{
    width:100%; max-width:340px; margin:20px;
    background:rgba(255,255,255,.55); backdrop-filter:blur(18px); -webkit-backdrop-filter:blur(18px);
    border:1px solid rgba(255,255,255,.6);
    border-radius:26px; box-shadow:0 30px 70px rgba(2,50,80,.35);
    padding:30px 28px; position:relative; text-align:center;
    opacity:0; transform:translateY(-24px); transition:all .4s var(--ease);
  }
  .modal-overlay.show .modal-card{opacity:1; transform:translateY(0);}
  .modal-close{position:absolute; top:14px; right:14px; width:28px; height:28px; border-radius:50%; background:rgba(255,255,255,.7); display:flex; align-items:center; justify-content:center;}
  .modal-icon{width:52px; height:52px; border-radius:50%; margin:0 auto 14px; background:var(--blue); display:flex; align-items:center; justify-content:center; color:#fff; box-shadow:0 8px 20px rgba(14,165,233,.4);}
  .modal-card h2{font-size:18px; font-weight:700; margin-bottom:3px;}
  .modal-card > p.sub{color:#475569; font-weight:600; font-size:12.5px; margin-bottom:20px;}
  .field{margin-bottom:14px; text-align:left;}
  .field label{display:block; font-size:12px; font-weight:700; margin-bottom:6px; color:#334155;}
  .field .input-wrap{position:relative;}
  .field input{width:100%; padding:10px 38px 10px 13px; border-radius:12px; border:1.5px solid rgba(148,163,184,.4); background:rgba(255,255,255,.7); font-family:inherit; font-size:13.5px; outline:none; transition:border-color .25s;}
  .field input:focus{border-color:var(--blue); box-shadow:0 0 0 3px rgba(14,165,233,.15);}
  .field .field-ico{position:absolute; right:12px; top:50%; transform:translateY(-50%); color:var(--gray-400); width:16px; height:16px;}
  .modal-row-between{display:flex; align-items:center; justify-content:space-between; margin:4px 0 18px; font-size:11.5px;}
  .remember{display:flex; align-items:center; gap:6px; color:#334155; font-weight:600;}
  .modal-row-between a{color:var(--blue-dark); font-weight:500;}
  .divider-text{font-size:11px; color:var(--gray-400); margin:14px 0 10px;}
  .modal-options{display:flex; gap:8px; margin-bottom:14px;}
  .modal-options button{flex:1; padding:9px; border-radius:12px; border:1.5px solid rgba(148,163,184,.35); font-size:12px; font-weight:600; background:rgba(255,255,255,.6); display:flex; align-items:center; justify-content:center; gap:6px;}
  .modal-options button.active{border-color:var(--blue); color:var(--blue-dark); background:var(--blue-soft);}
  .legal-text{font-size:10.5px; color:var(--gray-400); line-height:1.5;}
  .legal-text a{color:var(--blue-dark); font-weight:500;}

  @media (max-width:900px){
    .nav-links{display:none;}
    .hero-row{flex-direction:column; min-height:auto;}
    .hero-left{flex:none; max-width:100%; padding:32px 0;}
    .hero-photo{height:260px; -webkit-mask-image:none; mask-image:none;}
    .stats-inner{grid-template-columns:1fr 1fr; margin-top:20px;}
    .feat-layout{grid-template-columns:1fr;}
    .contact-flex{flex-direction:column;}
    .contact-connector{display:none;}
    .guarantee-bar{grid-template-columns:1fr 1fr;}
  }
</style>
</head>
<body>

<header id="siteHeader">
  <div class="container nav-wrap">
    <a href="#" class="logo" data-nav="accueil">
      <img src="https://tse2.mm.bing.net/th/id/OIP.EOrKpTJ8eXtGHR5zXxfQ1wAAAA?r=0&pid=Api&h=220&P=0" alt="Naja7host" style="width:36px;height:36px;border-radius:10px;object-fit:cover;">
      <span><span class="brand">NAJA7</span>HOST<br><small>Hébergement &amp; développement web</small></span>
    </a>
    <nav class="nav-links">
      <a href="#" data-nav="accueil" class="active">Accueil</a>
      <a href="#" data-nav="fonctionnalites">Fonctionnalités</a>
      <a href="#" data-nav="contact">Contact</a>
    </nav>
    <button class="btn btn-outline-pill" id="openLogin">Se connecter</button>
  </div>
</header>

<!-- ACCUEIL -->
<section class="page-section active" id="page-accueil">

  <div class="hero-wrap">
    <svg class="hero-wave" viewBox="0 0 600 400" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M20 300C120 200 180 350 280 260C380 170 420 320 520 240" stroke="#7DD3FC" stroke-width="2" stroke-dasharray="6 8"/>
      <path d="M0 120C100 60 160 180 260 110C360 40 430 160 600 90" stroke="#BAE6FD" stroke-width="2" stroke-dasharray="6 8"/>
      <circle cx="80" cy="90" r="4" fill="#7DD3FC"/>
      <circle cx="480" cy="260" r="4" fill="#BAE6FD"/>
    </svg>

    <div class="hero-row">
      <div class="hero-left">
        <h1>Gérez les congés <span>en toute simplicité</span></h1>

        <div class="feature-list">
          <div class="feature-item"><span class="ico ico-blue"><i data-lucide="calendar" style="width:18px;height:18px;" stroke-width="2.5"></i></span><div><b>Demandes faciles</b><span>Soumettez vos congés en quelques clics.</span></div></div>
          <div class="feature-item"><span class="ico ico-green"><i data-lucide="check" style="width:18px;height:18px;" stroke-width="2.5"></i></span><div><b>Validation rapide</b><span>Les RH approuvent en un instant.</span></div></div>
          <div class="feature-item"><span class="ico ico-purple"><i data-lucide="bar-chart-2" style="width:18px;height:18px;" stroke-width="2.5"></i></span><div><b>Suivi en temps réel</b><span>Consultez vos soldes à tout moment.</span></div></div>
          <div class="feature-item"><span class="ico ico-orange"><i data-lucide="calendar-days" style="width:18px;height:18px;" stroke-width="2.5"></i></span><div><b>Calendrier d'équipe</b><span>Visualisez les absences de l'équipe.</span></div></div>
        </div>

        <div class="signup-row">
          <p>Nouveau ici ? Créez votre compte et rejoignez votre équipe dès maintenant.</p>
          <button type="button" class="btn btn-primary" id="openRegisterCta">S'inscrire</button>
        </div>
      </div>

      <div class="hero-photo" id="heroCarousel">
        <!-- Remplace ces src par tes propres photos (5 images) -->
        <div class="carousel-slide active"><img src="https://i.pinimg.com/1200x/fd/96/24/fd9624ae8ebf666a6661ff666fa06c45.jpg" alt="Équipe au bureau"></div>
        <div class="carousel-slide"><img src="https://i.pinimg.com/1200x/c0/52/2a/c0522a131f97abd86fc6cde6a9c2cbe1.jpg" alt="Réunion RH"></div>
        <div class="carousel-slide"><img src="https://i.pinimg.com/736x/cf/f5/e1/cff5e1cba8964bcaeaee87cf0eaecb59.jpg" alt="Collaborateurs"></div>
        <div class="carousel-slide"><img src="https://i.pinimg.com/736x/d1/ea/3b/d1ea3be913e240fb7d89c742703b96e0.jpg" alt="Ordinateur et planning"></div>
        <div class="carousel-slide"><img src="https://i.pinimg.com/736x/d1/bc/5d/d1bc5d90a161cb0a1fb37023203b1f25.jpg" alt="Équipe en réunion"></div>
      </div>
    </div>
  </div>

  <div class="home-spacer"></div>
</section>

<!-- FONCTIONNALITES (inchange) -->
<section class="page-section" id="page-fonctionnalites">
  <div class="container">
    <div class="page-title">
      <h1>Fonctionnalités</h1>
      <p>Tout ce qu'il vous faut pour une gestion des congés efficace</p>
    </div>
    <div class="feat-layout">
      <img src="https://i.pinimg.com/736x/f9/da/44/f9da4483b5b731dd7e1235a511915acb.jpg" alt="Équipe en réunion">
      <div class="feat-cards">
        <div class="feat-card"><span class="ico ico-blue"><i data-lucide="calendar" style="width:16px;height:16px;"></i></span><h3>Demandes de congé</h3><p>Soumettez et suivez vos congés en quelques clics.</p></div>
        <div class="feat-card"><span class="ico ico-green"><i data-lucide="check-circle" style="width:16px;height:16px;"></i></span><h3>Validation rapide</h3><p>Les RH approuvent ou refusent instantanément.</p></div>
        <div class="feat-card"><span class="ico ico-purple"><i data-lucide="calendar-days" style="width:16px;height:16px;"></i></span><h3>Calendrier d'équipe</h3><p>Visualisez les absences de toute l'équipe.</p></div>
        <div class="feat-card"><span class="ico ico-blue"><i data-lucide="bar-chart-2" style="width:16px;height:16px;"></i></span><h3>Suivi des soldes</h3><p>Consultez vos soldes de congés à tout moment.</p></div>
        <div class="feat-card"><span class="ico ico-orange"><i data-lucide="bell" style="width:16px;height:16px;"></i></span><h3>Notifications</h3><p>Restez informé à chaque étape de la demande.</p></div>
        <div class="feat-card"><span class="ico ico-green"><i data-lucide="file-text" style="width:16px;height:16px;"></i></span><h3>Export &amp; Rapports</h3><p>Générez des rapports PDF de l'historique.</p></div>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT (fond fonce + carte numerotee) -->
<section class="page-section" id="page-contact">
  <div class="contact-dark">
    <div class="container">

      <div class="contact-title">
        <h1>Nous sommes <span>à votre écoute</span></h1>
        <div class="caption-rule"></div>
      </div>

      <div class="contact-flex">
        <div class="contact-photo-card">
          <img src="https://i.pinimg.com/1200x/13/8f/b7/138fb764a994b10a7e20c3e871c438ba.jpg" alt="Équipe support Naja7 Host">
          <div class="photo-overlay"></div>
          <div class="photo-caption">
            <div></div>
            <div class="contact-socials">
              <a href="#"><i data-lucide="linkedin" style="width:16px;height:16px;"></i></a>
              <a href="#"><i data-lucide="instagram" style="width:16px;height:16px;"></i></a>
              <a href="#"><i data-lucide="facebook" style="width:16px;height:16px;"></i></a>
              <a href="#"><i data-lucide="twitter" style="width:16px;height:16px;"></i></a>
            </div>
          </div>
        </div>

        <div class="contact-connector"><i data-lucide="arrow-right" style="width:24px;height:24px;"></i></div>

        <div class="contact-info-card">
          <div class="info-num-row">
            <span class="row-ico"><i data-lucide="phone" style="width:18px;height:18px;"></i></span>
            <span class="num-badge">1</span>
            <div class="info-text"><b>Téléphone</b><span>05 39 71 42 32</span></div>
          </div>
          <div class="info-num-row">
            <span class="row-ico"><i data-lucide="mail" style="width:18px;height:18px;"></i></span>
            <span class="num-badge">2</span>
            <div class="info-text"><b>Email</b><span>info@naja7host.com</span></div>
          </div>
          <div class="info-num-row">
            <span class="row-ico"><i data-lucide="map-pin" style="width:18px;height:18px;"></i></span>
            <span class="num-badge">3</span>
            <div class="info-text"><b>Adresse</b><span><a href="https://www.google.com/maps/search/?api=1&query=Av.+Hassan+II+Challal+Center+Tétouan" target="_blank" rel="noopener" style="color:inherit; text-decoration:underline;">Av. Hassan II, Challal Center, étg 4, N°20, Tétouan</a></span></div>
          </div>
        </div>
      </div>

      <div class="guarantee-bar">
        <div class="guarantee-item"><span class="g-ico"><i data-lucide="shield-check" style="width:18px;height:18px;"></i></span><div><b>Sécurisé</b><span>Données protégées</span></div></div>
        <div class="guarantee-item"><span class="g-ico"><i data-lucide="clock" style="width:18px;height:18px;"></i></span><div><b>Disponible 24/7</b><span>Toujours là pour vous</span></div></div>
        <div class="guarantee-item"><span class="g-ico"><i data-lucide="users" style="width:18px;height:18px;"></i></span><div><b>Équipe réactive</b><span>Réponse rapide garantie</span></div></div>
        <div class="guarantee-item"><span class="g-ico"><i data-lucide="lock" style="width:18px;height:18px;"></i></span><div><b>Confidentialité</b><span>Respect &amp; protection</span></div></div>
      </div>

    </div>
  </div>
</section>

<footer>&copy; 2026 Naja7host — Hébergement &amp; développement web — Tous droits réservés</footer>

<!-- MODAL CONNEXION -->
<div class="modal-overlay" id="loginModal">
  <div class="modal-card">
    <button class="modal-close" id="closeLoginModal"><i data-lucide="x" style="width:14px;height:14px;"></i></button>
    <div class="modal-icon"><i data-lucide="shield" style="width:22px;height:22px;"></i></div>
    <h2>Connexion à votre compte</h2>
    <p class="sub">Accédez à votre espace personnel</p>

    @if ($errors->any() && !old('name'))
      <div style="background:#FEE2E2; color:#991B1B; font-size:12.5px; font-weight:600; padding:10px 14px; border-radius:10px; margin-bottom:16px; text-align:left;">
        @foreach ($errors->all() as $error)
          {{ $error }}
        @endforeach
      </div>
    @endif

    <form id="loginForm" method="POST" action="{{ route('login') }}">
      @csrf
      <div class="field">
        <label>Email</label>
        <div class="input-wrap">
          <input type="email" name="email" placeholder="exemple@entreprise.com" required>
          <i data-lucide="mail" class="field-ico"></i>
        </div>
      </div>
      <div class="field">
        <label>Mot de passe</label>
        <div class="input-wrap">
          <input type="password" name="password" id="loginPassword" placeholder="Votre mot de passe" required>
          <i data-lucide="eye" class="field-ico" id="togglePassword" style="cursor:pointer;"></i>
        </div>
      </div>

      <div class="modal-row-between">
        <label class="remember"><input type="checkbox" name="remember"> Se souvenir de moi</label>
        <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center;">Se connecter</button>
    </form>

    <p class="divider-text">Pas encore de compte ?</p>
    <button type="button" class="btn btn-outline-pill" id="switchToRegister" style="width:100%; justify-content:center; color:#075985; border-color:rgba(7,89,133,.35); margin-bottom:14px;">Créer un compte</button>

    <p class="legal-text">En vous connectant, vous acceptez nos <a href="#">Conditions d'utilisation</a> et <a href="#">Politique de confidentialité</a>.</p>
  </div>
</div>

<!-- MODAL INSCRIPTION -->
<div class="modal-overlay" id="registerModal">
  <div class="modal-card" style="max-width:380px;">
    <button class="modal-close" id="closeRegisterModal"><i data-lucide="x" style="width:14px;height:14px;"></i></button>
    <div class="modal-icon"><i data-lucide="user-plus" style="width:22px;height:22px;"></i></div>
    <h2>Créer votre compte</h2>
    <p class="sub">Rejoignez NAJA7HOST et simplifiez la gestion des congés</p>

    @if ($errors->any() && old('name'))
      <div style="background:#FEE2E2; color:#991B1B; font-size:12.5px; font-weight:600; padding:10px 14px; border-radius:10px; margin-bottom:16px; text-align:left;">
        @foreach ($errors->all() as $error)
          {{ $error }}
        @endforeach
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
      @csrf
      <div class="field">
        <label>Nom complet</label>
        <div class="input-wrap">
          <input type="text" name="name" value="{{ old('name') }}" placeholder="Entrez votre nom complet" required>
          <i data-lucide="user" class="field-ico"></i>
        </div>
      </div>
      <div class="field">
        <label>Email professionnel</label>
        <div class="input-wrap">
          <input type="email" name="email" value="{{ old('email') }}" placeholder="Entrez votre email professionnel" required>
          <i data-lucide="mail" class="field-ico"></i>
        </div>
      </div>
      <div class="field">
        <label>Mot de passe</label>
        <div class="input-wrap">
          <input type="password" name="password" id="registerPassword" placeholder="Créez un mot de passe" required>
          <i data-lucide="eye" class="field-ico" id="toggleRegisterPassword" style="cursor:pointer;"></i>
        </div>
      </div>
      <div class="field">
        <label>Confirmer le mot de passe</label>
        <div class="input-wrap">
          <input type="password" name="password_confirmation" id="registerPasswordConfirm" placeholder="Confirmez votre mot de passe" required>
          <i data-lucide="eye" class="field-ico" id="toggleRegisterPasswordConfirm" style="cursor:pointer;"></i>
        </div>
      </div>

      <div class="field">
        <label>Vous êtes</label>
        <div class="modal-options" style="margin-top:6px;">
          <label style="flex:1; cursor:pointer;">
            <input type="radio" name="role" value="employe" {{ old('role', 'employe') === 'employe' ? 'checked' : '' }} style="display:none;" class="role-radio">
            <div class="role-choice active" data-role="employe">
              <i data-lucide="user" style="width:14px;height:14px;"></i> Employé
            </div>
          </label>
          <label style="flex:1; cursor:pointer;">
            <input type="radio" name="role" value="rh" {{ old('role') === 'rh' ? 'checked' : '' }} style="display:none;" class="role-radio">
            <div class="role-choice" data-role="rh">
              <i data-lucide="user-check" style="width:14px;height:14px;"></i> Responsable RH
            </div>
          </label>
        </div>
        @error('role') <div style="color:#DC2626; font-size:11px; margin-top:4px;">{{ $message }}</div> @enderror
      </div>

      <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; margin-top:14px;">S'inscrire</button>
    </form>

    <p class="divider-text">Vous avez déjà un compte ?</p>
    <button type="button" class="btn btn-outline-pill" id="switchToLogin" style="width:100%; justify-content:center; color:#075985; border-color:rgba(7,89,133,.35);">Se connecter</button>
  </div>
</div>

<script>
  lucide.createIcons();
  const navLinks = document.querySelectorAll('[data-nav]');
  const sections = document.querySelectorAll('.page-section');
  function goTo(t){
    sections.forEach(s => s.classList.toggle('active', s.id === 'page-' + t));
    document.querySelectorAll('.nav-links a').forEach(a => a.classList.toggle('active', a.dataset.nav === t));
    window.scrollTo({top:0, behavior:'smooth'});
  }
  navLinks.forEach(el => el.addEventListener('click', e => { e.preventDefault(); goTo(el.dataset.nav); }));

  const slides = document.querySelectorAll('#heroCarousel .carousel-slide');
  let current = 0;
  function showSlide(i){ slides[current].classList.remove('active'); current = (i + slides.length) % slides.length; slides[current].classList.add('active'); }
  setInterval(() => showSlide(current + 1), 5000);

  const toggleBtn = document.getElementById('togglePassword');
  const pwdInput = document.getElementById('loginPassword');
  toggleBtn.addEventListener('click', () => { pwdInput.type = pwdInput.type === 'text' ? 'password' : 'text'; });

  document.getElementById('toggleRegisterPassword').addEventListener('click', () => {
    const i = document.getElementById('registerPassword');
    i.type = i.type === 'text' ? 'password' : 'text';
  });
  document.getElementById('toggleRegisterPasswordConfirm').addEventListener('click', () => {
    const i = document.getElementById('registerPasswordConfirm');
    i.type = i.type === 'text' ? 'password' : 'text';
  });

  // Choix du rôle (visuel)
  document.querySelectorAll('.role-radio').forEach(radio => {
    radio.addEventListener('change', () => {
      document.querySelectorAll('.role-choice').forEach(c => c.classList.remove('active'));
      document.querySelector(`.role-choice[data-role="${radio.value}"]`).classList.add('active');
    });
  });

  // ===== Ouverture / fermeture des 2 modales =====
  const loginModal = document.getElementById('loginModal');
  const registerModal = document.getElementById('registerModal');

  function openLoginModal(){ registerModal.classList.remove('open','show'); loginModal.classList.add('open'); requestAnimationFrame(() => loginModal.classList.add('show')); }
  function openRegisterModal(){ loginModal.classList.remove('open','show'); registerModal.classList.add('open'); requestAnimationFrame(() => registerModal.classList.add('show')); }
  function closeModals(){
    loginModal.classList.remove('show'); registerModal.classList.remove('show');
    setTimeout(() => { loginModal.classList.remove('open'); registerModal.classList.remove('open'); }, 300);
  }

  @if ($errors->any())
    @if (old('name'))
      openRegisterModal();
    @else
      openLoginModal();
    @endif
  @endif

  document.getElementById('openLogin').addEventListener('click', openLoginModal);
  document.getElementById('openRegisterCta').addEventListener('click', openRegisterModal);
  document.getElementById('switchToRegister').addEventListener('click', openRegisterModal);
  document.getElementById('switchToLogin').addEventListener('click', openLoginModal);
  document.getElementById('closeLoginModal').addEventListener('click', closeModals);
  document.getElementById('closeRegisterModal').addEventListener('click', closeModals);
  loginModal.addEventListener('click', e => { if(e.target === loginModal) closeModals(); });
  registerModal.addEventListener('click', e => { if(e.target === registerModal) closeModals(); });
  document.addEventListener('keydown', e => { if(e.key === 'Escape') closeModals(); });
</script>

<style>
  .role-choice{display:flex; align-items:center; justify-content:center; gap:6px; padding:9px; border-radius:12px; border:1.5px solid rgba(148,163,184,.35); font-size:12px; font-weight:600; background:rgba(255,255,255,.6); color:#334155;}
  .role-choice.active{border-color:#0EA5E9; color:#0284C7; background:#E6F6FE;}
</style>
</body>
</html>