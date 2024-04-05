@extends('layouts.main')

@section('title', 'Add new person')

@section('main')
    <x-header>Add new person</x-header>
    <div class="d-flex flex-column align-items-center">
        <x-container class="w-50">
            <form action="{{ route('create-person.action') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Full name</span>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                           aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="fullName">
                    @error('fullName')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">Role</label>
                    <select class="form-select @error('role') is-invalid @enderror" id="inputGroupSelect01" name="role">
                        <option selected disabled>Choose...</option>
                        <option value="director">Director</option>
                        <option value="producer">Producer</option>
                        <option value="actor">Actor</option>
                        <option value="screenwriter">Screenwriter</option>
                        <option value="cameraman">Cameraman</option>
                        <option value="composer">Composer</option>
                    </select>
                </div>
                @error('role')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupSelect01">On movie</label>
                    <select class="form-select @error('role') is-invalid @enderror" id="inputGroupSelect01" name="movieId">
                        <option selected disabled>Choose...</option>
                        @foreach($movies as $movie)
                        <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                        @endforeach
                    </select>
                </div>
                @error('role')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-light fw-medium mx-3">Add a person</button>
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
