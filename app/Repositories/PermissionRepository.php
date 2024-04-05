<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{

    public function get(array $data): Collection
    {
        return Permission::whereIn('id', $data)->get();
    }

    public function all()
    {
        return Permission::all();
    }
}
