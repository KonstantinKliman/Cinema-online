<?php

use App\Http\Controllers\Application\GenreController;
use App\Http\Controllers\Application\PersonController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Application\PagesController;
use App\Http\Controllers\Application\ProfileController;
use App\Http\Controllers\Application\MovieController;
use App\Http\Controllers\Application\UserController;
use App\Http\Controllers\Application\CommentController;
use App\Http\Controllers\Application\RatingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [PagesController::class, 'showHomePage'])->name('home.page');

Route::middleware('auth')->group(function () {
    Route::post('/movie/{movie_id}/create_rating', [RatingsController::class, 'createRating'])->name('createRating.action');
});

Route::middleware('auth')->group(function () {
    Route::post('/movie/{movie_id}/create_comment', [CommentController::class, 'createComment'])->name('createComment.action');
    Route::delete('/delete_comment/{comment_id}', [CommentController::class, 'deleteComment'])->name('deleteComment.action');
});

Route::middleware('auth')->group(function () {
    Route::get('/movie/create', [MovieController::class, 'showMovieCreateForm'])->name('create-movie-form.page');
    Route::post('/movie/create', [MovieController::class, 'createMovie'])->name('createMovie.action');
    Route::get('/search', [MovieController::class, 'searchMovie'])->name('movie.search')->withoutMiddleware('auth');
    Route::get('/filter', [MovieController::class, 'filterMovie'])->name('movie.filter')->withoutMiddleware('auth');
    Route::get('/filter', [MovieController::class, 'filterMovie'])->name('movie.filter')->withoutMiddleware('auth');
    Route::get('/movie/{movie_id}', [MovieController::class, 'showMoviePage'])->name('movie.page')->withoutMiddleware('auth');
    Route::get('/movie/{movie_id}/edit', [MovieController::class, 'showEditMovieForm'])->name('edit-movie.page');
    Route::post('/movie/{movie_id}/edit', [MovieController::class, 'editMovie'])->name('editMovie.action');
    Route::post('/movie/{movie_id}/publish', [MovieController::class, 'publishMovie'])->name('publishMovie.action');
    Route::delete('/movie/{movie_id}', [MovieController::class, 'deleteMovie'])->name('movie.delete');
    Route::get('/sort', [MovieController::class, 'sort'])->name('sort')->withoutMiddleware('auth');
});

Route::middleware('auth')->group(function () {
   Route::get('/person/create', [PersonController::class, 'showPersonCreateForm'])->name('create-person-form.page') ;
   Route::post('/person/create', [PersonController::class, 'create'])->name('create-person.action');
   Route::get('/person/{person_url}', [PersonController::class, 'showPersonPage'])->name('person-page')->withoutMiddleware('auth');
});

Route::get('/movies/{genre_name}', [GenreController::class, 'showGenrePage'])->name('genre.page');

Route::middleware(['auth', 'checkEditProfileAccess'])->group(function () {
    Route::get('/profile/{user_id}', [ProfileController::class, 'showProfilePage'])->name('profile.page');
    Route::get('/profile/{user_id}/edit', [ProfileController::class, 'showEditProfileForm'])->name('edit-profile-form.page');
    Route::post('/profile/{user_id}/edit_profile_info', [ProfileController::class, 'editProfileInfo'])->name('edit-profile-info.action');
    Route::post('/profile/{user_id}/upload_photo', [ProfileController::class, 'uploadProfilePhoto'])->name('upload-profile-photo.action');
});

Route::middleware(['auth', 'checkEditProfileAccess'])->group(function () {
    Route::get('/user/{user_id}', [UserController::class, 'showUserAccount'])->name('user.page');
    Route::post('/user/{user_id}/edit_user_name', [UserController::class, 'editUserName'])->name('edit-user-name.action');
    Route::post('/user/{user_id}/edit_user_email', [UserController::class, 'editUserEmail'])->name('edit-user-email.action');
    Route::post('/user/{user_id}/edit_password', [UserController::class, 'editUserPassword'])->name('edit-user-password.action');
    Route::delete('/user/{user_id}/delete_account', [UserController::class, 'deleteUser'])->name('delete-user-account.action');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login.page');
    Route::get('/register', [AuthController::class, 'showRegisterPage'])->name('register.page');
    Route::post('/login', [AuthController::class, 'login'])->name('login.action');
    Route::post('/register', [AuthController::class, 'register'])->name('register.action');
});

Route::middleware(['auth', 'throttle:6,1'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.action')->withoutMiddleware('guest');
    Route::get('/email/verify', [AuthController::class, 'verifyEmailPage'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify')->middleware('signed');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationLink'])->name('verification.send');
});
