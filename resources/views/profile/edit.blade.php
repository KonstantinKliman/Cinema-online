@extends('layouts.main')

@section('title', 'Edit profile')

@section('main')
    <h1 class="text-center my-3">Edit your profile</h1>
    <div class="d-flex flex-column align-items-center">
        {{--Edit profile information--}}
        <div class="border bg-light-subtle rounded-3 px-3 mb-5 w-50">
            <h5 class="my-3 border-bottom pb-3">Edit your profile information</h5>
            <form action="{{ route('edit-profile-info.action', ['user_id' => $profile->user->id]) }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text">First name</span>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                           value="{{ old('first_name', $profile->first_name) }}" name="first_name" placeholder="Enter your first name here">
                    @error('first_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Last name</span>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                           value="{{ old('last_name', $profile->last_name) }}" name="last_name" placeholder="Enter your last name here">
                    @error('last_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Date of birth</span>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                           value="{{ old('date_of_birth', $profile->date_of_birth) }}" name="date_of_birth" placeholder="Enter your date of birth here">
                    @error('date_of_birth')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Country</span>
                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                           value="{{ old('country', $profile->country) }}" name="country" placeholder="Enter your country here">
                    @error('country')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">City</span>
                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                           value="{{ old('city', $profile->city) }}" name="city" placeholder="Enter your city here">
                    @error('city')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Information about yourself</span>
                    <textarea type="text" class="form-control @error('description') is-invalid @enderror"
                              name="description" placeholder="Enter your information about yourself here">{{ old('description', $profile->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-light fw-medium mx-3">Edit profile information</button>
                </div>
            </form>
            @if(session('profile_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('profile_success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        {{--Edit profile photo--}}
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
