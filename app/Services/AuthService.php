<?php


namespace App\Services;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(RegisterRequest $request): User
    {
        $user = User::create($request->validated());

        $profile = new Profile(['user_id' => $user->id]);
        $profile->save();

        return $user;
    }

    public function login(array $credentials, bool $isRememberMe = false)
    {
        return Auth::attempt($credentials, $isRememberMe);
    }

}
