<?php

namespace App\Providers;

use App\Models\Incident;
use App\Observers\IncidentObserver;
use Illuminate\Support\ServiceProvider;

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
        // 🔥 Registramos el Observer para que los estados se muevan solos
        Incident::observe(IncidentObserver::class);
    }
}