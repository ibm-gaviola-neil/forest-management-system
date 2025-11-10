<?php

namespace App\Providers;

use App\Http\View\NotificationComposer;
use App\Http\View\SystemSettingsComposer;
use Illuminate\Support\Facades\View;
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
        View::composer('*', SystemSettingsComposer::class);
        View::composer('*', NotificationComposer::class);
    }
}
