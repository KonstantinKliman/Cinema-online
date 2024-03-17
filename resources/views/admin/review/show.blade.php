@extends('layouts.admin')

@section('title', $review->user->name . '`s review on ' . $review->movie->title)

@section('main')
    <x-header>
        {{ $review->user->name . '`s review on ' }} <a href="{{ route('admin-movie.page', ['movie_id' => $review->movie->id]) }}" class="link text-light m-0">{{ $review->movie->title }}</a>
    </x-header>
    <div class="row d-flex justify-content-center w-100">
        <div class="col-2 d-flex justify-content-center">
            <form action="{{ route('publish-review.action', ['review_id' => $review->id]) }}" method="post">
                @csrf
                @if($review->is_published)
                    <button type="submit" class="btn btn-outline-light me-1">Hide</button>
                @else
                    <button type="submit" class="btn btn-outline-light me-1">Publish</button>
                @endif
            </form>
            <a href="{{ route('admin-edit-review.page', ['review_id' => $review->id]) }}" class="btn btn-outline-success me-1">Edit</a>
                <form action="{{ route('delete-review.action', ['review_id' => $review->id]) }}" method="post">
                    @csrf
                    @method("DELETE")
                    <button class="btn btn-outline-danger" type="submit">Delete</button>
                </form>
        </div>
    </div>
    <div class="row border rounded-3 p-3 mx-1 my-3 @switch($review->type) @case('positive')positive-review-bg @break @case('negative')negative-review-bg @break @case('neutral')neutral-review-bg @break @endswitch">
        <div class="col-1">
            <img src="{{ asset($review->user->profile->avatar) }}" alt="" class="img-fluid rounded-circle">
        </div>
        <div class="col-11 d-flex flex-column">
            <h3>{{ $review->user->profile->first_name . ' ' . $review->user->profile->last_name }}</h3>
            <h5>{{ $review->title }}</h5>
            <p>{{ $review->review }}</p>
        </div>
    </div>
@endsection
