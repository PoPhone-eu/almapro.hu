@extends('layouts.app')
@section('maincontent')
    <div class="w-full">
        <div class="title-name">
            <p>Keresés eredménye</p>
        </div>
    </div>
    <livewire:front.menus.searchresult :search="$search" />
@endsection
