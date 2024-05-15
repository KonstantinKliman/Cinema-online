<?php


namespace App\Services;


use App\Http\Requests\Dashboard\AttachMovieToPersonRequest;
use App\Http\Requests\Dashboard\CreatePersonRoleRequest;
use App\Http\Requests\Dashboard\EditPersonRequest;
use App\Http\Requests\Dashboard\EditPersonRoleRequest;
use App\Http\Requests\Application\CreatePersonRequest;
use App\Models\Movie;
use App\Models\Person;
use App\Models\PersonRole;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Repositories\Interfaces\PersonRepositoryInterface;
use App\Repositories\Interfaces\PersonRoleRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Services\Interfaces\PersonRoleServiceInterface;
use App\Services\Interfaces\PersonServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class PersonService implements PersonServiceInterface
{

    private PersonRepositoryInterface $personRepository;
    private MovieRepositoryInterface $movieRepository;
    private PersonRoleRepositoryInterface $personRoleRepository;

    public function __construct(PersonRepositoryInterface $personRepository, MovieRepositoryInterface $movieRepository, PersonRoleRepositoryInterface $personRoleRepository)
    {
        $this->personRepository = $personRepository;
        $this->movieRepository = $movieRepository;
        $this->personRoleRepository = $personRoleRepository;
    }

    private function isRecordExists(int $personId, int $movieId, int $roleId)
    {
        return $this->personRepository->exists($personId, $movieId, $roleId);
    }

    public function create(CreatePersonRequest $request): Person
    {
        $data = [
            'full_name' => ucwords($request->validated('full_name')),
            'slug' => strtolower(str_replace([' ', '.'], ['-', ''], $request->validated('full_name'))),
        ];
        return $this->personRepository->create($data);
    }

    public function getPersonByFullName(string $fullName)
    {
        return $this->personRepository->getByFullName($fullName);
    }

    public function getPersonRoles(Person $person)
    {
        return $this->personRepository->getPersonRoles($person);
    }

    public function getPersonMovies(Person $person)
    {
        return $this->personRepository->getPersonMovies($person);
    }

    public function all(): Collection
    {
        return $this->personRepository->all();
    }

    public function getMovieRoles(Person $person): array
    {
        $movieRoles = [];

        foreach ($person->movies as $movie) {
            $roles = $this->personRepository->getMovieRoles($person, $movie->id);
            $movieRoles[$movie->id] = $roles->map(function ($role) {
                return ucfirst($role);
            })->implode(', ');
        }

        return $movieRoles;
    }

    public function edit(EditPersonRequest $request, Person $person): string
    {
        $data = [
            'full_name' => $request->validated('full_name'),
            'slug' => strtolower(str_replace([' ', '.'], ['-', ''], $request->validated('full_name'))),
        ];
        $this->personRepository->update($data, $person);
        return $person->slug;
    }

    public function createPersonRole(CreatePersonRoleRequest $request)
    {
        $data = [
            'name' => ucfirst($request->validated('name')),
        ];
        return $this->personRoleRepository->create($data);
    }

    public function getAllPersonRoles(): Collection
    {
        return $this->personRoleRepository->all();
    }

    public function getPersonRole(int $roleId): PersonRole
    {
        return $this->personRoleRepository->get($roleId);
    }

    public function editPersonRoleName(EditPersonRoleRequest $request, int $roleId)
    {
        $data = [
            'name' => ucfirst($request->validated('name')),
        ];
        return $this->personRoleRepository->edit($roleId, $data);
    }

    public function deletePersonRole(int $roleId)
    {
        $this->personRoleRepository->delete($roleId);
    }

    public function attachPersonToMovie(AttachMovieToPersonRequest $request): Person
    {
        $personId = $request->validated('person_id');
        $movieId = $request->validated('movie_id');
        $roleId = $request->validated('role_id');
        $person = $this->personRepository->get($personId);
        if (!$this->isRecordExists($personId, $movieId, $roleId)) {
            $this->personRepository->attachToMovie($person, $movieId, $roleId);
        };
        return $person;
    }

    public function detachPersonRoleFromMovie(Person $person, int $movieId, int $roleId): void
    {
        $this->personRepository->detachPersonRoleFromMovie($person, $movieId, $roleId);
    }

    public function delete(Person $person): void
    {
        $this->personRepository->delete($person);
    }

    public function getAllMovies()
    {
        return $this->movieRepository->all();
    }
}
