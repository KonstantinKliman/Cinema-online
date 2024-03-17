<?php

namespace App\Services;

use App\Http\Requests\Admin\CreatePersonRoleRequest;
use App\Http\Requests\Admin\EditPersonRoleRequest;
use App\Models\PersonRole;
use App\Repositories\Interfaces\PersonRoleRepositoryInterface;
use App\Services\Interfaces\PersonRoleServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class PersonRoleService implements PersonRoleServiceInterface
{
    private PersonRoleRepositoryInterface $roleRepository;

    public function __construct(PersonRoleRepositoryInterface $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function create(CreatePersonRoleRequest $request): PersonRole
    {
        $data = [
            'name' => ucfirst($request->validated('name')),
        ];
        return $this->roleRepository->create($data);
    }

    public function all(): Collection
    {
        return $this->roleRepository->all();
    }

    public function get(int $roleId): PersonRole
    {
        return $this->roleRepository->get($roleId);
    }

    public function edit(EditPersonRoleRequest $request, int $roleId)
    {
        $data = [
            'name' => ucfirst($request->validated('name')),
        ];
        return $this->roleRepository->edit($roleId, $data);
    }

    public function delete(int $roleId)
    {
        $this->roleRepository->delete($roleId);
    }
}
