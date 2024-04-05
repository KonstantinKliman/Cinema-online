<?php


namespace App\Services;


use App\Http\Requests\Application\CreateProfileRequest;
use App\Http\Requests\Application\EditProfileRequest;
use App\Http\Requests\Application\PhotoProfileRequest;
use App\Models\Profile;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\StorageServiceInterface;

class ProfileService implements ProfileServiceInterface
{
    private ProfileRepositoryInterface $profileRepository;
    private StorageServiceInterface $storageService;
    private const AVATAR_PATH = 'profile/avatar';
    private const STORAGE_PATH = 'storage/';

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

    public function create(CreateProfileRequest $request)
    {
        $userId = $request->validated('user_id');
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
        $this->profileRepository->delete($profileId);
    }

    public function update(EditProfileRequest $request, int $profileId): void
    {
        $data = [
            'first_name' => $request->validated('first_name'),
            'last_name' => $request->validated('last_name'),
            'date_of_birth' => $request->validated('date_of_birth'),
            'country' => $request->validated('country'),
            'city' => $request->validated('city'),
            'description' => $request->validated('description')
        ];

        $profile = $this->profileRepository->get($profileId);

        $this->profileRepository->update($profile, $data);

        if ($request->hasFile('avatar')) {
            $profile->avatar = self::STORAGE_PATH . $request->file('avatar')->store(self::AVATAR_PATH);
        }

        $this->profileRepository->save($profile);

    }
}
