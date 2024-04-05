<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\CreateProfileRequest;
use App\Http\Requests\Application\EditProfileRequest;
use App\Http\Requests\Application\PhotoProfileRequest;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{

    private ProfileServiceInterface $profileService;
    private UserServiceInterface $userService;

    public function __construct(ProfileServiceInterface $profileService, UserServiceInterface $userService)
    {
        $this->profileService = $profileService;
        $this->userService = $userService;
    }

    public function index()
    {
        return view('admin.profile.index', ['profiles' => $this->profileService->all()]);
    }

    public function adminEdit(int $profileId)
    {
        return view('admin.profile.edit', ['profile' => $this->profileService->getProfileById($profileId)]);
    }

    public function update(EditProfileRequest $request, int $profileId)
    {
        $this->profileService->update($request, $profileId);
        return redirect()->back();
    }

    public function delete(int $profileId)
    {
        $this->profileService->delete($profileId);
        return redirect()->back();
    }

    public function create()
    {
        return view('admin.profile.create', ['users' => $this->userService->getAllUsers()]);
    }

    public function store(CreateProfileRequest $request)
    {
        $this->profileService->create($request);
        return redirect()->route('admin.profile.index');
    }

    public function adminShow(int $profileId)
    {
        return view('admin.profile.show', ['profile' => $this->profileService->getProfileById($profileId)]);
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
