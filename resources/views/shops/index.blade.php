@extends('layouts.app')

@section('maincontent')
    @include('public.profile.profilemenu')
    <div class="profile-content"> <livewire:company.shops.shops-table /></div>
@endsection
