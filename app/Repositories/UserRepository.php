<?php


namespace App\Repositories;

use App\Enums\RoleType;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Spatie\Permission\Models\Role;

class UserRepository implements UserRepositoryInterface

{
    public function getByUserId(int $userId)
    {
        return User::where('id', $userId)->first();
    }

    public function save($user)
    {
        $user->save();
    }

    public function all()
    {
        return User::all();
    }

    public function delete(int $userId)
    {
        User::find($userId)->delete();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function editUserName(User $user, string $name): string
    {
        return $user->name = $name;
    }

    public function editUserEmail(User $user, string $email): string
    {
        return $user->email = $email;
    }

    public function getAllRoles(): array
    {
        return User::getRoles();
    }

    public function editUserRole(User $user, string $role): void
    {
        $user->assignRole($role);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
    }
}
