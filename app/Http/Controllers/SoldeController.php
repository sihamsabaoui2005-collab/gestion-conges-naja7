<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class SoldeController extends Controller
{
    // Solde annuel total attribué à chaque employé (voir décision projet : 30 jours/an)
    private const SOLDE_ANNUEL_TOTAL = 30;

    public function index()
    {
        $user = Auth::user();
        $anneeEnCours = now()->year;

        // ----- Solde annuel (congés payés uniquement) -----
        $soldeAnnuelTotal    = self::SOLDE_ANNUEL_TOTAL;
        $joursRestantsAnnuel = $user->solde_conges_annuel;
        $joursUtilisesAnnuel = $soldeAnnuelTotal - $joursRestantsAnnuel;

        // Toutes les demandes approuvées de l'utilisateur pour l'année en cours
        $demandesApprouvees = LeaveRequest::where('user_id', $user->id)
            ->where('statut', 'approuve')
            ->whereYear('date_debut', $anneeEnCours)
            ->get();

        $totalJoursUtilises = $demandesApprouvees->sum('jours');
        $totalTypesConges   = $demandesApprouvees->pluck('type')->unique()->count();
        $demandesEnAttente  = LeaveRequest::where('user_id', $user->id)
            ->where('statut', 'en_attente')
            ->count();

        // ----- Activité récente (les 4 dernières demandes approuvées) -----
        $libellesTypes = [
            'paye'         => 'Congés annuels',
            'maladie'      => 'Congés maladie',
            'sans_solde'   => 'Congé sans solde',
            'exceptionnel' => 'Congés personnels',
            'rtt'          => 'RTT',
            'autre'        => 'Autre congé',
        ];
        $stylesTypes = [
            'paye'         => ['icone' => 'calendar',      'couleur' => '#3B82F6', 'rgb' => '59,130,246'],
            'maladie'      => ['icone' => 'heart',          'couleur' => '#F59E0B', 'rgb' => '245,158,11'],
            'sans_solde'   => ['icone' => 'user',            'couleur' => '#EF4444', 'rgb' => '239,68,68'],
            'exceptionnel' => ['icone' => 'user',            'couleur' => '#10B981', 'rgb' => '16,185,129'],
            'rtt'          => ['icone' => 'clock',           'couleur' => '#8B5CF6', 'rgb' => '139,92,246'],
            'autre'        => ['icone' => 'more-horizontal',  'couleur' => '#60A5FA', 'rgb' => '96,165,250'],
        ];

        $activitesRecentes = $demandesApprouvees
            ->sortByDesc('date_debut')
            ->take(4)
            ->map(function ($d) use ($libellesTypes, $stylesTypes) {
                $style = $stylesTypes[$d->type] ?? $stylesTypes['autre'];
                return [
                    'type'    => $libellesTypes[$d->type] ?? $d->type,
                    'periode' => $d->date_debut->format('d M').' - '.$d->date_fin->format('d M Y'),
                    'jours'   => $d->jours,
                    'statut'  => 'Approuvé',
                    'icone'   => $style['icone'],
                    'couleur' => $style['couleur'],
                    'rgb'     => $style['rgb'],
                ];
            })
            ->values();

        // ----- Détail par type de congé (catégories affichées sur la page) -----
        $typesConges = [
            [
                'label'   => 'Congés annuels',
                'utilise' => $joursUtilisesAnnuel,
                'restant' => $joursRestantsAnnuel,
                'total'   => $soldeAnnuelTotal,
                'regle'   => null,
                'icone'   => 'calendar',
                'couleur' => '#3B82F6',
                'rgb'     => '59,130,246',
            ],
            [
                'label'   => 'Congés maladie',
                'utilise' => $demandesApprouvees->where('type', 'maladie')->sum('jours'),
                'restant' => null,
                'total'   => null,
                'regle'   => 'Soumis à validation selon justificatif',
                'icone'   => 'heart',
                'couleur' => '#F59E0B',
                'rgb'     => '245,158,11',
            ],
            [
                'label'   => 'Congés personnels',
                'utilise' => $demandesApprouvees->where('type', 'exceptionnel')->sum('jours'),
                'restant' => null,
                'total'   => null,
                'regle'   => 'Soumis à validation selon le motif',
                'icone'   => 'user',
                'couleur' => '#10B981',
                'rgb'     => '16,185,129',
            ],
            [
                'label'   => 'RTT',
                'utilise' => $demandesApprouvees->where('type', 'rtt')->sum('jours'),
                'restant' => null,
                'total'   => null,
                'regle'   => "Selon les besoins de l'entreprise",
                'icone'   => 'clock',
                'couleur' => '#8B5CF6',
                'rgb'     => '139,92,246',
            ],
            [
                'label'   => 'Autre congé',
                'utilise' => $demandesApprouvees->whereIn('type', ['autre', 'sans_solde'])->sum('jours'),
                'restant' => null,
                'total'   => null,
                'regle'   => 'Soumis à validation selon le motif',
                'icone'   => 'more-horizontal',
                'couleur' => '#60A5FA',
                'rgb'     => '96,165,250',
            ],
        ];

        // ----- Prévision mensuelle (congés annuels uniquement, cumulé) -----
        $previsionParMois = [];
        $cumulUtilise = 0;

        for ($mois = 1; $mois <= 12; $mois++) {
            $utiliseCeMois = $demandesApprouvees
                ->where('type', 'paye')
                ->filter(fn ($d) => (int) $d->date_debut->format('n') === $mois)
                ->sum('jours');

            $cumulUtilise += $utiliseCeMois;

            $previsionParMois[] = [
                'utilise' => $cumulUtilise,
                'restant' => max(0, $soldeAnnuelTotal - $cumulUtilise),
            ];
        }

        return view('conges.solde', compact(
            'anneeEnCours',
            'soldeAnnuelTotal',
            'joursRestantsAnnuel',
            'joursUtilisesAnnuel',
            'totalJoursUtilises',
            'totalTypesConges',
            'demandesEnAttente',
            'activitesRecentes',
            'typesConges',
            'previsionParMois'
        ));
    }
}