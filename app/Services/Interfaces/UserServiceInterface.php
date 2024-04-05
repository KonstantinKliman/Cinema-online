<?php


namespace App\Services\Interfaces;


use App\Http\Requests\Admin\EditUserRoleRequest;
use App\Http\Requests\Application\EditUserEmailRequest;
use App\Http\Requests\Application\EditUserNameRequest;
use App\Http\Requests\Application\User\CreateRequest;
use App\Http\Requests\Application\User\EditUserPasswordRequest;
use App\Http\Requests\Application\User\EditUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceInterface
{
    public function editUserPassword(EditUserPasswordRequest $request, int $userId): array;

    public function destroy(int $userId);

    public function store(CreateRequest $request);

    public function getAllUsers(): Collection;

    public function getUser(int $userId): User;

    public function getAllRoles(): array;

    public function editUserRole(EditUserRoleRequest $request, $userId);

    public function update(EditUserRequest $request, $userId);
}
