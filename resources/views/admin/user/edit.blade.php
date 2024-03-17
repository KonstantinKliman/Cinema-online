@extends('layouts.admin')

@section('title', 'Edit user')

@section('main')
    <div class="row">
        <div class="col">
            <x-header>
                Edit {{ $user->name }} account
            </x-header>
        </div>
    </div>
    <div class="d-flex flex-column align-items-center mb-5">
        {{--Edit user information--}}
        <div class="border bg-light-subtle rounded-3 px-3 mb-5 w-50">
            <h5 class="my-3 border-bottom pb-3">Edit account information</h5>
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
            <form action="{{ route('edit-user-role.action', ['user_id' => $user->id]) }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <select class="form-select" name="role" id="inputGroupSelect04" aria-label="Example select with button addon">
                        @foreach($roles as $id => $role)
                            <option
                                value="{{ $id }}" {{ $id == $user->role ? 'selected disabled' : '' }}>{{ $role }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-outline-secondary" type="submit">Confirm</button>
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
