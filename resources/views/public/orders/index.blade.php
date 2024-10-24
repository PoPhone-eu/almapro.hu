@extends('layouts.app')

@section('maincontent')
    <livewire:front.menus.profilmenu />
    <div class="profile-content">
        <livewire:front.menus.customer-orders-table />
    </div>


    <script>
        document.addEventListener("livewire:navigated", () => {
            Livewire.on('reloadit', () => {
                Livewire.dispatch('changeit');
            });
        })
    </script>
@endsection
