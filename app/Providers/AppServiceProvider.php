<?php

namespace App\Providers;

use App\Models\Status;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([
            'permissions' => function () {
                return [
                    'canCreate' => auth()->user()?->can('create projects'),
                    'canEdit' => auth()->user()?->can('edit projects'),
                    'canDelete' => auth()->user()?->can('delete projects'),
                ];
            },
            'projectStatus' => function () {
                return Status::all(['id', 'name']);
            },
        ]);
    }
}
