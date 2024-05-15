<?php


namespace App\Services;


use App\Http\Requests\Application\CreateProfileRequest;
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
    private UserRepositoryInterface $userRepository;
    private const AVATAR_PATH = 'profile/avatar';
    private const STORAGE_PATH = 'storage/';
    private const PROFILE_PATH = 'profile/';
    private const DEFAULT_AVATAR_PATH = 'assets/img/img-profile.png';

    public function __construct(ProfileRepositoryInterface $profileRepository, UserRepositoryInterface $userRepository)
    {
        $this->profileRepository = $profileRepository;
        $this->userRepository = $userRepository;
    }

    public function getProfileInfo(int $userId): Profile
    {
        return $this->profileRepository->getByUserId($userId);
    }

    public function editProfileInfo(EditProfileRequest $request, int $profileId): Profile
    {
        $data = array_filter($request->validated());
        $this->profileRepository->update($profileId, $data);
        return $this->profileRepository->get($profileId);
    }

    public function editProfileAvatar(PhotoProfileRequest $request, int $userId): Profile
    {
        $profile = $this->profileRepository->getByUserId($userId);
        if ($request->file('avatar') !== null) {
            $profile->update(['avatar' => self::STORAGE_PATH . $request->file('avatar')->store(self::PROFILE_PATH . 'avatar')]);
        } else {
            Storage::delete(str_replace(self::STORAGE_PATH, '', $profile->avatar));
            $profile->update(['avatar' => self::DEFAULT_AVATAR_PATH]);
        }
        return $profile;
    }

    public function create(CreateProfileRequest $request)
    {
        $user = $this->userRepository->getByUserId($request->validated('user_id'));
        $this->profileRepository->create($request->validated('user_id'), $user->first_name);
    }

    public function setDefaultProfilePhoto(int $userId)
    {
        $profile = $this->getProfileInfo($userId);
        $profile->update(['avatar' => self::DEFAULT_AVATAR_PATH]);
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

    public function getAllUsers()
    {
        return $this->userRepository->all();
    }
}
