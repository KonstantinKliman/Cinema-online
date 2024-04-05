<?php

namespace App\Repositories;

use App\Models\PersonRole;
use App\Repositories\Interfaces\PersonRoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class PersonRoleRepository implements PersonRoleRepositoryInterface
{
    public function create(array $data): PersonRole
    {
        return PersonRole::firstOrCreate($data);
    }

    public function all(): Collection
    {
        return PersonRole::all();
    }

    public function get(int $roleId): PersonRole
    {
        return PersonRole::find($roleId);
    }

    public function edit(int $roleId, array $data)
    {
        return PersonRole::where('id', $roleId)->update($data);
    }

    public function delete(int $roleId)
    {
        PersonRole::destroy($roleId);
    }
}
