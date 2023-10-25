<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\User;

class PagesController extends Controller
{
    public function showHomePage()
    {
        return view('home');
    }

    public function showProfilePage($userId)
    {
        $user = User::find($userId);
        return view('profile', ['user' => $user]);
    }

}
