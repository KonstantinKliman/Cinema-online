<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
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
            'roles' => $roles,
            'movies' => $movies,
        ]);
    }

    public function create(CreatePersonRequest $request): RedirectResponse
    {
        $this->personService->create($request);
        return redirect()->back();
    }
}
