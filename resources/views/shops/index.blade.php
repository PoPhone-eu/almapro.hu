@extends('layouts.app')

@section('maincontent')
    <livewire:front.menus.profilmenu />
    <div class="profile-content"> <livewire:company.shops.shops-table /></div>
@endsection
