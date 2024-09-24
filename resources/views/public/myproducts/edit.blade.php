@extends('layouts.app')
@section('maincontent')
    <livewire:front.menus.profilmenu />

    <div class="profile-content">
        <livewire:front.products.edit-product :product_id="$product_id" />
    </div>
@endsection
