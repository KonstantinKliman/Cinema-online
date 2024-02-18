<?php


namespace App\Services\Interfaces;


use App\Http\Requests\Application\CreatePersonRequest;
use App\Models\Person;

interface PersonServiceInterface
{
    public function create(CreatePersonRequest $request);
    public function getPersonByFullName(string $fullName);
    public function getPersonByUrl(string $personUrl);
    public function getPersonRoles(Person $person);
    public function getPersonMovies(Person $person);
}
