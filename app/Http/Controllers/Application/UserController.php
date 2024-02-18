<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\EditUserEmailRequest;
use App\Http\Requests\Application\EditUserNameRequest;
use App\Http\Requests\Application\EditUserPasswordRequest;
use App\Services\Interfaces\UserServiceInterface;
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
        return view('user-account', ['user' => $request->user()]);
    }

    public function editUserName(EditUserNameRequest $request, $userId)
    {
        $this->userService->editUserName($request, $userId);
        return redirect()->back()->with('success', 'Name changed successfully');
    }

    public function editUserEmail(EditUserEmailRequest $request, $userId)
    {
        $this->userService->editUserEmail($request, $userId);
        return redirect()->back()->with('success', 'Profile information changed successfully');
    }

    public function editUserPassword(EditUserPasswordRequest $request, $userId)
    {
        $message = $this->userService->editUserPassword($request, $userId);
        return redirect()->back()->with($message);
    }

    public function deleteUser($userId)
    {
        $message = $this->userService->deleteUser($userId);
        return redirect()->route('home.page')->with($message);
    }

}
