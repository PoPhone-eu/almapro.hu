@extends('layouts.app')

@section('maincontent')
    @include('public.profile.profilemenu')

    <div class="profile-content"><livewire:messages.sellers.edit-message :message_id="$message_id" /></div>
@endsection
