<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function showHomePage()
    {
        return view('home');
    }
}
