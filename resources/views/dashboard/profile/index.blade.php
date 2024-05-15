@extends('layouts.dashboard')

@section('title', 'Cinema-online user profiles')

@section('main')
    <div class="row">
        <div class="col">
            <h3 class="mb-3 text-center">
                Profiles
            </h3>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col d-flex justify-content-center">
            <a href="{{ route('dashboard.profile.create') }}" class="btn btn-outline-light">
                Create profile
            </a>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="accordion accordion-flush border" id="accordionFlushExample">
                @foreach($profiles as $index => $profile)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-{{ $index }}" aria-expanded="false" aria-controls="panelsStayOpen-{{ $index }}">
                                {{ $index + 1 . '. ' . ucwords("$profile->first_name $profile->last_name")}}
                            </button>
                        </h2>
                        <div id="panelsStayOpen-{{ $index }}" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12 col-lg-2 d-lg-block d-flex justify-content-center mb-3 mb-lg-0">
                                        <img class="img-fluid" src="{{ asset($profile->avatar) }}" alt="profileAvatar">
                                    </div>
                                    <div class="col-12 col-lg-9">
                                        <p>First name: {{ $profile->first_name }}</p>
                                        <p>Last name: {{ $profile->last_name }}</p>
                                        <p>Date of birth: {{ $profile->date_of_birth }}</p>
                                        <p>Country: {{ $profile->country }}</p>
                                        <p>City: {{ $profile->city }}</p>
                                        <p>Description: {{ $profile->description }}</p>
                                    </div>
                                    <div class="col-12 col-lg-1 d-flex justify-content-center justify-content-lg-end flex-row">
                                        <a href="{{ route('dashboard.profile.edit', ['profile_id' => $profile->id]) }}"
                                           class="me-1">
                                            <button class="btn btn-sm btn-outline-success mb-1">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </a>
                                        <form action="{{ route('dashboard.profile.delete', ['profile_id' => $profile->id]) }}"
                                              method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
