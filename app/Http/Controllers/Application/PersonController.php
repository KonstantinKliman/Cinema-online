<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\CreatePersonRequest;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\PersonServiceInterface;

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
        return view('add-person-form', ['movies' => $this->movieService->all()]);
    }

    public function showPersonPage($personUrl)
    {
        $person = $this->personService->getPersonByUrl($personUrl);
        $roles = $this->personService->getPersonRoles($person);
        $movies = $this->personService->getPersonMovies($person);
        return view('person', [
            'person' => $person,
            'roles' => $roles,
            'movies' => $movies,
        ]);
    }

    public function create(CreatePersonRequest $request)
    {
        $this->personService->create($request);
        return redirect()->back();
    }
}
