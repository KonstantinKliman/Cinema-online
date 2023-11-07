<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Profile;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

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
        $user = $this->authService->register($request);
        return redirect()->route('home.page');
    }

    public function login(LoginRequest $request)
    {
        $isRememberMe = (bool)$request->remember_me;
        if ($this->authService->login($request->validated(), $isRememberMe)) {
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
