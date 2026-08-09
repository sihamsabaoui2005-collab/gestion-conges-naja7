<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'rh') {
            return view('dashboard-rh');
        }

        $userId = Auth::id();
        $anneeActuelle = now()->year;

        $soldeAnnuel = Auth::user()->solde_conges_annuel ?? 30;

        $joursUtilises = LeaveRequest::where('user_id', $userId)
            ->where('statut', 'approuve')
            ->whereYear('date_debut', $anneeActuelle)
            ->sum('jours');

        $soldeDisponible = max(0, $soldeAnnuel - $joursUtilises);

        $pourcentageUtilise = $soldeAnnuel > 0
            ? (int) round(($joursUtilises / $soldeAnnuel) * 100)
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

        // Toutes les demandes (approuvées + en attente), envoyées telles quelles au calendrier JS
        $demandesCalendrier = LeaveRequest::where('user_id', $userId)
            ->whereIn('statut', ['approuve', 'en_attente'])
            ->get(['type', 'date_debut', 'date_fin', 'statut'])
            ->map(fn ($d) => [
                'debut' => $d->date_debut->format('Y-m-d'),
                'fin' => $d->date_fin->format('Y-m-d'),
                'statut' => $d->statut,
                'type' => $d->type,
            ]);

        // Liste des années à proposer dans le graphique : toutes les années où l'utilisateur
        // a au moins une demande approuvée, plus l'année en cours (jamais une liste vide).
        // On utilise pluck() plutôt que get()->map() pour éviter un piège de Laravel :
        // unique() se comporte différemment sur une collection "Eloquent" que sur une collection normale.
        $anneesAvecDonnees = LeaveRequest::where('user_id', $userId)
            ->where('statut', 'approuve')
            ->pluck('date_debut')
            ->map(fn ($date) => $date->year)
            ->push($anneeActuelle)
            ->unique()
            ->sortDesc()
            ->values();

        $congesParMoisParAnnee = [];
        foreach ($anneesAvecDonnees as $annee) {
            $valeurs = array_fill(1, 12, 0);
            $groupes = LeaveRequest::where('user_id', $userId)
                ->where('statut', 'approuve')
                ->whereYear('date_debut', $annee)
                ->get()
                ->groupBy(fn ($d) => $d->date_debut->month);

            foreach ($groupes as $mois => $groupe) {
                $valeurs[$mois] = $groupe->sum('jours');
            }

            $congesParMoisParAnnee[$annee] = array_values($valeurs);
        }

        // Petites notifications : demandes en attente + décisions récentes (14 derniers jours)
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
}
