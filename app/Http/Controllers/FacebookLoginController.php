<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class FacebookLoginController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->stateless()->user();
        $user = User::where('email', $facebookUser->email)->first();
        if (!$user) {
            return redirect()->route('register');
            // $user = User::create(['name' => $facebookUser->name, 'email' => $facebookUser->email, 'password' => \Hash::make(rand(100000, 999999))]);
        }

        Auth::login($user);
        if (Auth::user()->role == 'admin') return redirect(url('admindash'));
        return redirect(url('/'));
    }
}
