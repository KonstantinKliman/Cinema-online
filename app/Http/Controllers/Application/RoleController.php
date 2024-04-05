<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRoleRequest;
use App\Http\Requests\Admin\EditRoleRequest;
use App\Services\Interfaces\RoleServiceInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private RoleServiceInterface $roleService;

    public function __construct(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        return view('admin.role.index', ['roles' => $this->roleService->all()]);
    }

    public function create()
    {
        return view('admin.role.create', ['permissions' => $this->roleService->permissions()]);
    }

    public function store(CreateRoleRequest $request)
    {
        $this->roleService->create($request);
        return redirect()->route('admin.role.index');
    }

    public function edit($roleId)
    {
        return view('admin.role.edit', [
            'role' => $this->roleService->get($roleId),
            'permissions' => $this->roleService->permissions()
        ]);
    }

    public function update(EditRoleRequest $request, $roleId)
    {
        $this->roleService->update($request, $roleId);
        return redirect()->back();
    }

    public function delete($roleId)
    {
        $this->roleService->delete($roleId);
        return redirect()->back();
    }
}
