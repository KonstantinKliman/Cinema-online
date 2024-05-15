@extends('layouts.dashboard')

@section('title', 'Create user')

@section('main')
    <div class="row">
        <div class="col">
            <x-header>
                Create user account
            </x-header>
            <p class="form-text text-center">Default password: <strong>root</strong></p>
        </div>
    </div>
    <div class="d-flex flex-column align-items-center mb-5">
        {{--Edit user information--}}
        <div class="border bg-light-subtle rounded-3 py-3 px-3 mb-5 w-100">
            <form action="{{ route('dashboard.user.store') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text">Name <span class="text-danger fw-bold">*</span></span>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           value="" name="name">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text">Email <span class="text-danger fw-bold">*</span></span>
                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                           value="" name="email">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @csrf
                <div class="row d-flex justify-content-center">
                    <div class="w-auto p-0">
                        <button class="btn btn-outline-light" type="submit">Create</button>
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
    </div>
@endsection
