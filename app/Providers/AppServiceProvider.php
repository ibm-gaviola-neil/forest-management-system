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
        $this->app->singleton(\App\Http\Services\DepartmentService::class, function ($app) {
            return new \App\Http\Services\DepartmentService();
        });

        $this->app->singleton(\App\Http\Services\DonorService::class, function ($app) {
            return new \App\Http\Services\DonorService();
        });

        $this->app->singleton(\App\Http\Services\DonationService::class, function ($app) {
            return new \App\Http\Services\DonationService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
