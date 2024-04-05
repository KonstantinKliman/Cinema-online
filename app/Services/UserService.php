<?php

namespace App\Services;

use App\Enums\RoleType;
use App\Http\Requests\Admin\EditUserRoleRequest;
use App\Http\Requests\Application\User\CreateRequest;
use App\Http\Requests\Application\User\EditUserPasswordRequest;
use App\Http\Requests\Application\User\EditUserRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserService implements UserServiceInterface
{

    private UserRepositoryInterface $userRepository;
    private ProfileServiceInterface $profileService;

    private RoleServiceInterface $roleService;
    private const DEFAULT_USER_PASSWORD = 'root';

    public function __construct(UserRepositoryInterface $userRepository, ProfileServiceInterface $profileService, RoleServiceInterface $roleService)
    {
        $this->userRepository = $userRepository;
        $this->profileService = $profileService;
        $this->roleService = $roleService;
    }

    public function store(CreateRequest $request)
    {
        $data = [
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
            'password' => Hash::make(self::DEFAULT_USER_PASSWORD)
        ];
        $user = $this->userRepository->create($data);
        $user->assignRole('user');
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

    public function destroy(int $userId): void
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

    public function update(EditUserRequest $request, $userId)
    {
        $data = [
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
        ];
        $user = $this->userRepository->getByUserId($userId);
        $newRoleName = $this->roleService->get($request->validated('role'))->name;
        $oldRoleName = $user->roles()->first()->name;
        $this->userRepository->update($user, $data);
        $user->removeRole($oldRoleName);
        $user->assignRole($newRoleName);
        $this->userRepository->save($user);
    }
}
