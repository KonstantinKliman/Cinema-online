@extends('layouts.main')

@section('title', 'Profile')

@section('main')
    <div class="row my-3">
        <div class="col d-flex align-items-center justify-content-center">
            <h1 class="text-center">
                {{ $profile->user->name }} profile page
            </h1>
        </div>
    </div>
    <x-container>
        <div class="col-2">
            @if($profile->avatar === null)
                <img src="{{ asset('assets/img/img-profile.png') }}" alt="no-img-profile" class="img-fluid rounded-circle">
            @else
                <img src="{{ asset($profile->avatar) }}" alt="img-profile" class="img-fluid rounded-circle">
            @endif
        </div>
        <div class="col-10 text-start">
            <p><strong>Username:</strong> {{ $profile->user->name }}</p>
            <p><strong>First name:</strong> {{ $profile->first_name }}</p>
            <p><strong>Last name:</strong> {{ $profile->last_name }}</p>
            <p><strong>Country:</strong> {{ $profile->country }}</p>
            <p><strong>City:</strong> {{ $profile->city }}</p>
            <p><strong>Information about yourself:</strong> {{ $profile->description }}</p>
        </div>
    </x-container>
@endsection
