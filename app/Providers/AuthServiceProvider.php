<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Services\AuthService;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    public function register()
    {
        $this->app->bind(AuthService::class, function (Application $app) {
           return new AuthService();
        });
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
