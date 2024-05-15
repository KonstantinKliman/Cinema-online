<?php

namespace App\Services\Interfaces;

use App\Http\Requests\Dashboard\CreatePersonRoleRequest;
use App\Http\Requests\Dashboard\EditPersonRoleRequest;
use App\Models\PersonRole;
use Illuminate\Database\Eloquent\Collection;

interface PersonRoleServiceInterface
{
    public function create(CreatePersonRoleRequest $request): PersonRole;

    public function all(): Collection;

    public function get(int $roleId): PersonRole;

    public function edit(EditPersonRoleRequest $request, int $roleId);

    public function delete(int $roleId);
}
