<?php

namespace App\Providers;

use App\Models\LeaveRequest;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        // Partage $demandesEnAttente avec TOUTES les vues (sidebar, notifications, etc.)
        // pour ne plus avoir à le calculer/passer manuellement dans chaque contrôleur.
        View::composer('*', function ($view) {
            $demandesEnAttente = 0;

            if (auth()->check() && auth()->user()->role === 'rh') {
                $demandesEnAttente = LeaveRequest::where('statut', 'en_attente')->count();
            }

            $view->with('demandesEnAttente', $demandesEnAttente);
        });
    }
}