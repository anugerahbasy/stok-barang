<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Force HTTPS hanya jika aplikasi berjalan di environment production
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        Blade::component('layouts.app', 'app-layout');
    }

    public function register(): void
    {
        //
    }
}