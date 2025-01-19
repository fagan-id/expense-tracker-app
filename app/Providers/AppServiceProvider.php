<?php

namespace App\Providers;

use App\Policies\AuthRegisterPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Define Newly Added Policies
        Gate::define('modify', [AuthRegisterPolicy::class, 'modify']);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
