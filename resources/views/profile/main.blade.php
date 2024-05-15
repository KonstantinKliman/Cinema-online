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
        <div class="col-lg-2 col-12 d-flex justify-content-center d-lg-block">
            <img class="img-fluid rounded-circle" src="{{ asset($profile->avatar) }}" alt="profileAvatarImg">
        </div>
        <div class="col-lg-10 col-12 d-flex flex-column mt-lg-0 mt-3">
            <p><strong>First name:</strong> {{ $profile->first_name }}</p>
            <p><strong>Last name:</strong> {{ $profile->last_name }}</p>
            <p><strong>Date of birth:</strong> {{ $profile->date_of_birth }} ({{ \Carbon\Carbon::createFromDate($profile->date_of_birth)->age }} years)</p>
            <p><strong>Country:</strong> {{ $profile->country }}</p>
            <p><strong>City:</strong> {{ $profile->city }}</p>
            <p><strong>Information about yourself:</strong> {{ $profile->description }}</p>
        </div>
    </x-container>
    <div class="row">
        <div class="col d-flex justify-content-center align-items-center">
            <h1>User reviews</h1>
        </div>
    </div>
    @foreach($profile->user->reviews as $review)
        @if($review->is_published)
            <div class="row border rounded-3 p-3 mx-1 my-3 @switch($review->type_id) @case(\App\Enums\ReviewType::positive->value)positive-review-bg @break @case(\App\Enums\ReviewType::negative->value)negative-review-bg @break @case(\App\Enums\ReviewType::neutral->value)neutral-review-bg @break @endswitch">
                <div class="col-lg-2 col-12">
                    <img src="{{ asset($review->movie->poster_file_path) }}" alt="" class="img-fluid">
                </div>
                <div class="col-lg-10 col-12 d-flex flex-column mt-lg-0 mt-3">
                    <h5><a class="link" href="{{ route('movie.page', ['movie_id' => $review->movie->id]) }}">{{ $review->title }}</a></h5>
                    <p>{{ $review->review }}</p>
                </div>
            </div>
        @endif
    @endforeach
@endsection
