<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PermissionRepositoryInterface
{
    public function get(array $data): Collection;

    public function all();
}
