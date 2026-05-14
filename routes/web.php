<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::resource('candidats', CandidatController::class);
});

require __DIR__.'/settings.php';
