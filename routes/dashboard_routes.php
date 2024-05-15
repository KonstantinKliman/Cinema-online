<?php

use App\Http\Controllers\Application\GenreController;
use App\Http\Controllers\Application\MovieController;
use App\Http\Controllers\Application\PagesController;
use App\Http\Controllers\Application\PersonController;
use App\Http\Controllers\Application\PersonRoleController;
use App\Http\Controllers\Application\ProfileController;
use App\Http\Controllers\Application\RatingController;
use App\Http\Controllers\Application\ReviewController;
use App\Http\Controllers\Application\RoleController;
use App\Http\Controllers\Application\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [PagesController::class, 'dashboardIndex'])->name('dashboard.index');
    Route::get('/user', [UserController::class, 'index'])->name('dashboard.user');
    Route::put('/user/{user_id}/edit', [UserController::class, 'update'])->name('dashboard.user.update');
    Route::post('/user/{user_id}/edit_password', [UserController::class, 'editUserPassword'])->name('edit-user-password.action');
});

Route::group(['middleware' => 'verified'], function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('dashboard.profile');
    Route::patch('/profile/{profileId}/edit-profile-info', [ProfileController::class, 'editProfileInfo'])->name('edit-profile-info.action');
    Route::get('/user-reviews', [ReviewController::class, 'index'])->name('dashboard.reviews');
    Route::get('/ratings', [RatingController::class, 'index'])->name('dashboard.ratings');
});

Route::group(['middleware' => 'permission:add user|edit user|delete user'], function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'adminUserIndex'])->name('dashboard.user.index');
        Route::get('/create', [UserController::class, 'create'])->name('dashboard.user.create');
        Route::post('/create', [UserController::class, 'store'])->name('dashboard.user.store');
        Route::get('/{user_id}', [UserController::class, 'adminUserShow'])->name('dashboard.user.show');
        Route::get('/{user_id}/edit', [UserController::class, 'adminUserEdit'])->name('dashboard.user.edit');
        Route::put('/{user_id}/edit', [UserController::class, 'update'])->name('dashboard.user.update');
        Route::delete('/{user_id}/delete', [UserController::class, 'delete'])->name('dashboard.user.delete');
    });
});

Route::group(['middleware' => 'permission:add profile|edit profile|delete profile'], function () {
    Route::prefix('profiles')->group(function () {
        Route::get('/', [ProfileController::class, 'adminIndex'])->name('dashboard.profile.index');
        Route::get('/create', [ProfileController::class, 'create'])->name('dashboard.profile.create');
        Route::post('/create', [ProfileController::class, 'store'])->name('dashboard.profile.store');
        Route::get('/{profile_id}', [ProfileController::class, 'adminShow'])->name('dashboard.profile.show');
        Route::get('/{profile_id}/edit', [ProfileController::class, 'adminEdit'])->name('dashboard.profile.edit');
        Route::put('/{profile_id}/edit', [ProfileController::class, 'update'])->name('dashboard.profile.update');
        Route::delete('/{profile_id}/delete', [ProfileController::class, 'delete'])->name('dashboard.profile.delete');
    });
});

Route::group(['middleware' => 'permission:add movie|edit movie|delete movie'], function () {
    Route::prefix('movies')->group(function () {
        Route::get('/', [MovieController::class, 'index'])->name('dashboard.movie.index');
        Route::get('/create', [MovieController::class, 'create'])->name('dashboard.movie.create');
        Route::post('/create', [MovieController::class, 'store'])->name('dashboard.movie.store');
        Route::get('/{movie_id}', [MovieController::class, 'adminShow'])->name('dashboard.movie.show');
        Route::get('/{movie_id}/edit', [MovieController::class, 'edit'])->name('dashboard.movie.edit');
        Route::put('/{movie_id}/edit', [MovieController::class, 'update'])->name('dashboard.movie.update');
        Route::post('/{movie_id}/publish', [MovieController::class, 'publish'])->name('dashboard.movie.publish');
        Route::delete('/{movie_id}/delete', [MovieController::class, 'delete'])->name('dashboard.movie.delete');
    });
});

Route::group(['middleware' => 'permission:add genre|edit genre|delete genre'], function () {
    Route::prefix('genres')->group(function () {
        Route::get('/', [GenreController::class, 'index'])->name('dashboard.genres.index');
        Route::get('/create', [GenreController::class, 'create'])->name('dashboard.genre.create');
        Route::post('/create', [GenreController::class, 'store'])->name('dashboard.genre.store');
        Route::get('/{genre:slug}', [GenreController::class, 'adminShow'])->name('dashboard.genre.show');
        Route::get('/{genre:slug}/edit', [GenreController::class, 'edit'])->name('dashboard.genre.edit');
        Route::put('/{genre:slug}/edit', [GenreController::class, 'update'])->name('dashboard.genre.update');
        Route::post('/{genre_id}/{movie_id}/detach', [GenreController::class, 'detach'])->name('dashboard.genre.detach');
        Route::delete('/{genre:slug}/delete', [GenreController::class, 'delete'])->name('dashboard.genre.delete');
    });
});

Route::group(['middleware' => 'permission:add person|edit person|delete person'], function () {
    Route::prefix('person')->group(function () {
        Route::get('/', [PersonController::class, 'index'])->name('dashboard.person.index');
        Route::get('/create', [PersonController::class, 'create'])->name('dashboard.person.create');
        Route::post('/create', [PersonController::class, 'store'])->name('dashboard.person.store');
        Route::get('/attach', [PersonController::class, 'showAttachForm'])->name('dashboard.person.showAttachForm');
        Route::post('/attach', [PersonController::class, 'attach'])->name('dashboard.person.attach');
        Route::get('/{person:slug}', [PersonController::class, 'adminShow'])->name('dashboard.person.show');
        Route::get('/{person:slug}/edit', [PersonController::class, 'edit'])->name('dashboard.person.edit');
        Route::put('/{person:slug}/edit', [PersonController::class, 'update'])->name('dashboard.person.update');
        Route::delete('/{person:slug}/delete', [PersonController::class, 'delete'])->name('dashboard.person.delete');
        Route::post('/{person:slug}/{movie_id}/{role_id}/detach', [PersonController::class, 'detach'])->name('dashboard.person.detach');
    });
});

Route::group(['middleware' => 'permission:add person role|edit person role|delete person role'], function () {
    Route::prefix('person-role')->group(function () {
        Route::get('/', [PersonRoleController::class, 'index'])->name('dashboard.person.role.index');
        Route::get('/create', [PersonRoleController::class, 'create'])->name('dashboard.person.role.create');
        Route::post('/create', [PersonRoleController::class, 'store'])->name('dashboard.person.role.store');
        Route::get('/{role_id}/edit', [PersonRoleController::class, 'edit'])->name('dashboard.person.role.edit');
        Route::put('/{role_id}/edit', [PersonRoleController::class, 'update'])->name('dashboard.person.role.update');
        Route::delete('/{role_id}/delete', [PersonRoleController::class, 'delete'])->name('dashboard.person.role.delete');
    });
});

Route::group(['middleware' => 'permission:add review|edit review|delete review'], function () {
    Route::prefix('/reviews')->group(function () {
        Route::get('/', [ReviewController::class, 'adminIndex'])->name('dashboard.review.index');
        Route::get('/create', [ReviewController::class, 'create'])->name('dashboard.review.create');
        Route::post('/create', [ReviewController::class, 'adminStore'])->name('dashboard.review.store');
        Route::get('/{review_id}', [ReviewController::class, 'show'])->name('dashboard.review.show');
        Route::get('/{review_id}/edit', [ReviewController::class, 'edit'])->name('dashboard.review.edit');
        Route::put('/{review_id}/edit', [ReviewController::class, 'update'])->name('dashboard.review.update');
        Route::delete('/{review_id}/delete', [ReviewController::class, 'delete'])->name('dashboard.review.delete');
        Route::post('/{review_id}/publish', [ReviewController::class, 'publish'])->name('dashboard.review.publish');
    });
});

Route::group(['middleware' => 'permission:add role|edit role|delete role'], function () {
    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('dashboard.role.index');
        Route::get('/create', [RoleController::class, 'create'])->name('dashboard.role.create');
        Route::post('/create', [RoleController::class, 'store'])->name('dashboard.role.store');
        Route::get('/{role_id}/edit', [RoleController::class, 'edit'])->name('dashboard.role.edit');
        Route::post('/{role_id}/edit', [RoleController::class, 'update'])->name('dashboard.role.update');
        Route::delete('/{role_id}/delete', [RoleController::class, 'delete'])->name('dashboard.role.delete');
    });
});


