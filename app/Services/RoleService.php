<?php

namespace App\Services;

use App\Http\Requests\Admin\CreateRoleRequest;
use App\Http\Requests\Admin\EditRoleRequest;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Services\Interfaces\RoleServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleService implements RoleServiceInterface
{
    private RoleRepositoryInterface $roleRepository;

    private PermissionRepositoryInterface $permissionRepository;

    public function __construct(RoleRepositoryInterface $roleRepository, PermissionRepositoryInterface $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    public function create(CreateRoleRequest $request)
    {
        $data = [
            'name' => $request->validated('name'),
        ];
        $newRole = $this->roleRepository->create($data);
        $permissions = $this->permissionRepository->get($request->validated('permissions'));
        $this->roleRepository->sync($newRole, $permissions);
    }

    public function get(int $roleId)
    {
        return $this->roleRepository->find($roleId);
    }

    public function all(): Collection
    {
        return $this->roleRepository->all();
    }

    public function permissions(): Collection
    {
        return $this->permissionRepository->all();
    }

    public function update(EditRoleRequest $request, $roleId)
    {
        $role = $this->roleRepository->findOrFail($roleId);
        $data = [
            'name' => $request->validated('name'),
        ];
        $this->roleRepository->update($role, $data);
        $permissions = $this->permissionRepository->get($request->validated('permissions'));
        $this->roleRepository->sync($role, $permissions);
    }

    public function delete(int $roleId)
    {
        $this->roleRepository->delete($roleId);
    }
}
