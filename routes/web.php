<?php

use App\Http\Controllers\Application\GenreController;
use App\Http\Controllers\Application\PersonController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Application\PagesController;
use App\Http\Controllers\Application\ProfileController;
use App\Http\Controllers\Application\MovieController;
use App\Http\Controllers\Application\UserController;
use App\Http\Controllers\Application\ReviewController;
use App\Http\Controllers\Application\RatingController;

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


Route::get('/', [PagesController::class, 'index'])->name('index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/movie/{movie_id}/create_rating', [RatingController::class, 'createRating'])->name('createRating.action');
    Route::delete('/movie/{movie_id}/delete_rating', [RatingController::class,'deleteRating'])->name('deleteRating.action');
});

Route::post('/movie/{movie_id}/create_review', [ReviewController::class, 'createReview'])->name('createReview.action')->middleware('auth');

Route::get('/search', [MovieController::class, 'searchMovie'])->name('movie.search');
Route::get('/filter', [MovieController::class, 'filter'])->name('movie.filter');
Route::get('/movie/{movie_id}', [MovieController::class, 'showMoviePage'])->name('movie.page');
Route::get('/sort', [MovieController::class, 'sort'])->name('sort');
Route::get('/movie/{movie_id}/stream', [MovieController::class, 'streamMovie'])->name('movie.stream');

Route::get('/person/{person:slug}', [PersonController::class, 'showPersonPage'])->name('person-page');

Route::get('/movies/{genre:slug}', [GenreController::class, 'showGenrePage'])->name('genre.page');

Route::middleware('auth')->group(function () {
    Route::get('/profile/{profile_id}', [ProfileController::class, 'showProfilePage'])->name('profile.page');
    Route::post('/profile/{profile_id}/upload_photo', [ProfileController::class, 'uploadProfilePhoto'])->name('upload-profile-photo.action');
    Route::post('/profile/{profile_id}/default_photo', [ProfileController::class, 'defaultProfilePhoto'])->name('default-profile-photo.action');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginPage'])->name('login.page');
    Route::get('/register', [AuthController::class, 'showRegisterPage'])->name('register.page');
    Route::post('/login', [AuthController::class, 'login'])->name('login.action');
    Route::post('/register', [AuthController::class, 'register'])->name('register.action');
});

Route::middleware(['auth', 'throttle:6,1'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.action');
    Route::get('/email/verify', [AuthController::class, 'verifyEmailPage'])->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify')->middleware('signed');
    Route::post('/email/verification-notification', [AuthController::class, 'resendVerificationLink'])->name('verification.send');
});

Route::prefix('dashboard')->group(function (){
    require __DIR__ . '/dashboard_routes.php';
});
