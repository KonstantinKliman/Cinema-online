@extends('layouts.main')

@section('title', $movie->title)

@section('main')
    <x-container>
        <div class="row">
            <div class="col-2 d-flex justify-content-start">
                <img src="{{ asset($movie->poster_file_path) }}" alt="" class="img-fluid rounded-3"
                     style="width: 300px; height: 400px">
            </div>
            <div class="col-10 text-start">
                <p><strong>Title</strong> : {{ $movie->title }}</p>
                <p><strong>Year</strong> : {{ $movie->release_year }}</p>
                <p><strong>Production studio</strong> : {{ $movie->production_studio }}</p>
                <p><strong>Country</strong> : {{ $movie->country }}</p>
                <p>
                    <strong>Genre</strong> :
                    @foreach($movie->genres as $genre)
                        <a href="{{ route('genre.page', ['genre' => $genre->slug]) }}"
                           class="link">
                            {{ ucfirst($genre->name) }}</a>
                        @if(!$loop->last)
                            ,
                        @endif
                    @endforeach
                </p>
                <p class="text-break"><strong>Description</strong> : {{ $movie->description }}</p>
                <p><strong>Cinema-online rating</strong> : {{ $movie->rating }}</p>
            </div>
        </div>
    </x-container>
    <div class="accordion mx-1 mb-3" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header bg-light-subtle">
                <button class="accordion-button bg-light-subtle text-light" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Watch online {{ $movie->title }}
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body d-flex justify-content-center">
                    <video class="object-fit-fill" controls>
                        <source src="{{ route('movie.stream', ['movie_id' => $movie->id]) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
    <x-header>
        {{__('Your rating')}}
    </x-header>
    <div class="row d-flex justify-content-center border rounded-3 p-3 mx-1 my-3 bg-light-subtle">
        <div class="col d-flex justify-content-center align-content-center">
            <form action="{{ route('createRating.action', ['movie_id' => $movie->id]) }}" method="post">
                @csrf
                <div class="full-stars d-flex flex-column">
                    <div class="rating-group mb-3">
                        <input name="rating" value="0" type="radio" disabled checked />
                        @for($i = 1; $i < 6; $i++)
                            <label for="rating-{{ $i }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M259.3 17.8L194 150.2 47.9 171.5c-26.2 3.8-36.7 36.1-17.7 54.6l105.7 103-25 145.5c-4.5 26.3 23.2 46 46.4 33.7L288 439.6l130.7 68.7c23.2 12.2 50.9-7.4 46.4-33.7l-25-145.5 105.7-103c19-18.5 8.5-50.8-17.7-54.6L382 150.2 316.7 17.8c-11.7-23.6-45.6-23.9-57.4 0z"/></svg>
                            </label>
                            <input name="rating" id="rating-{{ $i }}" value="{{ $i }}" type="radio" {{ $rating == $i ? 'checked' : '' }}/>
                        @endfor
                    </div>
                    <button type="submit" class="btn btn-outline-light">Rate movie</button>
                </div>
            </form>
        </div>
    </div>
    <x-header>
        {{__('User reviews')}}
    </x-header>
    @foreach($movie->reviews as $review)
        @if($review->is_published)
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
        @endif
    @endforeach
    <x-header>
        {{__('Write a review')}}
    </x-header>
    <div class="row border rounded-3 p-3 mx-1 my-3 bg-light-subtle">
        <form action="{{ route('createReview.action', ['movie_id' => $movie->id]) }}" method="post">
            @csrf
            <div class="col d-flex flex-column">
                <select name="type" class="form-select mb-1">
                    <option value="" disabled selected>Select the type of review</option>
                    <option value="0">Positive</option>
                    <option value="1">Neutral</option>
                    <option value="2">Negative</option>
                </select>
                <input name="title" class="form-control mb-1" type="text" placeholder="Title">
                <textarea name="review" class="form-control mb-1" cols="30" rows="10" placeholder="Review"></textarea>
                <button class="btn btn-outline-light my-1" type="submit">Create</button>
            </div>
        </form>
    </div>
@endsection
