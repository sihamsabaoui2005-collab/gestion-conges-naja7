<?php

namespace App\Http\Controllers;

use App\Exports\RapportCongesExport;
use App\Models\LeaveRequest;
use App\Models\SavedReport;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        $departements = User::where('departement', '!=', 'Ressources Humaines')
            ->whereNotNull('departement')
            ->distinct()
            ->pluck('departement');

        $rapportsEnregistres = SavedReport::where('user_id', auth()->id())
            ->latest()
            ->take(6)
            ->get();

        return view('rapports.index', compact('departements', 'rapportsEnregistres'));
    }

    private function calculerDonnees(Request $request): array
    {
        $debut = Carbon::parse($request->input('periode_debut', now()->startOfYear()));
        $fin = Carbon::parse($request->input('periode_fin', now()->endOfYear()));

        $query = LeaveRequest::whereHas('user', function ($q) {
            $q->where('departement', '!=', 'Ressources Humaines');
        })->whereBetween('date_debut', [$debut, $fin]);

        if ($departements = $request->input('departements')) {
            $query->whereHas('user', fn($q) => $q->whereIn('departement', $departements));
        }
        if ($types = $request->input('types_conge')) {
            $query->whereIn('type', $types);
        }
        if ($statut = $request->input('statut')) {
            $query->where('statut', $statut);
        }

        $demandes = $query->with('user')->get();

        $repartitionType = $demandes->groupBy('type')->map->count();
        $repartitionDept = $demandes->groupBy('user.departement')
            ->map(fn($g) => (int) $g->where('statut', 'approuve')->sum('jours'));

        // Tendance mensuelle (nombre de demandes par mois sur la période)
        $tendanceMensuelle = $demandes->groupBy(fn($d) => $d->date_debut->format('Y-m'))
            ->map->count()
            ->sortKeys();

        // Top 5 employés par jours de congé approuvés
        $topEmployes = $demandes->where('statut', 'approuve')
            ->groupBy('user.name')
            ->map(fn($g) => (int) $g->sum('jours'))
            ->sortDesc()
            ->take(5);

        // Top départements par nombre de demandes (pas seulement jours approuvés)
        $topDeptDemandes = $demandes->groupBy('user.departement')
            ->map->count()
            ->sortDesc()
            ->take(5);

        // Détail par type : demandes, jours pris (approuvés), taux d'approbation
        $detailParType = $demandes->groupBy('type')->map(function ($g) {
            $total = $g->count();
            $approuvees = $g->where('statut', 'approuve')->count();
            return [
                'demandes' => $total,
                'jours' => (int) $g->where('statut', 'approuve')->sum('jours'),
                'taux_approbation' => $total > 0 ? round($approuvees / $total * 100) : 0,
            ];
        });

        // Délai moyen de traitement (jours entre soumission et décision), demandes déjà traitées uniquement
        $traitees = $demandes->whereIn('statut', ['approuve', 'refuse']);
        $delaiMoyen = $traitees->isNotEmpty()
            ? round($traitees->avg(fn($d) => $d->created_at->diffInDays($d->updated_at)), 1)
            : 0;

        // Jours moyens par employé, par département
        $moyenneParDeptEmploye = $demandes->where('statut', 'approuve')
            ->groupBy('user.departement')
            ->map(function ($g) {
                $nbEmployes = $g->pluck('user.name')->unique()->filter()->count();
                return $nbEmployes > 0 ? round($g->sum('jours') / $nbEmployes, 1) : 0;
            });

        // Statistiques complètes par département (pour le classement de l'Analyse Détaillée)
        $effectifQuery = User::where('departement', '!=', 'Ressources Humaines')->whereNotNull('departement');
        if ($departements) {
            $effectifQuery->whereIn('departement', $departements);
        }
        $effectifParDept = $effectifQuery->get()->groupBy('departement')->map->count();

        $departementsStats = $demandes->groupBy('user.departement')->map(function ($g, $dept) use ($effectifParDept) {
            $total = $g->count();
            $approuvees = $g->where('statut', 'approuve')->count();
            $refusees = $g->where('statut', 'refuse')->count();
            $jours = (int) $g->where('statut', 'approuve')->sum('jours');
            $effectif = $effectifParDept[$dept] ?? $g->pluck('user.name')->unique()->filter()->count();
            return [
                'effectif' => $effectif,
                'demandes' => $total,
                'jours' => $jours,
                'moyenne_par_employe' => $effectif > 0 ? round($jours / $effectif, 1) : 0,
                'taux_approbation' => ($approuvees + $refusees) > 0 ? round($approuvees / ($approuvees + $refusees) * 100) : 0,
            ];
        })->sortByDesc('moyenne_par_employe');

        // Tendance mensuelle par département (pour le graphique multi-lignes)
        $tendanceParDept = $demandes->groupBy('user.departement')->map(
            fn($g) => $g->groupBy(fn($d) => $d->date_debut->format('Y-m'))->map->count()->sortKeys()
        );

        // Comparaison 1ère moitié / 2e moitié de la période, par département
        $milieu = $debut->copy()->addDays($debut->diffInDays($fin) / 2);
        $premiereMoitie = $demandes->filter(fn($d) => $d->date_debut->lt($milieu));
        $deuxiemeMoitie = $demandes->filter(fn($d) => $d->date_debut->gte($milieu));
        $comparaisonPeriodes = $departementsStats->keys()->mapWithKeys(function ($dept) use ($premiereMoitie, $deuxiemeMoitie) {
            $n1 = $premiereMoitie->where('user.departement', $dept)->count();
            $n2 = $deuxiemeMoitie->where('user.departement', $dept)->count();
            return [$dept => [
                'periode_1' => $n1,
                'periode_2' => $n2,
                'evolution' => $n1 > 0 ? round((($n2 - $n1) / $n1) * 100) : ($n2 > 0 ? 100 : 0),
            ]];
        });

        // Détail des 5 employés en tête (jours, département, nb demandes, type dominant)
        $topEmployesDetail = $demandes->where('statut', 'approuve')
            ->groupBy('user.name')
            ->map(function ($g) {
                $typeDominant = $g->groupBy('type')->map->count()->sortDesc()->keys()->first();
                return [
                    'departement' => $g->first()->user->departement ?? '—',
                    'jours' => (int) $g->sum('jours'),
                    'demandes' => $g->count(),
                    'type_dominant' => $typeDominant,
                ];
            })
            ->sortByDesc('jours')
            ->take(5);

        return [
            'periode_debut' => $debut->format('d/m/Y'),
            'periode_fin' => $fin->format('d/m/Y'),
            'demandes_totales' => $demandes->count(),
            'approuvees' => $demandes->where('statut', 'approuve')->count(),
            'en_attente' => $demandes->where('statut', 'en_attente')->count(),
            'refusees' => $demandes->where('statut', 'refuse')->count(),
            'jours_utilises' => (int) $demandes->where('statut', 'approuve')->sum('jours'),
            'taux_approbation' => $demandes->count() > 0
                ? round($demandes->where('statut', 'approuve')->count() / $demandes->count() * 100)
                : 0,
            'taux_refus' => $demandes->count() > 0
                ? round($demandes->where('statut', 'refuse')->count() / $demandes->count() * 100)
                : 0,
            'duree_moyenne' => $demandes->count() > 0
                ? round($demandes->avg('jours'), 1)
                : 0,
            'repartition_par_type' => $repartitionType,
            'repartition_par_departement' => $repartitionDept,
            'departement_plus_demandeur' => $repartitionDept->isNotEmpty() ? $repartitionDept->sortDesc()->keys()->first() : null,
            'type_plus_utilise' => $repartitionType->isNotEmpty() ? $repartitionType->sortDesc()->keys()->first() : null,
            'tendance_mensuelle' => $tendanceMensuelle,
            'top_employes' => $topEmployes,
            'top_departements_demandes' => $topDeptDemandes,
            'nb_employes_concernes' => $demandes->pluck('user.name')->unique()->filter()->count(),
            'detail_par_type' => $detailParType,
            'delai_moyen_traitement' => $delaiMoyen,
            'moyenne_jours_par_employe_departement' => $moyenneParDeptEmploye,
            'nb_departements' => $demandes->pluck('user.departement')->unique()->filter()->count(),
            'departements_stats' => $departementsStats,
            'tendance_par_departement' => $tendanceParDept,
            'comparaison_periodes' => $comparaisonPeriodes,
            'top_employes_detail' => $topEmployesDetail,
        ];
    }

    /**
     * Génère un rapport. Si "ai"=false (génération manuelle), on calcule
     * uniquement les statistiques sans appeler l'IA.
     */
    public function generate(Request $request)
    {
        $donnees = $this->calculerDonnees($request);
        $utiliserIa = filter_var($request->input('ai', true), FILTER_VALIDATE_BOOLEAN);

        $resumeIa = null;

        if ($utiliserIa) {
            try {
                $resumeIa = $this->appellerGemini(
                    "Voici les statistiques de congés RH suivantes au format JSON : "
                    . json_encode($donnees, JSON_UNESCAPED_UNICODE)
                    . ". Rédige un résumé clair et professionnel en français (5-8 lignes) qui met en avant les tendances, anomalies et points d'attention pour un responsable RH."
                );
            } catch (\Throwable $e) {
                Log::error('Erreur génération résumé IA rapport', ['message' => $e->getMessage()]);
                return response()->json([
                    'success' => false,
                    'error' => "L'IA n'a pas pu générer le résumé. Vérifie ta clé API et le nom du modèle dans .env / ReportController. Détail technique: " . $e->getMessage(),
                ], 500);
            }
        }

        try {
            $rapport = SavedReport::create([
                'user_id' => auth()->id(),
                'titre' => $request->input('titre', 'Rapport du ' . now()->format('d/m/Y')),
                'format' => $request->input('format', 'pdf'),
                'modele_rapport' => $request->input('modele_rapport', 'standard'),
                'periode_debut' => $request->input('periode_debut', now()->startOfYear()),
                'periode_fin' => $request->input('periode_fin', now()->endOfYear()),
                'departements' => $request->input('departements'),
                'types_conge' => $request->input('types_conge'),
                // FIX : ce champ représente le statut du RAPPORT lui-même (ex: "généré"),
                // pas le filtre de statut des demandes de congé (approuvé/en_attente/refusé)
                // utilisé plus haut dans calculerDonnees(). Réutiliser $request->input('statut')
                // ici insérait souvent NULL (le filtre étant optionnel), ce qui violait la
                // contrainte NOT NULL de la colonne 'statut' en base.
                'statut' => 'genere',
                'regroupement' => $request->input('regroupement', 'mois'),
                'indicateurs' => $request->input('indicateurs'),
                'donnees' => $donnees,
                'resume_ia' => $resumeIa,
            ]);
        } catch (\Throwable $e) {
            Log::error('Erreur enregistrement rapport', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'error' => "Erreur lors de l'enregistrement du rapport : " . $e->getMessage(),
            ], 500);
        }

        try {
            $apercuHtml = view('exports.partials.body-' . $rapport->modele_rapport, ['rapport' => $rapport])->render();
        } catch (\Throwable $e) {
            Log::error('Erreur rendu aperçu rapport', ['message' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'error' => "Le rapport a été enregistré mais l'aperçu n'a pas pu être généré : " . $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'success' => true,
            'rapport' => $rapport,
            'apercu_html' => $apercuHtml,
        ]);
    }

    /**
     * Modifie un rapport déjà enregistré : titre, résumé et/ou contenu édité
     * directement dans l'aperçu (sans tout régénérer).
     */
    public function update(Request $request, SavedReport $rapport)
    {
        if ($rapport->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'titre' => 'nullable|string|max:255',
            'resume_ia' => 'nullable|string',
            'contenu_html' => 'nullable|string',
        ]);

        $rapport->update([
            'titre' => $request->input('titre', $rapport->titre),
            'resume_ia' => $request->input('resume_ia', $rapport->resume_ia),
            'contenu_html' => $request->input('contenu_html', $rapport->contenu_html),
        ]);

        return response()->json(['success' => true, 'rapport' => $rapport]);
    }

    public function export(SavedReport $rapport, Request $request)
    {
        if ($rapport->user_id !== auth()->id()) {
            abort(403);
        }

        $format = $request->query('format', $rapport->format);

        if ($format === 'pdf') {
            // Priorité 1 : contenu édité manuellement dans l'aperçu (WYSIWYG).
            // Priorité 2 : template propre au modèle choisi (standard/détaillé/exécutif).
            // Priorité 3 : ancien template générique.
            if ($rapport->contenu_html) {
                $vue = 'exports.rapport-pdf-editable';
            } else {
                $vue = match ($rapport->modele_rapport) {
                    'detaille' => 'exports.rapport-detaille-pdf',
                    'executif' => 'exports.rapport-executif-pdf',
                    default => 'exports.rapport-standard-pdf',
                };
            }
            $pdf = Pdf::loadView($vue, ['rapport' => $rapport]);
            return $pdf->download('rapport-' . $rapport->id . '.pdf');
        }

        if ($format === 'excel') {
            return Excel::download(new RapportCongesExport($rapport), 'rapport-' . $rapport->id . '.xlsx');
        }

        abort(404);
    }

    public function destroy(SavedReport $rapport)
    {
        if ($rapport->user_id !== auth()->id()) {
            abort(403);
        }

        $rapport->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Appel générique à l'API Google Gemini (gratuite).
     * Conservé pour un usage futur éventuel (l'appel n'est plus déclenché
     * depuis la page Rapports, qui envoie toujours ai=false).
     */
    private function appellerGemini(string $prompt): string
    {
        $apiKey = config('services.gemini.api_key');

        if (empty($apiKey)) {
            throw new \Exception("GEMINI_API_KEY absente ou vide dans .env / config/services.php.");
        }

        $modele = config('services.gemini.model', 'gemini-3.6-flash');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modele}:generateContent";

        try {
            $response = Http::withHeaders(['x-goog-api-key' => $apiKey])
                ->connectTimeout(10)->timeout(20)->post($url, [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]],
                    ],
                ]);
        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            throw new \Exception("Impossible de joindre l'API Gemini (connexion réseau). Vérifie ta connexion internet, ton pare-feu, ou ton antivirus. Détail: " . $this->masquerCle($e->getMessage(), $apiKey));
        }

        if ($response->failed()) {
            $detail = $response->json('error.message') ?? $response->body();
            throw new \Exception("Appel API Gemini échoué (HTTP {$response->status()}) : " . $this->masquerCle($detail, $apiKey));
        }

        return $response->json('candidates.0.content.parts.0.text') ?? "Aucune réponse disponible.";
    }

    /**
     * Retire toute trace de la clé API d'un message d'erreur, par sécurité.
     */
    private function masquerCle(string $message, ?string $apiKey): string
    {
        if (empty($apiKey)) {
            return $message;
        }
        return str_replace($apiKey, '***CLE_MASQUEE***', $message);
    }
}