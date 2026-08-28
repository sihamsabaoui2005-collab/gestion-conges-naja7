<div class="report-doc">

@php
  $logoPath = public_path('images/logo-naja7host.png');
  $logoData = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : null;
  $d = $rapport->donnees ?? [];
  $typeLabels = ['paye'=>'Congé annuel','rtt'=>'RTT','exceptionnel'=>'Exceptionnel','maladie'=>'Maladie','sans_solde'=>'Sans solde','autre'=>'Autre'];
  $shades = ['#FF7A1A','#E85D04','#FFA94D','#FFC08A','#C2410C','#7A2E00'];
  $deptStats = collect($d['departements_stats'] ?? []);
  $repDeptJours = collect($d['repartition_par_departement'] ?? []);
  $maxDeptJours = $repDeptJours->max() ?: 1;
  $comparaison = collect($d['comparaison_periodes'] ?? []);
  $tendanceDept = collect($d['tendance_par_departement'] ?? []);
  $moisListe = $tendanceDept->flatMap(fn($m) => array_keys($m))->unique()->sort()->values();
  $topEmp = collect($d['top_employes_detail'] ?? []);
  $detailType = collect($d['detail_par_type'] ?? []);
  $evolutionGlobale = null;
  if ($comparaison->isNotEmpty()) {
      $totalP1 = $comparaison->sum('periode_1'); $totalP2 = $comparaison->sum('periode_2');
      $evolutionGlobale = $totalP1 > 0 ? round((($totalP2 - $totalP1) / $totalP1) * 100) : null;
  }

  // Sections cochées dans "Personnaliser le contenu"
  $indicateurs = collect($rapport->indicateurs ?? []);
  $afficherStats    = $indicateurs->isEmpty() || $indicateurs->contains('demandes_totales');
  $afficherRepDept  = $indicateurs->isEmpty() || $indicateurs->contains('repartition_par_departement');
  $afficherTendance = $indicateurs->isEmpty() || $indicateurs->contains('tendance_mensuelle');
  $afficherTopEmp   = $indicateurs->isEmpty() || $indicateurs->contains('top_employes');
@endphp

<!-- PAGE 1 — COUVERTURE -->
<div class="sheet">
  <div class="cover-topbar"></div>
  <div><img src="{{ $logoData }}" class="logo-mark" alt="Naja7 Host"><span class="logo-word"><b>NAJA7 HOST</b><span>Hébergement web · Développement</span></span></div>
  <p class="cover-eyebrow">Module Rapports RH — Gestion des congés</p>
  <h1>{{ $rapport->titre }}</h1>
  <p class="subtitle">Comparaison entre départements, tendances et classements.</p>
  <div class="cover-infobox">
    <div class="cell"><strong>Période couverte</strong>{{ $rapport->periode_debut->format('d/m/Y') }} – {{ $rapport->periode_fin->format('d/m/Y') }}</div>
    <div class="cell"><strong>Regroupement</strong>Par département</div>
    <div class="cell"><strong>Généré le</strong>{{ $rapport->created_at->format('d/m/Y') }}</div>
    <div class="cell"><strong>Format</strong>PDF</div>
  </div>
  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 1</span></div>
</div>

<!-- PAGE 2 — TITRE -->
<div class="sheet titlepage">
  <img src="{{ $logoData }}" class="logo-mark" style="width:64px;height:64px;" alt="Naja7 Host">
  <div class="logo-word" style="display:block; margin-top:10px;"><b>NAJA7 HOST</b><span>Hébergement web · Développement</span></div>
  <h1>{{ $rapport->titre }}</h1>
  <p class="subtitle">Rapport comparatif inter-départements — Plateforme de gestion des congés</p>
  <div class="credit">
    <div class="lbl">Réalisé par</div><div class="val">Service RH — Naja7 Host</div>
    <div class="lbl">Généré via</div><div class="val">Module Rapports RH</div>
  </div>
  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 2</span></div>
</div>

<!-- PAGE 3 — SOMMAIRE -->
<div class="sheet">
  <div class="pageheader"><span class="l">{{ $rapport->titre }}</span><span class="r">Sommaire</span></div>
  <h2 class="section-title">Sommaire</h2>
  <ul class="toc-list">
    <li><span class="txt"><span class="num">01</span>Vue d'ensemble — indicateurs globaux</span><span class="pg">p.4</span></li>
    @if($afficherRepDept)<li><span class="txt"><span class="num">02</span>Classement des départements</span><span class="pg">p.5</span></li>@endif
    @if($afficherRepDept)<li><span class="txt"><span class="num">03</span>Comparaison des jours de congé pris</span><span class="pg">p.6</span></li>@endif
    @if($afficherTendance)<li><span class="txt"><span class="num">04</span>Tendances mensuelles par département</span><span class="pg">p.7</span></li>@endif
    @if($afficherRepDept)<li><span class="txt"><span class="num">05</span>Comparaison entre périodes</span><span class="pg">p.8</span></li>@endif
    @if($afficherTopEmp)<li><span class="txt"><span class="num">06</span>Focus employés — top 5</span><span class="pg">p.9</span></li>@endif
    <li><span class="txt"><span class="num">07</span>Conclusion, recommandations et glossaire</span><span class="pg">p.10</span></li>
  </ul>
  <p class="body-text" style="margin-top:20px;">Ce rapport présente une analyse comparative de l'utilisation des congés au sein de Naja7 Host sur la période du {{ $rapport->periode_debut->format('d/m/Y') }} au {{ $rapport->periode_fin->format('d/m/Y') }}, département par département.</p>
  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 3</span></div>
</div>

<!-- PAGE 4 — VUE D'ENSEMBLE -->
<div class="sheet">
  <div class="pageheader"><span class="l">{{ $rapport->titre }}</span><span class="r">01 · Vue d'ensemble</span></div>
  <h2 class="section-title">Vue d'ensemble — indicateurs globaux</h2>

  @if ($afficherStats)
    <table class="kpi-table"><tr>
      <td><span class="kpi-num">{{ $d['nb_departements'] ?? 0 }}</span><span class="kpi-lbl">Départements analysés</span></td>
      <td><span class="kpi-num">{{ $d['demandes_totales'] ?? 0 }}</span><span class="kpi-lbl">Demandes totales</span></td>
      <td><span class="kpi-num">{{ $deptStats->avg('moyenne_par_employe') ? round($deptStats->avg('moyenne_par_employe'),1) : 0 }}</span><span class="kpi-lbl">Jours moyens / employé</span></td>
      <td><span class="kpi-num">{{ $evolutionGlobale !== null ? ($evolutionGlobale >= 0 ? '+' : '').$evolutionGlobale.'%' : '—' }}</span><span class="kpi-lbl">Évolution 1ère → 2e moitié</span></td>
    </tr></table>
  @endif

  @if ($afficherRepDept)
    <div class="chart-box">
      <h3>Répartition des {{ $d['jours_utilises'] ?? 0 }} jours de congé par département</h3>
      @if($repDeptJours->isNotEmpty())
        {{-- FIX : ?: 1 pour éviter une division par zéro quand aucun jour de congé
             n'est encore approuvé sur la période (tous les $valeur à 0, somme = 0) --}}
        @php $totalJoursDept = $repDeptJours->sum() ?: 1; @endphp
        <div class="segbar">
          @foreach($repDeptJours->sortDesc() as $dept => $valeur)
            <div class="seg" style="width:{{ round($valeur/$totalJoursDept*100) }}%; background:{{ $shades[$loop->index % count($shades)] }};"></div>
          @endforeach
        </div>
        @foreach($repDeptJours->sortDesc() as $dept => $valeur)
          <div class="legend-item"><span class="l"><span class="legend-dot" style="background:{{ $shades[$loop->index % count($shades)] }};"></span>{{ $dept }}</span><span class="v">{{ round($valeur/$totalJoursDept*100) }}% ({{ $valeur }} j)</span></div>
        @endforeach
      @endif
    </div>
    <p class="body-text" style="margin-top:12px;">
      Sur la période du {{ $rapport->periode_debut->format('d/m/Y') }} au {{ $rapport->periode_fin->format('d/m/Y') }}, {{ $d['nb_employes_concernes'] ?? 0 }} employé(s) répartis sur {{ $d['nb_departements'] ?? 0 }} département(s) ont déposé {{ $d['demandes_totales'] ?? 0 }} demande(s) de congé, pour une durée moyenne de {{ $d['duree_moyenne'] ?? 0 }} jour(s) par demande.
      @if(($d['taux_refus'] ?? 0) > 0)
        Le taux de refus s'établit à {{ $d['taux_refus'] }}%, un point à surveiller sur les prochaines périodes.
      @else
        Aucune demande n'a été refusée sur la période, signe d'un processus de validation fluide.
      @endif
      Le délai moyen de traitement d'une demande est de {{ $d['delai_moyen_traitement'] ?? 0 }} jour(s).
    </p>
  @endif

  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 4</span></div>
</div>

@if ($afficherRepDept)
<!-- PAGE 5 — CLASSEMENT -->
<div class="sheet">
  <div class="pageheader"><span class="l">{{ $rapport->titre }}</span><span class="r">02 · Classement</span></div>
  <h2 class="section-title">Classement des départements</h2>
  <table class="data">
    <thead><tr><th>Rang</th><th>Département</th><th class="num">Effectif</th><th class="num">Demandes</th><th class="num">Jours pris</th><th class="num">Jours moy./employé</th><th class="num">Taux d'approbation</th></tr></thead>
    <tbody>
      @forelse($deptStats as $dept => $info)
        <tr><td class="medal">{{ $loop->iteration }}{{ $loop->iteration == 1 ? 'er' : 'e' }}</td><td>{{ $dept }}</td><td class="num">{{ $info['effectif'] }}</td><td class="num">{{ $info['demandes'] }}</td><td class="num">{{ $info['jours'] }}</td><td class="num">{{ $info['moyenne_par_employe'] }}</td><td class="num">{{ $info['taux_approbation'] }}%</td></tr>
      @empty
        <tr><td colspan="7">Aucune donnée sur la période.</td></tr>
      @endforelse
    </tbody>
  </table>
  @if($deptStats->isNotEmpty())
    <p class="body-text" style="margin-top:14px;">
      Le département <strong>{{ $deptStats->keys()->first() }}</strong> prend la première place avec {{ $deptStats->first()['moyenne_par_employe'] }} jours de congé en moyenne par employé, pour un effectif de {{ $deptStats->first()['effectif'] }} personne(s).
      @if($deptStats->count() > 1)
        Il devance {{ $deptStats->keys()->skip(1)->first() }} ({{ $deptStats->values()->skip(1)->first()['moyenne_par_employe'] }} j/employé).
      @else
        C'est actuellement le seul département actif sur cette période, un comparatif inter-départements plus complet nécessitera davantage de données.
      @endif
      Son taux d'approbation ({{ $deptStats->first()['taux_approbation'] }}%) reste {{ $deptStats->first()['taux_approbation'] >= 90 ? 'élevé' : 'à surveiller' }}.
    </p>
    <div class="callout"><strong>Lecture du classement</strong>Le classement est basé sur la moyenne de jours par employé plutôt que sur le volume brut, pour éviter de survaloriser les grands effectifs.</div>
  @endif
  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 5</span></div>
</div>

<!-- PAGE 6 — COMPARAISON JOURS PRIS -->
<div class="sheet">
  <div class="pageheader"><span class="l">{{ $rapport->titre }}</span><span class="r">03 · Comparaison</span></div>
  <h2 class="section-title">Comparaison des jours de congé pris</h2>
  <div class="chart-box">
    <h3>Jours de congé pris par département (volume total)</h3>
    @foreach($repDeptJours->sortDesc() as $dept => $valeur)
      <div class="bar-row">
        <div class="bar-label"><span class="l">{{ $dept }}</span><span class="v">{{ $valeur }} j</span></div>
        <div class="bar-track"><div class="bar-fill" style="width:{{ round($valeur/$maxDeptJours*100) }}%;"></div></div>
      </div>
    @endforeach
  </div>
  <p class="body-text">Ce classement distingue le volume total (lié à la taille de l'effectif) de la moyenne individuelle présentée en page précédente : un département peut apparaître comme le plus consommateur en jours cumulés sans que cela reflète un usage individuel plus intensif.
    @if($repDeptJours->count() > 1)
      @php $ecart = $repDeptJours->max() > 0 ? round(($repDeptJours->max() - $repDeptJours->min()) / $repDeptJours->max() * 100) : 0; @endphp
      L'écart entre le département le plus consommateur et le moins consommateur atteint {{ $ecart }}% du volume total.
    @else
      Avec un seul département actif sur la période, cette comparaison gagnera en pertinence à mesure que d'autres équipes généreront des demandes.
    @endif
  </p>
  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 6</span></div>
</div>
@endif

@if ($afficherTendance)
<!-- PAGE 7 — TENDANCES MENSUELLES -->
<div class="sheet">
  <div class="pageheader"><span class="l">{{ $rapport->titre }}</span><span class="r">04 · Tendances</span></div>
  <h2 class="section-title">Tendances mensuelles par département</h2>
  <p class="caption" style="margin-bottom:10px;">Nombre de demandes par mois et par département sur la période.</p>
  <table class="data">
    <thead><tr><th>Département</th>@foreach($moisListe as $mois)<th class="num">{{ \Carbon\Carbon::createFromFormat('Y-m',$mois)->translatedFormat('M') }}</th>@endforeach</tr></thead>
    <tbody>
      @foreach($tendanceDept as $dept => $parMois)
        <tr><td>{{ $dept }}</td>@foreach($moisListe as $mois)<td class="num">{{ $parMois[$mois] ?? 0 }}</td>@endforeach</tr>
      @endforeach
    </tbody>
  </table>
  <p class="body-text" style="margin-top:12px;">
    @if($moisListe->count() > 1)
      Toutes les équipes suivent globalement une tendance haussière sur la période, avec des rythmes de progression différents selon les départements.
    @else
      Un seul mois de données est disponible sur la période sélectionnée ; la tendance mensuelle s'affinera à mesure que davantage de mois seront couverts.
    @endif
    Le suivi mois par mois permet d'anticiper les pics saisonniers de demandes, notamment à l'approche des périodes de vacances scolaires.
  </p>
  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 7</span></div>
</div>
@endif

@if ($afficherRepDept)
<!-- PAGE 8 — T1 VS T2 -->
<div class="sheet">
  <div class="pageheader"><span class="l">{{ $rapport->titre }}</span><span class="r">05 · Comparaison périodes</span></div>
  <h2 class="section-title">Comparaison entre périodes (1ère moitié vs 2e moitié)</h2>
  <table class="data">
    <thead><tr><th>Département</th><th class="num">1ère moitié</th><th class="num">2e moitié</th><th class="num">Évolution</th></tr></thead>
    <tbody>
      @forelse($comparaison as $dept => $info)
        <tr><td>{{ $dept }}</td><td class="num">{{ $info['periode_1'] }}</td><td class="num">{{ $info['periode_2'] }}</td><td class="num">{{ $info['evolution'] >= 0 ? '+' : '' }}{{ $info['evolution'] }}%</td></tr>
      @empty
        <tr><td colspan="4">Aucune donnée sur la période.</td></tr>
      @endforelse
    </tbody>
  </table>
  @if($comparaison->isNotEmpty())
    <p class="body-text" style="margin-top:14px;">
      @php $plusForteHausse = $comparaison->sortByDesc('evolution')->keys()->first(); @endphp
      Le département <strong>{{ $plusForteHausse }}</strong> connaît la plus forte progression relative entre les deux moitiés de la période ({{ $comparaison[$plusForteHausse]['evolution'] >= 0 ? '+' : '' }}{{ $comparaison[$plusForteHausse]['evolution'] }}%).
      @if($evolutionGlobale !== null)
        Sur l'ensemble des départements, l'évolution globale des demandes entre les deux moitiés est de {{ $evolutionGlobale >= 0 ? '+' : '' }}{{ $evolutionGlobale }}%.
      @endif
    </p>
  @endif
  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 8</span></div>
</div>
@endif

@if ($afficherTopEmp)
<!-- PAGE 9 — FOCUS EMPLOYES -->
<div class="sheet">
  <div class="pageheader"><span class="l">{{ $rapport->titre }}</span><span class="r">06 · Focus employés</span></div>
  <h2 class="section-title">Focus employés — top 5 utilisateurs de congés</h2>
  <table class="data">
    <thead><tr><th>Employé</th><th>Département</th><th class="num">Jours pris</th><th class="num">Demandes</th><th>Type dominant</th></tr></thead>
    <tbody>
      @forelse($topEmp as $nom => $info)
        <tr><td>{{ $nom }}</td><td>{{ $info['departement'] }}</td><td class="num">{{ $info['jours'] }}</td><td class="num">{{ $info['demandes'] }}</td><td>{{ $typeLabels[$info['type_dominant']] ?? $info['type_dominant'] }}</td></tr>
      @empty
        <tr><td colspan="5">Aucune donnée sur la période.</td></tr>
      @endforelse
    </tbody>
  </table>
  @if($topEmp->isNotEmpty())
    <p class="body-text" style="margin-top:14px;">
      <strong>{{ $topEmp->keys()->first() }}</strong> ({{ $topEmp->first()['departement'] }}) arrive en tête avec {{ $topEmp->first()['jours'] }} jours pris sur {{ $topEmp->first()['demandes'] }} demande(s), principalement de type « {{ $typeLabels[$topEmp->first()['type_dominant']] ?? $topEmp->first()['type_dominant'] }} ».
      @if($topEmp->count() > 1)
        Au total, les {{ $topEmp->count() }} employés listés ici cumulent {{ $topEmp->sum('jours') }} jours de congé sur la période.
      @endif
    </p>
  @endif
  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 9</span></div>
</div>
@endif

<!-- PAGE 10 — CONCLUSION -->
<div class="sheet">
  <div class="pageheader"><span class="l">{{ $rapport->titre }}</span><span class="r">07 · Conclusion</span></div>
  <h2 class="section-title">Conclusion et recommandations</h2>
  <p class="body-text">L'analyse comparative fait ressortir un taux d'approbation global de {{ $d['taux_approbation'] ?? 0 }}%, avec des écarts notables entre départements sur la charge de congés par employé. Sur la période, {{ $d['nb_employes_concernes'] ?? 0 }} employé(s) ont sollicité un congé, pour une durée moyenne de {{ $d['duree_moyenne'] ?? 0 }} jour(s) par demande et un délai de traitement moyen de {{ $d['delai_moyen_traitement'] ?? 0 }} jour(s).</p>
  <ul class="body-list">
    @if($afficherRepDept && $deptStats->isNotEmpty())
      <li>Suivre de près la charge du département <strong>{{ $deptStats->keys()->first() }}</strong>, en tête du classement par jours moyens/employé.</li>
    @endif
    @if($detailType->isNotEmpty() && $detailType->min('taux_approbation') < 90)
      @php $typeMoinsApprouve = $detailType->sortBy('taux_approbation')->keys()->first(); @endphp
      <li>Clarifier les critères de refus du type « {{ $typeLabels[$typeMoinsApprouve] ?? $typeMoinsApprouve }} » ({{ $detailType[$typeMoinsApprouve]['taux_approbation'] }}% d'approbation) pour réduire les délais liés à des dossiers incomplets.</li>
    @endif
    <li>Maintenir un suivi mensuel par département pour anticiper les pics saisonniers de demandes.</li>
  </ul>
  <h2 class="section-title" style="margin-top:22px;">Glossaire des indicateurs</h2>
  <dl class="glossary">
    <dt>Jours moyens / employé</dt>
    <dd>Total des jours de congé pris dans le département, divisé par son effectif.</dd>
    <dt>Taux d'approbation</dt>
    <dd>Part des demandes validées parmi l'ensemble des demandes traitées (validées + refusées).</dd>
    <dt>1ère moitié / 2e moitié</dt>
    <dd>Découpage de la période sélectionnée en deux parties égales, pour comparer l'évolution des demandes.</dd>
  </dl>
  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 10</span></div>
</div>

</div>