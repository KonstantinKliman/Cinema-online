<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ProfileService;

class PagesController extends Controller
{
    public function showHomePage()
    {
        return view('home');
    }
}
