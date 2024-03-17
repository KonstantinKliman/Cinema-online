<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\EditUserEmailRequest;
use App\Http\Requests\Application\EditUserNameRequest;
use App\Http\Requests\Application\EditUserPasswordRequest;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function showUserAccount(Request $request)
    {
        return view('user.main', ['user' => $request->user()]);
    }

    public function editUserName(EditUserNameRequest $request, $userId): RedirectResponse
    {
        $this->userService->editUserName($request, $userId);
        return redirect()->back()->with('success', 'Name changed successfully');
    }

    public function editUserEmail(EditUserEmailRequest $request, $userId): RedirectResponse
    {
        $this->userService->editUserEmail($request, $userId);
        return redirect()->back()->with('success', 'Email changed successfully');
    }

    public function editUserPassword(EditUserPasswordRequest $request, $userId): RedirectResponse
    {
        $message = $this->userService->editUserPassword($request, $userId);
        return redirect()->back()->with($message);
    }

    public function deleteUser($userId): RedirectResponse
    {
        $this->userService->deleteUser($userId);
        return redirect()->route('home.page');
    }

}
