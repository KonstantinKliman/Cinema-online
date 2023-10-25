<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Application\PagesController;
use App\Http\Controllers\Application\ProfileController;

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

Route::controller(PagesController::class)->group(function () {
    Route::get('/', 'showHomePage')->name('home.page');
    Route::get('/profile/{user_id}', 'showProfilePage')->name('profile.page');
});

Route::controller(ProfileController::class)->middleware(['auth', 'checkEditProfileAccess'])->group(function () {
    Route::get('/profile/{user_id}/edit', 'showEditProfileForm')->name('edit-profile-form.page');
    Route::post('/profile/{user_id}/edit_user_name', 'editUserName')->name('edit-user-name.action');
    Route::post('/profile/{user_id}/edit_user_email', 'editUserEmail')->name('edit-user-email.action');
    Route::post('/profile/{user_id}/edit_user_country', 'editUserCountry')->name('edit-user-country.action');
    Route::post('/profile/{user_id}/edit_user_city', 'editUserCity')->name('edit-user-city.action');
    Route::post('/profile/{user_id}/upload_photo', 'uploadProfilePhoto')->name('upload-profile-photo.action');
    Route::post('/profile/{user_id}/edit_password', 'editUserPassword')->name('edit-user-password.action');
    Route::post('/profile/{user_id}/delete_account', 'deleteUserAccount')->name('delete-user-account.action');
});

Route::controller(AuthController::class)->middleware('guest')->group(function () {
    Route::get('/login', 'showLoginPage')->name('login.page');
    Route::get('/register', 'showRegisterPage')->name('register.page');
    Route::post('/login', 'login')->name('login.action');
    Route::post('/register', 'register')->name('register.action');
    Route::post('/logout', 'logout')->name('logout.action')->withoutMiddleware('guest');
});

