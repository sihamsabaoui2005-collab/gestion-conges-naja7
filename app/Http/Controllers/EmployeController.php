<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    /**
     * Page RH : gestion des employés, regroupés par département
     */
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'rh') {
            abort(403);
        }

        $recherche         = $request->query('q');
        $departementFiltre = $request->query('departement');

        $typesConges   = ['paye', 'rtt', 'exceptionnel', 'autre'];
        $typesAbsences = ['maladie', 'sans_solde'];

        // ===== Départements avec compteur d'employés (pour la colonne de gauche) =====
        $departements = User::whereNotNull('departement')
            ->selectRaw('TRIM(departement) as departement, count(*) as total')
            ->groupBy('departement')
            ->pluck('total', 'departement')
            ->reject(fn ($total, $dep) => mb_strtolower($dep) === 'ressources humaines')
            ->sortKeys();

        $totalEmployes = User::whereRaw('LOWER(TRIM(departement)) != ? OR departement IS NULL', ['ressources humaines'])->count();

        // ===== Liste des employés (filtrée par recherche / département), groupée par département =====
        $requeteEmployes = User::whereRaw('LOWER(TRIM(departement)) != ? OR departement IS NULL', ['ressources humaines']);

        if ($recherche) {
            $requeteEmployes->where('name', 'like', "%{$recherche}%");
        }
        if ($departementFiltre) {
            if (mb_strtolower(trim($departementFiltre)) === 'ressources humaines') {
                abort(404);
            }
            $requeteEmployes->whereRaw('LOWER(TRIM(departement)) = ?', [mb_strtolower(trim($departementFiltre))]);
        }

        $tousLesEmployes = $requeteEmployes->orderBy('name')->get();

        // ===== Statut du jour (présent / en congé / absent), calculé une fois pour tous les employés =====
        $demandesAujourdhui = LeaveRequest::where('statut', 'approuve')
            ->whereDate('date_debut', '<=', now())
            ->whereDate('date_fin', '>=', now())
            ->get()
            ->keyBy('user_id');

        $calculerStatut = function ($employe) use ($demandesAujourdhui, $typesAbsences) {
            $demande = $demandesAujourdhui->get($employe->id);

            $statut = 'present';
            $jusquau = null;

            if ($demande) {
                $statut = in_array($demande->type, $typesAbsences) ? 'absent' : 'conge';
                $jusquau = $demande->date_fin;
            }

            return (object) ['user' => $employe, 'statut' => $statut, 'jusquau' => $jusquau];
        };

        // Liste affichée dans les sections (respecte la recherche / le filtre département)
        $employesAvecStatut = $tousLesEmployes->map($calculerStatut);

        $employesParDepartement = $employesAvecStatut
            ->groupBy(fn ($e) => $e->user->departement ? trim($e->user->departement) : 'Sans département')
            ->sortKeys();

        // Compteurs présents / en congé / absents PAR département (pour l'en-tête de chaque section)
        $statsParDepartement = $employesParDepartement->map(fn ($groupe) => [
            'presents' => $groupe->where('statut', 'present')->count(),
            'conge'    => $groupe->where('statut', 'conge')->count(),
            'absents'  => $groupe->where('statut', 'absent')->count(),
        ]);

        // ===== Statistiques du jour pour le panneau de droite : TOUJOURS sur l'ensemble de l'entreprise,
        // indépendamment de la recherche / du filtre département appliqué à la liste affichée =====
        $statutsGlobaux = User::whereRaw('LOWER(TRIM(departement)) != ? OR departement IS NULL', ['ressources humaines'])
            ->get()
            ->map($calculerStatut);

        $congeAujourdhui    = $statutsGlobaux->where('statut', 'conge')->count();
        $absentsAujourdhui  = $statutsGlobaux->where('statut', 'absent')->count();
        $presentsAujourdhui = $statutsGlobaux->where('statut', 'present')->count();

        // ===== Anniversaires du mois =====
        $anniversaires = User::whereNotNull('date_naissance')
            ->whereRaw('LOWER(TRIM(departement)) != ? OR departement IS NULL', ['ressources humaines'])
            ->whereMonth('date_naissance', now()->month)
            ->get()
            ->sortBy(fn ($u) => $u->date_naissance->day)
            ->values();

        return view('employes.index', compact(
            'departements',
            'totalEmployes',
            'employesParDepartement',
            'statsParDepartement',
            'departementFiltre',
            'recherche',
            'anniversaires',
            'presentsAujourdhui',
            'congeAujourdhui',
            'absentsAujourdhui'
        ));
    }

    /**
     * Formulaire de création d'un nouvel employé
     */
    public function create()
    {
        if (auth()->user()->role !== 'rh') {
            abort(403);
        }

        $departements = User::whereNotNull('departement')
            ->pluck('departement')
            ->map(fn ($d) => trim($d))
            ->unique()
            ->reject(fn ($d) => mb_strtolower($d) === 'ressources humaines')
            ->sort()
            ->values();

        return view('employes.create', compact('departements'));
    }

    /**
     * Enregistrer le nouvel employé
     */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'rh') {
            abort(403);
        }

        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'required|email|unique:users,email',
            'password'             => 'required|string|min:8',
            'role'                 => 'required|in:employe,rh',
            'poste'                => 'nullable|string|max:255',
            'departement'          => 'nullable|string|max:255',
            'solde_conges_annuel'  => 'nullable|integer|min:0',
            'telephone'            => 'nullable|string|max:30',
            'date_naissance'       => 'nullable|date',
            'lieu_naissance'       => 'nullable|string|max:255',
            'nationalite'          => 'nullable|string|max:255',
            'cin'                  => 'nullable|string|max:50',
            'adresse'              => 'nullable|string|max:500',
            'situation_familiale'  => 'nullable|string|max:100',
            'photo'                => 'nullable|image|max:3072',
        ]);

        $cheminPhoto = $request->hasFile('photo')
            ? $request->file('photo')->store('photos-employes', 'public')
            : null;

        User::create([
            'name'                 => $validated['name'],
            'email'                => $validated['email'],
            'password'             => \Illuminate\Support\Facades\Hash::make($validated['password']),
            'role'                 => $validated['role'],
            'poste'                => $validated['poste'] ?? null,
            'departement'          => $validated['departement'] ?? null,
            'solde_conges_annuel'  => $validated['solde_conges_annuel'] ?? 21,
            'photo_path'           => $cheminPhoto,
            'telephone'            => $validated['telephone'] ?? null,
            'date_naissance'       => $validated['date_naissance'] ?? null,
            'lieu_naissance'       => $validated['lieu_naissance'] ?? null,
            'nationalite'          => $validated['nationalite'] ?? null,
            'cin'                  => $validated['cin'] ?? null,
            'adresse'              => $validated['adresse'] ?? null,
            'situation_familiale'  => $validated['situation_familiale'] ?? null,
        ]);

        return redirect()
            ->route('employes.index')
            ->with('success', 'Employé ajouté avec succès.');
    }
}