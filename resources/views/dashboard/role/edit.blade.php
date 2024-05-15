@extends('layouts.dashboard')

@section('title', 'Edit ' . $role->name .  ' role')

@section('main')
    <div class="row">
        <div class="col">
            <x-header>
                Edit {{ $role->name }} role
            </x-header>
        </div>
    </div>
    <div class="d-flex flex-column align-items-center mb-5">
        <div class="border bg-light-subtle rounded-3 py-3 px-3 mb-5 w-50">
            <form action="{{ route('dashboard.role.update', ['role_id' => $role->id]) }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text">Name</span>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           value="{{ $role->name }}" name="name">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @foreach($permissions as $permission)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{ $permission->id }}"
                               name="permissions[]"
                               id="flexCheckDefault{{ $permission->id }}" {{ $role->hasPermissionTo($permission->name) == $permission->name ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexCheckDefault{{ $permission->id }}">
                            {{ $permission->name }}
                        </label>
                    </div>
                @endforeach
                <div class="row d-flex justify-content-center">
                    <div class="w-auto p-0">
                        <button class="btn btn-outline-light" type="submit">Edit</button>
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
