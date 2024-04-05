<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\User\CreateRequest;
use App\Http\Requests\Application\User\EditUserPasswordRequest;
use App\Http\Requests\Application\User\EditUserRequest;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    private UserServiceInterface $userService;

    private RoleServiceInterface $roleService;

    public function __construct(UserServiceInterface $userService, RoleServiceInterface $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function adminUserIndex(): View
    {
        return view('admin.user.index', [
            'users' => $this->userService->getAllUsers(),
        ]);
    }

    public function adminUserShow($userId): View
    {
        return view('admin.user.show', [
            'user' => $this->userService->getUser($userId),
        ]);
    }

    public function adminUserEdit($userId): View
    {
        return view('admin.user.edit', [
            'user' => $this->userService->getUser($userId),
            'roles' => $this->roleService->all()
        ]);
    }

    public function index(Request $request)
    {
        return view('user.main', ['user' => $request->user()]);
    }

    public function update(EditUserRequest $request, $userId): RedirectResponse
    {
//        dd($request->validated());
        $this->userService->update($request, $userId);
        return redirect()->back();
    }

    public function editUserPassword(EditUserPasswordRequest $request, $userId): RedirectResponse
    {
        $message = $this->userService->editUserPassword($request, $userId);
        return redirect()->back()->with($message);
    }

    public function destroy($userId): RedirectResponse
    {
        $this->userService->destroy($userId);
        return redirect()->route('admin.user.index');
    }

    public function create(): View
    {
        return view('admin.user.create');
    }

    public function store(CreateRequest $request): RedirectResponse
    {
        $user = $this->userService->store($request);
        return redirect()->route('admin.user.show', ['user_id' => $user->id]);
    }
}
