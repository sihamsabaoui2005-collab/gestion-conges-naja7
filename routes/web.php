<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\EmployeController;
use App\Http\Controllers\CalendrierController;

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

    // Employé : nouvelle demande de congé
    Route::get('/conges/nouvelle', [LeaveRequestController::class, 'create'])->name('conges.create');
    Route::post('/conges', [LeaveRequestController::class, 'store'])->name('conges.store');

    // Employé : ses propres demandes
    Route::get('/conges/mes-demandes', [LeaveRequestController::class, 'mesDemandes'])->name('conges.mesDemandes');

    // RH : liste des demandes + validation
    Route::get('/rh/conges', [LeaveRequestController::class, 'index'])->name('conges.index');
    // IMPORTANT : cette route doit rester AVANT /rh/conges/{leaveRequest}, sinon
    // Laravel essaiera de résoudre "apercu" comme un {leaveRequest} et plantera.
    Route::get('/rh/conges/apercu', [LeaveRequestController::class, 'apercu'])->name('conges.apercu');
    Route::get('/rh/conges/departement/{departement}', [LeaveRequestController::class, 'departementDetail'])->name('conges.departement');
    Route::get('/rh/employes', [EmployeController::class, 'index'])->name('employes.index');
    Route::get('/rh/employes/nouveau', [EmployeController::class, 'create'])->name('employes.create');
    Route::post('/rh/employes', [EmployeController::class, 'store'])->name('employes.store');
    Route::get('/rh/calendrier', [CalendrierController::class, 'index'])->name('calendrier.index');
    Route::get('/rh/conges/{leaveRequest}', [LeaveRequestController::class, 'show'])->name('conges.show');
    Route::post('/rh/conges/{leaveRequest}/commentaire', [LeaveRequestController::class, 'storeComment'])->name('conges.comment');
    Route::post('/rh/conges/{leaveRequest}/approuver', [LeaveRequestController::class, 'approve'])->name('conges.approve');
    Route::post('/rh/conges/{leaveRequest}/refuser', [LeaveRequestController::class, 'reject'])->name('conges.reject');
});

require __DIR__.'/auth.php';