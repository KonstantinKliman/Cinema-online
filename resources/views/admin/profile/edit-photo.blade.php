@extends('layouts.admin')

@section('title', 'Edit profile')

@section('main')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <h1 class="text-center my-3">Edit {{ $profile->user->name }} profile photo</h1>
        <div class="border bg-light-subtle rounded-3 px-3 mb-5 w-50">
            <form action="{{ route('upload-profile-photo.action', ['user_id' => $profile->user->id]) }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <div class="border-bottom">
                    <h5 class="my-3">Edit your profile photo</h5>
                    <div class="form-text mb-3">
                        <strong>500x500</strong> px, Maximum size: <strong>2MB</strong>, Format file: <strong>pg, jpeg,
                            png, bmp, gif, svg, or webp</strong>
                    </div>
                </div>
                <div class="my-3">
                    <p class="mx-0 my-1">Current photo:</p>
                    @if($profile->avatar === null)
                        <img src="{{ asset('assets/img/img-profile.png') }}" alt="no-img-profile" class="img-fluid">
                    @else
                        <img src="{{ asset($profile->avatar) }}" alt="img-profile" class="img-fluid">
                    @endif
                </div>
                <div class="input-group mb-3">
                    <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                           id="inputGroupFile02" name="avatar">
                    @error('avatar')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-light fw-medium mx-3">Edit profile photo</button>
                </div>
                @if(session('photo_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('photo_message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection
