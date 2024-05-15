<?php


namespace App\Services\Interfaces;


use App\Http\Requests\Dashboard\EditUserRoleRequest;
use App\Http\Requests\Application\User\CreateUserRequest;
use App\Http\Requests\Application\User\EditUserPasswordRequest;
use App\Http\Requests\Application\User\EditUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface UserServiceInterface
{
    public function editUserPassword(EditUserPasswordRequest $request, int $userId): array;

    public function destroy(Request $request, int $userId);

    public function store(CreateUserRequest $request);

    public function getAllUsers(): Collection;

    public function getUser(int $userId): User;

    public function getAllRoles(): Collection;


    public function update(EditUserRequest $request, $userId);
}
