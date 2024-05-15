@extends('layouts.main')

@section('title', 'Search')

@section('main')
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
