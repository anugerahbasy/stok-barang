<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL; // Jangan lupa import URL

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Force HTTPS jika di production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // 2. Registrasi Blade component kustom
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