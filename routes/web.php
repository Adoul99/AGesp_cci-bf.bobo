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
        if (in_array($user->role, ['admin', 'superadmin', 'secretaire'])) {
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

    // ── Galerie photos (candidats en formation : créneau, conduite, véhicules) ──
    // Les photos sont intégrées directement dans le code (base64), aucun fichier
    // externe à déposer. Pour changer/ajouter des photos : voir
    // resources/data/gallery_images.php
    $galleryImages = [];
    foreach (require resource_path('data/gallery_images.php') as $photo) {
        $galleryImages[] = [
            'url'     => 'data:image/jpeg;base64,' . $photo['data'],
            'caption' => $photo['caption'],
        ];
    }

    // ── Photo de fond du hero ──
    $heroImage = 'data:image/jpeg;base64,' . require resource_path('data/hero_image.php');

    return view('welcome', compact(
        'totalCandidats',
        'totalMoniteurs',
        'formationsActives',
        'examensThisMois',
        'galleryImages',
        'heroImage'
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
// PAGES COMMUNES AU PERSONNEL : ADMIN + MONITEUR + SECRÉTAIRE
// ══════════════════════════════════════════════════════════════
Route::middleware(['auth', 'verified', 'staff'])->group(function () {

    // ── Tableau de bord ───────────────────────────────────────
    Route::get('dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
         ->name('dashboard');

    // ── Alertes ──────────────────────────────────────────────
    Route::get('alertes', [App\Http\Controllers\AlerteController::class, 'index'])
         ->name('alertes.index');

});

// ══════════════════════════════════════════════════════════════
// MODULES PARTAGÉS : ADMIN + MONITEUR
// (formation, planification et évaluation des candidats)
// ══════════════════════════════════════════════════════════════
Route::middleware(['auth', 'verified', 'admin.or.moniteur'])->group(function () {

    // ── Formations ───────────────────────────────────────────
    Route::resource('formations',         FormationController::class);

    // ── Lieux de formation ───────────────────────────────────
    Route::resource('lieu_formations',    LieuFormationController::class);

    // ── Sessions de formation ────────────────────────────────
    Route::resource('session_formations', SessionFormationController::class);
    Route::get ('session_formations/{sessionFormation}/cloture',  [SessionFormationController::class, 'cloture'])  ->name('session_formations.cloture');
    Route::post('session_formations/{sessionFormation}/cloturer', [SessionFormationController::class, 'cloturer']) ->name('session_formations.cloturer');

    // ── Examens ──────────────────────────────────────────────
    // Route AJAX (candidats programmés pour un type d'examen donné) : doit être
    // déclarée AVANT le Route::resource pour éviter tout conflit avec
    // examens/{examen} (sinon Laravel tenterait de résoudre "candidats-par-type"
    // comme un identifiant d'examen).
    Route::get('examens/candidats-par-type/{typeSession}', [ExamenController::class, 'candidatsParType'])
         ->name('examens.candidats-par-type');
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
// MODULES PARTAGÉS : ADMIN + SECRÉTAIRE
// (accueil / dossier administratif des candidats)
// ══════════════════════════════════════════════════════════════
Route::middleware(['auth', 'verified', 'admin.or.secretaire'])->group(function () {

    // ── Gestion des candidats ────────────────────────────────
    Route::resource('candidats',          CandidatController::class);
    Route::get('candidats/{candidat}/espace', [EspaceCandidatController::class, 'voirCommeAdmin'])
         ->name('candidats.espace.admin');

    // ── Remplacement d'un candidat désistant ──
    Route::get('candidats/{candidat}/remplacer', [CandidatController::class, 'remplacerForm'])
         ->name('candidats.remplacer.form');
    Route::put('candidats/{candidat}/remplacer', [CandidatController::class, 'remplacerStore'])
         ->name('candidats.remplacer.store');
    Route::get('candidats/{candidat}/remplacements', [CandidatController::class, 'remplacementsHistorique'])
         ->name('candidats.remplacements.historique');

    // ── Inscriptions ─────────────────────────────────────────
    Route::resource('inscriptions',       InscriptionController::class);

    // ── Catégories de permis ─────────────────────────────────
    Route::resource('categorie_permis', CategoriePermisController::class)
         ->parameters(['categorie_permis' => 'categoriePermis']);

    // ── Groupes ──────────────────────────────────────────────
    Route::resource('groupes',            GroupeController::class);

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

    // ── Types de session (paramétrage) ───────────────────────
    Route::resource('type_sessions',      TypeSessionController::class);

    // ── Dossiers ─────────────────────────────────────────────
    Route::resource('dossiers',           DossierController::class);

    // ── Paiements ────────────────────────────────────────────
    Route::resource('paiements',          PaiementController::class);

    // ── Moniteurs ────────────────────────────────────────────
    Route::resource('moniteurs',          MoniteurController::class);

    // ── Véhicules ────────────────────────────────────────────
    Route::resource('vehicules',          VehiculeController::class);

    // ── Attestations ─────────────────────────────────────────
    Route::resource('attestations',       AttestationController::class);

    // ── Reçus ────────────────────────────────────────────────
    Route::resource('recus',              RecusController::class);

});

require __DIR__.'/settings.php';