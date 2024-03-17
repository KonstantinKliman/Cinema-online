@extends('layouts.admin')

@section('title', $person->full_name)

@section('main')
    <div class="d-flex flex-row align-items-center mt-3">
        <h1 class="text-start">{{ ucfirst($person->full_name) }}</h1>
        <a href="{{ route('admin-edit-person.page', ['person' => $person->slug]) }}" class="ms-1">
            <button class="btn btn-sm btn-outline-light">
                Edit
            </button>
        </a>
    </div>
    <div class="form-text">
        <p>
            @foreach($allRoles as $role)
                {{ ucfirst($role)}}@if(!$loop->last)
                    ,
                @endif
            @endforeach
        </p>
    </div>
    <div class="row my-3">
        <div class="col">
            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Role(Roles)</th>
                    <th>Uploaded by</th>
                    <th>Published</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($movies as $index => $movie)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><a href="{{ route('admin-movie.page', ['movie_id' => $movie->id]) }}"
                               class="link text-light m-0">{{ $movie->title }}</a></td>
                        <td>
                            <div class="row d-flex flex-column">
                                @foreach($movie->personRoles()->where('person_id', $person->id)->get() as $roles)
                                    <div class="col mb-1">
                                        <form
                                            action="{{ route('detach-person-role-from-movie.action', ['person' => $person->slug, 'movie_id' => $movie->id, 'role_id' => $roles->role->id,]) }}"
                                            method="post">
                                            @csrf
                                            @method("DELETE")
                                            {{ $roles->role->name }}
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </td>
                        <td><a href="{{ route('admin-user.page', ['user_id' => $movie->user->id]) }}"
                               class="link text-light m-0">{{ $movie->user->name }}</a></td>
                        <td>
                            @if($movie->is_published)
                                <i class="bi bi-check-lg text-success"></i>
                            @else
                                <i class="bi bi-x-lg text-danger"></i>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex">
                                <form action=""
                                      method="post">
                                    @method("DELETE")
                                    @csrf
                                    <button class="btn btn-sm btn-outline-danger" title="Detach">
                                        <i class="bi bi-x-lg"></i>
                                        Detach person from movie
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
