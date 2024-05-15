@extends('layouts.dashboard')

@section('title', 'Cinema-online person')

@section('main')
    <div class="row">
        <div class="col">
            <h3 class="mb-3 text-center">
                Persons
            </h3>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col d-flex justify-content-center align-items-center mb-3">
            <a href="{{ route('dashboard.person.showAttachForm') }}">
                <button class="btn btn-outline-light me-1">
                    Attach person to movie
                </button>
            </a>
            <a href="{{ route('dashboard.person.create') }}">
                <button class="btn btn-outline-light me-1">
                    Add person
                </button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="accordion accordion-flush border" id="accordionFlushExample">
                @foreach($persons as $index => $person)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-{{ $index }}" aria-expanded="false"
                                    aria-controls="panelsStayOpen-{{ $index }}">
                                {{ $index + 1 . '. ' . ucwords("$person->full_name")}}
                            </button>
                        </h2>
                        <div id="panelsStayOpen-{{ $index }}" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12 col-lg-11 d-flex align-items-center">
                                        <div class="d-flex flex-row">
                                            @if(empty($person->movies->toArray()))
                                                <p class="mb-0">Empty </p>
                                            @else
                                                <p class="mb-0">Movies(role/roles): </p>
                                                @foreach($person->movies->unique() as $movie)
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <a href="{{ route('dashboard.movie.show', ['movie_id' => $movie->id]) }}"
                                                               class="link">
                                                                {{ $movie->title }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-1 d-flex justify-content-center justify-content-lg-end">
                                        <a href="{{ route('dashboard.person.edit', ['person' => $person->slug]) }}"
                                           class="me-1">
                                            <button class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </a>
                                        <form
                                            action="{{ route('dashboard.person.delete', ['person' => $person->slug]) }}"
                                            method="post">
                                            @csrf
                                            @method("DELETE")
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
