<?php

use App\Http\Controllers\CreneauController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RendezVousController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Routes accessibles aux utilisateurs connectés
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    // =========================
    // CRÉNEAUX
    // =========================

    // Voir la liste des créneaux
    Route::get('/creneaux', [CreneauController::class, 'index'])
        ->name('creneaux.index');

    // Voir un créneau
    Route::get('/creneaux/{creneau}', [CreneauController::class, 'show'])
        ->name('creneaux.show');


    // =========================
    // RENDEZ-VOUS
    // =========================

    // Voir mes rendez-vous
    Route::get('/mes-rendez-vous', [RendezVousController::class, 'index'])
        ->name('rendezvous.index');

    // Réserver un créneau
    Route::post('/creneaux/{creneau}/reserver', [RendezVousController::class, 'store'])
        ->name('rendezvous.store');

    // Annuler un rendez-vous
    Route::delete('/rendez-vous/{rendezVous}', [RendezVousController::class, 'destroy'])
        ->name('rendezvous.destroy');
});


/*
|--------------------------------------------------------------------------
| Routes réservées à l'administrateur
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        // Créer un créneau
        Route::get('/creneaux/create', [CreneauController::class, 'create'])
            ->name('creneaux.create');

        Route::post('/creneaux', [CreneauController::class, 'store'])
            ->name('creneaux.store');


        // Modifier un créneau
        Route::get('/creneaux/{creneau}/edit', [CreneauController::class, 'edit'])
            ->name('creneaux.edit');

        Route::put('/creneaux/{creneau}', [CreneauController::class, 'update'])
            ->name('creneaux.update');


        // Supprimer un créneau
        Route::delete('/creneaux/{creneau}', [CreneauController::class, 'destroy'])
            ->name('creneaux.destroy');
    });


/*
|--------------------------------------------------------------------------
| Test Middleware Admin
|--------------------------------------------------------------------------
*/

Route::get('/admin-test', function () {
    return 'Bienvenue Admin !';
})->middleware(['auth', 'admin']);


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';