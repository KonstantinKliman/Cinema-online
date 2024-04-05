@extends('layouts.admin')

@section('title', 'Person role')

@section('main')
    <div class="row">
        <div class="col d-flex align-items-center flex-column">
            <h1 class="my-3">Role for persons</h1>
        </div>
    </div>
    <div class="d-flex flex-column">
        <x-container class="w-50">
            <div class="col d-flex align-items-center flex-column">
                <h5 class="mb-3 text-center">Create role for persons</h5>
            </div>
            <form action="{{ route('admin.person.role.store') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text" id="inputGroup-sizing-default">Name</span>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                           aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" name="name">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-center mb-3">
                    <button type="submit" class="btn btn-light fw-medium mx-3">Create</button>
                </div>
            </form>
            @if(session('create_movie_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('create_movie_success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('create_movie_error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('create_movie_error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </x-container>
    </div>
    <div class="row">
        <div class="col d-flex align-items-center flex-column">
            <h1 class="my-3">Current roles for persons</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Role name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $index => $role)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('admin.person.role.edit', ['role_id' => $role->id]) }}"
                                   class="me-1">
                                    <button class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </a>
                                <form action="{{ route('admin.person.role.delete', ['role_id' => $role->id]) }}" method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
