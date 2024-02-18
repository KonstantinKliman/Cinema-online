<?php

namespace App\Services;

use App\Http\Requests\Application\EditUserEmailRequest;
use App\Http\Requests\Application\EditUserNameRequest;
use App\Http\Requests\Application\EditUserPasswordRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService implements UserServiceInterface
{

    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(array $data)
    {
        return $this->userRepository->create($data);
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

    public function editUserPassword(EditUserPasswordRequest $request, int $userId) : array
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

    public function deleteUser(int $userId): string
    {
        $user = $this->userRepository->getByUserId($userId);
        if ($user->profile->hasAvatar()) {
            Storage::delete(str_replace('storage/', '', $user->profile->avatar));
        }
        $this->userRepository->delete($userId);
        $message = 'Account deleted successfully.';
        return $message;
    }
}
