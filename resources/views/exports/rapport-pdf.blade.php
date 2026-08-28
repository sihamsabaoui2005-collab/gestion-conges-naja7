<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>{{ $rapport->titre }}</title>
<style>
  @page { margin: 30px 34px; }
  * { box-sizing: border-box; }
  body {
    font-family: sans-serif;
    color: #111;
    font-size: 12px;
    line-height: 1.5;
  }
  header {
    border-bottom: 2px solid #111;
    padding-bottom: 14px;
    margin-bottom: 22px;
  }
  header h1 { margin: 0 0 4px; font-size: 21px; color: #111; }
  header .meta { color: #555; font-size: 11.5px; }

  h2 {
    font-size: 14.5px;
    margin: 26px 0 10px;
    padding-bottom: 6px;
    border-bottom: 1px solid #ccc;
    color: #111;
  }

  table { width: 100%; border-collapse: collapse; font-size: 11.5px; margin-bottom: 8px; }
  th, td { text-align: left; padding: 7px 10px; border-bottom: 1px solid #ddd; }
  th { color: #444; font-weight: bold; background: #f2f2f2; }

  .kpi-grid table { width: 100%; }
  .kpi-grid td { width: 25%; padding: 4px; }
  .kpi {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    background: #fafafa;
    text-align: center;
  }
  .kpi .val { font-size: 18px; font-weight: bold; color: #111; }
  .kpi .label { font-size: 10px; color: #555; margin-top: 2px; }

  .chart-box {
    background: #fafafa;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 12px 14px;
    margin-bottom: 8px;
  }
  .bar-row { display: block; margin-bottom: 7px; }
  .bar-label { font-size: 10.5px; color: #333; margin-bottom: 2px; }
  .bar-track { background: #e2e2e2; border-radius: 3px; height: 12px; width: 100%; }
  .bar-fill { background: #333; height: 12px; border-radius: 3px; }
  .bar-value { font-size: 10px; color: #555; float: right; }

  .analysis {
    font-size: 11.5px;
    color: #333;
    background: #f2f2f2;
    border-left: 3px solid #333;
    padding: 10px 14px;
    margin-top: 8px;
    border-radius: 0 4px 4px 0;
  }
  .analysis b { color: #111; }

  .badge {
    display: inline-block;
    background: #111;
    color: #fff;
    font-size: 9.5px;
    font-weight: bold;
    padding: 2px 7px;
    border-radius: 9px;
  }

  ol { font-size: 11.5px; }

  footer {
    margin-top: 34px;
    font-size: 10px;
    color: #777;
    text-align: center;
    border-top: 1px solid #ddd;
    padding-top: 10px;
  }

  .empty-note { font-size: 11px; color: #888; font-style: italic; }
</style>
</head>
<body>

@php
    $d = $rapport->donnees ?? [];
    $typeLabels = ['paye' => 'Congé annuel', 'rtt' => 'RTT', 'exceptionnel' => 'Exceptionnel', 'maladie' => 'Maladie', 'sans_solde' => 'Sans solde', 'autre' => 'Autre'];

    $repartitionType = collect($d['repartition_par_type'] ?? []);
    $totalType = $repartitionType->sum();
    $maxType = $repartitionType->max() ?: 1;

    $repartitionDept = collect($d['repartition_par_departement'] ?? []);
    $maxDept = $repartitionDept->max() ?: 1;

    $topDeptDemandes = collect($d['top_departements_demandes'] ?? []);

    $tendance = collect($d['tendance_mensuelle'] ?? []);
    $maxTendance = $tendance->max() ?: 1;

    $topEmployes = collect($d['top_employes'] ?? []);
@endphp

<header>
  <h1>{{ $rapport->titre }}</h1>
  <div class="meta">
    NAJA7 HOST · Direction des Ressources Humaines
    · Période : {{ $d['periode_debut'] ?? $rapport->periode_debut->format('d/m/Y') }} — {{ $d['periode_fin'] ?? $rapport->periode_fin->format('d/m/Y') }}
    · Généré le {{ $rapport->created_at->format('d/m/Y') }}
  </div>
</header>

<h2>1. Résumé</h2>
<div class="kpi-grid">
  <table>
    <tr>
      <td><div class="kpi"><div class="val">{{ $d['demandes_totales'] ?? 0 }}</div><div class="label">Demandes soumises</div></div></td>
      <td><div class="kpi"><div class="val">{{ $d['approuvees'] ?? 0 }} ({{ $d['taux_approbation'] ?? 0 }}%)</div><div class="label">Approuvées</div></div></td>
      <td><div class="kpi"><div class="val">{{ $d['jours_utilises'] ?? 0 }}</div><div class="label">Jours consommés</div></div></td>
      <td><div class="kpi"><div class="val">{{ $d['duree_moyenne'] ?? 0 }} j</div><div class="label">Durée moyenne</div></div></td>
    </tr>
  </table>
</div>
@if($rapport->resume_ia)
  <div class="analysis">{{ $rapport->resume_ia }}</div>
@else
  <div class="analysis">
    Sur la période, <b>{{ $d['demandes_totales'] ?? 0 }} demande(s)</b> ont été soumises, dont <b>{{ $d['taux_approbation'] ?? 0 }}%</b> approuvées et <b>{{ $d['taux_refus'] ?? 0 }}%</b> refusées.
    @if(!empty($d['type_plus_utilise']))
      Le type de congé le plus utilisé est <b>{{ $typeLabels[$d['type_plus_utilise']] ?? $d['type_plus_utilise'] }}</b>.
    @endif
    @if(!empty($d['departement_plus_demandeur']))
      Le département <b>{{ $d['departement_plus_demandeur'] }}</b> concentre le plus de jours de congé utilisés.
    @endif
  </div>
@endif

@if($repartitionType->isNotEmpty())
<h2>2. Répartition par type de congé</h2>
<div style="display:table; width:100%;">
  <div style="display:table-cell; width:55%; vertical-align:top; padding-right:14px;">
    <div class="chart-box">
      @foreach($repartitionType->sortDesc() as $type => $valeur)
        <div class="bar-row">
          <div class="bar-label">{{ $typeLabels[$type] ?? $type }} <span class="bar-value">{{ $valeur }} ({{ $totalType > 0 ? round($valeur / $totalType * 100) : 0 }}%)</span></div>
          <div class="bar-track"><div class="bar-fill" style="width: {{ round($valeur / $maxType * 100) }}%;"></div></div>
        </div>
      @endforeach
    </div>
  </div>
  <div style="display:table-cell; width:45%; vertical-align:top;">
    <table>
      <tr><th>Type</th><th>Nombre</th><th>%</th></tr>
      @foreach($repartitionType->sortDesc() as $type => $valeur)
        <tr><td>{{ $typeLabels[$type] ?? $type }}</td><td>{{ $valeur }}</td><td>{{ $totalType > 0 ? round($valeur / $totalType * 100) : 0 }}%</td></tr>
      @endforeach
    </table>
  </div>
</div>
@endif

@if($repartitionDept->isNotEmpty())
<h2>3. Jours utilisés par département</h2>
<div class="chart-box">
  @foreach($repartitionDept->sortDesc() as $dept => $valeur)
    <div class="bar-row">
      <div class="bar-label">{{ $dept }} <span class="bar-value">{{ $valeur }} j</span></div>
      <div class="bar-track"><div class="bar-fill" style="width: {{ round($valeur / $maxDept * 100) }}%;"></div></div>
    </div>
  @endforeach
</div>
<div class="analysis">
  Le département <b>{{ $repartitionDept->sortDesc()->keys()->first() }}</b> a consommé le plus de jours de congé sur la période ({{ $repartitionDept->max() }} j).
</div>
@endif

@if($topDeptDemandes->isNotEmpty())
<h2>4. Top départements par nombre de demandes</h2>
<table>
  <tr><th>#</th><th>Département</th><th>Demandes</th></tr>
  @php $rang = 1; @endphp
  @foreach($topDeptDemandes as $dept => $valeur)
    <tr><td><span class="badge">#{{ $rang++ }}</span></td><td>{{ $dept }}</td><td>{{ $valeur }}</td></tr>
  @endforeach
</table>
@endif

@if($topEmployes->isNotEmpty())
<h2>5. Employés — plus forte consommation</h2>
<table>
  <tr><th>#</th><th>Employé</th><th>Jours utilisés</th></tr>
  @php $rang = 1; @endphp
  @foreach($topEmployes as $nom => $valeur)
    <tr><td><span class="badge">#{{ $rang++ }}</span></td><td>{{ $nom }}</td><td>{{ $valeur }} j</td></tr>
  @endforeach
</table>
<div class="analysis">
  {{ $topEmployes->keys()->first() }} arrive en tête avec {{ $topEmployes->first() }} jour(s) de congé utilisés sur la période.
</div>
@endif

@if($tendance->isNotEmpty())
<h2>6. Tendance mensuelle des demandes</h2>
<div class="chart-box">
  @foreach($tendance as $mois => $valeur)
    <div class="bar-row">
      <div class="bar-label">{{ \Carbon\Carbon::createFromFormat('Y-m', $mois)->translatedFormat('F Y') }} <span class="bar-value">{{ $valeur }} demande(s)</span></div>
      <div class="bar-track"><div class="bar-fill" style="width: {{ round($valeur / $maxTendance * 100) }}%;"></div></div>
    </div>
  @endforeach
</div>
@if($tendance->count() >= 2)
  @php
    $premier = $tendance->first();
    $dernier = $tendance->last();
    $variation = $premier > 0 ? round((($dernier - $premier) / $premier) * 100) : null;
  @endphp
  @if(!is_null($variation))
    <div class="analysis">
      Les demandes ont {{ $variation >= 0 ? 'augmenté' : 'diminué' }} de <b>{{ abs($variation) }}%</b> entre le début et la fin de la période observée.
    </div>
  @endif
@endif
@endif

<h2>7. Recommandations</h2>
<ol>
  @if(($d['taux_refus'] ?? 0) > 15)
    <li>Le taux de refus ({{ $d['taux_refus'] }}%) est élevé — analyser les motifs de refus pour identifier des causes récurrentes (chevauchements d'équipe, solde insuffisant...).</li>
  @endif
  @if(!empty($d['departement_plus_demandeur']))
    <li>Surveiller la charge du département <b>{{ $d['departement_plus_demandeur'] }}</b>, qui concentre le plus de jours de congé.</li>
  @endif
  @if(($d['en_attente'] ?? 0) > 0)
    <li>{{ $d['en_attente'] }} demande(s) restent en attente de décision — les traiter rapidement pour éviter tout retard de planification.</li>
  @endif
  <li>Continuer à suivre l'évolution mensuelle des demandes pour anticiper les périodes de forte affluence.</li>
</ol>

<footer>NAJA7 HOST — RH Intelligent · Rapport généré automatiquement à partir des données de congés</footer>

</body>
</html>