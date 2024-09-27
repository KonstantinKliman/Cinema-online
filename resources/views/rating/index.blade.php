@extends('layouts.dashboard')

@section('title', 'Your reviews')

@section('main')
    <h3 class="text-center mb-3">Your ratings</h3>
    @foreach($ratings as $rating)
        <div class="card mb-3">
            <div class="card-body bg-light-subtle d-flex align-items-center justify-content-between">
                <a class="link" href="{{ route('movie.page', ['movie_id' => $rating->movie->id]) }}">{{ $rating->movie->title }}</a>
                <p class="mb-0">Rating: {{ $rating->user_rating }}</p>
            </div>
        </div>
    @endforeach
@endsection
