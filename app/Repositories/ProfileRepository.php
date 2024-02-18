<?php


namespace App\Repositories;

use App\Models\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;

class ProfileRepository implements ProfileRepositoryInterface
{
    public function getByUserId(int $userId)
    {
        return Profile::where('user_id', $userId)->first();
    }

    public function create(int $userId)
    {
        return Profile::create(['user_id' => $userId, 'avatar' => 'assets/img/img-profile.png']);
    }
}
