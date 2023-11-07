<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\EditUserPasswordRequest;
use App\Http\Requests\Application\EditUserEmailRequest;
use App\Http\Requests\Application\EditProfileInfoRequest;
use App\Http\Requests\Application\PhotoProfileRequest;
use App\Services\ProfileService;

class ProfileController extends Controller
{

    private ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function showProfilePage($userId)
    {
        return view('profile', ['user' => $this->profileService->findUserById($userId)]);
    }

    public function showEditProfileForm($userId)
    {
        return view('profile-edit-form', ['user' => $this->profileService->findUserById($userId)]);
    }

    public function editUserName(EditUserNameRequest $request, $userId)
    {
        $this->profileService->editUserName($request, $userId);
        return redirect()->back()->with('success', 'Name changed successfully');
    }

    public function editUserEmail(EditUserEmailRequest $request, $userId)
    {
        $this->profileService->editUserEmail($request, $userId);
        return redirect()->back()->with('success', 'Profile information changed successfully');
    }

    public function editProfileInfo(EditProfileInfoRequest $request, $userId)
    {
        $this->profileService->editProfileInfo($request, $userId);
        return redirect()->back()->with('profile_success', 'Profile information changed successfully');
    }

    public function uploadProfilePhoto(PhotoProfileRequest $request, $userId)
    {
        $this->profileService->editUserAvatar($request, $userId);
        return redirect()->back()->with('photo_success', 'Profile photo changed successfully');
    }

    public function editUserPassword(EditUserPasswordRequest $request, $userId)
    {
        $message = $this->profileService->editUserPassword($request, $userId);
        return redirect()->back()->with($message);
    }

    public function deleteUserAccount($userId)
    {
        $message = $this->profileService->deleteUserAccount($userId);
        return redirect()->route('home.page')->with($message);
    }
}
