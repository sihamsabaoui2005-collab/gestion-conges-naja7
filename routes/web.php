<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaveRequestController;

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

    // RH : liste des demandes + validation
    Route::get('/rh/conges', [LeaveRequestController::class, 'index'])->name('conges.index');
    Route::get('/rh/conges/{leaveRequest}', [LeaveRequestController::class, 'show'])->name('conges.show');
    Route::post('/rh/conges/{leaveRequest}/commentaire', [LeaveRequestController::class, 'storeComment'])->name('conges.comment');
    Route::post('/rh/conges/{leaveRequest}/approuver', [LeaveRequestController::class, 'approve'])->name('conges.approve');
    Route::post('/rh/conges/{leaveRequest}/refuser', [LeaveRequestController::class, 'reject'])->name('conges.reject');
});

require __DIR__.'/auth.php';