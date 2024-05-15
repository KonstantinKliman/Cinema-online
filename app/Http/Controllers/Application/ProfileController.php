<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\CreateProfileRequest;
use App\Http\Requests\Application\EditProfileRequest;
use App\Http\Requests\Application\PhotoProfileRequest;
use App\Services\Interfaces\ProfileServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{

    private ProfileServiceInterface $profileService;

    public function __construct(ProfileServiceInterface $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index(Request $request): View
    {
        return view('profile.edit', ['profile' => $this->profileService->getProfileInfo($request->user()->id)]);
    }

    public function adminIndex(): View
    {
        return view('dashboard.profile.index', ['profiles' => $this->profileService->all()]);
    }

    public function adminEdit(int $profileId): View
    {
        return view('dashboard.profile.edit', ['profile' => $this->profileService->getProfileById($profileId)]);
    }

    public function update(EditProfileRequest $request, int $profileId)
    {
        $this->profileService->update($request, $profileId);
        return redirect()->back();
    }

    public function delete(int $profileId): RedirectResponse
    {
        $this->profileService->delete($profileId);
        return redirect()->back();
    }

    public function create(): View
    {
        return view('dashboard.profile.create', ['users' => $this->profileService->getAllUsers()]);
    }

    public function store(CreateProfileRequest $request): RedirectResponse
    {
        $this->profileService->create($request);
        return redirect()->route('dashboard.profile.index');
    }

    public function adminShow(int $profileId): View
    {
        return view('dashboard.profile.show', ['profile' => $this->profileService->getProfileById($profileId)]);
    }

    public function showProfilePage(int $profileId): View
    {
        return view('profile.main', ['profile' => $this->profileService->getProfileInfo($profileId)]);
    }

    public function showEditProfileForm($userId): View
    {
        return view('profile.edit', ['profile' => $this->profileService->getProfileInfo($userId)]);
    }

    public function editProfileInfo(EditProfileRequest $request, $profileId): RedirectResponse
    {
        $this->profileService->editProfileInfo($request, $profileId);
        return redirect()->back()->with('profile_success', 'Profile information changed successfully');
    }

    public function uploadProfilePhoto(PhotoProfileRequest $request, $userId): RedirectResponse
    {
        $this->profileService->editProfileAvatar($request, $userId);
        return redirect()->back()->with('photo_message', 'Profile photo changed successfully');
    }

    public function defaultProfilePhoto($userId): RedirectResponse
    {
        $this->profileService->setDefaultProfilePhoto($userId);
        return redirect()->back();
    }
}
