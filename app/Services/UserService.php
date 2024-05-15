<?php

namespace App\Services;

use App\Enums\RoleType;
use App\Http\Requests\Dashboard\EditUserRoleRequest;
use App\Http\Requests\Application\User\CreateUserRequest;
use App\Http\Requests\Application\User\EditUserPasswordRequest;
use App\Http\Requests\Application\User\EditUserRequest;
use App\Models\User;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserService implements UserServiceInterface
{

    private UserRepositoryInterface $userRepository;
    private RoleRepositoryInterface $roleRepository;
    private ProfileRepositoryInterface $profileRepository;
    private const DEFAULT_USER_PASSWORD = 'root';

    public function __construct(UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository, ProfileRepositoryInterface $profileRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->profileRepository = $profileRepository;
    }

    public function store(CreateUserRequest $request)
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

    public function destroy(Request $request, int $userId): void
    {
        if ($request->user()->id == $userId) {
            abort(403);
        }
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

    public function getAllRoles(): Collection
    {
        return $this->roleRepository->all();
    }

    public function update(EditUserRequest $request, $userId)
    {
        $data = [
            'name' => $request->validated('name'),
            'email' => $request->validated('email'),
        ];
        $user = $this->userRepository->getByUserId($userId);
        $this->userRepository->update($user, $data);
        if ($request->user()->roles->first()->id == RoleType::Administrator->value) {
            $oldRole = $this->roleRepository->find($user->roles->first()->id);
            $newRole = $this->roleRepository->find($request->validated('role'));
            $user->syncRoles($this->roleRepository->find($request->validated('role')));
            if ($oldRole->id != RoleType::User->value && $newRole->id == RoleType::User->value) {
                $this->profileRepository->delete($user->profile->id);
                $user->email_verified_at = null;
            }
            if ($oldRole->id == RoleType::User->value && $newRole->id != RoleType::User->value) {
                $this->profileRepository->create($user->id, $user->name);
                $user->email_verified_at = date('Y-m-d H:i:s');
            }
        }
        $this->userRepository->save($user);
    }
}
