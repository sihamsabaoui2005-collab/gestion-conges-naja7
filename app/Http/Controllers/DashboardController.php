<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'rh') {
            return $this->dashboardRh();
        }

        return $this->dashboardEmploye();
    }

    // ==========================================================
    // TABLEAU DE BORD EMPLOYÉ
    // ==========================================================
    private function dashboardEmploye()
    {
        $userId = Auth::id();
        $anneeActuelle = now()->year;

        // solde_conges_annuel est un solde "vivant" : approve() le décrémente déjà
        // au moment de la validation d'une demande. Il ne faut donc PAS soustraire
        // à nouveau les jours utilisés ici, sinon chaque congé approuvé est compté deux fois.
        $soldeAnnuel = Auth::user()->solde_conges_annuel ?? 30;

        $joursUtilises = LeaveRequest::where('user_id', $userId)
            ->where('statut', 'approuve')
            ->whereYear('date_debut', $anneeActuelle)
            ->sum('jours');

        $soldeDisponible = $soldeAnnuel;

        // NB : ce pourcentage compare l'usage de l'année au solde restant (pas à un solde
        // initial fixe, qui n'existe pas encore comme colonne séparée) — c'est une
        // approximation à corriger si un champ "solde_conges_initial" est ajouté plus tard.
        $pourcentageUtilise = ($soldeAnnuel + $joursUtilises) > 0
            ? (int) round(($joursUtilises / ($soldeAnnuel + $joursUtilises)) * 100)
            : 0;

        $demandesEnAttente = LeaveRequest::where('user_id', $userId)
            ->where('statut', 'en_attente')
            ->count();

        $congesApprouves = $joursUtilises;

        $prochaineAbsence = LeaveRequest::where('user_id', $userId)
            ->where('statut', 'approuve')
            ->where('date_debut', '>=', now())
            ->orderBy('date_debut')
            ->first();

        $demandesRecentes = LeaveRequest::where('user_id', $userId)
            ->latest('date_debut')
            ->take(5)
            ->get();

        $prochainesAbsences = LeaveRequest::where('user_id', $userId)
            ->where('statut', 'approuve')
            ->where('date_debut', '>=', now())
            ->orderBy('date_debut')
            ->take(2)
            ->get();

        $demandesCalendrier = LeaveRequest::where('user_id', $userId)
            ->whereIn('statut', ['approuve', 'en_attente'])
            ->get(['type', 'date_debut', 'date_fin', 'statut'])
            ->map(fn ($d) => [
                'debut' => $d->date_debut->format('Y-m-d'),
                'fin' => $d->date_fin->format('Y-m-d'),
                'statut' => $d->statut,
                'type' => $d->type,
            ]);

        $toutesLesDemandesApprouvees = LeaveRequest::where('user_id', $userId)
            ->where('statut', 'approuve')
            ->get()
            ->groupBy(fn ($d) => $d->date_debut->year);

        $congesParMoisParAnnee = [];
        for ($annee = 2030; $annee >= 2001; $annee--) {
            $valeurs = array_fill(1, 12, 0);
            if ($toutesLesDemandesApprouvees->has($annee)) {
                $groupes = $toutesLesDemandesApprouvees->get($annee)->groupBy(fn ($d) => $d->date_debut->month);
                foreach ($groupes as $mois => $groupe) {
                    $valeurs[$mois] = $groupe->sum('jours');
                }
            }
            $congesParMoisParAnnee[$annee] = array_values($valeurs);
        }

        $notifications = LeaveRequest::where('user_id', $userId)
            ->whereIn('statut', ['approuve', 'refuse'])
            ->where('updated_at', '>=', now()->subDays(14))
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('dashboard-employe', compact(
            'soldeAnnuel',
            'joursUtilises',
            'soldeDisponible',
            'pourcentageUtilise',
            'demandesEnAttente',
            'congesApprouves',
            'prochaineAbsence',
            'demandesRecentes',
            'prochainesAbsences',
            'demandesCalendrier',
            'congesParMoisParAnnee',
            'anneeActuelle',
            'notifications'
        ));
    }

    // ==========================================================
    // TABLEAU DE BORD RH
    // ==========================================================
    private function dashboardRh()
    {
        $anneeActuelle = now()->year;
        $debutMois = now()->startOfMonth();
        $finMois = now()->endOfMonth();

        // ---------- KPI ----------
        $totalEmployes = User::where('role', 'employe')->count();

        $demandesEnAttente = LeaveRequest::where('statut', 'en_attente')->count();

        $absencesAujourdhui = LeaveRequest::where('statut', 'approuve')
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now())
            ->distinct('user_id')
            ->count('user_id');

        // FIX : on ne compte que les jours qui tombent réellement dans le mois en cours
        // (intersection entre la période de la demande et le mois), au lieu de compter
        // le total complet 'jours' d'une demande dès que sa date de début est dans le mois.
        // Une demande du 23 août au 27 septembre comptait avant pour 30 jours "en août"
        // au lieu des ~9 jours réellement pris en août.
        $joursPrisCeMois = (int) round(LeaveRequest::where('statut', 'approuve')
            ->where('date_debut', '<=', $finMois)
            ->where('date_fin', '>=', $debutMois)
            ->get()
            ->sum(function ($demande) use ($debutMois, $finMois) {
                $debutEffectif = $demande->date_debut->copy()->startOfDay()->max($debutMois->copy()->startOfDay());
                $finEffectif = $demande->date_fin->copy()->startOfDay()->min($finMois->copy()->startOfDay());
                return $debutEffectif->diffInDays($finEffectif) + 1;
            }));

        // ---------- Activité récente de l'équipe ----------
        $activiteRecente = LeaveRequest::with('user')
            ->latest('created_at')
            ->take(5)
            ->get();

        // ---------- Calendrier RH (congés + événements d'équipe) ----------
        $demandesCalendrier = LeaveRequest::with('user:id,name')
            ->whereIn('statut', ['approuve', 'en_attente'])
            ->get(['id', 'user_id', 'type', 'date_debut', 'date_fin', 'statut'])
            ->map(fn ($d) => [
                'debut' => $d->date_debut->format('Y-m-d'),
                'fin' => $d->date_fin->format('Y-m-d'),
                'statut' => $d->statut,
                'type' => $d->type,
                'employe' => $d->user->name ?? '',
            ]);

        // ---------- Résumé des employés (statut aujourd'hui) ----------
        $absentsAujourdhui = LeaveRequest::where('statut', 'approuve')
            ->where('type', 'maladie')
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now())
            ->distinct('user_id')
            ->count('user_id');

        $congeAujourdhui = LeaveRequest::where('statut', 'approuve')
            ->whereIn('type', ['paye', 'sans_solde'])
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now())
            ->distinct('user_id')
            ->count('user_id');

        $actifsAujourdhui = max(0, $totalEmployes - $absentsAujourdhui - $congeAujourdhui);

        // ---------- Prochaines absences (équipe) ----------
        $prochainesAbsences = LeaveRequest::with('user')
            ->where('statut', 'approuve')
            ->where('date_debut', '>=', now())
            ->orderBy('date_debut')
            ->take(2)
            ->get();

        // ---------- Évolution des congés utilisés (toute l'équipe) ----------
        $toutesLesDemandesApprouvees = LeaveRequest::where('statut', 'approuve')
            ->get()
            ->groupBy(fn ($d) => $d->date_debut->year);

        $congesParMoisParAnnee = [];
        for ($annee = 2030; $annee >= 2001; $annee--) {
            $valeurs = array_fill(1, 12, 0);
            if ($toutesLesDemandesApprouvees->has($annee)) {
                $groupes = $toutesLesDemandesApprouvees->get($annee)->groupBy(fn ($d) => $d->date_debut->month);
                foreach ($groupes as $mois => $groupe) {
                    $valeurs[$mois] = $groupe->sum('jours');
                }
            }
            $congesParMoisParAnnee[$annee] = array_values($valeurs);
        }

        // ---------- Insights intelligents ----------
        $demandesCeMois = LeaveRequest::whereBetween('created_at', [$debutMois, $finMois])->count();
        $demandesMoisDernier = LeaveRequest::whereBetween('created_at', [
            now()->subMonthNoOverflow()->startOfMonth(),
            now()->subMonthNoOverflow()->endOfMonth(),
        ])->count();
        $variationDemandes = $demandesMoisDernier > 0
            ? (int) round((($demandesCeMois - $demandesMoisDernier) / $demandesMoisDernier) * 100)
            : null;

        $jourLePlusDemande = LeaveRequest::all(['date_debut'])
            ->groupBy(fn ($d) => $d->date_debut->format('d/m'))
            ->sortByDesc(fn ($g) => $g->count())
            ->map(fn ($g, $date) => ['date' => $date, 'nombre' => $g->count()])
            ->first();

        $departementPlusAbsences = LeaveRequest::where('statut', 'approuve')
            ->with('user:id,departement')
            ->get()
            ->filter(fn ($d) => $d->user && $d->user->departement)
            ->groupBy(fn ($d) => $d->user->departement)
            ->map(fn ($g) => $g->sum('jours'))
            ->sortDesc()
            ->take(1);

        // ---------- Top départements (jours d'absence) ----------
        $topDepartements = LeaveRequest::where('statut', 'approuve')
            ->with('user:id,departement')
            ->get()
            ->filter(fn ($d) => $d->user && $d->user->departement)
            ->groupBy(fn ($d) => $d->user->departement)
            ->map(fn ($g) => $g->sum('jours'))
            ->sortDesc()
            ->take(4);

        return view('dashboard-rh', compact(
            'totalEmployes',
            'demandesEnAttente',
            'absencesAujourdhui',
            'joursPrisCeMois',
            'activiteRecente',
            'demandesCalendrier',
            'actifsAujourdhui',
            'congeAujourdhui',
            'absentsAujourdhui',
            'prochainesAbsences',
            'congesParMoisParAnnee',
            'anneeActuelle',
            'variationDemandes',
            'jourLePlusDemande',
            'departementPlusAbsences',
            'topDepartements'
        ));
    }
}