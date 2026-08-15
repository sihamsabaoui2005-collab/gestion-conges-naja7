<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\User;
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

        // ===== Départements pour le filtre =====
        $departements = User::whereNotNull('departement')->distinct()->pluck('departement');

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

        return back()->with('success', 'Demande refusée.');
    }
}