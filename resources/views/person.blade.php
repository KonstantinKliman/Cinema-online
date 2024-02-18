@extends('layouts.main')

@section('title', $person->full_name )

@push('styles')
    <style>
        .card {
            position: relative;
            overflow: hidden;
        }

        .card-img {
            transition: filter 1s ease-in-out;
        }

        .card:hover .card-img {
            filter: brightness(70%);
        }

        .card-img-overlay {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            backdrop-filter: blur(10px);
            background-color: rgba(0, 0, 0, 0.5);
        }

        .card:hover .card-img-overlay {
            opacity: 1;
        }

        .card-info {
            flex-grow: 1;
        }

        .btn-watch-now {
            margin-top: 1rem;
        }
    </style>
@endpush


@section('main')
    <x-container>
        <x-header>{{ $person->full_name }}</x-header>
        <p class="form-text text-center ">@foreach($roles as $role) {{ ucfirst($role)}}@if(!$loop->last),@endif @endforeach</p>
        <p> {{ ucfirst($person->description) }}</p>
    </x-container>
    <div class="row my-3">
        @foreach($movies as $movie)
            @component('components.movie-card', ['movie' => $movie])
            @endcomponent
        @endforeach
    </div>
@endsection
