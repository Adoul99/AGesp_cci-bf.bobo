<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\InscriptionController;
 use App\Http\Controllers\FormationController;
 use App\Http\Controllers\ExamenController;
 use App\Http\Controllers\PaiementController;
 use App\Http\Controllers\MoniteurController;
 use App\Http\Controllers\VehiculeController;
 use App\Http\Controllers\AttestationController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::resource('candidats', CandidatController::class);
    Route::resource('dossiers', DossierController::class);
    Route::resource('inscriptions', InscriptionController::class);
    Route::resource('formations', FormationController::class);
    Route::resource('examens', ExamenController::class);
    Route::resource('paiements', PaiementController::class);
    Route::resource('moniteurs', MoniteurController::class);
    Route::resource('vehicules', VehiculeController::class);
    Route::resource('attestations', AttestationController::class);
});

require __DIR__.'/settings.php';
