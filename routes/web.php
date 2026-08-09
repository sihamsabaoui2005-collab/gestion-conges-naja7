<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Redirige vers le bon tableau de bord selon le role de la personne connectee
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'rh') {
        return view('dashboard-rh');
    }
    return view('dashboard-employe');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
