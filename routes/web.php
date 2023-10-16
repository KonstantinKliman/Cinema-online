<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Application\PagesController;

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

Route::controller(AuthController::class)->group(function () {
    Route::get('/login', 'showLoginPage')->name('login.page');
    Route::get('/register', 'showRegisterPage')->name('register.page');
    Route::post('/register', 'register')->name('register.action');
    Route::post('/login', 'login')->name('login.action');
    Route::post('/logout', 'logout')->name('logout.action');
});

