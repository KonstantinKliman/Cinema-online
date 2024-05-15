@extends('layouts.dashboard')

@section('title', 'Your reviews')

@section('main')
    <h3 class="text-center mb-3">Your reviews</h3>
    @foreach($reviews as $review)
        <div
            class="row border rounded-3 p-3 mx-1 my-3 @switch($review->type->id) @case(\App\Enums\ReviewType::positive->value)positive-review-bg @break @case(\App\Enums\ReviewType::negative->value)negative-review-bg @break @case(\App\Enums\ReviewType::neutral->value)neutral-review-bg @break @endswitch">
            <div class="col-12 d-flex flex-column">
                <h3>{{ $review->title }} @if(!$review->is_published)<span class="badge text-bg-secondary">Not pubished</span>@endif</h3>
                <h5>Movie: <a class="link" href="{{ $review->movie->id }}">{{ $review->movie->title }}</a></h5>
                <p>{{ $review->review }}</p>
            </div>
        </div>
    @endforeach
@endsection
