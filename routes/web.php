<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CalendrierController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SoldeController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Redirige vers le bon tableau de bord selon le role de la personne connectee
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Paramètres & Support (page fusionnée, un seul lien dans le sidebar)
    Route::get('/parametres-support', [SettingsController::class, 'index'])->name('settings.index');
    Route::patch('/parametres-support', [SettingsController::class, 'update'])->name('settings.update');

    // Ouvrir une notification (marque comme lue + redirige vers la bonne page)
    Route::get('/notifications/{id}/ouvrir', [NotificationController::class, 'ouvrir'])->name('notifications.ouvrir');

    // Employé : nouvelle demande de congé
    Route::get('/conges/nouvelle', [LeaveRequestController::class, 'create'])->name('conges.create');
    Route::post('/conges', [LeaveRequestController::class, 'store'])->name('conges.store');

    // Employé : ses propres demandes (liste simple)
    Route::get('/conges/mes-demandes', [LeaveRequestController::class, 'mesDemandes'])->name('conges.mesDemandes');

    // Employé : annuler une demande encore en attente
    Route::delete('/conges/{leaveRequest}/annuler', [LeaveRequestController::class, 'annuler'])->name('conges.annuler');

    // Employé : historique de ses demandes (timeline + filtres + widgets)
    Route::get('/conges/historique', [LeaveRequestController::class, 'historique'])->name('conges.historique');

    // Employé : solde de congés
    Route::get('/conges/solde', [SoldeController::class, 'index'])->name('conges.solde');

    // RH : liste des demandes + validation
    Route::get('/rh/conges', [LeaveRequestController::class, 'index'])->name('conges.index');
    // IMPORTANT : cette route doit rester AVANT /rh/conges/{leaveRequest}, sinon
    // Laravel essaiera de résoudre "apercu" comme un {leaveRequest} et plantera.
    Route::get('/rh/conges/apercu', [LeaveRequestController::class, 'apercu'])->name('conges.apercu');
    Route::get('/rh/conges/departement/{departement}', [LeaveRequestController::class, 'departementDetail'])->name('conges.departement');
    Route::get('/rh/employes', [EmployeController::class, 'index'])->name('employes.index');
    Route::get('/rh/employes/nouveau', [EmployeController::class, 'create'])->name('employes.create');
    Route::post('/rh/employes', [EmployeController::class, 'store'])->name('employes.store');
    Route::delete('/rh/employes/{employe}', [EmployeController::class, 'destroy'])->name('employes.destroy');
    Route::get('/rh/calendrier', [CalendrierController::class, 'index'])->name('calendrier.index');
    Route::get('/rh/conges/{leaveRequest}', [LeaveRequestController::class, 'show'])->name('conges.show');
    Route::post('/rh/conges/{leaveRequest}/commentaire', [LeaveRequestController::class, 'storeComment'])->name('conges.comment');
    Route::delete('/rh/conges/{leaveRequest}/commentaire/{comment}', [LeaveRequestController::class, 'destroyComment'])->name('conges.comment.destroy');
    Route::post('/rh/conges/{leaveRequest}/approuver', [LeaveRequestController::class, 'approve'])->name('conges.approve');
    Route::post('/rh/conges/{leaveRequest}/refuser', [LeaveRequestController::class, 'reject'])->name('conges.reject');
    Route::post('/rh/conges/{leaveRequest}/annuler-decision', [LeaveRequestController::class, 'annulerDecision'])->name('conges.annulerDecision');

    // Rapports
    Route::get('/rh/rapports', [ReportController::class, 'index'])->name('rapports.index');
    Route::post('/rh/rapports/generer', [ReportController::class, 'generate'])->name('rapports.generate');
    Route::patch('/rh/rapports/{rapport}', [ReportController::class, 'update'])->name('rapports.update');
    Route::get('/rh/rapports/{rapport}/export', [ReportController::class, 'export'])->name('rapports.export');
    Route::delete('/rh/rapports/{rapport}', [ReportController::class, 'destroy'])->name('rapports.destroy');

    // Statistiques
    Route::get('/rh/statistiques', [StatistiqueController::class, 'index'])->name('statistiques.index');
});

require __DIR__.'/auth.php';