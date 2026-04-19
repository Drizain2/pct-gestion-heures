<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\AnneeAcademiqueController;
use App\Http\Controllers\admin\ParametreController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RessourceController;
use App\Http\Controllers\SequenceController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    //Admin
    Route::middleware(["role:admin"])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'admin'])
                ->name('dashboard');

            // Utilisateurs
            Route::get('users', [UserController::class, 'index'])->name('users.index');
            Route::post('users', [UserController::class, 'store'])->name('users.store');
            Route::put('users/{user}/role', [UserController::class, 'updateRole'])->name('users.role');
            Route::put('users/{user}/password', [UserController::class, 'resetPassword'])->name('users.password');
            Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

            // Annees academiques
            Route::get('annees', [AnneeAcademiqueController::class, 'index'])->name('annees.index');
            Route::post('annees', [AnneeAcademiqueController::class, 'store'])->name('annees.store');
            Route::post('annees/{annee}/activer', [AnneeAcademiqueController::class, 'activer'])->name('annees.activer');
            Route::delete('annees/{annee}', [AnneeAcademiqueController::class, 'destroy'])->name('annees.destroy');

            // Parametres
            Route::get('parametres', [ParametreController::class, 'index'])->name('parametres.index');
            Route::post('parametres/systeme', [ParametreController::class, 'updateSysteme'])->name('parametres.systeme');
            Route::post('parametres/calcul', [ParametreController::class, 'updateCalcul'])->name('parametres.calcul');
        });

    // Secretaire
    Route::middleware(["role:secretaire"])
        ->prefix('secretaire')
        ->name('secretaire.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'secretaire'])
                ->name('dashboard');
        });

    //enseignant
    Route::middleware(["role:enseignant"])
        ->prefix('enseignant')
        ->name('enseignant.')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'enseignant'])
                ->name('dashboard');
        });

    // Accessible a admin et Secretaire
    Route::middleware(["role:admin|secretaire"])
        ->group(function () {
            // routes partagées
            Route::resource('enseignants', EnseignantController::class);
            Route::resource("cours", CoursController::class);
            // Sequence imbriquées dans cours
            Route::resource('cours.sequences', SequenceController::class)->except(['show']);
            // Ressource imbriquées dans cours
            Route::resource('cours.sequences.ressources', RessourceController::class)->except(['index', 'show']);
        });


});

require __DIR__ . '/auth.php';
