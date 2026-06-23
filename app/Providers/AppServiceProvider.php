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
        // Register BlatUI anonymous component path
        \Illuminate\Support\Facades\Blade::anonymousComponentPath(resource_path('views/components/ui'), 'ui');
    }
}
