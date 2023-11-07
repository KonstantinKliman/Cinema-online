@extends('layouts.main')

@section('title', 'Add new movie')

@section('main')
    <h1 class="text-center my-3">Upload a movie</h1>
    <div class="d-flex flex-column align-items-center">
        <div class="border bg-light-subtle rounded-3 p-3 w-50">
            <form action="{{ route('createMovie.action') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Title</span>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="title">
                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Description</span>
                    <textarea class="form-control @error('description') is-invalid @enderror" aria-label="With textarea" name="description"></textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
{{--                <div class="accordion mb-3" id="accordionExample">--}}
{{--                    <div class="accordion-item">--}}
{{--                        <h2 class="accordion-header">--}}
{{--                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">--}}
{{--                                Choose movie genre--}}
{{--                            </button>--}}
{{--                        </h2>--}}
{{--                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">--}}
{{--                            <div class="accordion-body">--}}
{{--                                <select class="form-select" multiple aria-label="multiple select example" name="genres[]">--}}
{{--                                    @foreach($genres as $genre)--}}
{{--                                        <option value="{{ $genre->id }}">{{ $genre->title }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupFile01">Movie file</label>
                    <input type="file" class="form-control @error('movie_file_path') is-invalid @enderror" id="inputGroupFile01" name="movie_file_path">
                    @error('movie_file_path')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <label class="input-group-text" for="inputGroupFile01">Movie poster</label>
                    <input type="file" class="form-control @error('poster_file_path') is-invalid @enderror" id="inputGroupFile01" name="poster_file_path">
                    @error('poster_file_path')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-light fw-medium mx-3">Upload a movie</button>
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
        </div>
    </div>
@endsection
