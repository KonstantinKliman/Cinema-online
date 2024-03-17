@extends('layouts.admin')

@section('title', 'Cinema-online genres')

@section('main')
    <div class="row">
        <div class="col">
            <x-header>
                Genres
            </x-header>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col d-flex justify-content-center align-items-center mb-3">
            <a href="{{ route('admin-create-genre.page') }}">
                <button class="btn btn-outline-light">
                    Add genre
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
                    <th>Genre</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($genres as $index => $genre)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <a href="{{ route('admin-genre.page', ['genre' => $genre->slug]) }}"
                               class="link">{{ ucfirst($genre->name) }}</a>
                        </td>
                        <td>{{ $genre->description }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('admin-edit-genre.page', ['genre' => $genre->slug]) }}"
                                   class="me-1">
                                    <button class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </a>
                                <form action="{{ route('delete-genre.action', ['genre' => $genre->slug]) }}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
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
