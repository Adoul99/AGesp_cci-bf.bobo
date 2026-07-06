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
use App\Http\Controllers\Auth\VerificationCodeController;
use App\Http\Controllers\EspaceCandidatController;
use App\Http\Controllers\UserController;

// ══════════════════════════════════════════════════════════════
// PAGE D'ACCUEIL
// ══════════════════════════════════════════════════════════════
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->role === 'candidat') {
            return redirect()->route('candidat.espace');
        }
        if (in_array($user->role, ['admin', 'superadmin'])) {
            return redirect()->route('dashboard');
        }
        if ($user->role === 'moniteur') {
            return redirect()->route('moniteur.espace');
        }
    }

    $totalCandidats    = \App\Models\Candidat::count();
    $totalMoniteurs    = \App\Models\Moniteur::count();
    $formationsActives = \App\Models\SessionFormation::count();
    $examensThisMois   = \App\Models\SessionFormation::whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();

    return view('welcome', compact(
        'totalCandidats',
        'totalMoniteurs',
        'formationsActives',
        'examensThisMois'
    ));
})->name('home');

// ══════════════════════════════════════════════════════════════
// VÉRIFICATION EMAIL (AJAX)
// ══════════════════════════════════════════════════════════════
Route::post('/verify-email/send',   [VerificationCodeController::class, 'send'])
     ->name('verify-email.send');

Route::post('/verify-email/verify', [VerificationCodeController::class, 'verify'])
     ->name('verify-email.verify');

// ══════════════════════════════════════════════════════════════
// INSCRIPTION PUBLIQUE
// ══════════════════════════════════════════════════════════════
Route::get('/s-inscrire',
    [InscriptionController::class, 'formulairePublic']
)->name('inscription.public');

Route::post('/s-inscrire',
    [InscriptionController::class, 'storePublic']
)->name('inscription.public.store');

Route::get('/inscription-confirmee',
    [InscriptionController::class, 'succes']
)->name('inscription.succes');

// ══════════════════════════════════════════════════════════════
// ESPACE CANDIDAT
// ══════════════════════════════════════════════════════════════
Route::middleware(['auth', 'candidat.only'])->group(function () {
    Route::get('/mon-espace', [EspaceCandidatController::class, 'index'])
         ->name('candidat.espace');
    Route::get('/mon-espace/attestations/{attestation}', [EspaceCandidatController::class, 'voirMonAttestation'])
         ->name('candidat.attestation.show');
});

// ══════════════════════════════════════════════════════════════
// ESPACE MONITEUR (tableau de bord personnel)
// ══════════════════════════════════════════════════════════════
Route::middleware(['auth', 'verified', 'moniteur.only'])->prefix('moniteur')->name('moniteur.')->group(function () {
    Route::get('/espace', [MoniteurController::class, 'espace'])
         ->name('espace');
});

// ══════════════════════════════════════════════════════════════
// MODULES PARTAGÉS : ADMIN + MONITEUR
// ══════════════════════════════════════════════════════════════
Route::middleware(['auth', 'verified', 'admin.or.moniteur'])->group(function () {

    // ── Tableau de bord admin ─────────────────────────────────
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
         ->name('dashboard');

    // ── Alertes ──────────────────────────────────────────────
    Route::get('alertes', [App\Http\Controllers\AlerteController::class, 'index'])
         ->name('alertes.index');

    // ── Formations ───────────────────────────────────────────
    Route::resource('formations',         FormationController::class);

    // ── Lieux de formation ───────────────────────────────────
    Route::resource('lieu_formations',    LieuFormationController::class);

    // ── Groupes ──────────────────────────────────────────────
    Route::resource('groupes',            GroupeController::class);

    // ── Sessions de formation ────────────────────────────────
    Route::resource('session_formations', SessionFormationController::class);
    Route::get ('session_formations/{sessionFormation}/cloture',  [SessionFormationController::class, 'cloture'])  ->name('session_formations.cloture');
    Route::post('session_formations/{sessionFormation}/cloturer', [SessionFormationController::class, 'cloturer']) ->name('session_formations.cloturer');

    // ── Types de session ─────────────────────────────────────
    Route::resource('type_sessions',      TypeSessionController::class);

    // ── Examens ──────────────────────────────────────────────
    Route::resource('examens',            ExamenController::class);

    // ── Évaluations ──────────────────────────────────────────
    Route::get('evaluations/rapport', [EvaluationController::class, 'report'])
         ->name('evaluations.report');
    Route::resource('evaluations',        EvaluationController::class);

    // ── Programmations ───────────────────────────────────────
    Route::get('programmations/candidats-par-type/{typeSession}', [ProgrammationController::class, 'candidatsParType'])
         ->name('programmations.candidats-par-type');
    Route::get('programmations/rechercher-candidat', [ProgrammationController::class, 'rechercherCandidat'])
         ->name('programmations.rechercher-candidat');
    Route::resource('programmations',     ProgrammationController::class);

});

// ══════════════════════════════════════════════════════════════
// ESPACE ADMIN UNIQUEMENT
// ══════════════════════════════════════════════════════════════
Route::middleware(['auth', 'verified', 'admin.only'])->group(function () {

    // ── Gestion des utilisateurs & rôles ─────────────────────
    Route::get   ('users',             [UserController::class, 'index'])      ->name('users.index');
    Route::get   ('users/create',      [UserController::class, 'create'])     ->name('users.create');
    Route::post  ('users',             [UserController::class, 'store'])      ->name('users.store');
    Route::patch ('users/{user}/role', [UserController::class, 'updateRole']) ->name('users.role');
    Route::delete('users/{user}',      [UserController::class, 'destroy'])    ->name('users.destroy');

    // ── Gestion des candidats ────────────────────────────────
    Route::resource('candidats',          CandidatController::class);
    Route::get('candidats/{candidat}/espace', [EspaceCandidatController::class, 'voirCommeAdmin'])
         ->name('candidats.espace.admin');

    // ── Dossiers ─────────────────────────────────────────────
    Route::resource('dossiers',           DossierController::class);

    // ── Inscriptions ─────────────────────────────────────────
    Route::resource('inscriptions',       InscriptionController::class);

    // ── Paiements ────────────────────────────────────────────
    Route::resource('paiements',          PaiementController::class);

    // ── Moniteurs ────────────────────────────────────────────
    Route::resource('moniteurs',          MoniteurController::class);

    // ── Véhicules ────────────────────────────────────────────
    Route::resource('vehicules',          VehiculeController::class);

    // ── Attestations ─────────────────────────────────────────
    Route::resource('attestations',       AttestationController::class);

    // ── Catégories de permis ─────────────────────────────────
    Route::resource('categorie_permis', CategoriePermisController::class)
         ->parameters(['categorie_permis' => 'categoriePermis']);

    // ── Reçus ────────────────────────────────────────────────
    Route::resource('recus',              RecusController::class);

});

require __DIR__.'/settings.php';