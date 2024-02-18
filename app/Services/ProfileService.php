<?php


namespace App\Services;


use App\Http\Requests\Application\EditProfileRequest;
use App\Http\Requests\Application\PhotoProfileRequest;
use App\Models\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\ProfileServiceInterface;
use Illuminate\Support\Facades\Storage;

class ProfileService implements ProfileServiceInterface
{
    private ProfileRepositoryInterface $profileRepository;

    public function __construct(ProfileRepositoryInterface $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function getProfileInfo(int $userId): Profile
    {
        return $this->profileRepository->getByUserId($userId);
    }

    public function editProfileInfo(EditProfileRequest $request, int $userId): Profile
    {
        $profile = $this->profileRepository->getByUserId($userId);
        $data = $request->validated();
        foreach ($data as $key => $value) {
            $profile->$key = $value;
        }
        $profile->save();
        return $profile;
    }

    public function editProfileAvatar(PhotoProfileRequest $request, int $userId): Profile
    {
        $profile = $this->profileRepository->getByUserId($userId);
        if ($request->file('avatar') !== null) {
            $profile->update(['avatar' => 'storage/' . $request->file('avatar')->store('profile/avatar')]);
        } else {
            Storage::delete(str_replace('storage/', '', $profile->avatar));
            $profile->update(['avatar' => 'assets/img/img-profile.png']);
        }
        return $profile;
    }

    public function create(int $userId)
    {
        $this->profileRepository->create($userId);
    }
}
