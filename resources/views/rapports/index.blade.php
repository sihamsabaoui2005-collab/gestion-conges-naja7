<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rapports — NAJA7 HOST</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://unpkg.com/lucide@latest"></script>
@include('exports.partials.style')
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
  .search-box{width:240px; height:40px; display:flex; align-items:center; gap:8px; background:var(--panel); border:1px solid var(--border); border-radius:10px; padding:0 12px;}
  .search-box input{flex:1; border:none; outline:none; background:transparent; color:#fff; font-size:13.5px;}
  .search-box input::placeholder{color:var(--text-dim);}
  .icon-btn{position:relative; width:38px; height:38px; border-radius:12px; background:var(--panel); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; flex:none;}
  .avatar{width:34px; height:34px; border-radius:50%; background:linear-gradient(135deg,var(--orange),#DC2626); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:13px; overflow:hidden; flex:none;}

  .panel{background:var(--panel); backdrop-filter:blur(var(--glass-blur)); -webkit-backdrop-filter:blur(var(--glass-blur)); border:1px solid var(--border); border-radius:var(--radius); box-shadow:0 8px 24px rgba(0,0,0,.25);}
  .panel-pad{padding:20px;}
  .panel + .panel{margin-top:16px;}

  .card-head{margin-bottom:14px;}
  .card-head h3{position:relative; font-size:12.5px; font-weight:800; color:#fff; display:inline-flex; align-items:center; gap:8px;
    padding:9px 18px; background:linear-gradient(180deg,#3D7BFF 0%,#1E4FC4 55%,#123591 100%); border-radius:999px;
    box-shadow:0 5px 12px rgba(23,73,176,.5), inset 0 2px 0 rgba(255,255,255,.4), inset 0 -4px 8px rgba(0,0,0,.3);}
  .card-head p{font-size:11px; color:var(--text-dim); margin-top:6px;}
  .step-num{width:18px; height:18px; border-radius:50%; background:rgba(255,255,255,.25); display:inline-flex; align-items:center; justify-content:center; font-size:10px; flex:none;}

  .builder-layout{display:grid; grid-template-columns:290px 1fr 300px; gap:16px; align-items:start;}
  @media (max-width:1300px){ .builder-layout{grid-template-columns:1fr;} }

  /* --- Colonne 1 : modèle + contenu --- */
  .model-card{border:1px solid var(--border); border-radius:14px; padding:12px; display:flex; gap:10px; align-items:flex-start; margin-bottom:10px; background:var(--panel-2);}
  .model-card:last-child{margin-bottom:0;}
  .model-card.active{border-color:var(--blue); background:rgba(59,130,246,.1);}
  .model-card .icon{width:34px; height:34px; border-radius:9px; background:var(--panel-2); display:flex; align-items:center; justify-content:center; flex:none; color:var(--blue-2);}
  .model-card.active .icon{background:var(--blue); color:#fff;}
  .model-card h4{font-size:12.5px; margin-bottom:3px;}
  .model-card p{font-size:10.5px; color:var(--text-dim); line-height:1.4;}

  .filters-mini{display:flex; flex-direction:column; gap:10px; margin-bottom:14px;}
  .field label{display:block; font-size:11px; color:var(--text-dim); margin-bottom:5px;}
  .field select, .field input[type=text], .field input[type=date], .field textarea{width:100%; background:#141b30; border:1px solid var(--border); border-radius:9px; padding:9px 11px; color:#fff; font-size:12.5px; color-scheme:dark;}
  .field select[multiple]{min-height:70px;}

  .section-list{display:flex; flex-direction:column; gap:2px;}
  .section-item{display:flex; align-items:center; gap:8px; padding:7px 4px; font-size:12px; color:var(--text-dim); border-bottom:1px solid rgba(255,255,255,.05);}
  .section-item i.drag{width:14px; height:14px; color:var(--text-dim); opacity:.5; flex:none;}
  .add-section-btn{margin-top:10px; width:100%; border:1px dashed var(--border); border-radius:10px; padding:9px; font-size:12px; color:var(--text-dim); display:flex; align-items:center; justify-content:center; gap:6px;}
  .add-section-btn:hover{color:#fff; border-color:var(--blue);}

  /* --- Colonne 2 : éditeur --- */
  .editor-toolbar{display:flex; align-items:center; gap:4px; flex-wrap:wrap; padding:8px 10px; background:#141b30; border:1px solid var(--border); border-radius:12px; margin-bottom:12px;}
  .editor-toolbar select{background:#0d1220; border:1px solid var(--border); border-radius:7px; color:#fff; font-size:11.5px; padding:6px 8px;}
  .tb-btn{width:30px; height:30px; border-radius:7px; display:flex; align-items:center; justify-content:center; color:var(--text-dim);}
  .tb-btn:hover{background:var(--panel-2); color:#fff;}
  .tb-sep{width:1px; height:20px; background:var(--border); margin:0 4px;}

  .doc-wrap{background:#0d1220; border-radius:14px; padding:20px; overflow:auto; max-height:640px;}
  .doc-page{max-width:210mm; margin:0 auto;}
  .doc-page:focus{outline:none;}
  .doc-page .empty-doc{color:var(--text-dim); text-align:center; padding:60px 0; font-size:12.5px;}

  .zoom-row{display:flex; align-items:center; justify-content:center; gap:10px; margin-top:10px; font-size:12px; color:var(--text-dim);}
  .zoom-row button{width:26px; height:26px; border-radius:7px; background:var(--panel-2); display:flex; align-items:center; justify-content:center;}

  /* --- Colonne 3 : paramètres + actions --- */
  .format-btns{display:flex; gap:6px;}
  .format-btn{flex:1; border:1px solid var(--border); background:#141b30; border-radius:9px; padding:8px; text-align:center; font-size:11.5px; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:5px; color:var(--text-dim);}
  .format-btn.active{border-color:var(--orange); color:var(--orange); background:rgba(245,158,11,.08);}

  .insert-grid{display:grid; grid-template-columns:repeat(3,1fr); gap:8px;}
  .insert-btn{border:1px solid var(--border); background:#141b30; border-radius:10px; padding:12px 4px; display:flex; flex-direction:column; align-items:center; gap:5px; font-size:10.5px; color:var(--text-dim);}
  .insert-btn:hover{color:#fff; border-color:var(--blue);}

  .action-btn{width:100%; border-radius:10px; padding:10px 14px; font-size:12.5px; display:flex; align-items:center; gap:8px; margin-bottom:8px; border:1px solid var(--border); background:#141b30; color:var(--text-dim);}
  .action-btn:last-child{margin-bottom:0;}
  .action-btn.primary{background:linear-gradient(135deg,var(--purple),var(--blue)); color:#fff; border:none;}
  .action-btn.orange-active{background:var(--orange); color:#fff; border-color:var(--orange);}
  .action-btn:hover{color:#fff;}

  .tip-box{background:rgba(139,92,246,.1); border:1px solid rgba(139,92,246,.3); border-radius:14px; padding:14px; font-size:11.5px; color:var(--text-dim); display:flex; gap:10px;}
  .tip-box i{color:var(--purple); flex:none;}

  .saved-grid{display:grid; grid-template-columns:repeat(4,1fr); gap:14px;}
  @media (max-width:1300px){ .saved-grid{grid-template-columns:1fr 1fr;} }
  .saved-card{background:#141b30; border:1px solid var(--border); border-radius:14px; padding:14px;}
  .saved-card .icon{width:32px; height:32px; border-radius:9px; background:var(--panel-2); display:flex; align-items:center; justify-content:center; margin-bottom:10px; color:var(--orange);}
  .saved-card h4{font-size:12.5px; margin-bottom:4px; font-weight:700;}
  .saved-card p{font-size:10.5px; color:var(--text-dim); margin-bottom:10px;}
  .saved-card .row{display:flex; justify-content:space-between; align-items:center; font-size:10.5px; color:var(--text-dim);}
  .saved-card a{color:#fff;}
  .save-status{font-size:11px; color:var(--green); margin-top:8px; text-align:center; min-height:14px;}

  @media (max-width:800px){ .sidebar{display:none;} }
</style>
</head>
<body>

<div class="app">

  @include('partials.sidebar')

  <main class="main">

    <div class="header">
      <div class="header-left">
        <h1>Rapports</h1>
        <p>Créez, personnalisez et exportez vos rapports avec des analyses détaillées.</p>
      </div>
      <div class="header-right">
        <button class="icon-btn"><i data-lucide="bell" style="width:16px;height:16px;"></i></button>
        <div class="avatar">
          @if (auth()->user()->photo_path)
            <img src="{{ asset('storage/'.auth()->user()->photo_path) }}" alt="" style="width:100%;height:100%;object-fit:cover;object-position:center top;">
          @else
            {{ strtoupper(substr(auth()->user()->name,0,1)) }}
          @endif
        </div>
      </div>
    </div>

    <form id="report-form">
    <div class="builder-layout">

      <!-- Colonne 1 : modèle + contenu -->
      <div>
        <div class="panel panel-pad">
          <div class="card-head">
            <h3><span class="step-num">1</span> Choisir un modèle</h3>
            <p>Sélectionnez un modèle adapté à vos besoins</p>
          </div>
          <div class="model-card active" data-model="standard">
            <div class="icon"><i data-lucide="file-text" style="width:16px;height:16px;"></i></div>
            <div><h4>Rapport Standard</h4><p>Statistiques générales et répartition par type de congé.</p></div>
          </div>
          <div class="model-card" data-model="detaille">
            <div class="icon"><i data-lucide="bar-chart-3" style="width:16px;height:16px;"></i></div>
            <div><h4>Analyse Détaillée</h4><p>Comparaison entre départements avec tendances et classements.</p></div>
          </div>
          <div class="model-card" data-model="executif">
            <div class="icon"><i data-lucide="pie-chart" style="width:16px;height:16px;"></i></div>
            <div><h4>Rapport Exécutif</h4><p>Résumé condensé et indicateurs clés uniquement.</p></div>
          </div>
          <input type="hidden" name="modele_rapport" id="modele-rapport" value="standard">
        </div>

        <div class="panel panel-pad">
          <div class="card-head">
            <h3><span class="step-num">2</span> Personnaliser le contenu</h3>
            <p>Filtres et sections à inclure</p>
          </div>
          <div class="filters-mini">
            <div class="field">
              <label>Période</label>
              <div style="display:flex; gap:6px;">
                <input type="date" name="periode_debut" value="{{ now()->startOfYear()->toDateString() }}">
                <input type="date" name="periode_fin" value="{{ now()->endOfYear()->toDateString() }}">
              </div>
            </div>
            <div class="field">
              <label>Départements</label>
              <select name="departements[]" multiple>
                @foreach($departements as $dep)
                  <option value="{{ $dep }}">{{ $dep }}</option>
                @endforeach
              </select>
            </div>
            <div class="field">
              <label>Types de congé</label>
              <select name="types_conge[]" multiple>
                <option value="paye">Congé annuel</option>
                <option value="rtt">RTT</option>
                <option value="exceptionnel">Exceptionnel</option>
                <option value="maladie">Maladie</option>
                <option value="sans_solde">Sans solde</option>
                <option value="autre">Autre</option>
              </select>
            </div>
            <div class="field">
              <label>Statut</label>
              <select name="statut">
                <option value="">Tous les statuts</option>
                <option value="approuve">Approuvées</option>
                <option value="en_attente">En attente</option>
                <option value="refuse">Refusées</option>
              </select>
            </div>
          </div>
          <div class="card-head" style="margin-top:4px;"><h3 style="font-size:12px;">Sections incluses</h3></div>
          <div class="section-list">
            <label class="section-item"><i data-lucide="grip-vertical" class="drag"></i><input type="checkbox" name="indicateurs[]" value="demandes_totales" checked> Statistiques clés</label>
            <label class="section-item"><i data-lucide="grip-vertical" class="drag"></i><input type="checkbox" name="indicateurs[]" value="repartition_par_type" checked> Répartition par type</label>
            <label class="section-item"><i data-lucide="grip-vertical" class="drag"></i><input type="checkbox" name="indicateurs[]" value="repartition_par_departement" checked> Comparaison départements</label>
            <label class="section-item"><i data-lucide="grip-vertical" class="drag"></i><input type="checkbox" name="indicateurs[]" value="top_employes" checked> Top employés</label>
            <label class="section-item"><i data-lucide="grip-vertical" class="drag"></i><input type="checkbox" name="indicateurs[]" value="tendance_mensuelle" checked> Tendance mensuelle</label>
            <label class="section-item"><i data-lucide="grip-vertical" class="drag"></i><input type="checkbox" name="indicateurs[]" value="top_departements_demandes" checked> Top départements</label>
          </div>
          <button type="button" class="add-section-btn" id="add-section-btn"><i data-lucide="plus" style="width:13px;height:13px;"></i> Ajouter une section personnalisée</button>
        </div>
      </div>

      <!-- Colonne 2 : éditeur -->
      <div>
        <div class="panel panel-pad">
          <div class="card-head">
            <h3><span class="step-num">3</span> Éditer votre rapport</h3>
            <p>Modifiez directement le contenu avant l'exportation</p>
          </div>

          <div class="editor-toolbar">
            <select onchange="document.execCommand('formatBlock', false, this.value)">
              <option value="p">Normal</option>
              <option value="h2">Titre 1</option>
              <option value="h3">Titre 2</option>
            </select>
            <div class="tb-sep"></div>
            <button type="button" class="tb-btn" onclick="document.execCommand('bold')"><i data-lucide="bold" style="width:14px;height:14px;"></i></button>
            <button type="button" class="tb-btn" onclick="document.execCommand('italic')"><i data-lucide="italic" style="width:14px;height:14px;"></i></button>
            <button type="button" class="tb-btn" onclick="document.execCommand('underline')"><i data-lucide="underline" style="width:14px;height:14px;"></i></button>
            <div class="tb-sep"></div>
            <button type="button" class="tb-btn" onclick="document.execCommand('justifyLeft')"><i data-lucide="align-left" style="width:14px;height:14px;"></i></button>
            <button type="button" class="tb-btn" onclick="document.execCommand('justifyCenter')"><i data-lucide="align-center" style="width:14px;height:14px;"></i></button>
            <div class="tb-sep"></div>
            <button type="button" class="tb-btn" onclick="document.execCommand('insertUnorderedList')"><i data-lucide="list" style="width:14px;height:14px;"></i></button>
            <button type="button" class="tb-btn" onclick="document.execCommand('insertOrderedList')"><i data-lucide="list-ordered" style="width:14px;height:14px;"></i></button>
          </div>

          <div class="doc-wrap">
            <div class="doc-page" id="doc-page" contenteditable="true">
              <div class="empty-doc">Clique sur "Générer le rapport" pour remplir cette page avec tes données, puis modifie-la directement ici.</div>
            </div>
          </div>

          <div class="zoom-row">
            <button type="button" id="zoom-out"><i data-lucide="zoom-out" style="width:13px;height:13px;"></i></button>
            <span id="zoom-label">100%</span>
            <button type="button" id="zoom-in"><i data-lucide="zoom-in" style="width:13px;height:13px;"></i></button>
          </div>
        </div>

        <div class="panel panel-pad" style="margin-top:16px;">
          <div class="card-head"><h3><i data-lucide="folder" style="width:14px;height:14px;"></i> Rapports enregistrés</h3></div>
          <div class="saved-grid" id="saved-grid">
            @forelse($rapportsEnregistres as $r)
              <div class="saved-card" id="saved-card-{{ $r->id }}">
                <div class="icon"><i data-lucide="file-text" style="width:16px;height:16px;"></i></div>
                <h4>{{ $r->titre }}</h4>
                <p>Généré le {{ $r->created_at->format('d/m/Y') }}</p>
                <div class="row">
                  <span>{{ strtoupper($r->format) }}</span>
                  <div style="display:flex; gap:8px;">
                    <a href="{{ route('rapports.export', $r) }}"><i data-lucide="download" style="width:14px;height:14px;"></i></a>
                    <button type="button" class="delete-report-btn" data-id="{{ $r->id }}" style="color:var(--red);"><i data-lucide="trash-2" style="width:14px;height:14px;"></i></button>
                  </div>
                </div>
              </div>
            @empty
              <p style="color:var(--text-dim); font-size:12.5px;">Aucun rapport enregistré pour le moment.</p>
            @endforelse
          </div>
        </div>
      </div>

      <!-- Colonne 3 : paramètres + actions -->
      <div>
        <div class="panel panel-pad">
          <div class="card-head">
            <h3><span class="step-num">4</span> Paramètres</h3>
            <p>Configurez les informations générales</p>
          </div>
          <div class="filters-mini">
            <div class="field">
              <label>Titre du rapport</label>
              <input type="text" name="titre" id="titre-input" value="Rapport d'analyse des congés">
            </div>
            <input type="hidden" name="format" value="pdf">
          </div>
        </div>

        <div class="panel panel-pad">
          <div class="card-head"><h3><span class="step-num">5</span> Éléments à insérer</h3></div>
          <div class="insert-grid">
            <button type="button" class="insert-btn" data-insert="texte"><i data-lucide="type" style="width:16px;height:16px;"></i>Texte</button>
            <button type="button" class="insert-btn" data-insert="graphique"><i data-lucide="bar-chart-2" style="width:16px;height:16px;"></i>Graphique</button>
            <button type="button" class="insert-btn" data-insert="tableau"><i data-lucide="table" style="width:16px;height:16px;"></i>Tableau</button>
            <button type="button" class="insert-btn" data-insert="image"><i data-lucide="image" style="width:16px;height:16px;"></i>Image</button>
            <button type="button" class="insert-btn" data-insert="note"><i data-lucide="sticky-note" style="width:16px;height:16px;"></i>Note</button>
            <button type="button" class="insert-btn" data-insert="separateur"><i data-lucide="minus" style="width:16px;height:16px;"></i>Séparateur</button>
          </div>
        </div>

        <div class="panel panel-pad">
          <div class="card-head"><h3>Actions</h3></div>
          <button type="button" class="action-btn" id="generate-btn"><i data-lucide="sparkles" style="width:14px;height:14px;"></i> Générer le rapport</button>
          <button type="button" class="action-btn" id="save-draft-btn" disabled><i data-lucide="save" style="width:14px;height:14px;"></i> Enregistrer le brouillon</button>
          <button type="button" class="action-btn primary" id="export-pdf-btn" disabled><i data-lucide="file-down" style="width:14px;height:14px;"></i> Exporter en PDF</button>
          <button type="button" class="action-btn" id="export-excel-btn" disabled><i data-lucide="file-spreadsheet" style="width:14px;height:14px;"></i> Exporter en Excel</button>
          <div class="save-status" id="save-status"></div>
        </div>

        <div class="tip-box">
          <i data-lucide="lightbulb" style="width:16px;height:16px;"></i>
          <div>Tu peux modifier directement le contenu dans l'aperçu avant l'exportation. Clique sur un élément pour le modifier ou le supprimer.</div>
        </div>
      </div>

    </div>
    </form>
  </main>
</div>

<script>
lucide.createIcons();
const csrf = document.querySelector('meta[name=csrf-token]').content;
let currentRapportId = null;
let currentDonnees = null;
let zoomLevel = 100;

// --- Sélection du modèle ---
document.querySelectorAll('.model-card').forEach(card => {
  card.addEventListener('click', () => {
    document.querySelectorAll('.model-card').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
    document.getElementById('modele-rapport').value = card.dataset.model;
  });
});

// --- Zoom (visuel uniquement) ---
document.getElementById('zoom-in').addEventListener('click', () => {
  zoomLevel = Math.min(zoomLevel + 10, 150);
  applyZoom();
});
document.getElementById('zoom-out').addEventListener('click', () => {
  zoomLevel = Math.max(zoomLevel - 10, 60);
  applyZoom();
});
function applyZoom() {
  document.getElementById('doc-page').style.transform = `scale(${zoomLevel / 100})`;
  document.getElementById('doc-page').style.transformOrigin = 'top center';
  document.getElementById('zoom-label').textContent = zoomLevel + '%';
}

// --- Ajouter une section personnalisée (liste de gauche) ---
document.getElementById('add-section-btn').addEventListener('click', () => {
  const nom = prompt('Nom de la section personnalisée :');
  if (!nom) return;
  insertHtmlInDoc(`<h2>${nom}</h2><p>Contenu à compléter...</p>`);
});

// --- Éléments à insérer (colonne 3) ---
document.querySelectorAll('.insert-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const type = btn.dataset.insert;
    if (type === 'texte') {
      insertHtmlInDoc('<p>Nouveau texte à modifier...</p>');
    } else if (type === 'tableau') {
      insertHtmlInDoc('<table class="data"><thead><tr><th>Colonne 1</th><th>Colonne 2</th></tr></thead><tbody><tr><td>—</td><td>—</td></tr><tr><td>—</td><td>—</td></tr></tbody></table>');
    } else if (type === 'separateur') {
      insertHtmlInDoc('<hr>');
    } else if (type === 'note') {
      insertHtmlInDoc('<div class="callout"><strong>Note</strong>À compléter...</div>');
    } else if (type === 'graphique') {
      insertHtmlInDoc(construireGraphiqueHtml());
    } else if (type === 'image') {
      const input = document.createElement('input');
      input.type = 'file';
      input.accept = 'image/*';
      input.onchange = () => {
        const file = input.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = () => insertHtmlInDoc(`<img src="${reader.result}" style="max-width:100%;border-radius:8px;margin:8px 0;">`);
        reader.readAsDataURL(file);
      };
      input.click();
    }
  });
});

function insertHtmlInDoc(html) {
  const doc = document.getElementById('doc-page');
  doc.querySelector('.empty-doc')?.remove();
  doc.focus();
  document.execCommand('insertHTML', false, html);
}

function construireGraphiqueHtml() {
  if (!currentDonnees || !currentDonnees.repartition_par_type) {
    return '<div class="callout"><strong>Info</strong>Génère d\'abord le rapport pour pouvoir insérer un graphique basé sur tes données.</div>';
  }
  const typeLabels = {paye:'Congé annuel', rtt:'RTT', exceptionnel:'Exceptionnel', maladie:'Maladie', sans_solde:'Sans solde', autre:'Autre'};
  const entries = Object.entries(currentDonnees.repartition_par_type);
  const max = Math.max(...entries.map(e => e[1]), 1);
  let html = '<div>';
  entries.forEach(([type, valeur]) => {
    const pct = Math.round((valeur / max) * 100);
    html += `<div class="bar-row"><div class="bar-label"><span>${typeLabels[type] || type}</span><span>${valeur}</span></div><div class="bar-track"><div class="bar-fill" style="width:${pct}%;"></div></div></div>`;
  });
  html += '</div>';
  return html;
}

// --- Génération du rapport ---
document.getElementById('generate-btn').addEventListener('click', () => {
  const genBtn = document.getElementById('generate-btn');
  genBtn.classList.add('orange-active');
  const doc = document.getElementById('doc-page');
  doc.innerHTML = '<div class="empty-doc">Génération en cours...</div>';

  const data = new FormData(document.getElementById('report-form'));
  const payload = {};
  for (const [key, value] of data.entries()) {
    const cleanKey = key.replace('[]', '');
    if (key.endsWith('[]')) {
      if (!payload[cleanKey]) payload[cleanKey] = [];
      payload[cleanKey].push(value);
    } else {
      payload[cleanKey] = value;
    }
  }
  payload.ai = false;

  fetch("{{ route('rapports.generate') }}", {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
    body: JSON.stringify(payload)
  })
  .then(async r => {
    const resData = await r.json();
    if (!r.ok || !resData.success) throw new Error(resData.error || 'Erreur inconnue lors de la génération.');
    return resData;
  })
  .then(resData => {
    currentRapportId = resData.rapport.id;
    currentDonnees = resData.rapport.donnees;
    doc.innerHTML = resData.apercu_html;
    document.getElementById('save-draft-btn').disabled = false;
    document.getElementById('export-pdf-btn').disabled = false;
    document.getElementById('export-excel-btn').disabled = false;
  })
  .catch(err => {
    doc.innerHTML = `<div class="note-box" style="border-color:var(--red);color:var(--red);">${err.message}</div>`;
  });
});

// --- Enregistrer le brouillon ---
document.getElementById('save-draft-btn').addEventListener('click', () => {
  if (!currentRapportId) return;
  const status = document.getElementById('save-status');
  status.textContent = 'Enregistrement...';

  fetch(`/rh/rapports/${currentRapportId}`, {
    method: 'PATCH',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
    body: JSON.stringify({
      titre: document.getElementById('titre-input').value,
      contenu_html: document.getElementById('doc-page').innerHTML,
    })
  })
  .then(r => r.json())
  .then(resData => { status.textContent = resData.success ? 'Brouillon enregistré ✓' : 'Erreur lors de l\'enregistrement.'; })
  .catch(() => { status.textContent = 'Erreur réseau.'; });
});

// --- Exporter en PDF ---
document.getElementById('export-pdf-btn').addEventListener('click', () => {
  if (!currentRapportId) return;
  document.getElementById('save-draft-btn').click();
  setTimeout(() => { window.location.href = `/rh/rapports/${currentRapportId}/export?format=pdf`; }, 400);
});

// --- Exporter en Excel ---
document.getElementById('export-excel-btn').addEventListener('click', () => {
  if (!currentRapportId) return;
  window.location.href = `/rh/rapports/${currentRapportId}/export?format=excel`;
});

// --- Supprimer un rapport enregistré ---
document.querySelectorAll('.delete-report-btn').forEach(btn => {
  btn.addEventListener('click', () => {
    const id = btn.dataset.id;
    fetch(`/rh/rapports/${id}`, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': csrf }
    })
    .then(r => r.json())
    .then(resData => { if (resData.success) document.getElementById(`saved-card-${id}`).remove(); });
  });
});
</script>
</body>
</html>