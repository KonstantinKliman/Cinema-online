@extends('layouts.admin')

@section('title', 'Add new person')

@section('main')
    <h1 class="text-center my-3">Add new person</h1>
    <div class="d-flex flex-column">
        <x-container class="w-50">
            <form action="{{ route('admin.person.store') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Full name</span>
                    <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                           aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="full_name">
                    @error('full_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-light fw-medium mx-3">Create</button>
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
