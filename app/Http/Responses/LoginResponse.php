<?php

namespace App\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{

    public function toResponse($request)
    {

        // below is the existing response
        // replace this with your own code
        // the user can be located with Auth facade

        /*  return $request->wantsJson()
            ? response()->json(['two_factor' => false])
            : redirect()->intended(config('fortify.home')); */

        if (Auth::user()->role == 'admin') {
            return redirect(url('admindash'));
        } else {
            $prev_url = session()->get('url.intended');
            if ($prev_url) {
                return redirect($prev_url);
            }
            return redirect(url('/profiledata'));
        }
    }
}
