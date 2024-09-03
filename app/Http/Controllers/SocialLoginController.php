<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    //Github
    function github_redirect(){
        return Socialite::driver('github')->redirect();
    }

    function github_callback(){
        $user = Socialite::driver('github')->user();

        Customer::updateOrCreate([
            'name'=>$user->getName(),
            'email'=>$user->getEmail(),
            'password'=>bcrypt('pass@123'),
            'created_at'=>Carbon::now(),
        ]);

        if (Auth::guard('customer')->attempt(['email'=>$user->getEmail(), 'password'=>'pass@123'])) {
            return redirect('/');
        }
    }

    //Google
    function google_redirect(){
        return Socialite::driver('google')->redirect();
    }

    function google_callback(){
        $user = Socialite::driver('google')->user();

        Customer::updateOrCreate([
            'name'=>$user->getName(),
            'email'=>$user->getEmail(),
            'password'=>bcrypt('pass@123'),
            'created_at'=>Carbon::now(),
        ]);

        if (Auth::guard('customer')->attempt(['email'=>$user->getEmail(), 'password'=>'pass@123'])) {
            return redirect('/');
        }
    }
}
