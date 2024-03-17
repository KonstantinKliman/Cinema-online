<?php


namespace App\Services\Interfaces;


use App\Http\Requests\Application\EditProfileRequest;
use App\Http\Requests\Application\PhotoProfileRequest;
use App\Models\Profile;

interface ProfileServiceInterface
{
    public function getProfileInfo(int $userId): Profile;

    public function editProfileInfo(EditProfileRequest $request, int $userId): Profile;

    public function editProfileAvatar(PhotoProfileRequest $request, int $userId): Profile;

    public function create(int $userId);

    public function setDefaultProfilePhoto(int $userId);

    public function deleteByUserId(int $userId);

    public function all();

    public function getProfileById(int $profileId);

    public function delete(int $profileId);
}
