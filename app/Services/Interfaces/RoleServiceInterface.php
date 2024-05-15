<?php

namespace App\Services\Interfaces;

use App\Http\Requests\Dashboard\CreateRoleRequest;
use App\Http\Requests\Dashboard\EditRoleRequest;
use Illuminate\Database\Eloquent\Collection;

interface RoleServiceInterface
{
    public function create(CreateRoleRequest $request);

    public function get(int $roleId);

    public function all(): Collection;

    public function permissions(): Collection;

    public function update(EditRoleRequest $request, $roleId);

    public function delete(int $roleId);
}
