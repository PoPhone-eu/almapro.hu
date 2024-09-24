@extends('layouts.app')

@section('maincontent')
    <div class="mb-4 text-sm text-gray-600">
        Elfelejtette a jelszavát? Csak adja meg e-mail címét, és e-mailben küldünk egy jelszó-visszaállítási linket, amely
        lehetővé teszi, hogy újat jelszavat állítson be.
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <x-validation-errors class="mb-4" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="block">
            <x-label for="email" value="{{ __('Email') }}" />
            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-button class="save-button">
                Jelszó-visszaállítási email kérése
            </x-button>
        </div>
    </form>
@endsection
