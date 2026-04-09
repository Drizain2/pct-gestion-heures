<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    //Admin
    Route::middleware(["role:admin"])
        ->prefix('admin')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'admin'])
                ->name('admin.dashboard');
        });

    // Secretaire
    Route::middleware(["role:secretaire"])
        ->prefix('secretaire')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'secretaire'])
                ->name('secretaire.dashboard');
        });

    //enseignant
    Route::middleware(["role:enseignant"])
        ->prefix('enseignant')
        ->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'enseignant'])
                ->name('enseignant.dashboard');
        });

    // Accessible a admin et Secretaire
    Route::middleware(["role:admin|secretaire"])
        ->group(function () {
            // routes partagées
        });
});

require __DIR__ . '/auth.php';
