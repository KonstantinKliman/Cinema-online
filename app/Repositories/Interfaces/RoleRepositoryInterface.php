<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Role;

interface RoleRepositoryInterface
{
    public function all(): Collection;

    public function findOrFail(int $roleId);

    public function update(Role $role, array $data);

    public function sync(Role $role, Collection $permissions): Role;

    public function create(array $data);

    public function find(int $roleId);

    public function delete(int $roleId);
}
