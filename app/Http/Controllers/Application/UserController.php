<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\User\CreateUserRequest;
use App\Http\Requests\Application\User\EditUserPasswordRequest;
use App\Http\Requests\Application\User\EditUserRequest;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function adminUserIndex(): View //
    {
        return view('dashboard.user.index', [
            'users' => $this->userService->getAllUsers(),
        ]);
    }

    public function adminUserShow($userId): View //
    {
        return view('dashboard.user.show', [
            'user' => $this->userService->getUser($userId),
        ]);
    }

    public function adminUserEdit($userId): View //
    {
        return view('dashboard.user.edit', [
            'user' => $this->userService->getUser($userId),
            'roles' => $this->userService->getAllRoles()
        ]);
    }

    public function index(Request $request): View //
    {
        return view('user.main', ['user' => $request->user()]);
    }

    public function update(EditUserRequest $request, $userId): RedirectResponse //
    {
        $this->userService->update($request, $userId);
        return redirect()->back();
    }

    public function editUserPassword(EditUserPasswordRequest $request, $userId): RedirectResponse //
    {
        $message = $this->userService->editUserPassword($request, $userId);
        return redirect()->back()->with($message);
    }

    public function delete(Request $request, $userId): RedirectResponse //
    {
        $this->userService->destroy($request, $userId);
        return redirect()->route('dashboard.user.index');
    }

    public function create(): View //
    {
        return view('dashboard.user.create');
    }

    public function store(CreateUserRequest $request): RedirectResponse //
    {
        $user = $this->userService->store($request);
        return redirect()->route('dashboard.user.show', ['user_id' => $user->id]);
    }
}
