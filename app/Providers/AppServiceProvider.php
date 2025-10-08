<?php

namespace App\Providers;

use App\Models\ShipmentTracking;
use App\Observers\ShipmentTrackingObserver;
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
        ShipmentTracking::observe(ShipmentTrackingObserver::class);
    }
}
