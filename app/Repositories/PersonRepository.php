<?php


namespace App\Repositories;

use App\Models\Person;
use App\Repositories\Interfaces\PersonRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PersonRepository implements PersonRepositoryInterface
{

    public function create(array $data)
    {
        return Person::firstOrCreate($data);
    }

    public function getByFullName(string $fullName)
    {
        return Person::where('full_name', $fullName)->first();
    }

    public function getPersonRoles(Person $person)
    {
        return $person->movies->pluck('pivot.role')->unique()->all();
    }

    public function getPersonMovies(Person $person)
    {
        return $person->movies->unique()->all();
    }

    public function all(): Collection
    {
        return Person::all();
    }

    public function getMovieRoles(Person $person, int $movieId)
    {
        return $person->movies()->where('movie_id', $movieId)->get()->pluck('pivot.role');
    }

    public function update(array $data, Person $person)
    {
        $person->update($data);
    }

    public function get(int $id)
    {
        return Person::find($id);
    }

    public function exists(int $personId, int $movieId, int $roleId)
    {
        $person = $this->get($personId);
        return $person->movies()->where('movie_id', $movieId)->where('role_id', $roleId)->exists();
    }

    public function attachToMovie(Person $person, int $movieId, int $roleId)
    {
        $person->movies()->attach($movieId, ['role_id' => $roleId]);
    }

    public function detachPersonRoleFromMovie(Person $person, int $movieId, int $roleId)
    {
        $person->movies()->wherePivot('role_id', $roleId)->detach($movieId);
    }

    public function delete(Person $person): void
    {
        $person->delete();
    }
}
