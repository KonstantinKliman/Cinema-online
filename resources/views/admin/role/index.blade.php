@extends('layouts.admin')

@section('title', 'Cinema-online user role')

@section('main')
    <div class="row">
        <div class="col">
            <x-header>
                User roles
            </x-header>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-1 d-flex align-items-center mb-3">
            <a href="{{ route('admin.role.create') }}">
                <button class="btn btn-outline-light">
                    Create user role
                </button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Role</th>
                    <th>Permissions</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($roles as $index => $role)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td><p>{{ $role->name }}</p></td>
                        <td>
                            <p>
                                @foreach($role->permissions as $permission)
                                    {{ $permission->name }},
                                @endforeach
                            </p>
                        </td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('admin.role.edit', ['role_id' => $role->id]) }}" class="me-1">
                                    <button class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </a>
                                <form action="{{ route('admin.role.delete', ['role_id' => $role->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
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
