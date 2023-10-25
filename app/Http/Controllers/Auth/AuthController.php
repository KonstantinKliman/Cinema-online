<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginPage()
    {
        return view('login');
    }

    public function showRegisterPage()
    {
        return view('register');
    }

    public function register(RegisterRequest $request)
    {
        User::create($request->validated());
        return redirect()->route('home.page');
    }

    public function login(LoginRequest $request)
    {
        $isRememberMe = (bool)$request->remember_me;
        if (Auth::attempt($request->validated(), $isRememberMe)) {
            return redirect()->route('home.page');
        }

        return redirect()->back()->withErrors(['auth_error' => 'Incorrect credentials']);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home.page');
    }
}