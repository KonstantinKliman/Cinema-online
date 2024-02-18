<?php


namespace App\Services\Interfaces;


use App\Http\Requests\Application\EditUserEmailRequest;
use App\Http\Requests\Application\EditUserNameRequest;
use App\Http\Requests\Application\EditUserPasswordRequest;
use App\Models\User;

interface UserServiceInterface
{
    public function editUserName(EditUserNameRequest $request, int $userId): User;
    public function editUserEmail(EditUserEmailRequest $request, int $userId): User;
    public function editUserPassword(EditUserPasswordRequest $request, int $userId) : array;
    public function deleteUser(int $userId);
    public function create(array $data);
}
