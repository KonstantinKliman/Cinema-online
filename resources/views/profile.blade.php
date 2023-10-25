@extends('layouts.main')

@section('title', 'Profile')

@section('main')
    <div class="row my-3">
        <div class="col d-flex align-items-center justify-content-center">
            <h1 class="text-center">
                {{ $user->name }} profile page
            </h1>
            @if(auth()->user()->id === $user->id)

            @endif
        </div>
    </div>
    <div class="row my-3">
        <div class="col-2">
            @if($user->profile_photo_path === null)
                <img src="{{ asset('assets/img/img-profile.png') }}" alt="no-img-profile" class="img-fluid rounded-circle">
            @else
                <img src="{{ asset($user->profile_photo_path) }}" alt="img-profile" class="img-fluid rounded-circle">
            @endif
        </div>
        <div class="col-10 text-start">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Country:</strong> {{ $user->country }}</p>
            <p><strong>City:</strong> {{ $user->city }}</p>
        </div>
    </div>
@endsection
