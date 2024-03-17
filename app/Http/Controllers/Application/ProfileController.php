<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\EditProfileRequest;
use App\Http\Requests\Application\PhotoProfileRequest;
use App\Services\Interfaces\ProfileServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{

    private ProfileServiceInterface $profileService;

    public function __construct(ProfileServiceInterface $profileService)
    {
        $this->profileService = $profileService;
    }

    public function showProfilePage($userId): View
    {
        return view('profile.main', ['profile' => $this->profileService->getProfileInfo($userId)]);
    }

    public function showEditProfileForm($userId): View
    {
        return view('profile.edit', ['profile' => $this->profileService->getProfileInfo($userId)]);
    }

    public function editProfileInfo(EditProfileRequest $request, $userId): RedirectResponse
    {
        $this->profileService->editProfileInfo($request, $userId);
        return redirect()->back()->with('profile_success', 'Profile information changed successfully');
    }

    public function uploadProfilePhoto(PhotoProfileRequest $request, $userId): RedirectResponse
    {
        $this->profileService->editProfileAvatar($request, $userId);
        return redirect()->back()->with('photo_message', 'Profile photo changed successfully');
    }

    public function defaultProfilePhoto($userId)
    {
        $this->profileService->setDefaultProfilePhoto($userId);
        return redirect()->back();
    }
}
