<?php

namespace App\Providers;

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
        // share site settings with all views
        view()->composer('*', function ($view) {
            $siteSettings = \App\Models\SiteSetting::first();
            $view->with('sitesettings', $siteSettings);
        });
    }
}
