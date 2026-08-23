<div>
  <div class="header">
    <div class="header-left">
      <h1>Statistiques des Taux</h1>
      <p>Analyse des taux clés liés aux congés et absences</p>
    </div>
    <div class="header-right">
      <div class="date-range-btn">
        <i data-lucide="calendar" style="width:15px;height:15px;"></i>
        <input type="date" wire:model.live.debounce.500ms="dateDebut">
        <span>—</span>
        <input type="date" wire:model.live.debounce.500ms="dateFin">
      </div>
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

  <div class="kpi-grid">
    @php
      $kpis = [
        ['label' => "Taux d'absentéisme global", 'valeur' => $stats['tauxAbsenteisme'], 'prec' => $stats['tauxAbsenteismePrec'], 'color' => 'kpi-blue'],
        ['label' => "Taux d'approbation des demandes", 'valeur' => $stats['tauxApprobation'], 'prec' => $stats['tauxApprobationPrec'], 'color' => 'kpi-green'],
        ['label' => "Taux de refus", 'valeur' => $stats['tauxRefus'], 'prec' => $stats['tauxRefusPrec'], 'color' => 'kpi-red'],
        ['label' => "Taux d'utilisation des congés", 'valeur' => $stats['tauxUtilisation'], 'prec' => $stats['tauxUtilisationPrec'], 'color' => 'kpi-purple'],
        ['label' => "Taux de report des congés", 'valeur' => $stats['tauxReport'], 'prec' => $stats['tauxReportPrec'], 'color' => 'kpi-orange'],
      ];
    @endphp
    @foreach($kpis as $kpi)
      @php $delta = round($kpi['valeur'] - $kpi['prec'], 1); @endphp
      <div class="panel panel-pad kpi-card">
        <div class="kpi-title">{{ $kpi['label'] }}</div>
        <div class="kpi-ring {{ $kpi['color'] }}" style="--pct:{{ min(100, max(0, $kpi['valeur'])) }}">
          <span class="kpi-value">{{ $kpi['valeur'] }}%</span>
        </div>
        <div class="kpi-prev">vs {{ $kpi['prec'] }}% période précédente</div>
        <div class="kpi-delta {{ $delta >= 0 ? 'up' : 'down' }}">
          <i data-lucide="{{ $delta >= 0 ? 'arrow-up' : 'arrow-down' }}" style="width:12px;height:12px;"></i> {{ abs($delta) }} pt{{ abs($delta) > 1 ? 's' : '' }}
        </div>
      </div>
    @endforeach
  </div>

  <div class="charts-row-3">
    <div class="panel panel-pad">
      <div class="card-head"><h3>Évolution du taux d'absentéisme</h3></div>
      <div class="chart-box" wire:ignore><canvas id="chart-evolution"></canvas></div>
    </div>
    <div class="panel panel-pad">
      <div class="card-head"><h3>Taux d'absentéisme par département</h3></div>
      <div class="chart-box" wire:ignore><canvas id="chart-dep-donut"></canvas></div>
    </div>
    <div class="panel panel-pad">
      <div class="card-head"><h3>Taux d'utilisation des congés par département</h3></div>
      <div class="chart-box" wire:ignore><canvas id="chart-dep-bars"></canvas></div>
    </div>
  </div>

  <div class="charts-row-4">
    <div class="panel panel-pad">
      <div class="card-head"><h3>Taux de présentéisme</h3></div>
      <div class="gauge-wrap" wire:ignore>
        <canvas id="chart-presenteisme"></canvas>
        <div class="gauge-value">{{ $stats['tauxPresenteisme'] }}%</div>
      </div>
      <div class="kpi-prev" style="text-align:center;">vs {{ $stats['tauxPresenteismePrec'] }}% période précédente</div>
    </div>
    <div class="panel panel-pad">
      <div class="card-head"><h3>Répartition des demandes par statut</h3></div>
      <div class="chart-box-sm" wire:ignore><canvas id="chart-statut"></canvas></div>
    </div>
    <div class="panel panel-pad">
      <div class="card-head"><h3>Prévision du taux d'absentéisme</h3></div>
      <div class="chart-box-sm" wire:ignore><canvas id="chart-prevision"></canvas></div>
    </div>
  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(() => {
  const colors = { bleu:'#3B82F6', vert:'#10B981', rouge:'#EF4444', violet:'#8B5CF6', orange:'#F59E0B', cyan:'#22D3EE', grille:'rgba(255,255,255,.08)', texte:'#F1F4FA' };
  Chart.defaults.color = colors.texte;
  Chart.defaults.font.family = 'Poppins';
  Chart.defaults.font.size = 12;
  const palette = [colors.bleu, colors.vert, colors.violet, colors.orange, colors.rouge, colors.cyan];
  let charts = {};

  function buildAll(stats) {
    buildEvolution(stats.evolutionMensuelle);
    buildDepDonut(stats.parDepartement);
    buildDepBars(stats.parDepartement);
    buildPresenteisme(stats.tauxPresenteisme);
    buildStatut({ approuvees: stats.approuvees, refusees: stats.refusees, enAttente: stats.enAttente });
    buildPrevision(stats.prevision);
  }

  function buildEvolution(data) {
    charts.evolution?.destroy();
    charts.evolution = new Chart(document.getElementById('chart-evolution'), {
      type: 'line',
      data: { labels: data.map(d => d.label), datasets: [{ data: data.map(d => d.taux), borderColor: colors.bleu, backgroundColor: 'rgba(59,130,246,.15)', fill: true, tension: .35, pointRadius: 3 }] },
      options: { maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { grid: { color: colors.grille }, ticks: { color: colors.texte, callback: v => v + '%' } }, x: { grid: { display: false }, ticks: { color: colors.texte } } } }
    });
  }

  function buildDepDonut(data) {
    charts.depDonut?.destroy();
    charts.depDonut = new Chart(document.getElementById('chart-dep-donut'), {
      type: 'doughnut',
      data: { labels: data.map(d => d.departement), datasets: [{ data: data.map(d => d.taux_absenteisme), backgroundColor: palette, borderWidth: 0 }] },
      options: { maintainAspectRatio: false, plugins: { legend: { position: 'right', labels: { color: colors.texte, boxWidth: 10, font: { size: 11 } } } }, cutout: '65%' }
    });
  }

  function buildDepBars(data) {
    charts.depBars?.destroy();
    charts.depBars = new Chart(document.getElementById('chart-dep-bars'), {
      type: 'bar',
      data: { labels: data.map(d => d.departement), datasets: [{ data: data.map(d => d.taux_utilisation), backgroundColor: palette, borderRadius: 6 }] },
      options: { maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { max: 100, grid: { color: colors.grille }, ticks: { color: colors.texte, callback: v => v + '%' } }, x: { grid: { display: false }, ticks: { color: colors.texte } } } }
    });
  }

  function buildPresenteisme(valeur) {
    charts.presenteisme?.destroy();
    charts.presenteisme = new Chart(document.getElementById('chart-presenteisme'), {
      type: 'doughnut',
      data: { datasets: [{ data: [valeur, 100 - valeur], backgroundColor: [colors.bleu, 'rgba(255,255,255,.08)'], borderWidth: 0 }] },
      options: { maintainAspectRatio: false, rotation: -90, circumference: 180, cutout: '75%', plugins: { legend: { display: false }, tooltip: { enabled: false } } }
    });
  }

  function buildStatut(s) {
    charts.statut?.destroy();
    charts.statut = new Chart(document.getElementById('chart-statut'), {
      type: 'doughnut',
      data: { labels: ['Approuvées', 'Refusées', 'En attente'], datasets: [{ data: [s.approuvees, s.refusees, s.enAttente], backgroundColor: [colors.bleu, colors.rouge, colors.orange], borderWidth: 0 }] },
      options: { maintainAspectRatio: false, plugins: { legend: { position: 'right', labels: { color: colors.texte, boxWidth: 10, font: { size: 11 } } } }, cutout: '65%' }
    });
  }

  function buildPrevision(prevision) {
    charts.prevision?.destroy();
    const historique = prevision.historique;
    const futur = prevision.previsionFuture;
    const labels = [...historique.map(d => d.label), ...futur.map(d => d.label)];
    const dataHist = [...historique.map(d => d.taux), ...Array(futur.length).fill(null)];
    const dataFutur = [...Array(historique.length - 1).fill(null), historique[historique.length - 1]?.taux ?? null, ...futur.map(d => d.taux)];

    charts.prevision = new Chart(document.getElementById('chart-prevision'), {
      type: 'line',
      data: {
        labels,
        datasets: [
          { label: 'Historique', data: dataHist, borderColor: colors.bleu, backgroundColor: 'transparent', tension: .35, pointRadius: 3 },
          { label: 'Prévision', data: dataFutur, borderColor: colors.orange, borderDash: [6, 4], backgroundColor: 'transparent', tension: .35, pointRadius: 3 },
        ]
      },
      options: { maintainAspectRatio: false, plugins: { legend: { position: 'top', labels: { color: colors.texte, boxWidth: 10, font: { size: 11 } } } }, scales: { y: { grid: { color: colors.grille }, ticks: { color: colors.texte, callback: v => v + '%' } }, x: { grid: { display: false }, ticks: { color: colors.texte } } } }
    });
  }

  buildAll(@json($stats));

  document.addEventListener('livewire:init', () => {
    Livewire.on('stats-refreshed', (e) => buildAll(e.stats));
  });
})();
</script>
@endpush