@extends('layouts.main')

@section('title', ucfirst($genre->name)   )

@section('main')
    <h1 class="text-start mt-3">{{ ucfirst($genre->name) }}</h1>
    <div class="form-text">
        <p>{{ $genre->description }}</p>
    </div>
    <div class="row my-3">
        @foreach($movies as $movie)
            <div class="col-2 my-3">
                @component('components.movie-card', ['movie' => $movie])
                @endcomponent
            </div>
        @endforeach
    </div>
@endsection
