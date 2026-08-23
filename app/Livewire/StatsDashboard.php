<?php

namespace App\Livewire;

use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Livewire\Component;

class StatsDashboard extends Component
{
    public $dateDebut;
    public $dateFin;

    public function mount()
    {
        $this->dateDebut = Carbon::now()->startOfYear()->toDateString();
        $this->dateFin   = Carbon::now()->endOfYear()->toDateString();
    }

    public function updated($name)
    {
        if (in_array($name, ['dateDebut', 'dateFin'])) {
            $this->dispatch('stats-refreshed', stats: $this->calculerStats());
        }
    }

    private function calculerStats(): array
    {
        $debut = Carbon::parse($this->dateDebut)->startOfDay();
        $fin   = Carbon::parse($this->dateFin)->endOfDay();
        $prevDebut = $debut->copy()->subYear();
        $prevFin   = $fin->copy()->subYear();

        $demandes     = LeaveRequest::whereBetween('date_debut', [$debut, $fin])->get();
        $demandesPrec = LeaveRequest::whereBetween('date_debut', [$prevDebut, $prevFin])->get();

        $total      = $demandes->count();
        $totalPrec  = $demandesPrec->count();
        $approuvees = $demandes->where('statut', 'approuve')->count();
        $refusees   = $demandes->where('statut', 'refuse')->count();
        $enAttente  = $demandes->where('statut', 'en_attente')->count();

        $tauxApprobation     = $total ? round($approuvees / $total * 100, 1) : 0;
        $tauxApprobationPrec = $totalPrec ? round($demandesPrec->where('statut', 'approuve')->count() / $totalPrec * 100, 1) : 0;

        $tauxRefus     = $total ? round($refusees / $total * 100, 1) : 0;
        $tauxRefusPrec = $totalPrec ? round($demandesPrec->where('statut', 'refuse')->count() / $totalPrec * 100, 1) : 0;

        $joursPris     = (float) $demandes->where('statut', 'approuve')->sum('jours');
        $joursPrisPrec = (float) $demandesPrec->where('statut', 'approuve')->sum('jours');
        $soldeTotal    = (float) (User::where('role', 'employe')->sum('solde_conges_annuel') ?: 1);

        $tauxUtilisation     = round(min(100, $joursPris / $soldeTotal * 100), 1);
        $tauxUtilisationPrec = round(min(100, $joursPrisPrec / $soldeTotal * 100), 1);

        $nbEmployes  = User::where('role', 'employe')->count() ?: 1;
        $nbMois      = max(1, $debut->diffInMonths($fin) + 1);
        $joursOuvres = $nbEmployes * $nbMois * 26; // semaine lun-sam, dimanche fermé

        $tauxAbsenteisme     = round($joursPris / $joursOuvres * 100, 1);
        $tauxAbsenteismePrec = round($joursPrisPrec / $joursOuvres * 100, 1);

        $tauxPresenteisme     = round(100 - $tauxAbsenteisme, 1);
        $tauxPresenteismePrec = round(100 - $tauxAbsenteismePrec, 1);

        return [
            'tauxAbsenteisme' => $tauxAbsenteisme, 'tauxAbsenteismePrec' => $tauxAbsenteismePrec,
            'tauxApprobation' => $tauxApprobation, 'tauxApprobationPrec' => $tauxApprobationPrec,
            'tauxRefus' => $tauxRefus, 'tauxRefusPrec' => $tauxRefusPrec,
            'tauxUtilisation' => $tauxUtilisation, 'tauxUtilisationPrec' => $tauxUtilisationPrec,
            // TODO : brancher le vrai concept de "report des congés" une fois défini
            'tauxReport' => 8.2, 'tauxReportPrec' => 10.8,
            'tauxPresenteisme' => $tauxPresenteisme, 'tauxPresenteismePrec' => $tauxPresenteismePrec,
            'approuvees' => $approuvees, 'refusees' => $refusees, 'enAttente' => $enAttente,
            'parDepartement' => $this->statsParDepartement($debut, $fin, $nbMois),
            'evolutionMensuelle' => $this->evolutionMensuelle($debut, $fin, $nbEmployes),
            'prevision' => $this->prevision($debut, $fin, $nbEmployes),
        ];
    }

    private function statsParDepartement($debut, $fin, $nbMois)
    {
        return User::where('role', 'employe')
            ->whereNotNull('departement')
            ->select('departement')->distinct()->pluck('departement')
            ->map(function ($dep) use ($debut, $fin, $nbMois) {
                $ids = User::where('role', 'employe')->where('departement', $dep)->pluck('id');
                $nb  = max(1, $ids->count());
                $jours = LeaveRequest::whereIn('user_id', $ids)
                    ->where('statut', 'approuve')
                    ->whereBetween('date_debut', [$debut, $fin])
                    ->sum('jours');
                $joursOuvres = $nb * $nbMois * 26;
                $solde = max(1, (float) User::where('role', 'employe')->where('departement', $dep)->sum('solde_conges_annuel'));
                return [
                    'departement' => $dep,
                    'taux_absenteisme' => $joursOuvres ? round($jours / $joursOuvres * 100, 1) : 0,
                    'taux_utilisation' => round(min(100, $jours / $solde * 100), 1),
                ];
            })->values();
    }

    private function evolutionMensuelle($debut, $fin, $nbEmployes)
    {
        $mois = collect();
        $curseur = $debut->copy()->startOfMonth();
        while ($curseur <= $fin) {
            $jours = LeaveRequest::where('statut', 'approuve')
                ->whereBetween('date_debut', [$curseur->copy()->startOfMonth(), $curseur->copy()->endOfMonth()])
                ->sum('jours');
            $joursOuvres = $nbEmployes * 26;
            $mois->push([
                'label' => ucfirst($curseur->translatedFormat('M')),
                'taux' => $joursOuvres ? round($jours / $joursOuvres * 100, 1) : 0,
            ]);
            $curseur->addMonth();
        }
        return $mois->values();
    }

    private function prevision($debut, $fin, $nbEmployes)
    {
        $historique = $this->evolutionMensuelle($debut, $fin, $nbEmployes);
        $valeurs = $historique->pluck('taux');
        $moyenne = $valeurs->count() ? round($valeurs->slice(-3)->avg(), 1) : 0;

        $futur = collect();
        $curseur = Carbon::parse($this->dateFin)->addMonth()->startOfMonth();
        for ($i = 0; $i < 6; $i++) {
            $futur->push(['label' => ucfirst($curseur->translatedFormat('M')), 'taux' => max(0, round($moyenne - $i * 0.3, 1))]);
            $curseur->addMonth();
        }

        return ['historique' => $historique, 'previsionFuture' => $futur];
    }

    public function render()
    {
        return view('livewire.stats-dashboard', ['stats' => $this->calculerStats()]);
    }
}