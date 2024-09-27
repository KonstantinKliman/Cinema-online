<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CreateRoleRequest;
use App\Http\Requests\Dashboard\EditRoleRequest;
use App\Services\Interfaces\RoleServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    private RoleServiceInterface $roleService;

    public function __construct(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index(): View
    {
        return view('dashboard.role.index', ['roles' => $this->roleService->all()]);
    }

    public function create(): View
    {
        return view('dashboard.role.create', ['permissions' => $this->roleService->permissions()]);
    }

    public function store(CreateRoleRequest $request): RedirectResponse
    {
        $this->roleService->create($request);
        return redirect()->route('dashboard.role.index');
    }

    public function edit($roleId): View
    {
        return view('dashboard.role.edit', [
            'role' => $this->roleService->get($roleId),
            'permissions' => $this->roleService->permissions()
        ]);
    }

    public function update(EditRoleRequest $request, $roleId): RedirectResponse
    {
        $this->roleService->update($request, $roleId);
        return redirect()->back();
    }

    public function delete($roleId): RedirectResponse
    {
        $this->roleService->delete($roleId);
        return redirect()->back();
    }
}
