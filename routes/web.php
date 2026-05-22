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
use App\Http\Controllers\CategoriePermisController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\GroupeController;
use App\Http\Controllers\LieuFormationController;
use App\Http\Controllers\ProgrammationController;
use App\Http\Controllers\RecusController;
use App\Http\Controllers\SessionFormationController;
use App\Http\Controllers\TypeSessionController;

// ── Page d'accueil ─────────────────────────────────────────────
Route::view('/', 'welcome')->name('home');

// ══ ROUTES PUBLIQUES — Inscription en ligne ════════════════════
Route::get('/s-inscrire',
    [InscriptionController::class, 'formulairePublic']
)->name('inscription.public');

Route::post('/s-inscrire',
    [InscriptionController::class, 'storePublic']
)->name('inscription.public.store');

Route::get('/inscription-confirmee',
    [InscriptionController::class, 'succes']
)->name('inscription.succes');

// ══ ROUTES PRIVÉES — Espace admin ═════════════════════════════
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
         ->name('dashboard');

    Route::resource('candidats',          CandidatController::class);
    Route::resource('dossiers',           DossierController::class);
    Route::resource('inscriptions',       InscriptionController::class);
    Route::resource('formations',         FormationController::class);
    Route::resource('examens',            ExamenController::class);
    Route::resource('paiements',          PaiementController::class);
    Route::resource('moniteurs',          MoniteurController::class);
    Route::resource('vehicules',          VehiculeController::class);
    Route::resource('attestations',       AttestationController::class);
    Route::resource('categorie_permis',   CategoriePermisController::class);
    Route::resource('evaluations',        EvaluationController::class);
    Route::resource('groupes',            GroupeController::class);
    Route::resource('lieu_formations',    LieuFormationController::class);
    Route::resource('programmations',     ProgrammationController::class);
    Route::resource('recus',              RecusController::class);
    Route::resource('session_formations', SessionFormationController::class);
    Route::resource('type_sessions',      TypeSessionController::class);

});

require __DIR__.'/settings.php';
