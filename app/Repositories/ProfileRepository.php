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

    public function create(int $userId, string $firstName)
    {
        return Profile::create([
            'user_id' => $userId,
            'avatar' => 'assets/img/img-profile.png',
            'first_name' => $firstName]);
    }

    public function save(Profile $profile)
    {
        $profile->save();
    }

    public function deleteByUserId(int $userId)
    {
        Profile::where('user_id', $userId)->delete();
    }

    public function all()
    {
        return Profile::all();
    }

    public function get(int $profileId)
    {
        return Profile::find($profileId);
    }

    public function delete(int $profileId): void
    {
        Profile::destroy($profileId);
    }

    public function update(int $profileId, array $data)
    {
        Profile::query()->where('id', $profileId)->update($data);
    }
}
