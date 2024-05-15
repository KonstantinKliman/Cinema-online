<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AttachMovieToPersonRequest;
use App\Http\Requests\Dashboard\EditPersonRequest;
use App\Http\Requests\Application\CreatePersonRequest;
use App\Models\Person;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\PersonServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PersonController extends Controller
{

    private PersonServiceInterface $personService;

    public function __construct(PersonServiceInterface $personService)
    {
        $this->personService = $personService;
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

    public function index(): View
    {
        return view('dashboard.person.index', [
            'persons' => $this->personService->all()
        ]);
    }

    public function create(): View
    {
        return view('dashboard.person.create');
    }

    public function store(CreatePersonRequest $request): View
    {
        $this->personService->create($request);
        return view('dashboard.person.index', [
            'persons' => $this->personService->all()
        ]);
    }

    public function adminShow(Person $person): View
    {
        return view('dashboard.person.show', [
            'person' => $person,
            'allRoles' => $this->personService->getPersonRoles($person),
            'movieRoles' => $this->personService->getMovieRoles($person),
            'movies' => $this->personService->getPersonMovies($person)
        ]);
    }

    public function edit(Person $person): View
    {
        return view('dashboard.person.edit', ['person' => $person]);
    }

    public function update(EditPersonRequest $request, Person $person): RedirectResponse
    {
        return redirect()->route('dashboard.person.edit', $this->personService->edit($request, $person));
    }

    public function delete(Person $person): RedirectResponse
    {
        $this->personService->delete($person);
        return redirect()->route('dashboard.person.index');
    }

    public function showAttachForm(): View
    {
        return view('dashboard.person.attach', [
            'movies' => $this->personService->getAllMovies(),
            'persons' => $this->personService->all(),
            'roles' => $this->personService->getAllPersonRoles()
        ]);
    }

    public function attach(AttachMovieToPersonRequest $request): RedirectResponse
    {
        $person = $this->personService->attachPersonToMovie($request);
        return redirect()->route('dashboard.person.show', [
            'person' => $person,
            'allRoles' => $this->personService->getPersonRoles($person),
            'movieRoles' => $this->personService->getMovieRoles($person),
            'movies' => $this->personService->getPersonMovies($person)
        ]);
    }

    public function detach(Person $person, $movieId, $roleId): RedirectResponse
    {
        $this->personService->detachPersonRoleFromMovie($person, $movieId, $roleId);
        return redirect()->route('dashboard.person.show', [
            'person' => $person,
            'allRoles' => $this->personService->getPersonRoles($person),
            'movieRoles' => $this->personService->getMovieRoles($person),
            'movies' => $this->personService->getPersonMovies($person)
        ]);
    }
}
