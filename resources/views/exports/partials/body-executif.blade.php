<div class="report-doc">
@php
  $logoPath = public_path('images/logo-naja7host.png');
  $logoData = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : null;
  $d = $rapport->donnees ?? [];
  $typeLabels = ['paye'=>'Congé annuel','rtt'=>'RTT','exceptionnel'=>'Exceptionnel','maladie'=>'Maladie','sans_solde'=>'Sans solde','autre'=>'Autre'];
  $shades = ['#FF7A1A','#E85D04','#FFA94D','#FFC08A','#C2440C','#7A2E00'];
  $repType = collect($d['repartition_par_type'] ?? []);
  $totalType = $repType->sum();
  $moyDept = collect($d['moyenne_jours_par_employe_departement'] ?? []);
  $maxMoyDept = $moyDept->max() ?: 1;
  $detailType = collect($d['detail_par_type'] ?? []);

  // Sections cochées dans "Personnaliser le contenu"
  $indicateurs = collect($rapport->indicateurs ?? []);
  $afficherStats   = $indicateurs->isEmpty() || $indicateurs->contains('demandes_totales');
  $afficherRepType = $indicateurs->isEmpty() || $indicateurs->contains('repartition_par_type');
  $afficherRepDept = $indicateurs->isEmpty() || $indicateurs->contains('repartition_par_departement');
@endphp

<!-- PAGE 1 — COUVERTURE -->
<div class="sheet cover">
  <div class="cover-topbar"></div>
  <div><img src="{{ $logoData }}" class="logo-mark" alt="Naja7 Host"><span class="logo-word"><b>NAJA7 HOST</b><span>Hébergement web · Développement</span></span></div>
  <p class="cover-eyebrow">Module Rapports RH — Gestion des congés</p>
  <h1>{{ $rapport->titre }}</h1>
  <p class="subtitle">Résumé condensé et indicateurs clés.</p>
  <div class="cover-infobox">
    <div class="cell"><strong>Période couverte</strong>{{ $rapport->periode_debut->format('d/m/Y') }} – {{ $rapport->periode_fin->format('d/m/Y') }}</div>
    <div class="cell"><strong>Regroupement</strong>Synthèse globale</div>
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
  <p class="subtitle">Synthèse — Plateforme de gestion des congés</p>
  <div class="credit">
    <div class="lbl">Réalisé par</div><div class="val">Service RH — Naja7 Host</div>
    <div class="lbl">Généré via</div><div class="val">Module Rapports RH</div>
  </div>
  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 2</span></div>
</div>

@if ($afficherStats)
<!-- PAGE 3 — INDICATEURS CLES -->
<div class="sheet">
  <div class="pageheader"><span class="l">{{ $rapport->titre }}</span><span class="r">Indicateurs clés</span></div>
  <h2 class="section-title">Indicateurs clés</h2>
  <p class="body-text">Sur la période couverte, l'activité du module congés affiche un taux d'approbation de {{ $d['taux_approbation'] ?? 0 }}% et un délai moyen de traitement de {{ $d['delai_moyen_traitement'] ?? 0 }} jour(s). Au total, {{ $d['nb_employes_concernes'] ?? 0 }} employé(s) ont déposé {{ $d['demandes_totales'] ?? 0 }} demande(s), pour une durée moyenne de {{ $d['duree_moyenne'] ?? 0 }} jour(s) chacune.</p>
  <table class="kpi-table"><tr>
    <td><span class="kpi-num">{{ $d['demandes_totales'] ?? 0 }}</span><span class="kpi-lbl">Demandes de congé</span></td>
    <td><span class="kpi-num">{{ $d['jours_utilises'] ?? 0 }}</span><span class="kpi-lbl">Jours pris</span></td>
    <td><span class="kpi-num">{{ $d['taux_approbation'] ?? 0 }}%</span><span class="kpi-lbl">Taux d'approbation</span></td>
    <td><span class="kpi-num">{{ $d['delai_moyen_traitement'] ?? 0 }}j</span><span class="kpi-lbl">Délai moyen de traitement</span></td>
  </tr></table>
  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 3</span></div>
</div>
@endif

@if ($afficherRepType || $afficherRepDept)
<!-- PAGE 4 — GRAPHIQUES + POINTS CLES -->
<div class="sheet">
  <div class="pageheader"><span class="l">{{ $rapport->titre }}</span><span class="r">Vue graphique</span></div>
  <h2 class="section-title">Vue graphique</h2>
  <div class="two-col">
    @if ($afficherRepType)
    <div class="col">
      <div class="chart-box">
        <h3>Répartition par type</h3>
        @if($totalType > 0)
          <div class="segbar">
            @foreach($repType->sortDesc() as $type => $valeur)
              <div class="seg" style="width:{{ round($valeur/$totalType*100) }}%; background:{{ $shades[$loop->index % count($shades)] }};"></div>
            @endforeach
          </div>
          @foreach($repType->sortDesc()->take(4) as $type => $valeur)
            <div class="legend-item"><span class="l"><span class="legend-dot" style="background:{{ $shades[$loop->index % count($shades)] }};"></span>{{ $typeLabels[$type] ?? $type }}</span><span class="v">{{ round($valeur/$totalType*100) }}%</span></div>
          @endforeach
        @endif
      </div>
    </div>
    @endif
    @if ($afficherRepDept)
    <div class="col">
      <div class="chart-box">
        <h3>Moyenne jours/employé par département</h3>
        @foreach($moyDept->sortDesc() as $dept => $valeur)
          <div class="bar-row">
            <div class="bar-label"><span class="l">{{ $dept }}</span><span class="v">{{ $valeur }} j</span></div>
            <div class="bar-track"><div class="bar-fill" style="width:{{ round($valeur/$maxMoyDept*100) }}%;"></div></div>
          </div>
        @endforeach
      </div>
    </div>
    @endif
  </div>
  <h2 class="section-title" style="margin-top:18px;">Points clés</h2>
  <ul class="insight-list">
    @if($afficherRepDept && $moyDept->isNotEmpty())
      <li>Le département <strong>{{ $moyDept->sortDesc()->keys()->first() }}</strong> enregistre la moyenne de congés la plus élevée ({{ $moyDept->max() }} j/employé).</li>
    @endif
    @if($afficherRepType && $detailType->isNotEmpty() && $detailType->min('taux_approbation') < 90)
      @php $typeMoinsApprouve = $detailType->sortBy('taux_approbation')->keys()->first(); @endphp
      <li>Le taux d'approbation global reste de {{ $d['taux_approbation'] ?? 0 }}%, tiré vers le bas par le type <strong>{{ $typeLabels[$typeMoinsApprouve] ?? $typeMoinsApprouve }}</strong> ({{ $detailType[$typeMoinsApprouve]['taux_approbation'] }}%).</li>
    @elseif($afficherRepType)
      <li>Le taux d'approbation global reste élevé sur la période ({{ $d['taux_approbation'] ?? 0 }}%), tous types de congé confondus.</li>
    @endif
    <li>{{ $d['en_attente'] ?? 0 }} demande(s) restent en attente de décision à la date de génération.</li>
    @if(($d['taux_refus'] ?? 0) > 0)
      <li>Le taux de refus global s'établit à {{ $d['taux_refus'] }}%.</li>
    @endif
  </ul>
  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 4</span></div>
</div>
@endif

<!-- PAGE 5 — RECOMMANDATIONS -->
<div class="sheet">
  <div class="pageheader"><span class="l">{{ $rapport->titre }}</span><span class="r">Recommandations</span></div>
  <h2 class="section-title">Recommandations</h2>
  @if($afficherRepDept && $moyDept->isNotEmpty())
    <div class="reco"><strong>Recommandation 1</strong>Surveiller la charge du département {{ $moyDept->sortDesc()->keys()->first() }}, dont la moyenne de {{ $moyDept->max() }} jours par employé est la plus élevée de l'entreprise.</div>
  @endif
  @if($afficherRepType && $detailType->isNotEmpty() && $detailType->min('taux_approbation') < 90)
    @php $typeMoinsApprouve = $detailType->sortBy('taux_approbation')->keys()->first(); @endphp
    <div class="reco"><strong>Recommandation 2</strong>Clarifier les critères de refus du congé « {{ $typeLabels[$typeMoinsApprouve] ?? $typeMoinsApprouve }} » afin d'améliorer son taux d'approbation ({{ $detailType[$typeMoinsApprouve]['taux_approbation'] }}%).</div>
  @endif
  <div class="reco"><strong>Recommandation 3</strong>Maintenir un suivi régulier des demandes pour anticiper les périodes de forte affluence à venir.</div>
  <h2 class="section-title" style="margin-top:20px;">Conclusion</h2>
  <p class="body-text">Sur la période analysée, la gestion des congés reste globalement maîtrisée, avec un taux d'approbation de {{ $d['taux_approbation'] ?? 0 }}% et un délai moyen de traitement de {{ $d['delai_moyen_traitement'] ?? 0 }} jour(s). Au total, {{ $d['jours_utilises'] ?? 0 }} jour(s) de congé ont été pris par {{ $d['nb_employes_concernes'] ?? 0 }} employé(s) sur {{ $d['nb_departements'] ?? 0 }} département(s). Les prochains rapports permettront de suivre l'évolution de ces indicateurs.</p>
  <div class="pagefoot"><span class="l">NAJA7 HOST — Plateforme de gestion des congés</span><span class="r">Page 5</span></div>
</div>
</div>