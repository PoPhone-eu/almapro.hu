@extends('layouts.app')

@section('maincontent')
    <form method="POST" action="{{ route('register') }}">
        @csrf


        <div>
            <select name="role" class="form-select mt-2 sm:mr-2 border-warning" required>
                {{--   <option value="person" selected>{{ __('I register as a visitor') }}</option> --}}
                <option value="private" selected>{{ __('I register as a private person') }}</option>
                <option value="company">{{ __('I register as a merchant') }}</option>
            </select>
        </div>

        <div>
            <x-label for="name" value="{{ __('Family Name') }}*" />
            <x-input id="name" class="block mt-1 w-full border-danger" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name" />
        </div>

        <div>
            <x-label for="given_name" value="{{ __('Given Name') }}*" />
            <x-input id="given_name" class="block mt-1 w-full border-danger" type="text" name="given_name"
                :value="old('given_name')" required autofocus autocomplete="name" />
        </div>

        <div class="mt-4">
            <x-label for="email" value="{{ __('Email') }}*" />
            <x-input id="email" class="block mt-1 w-full border-danger" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
        </div>

        <div class="mt-4">
            <x-label for="email" value="Város*" />
            <x-input id="invoice_city" class="block mt-1 w-full border-danger" type="text" name="invoice_city"
                :value="old('invoice_city')" required />
        </div>

        <div class="mt-4">
            <x-label for="password" value="{{ __('Password') }}*" />
            <x-input id="password" class="block mt-1 w-full border-danger" type="password" name="password" required
                autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}*" />
            <x-input id="password_confirmation" class="block mt-1 w-full border-danger" type="password"
                name="password_confirmation" required autocomplete="new-password" />
        </div>

        {{-- @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' =>
                                        '<a target="_blank" href="' .
                                        route('terms.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Terms of Service') .
                                        '</a>',
                                    'privacy_policy' =>
                                        '<a target="_blank" href="' .
                                        route('policy.show') .
                                        '" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">' .
                                        __('Privacy Policy') .
                                        '</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif --}}

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}" wire:navigate>
                {{ __('Already registered?') }}
            </a>

            <x-button class="ml-4 base-button">
                {{ __('Register') }}
            </x-button>
        </div>
    </form>
@endsection
