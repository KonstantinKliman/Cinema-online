<?php

namespace App\Providers;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\GenreRepositoryInterface;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Repositories\Interfaces\PersonRepositoryInterface;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\RatingsRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\CommentRepository;
use App\Repositories\GenreRepository;
use App\Repositories\MovieRepository;
use App\Repositories\PersonRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\RatingsRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
        $this->app->bind(CommentRepositoryInterface::class, CommentRepository::class);
        $this->app->bind(RatingsRepositoryInterface::class,RatingsRepository::class);
        $this->app->bind(GenreRepositoryInterface::class,GenreRepository::class);
        $this->app->bind(PersonRepositoryInterface::class,PersonRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
