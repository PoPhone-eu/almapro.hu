@extends('layouts.app')

@section('maincontent')
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
    </div>
@endsection
