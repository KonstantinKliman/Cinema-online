<?php


namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function getByUserId(int $userId);
    public function save(User $user);
    public function all();
    public function delete(int $userId);
    public function create(array $data);
    public function editUserName(User $user, string $name): string;
    public function editUserEmail(User $user, string $email): string;
}
