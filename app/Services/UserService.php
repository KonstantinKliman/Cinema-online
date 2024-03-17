<?php

namespace App\Services;

use App\Enums\RoleType;
use App\Http\Requests\Admin\EditUserRoleRequest;
use App\Http\Requests\Application\EditUserEmailRequest;
use App\Http\Requests\Application\EditUserNameRequest;
use App\Http\Requests\Application\EditUserPasswordRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService implements UserServiceInterface
{

    private UserRepositoryInterface $userRepository;
    private ProfileServiceInterface $profileService;

    public function __construct(UserRepositoryInterface $userRepository, ProfileServiceInterface $profileService)
    {
        $this->userRepository = $userRepository;
        $this->profileService = $profileService;
    }

    public function create(array $data)
    {
        $user = $this->userRepository->create($data);
        if ((int)$user->role == RoleType::user->value) {
            $this->profileService->create($user->id);
        }
        return $user;
    }

    public function editUserName(EditUserNameRequest $request, int $userId): User
    {
        $user = $this->userRepository->getByUserId($userId);
        $this->userRepository->editUserName($user, $request->validated('name'));
        $this->userRepository->save($user);
        return $user;
    }

    public function editUserEmail(EditUserEmailRequest $request, int $userId): User
    {
        $user = $this->userRepository->getByUserId($userId);
        $this->userRepository->editUserEmail($user, $request->validated('email'));
        $this->userRepository->save($user);
        return $user;
    }

    public function editUserPassword(EditUserPasswordRequest $request, int $userId): array
    {
        $user = $this->userRepository->getByUserId($userId);
        $message = [];

        if (Hash::check($request->validated('password'), $user->password)) {
            return $message = ['password_error' => 'The password is the same as the current one.'];
        }

        $user->password = Hash::make($request->validated('password'));
        $this->userRepository->save($user);

        return $message = ['password_success' => 'Password changed successfully.'];
    }

    public function deleteUser(int $userId): void
    {
        $user = $this->userRepository->getByUserId($userId);
        if ($user->profile) {
            if ($user->profile->hasAvatar()) {
                Storage::delete(str_replace('storage/', '', $user->profile->avatar));
            }
        }
        $this->userRepository->delete($userId);
    }

    public function getAllUsers(): Collection
    {
        return $this->userRepository->all();
    }

    public function getUser(int $userId): User
    {
        return $this->userRepository->getByUserId($userId);
    }

    public function getAllRoles(): array
    {
        return $this->userRepository->getAllRoles();
    }

    public function editUserRole(EditUserRoleRequest $request, $userId)
    {
        $currentRole = (int)$this->userRepository->getByUserId($userId)->role;
        $newRole = (int)$request->validated('role');
        $this->userRepository->editUserRole($userId, $request->validated('role'));
        if ($newRole === RoleType::user->value) {
            $this->profileService->deleteByUserId($userId);
            $user = $this->userRepository->getByUserId($userId);
            $user->email_verified_at = null;
            $user->save();
        } elseif ($currentRole === RoleType::user->value) {
            $this->profileService->create($userId);
        }
        if ($newRole !== RoleType::user->value) {
            $user = $this->userRepository->getByUserId($userId);
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->save();
        }
    }
}
