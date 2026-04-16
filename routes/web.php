<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\ProfileController;
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
        });
});

require __DIR__ . '/auth.php';

Auth::routes();
Route::resource('heures', App\Http\Controllers\HeureController::class)->middleware('auth');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
