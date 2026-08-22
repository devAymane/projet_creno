<?php

use App\Http\Controllers\Admin\RendezVousController as AdminRendezVousController;
use App\Http\Controllers\CreneauController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RendezVousController;
use App\Models\Creneau;
use App\Models\RendezVous;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    $user = auth()->user();

    // Dashboard Admin
if ($user->role === 'admin') {

    $totalCreneaux = Creneau::count();

    $totalRendezVous = RendezVous::count();

    $rendezVousEnAttente = RendezVous::where(
        'statut',
        'en_attente'
    )->count();

    $rendezVousConfirmes = RendezVous::where(
        'statut',
        'confirme'
    )->count();

    return view('dashboard', compact(
        'totalCreneaux',
        'totalRendezVous',
        'rendezVousEnAttente',
        'rendezVousConfirmes'
    ));
}

    // Dashboard Client
    $prochainsRendezVous = $user->rendezVous()
        ->with('creneau')
        ->where('statut', '!=', 'annule')
        ->whereHas('creneau', function ($query) {
            $query->whereDate(
                'date',
                '>=',
                now()->toDateString()
            );
        })
        ->latest()
        ->get();

    return view('dashboard', compact(
        'prochainsRendezVous'
    ));

})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Routes accessibles aux utilisateurs connectés
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | Créneaux
    |--------------------------------------------------------------------------
    */

    Route::get('/creneaux', [CreneauController::class, 'index'])
        ->name('creneaux.index');

    Route::get('/creneaux/{creneau}', [CreneauController::class, 'show'])
        ->name('creneaux.show');


    /*
    |--------------------------------------------------------------------------
    | Rendez-vous Client
    |--------------------------------------------------------------------------
    */

    Route::get('/mes-rendez-vous', [RendezVousController::class, 'index'])
        ->name('rendezvous.index');

    Route::post('/creneaux/{creneau}/reserver', [RendezVousController::class, 'store'])
        ->name('rendezvous.store');

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

        /*
        |--------------------------------------------------------------------------
        | Gestion des créneaux
        |--------------------------------------------------------------------------
        */

        Route::get('/creneaux/create', [CreneauController::class, 'create'])
            ->name('creneaux.create');

        Route::post('/creneaux', [CreneauController::class, 'store'])
            ->name('creneaux.store');

        Route::get('/creneaux/{creneau}/edit', [CreneauController::class, 'edit'])
            ->name('creneaux.edit');

        Route::put('/creneaux/{creneau}', [CreneauController::class, 'update'])
            ->name('creneaux.update');

        Route::delete('/creneaux/{creneau}', [CreneauController::class, 'destroy'])
            ->name('creneaux.destroy');


        /*
        |--------------------------------------------------------------------------
        | Gestion des rendez-vous
        |--------------------------------------------------------------------------
        */

        Route::get('/rendezvous', [AdminRendezVousController::class, 'index'])
            ->name('admin.rendezvous.index');

        Route::patch('/rendezvous/{rendezVous}/confirmer', [AdminRendezVousController::class, 'confirmer'])
            ->name('admin.rendezvous.confirmer');

        Route::patch('/rendezvous/{rendezVous}/annuler', [AdminRendezVousController::class, 'annuler'])
            ->name('admin.rendezvous.annuler');
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

require __DIR__ . '/auth.php';