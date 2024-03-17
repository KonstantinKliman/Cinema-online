@extends('layouts.admin')

@section('title', ucfirst($genre->name))

@section('main')
    <div class="d-flex flex-row align-items-center mt-3">
        <h1 class="text-start">{{ ucfirst($genre->name) }}</h1>
        <a href="{{ route('admin-edit-genre.page', ['genre' => $genre->slug]) }}" class="ms-1">
            <button class="btn btn-sm btn-outline-light">
                Edit
            </button>
        </a>
    </div>
    <div class="form-text">
        <p>{{ $genre->description }}</p>
    </div>
    <div class="row my-3">
        <div class="col">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Uploaded by</th>
                    <th>Published</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($movies as $index => $movie)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><a href="{{ route('admin-movie.page', ['movie_id' => $movie->id]) }}"
                               class="link text-light m-0">{{ $movie->title }}</a></td>
                        <td>{{ mb_strimwidth($movie->description, 0, 50, '...') }}</td>
                        <td><a href="{{ route('admin-user.page', ['user_id' => $movie->user->id]) }}"
                               class="link text-light m-0">{{ $movie->user->name }}</a></td>
                        <td>
                            @if($movie->is_published)
                                <i class="bi bi-check-lg text-success"></i>
                            @else
                                <i class="bi bi-x-lg text-danger"></i>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <form action="{{ route('detach-movie.action', ['movie_id' => $movie->id, 'genre_id' => $genre->id]) }}"
                                      method="post">
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger" title="Detach">
                                        <i class="bi bi-x-lg"></i>
                                        Detach movie
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
