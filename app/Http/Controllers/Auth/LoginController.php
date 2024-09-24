<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->avatar = $data->avatar;
            $user->save();
        } else {
            $user->updated_at = now();
            $user->save();
        }
        Auth::login($user);
    }

    //Facebook Login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    //facebook callback
    public function handleFacebookCallback()
    {

        $user = Socialite::driver('facebook')->stateless()->user();

        $this->_registerorLoginUser($user);
        return redirect()->route('home');
    }
}
