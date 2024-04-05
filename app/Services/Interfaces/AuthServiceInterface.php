<?php


namespace App\Services\Interfaces;


use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

interface AuthServiceInterface
{
    public function register(RegisterRequest $request): User;
    public function login(array $credentials, bool $isRememberMe);
    public function logout();
    public function verifyEmail(EmailVerificationRequest $request);
    public function resendVerificationLink(Request $request);
}
