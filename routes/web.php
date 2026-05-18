<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\DossierController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::resource('candidats', CandidatController::class);
    Route::resource('dossiers', DossierController::class);
});

require __DIR__.'/settings.php';
