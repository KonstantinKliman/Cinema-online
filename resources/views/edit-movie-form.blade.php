@extends('layouts.main')

@section('title', 'Edit movie')

@section('main')
    <h1 class="text-center my-3">Edit a movie</h1>
        <x-container>
            <form action="{{ route('editMovie.action', ['movie_id' => $movie->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                           aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="title" value="{{ $movie->title }}">
                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Country</span>
                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                           aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="country" value="{{ $movie->country }}">
                    @error('country')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Production studio</span>
                    <input type="text" class="form-control @error('production_studio') is-invalid @enderror"
                           aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="production_studio" value="{{ $movie->production_studio }}">
                    @error('production_studio')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Year</span>
                    <input type="number" min="1895" max="{{ now()->year }}" class="form-control @error('release_year') is-invalid @enderror"
                           aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="release_year" value="{{ $movie->release_year }}">
                    @error('release_year')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Description</span>
                    <textarea class="form-control @error('description') is-invalid @enderror" aria-label="With textarea"
                              name="description">{{ $movie->description }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Genre</span>
                    <select class="form-control" multiple="" aria-label="Multiple select example" size="5"
                            name="genres[]">
                        @foreach($genres as $genre)
                            <option value="{{ $genre->id }}" @foreach($movie->genres as $movieGenre)@if($movieGenre->id == $genre->id) selected @endif @endforeach>{{ $genre->name }}</option>
                        @endforeach
                    </select>
                    @error('genres[]')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupFile01">Movie file</label>
                    <input type="file" class="form-control @error('movie_file_path') is-invalid @enderror"
                           id="inputGroupFile01" name="movie_file_path">
                    @error('movie_file_path')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupFile01">Movie poster</label>
                    <input type="file" class="form-control @error('poster_file_path') is-invalid @enderror"
                           id="inputGroupFile01" name="poster_file_path">
                    @error('poster_file_path')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-light fw-medium mx-3">Edit a movie</button>
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
@endsection
