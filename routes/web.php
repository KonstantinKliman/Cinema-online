<?php

use App\Http\Controllers\Admin\AdminController;
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


Route::get('/', [PagesController::class, 'showHomePage'])->name('home.page');

Route::middleware('auth')->group(function () {
    Route::post('/movie/{movie_id}/create_rating', [RatingController::class, 'createRating'])->name('createRating.action');
    Route::delete('/movie/{movie_id}/delete_rating', [RatingController::class,'deleteRating'])->name('deleteRating.action');
});

Route::middleware('auth')->group(function () {
    Route::post('/movie/{movie_id}/create_review', [ReviewController::class, 'createReview'])->name('createReview.action');
    Route::delete('/delete_review/{review_id}', [ReviewController::class, 'deleteReview'])->name('deleteReview.action');
});

Route::middleware('auth')->group(function () {
    Route::get('/movie/create', [MovieController::class, 'showMovieCreateForm'])->name('create-movie-form.page');
    Route::post('/movie/create', [MovieController::class, 'createMovie'])->name('createMovie.action');
    Route::get('/search', [MovieController::class, 'searchMovie'])->name('movie.search')->withoutMiddleware('auth');
    Route::get('/filter', [MovieController::class, 'filter'])->name('movie.filter')->withoutMiddleware('auth');
    Route::get('/movie/{movie_id}', [MovieController::class, 'showMoviePage'])->name('movie.page')->withoutMiddleware('auth');
    Route::get('/movie/{movie_id}/edit', [MovieController::class, 'showEditMovieForm'])->name('edit-movie.page');
    Route::post('/movie/{movie_id}/edit', [MovieController::class, 'editMovie'])->name('editMovie.action');
    Route::post('/movie/{movie_id}/publish', [MovieController::class, 'publishMovie'])->name('publishMovie.action');
    Route::delete('/movie/{movie_id}', [MovieController::class, 'deleteMovie'])->name('movie.delete');
    Route::get('/sort', [MovieController::class, 'sort'])->name('sort')->withoutMiddleware('auth');
    Route::get('/movie/{movie_id}/stream', [MovieController::class, 'streamMovie'])->name('movie.stream')->withoutMiddleware('auth');
});

Route::middleware('auth')->group(function () {
   Route::get('/person/create', [PersonController::class, 'showPersonCreateForm'])->name('create-person-form.page') ;
   Route::post('/person/create', [PersonController::class, 'create'])->name('create-person.action');
   Route::get('/person/{person:slug}', [PersonController::class, 'showPersonPage'])->name('person-page')->withoutMiddleware('auth');
});

Route::get('/movies/{genre:slug}', [GenreController::class, 'showGenrePage'])->name('genre.page');

Route::middleware('auth')->group(function () {
    Route::get('/profile/{user_id}', [ProfileController::class, 'showProfilePage'])->name('profile.page')->withoutMiddleware('checkEditProfileAccess');
    Route::get('/profile/{user_id}/edit', [ProfileController::class, 'showEditProfileForm'])->name('edit-profile-form.page');
    Route::post('/profile/{user_id}/edit_profile_info', [ProfileController::class, 'editProfileInfo'])->name('edit-profile-info.action');
    Route::post('/profile/{user_id}/upload_photo', [ProfileController::class, 'uploadProfilePhoto'])->name('upload-profile-photo.action');
    Route::post('/profile/{user_id}/default_photo', [ProfileController::class, 'defaultProfilePhoto'])->name('default-profile-photo.action');
});

Route::middleware('auth')->group(function () {
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

Route::get('/admin/', [AdminController::class, 'showAdminHomePage'])->name('admin-home.page');
Route::get('/admin/users', [AdminController::class, 'showAdminUsersPage'])->name('admin-users.page');
Route::get('/admin/users/{user_id}', [AdminController::class, 'showUserPage'])->name('admin-user.page');
Route::get('/admin/users/{user_id}/edit', [AdminController::class, 'showEditUserPage'])->name('edit-user.page');
Route::get('/admin/users/create', [AdminController::class, 'createUserPage'])->name('create-user.page');
Route::post('/admin/users/create', [AdminController::class, 'createUser'])->name('create-user.action');
//profiles
Route::get('/admin/profiles', [AdminController::class, 'showAdminProfilesPage'])->name('admin-profiles.page');
Route::get('/admin/profiles/{profile_id}/edit_profile', [AdminController::class, 'showEditProfilePage'])->name('admin-edit-profile.page');
Route::get('/admin/profiles/{profile_id}/edit_photo', [AdminController::class, 'showEditPhotoPage'])->name('admin-edit-photo.page');
Route::delete('/admin/profiles/{profile_id}/delete', [AdminController::class, 'deleteProfile'])->name('admin-delete-profile.action');
//movies
Route::get('/admin/movies', [AdminController::class, 'showAdminMoviesPage'])->name('admin-movies.page');
Route::get('/admin/movies/create', [AdminController::class, 'showAdminCreateMoviePage'])->name('admin-create-movie.page');
Route::get('/admin/movies/{movie_id}', [AdminController::class, 'showAdminMoviePage'])->name('admin-movie.page');
Route::get('/admin/movies/{movie_id}/edit', [AdminController::class, 'showAdminEditMoviePage'])->name('admin-edit-movie.page');
Route::delete('/admin/movie/{movie_id}/delete', [AdminController::class, 'deleteMovie'])->name('admin-delete-movie.action');
//genres
Route::get('/admin/genres', [AdminController::class, 'showAdminGenresPage'])->name('admin-genres.page');
Route::get('/admin/genres/create', [AdminController::class, 'showAdminCreateGenrePage'])->name('admin-create-genre.page');
Route::post('/admin/genres/create', [AdminController::class, 'createGenre'])->name('create-genre.action');
Route::get('/admin/genres/{genre:slug}', [AdminController::class, 'showAdminGenrePage'])->name('admin-genre.page');
Route::post('/admin/genres/{genre_id}/{movie_id}/detach', [AdminController::class, 'detachMovieFromGenre'])->name('detach-movie.action');
Route::get('/admin/genres/{genre:slug}/edit', [AdminController::class, 'showAdminEditGenrePage'])->name('admin-edit-genre.page');
Route::post('/admin/genres/{genre:slug}/edit', [AdminController::class, 'editGenre'])->name('edit-genre.action');
Route::delete('/admin/genres/{genre:slug}/delete', [AdminController::class, 'deleteGenre'])->name('delete-genre.action');
//persons
Route::get('/admin/persons', [AdminController::class, 'showAdminPersonsPage'])->name('admin-persons.page');
Route::get('/admin/persons/role/' , [AdminController::class, 'showAdminPersonRolePage'])->name('admin-person-role.page');
Route::post('/admin/persons/role/create' , [AdminController::class, 'createPersonRole'])->name('create-person-role.action');
Route::get('/admin/persons/role/{role_id}/edit', [AdminController::class, 'showAdminEditPersonRolePage'])->name('admin-edit-person-role.page');
Route::put('/admin/persons/role/{role_id}/edit', [AdminController::class, 'editPersonRole'])->name('edit-person-role.action');
Route::delete('/admin/persons/role/{role_id}/delete', [AdminController::class, 'deletePersonRole'])->name('delete-person-role.action');
Route::get('/admin/persons/create', [AdminController::class, 'showAdminCreatePersonPage'])->name('admin-create-person.page');
Route::post('/admin/persons/create', [AdminController::class, 'createPerson'])->name('create-person.action');
Route::get('/admin/persons/attach', [AdminController::class, 'showAdminAttachPersonToMoviePage'])->name('admin-attach-person-to-movie.page');
Route::post('/admin/persons/attach', [AdminController::class, 'attachMovieToPerson'])->name('attach-movie-to-person.action');
Route::get('/admin/persons/{person:slug}', [AdminController::class, 'showAdminPersonPage'])->name('admin-person.page');
Route::get('/admin/persons/{person:slug}/edit', [AdminController::class, 'showAdminEditPersonPage'])->name('admin-edit-person.page');
Route::put('/admin/persons/{person:slug}/edit', [AdminController::class, 'editPerson'])->name('edit-person.action');
Route::delete('/admin/persons/{person:slug}/delete', [AdminController::class, 'deletePerson'])->name('delete-person.action');
Route::delete('/admin/persons/{person:slug}/{movie_id}/{role_id}/detach', [AdminController::class, 'detachPersonRoleFromMovie'])->name('detach-person-role-from-movie.action');
//reviews
Route::get('/admin/reviews', [AdminController::class, 'showAdminReviewsPage'])->name('admin-reviews.page');
Route::get('/admin/reviews/{review_id}', [AdminController::class, 'showAdminReview'])->name('admin-review.page');
Route::get('/admin/reviews/{review_id}/edit', [AdminController::class, 'showAdminEditReviewPage'])->name('admin-edit-review.page');
Route::put('/admin/reviews/{review_id}/edit', [AdminController::class, 'editReview'])->name('edit-review.action');
Route::delete('/admin/reviews/{review_id}/delete', [AdminController::class, 'deleteReview'])->name('delete-review.action');
Route::post('/admin/reviews/{review_id}/publish', [AdminController::class, 'publishReview'])->name('publish-review.action');


Route::post('/admin/users/{user_id}/edit_role', [AdminController::class, 'editUserRole'])->name('edit-user-role.action');
Route::post('/admin/users/{user_id}/edit_user_name', [UserController::class, 'editUserName'])->name('edit-user-name.action');
Route::post('/admin/users/{user_id}/edit_user_email', [UserController::class, 'editUserEmail'])->name('edit-user-email.action');
Route::post('/admin/users/{user_id}/edit_password', [UserController::class, 'editUserPassword'])->name('edit-user-password.action');
Route::delete('/admin/users/{user_id}/delete_account', [AdminController::class, 'deleteUserAccount'])->name('delete-user-account.action');
Route::post('/admin/profile/{user_id}/edit_profile_info', [ProfileController::class, 'editProfileInfo'])->name('edit-profile-info.action');
Route::post('/admin/profile/{user_id}/upload_photo', [ProfileController::class, 'uploadProfilePhoto'])->name('upload-profile-photo.action');
Route::post('/admin/profile/{user_id}/default_photo', [ProfileController::class, 'defaultProfilePhoto'])->name('default-profile-photo.action');
