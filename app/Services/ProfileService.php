<?php


namespace App\Services;


use App\Enums\RoleType;
use App\Http\Requests\Application\EditProfileRequest;
use App\Http\Requests\Application\PhotoProfileRequest;
use App\Models\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\StorageServiceInterface;
use Couchbase\Role;
use Illuminate\Support\Facades\Storage;

class ProfileService implements ProfileServiceInterface
{
    private ProfileRepositoryInterface $profileRepository;
    private StorageServiceInterface $storageService;

    public function __construct(ProfileRepositoryInterface $profileRepository, StorageServiceInterface $storageService)
    {
        $this->profileRepository = $profileRepository;
        $this->storageService = $storageService;
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
        $this->profileRepository->save($profile);
        return $profile;
    }

    public function editProfileAvatar(PhotoProfileRequest $request, int $userId): Profile
    {
        $profile = $this->profileRepository->getByUserId($userId);
        if ($request->file('avatar') !== null) {
            $profile->update(['avatar' => $this->storageService->storeFileForProfile($request, 'avatar')]);
        } else {
            $this->storageService->delete(str_replace($this->storageService->getStoragePath(), '', $profile->avatar));
            $profile->update(['avatar' => $this->storageService->getDefaultAvatarPath()]);
        }
        return $profile;
    }

    public function create(int $userId)
    {
        $this->profileRepository->create($userId);
    }

    public function setDefaultProfilePhoto(int $userId)
    {
        $profile = $this->getProfileInfo($userId);
        $profile->update(['avatar' => $this->storageService->getDefaultAvatarPath()]);
        return $profile;
    }

    public function deleteByUserId(int $userId)
    {
        $this->profileRepository->deleteByUserId($userId);
    }

    public function all()
    {
        return $this->profileRepository->all();
    }

    public function getProfileById(int $profileId)
    {
        return $this->profileRepository->get($profileId);
    }

    public function delete(int $profileId)
    {
        $user = $this->getProfileById($profileId)->user;
        if ($this->profileRepository->delete($profileId)) {
            $user->email_verified_at = null;
            $user->role = (string)RoleType::user->value;
            $user->save();
        }
    }
}
