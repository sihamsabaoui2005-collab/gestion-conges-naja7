<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ajouter un employé — NAJA7 HOST</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
<style>
  :root{
    --blue:#3B82F6; --blue-2:#60A5FA;
    --orange:#F59E0B; --green:#10B981; --red:#EF4444; --purple:#8B5CF6;
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
  .side-bottom{display:flex; flex-direction:column; gap:4px; padding-top:8px; margin-top:6px; border-top:1px solid var(--border); align-items:center; flex:none;}

  .main{flex:1; align-self:stretch; padding:6px 6px 40px; max-width:900px; margin:0 auto; overflow-x:hidden;}

  .back-link{
    display:inline-flex; align-items:center; gap:7px; font-size:13.5px; font-weight:700; color:#fff;
    margin-bottom:16px; padding:9px 18px; border-radius:11px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);
  }
  .back-link:hover{filter:brightness(1.1);}

  .header{margin-bottom:22px;}
  .header h1{font-size:27px; font-weight:800; color:#fff;}
  .header p{color:var(--text-dim); font-size:15px; margin-top:4px;}

  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25); padding:26px;}

  .section-title{font-size:15px; font-weight:700; color:#fff; margin:22px 0 14px; display:flex; align-items:center; gap:7px;}
  .section-title:first-child{margin-top:0;}

  .grid-2{display:grid; grid-template-columns:1fr 1fr; gap:14px;}
  .grid-3{display:grid; grid-template-columns:1fr 1fr 1fr; gap:14px;}
  @media (max-width:700px){ .grid-2, .grid-3{grid-template-columns:1fr;} }

  .champ label{display:block; font-size:13.5px; color:var(--text-dim); margin-bottom:6px;}
  .champ input, .champ select, .champ textarea{width:100%; background:#141b30; border:1px solid var(--border); border-radius:10px; padding:12px 13px; color:#fff; font-size:14.5px; outline:none;}
  .champ input::placeholder, .champ textarea::placeholder{color:var(--text-dim);}
  .champ{margin-bottom:14px;}
  .err{font-size:12.5px; color:var(--red); margin-top:5px;}

  /* ===== Aperçu photo façon avatar gris ===== */
  .photo-upload{display:flex; align-items:center; gap:16px; margin-bottom:18px;}
  .photo-preview{
    width:84px; height:84px; border-radius:50%; flex:none; overflow:hidden;
    background:#E5E7EB; display:flex; align-items:center; justify-content:center; position:relative;
  }
  .photo-preview img{width:100%; height:100%; object-fit:cover;}
  .photo-preview svg{width:100%; height:100%;}
  .btn-photo{
    display:inline-flex; align-items:center; gap:7px; font-size:13.5px; font-weight:700; color:#fff;
    padding:11px 20px; border-radius:11px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);
    cursor:pointer;
  }
  .btn-photo:hover{filter:brightness(1.1);}

  .form-actions{display:flex; align-items:center; justify-content:flex-end; gap:12px; margin-top:24px;}
  .btn-annuler{background:var(--panel-2); border:1px solid var(--border); color:var(--text-dim); font-size:14.5px; font-weight:600; padding:12px 24px; border-radius:11px;}
  .btn-soumettre{display:inline-flex; align-items:center; gap:8px; font-size:14.5px; font-weight:700; color:#fff; padding:12px 24px; border-radius:11px;
    background: radial-gradient(130% 200% at 30% -30%, rgba(255,255,255,.3), rgba(255,255,255,0) 45%), linear-gradient(160deg, #F59E0B, #C2410C 75%);
    box-shadow:0 6px 16px rgba(194,65,12,.4), inset 0 1px 0 rgba(255,255,255,.25);}
  .btn-soumettre:hover, .btn-annuler:hover{filter:brightness(1.1);}

  @media (max-width:800px){ .sidebar{display:none;} }
</style>
</head>
<body>

<div class="app">

  @include('partials.sidebar')

  <main class="main">

    <a href="{{ route('employes.index') }}" class="back-link"><i data-lucide="arrow-left" style="width:14px;height:14px;"></i> Retour aux employés</a>

    <div class="header">
      <h1>Ajouter un employé</h1>
      <p>Crée un nouveau compte employé et renseigne ses informations.</p>
    </div>

    <div class="panel">
      <form method="POST" action="{{ route('employes.store') }}" enctype="multipart/form-data">
        @csrf

        <div class="photo-upload">
          <label class="photo-preview" id="photoPreviewLabel">
            <svg viewBox="0 0 84 84" xmlns="http://www.w3.org/2000/svg">
              <circle cx="42" cy="42" r="42" fill="#E5E7EB"/>
              <circle cx="42" cy="32" r="14" fill="#9CA3AF"/>
              <path d="M12 78c2-18 16-28 30-28s28 10 30 28" fill="#9CA3AF"/>
            </svg>
          </label>
          <div>
            <label class="btn-photo" for="photoInput"><i data-lucide="camera" style="width:15px;height:15px;"></i> Choisir une photo</label>
            <input type="file" id="photoInput" name="photo" accept="image/*" style="display:none;">
            <div style="font-size:12px; color:var(--text-dim); margin-top:7px;">JPG, PNG (max. 3 Mo) — optionnel</div>
          </div>
        </div>
        @error('photo') <div class="err">{{ $message }}</div> @enderror

        <div class="section-title"><i data-lucide="user" style="width:15px;height:15px; color:var(--orange);"></i> Identité & connexion</div>
        <div class="grid-2">
          <div class="champ">
            <label>Nom complet *</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Ex. Sara El Amrani" required>
            @error('name') <div class="err">{{ $message }}</div> @enderror
          </div>
          <div class="champ">
            <label>Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="moussa.kariam@gmail.com" required>
            @error('email') <div class="err">{{ $message }}</div> @enderror
          </div>
        </div>
        <div class="grid-2">
          <div class="champ">
            <label>Mot de passe *</label>
            <input type="password" name="password" placeholder="8 caractères minimum" required minlength="8">
            @error('password') <div class="err">{{ $message }}</div> @enderror
          </div>
          <div class="champ">
            <label>Rôle *</label>
            <select name="role" required>
              <option value="employe" @selected(old('role', 'employe') === 'employe')>Employé</option>
              <option value="rh" @selected(old('role') === 'rh')>Responsable RH</option>
            </select>
            @error('role') <div class="err">{{ $message }}</div> @enderror
          </div>
        </div>

        <div class="section-title"><i data-lucide="briefcase" style="width:15px;height:15px; color:var(--orange);"></i> Poste & équipe</div>
        <div class="grid-2">
          <div class="champ">
            <label>Poste</label>
            <input type="text" name="poste" value="{{ old('poste') }}" placeholder="Ex. Développeur">
            @error('poste') <div class="err">{{ $message }}</div> @enderror
          </div>
          <div class="champ">
            <label>Département</label>
            <input type="text" name="departement" value="{{ old('departement') }}" list="departementsExistants" placeholder="Ex. Développement">
            <datalist id="departementsExistants">
              @foreach ($departements as $dep)
                <option value="{{ $dep }}">
              @endforeach
            </datalist>
            @error('departement') <div class="err">{{ $message }}</div> @enderror
          </div>
        </div>
        <div class="champ" style="max-width:220px;">
          <label>Solde de congés annuel (jours)</label>
          <input type="number" name="solde_conges_annuel" value="{{ old('solde_conges_annuel', 21) }}" min="0">
          @error('solde_conges_annuel') <div class="err">{{ $message }}</div> @enderror
        </div>

        <div class="section-title"><i data-lucide="id-card" style="width:15px;height:15px; color:var(--orange);"></i> Informations personnelles <span style="font-weight:400; color:var(--text-dim); font-size:12.5px;">(optionnel)</span></div>
        <div class="grid-3">
          <div class="champ">
            <label>Téléphone</label>
            <input type="text" name="telephone" value="{{ old('telephone') }}">
          </div>
          <div class="champ">
            <label>Date de naissance</label>
            <input type="date" name="date_naissance" value="{{ old('date_naissance') }}">
          </div>
          <div class="champ">
            <label>Lieu de naissance</label>
            <input type="text" name="lieu_naissance" value="{{ old('lieu_naissance') }}">
          </div>
        </div>
        <div class="grid-3">
          <div class="champ">
            <label>Nationalité</label>
            <input type="text" name="nationalite" value="{{ old('nationalite') }}">
          </div>
          <div class="champ">
            <label>CIN</label>
            <input type="text" name="cin" value="{{ old('cin') }}">
          </div>
          <div class="champ">
            <label>Situation familiale</label>
            <input type="text" name="situation_familiale" value="{{ old('situation_familiale') }}" placeholder="Ex. Célibataire">
          </div>
        </div>
        <div class="champ">
          <label>Adresse</label>
          <textarea name="adresse" rows="2">{{ old('adresse') }}</textarea>
        </div>

        <div class="form-actions">
          <a href="{{ route('employes.index') }}" class="btn-annuler">Annuler</a>
          <button type="submit" class="btn-soumettre"><i data-lucide="user-plus" style="width:15px;height:15px;"></i> Ajouter l'employé</button>
        </div>
      </form>
    </div>

  </main>
</div>

<script>
  lucide.createIcons();

  const photoInput = document.getElementById('photoInput');
  const photoPreviewLabel = document.getElementById('photoPreviewLabel');
  photoInput.addEventListener('change', () => {
    const fichier = photoInput.files[0];
    if (!fichier) return;
    const url = URL.createObjectURL(fichier);
    photoPreviewLabel.innerHTML = `<img src="${url}" alt="">`;
  });
</script>
</body>
</html>