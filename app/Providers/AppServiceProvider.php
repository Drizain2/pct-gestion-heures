<?php

namespace App\Providers;

use App\Models\Ressource;
use App\Policies\RessourcePolicy;
use App\Services\CalculHoraireService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
     public function register(): void
    {
        $this->app->singleton(CalculHoraireService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Ressource::class,RessourcePolicy::class);
    }
}
