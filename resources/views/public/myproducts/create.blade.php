@extends('layouts.app')
@section('maincontent')
    <livewire:front.menus.profilmenu />

    <div class="profile-content">
        <livewire:front.products.create-product :attr_type="$attr_type" :category_id="$category_id" :subcategory_id="$subcategory_id" />
    </div>
@endsection
