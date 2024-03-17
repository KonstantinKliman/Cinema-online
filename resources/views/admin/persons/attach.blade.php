@extends('layouts.admin')

@section('title', 'Attach person to movie')

@section('main')
    <h1 class="text-center my-3">Attach person to movie</h1>
    <div class="d-flex flex-column">
        <x-container class="w-50">
            <form action="{{ route('attach-movie-to-person.action') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Movie</label>
                    <select class="form-select" id="inputGroupSelect01" name="movie_id">
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Person</label>
                    <select class="form-select" id="inputGroupSelect01" name="person_id">
                        @foreach($persons as $person)
                            <option value="{{ $person->id }}">{{ $person->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Role</label>
                    <select class="form-select" id="inputGroupSelect01" name="role_id">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-light fw-medium mx-3">Attach</button>
                </div>
            </form>
            @if(session('create_movie_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('create_movie_success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('create_movie_error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('create_movie_error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </x-container>
    </div>
@endsection
