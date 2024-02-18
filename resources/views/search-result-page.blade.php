@extends('layouts.main')

@section('title', 'Search')

@section('main')
    @if(!$movies->isEmpty())
        <x-header>Search results for : <strong>{{ $request_query }}</strong></x-header>
        <div class="row my-3">
            @foreach($movies as $movie)
                <div class="col-2 my-3">
                    @component('components.movie-card', ['movie' => $movie])
                    @endcomponent
                </div>
            @endforeach
        </div>
    @else
        <x-header>Sorry, but nothing was found for : <strong>{{ $request_query }}</strong></x-header>
    @endif

@endsection
