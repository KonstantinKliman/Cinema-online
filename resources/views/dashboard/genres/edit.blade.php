@extends('layouts.dashboard')

@section('title', 'Edit ' . $genre->name . ' genre')

@section('main')
    <div class="row">
        <div class="col d-flex align-items-center flex-column">
            <h1 class="my-3">Edit {{ $genre->name }} genre</h1>
            <p class="form-text">Description must be smaller than <strong>255</strong> characters</p>
        </div>
    </div>
    <div class="d-flex flex-column">
        <x-container class="w-50">
            <form action="{{ route('dashboard.genre.update', ['genre' => $genre->slug]) }}" method="post">
                @csrf
                @method("PUT")
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="name"
                           value="{{ old('name', $genre->name) }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Description</span>
                    <input type="text" class="form-control @error('description') is-invalid @enderror"
                           aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default"
                           name="description" value="{{ old('description', $genre->description) }}">
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-light fw-medium mx-3">Edit</button>
                </div>
            </form>
            @if(session('create_genre_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('create_genre_success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('create_genre_error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('create_genre_error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </x-container>
    </div>
@endsection
