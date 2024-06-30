<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use App\Policies\SpeedTestPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{

    protected $policies = [
        User::class => SpeedTestPolicy::class,
    ];

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
        Gate::define('speedtest', [SpeedTestPolicy::class, 'speedtest']);
    }
}
