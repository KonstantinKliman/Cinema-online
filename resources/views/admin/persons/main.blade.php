@extends('layouts.admin')

@section('title', 'Cinema-online persons')

@section('main')
    <div class="row">
        <div class="col">
            <x-header>
                Persons
            </x-header>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col d-flex justify-content-center align-items-center mb-3">
            <a href="{{ route('admin-attach-person-to-movie.page') }}">
                <button class="btn btn-outline-light me-1">
                    Attach person to movie
                </button>
            </a>
            <a href="{{ route('admin-create-person.page') }}">
                <button class="btn btn-outline-light me-1">
                    Add person
                </button>
            </a>
            <a href="{{ route('admin-person-role.page') }}">
                <button class="btn btn-outline-light">
                    Add role
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
                    <th>Person full name</th>
                    <th>Movies</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($persons as $index => $person)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <a href="{{ route('admin-person.page', ['person' => $person->slug]) }}"
                               class="link">{{ $person->full_name }}</a>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                @foreach($person->movies->unique() as $movie)
                                    <a href="{{ route('admin-movie.page', ['movie_id' => $movie->id]) }}"
                                       class="link">{{ $movie->title }}</a>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('admin-edit-person.page', ['person' => $person->slug]) }}"
                                   class="me-1">
                                    <button class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </a>
                                <form action="{{ route('delete-person.action', ['person' => $person->slug]) }}" method="post">
                                    @csrf
                                    @method("DELETE")
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
