@extends('layouts.admin')

@section('title', 'Cinema-online movies')

@section('main')
    <div class="row">
        <div class="col">
            <x-header>
                Movies
            </x-header>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col d-flex justify-content-center align-items-center mb-3">
            <a href="{{ route('admin-create-movie.page') }}">
                <button class="btn btn-outline-light">
                    Upload movie
                </button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Country</th>
                    <th>Production studio</th>
                    <th>Release year</th>
                    <th>Description</th>
                    <th>Rating</th>
                    <th>Genres</th>
                    <th>Persons</th>
                    <th>Reviews</th>
                    <th>Uploaded by</th>
                    <th>Published</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($movies as $index => $movie)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><a href="{{ route('admin-movie.page', ['movie_id' => $movie->id]) }}" class="link text-light m-0">{{ $movie->title }}</a></td>
                        <td>{{ $movie->country }}</td>
                        <td>{{ $movie->production_studio }}</td>
                        <td>{{ $movie->release_year }}</td>
                        <td>{{ mb_strimwidth($movie->description, 0, 50, '...') }}</td>
                        <td>{{ $movie->rating }}</td>
                        <td>
                            <div class="d-flex flex-column">
                                @foreach($movie->genres as $genre)
                                    <a href="{{ route('admin-genre.page', ['genre' => $genre->slug]) }}" class="link">{{ ucfirst($genre->name) }}</a>
                                @endforeach
                            </div>
                        </td>
                        <td>
{{--                            <div class="d-flex flex-column">--}}
{{--                                @foreach($movie->persons as $person)--}}
{{--                                    <a href="{{ route('admin-person.page', ['person' => $person->slug]) }}" class="link">{{ $person->full_name }}</a>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
                        </td>
                        <td>{{ $movie->reviews->count() }}</td>
                        <td><a href="{{ route('admin-user.page', ['user_id' => $movie->user->id]) }}" class="link text-light m-0">{{ $movie->user->name }}</a></td>
                        <td>
                            @if($movie->is_published)
                                <i class="bi bi-check-lg text-success"></i>
                            @else
                                <i class="bi bi-x-lg text-danger"></i>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <form action="{{ route('publishMovie.action', ['movie_id' => $movie->id]) }}" method="post">
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
                                <a href="{{ route('admin-edit-movie.page', ['movie_id' => $movie->id]) }}" class="me-1">
                                    <button class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </a>
                                <form action="{{ route('admin-delete-movie.action', ['movie_id' => $movie->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
