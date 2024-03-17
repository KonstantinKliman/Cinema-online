<?php


namespace App\Services;

use App\Enums\RoleType;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;

class AuthService implements AuthServiceInterface
{

    private UserServiceInterface $userService;
    private ProfileServiceInterface $profileService;

    public function __construct(UserServiceInterface $userService, ProfileServiceInterface $profileService)
    {
        $this->userService = $userService;
        $this->profileService = $profileService;
    }

    public function register(RegisterRequest $request): User
    {
        $user = $this->userService->create($request->validated());
        event(new Registered($user));
        $this->login([
            'email' => $request->validated('email'),
            'password' => $request->validated('password'),
        ], false);
        return $user;
    }

    public function login(array $credentials, bool $isRememberMe = false): bool
    {
        return Auth::attempt($credentials, $isRememberMe);
    }

    public function logout(): void
    {
        Auth::logout();
    }

    public function verifyEmail(EmailVerificationRequest $request): void
    {
        $request->fulfill();
        $this->profileService->create($request->user()->id);
    }

    public function resendVerificationLink(Request $request): void
    {
        $request->user()->sendEmailVerificationNotification();
    }
}
