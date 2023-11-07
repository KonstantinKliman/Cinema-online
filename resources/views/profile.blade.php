@extends('layouts.main')

@section('title', 'Profile')

@section('main')
    <div class="row my-3">
        <div class="col d-flex align-items-center justify-content-center">
            <h1 class="text-center">
                {{ $user->name }} profile page
            </h1>
        </div>
    </div>
    <div class="row my-3">
        <div class="col-2">
            @if($user->profile->avatar === null)
                <img src="{{ asset('assets/img/img-profile.png') }}" alt="no-img-profile" class="img-fluid rounded-circle">
            @else
                <img src="{{ asset($user->profile->avatar) }}" alt="img-profile" class="img-fluid rounded-circle">
            @endif
        </div>
        <div class="col-10 text-start">
            <p><strong>Username:</strong> {{ $user->name }}</p>
            <p><strong>First name:</strong> {{ $user->profile->first_name }}</p>
            <p><strong>Last name:</strong> {{ $user->profile->last_name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Country:</strong> {{ $user->profile->country }}</p>
            <p><strong>City:</strong> {{ $user->profile->city }}</p>
            <p><strong>Information about yourself:</strong> {{ $user->profile->description }}</p>
        </div>
    </div>
@endsection
