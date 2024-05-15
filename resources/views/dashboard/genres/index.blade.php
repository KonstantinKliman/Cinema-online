@extends('layouts.dashboard')

@section('title', 'Cinema-online genres')

@section('main')
    <div class="row">
        <div class="col">
            <h3 class="mb-3 text-center">
                Genres
            </h3>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col d-flex justify-content-center align-items-center mb-3">
            <a href="{{ route('dashboard.genre.create') }}">
                <button class="btn btn-outline-light">
                    Add genre
                </button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="accordion accordion-flush border" id="accordionFlushExample">
                @foreach($genres as $index => $genre)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-{{ $index }}" aria-expanded="false" aria-controls="panelsStayOpen-{{ $index }}">
                                {{ $index + 1 . '. ' . ucwords("$genre->name")}}
                            </button>
                        </h2>
                        <div id="panelsStayOpen-{{ $index }}" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12 col-lg-11 d-flex align-items-center">
                                        <p class="mb-0">Description: {{ $genre->description }}</p>
                                    </div>
                                    <div class="col-12 col-lg-1 d-flex justify-content-center justify-content-lg-end">
                                        <a href="{{ route('dashboard.genre.edit', ['genre' => $genre->slug]) }}"
                                           class="me-1">
                                            <button class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </a>
                                        <form action="{{ route('dashboard.genre.delete', ['genre' => $genre->slug]) }}"
                                              method="post">
                                            @csrf
                                            @method("DELETE")
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
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
