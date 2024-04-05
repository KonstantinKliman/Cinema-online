@extends('layouts.main')

@section('title', $person->full_name)

@section('main')
    <x-container>
        <x-header>{{ $person->full_name }}</x-header>
        <p class="form-text text-center ">
            @foreach($roles as $role)
                {{ ucfirst($role)}}@if(!$loop->last)
                    ,
                @endif
            @endforeach
        </p>
    </x-container>
    <div class="row my-3">
        @foreach($movies as $movie)
            <div class="col-2 my-3">
                @component('components.movie-card', ['movie' => $movie])
                @endcomponent
            </div>
        @endforeach
    </div>
@endsection
