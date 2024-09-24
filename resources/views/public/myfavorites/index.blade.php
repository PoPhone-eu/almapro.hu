@extends('layouts.app')
@section('maincontent')
    <livewire:front.menus.profilmenu />

    <div class="product-page-content" style="z-index: 1000">

        <livewire:front.myfavorites.favorites-table />

    </div>
@endsection
