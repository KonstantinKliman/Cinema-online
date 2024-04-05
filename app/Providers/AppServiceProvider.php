<?php

namespace App\Providers;

use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\PersonRoleServiceInterface;
use App\Services\Interfaces\ReviewServiceInterface;
use App\Services\Interfaces\GenreServiceInterface;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\PersonServiceInterface;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\RatingServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\AuthService;
use App\Services\GenreService;
use App\Services\PersonRoleService;
use App\Services\ReviewService;
use App\Services\MovieService;
use App\Services\PersonService;
use App\Services\ProfileService;
use App\Services\RatingService;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->bind(MovieServiceInterface::class, MovieService::class);
        $this->app->bind(ProfileServiceInterface::class, ProfileService::class);
        $this->app->bind(ReviewServiceInterface::class, ReviewService::class);
        $this->app->bind(RatingServiceInterface::class, RatingService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(GenreServiceInterface::class, GenreService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(PersonServiceInterface::class, PersonService::class);
        $this->app->bind(PersonRoleServiceInterface::class, PersonRoleService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
 }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verify Email Address')
                ->line('Click the button below to verify your email address.')
                ->action('Verify Email Address', $url);
        });
    }
}
