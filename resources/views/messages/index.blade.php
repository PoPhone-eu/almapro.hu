@extends('layouts.app')

@section('maincontent')
    <livewire:front.menus.profilmenu />

    @include('messages.partials.index-css')

    <div class="profile-content"><livewire:messages.sellers.messages-table /></div>
@endsection
