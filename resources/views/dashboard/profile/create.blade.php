@extends('layouts.dashboard')

@section('title', 'Create profile')

@section('main')
    <h1 class="text-center my-3">Create profile</h1>
    <div class="row">
        <div class="col d-flex justify-content-center align-items-center">
            <div class="border bg-light-subtle rounded-3 px-3 mb-5 w-50">
                <form action="{{ route('dashboard.profile.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <h5 class="my-3">Profile for user</h5>
                    <div class="input-group mb-3">
                        <label class="input-group-text" for="inputGroupSelect01">User</label>
                        <select class="form-select" id="inputGroupSelect01" name="user_id">
                            <option selected disabled>Choose...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <h5 class="my-3">Profile info</h5>
                    <div class="input-group mb-3">
                        <span class="input-group-text">First name</span>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                               value="" name="first_name"
                               placeholder="Enter first name here">
                        @error('first_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Last name</span>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                               value="" name="last_name"
                               placeholder="Enter last name here">
                        @error('last_name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Date of birth</span>
                        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                               value="" name="date_of_birth"
                               placeholder="Enter date of birth here">
                        @error('date_of_birth')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Country</span>
                        <input type="text" class="form-control @error('country') is-invalid @enderror"
                               value="" name="country"
                               placeholder="Enter country here">
                        @error('country')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">City</span>
                        <input type="text" class="form-control @error('city') is-invalid @enderror"
                               value="" name="city" placeholder="Enter city here">
                        @error('city')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text">Description</span>
                        <textarea type="text" class="form-control @error('description') is-invalid @enderror"
                                  name="description"
                                  placeholder="Enter information about user here"></textarea>
                        @error('description')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        <button type="submit" class="btn btn-light fw-medium mx-3">Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
