@extends('layouts.auth')

@section('title', 'Register')

@section('main')
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <form method="post" action="{{ route('register.action') }}">
            @csrf
            <div class="d-flex justify-content-center flex-column">
                <h3 class="mb-3 fw-normal text-center">Register</h3>
                <div class="form-floating mb-3">
                    <input type="text" class="w-100 form-control @error('name') is-invalid @enderror" name="name"
                           id="floatingInput" placeholder="John" value="{{ old('name') }}">
                    <label for="floatingInput">Name</label>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                           id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}">
                    <label for="floatingInput">Email address</label>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                           id="floatingPassword" placeholder="Password" {{ old('password') }}>
                    <label for="floatingPassword">Password</label>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                           name="password_confirmation" id="floatingPassword" placeholder="Password"
                           value="{{ old('password_confirmation') }}">
                    <label for="floatingPassword">Confirm password</label>
                    @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <button class="w-100 btn btn-lg btn-light mb-3" type="submit">Register</button>
                <div class="d-flex justify-content-center mb-3 border-bottom">
                    <p class="me-1 text-secondary fw-light">Already have an account?</p>
                    <a href="{{ route('login.page') }}" class="text-decoration-none text-light fw-semibold">Login</a>
                </div>
                <div class="text-center">
                    <a class="me-1 text-light fw-semibold text-decoration-none" href="{{ route('index') }}">Go to home
                        page</a>
                </div>
            </div>
        </form>
    </div>
@endsection
