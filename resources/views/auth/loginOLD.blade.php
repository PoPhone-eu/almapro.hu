<x-guest-layout>
    <style>
        .btn-google,
        .btn-fb {
            display: inline-block;
            border-radius: 1px;
            text-decoration: none;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.25);
            transition: background-color 0.218s, border-color 0.218s, box-shadow 0.218s;
        }

        .btn-google .google-content,
        .btn-google .fb-content,
        .btn-fb .google-content,
        .btn-fb .fb-content {
            display: flex;
            align-items: center;
            width: 300px;
            height: 50px;
        }

        .btn-google .google-content .logo,
        .btn-google .fb-content .logo,
        .btn-fb .google-content .logo,
        .btn-fb .fb-content .logo {
            padding: 15px;
            height: inherit;
        }

        .btn-google .google-content svg,
        .btn-google .fb-content svg,
        .btn-fb .google-content svg,
        .btn-fb .fb-content svg {
            width: 18px;
            height: 18px;
        }

        .btn-google .google-content p,
        .btn-google .fb-content p,
        .btn-fb .google-content p,
        .btn-fb .fb-content p {
            width: 100%;
            line-height: 1;
            letter-spacing: 0.21px;
            text-align: center;
            font-weight: 500;
            font-family: "Roboto", sans-serif;
        }

        .btn-google {
            background: #FFF;
        }

        .btn-google:hover {
            box-shadow: 0 0 3px 3px rgba(66, 133, 244, 0.3);
        }

        .btn-google:active {
            background-color: #eee;
        }

        .btn-google .google-content p {
            color: #757575;
        }

        .btn-fb {
            padding-top: 1.5px;
            background: #4267b2;
            background-color: #3b5998;
        }

        .btn-fb:hover {
            box-shadow: 0 0 3px 3px rgba(59, 89, 152, 0.3);
        }

        .btn-fb .fb-content p {
            color: rgba(255, 255, 255, 0.87);
        }
    </style>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                    autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('messages.rememberme') }}</span>
                </label>
            </div>

            <div class="block mt-4">
                <x-button class="ml-4">
                    {{ __('Login') }}
                </x-button>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('passwords.forgotyourpassword') }}
                    </a>
                @endif



            </div>

            <div class="col-md-6 offset-md-3">
                <a role="button" href="{{ route('google.redirect') }}" class="btn-google mt-4">
                    <div class="google-content">
                        <div class="logo">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                viewBox="0 0 48 48">
                                <defs>
                                    <path id="a"
                                        d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z" />
                                </defs>
                                <clipPath id="b">
                                    <use xlink:href="#a" overflow="visible" />
                                </clipPath>
                                <path clip-path="url(#b)" fill="#FBBC05" d="M0 37V11l17 13z" />
                                <path clip-path="url(#b)" fill="#EA4335" d="M0 11l17 13 7-6.1L48 14V0H0z" />
                                <path clip-path="url(#b)" fill="#34A853" d="M0 37l30-23 7.9 1L48 0v48H0z" />
                                <path clip-path="url(#b)" fill="#4285F4" d="M48 48L17 24l-4-3 35-10z" />
                            </svg>
                        </div>
                        <p>Google belépés</p>
                    </div>
                </a>
                <a href="{{ route('facebook.redirect') }}" class="btn-fb">
                    <div class="fb-content">
                        <div class="logo">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                                version="1">
                                <path fill="#FFFFFF"
                                    d="M32 30a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h28a2 2 0 0 1 2 2v28z" />
                                <path fill="#4267b2"
                                    d="M22 32V20h4l1-5h-5v-2c0-2 1.002-3 3-3h2V5h-4c-3.675 0-6 2.881-6 7v3h-4v5h4v12h5z" />
                            </svg>
                        </div>
                        <p>Facebook belépés</p>
                    </div>
                </a>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
