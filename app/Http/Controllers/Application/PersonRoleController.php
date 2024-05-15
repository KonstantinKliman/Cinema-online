<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CreatePersonRoleRequest;
use App\Http\Requests\Dashboard\EditPersonRoleRequest;
use App\Services\Interfaces\PersonRoleServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PersonRoleController extends Controller
{
    private PersonRoleServiceInterface $personRoleService;

    public function __construct(PersonRoleServiceInterface $personRoleService)
    {
        $this->personRoleService = $personRoleService;
    }

    public function index(): View
    {
        return view('dashboard.person.role.index', ['roles' => $this->personRoleService->all()]);
    }

    public function create(): View
    {
        return view('dashboard.person.role.create');
    }

    public function store(CreatePersonRoleRequest $request): RedirectResponse
    {
        $this->personRoleService->create($request);
        return redirect()->route('dashboard.person.role.index', ['role' => $this->personRoleService->all()]);
    }

    public function edit($roleId): View
    {
        return view('dashboard.person.role.edit', ['role' => $this->personRoleService->get($roleId)]);
    }

    public function update($roleId, EditPersonRoleRequest $request): RedirectResponse
    {
        $this->personRoleService->edit($request,(int) $roleId);
        return redirect()->route('dashboard.person.role.index', ['role' => $this->personRoleService->all()]);
    }

    public function delete($roleId): RedirectResponse
    {
        $this->personRoleService->delete($roleId);
        return redirect()->route('dashboard.person.role.index', ['role' => $this->personRoleService->all()]);
    }
}
