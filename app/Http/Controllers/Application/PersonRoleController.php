<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreatePersonRoleRequest;
use App\Http\Requests\Admin\EditPersonRoleRequest;
use App\Services\Interfaces\PersonRoleServiceInterface;
use Illuminate\Http\Request;

class PersonRoleController extends Controller
{
    private PersonRoleServiceInterface $personRoleService;

    public function __construct(PersonRoleServiceInterface $personRoleService)
    {
        $this->personRoleService = $personRoleService;
    }

    public function index()
    {
        return view('admin.person.role.index', ['roles' => $this->personRoleService->all()]);
    }

    public function store(CreatePersonRoleRequest $request)
    {
        $this->personRoleService->create($request);
        return redirect()->route('admin.person.role.index', ['role' => $this->personRoleService->all()]);
    }

    public function edit($roleId)
    {
        return view('admin.person.role.edit', ['role' => $this->personRoleService->get($roleId)]);
    }

    public function update($roleId, EditPersonRoleRequest $request)
    {
        $this->personRoleService->edit($request,(int) $roleId);
        return redirect()->route('admin.person.role.index', ['role' => $this->personRoleService->all()]);
    }

    public function delete($roleId)
    {
        $this->personRoleService->delete($roleId);
        return redirect()->route('admin.person.role.index', ['role' => $this->personRoleService->all()]);
    }
}
