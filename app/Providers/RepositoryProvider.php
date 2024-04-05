<?php

namespace App\Providers;

use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\PersonRoleRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Repositories\Interfaces\GenreRepositoryInterface;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Repositories\Interfaces\PersonRepositoryInterface;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\RatingRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\PermissionRepository;
use App\Repositories\PersonRoleRepository;
use App\Repositories\ReviewRepository;
use App\Repositories\GenreRepository;
use App\Repositories\MovieRepository;
use App\Repositories\PersonRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\RatingRepository;
use App\Repositories\RoleRepository;
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
        $this->app->bind(ReviewRepositoryInterface::class, ReviewRepository::class);
        $this->app->bind(RatingRepositoryInterface::class,RatingRepository::class);
        $this->app->bind(GenreRepositoryInterface::class,GenreRepository::class);
        $this->app->bind(PersonRepositoryInterface::class,PersonRepository::class);
        $this->app->bind(PersonRoleRepositoryInterface::class,PersonRoleRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
