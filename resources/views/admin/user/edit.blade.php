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
        <div class="border bg-light-subtle rounded-3 px-3 mb-5 w-50">
            <h5 class="my-3 border-bottom pb-3">Edit account information</h5>
            <form action="{{ route('admin.user.update', ['user_id' => $user->id]) }}" method="post">
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
                    <div class="col">
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="role_select">Role</label>
                            <select class="form-select" id="role_select" name="role">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" @selected($user->roles()->first()->name == $role->name)>
                                        {{ $role->name }}</option>
                                @endforeach
                            </select>
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
    </div>
@endsection
