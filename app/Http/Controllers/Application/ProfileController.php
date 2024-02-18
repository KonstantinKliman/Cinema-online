<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\EditProfileRequest;
use App\Http\Requests\Application\PhotoProfileRequest;
use App\Services\Interfaces\ProfileServiceInterface;

class ProfileController extends Controller
{

    private ProfileServiceInterface $profileService;

    public function __construct(ProfileServiceInterface $profileService)
    {
        $this->profileService = $profileService;
    }

    public function showProfilePage($userId)
    {
        return view('profile', ['profile' => $this->profileService->getProfileInfo($userId)]);
    }

    public function showEditProfileForm($userId)
    {
        return view('profile-edit-form', ['profile' => $this->profileService->getProfileInfo($userId)]);
    }

    public function editProfileInfo(EditProfileRequest $request, $userId)
    {
        $this->profileService->editProfileInfo($request, $userId);
        return redirect()->back()->with('profile_success', 'Profile information changed successfully');
    }

    public function uploadProfilePhoto(PhotoProfileRequest $request, $userId)
    {
        $this->profileService->editProfileAvatar($request, $userId);
        return redirect()->back()->with('photo_message', 'Profile photo changed successfully');
    }

}
