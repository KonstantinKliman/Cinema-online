<?php


namespace App\Services\Interfaces;


use App\Http\Requests\Dashboard\AttachMovieToPersonRequest;
use App\Http\Requests\Dashboard\CreatePersonRoleRequest;
use App\Http\Requests\Dashboard\EditPersonRequest;
use App\Http\Requests\Dashboard\EditPersonRoleRequest;
use App\Http\Requests\Application\CreatePersonRequest;
use App\Models\Person;
use App\Models\PersonRole;
use Illuminate\Database\Eloquent\Collection;

interface PersonServiceInterface
{
    public function create(CreatePersonRequest $request);

    public function getPersonByFullName(string $fullName);

    public function getPersonRoles(Person $person);

    public function getPersonMovies(Person $person);

    public function all(): Collection;

    public function getMovieRoles(Person $person): array;

    public function edit(EditPersonRequest $request, Person $person): string;

    public function createPersonRole(CreatePersonRoleRequest $request);

    public function getAllPersonRoles(): Collection;

    public function getPersonRole(int $roleId): PersonRole;

    public function editPersonRoleName(EditPersonRoleRequest $request, int $roleId);

    public function deletePersonRole(int $roleId);

    public function attachPersonToMovie(AttachMovieToPersonRequest $request): Person;

    public function detachPersonRoleFromMovie(Person $person, int $movieId, int $roleId);

    public function delete(Person $person): void;

    public function getAllMovies();
}
