<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\User;
use App\Notifications\LeaveRequestDecided;
use App\Notifications\LeaveRequestReopened;
use App\Notifications\NewCommentOnLeaveRequest;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function create()
    {
        return view('conges.create');
    }

    public function store(Request $request)
    {
        // NB : ce chemin (formulaire classique) n'est plus utilisé depuis que la page
        // /conges/nouvelle passe par le composant Livewire NouvelleDemande, qui crée
        // la demande lui-même. Gardé ici pour compatibilité, mis à jour avec les mêmes types.
        $validated = $request->validate([
            'type'        => 'required|in:paye,maladie,sans_solde,exceptionnel,rtt,autre',
            'date_debut'  => 'required|date|after_or_equal:today',
            'date_fin'    => 'required|date|after_or_equal:date_debut',
            'motif'       => 'nullable|string|max:1000',
        ]);

        $debut = \Carbon\Carbon::parse($validated['date_debut']);
        $fin   = \Carbon\Carbon::parse($validated['date_fin']);
        $jours = $debut->diffInDays($fin) + 1;

        $user = auth()->user();
        if ($validated['type'] === 'paye' && $jours > $user->solde_conges_annuel) {
            return back()
                ->withInput()
                ->withErrors(['jours' => "Solde insuffisant. Tu demandes {$jours} jour(s) mais il te reste {$user->solde_conges_annuel} jour(s)."]);
        }

        LeaveRequest::create([
            'user_id'     => $user->id,
            'type'        => $validated['type'],
            'date_debut'  => $validated['date_debut'],
            'date_fin'    => $validated['date_fin'],
            'jours'       => $jours,
            'motif'       => $validated['motif'] ?? null,
        ]);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Ta demande de congé a été envoyée. Elle est en attente de validation.');
    }

    /**
     * Page employé : "Mes demandes" — liste simple de ses propres demandes,
     * avec filtre par statut et compteurs (sans les widgets de la page Historique).
     * Alimente la vue conges.mes-demandes.
     */
    public function mesDemandes(Request $request)
    {
        $user = auth()->user();

        $statut = $request->query('statut'); // 'en_attente' | 'approuve' | 'refuse' | null (toutes)
        $du     = $request->query('du');
        $au     = $request->query('au');

        $requete = LeaveRequest::where('user_id', $user->id)->with('comments.user');

        if ($statut) {
            $requete->where('statut', $statut);
        }
        if ($du) {
            $requete->where('date_debut', '>=', $du);
        }
        if ($au) {
            $requete->where('date_fin', '<=', $au);
        }

        $demandes = $requete->orderBy('date_debut', 'desc')->get();

        // Compteurs globaux (non filtrés) pour les cartes stats et le panneau de filtres
        $toutesLesDemandes = LeaveRequest::where('user_id', $user->id)->get();

        return view('conges.mes-demandes', [
            'demandes'   => $demandes,
            'total'      => $toutesLesDemandes->count(),
            'approuvees' => $toutesLesDemandes->where('statut', 'approuve')->count(),
            'enAttente'  => $toutesLesDemandes->where('statut', 'en_attente')->count(),
            'refusees'   => $toutesLesDemandes->where('statut', 'refuse')->count(),
            'statut'     => $statut,
        ]);
    }

    /**
     * Page employé : "Historique de mes demandes" — timeline + filtres + widgets,
     * alimente la vue conges.historique.
     */
    public function historique(Request $request)
    {
        $user = auth()->user();

        $statut = $request->query('statut'); // 'en_attente' | 'approuve' | 'refuse' | null (toutes)
        $du     = $request->query('du');
        $au     = $request->query('au');

        $requete = LeaveRequest::where('user_id', $user->id)->with('comments.user');

        if ($statut) {
            $requete->where('statut', $statut);
        }
        if ($du) {
            $requete->where('date_debut', '>=', $du);
        }
        if ($au) {
            $requete->where('date_fin', '<=', $au);
        }

        $demandes = $requete->orderBy('date_debut', 'desc')->get();

        // Compteurs globaux (non filtrés) pour les widgets et le panneau de filtres
        $toutesLesDemandes = LeaveRequest::where('user_id', $user->id)->get();

        // ===== Solde de congés (widget "Mon solde de congés") =====
        $soldeMax     = 30; // solde annuel de référence choisi pour le projet
        $soldeRestant = $user->solde_conges_annuel;
        $soldeUtilisePct = $soldeMax > 0
            ? round((($soldeMax - $soldeRestant) / $soldeMax) * 100)
            : 0;

        // ===== Répartition par type (widget "Répartition par type") =====
        // Basée sur TOUTES les demandes de l'employé (pas seulement la liste filtrée),
        // pour donner une vue d'ensemble stable même quand un onglet de statut est actif.
        $repartitionParType = $toutesLesDemandes->groupBy('type')->map->count();

        // ===== Activité mensuelle de l'année en cours (widget "Activité annuelle") =====
        $anneeActuelle = now()->year;
        $activiteMensuelle = collect(range(1, 12))->mapWithKeys(function ($mois) use ($toutesLesDemandes, $anneeActuelle) {
            $count = $toutesLesDemandes->filter(function ($d) use ($mois, $anneeActuelle) {
                return (int) $d->date_debut->format('Y') === $anneeActuelle
                    && (int) $d->date_debut->format('n') === $mois;
            })->count();

            return [$mois => $count];
        });

        return view('conges.historique', [
            'demandes'           => $demandes,
            'total'              => $toutesLesDemandes->count(),
            'approuvees'         => $toutesLesDemandes->where('statut', 'approuve')->count(),
            'enAttente'          => $toutesLesDemandes->where('statut', 'en_attente')->count(),
            'refusees'           => $toutesLesDemandes->where('statut', 'refuse')->count(),
            'statut'             => $statut,
            'soldeMax'           => $soldeMax,
            'soldeRestant'       => $soldeRestant,
            'soldeUtilisePct'    => $soldeUtilisePct,
            'repartitionParType' => $repartitionParType,
            'activiteMensuelle'  => $activiteMensuelle,
            'anneeActuelle'      => $anneeActuelle,
        ]);
    }

    /**
     * Annuler une demande encore en attente (par l'employé qui l'a créée)
     */
    public function annuler(LeaveRequest $leaveRequest)
    {
        if ($leaveRequest->user_id !== auth()->id()) {
            abort(403);
        }

        if ($leaveRequest->statut !== 'en_attente') {
            return back()->with('error', 'Seules les demandes en attente peuvent être annulées.');
        }

        $leaveRequest->delete();

        return back()->with('success', 'Ta demande a été annulée.');
    }

    /**
     * Page RH : liste des demandes avec filtres, onglets, statistiques et alertes
     */
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'rh') {
            abort(403);
        }

        $departement = $request->query('departement');
        $type        = $request->query('type');
        $statut      = $request->query('statut'); // 'toutes' | 'a_valider' | 'en_attente' | 'approuve' | 'refuse'
        $recherche   = $request->query('q');
        $tri         = $request->query('tri', 'date_desc');

        $requete = LeaveRequest::with('user');

        switch ($tri) {
            case 'date_asc':
                $requete->orderBy('date_debut', 'asc');
                break;
            case 'statut_asc':
                $requete->orderBy('statut', 'asc');
                break;
            case 'statut_desc':
                $requete->orderBy('statut', 'desc');
                break;
            case 'type_asc':
                $requete->orderBy('type', 'asc');
                break;
            case 'type_desc':
                $requete->orderBy('type', 'desc');
                break;
            default:
                $tri = 'date_desc';
                $requete->orderBy('date_debut', 'desc');
                break;
        }

        $triOptions = [
            'date_desc'   => 'Date (plus récente)',
            'date_asc'    => 'Date (plus ancienne)',
            'statut_asc'  => 'Statut (A → Z)',
            'statut_desc' => 'Statut (Z → A)',
            'type_asc'    => 'Type de congé (A → Z)',
            'type_desc'   => 'Type de congé (Z → A)',
        ];

        if ($departement) {
            $requete->whereHas('user', fn ($q) => $q->where('departement', $departement));
        }
        if ($type) {
            $requete->where('type', $type);
        }
        if ($recherche) {
            $requete->whereHas('user', fn ($q) => $q->where('name', 'like', "%{$recherche}%"));
        }

        $toutesDemandes = $requete->get();

        // "À valider" = en attente ET la date de début arrive dans moins de 7 jours (urgent)
        $seuilUrgence = now()->addDays(7);
        $aValiderIds = $toutesDemandes
            ->where('statut', 'en_attente')
            ->filter(fn ($d) => $d->date_debut->lte($seuilUrgence))
            ->pluck('id');

        // Regroupement affiché selon l'onglet actif
        if ($statut === 'a_valider') {
            $demandes = collect(['a_valider' => $toutesDemandes->whereIn('id', $aValiderIds)]);
        } elseif ($statut && $statut !== 'toutes') {
            $demandes = $toutesDemandes->where('statut', $statut)->groupBy('statut');
        } else {
            $demandes = $toutesDemandes->groupBy(function ($d) use ($aValiderIds) {
                if ($d->statut === 'en_attente') {
                    return $aValiderIds->contains($d->id) ? 'a_valider' : 'en_attente';
                }
                return $d->statut;
            });
        }

        // ===== Compteurs pour les onglets (sur l'ensemble, pas juste la page filtrée) =====
        $toutes = LeaveRequest::count();
        $enAttenteToutes = LeaveRequest::where('statut', 'en_attente')->with('user')->get();
        $countAValider  = $enAttenteToutes->filter(fn ($d) => $d->date_debut->lte($seuilUrgence))->count();
        $countEnAttente = $enAttenteToutes->count() - $countAValider;
        $countApprouvees = LeaveRequest::where('statut', 'approuve')->count();
        $countRefusees    = LeaveRequest::where('statut', 'refuse')->count();

        // ===== Départements pour le filtre (on exclut "Ressources Humaines", même logique
        // que sur les pages Aperçu et Détail département) =====
        $departements = User::whereNotNull('departement')
            ->distinct()
            ->pluck('departement')
            ->map(fn ($d) => trim($d))
            ->unique()
            ->reject(fn ($d) => mb_strtolower($d) === 'ressources humaines')
            ->sort()
            ->values();

        // ===== Alertes & conflits (calculées sur les vraies données) =====
        $conflitsParDepartement = [];
        foreach ($enAttenteToutes->groupBy(fn ($d) => $d->user->departement ?? 'Sans département') as $dep => $groupe) {
            if ($groupe->count() < 2) continue;
            $chevauche = false;
            foreach ($groupe as $a) {
                foreach ($groupe as $b) {
                    if ($a->id !== $b->id && $a->date_debut->lte($b->date_fin) && $b->date_debut->lte($a->date_fin)) {
                        $chevauche = true;
                    }
                }
            }
            if ($chevauche) $conflitsParDepartement[] = $dep;
        }
        $nombreConflits = count($conflitsParDepartement);

        $soldeFaibleCount = $enAttenteToutes
            ->where('type', 'paye')
            ->filter(fn ($d) => $d->user && ($d->user->solde_conges_annuel - $d->jours) < 5 && ($d->user->solde_conges_annuel - $d->jours) >= 0)
            ->count();

        $congesLongsCount = $enAttenteToutes->where('jours', '>', 10)->count();

        return view('conges.index', compact(
            'demandes',
            'toutes',
            'countAValider',
            'countEnAttente',
            'countApprouvees',
            'countRefusees',
            'departements',
            'departement',
            'type',
            'statut',
            'recherche',
            'nombreConflits',
            'soldeFaibleCount',
            'congesLongsCount',
            'tri',
            'triOptions'
        ));
    }

    /**
     * Page RH : vue d'ensemble des congés & absences, regroupée par département
     */
    public function apercu(Request $request)
    {
        if (auth()->user()->role !== 'rh') {
            abort(403);
        }

        $debut = $request->filled('debut') ? \Carbon\Carbon::parse($request->debut) : now()->startOfYear();
        $fin   = $request->filled('fin')   ? \Carbon\Carbon::parse($request->fin)   : now()->endOfYear();
        $departementFiltre = $request->input('departement');

        // Congés = absences planifiées à l'avance | Absences = subies / non planifiées
        $typesConges   = ['paye', 'rtt', 'exceptionnel', 'autre'];
        $typesAbsences = ['maladie', 'sans_solde'];

        $listeDepartements = User::whereNotNull('departement')
            ->distinct()
            ->pluck('departement')
            ->map(fn ($d) => trim($d))
            ->unique()
            ->reject(fn ($d) => mb_strtolower($d) === 'ressources humaines')
            ->sort()
            ->values();

        $departementsData = [];

        foreach ($listeDepartements as $dep) {
            if ($departementFiltre && mb_strtolower(trim($departementFiltre)) !== mb_strtolower($dep)) {
                continue;
            }

            $employesIds = User::whereRaw('LOWER(TRIM(departement)) = ?', [mb_strtolower($dep)])->pluck('id');

            $demandes = LeaveRequest::whereIn('user_id', $employesIds)
                ->where('statut', 'approuve')
                ->where('date_debut', '<=', $fin)
                ->where('date_fin', '>=', $debut)
                ->with('user')
                ->get();

            $conges   = $demandes->whereIn('type', $typesConges)->sortBy('date_debut')->values();
            $absences = $demandes->whereIn('type', $typesAbsences)->sortBy('date_debut')->values();

            $departementsData[] = [
                'nom'             => $dep,
                'nb_employes'     => $employesIds->count(),
                'conges_jours'    => $conges->sum('jours'),
                'conges_liste'    => $conges,
                'absences_jours'  => $absences->sum('jours'),
                'absences_liste'  => $absences,
            ];
        }

        // Répartition par type sur la période, toutes équipes confondues (pour le donut "Aperçu du mois")
        $demandesMois = LeaveRequest::where('statut', 'approuve')
            ->where('date_debut', '<=', $fin)
            ->where('date_fin', '>=', $debut)
            ->get();

        $totalJoursMois     = $demandesMois->sum('jours');
        $repartitionParType = $demandesMois->groupBy('type')->map(fn ($g) => $g->sum('jours'));

        // Congés/absences en cours aujourd'hui, toutes équipes
        $absencesAujourdhui = LeaveRequest::where('statut', 'approuve')
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now())
            ->with('user')
            ->get();

        return view('conges.apercu', compact(
            'departementsData',
            'listeDepartements',
            'departementFiltre',
            'debut',
            'fin',
            'totalJoursMois',
            'repartitionParType',
            'absencesAujourdhui'
        ));
    }

    /**
     * Page RH : détail des congés & absences d'UN département (liste employé par employé)
     */
    public function departementDetail(Request $request, string $departement)
    {
        if (auth()->user()->role !== 'rh') {
            abort(403);
        }

        $debut = $request->filled('debut') ? \Carbon\Carbon::parse($request->debut) : now()->startOfYear();
        $fin   = $request->filled('fin')   ? \Carbon\Carbon::parse($request->fin)   : now()->endOfYear();

        $typesConges   = ['paye', 'rtt', 'exceptionnel', 'autre'];
        $typesAbsences = ['maladie', 'sans_solde'];

        $listeDepartements = User::whereNotNull('departement')
            ->distinct()
            ->pluck('departement')
            ->map(fn ($d) => trim($d))
            ->unique()
            ->reject(fn ($d) => mb_strtolower($d) === 'ressources humaines')
            ->sort()
            ->values();

        $departement = trim($departement);

        if (mb_strtolower($departement) === 'ressources humaines') {
            abort(404);
        }

        $employesIds = User::whereRaw('LOWER(TRIM(departement)) = ?', [mb_strtolower($departement)])->pluck('id');
        $nbEmployes  = $employesIds->count();

        // Congés et absences mélangés, triés par date, pour le tableau détaillé de ce département
        $demandes = LeaveRequest::whereIn('user_id', $employesIds)
            ->where('statut', 'approuve')
            ->where('date_debut', '<=', $fin)
            ->where('date_fin', '>=', $debut)
            ->with('user')
            ->orderBy('date_debut')
            ->get();

        $congesJours   = $demandes->whereIn('type', $typesConges)->sum('jours');
        $absencesJours = $demandes->whereIn('type', $typesAbsences)->sum('jours');

        // Aperçu du mois + absences aujourd'hui : mêmes indicateurs globaux que sur la page d'ensemble
        $demandesMois = LeaveRequest::where('statut', 'approuve')
            ->where('date_debut', '<=', $fin)
            ->where('date_fin', '>=', $debut)
            ->get();

        $totalJoursMois     = $demandesMois->sum('jours');
        $repartitionParType = $demandesMois->groupBy('type')->map(fn ($g) => $g->sum('jours'));

        $absencesAujourdhui = LeaveRequest::where('statut', 'approuve')
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now())
            ->with('user')
            ->get();

        return view('conges.departement', compact(
            'departement',
            'listeDepartements',
            'nbEmployes',
            'demandes',
            'congesJours',
            'absencesJours',
            'debut',
            'fin',
            'totalJoursMois',
            'repartitionParType',
            'absencesAujourdhui',
            'typesConges',
            'typesAbsences'
        ));
    }

    /**
     * Page de détail d'une demande (RH) : infos employé, historique, commentaires, décision
     */
    public function show(LeaveRequest $leaveRequest)
    {
        if (auth()->user()->role !== 'rh') {
            abort(403);
        }

        $leaveRequest->load(['user', 'validateur', 'comments.user']);

        $employe = $leaveRequest->user;

        $autresDemandesEnAttente = LeaveRequest::with('user')
            ->where('statut', 'en_attente')
            ->where('id', '!=', $leaveRequest->id)
            ->latest()
            ->take(4)
            ->get();

        $equipe = User::where('departement', $employe->departement)
            ->where('id', '!=', $employe->id)
            ->take(6)
            ->get();

        $joursUtilises = LeaveRequest::where('user_id', $employe->id)
            ->where('type', 'paye')
            ->where('statut', 'approuve')
            ->whereYear('date_debut', now()->year)
            ->sum('jours');

        // Si la demande est déjà approuvée, le solde a déjà été décompté au moment
        // de l'approbation : on ne doit pas soustraire les jours une seconde fois.
        if ($leaveRequest->statut === 'approuve') {
            $apresValidation = $employe->solde_conges_annuel;
        } elseif ($leaveRequest->type === 'paye') {
            $apresValidation = max($employe->solde_conges_annuel - $leaveRequest->jours, 0);
        } else {
            $apresValidation = $employe->solde_conges_annuel;
        }

        $libelles = [
            'paye'         => 'Congé annuel',
            'maladie'      => 'Congé maladie',
            'sans_solde'   => 'Congé sans solde',
            'exceptionnel' => 'Congé exceptionnel',
            'rtt'          => 'RTT / Récupération',
            'autre'        => 'Autre congé',
        ];

        return view('conges.show', compact(
            'leaveRequest',
            'employe',
            'autresDemandesEnAttente',
            'equipe',
            'joursUtilises',
            'apresValidation',
            'libelles'
        ));
    }

    /**
     * Ajouter un commentaire sur une demande (RH ou employé concerné)
     */
    public function storeComment(Request $request, LeaveRequest $leaveRequest)
    {
        $user = auth()->user();

        if ($user->role !== 'rh' && $user->id !== $leaveRequest->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'message'     => 'required|string|max:2000',
            'visibilite'  => 'required|in:employe,interne',
        ]);

        if ($user->role !== 'rh') {
            $validated['visibilite'] = 'employe';
        }

        $leaveRequest->comments()->create([
            'user_id'    => $user->id,
            'message'    => $validated['message'],
            'visibilite' => $validated['visibilite'],
        ]);

        if ($user->role === 'rh' && $validated['visibilite'] === 'employe') {
            $leaveRequest->user->notify(new NewCommentOnLeaveRequest($leaveRequest));
        }

        return back()->with('success', 'Commentaire ajouté.');
    }

    public function approve(Request $request, LeaveRequest $leaveRequest)
    {
        if (auth()->user()->role !== 'rh') {
            abort(403);
        }

        if ($leaveRequest->statut !== 'en_attente') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        if ($leaveRequest->type === 'paye') {
            $employe = $leaveRequest->user;
            $employe->decrement('solde_conges_annuel', $leaveRequest->jours);
            $employe->refresh();

            if ($employe->notif_solde && $employe->solde_conges_annuel < 5) {
                $employe->notify(new \App\Notifications\SoldeFaibleReminder($employe->solde_conges_annuel));
            }
        }

        $leaveRequest->update([
            'statut'     => 'approuve',
            'valide_par' => auth()->id(),
            'valide_le'  => now(),
        ]);

        if ($request->filled('commentaire')) {
            $leaveRequest->comments()->create([
                'user_id'    => auth()->id(),
                'message'    => $request->input('commentaire'),
                'visibilite' => $request->input('visibilite', 'employe'),
            ]);
        }

        $leaveRequest->user->notify(new LeaveRequestDecided($leaveRequest));

        return back()->with('success', 'Demande approuvée.');
    }

    public function reject(Request $request, LeaveRequest $leaveRequest)
    {
        if (auth()->user()->role !== 'rh') {
            abort(403);
        }

        if ($leaveRequest->statut !== 'en_attente') {
            return back()->with('error', 'Cette demande a déjà été traitée.');
        }

        $request->validate([
            'commentaire' => 'required|string|max:2000',
        ], [
            'commentaire.required' => 'Un commentaire est obligatoire pour justifier un refus.',
        ]);

        $leaveRequest->update([
            'statut'     => 'refuse',
            'valide_par' => auth()->id(),
            'valide_le'  => now(),
        ]);

        $leaveRequest->comments()->create([
            'user_id'    => auth()->id(),
            'message'    => $request->input('commentaire'),
            'visibilite' => $request->input('visibilite', 'employe'),
        ]);

        $leaveRequest->user->notify(new LeaveRequestDecided($leaveRequest));

        return back()->with('success', 'Demande refusée.');
    }

    /**
     * Annuler une décision déjà prise (approbation ou refus) : remet la demande
     * en attente, recrédite le solde si c'était un congé payé approuvé,
     * et notifie l'employé.
     */
    public function annulerDecision(LeaveRequest $leaveRequest)
    {
        if (auth()->user()->role !== 'rh') {
            abort(403);
        }

        if (!in_array($leaveRequest->statut, ['approuve', 'refuse'])) {
            return back()->with('error', 'Seules les demandes déjà approuvées ou refusées peuvent être réouvertes.');
        }

        if ($leaveRequest->statut === 'approuve' && $leaveRequest->type === 'paye') {
            $leaveRequest->user->increment('solde_conges_annuel', $leaveRequest->jours);
        }

        $leaveRequest->update([
            'statut'     => 'en_attente',
            'valide_par' => null,
            'valide_le'  => null,
        ]);

        $leaveRequest->user->notify(new LeaveRequestReopened($leaveRequest));

        return back()->with('success', 'La décision a été annulée. La demande est de nouveau en attente.');
    }
}