<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\UserInfo;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'given_name' => ['required', 'string', 'max:255'],
            'role' => ['required',],
            'invoice_city' => ['required',],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();
        //Log::info($input);
        $user = User::create([
            'name' => $input['name'],
            'given_name' => $input['given_name'],
            'full_name' => $input['name'] . ' ' . $input['given_name'],
            'role' => $input['role'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
        // UserInfo->invoice_city
        UserInfo::create([
            'invoice_city' => $input['invoice_city'],
            'user_id' => $user->id,
        ]);
        return $user;
    }
}
