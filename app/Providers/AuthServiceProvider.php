<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        \App\Models\Fingerprint::class => \App\Policies\FingerprintPolicy::class,
        \App\Models\DetailProject::class => \App\Policies\DetailProjectPolicy::class,
        \App\Models\Logbook::class => \App\Policies\LogbookPolicy::class,
        \App\Models\Project::class => \App\Policies\ProjectPolicy::class,
        \App\Models\ToDoList::class => \App\Policies\ToDoListPolicy::class,     
        \App\Models\User::class => \App\Policies\UserPolicy::class,  
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
