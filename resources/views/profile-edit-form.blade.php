@extends('layouts.main')

@section('title', 'Edit profile')

@section('main')
    <h1 class="text-center my-3">Edit your profile</h1>
    <div class="d-flex flex-column align-items-center">
        <div class="border bg-light-subtle rounded-3 px-3 mb-5 w-50">
            <h5 class="my-3 border-bottom pb-3">Edit your account information</h5>
            <form action="{{ route('edit-user-name.action', ['user_id' => $user->id]) }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text">Name <span class="text-danger fw-bold">*</span></span>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $user->name) }}" name="name">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Confirm</button>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </form>
            <form action="{{ route('edit-user-email.action', ['user_id' => $user->id]) }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text">Email <span class="text-danger fw-bold">*</span></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $user->email) }}" name="email">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Confirm</button>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </form>
            <form action="{{ route('edit-user-country.action', ['user_id' => $user->id]) }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text">Country</span>
                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                           value="{{ old('country', $user->country) }}" name="country">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Confirm</button>
                    @error('country')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </form>
            <form action="{{ route('edit-user-city.action', ['user_id' => $user->id]) }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text">City</span>
                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                           value="{{ old('city', $user->city) }}" name="city">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Confirm</button>
                    @error('city')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </form>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        <div class="border bg-light-subtle rounded-3 px-3 mb-5 w-50">
            <form action="{{ route('upload-profile-photo.action', ['user_id' => $user->id]) }}" method="post"
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
                    @if($user->profile_photo_path === null)
                        <img src="{{ asset('assets/img/img-profile.png') }}" alt="no-img-profile" class="img-fluid">
                    @else
                        <img src="{{ asset($user->profile_photo_path) }}" alt="img-profile" class="img-fluid">
                    @endif
                </div>
                <div class="input-group inva mb-3">
                    <input type="file" class="form-control @error('profile_photo') is-invalid @enderror"
                           id="inputGroupFile02" name="profile_photo">
                    @error('profile_photo')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-light fw-medium mx-3">Edit profile photo</button>
                </div>
                @if(session('photo_success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('photo_success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </form>
        </div>
        <div class="border bg-light-subtle rounded-3 px-3 mb-5 w-50">
            <form action="{{ route('edit-user-password.action', ['user_id' => $user->id]) }}" method="post">
                @csrf
                <h5 class="my-3 border-bottom pb-3">Edit your password</h5>
                <div class="input-group mb-3">
                    <span class="input-group-text">Password<span class="text-danger fw-bold">*</span></span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text">Confirm password<span class="text-danger fw-bold">*</span></span>
                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                           name="password_confirmation">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-light fw-medium">Edit password</button>
                </div>
                @if(session('password_success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('password_success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if($errors->default->first('password_error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ $errors->default->first('password_error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </form>
        </div>
        <div class="border bg-light-subtle rounded-3 px-3 mb-5 w-50">
            <form action="{{ route('delete-user-account.action', ['user_id' => $user->id]) }}" method="post">
                @csrf
                <h5 class="my-3 border-bottom pb-3 text-danger-emphasis">Delete your account</h5>
                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-danger fw-bold">Delete account</button>
                </div>
            </form>
        </div>
    </div>
@endsection
{{--ViewSonic9997--}}
