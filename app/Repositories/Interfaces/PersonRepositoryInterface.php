<?php


namespace App\Repositories\Interfaces;

use App\Models\Person;

interface PersonRepositoryInterface
{
    public function getByFullName(string $fullName);
    public function firstOrCreate(array $data);
    public function getPersonByUrl(string $personUrl);
    public function getPersonRoles(Person $person);
    public function getPersonMovies(Person $person);
}
