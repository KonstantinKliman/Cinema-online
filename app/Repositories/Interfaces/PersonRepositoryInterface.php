<?php


namespace App\Repositories\Interfaces;

use App\Models\Person;
use Illuminate\Database\Eloquent\Collection;

interface PersonRepositoryInterface
{
    public function getByFullName(string $fullName);

    public function create(array $data);

    public function getPersonRoles(Person $person);

    public function getPersonMovies(Person $person);

    public function all(): Collection;

    public function getMovieRoles(Person $person, int $movieId);

    public function update(array $data, Person $person);

    public function get(int $id);

    public function exists(int $personId, int $movieId, int $roleId);

    public function attachToMovie(Person $person, int $movieId, int $roleId);

    public function detachPersonRoleFromMovie(Person $person, int $movieId, int $roleId);

    public function delete(Person $person): void;
}
