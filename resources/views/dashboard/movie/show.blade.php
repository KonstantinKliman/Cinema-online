@extends('layouts.dashboard')

@section('title', $movie->title)

@section('main')
    <x-header>
        {{ $movie->title }}
    </x-header>
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
                @if($persons)
                    <hr>
                    @foreach($persons as $key => $personItem)
                        <div class="d-flex flex-column w-100 mb-3">
                            <p class="m-0"><strong>{{ ucfirst($key) . 's:'}}</strong></p>
                            @foreach($personItem as $person)
                                <a class="link"
                                   href="{{ route('person-page', ['person' => $person->slug]) }}"> {{ $person->full_name }}</a>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </x-container>
@endsection
