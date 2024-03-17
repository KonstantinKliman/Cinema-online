<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReviewType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AttachMovieToPersonRequest;
use App\Http\Requests\Admin\CreatePersonRoleRequest;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\EditGenreRequest;
use App\Http\Requests\Admin\EditPersonRequest;
use App\Http\Requests\Admin\EditPersonRoleRequest;
use App\Http\Requests\Admin\EditReviewRequest;
use App\Http\Requests\Admin\EditUserRoleRequest;
use App\Http\Requests\Application\CreateGenreRequest;
use App\Http\Requests\Application\CreatePersonRequest;
use App\Models\Genre;
use App\Models\Person;
use App\Services\Interfaces\GenreServiceInterface;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\PersonServiceInterface;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\ReviewServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    private const DEFAULT_USER_PASSWORD = 'root';
    private UserServiceInterface $userService;
    private ProfileServiceInterface $profileService;
    private MovieServiceInterface $movieService;
    private GenreServiceInterface $genreService;
    private PersonServiceInterface $personService;
    private ReviewServiceInterface $reviewService;

    public function __construct(UserServiceInterface    $userService,
                                ProfileServiceInterface $profileService,
                                MovieServiceInterface   $movieService,
                                GenreServiceInterface   $genreService,
                                PersonServiceInterface  $personService,
                                ReviewServiceInterface $reviewService)
    {
        $this->userService = $userService;
        $this->profileService = $profileService;
        $this->movieService = $movieService;
        $this->genreService = $genreService;
        $this->personService = $personService;
        $this->reviewService = $reviewService;
    }

    public function showAdminHomePage(): View
    {
        return view('admin.main');
    }

    public function showAdminUsersPage(): View
    {
        return view('admin.user.main', [
            'users' => $this->userService->getAllUsers(),
            'roles' => $this->userService->getAllRoles(),
        ]);
    }

    public function showUserPage($userId)
    {
        return view('admin.user.show', [
            'user' => $this->userService->getUser($userId),
            'roles' => $this->userService->getAllRoles(),
        ]);
    }

    public function editUserRole(EditUserRoleRequest $request, $userId)
    {
        $this->userService->editUserRole($request, $userId);
        return redirect()->back();
    }

    public function showEditUserPage($userId)
    {
        return view('admin.user.edit', [
            'user' => $this->userService->getUser($userId),
            'roles' => $this->userService->getAllRoles(),
        ]);
    }

    public function deleteUserAccount($userId)
    {
        $this->userService->deleteUser($userId);
        return redirect()->back();
    }

    public function createUserPage()
    {
        return view('admin.user.create', ['roles' => $this->userService->getAllRoles()]);
    }

    public function createUser(CreateUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make(self::DEFAULT_USER_PASSWORD);
        $this->userService->create($data);
        return redirect()->back();
    }

    public function showAdminProfilesPage()
    {
        return view('admin.profile.main', ['profiles' => $this->profileService->all()]);
    }

    public function showEditProfilePage($profileId)
    {
        return view('admin.profile.edit-profile', ['profile' => $this->profileService->getProfileById($profileId)]);
    }

    public function showEditPhotoPage($profileId)
    {
        return view('admin.profile.edit-photo', ['profile' => $this->profileService->getProfileById($profileId)]);
    }

    public function deleteProfile($profileId)
    {
        $this->profileService->delete($profileId);
        return redirect()->back();
    }

    public function showAdminMoviesPage()
    {
        return view('admin.movie.main', ['movies' => $this->movieService->all()]);
    }

    public function showAdminMoviePage(Request $request, $movieId)
    {
        return view('admin.movie.show', [
            'movie' => $this->movieService->getMovieItem($movieId),
            'persons' => $this->movieService->getPersonOnMovie($movieId, $request),
        ]);
    }

    public function showAdminCreateMoviePage()
    {
        return view('admin.movie.create', ['genres' => $this->genreService->getAllGenres()]);
    }

    public function showAdminEditMoviePage($movieId)
    {
        return view('admin.movie.edit', [
            'movie' => $this->movieService->getMovieItem($movieId),
            'genres' => $this->genreService->getAllGenres(),
        ]);
    }

    public function deleteMovie($movieId)
    {
        $this->movieService->delete($movieId);
        return redirect()->back();
    }

    public function showAdminGenresPage()
    {
        return view('admin.genres.main', ['genres' => $this->genreService->getAllGenres()]);
    }

    public function showAdminGenrePage(Genre $genre)
    {

        return view('admin.genres.show', [
            'genre' => $genre,
            'movies' => $this->genreService->getMoviesByGenre($genre),
        ]);
    }

    public function detachMovieFromGenre($genreId, $movieId)
    {
        $this->genreService->detach($genreId, $movieId);
        return redirect()->back();
    }

    public function showAdminCreateGenrePage()
    {
        return view('admin.genres.create');
    }

    public function showAdminEditGenrePage(Genre $genre)
    {
        return view('admin.genres.edit', ['genre' => $genre]);
    }

    public function createGenre(CreateGenreRequest $request)
    {
        $this->genreService->create($request);
        return redirect()->back();
    }

    public function editGenre(EditGenreRequest $request, Genre $genre)
    {
        $slug = $this->genreService->edit($request, $genre);
        return redirect()->route('admin-edit-genre.page', $slug);
    }

    public function deleteGenre(Genre $genre)
    {
        $this->genreService->delete($genre);
        return redirect()->back();
    }

    public function showAdminPersonsPage(): View
    {
        return view('admin.persons.main', [
            'persons' => $this->personService->all()
        ]);
    }

    public function showAdminPersonPage(Person $person): View
    {
        return view('admin.persons.show', [
            'person' => $person,
            'allRoles' => $this->personService->getPersonRoles($person),
            'movieRoles' => $this->personService->getMovieRoles($person),
            'movies' => $this->personService->getPersonMovies($person)
        ]);
    }

    public function showAdminEditPersonPage(Person $person)
    {
        return view('admin.persons.edit', ['person' => $person]);
    }

    public function editPerson(EditPersonRequest $request, Person $person)
    {
        $slug = $this->personService->edit($request, $person);
        return redirect()->route('admin-edit-person.page', $slug);
    }

    public function showAdminPersonRolePage()
    {
        return view('admin.persons.role.main', ['roles' => $this->personService->getAllPersonRoles()]);
    }

    public function createPersonRole(CreatePersonRoleRequest $request)
    {
        $this->personService->createPersonRole($request);
        return redirect()->route('admin-person-role.page', ['roles' => $this->personService->getAllPersonRoles()]);
    }

    public function showAdminEditPersonRolePage(int $roleId)
    {
        return view('admin.persons.role.edit', ['role' => $this->personService->getPersonRole($roleId)]);
    }

    public function editPersonRole(EditPersonRoleRequest $request, int $roleId)
    {
        $this->personService->editPersonRoleName($request, $roleId);
        return redirect()->route('admin-person-role.page', ['roles' => $this->personService->getAllPersonRoles()]);
    }

    public function deletePersonRole(int $roleId)
    {
        $this->personService->deletePersonRole($roleId);
        return redirect()->route('admin-person-role.page', ['roles' => $this->personService->getAllPersonRoles()]);
    }

    public function showAdminCreatePersonPage()
    {
        return view('admin.persons.create');
    }

    public function createPerson(CreatePersonRequest $request)
    {
        $this->personService->create($request);
        return view('admin.persons.main', [
            'persons' => $this->personService->all()
        ]);
    }

    public function showAdminAttachPersonToMoviePage()
    {
        return view('admin.persons.attach', [
            'movies' => $this->movieService->all(),
            'persons' => $this->personService->all(),
            'roles' => $this->personService->getAllPersonRoles()
        ]);
    }

    public function attachMovieToPerson(AttachMovieToPersonRequest $request)
    {
        $this->personService->attachPersonToMovie($request);
        return redirect()->route('admin-persons.page');
    }

    public function detachPersonRoleFromMovie(Person $person, $movieId, $roleId)
    {
        $this->personService->detachPersonRoleFromMovie($person, $movieId, $roleId);
        return redirect()->route('admin-persons.page');
    }

    public function deletePerson(Person $person)
    {
        $this->personService->delete($person);
        return redirect()->route('admin-persons.page');
    }

    public function showAdminReviewsPage()
    {
        return view('admin.review.main', ['reviews' => $this->reviewService->all()]);
    }

    public function showAdminReview(int $reviewId)
    {
        return view('admin.review.show', ['review' => $this->reviewService->get($reviewId)]);
    }

    public function showAdminEditReviewPage(int $reviewId)
    {
        return view('admin.review.edit', ['review' => $this->reviewService->get($reviewId)]);
    }

    public function editReview(EditReviewRequest $request, $reviewId)
    {
        $isPublished = (bool)$request->is_published;
        $this->reviewService->edit($request, $isPublished, $reviewId);
        return redirect()->back();
    }

    public function deleteReview($reviewId)
    {
        $this->reviewService->delete($reviewId);
        return redirect()->route('admin-reviews.page');
    }

    public function publishReview($reviewId)
    {
        $this->reviewService->publish($reviewId);
        return redirect()->back();
    }
}
