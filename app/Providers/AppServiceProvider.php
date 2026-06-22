<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS hanya jika di lingkungan produksi (Railway)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Registrasi Blade component kustom
        Blade::component('layouts.app', 'app-layout');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Tempat untuk register service jika ada
    }
}