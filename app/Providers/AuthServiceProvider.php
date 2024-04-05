<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Services\AuthService;
use App\Services\Interfaces\AuthServiceInterface;
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
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('administrator') ? true : null;
        });
    }
}
