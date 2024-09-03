<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    function admin_panel(){
        return view('backend.dashboard');
    }

    function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
