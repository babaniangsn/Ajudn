<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CotisationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\MembreController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes de l'application - Gestion des Cotisations
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

// Authentification
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth.admin')
    ->name('logout');

// Espace administrateur protégé
Route::middleware('auth.admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('membres/carte', [MembreController::class, 'carte'])->name('membres.carte');
    Route::resource('membres', MembreController::class);

    Route::resource('cotisations', CotisationController::class)->except(['show']);
    Route::get('cotisations/{cotisation}/recu', [CotisationController::class, 'recu'])->name('cotisations.recu');

    Route::prefix('exports')->name('exports.')->group(function () {
        Route::get('membres/pdf', [ExportController::class, 'membresPdf'])->name('membres.pdf');
        Route::get('cotisations/pdf', [ExportController::class, 'cotisationsPdf'])->name('cotisations.pdf');
    });

    Route::prefix('sauvegarde')->name('backup.')->group(function () {
        Route::get('/', [BackupController::class, 'index'])->name('index');
        Route::post('/', [BackupController::class, 'creer'])->name('creer');
        Route::get('/{fichier}/telecharger', [BackupController::class, 'telecharger'])->name('telecharger');
        Route::delete('/{fichier}', [BackupController::class, 'supprimer'])->name('supprimer');
    });
});
