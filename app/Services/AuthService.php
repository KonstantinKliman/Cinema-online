<?php


namespace App\Services;

use App\Enums\RoleType;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{

    private UserRepositoryInterface $userRepository;
    private ProfileRepositoryInterface $profileRepository;
    private RoleRepositoryInterface $roleRepository;

    public function __construct(UserRepositoryInterface $userRepository, ProfileRepositoryInterface $profileRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
        $this->roleRepository = $roleRepository;
    }

    public function register(RegisterRequest $request): User //
    {
        $data = array(
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make($request->validated('password'))
        );
        $user = $this->userRepository->create($data);
        $user->assignRole(RoleType::User->name);
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
        $user = $this->userRepository->getByUserId($request->user()->id);
        $request->fulfill();
        $user->syncRoles($this->roleRepository->find(RoleType::Verified->value));
        $this->profileRepository->create($request->user()->id, $user->name);
    }

    public function resendVerificationLink(Request $request): void
    {
        $request->user()->sendEmailVerificationNotification();
    }
}
