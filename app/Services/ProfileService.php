<?php


namespace App\Services;


use App\Http\Requests\Application\EditProfileInfoRequest;
use App\Http\Requests\Application\EditUserEmailRequest;
use App\Http\Requests\Application\EditUserPasswordRequest;
use App\Http\Requests\Application\PhotoProfileRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileService
{
    public function findUserById(int $userId): User
    {
        $user = User::where('id', $userId)->first();
        return $user;
    }

    private function findProfileByUserId(int $userId): Profile
    {
        $profile = Profile::where('user_id', $userId)->first();
        return $profile;
    }

    public function editProfileInfo(EditProfileInfoRequest $request, int $userId): Profile
    {
        $profile = $this->findProfileByUserId($userId);
        $data = $request->validated();
        foreach ($data as $key => $value) {
            $profile->$key = $value;
        }
        $profile->save();
        return $profile;
    }

    public function editUserName(EditUserNameRequest $request, int $userId): User
    {
        $user = $this->findUserById($userId);
        $user->name = $request->name;
        $user->save();
        return $user;
    }

    public function editUserEmail(EditUserEmailRequest $request, int $userId): User
    {
        $user = $this->findUserById($userId);
        $user->email = $request->email;
        $user->save();
        return $user;
    }

    public function editUserAvatar(PhotoProfileRequest $request, int $userId): Profile
    {
        $profile = $this->findProfileByUserId($userId);
        $profile->update(['avatar' => 'storage/' . $request->file('avatar')->store('profile/avatar')]);
        return $profile;
    }

    public function editUserPassword(EditUserPasswordRequest $request, int $userId) : array
    {
        $user = $this->findUserById($userId);
        $message = [];

        if (Hash::check($request->validated()['password'], $user->password)) {
            return $message = ['password_error' => 'The password is the same as the current one.'];
        }

        $user->password = Hash::make($request->validated()['password']);
        $user->save();

        return $message = ['password_success' => 'Password changed successfully.'];
    }

    public function deleteUserAccount(int $userId)
    {
        $user = User::find($userId);
        $user->delete();
        $message = 'Account deleted successfully.';
        return $message;
    }
}
