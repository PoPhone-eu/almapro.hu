@extends('layouts.app')
@section('maincontent')
    {{--   @include('livewire.front.menus.partials.banners') --}}
    <livewire:front.menus.maincategory :product_type="$product_type" />
@endsection
