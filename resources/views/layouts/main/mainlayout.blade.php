<!-- Design from figma: https://www.figma.com/file/B0gfROr9XjaNOPllEHFKEA/AlmaPro?node-id=99%3A88&mode=dev -->
<div class="main-container">
    @include('layouts.main.top-section')
    <main>
        {{--  if route is not welcome: --}}
        {{-- @if (Route::current()->uri != '/') --}}
        @livewire('front.banner-section')
        {{--  @endif --}}

        @yield('maincontent')
    </main>
</div>
@include('layouts.main.footer-section')
