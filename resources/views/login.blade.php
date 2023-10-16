@extends('layouts.main')

@section('title', 'Login')

@section('main')
    <div class="w-100 h-100 d-flex justify-content-center align-content-center">
        <form class="w-25 d-flex justify-content-center flex-column" method="post" action="{{ route('login.action') }}">
            @csrf
            <h3 class="mb-3 fw-normal text-center">Login</h3>
            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}">
                <label for="floatingInput">Email address</label>
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="floatingPassword" placeholder="Password" value="{{ old('password') }}">
                <label for="floatingPassword">Password</label>
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" name="remember_me"> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-light mb-3" type="submit">Login</button>
            <div class="d-flex justify-content-center">
                <p class="me-1 text-secondary fw-light">Don't have an account?</p>
                <a href="{{ route('register.page') }}" class="text-decoration-none text-light fw-semibold">Register</a>
            </div>
        </form>
    </div>
@endsection
