<?php

use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TeamsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/projects', [ProjectsController::class, 'index'])->name('projects.index');

    Route::middleware(['role:Administrador|Gerente|Desenvolvedor'])->group(function () {
        Route::get('/projects/register', [ProjectsController::class, 'register'])->name('projects.register');
        Route::post('/projects/create', [ProjectsController::class, 'create'])->name('projects.create');
        Route::get('/projects/{project}/edit', [ProjectsController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{project}', [ProjectsController::class, 'update'])->name('projects.update');
    });

    Route::middleware(['role:Administrador|Gerente'])->group(function () {
        Route::delete('/projects/{project}', [ProjectsController::class, 'delete'])->name('projects.delete');
    });

    Route::middleware(['role:Administrador|Gerente'])->group(function () {
        Route::get('/teams', [TeamsController::class, 'index'])->name('teams.index');
        Route::get('/teams/register', [TeamsController::class, 'register'])->name('teams.register');
        Route::post('/teams/create', [TeamsController::class, 'create'])->name('teams.create');
        Route::get('/teams/{id}/edit', [TeamsController::class, 'edit'])->name('teams.edit');
        Route::put('/teams/{id}', [TeamsController::class, 'update'])->name('teams.update');
    });

    Route::middleware(['role:Administrador'])->group(function () {
        Route::delete('/teams/{id}', [TeamsController::class, 'delete'])->name('teams.delete');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
