<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

require __DIR__.'/auth.php';