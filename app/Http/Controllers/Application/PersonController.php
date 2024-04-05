<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AttachMovieToPersonRequest;
use App\Http\Requests\Admin\EditPersonRequest;
use App\Http\Requests\Application\CreatePersonRequest;
use App\Models\Person;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\PersonServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PersonController extends Controller
{

    private MovieServiceInterface $movieService;
    private PersonServiceInterface $personService;

    public function __construct(MovieServiceInterface $movieService, PersonServiceInterface $personService)
    {
        $this->movieService = $movieService;
        $this->personService = $personService;
    }

    public function showPersonCreateForm()
    {
        return view('person.add', ['movies' => $this->movieService->all()]);
    }

    public function showPersonPage(Person $person): View
    {
        $roles = $this->personService->getPersonRoles($person);
        $movies = $this->personService->getPersonMovies($person);
        return view('person.main', [
            'person' => $person,
            'role' => $roles,
            'movies' => $movies,
        ]);
    }

    public function index()
    {
        return view('admin.person.index', [
            'persons' => $this->personService->all()
        ]);
    }

    public function create()
    {
        return view('admin.person.create');
    }

    public function store(CreatePersonRequest $request): View
    {
        $this->personService->create($request);
        return view('admin.person.index', [
            'persons    ' => $this->personService->all()
        ]);
    }

    public function adminShow(Person $person): View
    {
        return view('admin.person.show', [
            'person' => $person,
            'allRoles' => $this->personService->getPersonRoles($person),
            'movieRoles' => $this->personService->getMovieRoles($person),
            'movies' => $this->personService->getPersonMovies($person)
        ]);
    }

    public function edit(Person $person)
    {
        return view('admin.person.edit', ['person' => $person]);
    }

    public function update(EditPersonRequest $request, Person $person)
    {
        $slug = $this->personService->edit($request, $person);
        return redirect()->route('admin.person.edit', $slug);
    }

    public function delete(Person $person)
    {
        $this->personService->delete($person);
        return redirect()->route('admin.person.index');
    }

    public function showAttachForm()
    {
        return view('admin.person.attach', [
            'movies' => $this->movieService->all(),
            'persons' => $this->personService->all(),
            'role' => $this->personService->getAllPersonRoles()
        ]);
    }

    public function attach(AttachMovieToPersonRequest $request)
    {
        $person = $this->personService->attachPersonToMovie($request);
        return redirect()->route('admin.person.show', [
            'person' => $person,
            'allRoles' => $this->personService->getPersonRoles($person),
            'movieRoles' => $this->personService->getMovieRoles($person),
            'movies' => $this->personService->getPersonMovies($person)
        ]);
    }

    public function detach(Person $person, $movieId, $roleId)
    {
        $this->personService->detachPersonRoleFromMovie($person, $movieId, $roleId);
        return redirect()->route('admin.person.show', [
            'person' => $person,
            'allRoles' => $this->personService->getPersonRoles($person),
            'movieRoles' => $this->personService->getMovieRoles($person),
            'movies' => $this->personService->getPersonMovies($person)
        ]);
    }
}
