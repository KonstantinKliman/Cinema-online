@extends('layouts.admin')

@section('title', 'Cinema-online users')

@push('js')
    <script src="{{ asset('assets/js/role.js') }}"></script>
@endpush

@section('main')
    <div class="row">
        <div class="col">
            <x-header>
                Users
            </x-header>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-1 d-flex align-items-center mb-3">
            <a href="{{ route('admin.user.create') }}">
                <button class="btn btn-outline-light">
                    Create user
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Verified email</th>
                    <th>Registered at</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $index+1 }}</td>
                            <td><a href="{{ route('admin.user.show', ['user_id' => $user->id]) }}" class="link text-light m-0">{{ $user->name }}</a></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->hasVerifiedEmail())
                                    <i class="bi bi-check-lg text-success"></i>
                                @else
                                    <i class="bi bi-x-lg text-danger"></i>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d F Y') }}</td>
                            <td>
                                @dump($user->roles()->first()->name)
                            </td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{ route('admin.user.edit', ['user_id' => $user->id]) }}" class="me-1">
                                        <button class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                    </a>
                                    <form action="{{ route('admin.user.destroy', ['user_id' => $user->id]) }}" method="post">
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
