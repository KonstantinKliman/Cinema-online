<?php

namespace App\Repositories\Interfaces;

use App\Models\PersonRole;
use Illuminate\Database\Eloquent\Collection;

interface PersonRoleRepositoryInterface
{
    public function create(array $data): PersonRole;

    public function all(): Collection;

    public function get(int $roleId): PersonRole;

    public function edit(int $roleId, array $data);

    public function delete(int $roleId);
}
