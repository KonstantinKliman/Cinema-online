<?php

use App\Http\Controllers\Application\GenreController;
use App\Http\Controllers\Application\MovieController;
use App\Http\Controllers\Application\PagesController;
use App\Http\Controllers\Application\PersonController;
use App\Http\Controllers\Application\PersonRoleController;
use App\Http\Controllers\Application\ProfileController;
use App\Http\Controllers\Application\ReviewController;
use App\Http\Controllers\Application\RoleController;
use App\Http\Controllers\Application\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PagesController::class, 'adminIndex'])->name('admin.index')->middleware(['role:administrator|moderator|uploader']);

Route::group(['middleware' => 'permission:add user|edit user|delete user'], function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'adminUserIndex'])->name('admin.user.index');
        Route::get('/create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('/create', [UserController::class, 'store'])->name('admin.user.store');
        Route::get('/{user_id}', [UserController::class, 'adminUserShow'])->name('admin.user.show');
        Route::get('/{user_id}/edit', [UserController::class, 'adminUserEdit'])->name('admin.user.edit');
        Route::put('/{user_id}/edit', [UserController::class, 'update'])->name('admin.user.update');
        Route::delete('/{user_id}/delete', [UserController::class, 'destroy'])->name('admin.user.destroy');
    });
});

Route::group(['middleware' => 'permission:add profile|edit profile|delete profile'], function () {
    Route::prefix('profiles')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('admin.profile.index');
        Route::get('/create', [ProfileController::class, 'create'])->name('admin.profile.create');
        Route::post('/create', [ProfileController::class, 'store'])->name('admin.profile.store');
        Route::get('/{profile_id}', [ProfileController::class, 'adminShow'])->name('admin.profile.show');
        Route::get('/{profile_id}/edit', [ProfileController::class, 'adminEdit'])->name('admin.profile.edit');
        Route::put('/{profile_id}/edit', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::delete('/{profile_id}/delete', [ProfileController::class, 'delete'])->name('admin.profile.delete');
    });
});

Route::group(['middleware' => 'permission:add movie|edit movie|delete movie'], function () {
    Route::prefix('movies')->group(function () {
        Route::get('/', [MovieController::class, 'index'])->name('admin.movie.index');
        Route::get('/create', [MovieController::class, 'create'])->name('admin.movie.create');
        Route::post('/create', [MovieController::class, 'store'])->name('admin.movie.store');
        Route::get('/{movie_id}', [MovieController::class, 'adminShow'])->name('admin.movie.show');
        Route::get('/{movie_id}/edit', [MovieController::class, 'edit'])->name('admin.movie.edit');
        Route::put('/{movie_id}/edit', [MovieController::class, 'update'])->name('admin.movie.update');
        Route::post('/{movie_id}/publish', [MovieController::class, 'publish'])->name('admin.movie.publish');
        Route::delete('/{movie_id}/delete', [MovieController::class, 'delete'])->name('admin.movie.delete');
    });
});

Route::group(['middleware' => 'permission:add genre|edit genre|delete genre'], function () {
    Route::prefix('genres')->group(function () {
        Route::get('/', [GenreController::class, 'index'])->name('admin.genres.index');
        Route::get('/create', [GenreController::class, 'create'])->name('admin.genre.create');
        Route::post('/create', [GenreController::class, 'store'])->name('admin.genre.store');
        Route::get('/{genre:slug}', [GenreController::class, 'adminShow'])->name('admin.genre.show');
        Route::get('/{genre:slug}/edit', [GenreController::class, 'edit'])->name('admin.genre.edit');
        Route::put('/{genre:slug}/edit', [GenreController::class, 'update'])->name('admin.genre.update');
        Route::post('/{genre_id}/{movie_id}/detach', [GenreController::class, 'detach'])->name('admin.genre.detach');
        Route::delete('/{genre:slug}/delete', [GenreController::class, 'delete'])->name('admin.genre.delete');
    });
});

Route::group(['middleware' => 'permission:add person|edit person|delete person'], function () {
    Route::prefix('person')->group(function () {
        Route::get('/', [PersonController::class, 'index'])->name('admin.person.index');
        Route::get('/create', [PersonController::class, 'create'])->name('admin.person.create');
        Route::post('/create', [PersonController::class, 'store'])->name('admin.person.store');
        Route::get('/attach', [PersonController::class, 'showAttachForm'])->name('admin.person.showAttachForm');
        Route::post('/attach', [PersonController::class, 'attach'])->name('admin.person.attach');
        Route::get('/{person:slug}', [PersonController::class, 'adminShow'])->name('admin.person.show');
        Route::get('/{person:slug}/edit', [PersonController::class, 'edit'])->name('admin.person.edit');
        Route::put('/{person:slug}/edit', [PersonController::class, 'update'])->name('admin.person.update');
        Route::delete('/{person:slug}/delete', [PersonController::class, 'delete'])->name('admin.person.delete');
        Route::post('/{person:slug}/{movie_id}/{role_id}/detach', [PersonController::class, 'detach'])->name('admin.person.detach');
    });
});

Route::group(['middleware' => 'permission:add person role|edit person role|delete person role'], function () {
    Route::prefix('person-role')->group(function () {
        Route::get('/', [PersonRoleController::class, 'index'])->name('admin.person.role.index');
        Route::post('/create', [PersonRoleController::class, 'store'])->name('admin.person.role.store');
        Route::get('/{role_id}/edit', [PersonRoleController::class, 'edit'])->name('admin.person.role.edit');
        Route::put('/{role_id}/edit', [PersonRoleController::class, 'update'])->name('admin.person.role.update');
        Route::delete('/{role_id}/delete', [PersonRoleController::class, 'delete'])->name('admin.person.role.delete');
    });
});

Route::group(['middleware' => 'permission:add review|edit review|delete review'], function () {
    Route::prefix('/reviews')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('admin.review.index');
        Route::get('/create', [ReviewController::class, 'create'])->name('admin.review.create');
        Route::post('/create', [ReviewController::class, 'adminStore'])->name('admin.review.store');
        Route::get('/{review_id}', [ReviewController::class, 'show'])->name('admin.review.show');
        Route::get('/{review_id}/edit', [ReviewController::class, 'edit'])->name('admin.review.edit');
        Route::put('/{review_id}/edit', [ReviewController::class, 'update'])->name('admin.review.update');
        Route::delete('/{review_id}/delete', [ReviewController::class, 'delete'])->name('admin.review.delete');
        Route::post('/{review_id}/publish', [ReviewController::class, 'publish'])->name('admin.review.publish');
    });
});

Route::group(['middleware' => 'permission:add role|edit role|delete role'], function () {
    Route::prefix('role')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('admin.role.index');
        Route::get('/create', [RoleController::class, 'create'])->name('admin.role.create');
        Route::post('/create', [RoleController::class, 'store'])->name('admin.role.store');
        Route::get('/{role_id}/edit', [RoleController::class, 'edit'])->name('admin.role.edit');
        Route::post('/{role_id}/edit', [RoleController::class, 'update'])->name('admin.role.update');
        Route::delete('/{role_id}/delete', [RoleController::class, 'delete'])->name('admin.role.delete');
    });
});


