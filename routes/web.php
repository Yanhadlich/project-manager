<?php

use App\Http\Controllers\ProjectsController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group( function () {
    Route::get('/projects', [ProjectsController::class. 'index'])->name('projects.index');
    Route::get('/projects/create', [ProjectsController::class. 'create'])->name('projects.create');
    Route::put('/projects/{project}', [ProjectsController::class. 'update'])->name('projects.update');
    Route::delete('/projects/{project}', [ProjectsController::class. 'delete'])->name('projects.delete');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
