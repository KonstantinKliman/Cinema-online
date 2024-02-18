<?php


namespace App\Services;


use App\Http\Requests\Application\CreatePersonRequest;
use App\Models\Movie;
use App\Models\Person;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Repositories\Interfaces\PersonRepositoryInterface;
use App\Services\Interfaces\PersonServiceInterface;

class PersonService implements PersonServiceInterface
{

    private PersonRepositoryInterface $personRepository;
    private MovieRepositoryInterface $movieRepository;

    public function __construct(PersonRepositoryInterface $personRepository, MovieRepositoryInterface $movieRepository)
    {
        $this->personRepository = $personRepository;
        $this->movieRepository = $movieRepository;
    }

    private function isPersonExists(Movie $movie, int $personId, string $role) {
        if ($this->movieRepository->isPersonExists($movie, $personId, $role)) {
            return true;
        }
        return false;
    }

    public function create(CreatePersonRequest $request): Person
    {
        $data = [
            'full_name' => ucwords($request->validated('fullName')),
            'person_url' => strtolower(str_replace([' ', '.'], ['-', ''],    $request->validated('fullName'))),
        ];

        $person = $this->personRepository->firstOrCreate($data);
        $movie = $this->movieRepository->getById($request->movieId);
        if (!$this->isPersonExists($movie, $person->id, $request->validated('role'))) {
            $this->movieRepository->attachPersons($movie, $person->id, ['role' => $request->validated('role')]);
        }
        return $person;
    }

    public function getPersonByFullName(string $fullName)
    {
        return $this->personRepository->getByFullName($fullName);
    }

    public function getPersonByUrl(string $personUrl)
    {
        return $this->personRepository->getPersonByUrl($personUrl);
    }

    public function getPersonRoles(Person $person)
    {
        return $this->personRepository->getPersonRoles($person);
    }

    public function getPersonMovies(Person $person)
    {
        return $this->personRepository->getPersonMovies($person);
    }
}
