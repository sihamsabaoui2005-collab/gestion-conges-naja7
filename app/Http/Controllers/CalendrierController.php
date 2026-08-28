<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendrierController extends Controller
{
    /**
     * Page calendrier : une seule route/vue, adaptée selon le rôle connecté.
     * RH  -> calendrier de toute l'équipe (par département, avec filtres, puces par jour).
     * Employé -> calendrier de SES SEULES demandes, affichées en barres façon maquette,
     *            avec panneau de stats et "Prochains congés".
     */
    public function index(Request $request)
    {
        $estRh = auth()->user()->role === 'rh';

        $moisParam = $request->query('mois');

        if ($request->filled('moisNum') && $request->filled('anneeNum')) {
            $moisParam = $request->query('anneeNum').'-'.str_pad($request->query('moisNum'), 2, '0', STR_PAD_LEFT);
        }

        $mois = $moisParam
            ? Carbon::createFromFormat('Y-m', $moisParam)->startOfMonth()
            : now()->startOfMonth();

        $moisNumActuel  = $mois->format('m');
        $anneeActuelle  = (int) $mois->format('Y');
        $moisParam      = $mois->format('Y-m');

        // Un employé ne peut pas filtrer par département : c'est toujours SON calendrier.
        $departementFiltre = $estRh ? $request->query('departement') : null;
        $typeFiltre         = $request->query('type');

        $debutGrille = $mois->copy()->startOfMonth()->startOfWeek(Carbon::MONDAY);
        $finGrille   = $mois->copy()->endOfMonth()->endOfWeek(Carbon::SUNDAY);

        if ($estRh) {
            $departements = User::whereNotNull('departement')
                ->selectRaw('TRIM(departement) as departement, count(*) as total')
                ->groupBy('departement')
                ->pluck('total', 'departement')
                ->reject(fn ($total, $dep) => mb_strtolower($dep) === 'ressources humaines')
                ->sortKeys();

            $totalEmployes = User::whereRaw('LOWER(TRIM(departement)) != ? OR departement IS NULL', ['ressources humaines'])->count();
        } else {
            $departements  = collect();
            $totalEmployes = 1;
        }

        // ===== Demandes (approuvées + en attente) qui touchent la grille affichée =====
        $requeteDemandes = LeaveRequest::whereIn('statut', ['approuve', 'en_attente'])
            ->where('date_debut', '<=', $finGrille)
            ->where('date_fin', '>=', $debutGrille)
            ->with('user');

        if (!$estRh) {
            $requeteDemandes->where('user_id', auth()->id());
        } elseif ($departementFiltre) {
            if (mb_strtolower(trim($departementFiltre)) === 'ressources humaines') {
                abort(404);
            }
            $requeteDemandes->whereHas('user', fn ($q) => $q->whereRaw('LOWER(TRIM(departement)) = ?', [mb_strtolower(trim($departementFiltre))]));
        } else {
            $requeteDemandes->whereHas('user', fn ($q) => $q->whereRaw('LOWER(TRIM(departement)) != ? OR departement IS NULL', ['ressources humaines']));
        }

        if ($typeFiltre) {
            $requeteDemandes->where('type', $typeFiltre);
        }

        $demandes = $requeteDemandes->get();

        $typesConges = ['paye', 'rtt', 'exceptionnel', 'autre'];

        $libellesType = [
            'paye' => 'Congé annuel', 'rtt' => 'RTT', 'exceptionnel' => 'Congé exceptionnel',
            'autre' => 'Autre congé', 'maladie' => 'Congé maladie', 'sans_solde' => 'Congé sans solde',
        ];

        $metaCouleur = function ($d) use ($typesConges, $libellesType) {
            if ($d->statut === 'en_attente') {
                return ['couleur' => 'attente', 'icone' => 'clock', 'libelle' => 'En attente', 'bg' => 'var(--purple)'];
            }
            if ($d->type === 'maladie') {
                return ['couleur' => 'maladie', 'icone' => 'heart-pulse', 'libelle' => $libellesType[$d->type], 'bg' => 'var(--blue)'];
            }
            if (in_array($d->type, $typesConges)) {
                return ['couleur' => 'conge', 'icone' => 'palmtree', 'libelle' => $libellesType[$d->type] ?? $d->type, 'bg' => 'var(--orange)'];
            }
            return ['couleur' => 'autre', 'icone' => 'calendar', 'libelle' => $libellesType[$d->type] ?? $d->type, 'bg' => 'var(--blue-2)'];
        };

        // ===== Construction de la grille (semaines de lundi à dimanche) =====
        $semaines = [];
        $semaine  = [];
        $curseur  = $debutGrille->copy();

        while ($curseur->lte($finGrille)) {
            $jourCourant = $curseur->copy();

            $demandesDuJour = $demandes
                ->filter(fn ($d) => $jourCourant->betweenIncluded($d->date_debut, $d->date_fin))
                ->map(function ($d) use ($jourCourant, $metaCouleur) {
                    $meta = $metaCouleur($d);
                    return [
                        'nom'         => $d->user->name ?? 'Employé supprimé',
                        'photo'       => $d->user->photo_path ?? null,
                        'jours'       => $d->jours,
                        'premierJour' => $jourCourant->isSameDay($d->date_debut),
                        'couleur'     => $meta['couleur'],
                        'icone'       => $meta['icone'],
                        'libelle'     => $meta['libelle'],
                    ];
                })
                ->values();

            $semaine[] = [
                'date'            => $jourCourant,
                'dansMoisCourant' => $jourCourant->month === $mois->month,
                'estAujourdhui'   => $jourCourant->isToday(),
                'demandes'        => $demandesDuJour,
            ];

            if ($curseur->dayOfWeekIso === 7) {
                // ===== Barres de la semaine (vue employé façon maquette) =====
                $debutSemaine = $semaine[0]['date'];
                $finSemaine   = $semaine[6]['date'];

                $demandesSemaine = $demandes->filter(
                    fn ($d) => $d->date_debut->lte($finSemaine) && $d->date_fin->gte($debutSemaine)
                )->values();

                $barres = $demandesSemaine->map(function ($d, $i) use ($debutSemaine, $finSemaine, $metaCouleur) {
                    $meta = $metaCouleur($d);
                    $colDebut = $d->date_debut->lt($debutSemaine) ? 1 : $d->date_debut->dayOfWeekIso;
                    $colFin   = $d->date_fin->gt($finSemaine) ? 7 : $d->date_fin->dayOfWeekIso;

                    return [
                        'colDebut' => $colDebut,
                        'largeur'  => max(1, $colFin - $colDebut + 1),
                        'rowIndex' => $i,
                        'libelle'  => $meta['libelle'],
                        'bg'       => $meta['bg'],
                        'jours'    => $d->jours,
                    ];
                })->values();

                $semaines[] = ['jours' => $semaine, 'barres' => $barres];
                $semaine = [];
            }

            $curseur->addDay();
        }

        // ===== Aperçu rapide : compteurs sur le mois réel (pas la grille étendue), même filtre =====
        $requeteMois = LeaveRequest::where('date_debut', '<=', $mois->copy()->endOfMonth())
            ->where('date_fin', '>=', $mois->copy()->startOfMonth());

        if (!$estRh) {
            $requeteMois->where('user_id', auth()->id());
        } elseif ($departementFiltre) {
            $requeteMois->whereHas('user', fn ($q) => $q->whereRaw('LOWER(TRIM(departement)) = ?', [mb_strtolower(trim($departementFiltre))]));
        } else {
            $requeteMois->whereHas('user', fn ($q) => $q->whereRaw('LOWER(TRIM(departement)) != ? OR departement IS NULL', ['ressources humaines']));
        }

        $demandesMois = $requeteMois->get();

        $congesApprouvesMois = $demandesMois->where('statut', 'approuve')->count();
        $enAttenteMois       = $demandesMois->where('statut', 'en_attente')->count();
        $refuseesMois        = $demandesMois->where('statut', 'refuse')->count();
        $totalDemandesMois   = $demandesMois->count();

        $moisPrecedent = $mois->copy()->subMonth()->format('Y-m');
        $moisSuivant   = $mois->copy()->addMonth()->format('Y-m');
        $libelleMois   = $mois->translatedFormat('F Y');

        // ===== Panneau droit "Mes congés et absences" + "Prochains congés" (employé uniquement) =====
        $congesPlanifies = null;
        $joursApprouvesAnnee = null;
        $joursAbsenceMaladie = null;
        $demandesRefuseesTotal = null;
        $prochainsConges = collect();

        if (!$estRh) {
            $userId = auth()->id();

            $congesPlanifies = LeaveRequest::where('user_id', $userId)
                ->whereIn('statut', ['approuve', 'en_attente'])
                ->where('date_debut', '>=', now())
                ->count();

            $joursApprouvesAnnee = LeaveRequest::where('user_id', $userId)
                ->whereIn('type', $typesConges)
                ->where('statut', 'approuve')
                ->whereYear('date_debut', now()->year)
                ->sum('jours');

            $joursAbsenceMaladie = LeaveRequest::where('user_id', $userId)
                ->where('type', 'maladie')
                ->where('statut', 'approuve')
                ->whereYear('date_debut', now()->year)
                ->sum('jours');

            // Le schéma actuel n'a pas de notion "justifiée / non justifiée" : on affiche
            // les demandes refusées comme 4e indicateur, le plus proche équivalent disponible.
            $demandesRefuseesTotal = LeaveRequest::where('user_id', $userId)
                ->where('statut', 'refuse')
                ->count();

            $prochainsConges = LeaveRequest::where('user_id', $userId)
                ->where('statut', 'approuve')
                ->where('date_debut', '>=', now())
                ->orderBy('date_debut')
                ->take(3)
                ->get();
        }

        return view('calendrier.index', compact(
            'estRh',
            'semaines',
            'departements',
            'totalEmployes',
            'departementFiltre',
            'typeFiltre',
            'libellesType',
            'moisParam',
            'moisNumActuel',
            'anneeActuelle',
            'moisPrecedent',
            'moisSuivant',
            'libelleMois',
            'congesApprouvesMois',
            'enAttenteMois',
            'refuseesMois',
            'totalDemandesMois',
            'congesPlanifies',
            'joursApprouvesAnnee',
            'joursAbsenceMaladie',
            'demandesRefuseesTotal',
            'prochainsConges'
        ));
    }
}