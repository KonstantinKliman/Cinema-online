<?php


namespace App\Repositories;

use App\Models\Person;
use App\Repositories\Interfaces\PersonRepositoryInterface;

class PersonRepository implements PersonRepositoryInterface
{

    public function firstOrCreate(array $data)
    {
        return Person::firstOrCreate($data);
    }

    public function getByFullName(string $fullName)
    {
        return Person::where('full_name', $fullName)->first();
    }

    public function getPersonByUrl(string $personUrl)
    {
        return Person::where('person_url', $personUrl)->firstOrFail();
    }

    public function getPersonRoles(Person $person)
    {
        return $person->movies->pluck('pivot.role')->unique()->all();
    }

    public function getPersonMovies(Person $person)
    {
        return $person->movies->unique()->all();
    }
}
