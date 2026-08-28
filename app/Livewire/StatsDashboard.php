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

    // Types de congés considérés comme des ABSENCES non planifiées (pour le taux d'absentéisme)
    private array $typesAbsence = ['maladie', 'sans_solde'];

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
        $prevPrevDebut = $prevDebut->copy()->subYear();
        $prevPrevFin   = $prevFin->copy()->subYear();

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

        // FIX : "Taux d'utilisation" et "Taux d'absentéisme" mesuraient tous les deux la même
        // chose (tous types de congés approuvés confondus), ce qui n'a pas de sens : le solde
        // annuel (solde_conges_annuel) ne concerne QUE le congé payé (seul type décompté à
        // l'approbation, cf. LeaveRequestController::approve()), et l'absentéisme désigne les
        // absences NON planifiées (maladie, sans solde), pas les vacances prévues à l'avance.
        // On sépare donc les deux notions avec des données différentes.
        $joursPayePris     = (float) $demandes->where('statut', 'approuve')->where('type', 'paye')->sum('jours');
        $joursPayePrisPrec = (float) $demandesPrec->where('statut', 'approuve')->where('type', 'paye')->sum('jours');
        $soldeTotal        = (float) (User::where('role', 'employe')->sum('solde_conges_annuel') ?: 1);

        $tauxUtilisation     = round(min(100, $joursPayePris / $soldeTotal * 100), 1);
        $tauxUtilisationPrec = round(min(100, $joursPayePrisPrec / $soldeTotal * 100), 1);

        $joursAbsence     = (float) $demandes->where('statut', 'approuve')->whereIn('type', $this->typesAbsence)->sum('jours');
        $joursAbsencePrec = (float) $demandesPrec->where('statut', 'approuve')->whereIn('type', $this->typesAbsence)->sum('jours');

        $nbEmployes  = User::where('role', 'employe')->count() ?: 1;
        $nbMois      = max(1, $debut->diffInMonths($fin) + 1);
        $joursOuvres = $nbEmployes * $nbMois * 26; // semaine lun-sam, dimanche fermé

        $tauxAbsenteisme     = round($joursAbsence / $joursOuvres * 100, 1);
        $tauxAbsenteismePrec = round($joursAbsencePrec / $joursOuvres * 100, 1);

        $tauxPresenteisme     = round(100 - $tauxAbsenteisme, 1);
        $tauxPresenteismePrec = round(100 - $tauxAbsenteismePrec, 1);

        // FIX : "Taux de report des congés" était codé en dur (valeurs fictives 8.2 / 10.8).
        // Défini ici comme la part du solde annuel de congé payé qui n'a PAS été consommée
        // sur la période précédente (et qui a donc dû être reportée, perdue, ou payée).
        $joursNonUtilisesPrec     = max(0, $soldeTotal - $joursPayePrisPrec);
        $joursPayePrisPrevPrev    = (float) LeaveRequest::where('statut', 'approuve')
            ->where('type', 'paye')
            ->whereBetween('date_debut', [$prevPrevDebut, $prevPrevFin])
            ->sum('jours');
        $joursNonUtilisesPrevPrev = max(0, $soldeTotal - $joursPayePrisPrevPrev);

        $tauxReport     = round($joursNonUtilisesPrec / $soldeTotal * 100, 1);
        $tauxReportPrec = round($joursNonUtilisesPrevPrev / $soldeTotal * 100, 1);

        return [
            'tauxAbsenteisme' => $tauxAbsenteisme, 'tauxAbsenteismePrec' => $tauxAbsenteismePrec,
            'tauxApprobation' => $tauxApprobation, 'tauxApprobationPrec' => $tauxApprobationPrec,
            'tauxRefus' => $tauxRefus, 'tauxRefusPrec' => $tauxRefusPrec,
            'tauxUtilisation' => $tauxUtilisation, 'tauxUtilisationPrec' => $tauxUtilisationPrec,
            'tauxReport' => $tauxReport, 'tauxReportPrec' => $tauxReportPrec,
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

                // Absentéisme = uniquement les absences non planifiées (maladie, sans solde)
                $joursAbsence = LeaveRequest::whereIn('user_id', $ids)
                    ->where('statut', 'approuve')
                    ->whereIn('type', $this->typesAbsence)
                    ->whereBetween('date_debut', [$debut, $fin])
                    ->sum('jours');

                // Utilisation = uniquement le congé payé, par rapport au solde du département
                $joursPaye = LeaveRequest::whereIn('user_id', $ids)
                    ->where('statut', 'approuve')
                    ->where('type', 'paye')
                    ->whereBetween('date_debut', [$debut, $fin])
                    ->sum('jours');

                $joursOuvres = $nb * $nbMois * 26;
                $solde = max(1, (float) User::where('role', 'employe')->where('departement', $dep)->sum('solde_conges_annuel'));
                return [
                    'departement' => $dep,
                    'taux_absenteisme' => $joursOuvres ? round($joursAbsence / $joursOuvres * 100, 1) : 0,
                    'taux_utilisation' => round(min(100, $joursPaye / $solde * 100), 1),
                ];
            })->values();
    }

    private function evolutionMensuelle($debut, $fin, $nbEmployes)
    {
        $mois = collect();
        $curseur = $debut->copy()->startOfMonth();
        while ($curseur <= $fin) {
            // Ce graphique représente l'évolution du taux d'ABSENTÉISME : on ne compte
            // que les absences non planifiées (maladie, sans solde), pas le congé payé.
            $jours = LeaveRequest::where('statut', 'approuve')
                ->whereIn('type', $this->typesAbsence)
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