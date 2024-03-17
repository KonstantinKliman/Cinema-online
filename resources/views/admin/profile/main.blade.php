@extends('layouts.admin')

@section('title', 'Cinema-online user profiles')

@section('main')
    <div class="row">
        <div class="col">
            <x-header>
                Profiles
            </x-header>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Avatar</th>
                    <th>Username</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Date of birth</th>
                    <th>Country</th>
                    <th>City</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($profiles as $index => $profile)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><img src="{{ asset($profile->avatar) }}" alt="" class="img-fluid" width="100" height="100">
                            </td>
                            <td><a href="{{ route('admin-user.page', ['user_id' => $profile->user->id]) }}" class="link text-light m-0">{{ $profile->user->name }}</a></td>
                            <td>
                                @if($profile->first_name)
                                    {{ $profile->first_name }}
                                @else
                                    <span class="text-light opacity-50">Empty</span>
                                @endif
                            </td>
                            <td>
                                @if($profile->last_name)
                                    {{ $profile->last_name }}
                                @else
                                    <span class="text-light opacity-50">Empty</span>
                                @endif
                            </td>
                            <td>
                                @if($profile->date_of_birth)
                                    {{ $profile->date_of_birth }}
                                @else
                                    <span class="text-light opacity-50">Empty</span>
                                @endif
                            </td>
                            <td>
                                @if($profile->country)
                                    {{ $profile->country }}
                                @else
                                    <span class="text-light opacity-50">Empty</span>
                                @endif
                            </td>
                            <td>
                                @if($profile->city)
                                    {{ $profile->city }}
                                @else
                                    <span class="text-light opacity-50">Empty</span>
                                @endif
                            </td>
                            <td>
                                @if($profile->description)
                                    {{ mb_strimwidth($profile->description, 0, 50, '...') }}
                                @else
                                    <span class="text-light opacity-50">Empty</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <a href="{{ route('admin-edit-profile.page', ['profile_id' => $profile->id]) }}" class="me-1">
                                        <button class="btn btn-sm btn-outline-success mb-1">
                                            <i class="bi bi-pencil"></i>
                                            Edit profile info
                                        </button>
                                    </a>
                                    <a href="{{ route('admin-edit-photo.page', ['profile_id' => $profile->id]) }}" class="me-1">
                                        <button class="btn btn-sm btn-outline-success mb-1">
                                            <i class="bi bi-file-earmark-image"></i>
                                            Edit profile photo
                                        </button>
                                    </a>
                                    <form action="{{ route('admin-delete-profile.action', ['profile_id' => $profile->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                            Delete profile
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
