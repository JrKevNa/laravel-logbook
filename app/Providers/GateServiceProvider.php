<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class GateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        // SDM menu access
        Gate::define('access-sdm-menu', fn($user) => $user->hasRole('sdm') || $user->hasRole('admin'));
        Gate::define('access-admin-menu', fn($user) => $user->hasRole('admin'));
    }
}
