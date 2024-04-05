<?php


namespace App\Repositories\Interfaces;

use App\Models\Profile;

interface ProfileRepositoryInterface
{
    public function getByUserId(int $userId);

    public function create(int $userId);

    public function save(Profile $profile);

    public function deleteByUserId(int $userId);

    public function all();

    public function get(int $profileId);

    public function delete(int $profileId);

    public function update(Profile $profile, array $data);
}
