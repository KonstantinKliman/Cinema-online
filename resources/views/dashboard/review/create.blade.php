@extends('layouts.dashboard')

@section('title', 'Create new review')

@section('main')
    <h1 class="text-center my-3">Create new review</h1>
    <div class="row border rounded-3 p-3 mx-1 my-3 bg-light-subtle">
        <form action="{{ route('dashboard.review.store') }}" method="post">
            @csrf
            <div class="col d-flex flex-column">
                <select name="movie_id" class="form-select mb-1">
                    <option value="" disabled selected>Select movie</option>
                    @foreach($movies as $movie)
                        <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                    @endforeach
                </select>
                <select name="type_id" class="form-select mb-1">
                    <option value="" disabled selected>Select the type of review</option>
                    <option value="1">Positive</option>
                    <option value="2">Neutral</option>
                    <option value="3">Negative</option>
                </select>
                <input name="title" class="form-control mb-1" type="text" placeholder="Title">
                <textarea name="review" class="form-control mb-1" cols="30" rows="10" placeholder="Review"></textarea>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault"
                           name="is_published">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Published</label>
                </div>
                <button class="btn btn-outline-light my-1" type="submit">Submit</button>
            </div>
        </form>
    </div>
@endsection
