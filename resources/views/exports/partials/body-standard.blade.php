<div class="report-doc">
@php
  $logoPath = public_path('images/logo-naja7host.png');
  $logoData = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : null;
  $d = $rapport->donnees ?? [];
  $typeLabels = ['paye'=>'Congé annuel','rtt'=>'RTT','exceptionnel'=>'Exceptionnel','maladie'=>'Maladie','sans_solde'=>'Sans solde','autre'=>'Autre'];
  $shades = ['#FF7A1A','#E85D04','#FFA94D','#FFC08A','#C2440C','#7A2E00'];
  $repType = collect($d['repartition_par_type'] ?? []);
  $totalType = $repType->sum();
  $tendance = collect($d['tendance_mensuelle'] ?? []);
  $maxTendance = $tendance->max() ?: 1;
  $detailType = collect($d['detail_par_type'] ?? []);

  // Sections cochées par l'utilisateur dans "Personnaliser le contenu" (colonne 1 du builder).
  // Valeurs possibles : demandes_totales, repartition_par_type, repartition_par_departement,
  // top_employes, tendance_mensuelle, top_departements_demandes.
  $indicateurs = collect($rapport->indicateurs ?? []);
  $afficherStats       = $indicateurs->isEmpty() || $indicateurs->contains('demandes_totales');
  $afficherRepartition = $indicateurs->isEmpty() || $indicateurs->contains('repartition_par_type');
  $afficherTendance    = $indicateurs->isEmpty() || $indicateurs->contains('tendance_mensuelle');
@endphp

<!-- PAGE 1 — COUVERTURE -->
<div class="sheet cover">
  <div class="cover-topbar"></div>
  <div><img src="{{ $logoData }}" class="logo-mark" alt="Naja7 Host"><span class="logo-word"><b>NAJA7 HOST</b><span>Hébergement web · Développement</span></span></div>
  <p class="cover-eyebrow">Module Rapports RH — Gestion des congés</p>
  <h1>{{ $rapport->titre }}</h1>
  <p class="subtitle">Statistiques générales et répartition des congés par type.</p>
  <div class="cover-infobox">
    <div class="cell"><strong>Période couverte</strong>{{ $rapport->periode_debut->format('d/m/Y') }} – {{ $rapport->periode_fin->format('d/m/Y') }}</div>
    <div class="cell"><strong>Regroupement</strong>{{ ucfirst($rapport->regroupement ?? 'Mensuel') }}</div>
    <div class="cell"><strong>Généré le</strong>{{ $rapport->created_at->format('d/m/Y') }}</div>
    <div class="cell"><strong>Format</strong>PDF</div>
  </div>
</div>

<!-- PAGE 2 — TITRE -->
<div class="sheet titlepage">
  <img src="{{ $logoData }}" class="logo-mark" style="width:64px;height:64px;" alt="Naja7 Host">
  <div class="logo-word" style="display:block; margin-top:10px;"><b>NAJA7 HOST</b><span>Hébergement web · Développement</span></div>
  <h1>{{ $rapport->titre }}</h1>
  <p class="subtitle">Statistiques générales — Plateforme de gestion des congés</p>
  <div class="credit">
    <div class="lbl">Réalisé par</div><div class="val">Service RH — Naja7 Host</div>
    <div class="lbl">Généré via</div><div class="val">Module Rapports RH</div>
  </div>
</div>

@if ($afficherStats || $afficherRepartition || $afficherTendance)
<!-- PAGE 3 — INDICATEURS + REPARTITION -->
<div class="sheet">
  <div class="pageheader"><span class="l">{{ $rapport->titre }}</span><span class="r">Indicateurs</span></div>

  @if ($afficherStats)
    <h2 class="section-title">Indicateurs généraux</h2>
    <table class="kpi-table"><tr>
      <td><span class="kpi-num">{{ $d['demandes_totales'] ?? 0 }}</span><span class="kpi-lbl">Demandes de congé</span></td>
      <td><span class="kpi-num">{{ $d['jours_utilises'] ?? 0 }}</span><span class="kpi-lbl">Jours de congé pris</span></td>
      <td><span class="kpi-num">{{ $d['taux_approbation'] ?? 0 }}%</span><span class="kpi-lbl">Taux d'approbation</span></td>
      <td><span class="kpi-num">{{ $d['nb_employes_concernes'] ?? 0 }}</span><span class="kpi-lbl">Employés concernés</span></td>
    </tr></table>
  @endif

  @if ($afficherRepartition)
    <h2 class="section-title">Répartition par type de congé</h2>
    <div class="chart-box">
      <h3>Demandes par type</h3>
      @if($totalType > 0)
        <div class="segbar">
          @foreach($repType->sortDesc() as $type => $valeur)
            <div class="seg" style="width:{{ round($valeur/$totalType*100) }}%; background:{{ $shades[$loop->index % count($shades)] }};"></div>
          @endforeach
        </div>
        @foreach($repType->sortDesc() as $type => $valeur)
          <div class="legend-item"><span class="l"><span class="legend-dot" style="background:{{ $shades[$loop->index % count($shades)] }};"></span>{{ $typeLabels[$type] ?? $type }}</span><span class="v">{{ round($valeur/$totalType*100) }}% ({{ $valeur }})</span></div>
        @endforeach
      @else
        <p class="caption">Aucune demande sur la période.</p>
      @endif
    </div>
  @endif

  @if ($afficherTendance && $tendance->isNotEmpty())
  <div class="chart-box">
    <h3>Évolution mensuelle des demandes</h3>
    <table class="bar-col-table"><tr>
      @foreach($tendance as $mois => $valeur)
        <td><div class="bar-fill-col" style="height:{{ max(4, round($valeur/$maxTendance*70)) }}px; width:22px;"></div></td>
      @endforeach
    </tr><tr>
      @foreach($tendance as $mois => $valeur)
        <td><div class="bar-col-lbl">{{ \Carbon\Carbon::createFromFormat('Y-m',$mois)->translatedFormat('M') }}</div></td>
      @endforeach
    </tr></table>
  </div>
  @endif

  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 3</span></div>
</div>
@endif

@if ($afficherRepartition)
<!-- PAGE 4 — DETAIL + ANALYSE -->
<div class="sheet">
  <div class="pageheader"><span class="l">{{ $rapport->titre }}</span><span class="r">Détail et analyse</span></div>
  <h2 class="section-title">Détail par type de congé</h2>
  <table class="data">
    <thead><tr><th>Type de congé</th><th class="num">Demandes</th><th class="num">Part</th><th class="num">Jours pris</th><th class="num">Taux d'approbation</th></tr></thead>
    <tbody>
      @forelse($detailType->sortByDesc('demandes') as $type => $info)
        <tr>
          <td><span class="tag" style="background:{{ $shades[$loop->index % count($shades)] }};"></span>{{ $typeLabels[$type] ?? $type }}</td>
          <td class="num">{{ $info['demandes'] }}</td>
          <td class="num">{{ $totalType > 0 ? round($info['demandes']/$totalType*100) : 0 }}%</td>
          <td class="num">{{ $info['jours'] }}</td>
          <td class="num">{{ $info['taux_approbation'] }}%</td>
        </tr>
      @empty
        <tr><td colspan="5">Aucune donnée sur la période.</td></tr>
      @endforelse
    </tbody>
  </table>

  <h2 class="section-title" style="margin-top:20px;">Analyse et lecture des résultats</h2>
  @if($detailType->isNotEmpty())
    @php $typePlusUtilise = $detailType->sortByDesc('demandes')->keys()->first(); @endphp
    <p class="body-text">Le type <strong>{{ $typeLabels[$typePlusUtilise] ?? $typePlusUtilise }}</strong> concentre le plus grand nombre de demandes sur la période, avec un taux d'approbation de {{ $detailType[$typePlusUtilise]['taux_approbation'] }}%.</p>
    @php $typeMoinsApprouve = $detailType->sortBy('taux_approbation')->keys()->first(); @endphp
    <p class="body-text">Le taux d'approbation le plus faible concerne le type <strong>{{ $typeLabels[$typeMoinsApprouve] ?? $typeMoinsApprouve }}</strong> ({{ $detailType[$typeMoinsApprouve]['taux_approbation'] }}%), ce qui peut suggérer des critères de validation plus stricts ou des dossiers incomplets.</p>
  @endif
  <ul class="body-list">
    <li>Délai moyen de traitement des demandes sur la période : {{ $d['delai_moyen_traitement'] ?? 0 }} jour(s).</li>
    <li>{{ $d['en_attente'] ?? 0 }} demande(s) restent en attente de décision à la date de génération du rapport.</li>
  </ul>
  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 4</span></div>
</div>
@endif
</div>