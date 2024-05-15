<?php


namespace App\Services\Interfaces;


use App\Http\Requests\Application\CreateProfileRequest;
use App\Http\Requests\Application\EditProfileRequest;
use App\Http\Requests\Application\PhotoProfileRequest;
use App\Models\Profile;

interface ProfileServiceInterface
{
    public function getProfileInfo(int $userId): Profile;

    public function editProfileInfo(EditProfileRequest $request, int $profileId): Profile;

    public function editProfileAvatar(PhotoProfileRequest $request, int $userId): Profile;

    public function create(CreateProfileRequest $request);

    public function setDefaultProfilePhoto(int $userId);

    public function deleteByUserId(int $userId);

    public function all();

    public function getProfileById(int $profileId);

    public function delete(int $profileId);

    public function update(EditProfileRequest $request, int $profileId);

    public function getAllUsers();
}
