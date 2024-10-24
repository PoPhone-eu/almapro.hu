<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Laravel\Cashier\Cashier;

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
        Cashier::useCustomerModel(User::class);
        Cashier::calculateTaxes();
        // share site settings with all views
        view()->composer('*', function ($view) {
            $siteSettings = \App\Models\SiteSetting::first();
            $view->with('sitesettings', $siteSettings);
        });
    }
}
