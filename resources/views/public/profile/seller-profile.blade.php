@extends('layouts.app')

@section('maincontent')
    {{--  <livewire:front.menus.profilmenu /> --}}
    <livewire:front.menus.seller-profile :seller_id="$seller_id" />
@endsection
