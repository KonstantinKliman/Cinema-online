@extends('layouts.dashboard')

@section('title', 'Cinema-online movies')

@section('main')
    <div class="row">
        <div class="col">
            <h3 class="mb-3 text-center">
                Movies
            </h3>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col d-flex justify-content-center align-items-center mb-3">
            <a href="{{ route('dashboard.movie.create') }}">
                <button class="btn btn-outline-light">
                    Upload movie
                </button>
            </a>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="accordion accordion-flush border" id="accordionFlushExample">
                @foreach($movies as $index => $movie)
                    <div class="accordion-item">
                        <h2 class="accordion-header ">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-{{ $index }}" aria-expanded="false"
                                    aria-controls="panelsStayOpen-{{ $index }}">
                                {{ $index + 1 . '. ' . ucfirst($movie->title)}}
                                @if(!$movie->is_published)
                                    <span class="badge text-bg-secondary ms-2">Not published</span>
                                @endif
                            </button>
                        </h2>
                        <div id="panelsStayOpen-{{ $index }}" class="accordion-collapse collapse">
                            <div class="accordion-body mb-3">
                                <div class="row border-bottom">
                                    <div class="col-12 col-lg-2 d-lg-block d-flex justify-content-center mb-3 mb-lg-0">
                                        <img src="{{ asset($movie->poster_file_path) }}" class="img-fluid"
                                             alt="posterFilePath">
                                    </div>
                                    <div class="col-12 col-lg-9">
                                        <p><strong>Title:</strong> {{ $movie->title }}</p>
                                        <p><strong>Year:</strong> {{ $movie->release_year }}</p>
                                        <p><strong>Production studio:</strong> {{ $movie->production_studio }}</p>
                                        <p><strong>Country:</strong> {{ $movie->country }}</p>
                                        <p><strong>Genres:</strong>
                                            @foreach($movie->genres as $genre)
                                                <a href="{{ route('dashboard.genre.show', ['genre' => $genre->slug]) }}"
                                                   class="link">{{ ucfirst($genre->name) }}</a>
                                            @endforeach
                                        </p>
                                        <div class="d-flex flex-column">
                                            @foreach($movie->getPersons() as $role => $persons)
                                                @php
                                                    $roleId = \App\Models\PersonRole::query()->where('name', $role)->first()->id;
                                                @endphp
                                                <div class="d-inline-flex">
                                                    <p><strong>{{ "$role:" }}</strong></p>
                                                    @if(is_array($persons))
                                                        <ul class="list-inline ms-1 d-flex flex-row">
                                                            @foreach($persons as $person)
                                                                <li class="list-inline-item d-flex flex-row">
                                                                    <a class="link" href="#">
                                                                        {{ $person->full_name }}
                                                                    </a>
                                                                    <form
                                                                        action="{{ route('dashboard.person.detach', ['person' => $person->slug, 'movie_id' => $movie->id, 'role_id' => $roleId,]) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-sm btn-outline-danger p-0">
                                                                            <i class="bi bi-x"></i>
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <ul class="list-inline ms-1 d-flex flex-row">
                                                            <li class="list-inline-item d-flex flex-row">
                                                                <a class="link" href="#">
                                                                    {{ $person->full_name }}
                                                                </a>
                                                                <form
                                                                    action="{{ route('dashboard.person.detach', ['person' => $person->slug, 'movie_id' => $movie->id, 'role_id' => $roleId,]) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger p-0">
                                                                        <i class="bi bi-x"></i>
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        <p><strong>Reviews:</strong> {{ $movie->reviews->count() }}</p>
                                        <p><strong>Description:</strong> {{ $movie->description }}</p>
                                        <p><strong>Cinema-online rating:</strong> {{ $movie->rating }}</p>
                                        <p><strong>Uploaded by:</strong>
                                            <a href="{{ route('dashboard.user.show', ['user_id' => $movie->user->id]) }}"
                                               class="link text-light m-0">{{ $movie->user->name }}</a>
                                        </p>
                                    </div>
                                    <div class="col-12 col-lg-1 d-flex justify-content-center justify-content-lg-end flex-row mb-3 mb-lg-0">
                                        <form
                                            action="{{ route('dashboard.movie.publish', ['movie_id' => $movie->id]) }}"
                                            method="post">
                                            @csrf
                                            @if($movie->is_published)
                                                <button class="btn btn-sm me-1 btn-outline-secondary">
                                                    <i class="bi bi-eye-slash"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-sm me-1 btn-outline-light">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            @endif
                                        </form>
                                        <a href="{{ route('dashboard.movie.edit', ['movie_id' => $movie->id]) }}"
                                           class="me-1">
                                            <button class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </a>
                                        <form action="{{ route('dashboard.movie.delete', ['movie_id' => $movie->id]) }}"
                                              method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-12 d-flex justify-content-center">
                                        <video class="object-fit-cover w-100" controls>
                                            <source src="{{ route('movie.stream', ['movie_id' => $movie->id]) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
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
