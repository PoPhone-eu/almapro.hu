@extends('layouts.backend')

@section('maincontent')
    <!-- BEGIN: Mobile Menu -->
    @include('layouts.partials.mobile-menu')
    <!-- END: Mobile Menu -->
    <!-- BEGIN: Top Bar -->
    @include('layouts.partials.top-bar')
    <!-- END: Top Bar -->

    <div class="flex overflow-hidden">

        <!-- BEGIN: Side Menu -->
        @include('layouts.partials.side-menu')
        <!-- END: Side Menu -->

        <!-- BEGIN: Content -->
        <div class="content">
            @yield('content')

            {{ isset($slot) ? $slot : '' }}
        </div>
        <!-- END: Content -->

    </div>
    {{--  @isset($slot)
        {{ $slot }}
    @endisset --}}

    @yield('footer-scripts')
@endsection
