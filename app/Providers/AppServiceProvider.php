<?php

namespace App\Providers;

use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\CommentServiceInterface;
use App\Services\Interfaces\GenreServiceInterface;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\PersonServiceInterface;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\RatingsServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\AuthService;
use App\Services\GenreService;
use App\Services\CommentService;
use App\Services\MovieService;
use App\Services\PersonService;
use App\Services\ProfileService;
use App\Services\RatingsService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MovieServiceInterface::class,MovieService::class);
        $this->app->bind(ProfileServiceInterface::class,ProfileService::class);
        $this->app->bind(CommentServiceInterface::class,CommentService::class);
        $this->app->bind(RatingsServiceInterface::class,RatingsService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(GenreServiceInterface::class, GenreService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(PersonServiceInterface::class, PersonService::class);
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
