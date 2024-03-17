@extends('layouts.admin')

@section('title', 'Edit profile')

@section('main')
    <h1 class="text-center my-3">Edit {{ $profile->user->name }} profile</h1>
    <div class="d-flex flex-column align-items-center">
        <div class="border bg-light-subtle rounded-3 pt-3 px-3 mb-5 w-50">
            <form action="{{ route('edit-profile-info.action', ['user_id' => $profile->user->id]) }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text">First name</span>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                           value="{{ old('first_name', $profile->first_name) }}" name="first_name" placeholder="Enter first name here">
                    @error('first_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Last name</span>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                           value="{{ old('last_name', $profile->last_name) }}" name="last_name" placeholder="Enter last name here">
                    @error('last_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Date of birth</span>
                    <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                           value="{{ old('date_of_birth', $profile->date_of_birth) }}" name="date_of_birth" placeholder="Enter date of birth here">
                    @error('date_of_birth')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Country</span>
                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                           value="{{ old('country', $profile->country) }}" name="country" placeholder="Enter country here">
                    @error('country')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">City</span>
                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                           value="{{ old('city', $profile->city) }}" name="city" placeholder="Enter city here">
                    @error('city')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Description</span>
                    <textarea type="text" class="form-control @error('description') is-invalid @enderror"
                              name="description" placeholder="Enter information about user here">{{ old('description', $profile->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-light fw-medium mx-3">Save</button>
                </div>
            </form>
            @if(session('profile_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('profile_success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
@endsection
