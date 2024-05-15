@extends('layouts.dashboard')

@section('title', 'Your user account')

@section('main')
    <h1 class="text-center mb-3">Your account</h1>
    @if(!auth()->user()->hasVerifiedEmail())
        <p class="text-center form-text">
            To access your profile, you need to verify your email. If you did not receive an email, please click
            <a class="text-decoration-none text-light fw-bold" href="{{ route('verification.send') }}"
               onclick="event.preventDefault(); document.getElementById('verification-form').submit();">
                here
            </a>
            <form id="verification-form" method="POST" action="{{ route('verification.send') }}" style="display: none;">
                @csrf
            </form>
        </p>
    @endif
    <div class="d-flex flex-column align-items-center">
        {{--Edit user information--}}
        <div class="border bg-light-subtle rounded-3 px-3 mb-5 w-100">
            <h5 class="my-3 border-bottom pb-3">Edit your account information</h5>
            <form action="{{ route('user.update', ['user_id' => $user->id]) }}" method="post">
                @csrf
                @method("PUT")
                <div class="row d-flex flex-column">
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Name <span class="text-danger fw-bold">*</span></span>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}" name="name">
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <div class="input-group mb-3">
                            <span class="input-group-text">Email <span class="text-danger fw-bold">*</span></span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}" name="email">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col d-flex justify-content-center mb-3">
                        <button type="submit" class="btn btn-light fw-medium">Edit</button>
                    </div>
                </div>
            </form>
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
        {{--Edit user password--}}
        <div class="border bg-light-subtle rounded-3 px-3 mb-5 w-100">
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
                @if(session('password_error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('password_error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection
