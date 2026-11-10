<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
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
        Carbon::setLocale(config('app.locale'));

        // Publica los artículos incluidos en el código la primera vez que se visita el sitio.
        if (! $this->app->runningInConsole()) {
            $this->app->booted(function () {
                \App\Support\BundledArticles::ensure();
                \App\Support\BundledSeeders::ensure();
            });
        }
    }
}
