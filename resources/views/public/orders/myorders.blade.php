@extends('layouts.app')

@section('maincontent')
    {{--   @include('public.profile.profilemenu') --}}
    <livewire:front.menus.profilmenu />
    <div class="profile-content">
        <livewire:front.menus.myorders-table />
    </div>


    <script>
        document.addEventListener("livewire:navigated", () => {
            Livewire.on('reloadit', () => {
                Livewire.dispatch('changeit');
            });
        })
    </script>
@endsection
