<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{

    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginPage(): View
    {
        return view('auth.login');
    }

    public function showRegisterPage(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $this->authService->register($request);
        return redirect()->route('home.page');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $isRememberMe = (bool)$request->remember_me;
        if ($this->authService->login($request->validated(), $isRememberMe)) {
            return redirect()->route('home.page');
        }
        return redirect()->back()->withErrors(['auth_error' => 'Incorrect credentials']);
    }

    public function logout(): RedirectResponse
    {
        $this->authService->logout();
        return redirect()->route('home.page');
    }

    public function verifyEmailPage(): View
    {
        return view('auth.verify-email');
    }

    public function verifyEmail(EmailVerificationRequest $request): RedirectResponse
    {
        $this->authService->verifyEmail($request);
        return redirect()->route('home.page');
    }

    public function resendVerificationLink(Request $request): RedirectResponse
    {
        $this->authService->resendVerificationLink($request);
        return back()->with('message', 'Verification link sent!');
    }
}
