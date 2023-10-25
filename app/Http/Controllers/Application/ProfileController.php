<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Application\EditUserPasswordRequest;
use App\Http\Requests\Application\EditUserNameRequest;
use App\Http\Requests\Application\EditUserEmailRequest;
use App\Http\Requests\Application\EditUserCountryRequest;
use App\Http\Requests\Application\EditUserCityRequest;
use App\Http\Requests\Application\PhotoProfileRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function showEditProfileForm($userId)
    {
        $user = User::find($userId);
        return view('profile-edit-form', ['user' => $user]);
    }

    public function editUserName(EditUserNameRequest $request, $userId)
    {
        $user = User::find($userId);
        $user->name = $request->name;
        $user->save();
        return redirect()->back()->with('success', 'Name changed successfully');
    }

    public function editUserEmail(EditUserEmailRequest $request, $userId)
    {
        $user = User::find($userId);
        $user->email = $request->email;
        $user->save();
        return redirect()->back()->with('success', 'Email changed successfully');
    }

    public function editUserCountry(EditUserCountryRequest $request, $userId)
    {
        $user = User::find($userId);
        $user->country = $request->country;
        $user->save();
        return redirect()->back()->with('success', 'Country changed successfully');
    }

    public function editUserCity(EditUserCityRequest $request, $userId)
    {
        $user = User::find($userId);
        $user->city = $request->city;
        $user->save();
        return redirect()->back()->with('success', 'City changed successfully');
    }

    public function uploadProfilePhoto(PhotoProfileRequest $request, $userId)
    {
        User::where('id', $userId)->update(['profile_photo_path' => 'storage/' . $request->file('profile_photo')->store('profile/photo')]);
        return redirect()->back()->with('photo_success', 'Profile photo changed successfully');
    }

    public function editUserPassword(EditUserPasswordRequest $request, $userId)
    {
        $user = User::find($userId);

        if (Hash::check($request->validated()['password'], $user->password)) {
            return redirect()->back()->withErrors(['password_error' => 'The password is the same as the current one.']);
        }

        $user->password = Hash::make($request->validated()['password']);
        $user->save();

        return redirect()->back()->with('password_success', 'Password changed successfully');
    }

    public function deleteUserAccount($userId)
    {
        $user = User::find($userId);
        $user->delete();
        return redirect()->route('home.page');
    }
}
