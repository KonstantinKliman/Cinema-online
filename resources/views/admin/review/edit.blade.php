@extends('layouts.admin')

@section('title', 'Edit ' . $review->user->name . '`s review on ' . $review->movie->title)

@section('main')
    <div class="row">
        <div class="col d-flex align-items-center flex-column">
            <h1 class="my-3">Edit {{ $review->user->name }} review on {{ $review->movie->title }} </h1>
        </div>
    </div>
    <div class="d-flex flex-column">
        <x-container class="w-50">
            <form action="{{ route('admin.review.update', ['review_id' => $review->id]) }}" method="post">
                @csrf
                @method("PUT")
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Type</label>
                    <select name="type" class="form-select">
                        <option disabled selected>Select the type of review</option>
                        @foreach($review->getReviewType() as $reviewValue => $reviewType)
                            <option value="{{ $reviewValue }}" {{ $review->type == $reviewValue ? 'selected' : '' }}>{{ ucfirst($reviewType) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                           aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="title" value="{{ old('title', $review->title) }}">
                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Review</span>
                    <textarea class="form-control @error('review') is-invalid @enderror" aria-label="With textarea"
                              name="review">{{ old('review', $review->review) }}</textarea>
                    @error('review')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" name="is_published" type="checkbox" id="flexSwitchCheckDefault" {{ $review->is_published ? 'checked' : '' }}>
                    <label class="form-check-label" for="flexSwitchCheckDefault">Published</label>
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-light fw-medium mx-3">Edit</button>
                </div>
            </form>
            @if(session('create_genre_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('create_genre_success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('create_genre_error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('create_genre_error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </x-container>
    </div>
@endsection
