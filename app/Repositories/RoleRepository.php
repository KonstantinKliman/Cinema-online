<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

class RoleRepository implements RoleRepositoryInterface
{
    public function all(): Collection
    {
        return Role::where('name', '!=', 'administrator')->get();
    }

    public function findOrFail(int $roleId)
    {
        return Role::where('name', '!=', 'administrator')->findOrFail($roleId);
    }

    public function update(Role $role, array $data)
    {
        $role->update($data);
    }

    public function sync(Role $role, Collection $permissions): Role
    {
        return $role->syncPermissions($permissions);
    }

    public function create(array $data)
    {
        return Role::create($data);
    }

    public function find(int $roleId)
    {
        return Role::find($roleId);
    }

    public function delete(int $roleId)
    {
        Role::destroy($roleId);
    }
}
