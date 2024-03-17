@extends('layouts.main')

@section('title', 'Search')

@section('main')
    <div class="row my-3">
        <div class="col-2"></div>
        <div class="col-8">
            <form method="get" action="{{ route('movie.search') }}">
                <div class="d-flex justify-content-center">
                    <input class="form-control me-2 w-25" placeholder="Search" aria-label="Search" name="query">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="bi bi-search"></i>
                        Search
                    </button>
                </div>
            </form>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row my-3">
        @if(!$movies->isEmpty())
            <x-header>Search results</x-header>
            @foreach($movies as $movie)
                <div class="col-2 my-3">
                    @component('components.movie-card', ['movie' => $movie])
                    @endcomponent
                </div>
            @endforeach
        @else
            <div class="col vh-100 d-flex justify-content-center align-items-center">
                <x-header>Sorry, but nothing was found</x-header>
            </div>
        @endif
    </div>
@endsection
