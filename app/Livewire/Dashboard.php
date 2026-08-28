<?php

namespace App\Livewire;

use App\Models\LeaveRequest; // adapte le nom si ton modèle s'appelle autrement (ex: Conge)
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    // Année affichée dans le graphique "Congés utilisés par mois"
    public int $anneeGraphique;

    // Mois affiché dans le mini calendrier (format Y-m)
    public string $moisCalendrier;

    public function mount(): void
    {
        $this->anneeGraphique = now()->year;
        $this->moisCalendrier = now()->format('Y-m');
    }

    // ---------- Actions du calendrier ----------

    public function moisPrecedent(): void
    {
        $this->moisCalendrier = Carbon::parse($this->moisCalendrier.'-01')->subMonth()->format('Y-m');
    }

    public function moisSuivant(): void
    {
        $this->moisCalendrier = Carbon::parse($this->moisCalendrier.'-01')->addMonth()->format('Y-m');
    }

    public function aujourdHui(): void
    {
        $this->moisCalendrier = now()->format('Y-m');
    }

    public function changerAnnee(int $annee): void
    {
        $this->anneeGraphique = $annee;
    }

    // ---------- Données (computed properties Livewire) ----------

    // Solde annuel total de l'utilisateur (ex: 30 jours/an)
    public function getSoldeAnnuelProperty(): int
    {
        return auth()->user()->solde_conges_annuel ?? 30;
    }

    // Jours déjà utilisés cette année (congés approuvés)
    public function getJoursUtilisesProperty(): int
    {
        return LeaveRequest::where('user_id', auth()->id())
            ->where('statut', 'approuve')
            ->whereYear('date_debut', now()->year)
            ->sum('jours');
    }

    // Jours restants = solde annuel - jours utilisés
    public function getSoldeDisponibleProperty(): int
    {
        return max(0, $this->solde_annuel - $this->jours_utilises);
    }

    public function getPourcentageUtiliseProperty(): int
    {
        if ($this->solde_annuel === 0) {
            return 0;
        }

        return (int) round(($this->jours_utilises / $this->solde_annuel) * 100);
    }

    public function getDemandesEnAttenteProperty(): int
    {
        return LeaveRequest::where('user_id', auth()->id())
            ->where('statut', 'en_attente')
            ->count();
    }

    public function getCongesApprouvesProperty(): int
    {
        return $this->jours_utilises;
    }

    // Prochaine absence approuvée à venir
    public function getProchaineAbsenceProperty()
    {
        return LeaveRequest::where('user_id', auth()->id())
            ->where('statut', 'approuve')
            ->where('date_debut', '>=', now())
            ->orderBy('date_debut')
            ->first();
    }

    // 5 dernières demandes (tous statuts)
    public function getDemandesRecentesProperty()
    {
        return LeaveRequest::where('user_id', auth()->id())
            ->latest('date_debut')
            ->take(5)
            ->get();
    }

    // Les 2 prochaines absences approuvées
    public function getProchainesAbsencesProperty()
    {
        return LeaveRequest::where('user_id', auth()->id())
            ->where('statut', 'approuve')
            ->where('date_debut', '>=', now())
            ->orderBy('date_debut')
            ->take(2)
            ->get();
    }

    // Total de jours utilisés, mois par mois, pour l'année sélectionnée (12 valeurs)
    public function getCongesParMoisProperty(): array
    {
        $donnees = array_fill(1, 12, 0);

        $demandes = LeaveRequest::where('user_id', auth()->id())
            ->where('statut', 'approuve')
            ->whereYear('date_debut', $this->anneeGraphique)
            ->get()
            ->groupBy(fn ($demande) => $demande->date_debut->month);

        foreach ($demandes as $mois => $groupe) {
            $donnees[$mois] = $groupe->sum('jours');
        }

        return $donnees;
    }

    // Grille du mini calendrier : toutes les cases du lundi au dimanche
    public function getJoursCalendrierProperty(): array
    {
        $debutMois = Carbon::parse($this->moisCalendrier.'-01');
        $finMois = $debutMois->copy()->endOfMonth();

        $debutGrille = $debutMois->copy()->startOfWeek(Carbon::MONDAY);
        $finGrille = $finMois->copy()->endOfWeek(Carbon::SUNDAY);

        $demandes = LeaveRequest::where('user_id', auth()->id())
            ->whereIn('statut', ['approuve', 'en_attente'])
            ->get();

        $jours = [];
        $curseur = $debutGrille->copy();

        while ($curseur->lte($finGrille)) {
            $statutJour = null;

            foreach ($demandes as $demande) {
                if ($curseur->between($demande->date_debut, $demande->date_fin)) {
                    $statutJour = $demande->statut;
                    break;
                }
            }

            $jours[] = [
                'date' => $curseur->copy(),
                'horsMois' => ! $curseur->isSameMonth($debutMois),
                'aujourdHui' => $curseur->isToday(),
                'statut' => $statutJour,
            ];

            $curseur->addDay();
        }

        return $jours;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
