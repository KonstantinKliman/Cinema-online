@extends('layouts.dashboard')

@section('title', 'Cinema-online users')

@section('main')
    <div class="row">
        <div class="col">
            <h3 class="mb-3 text-center">
                Users
            </h3>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col-auto d-flex align-items-center mb-3">
            <a href="{{ route('dashboard.user.create') }}">
                <button class="btn btn-outline-light">
                    Create user
                </button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="accordion accordion-flush border" id="accordionFlushExample">
                @foreach($users as $index => $user)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-{{ $index }}" aria-expanded="false"
                                    aria-controls="flush-{{ $index }}">
                                {{ $index + 1 . '. ' . $user->name }}
                            </button>
                        </h2>
                        <div id="flush-{{ $index }}" class="accordion-collapse collapse"
                             data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12 col-lg-11">
                                        <div class="d-flex flex-column">
                                            <p>Email: {{ $user->email }}
                                                @if($user->hasVerifiedEmail())
                                                    <span class="badge text-bg-success">Verified</span>
                                                @else
                                                    <span class="badge text-bg-danger">Non-verified</span>
                                                @endif
                                            </p>
                                            <p>Role: {{ ucfirst($user->getRoleName()) }}</p>
                                            <p>Registered at: {{ $user->created_at->format('d F Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-1 d-flex justify-content-center justify-content-lg-end">
                                        <div class="d-flex">
                                            <a href="{{ route('dashboard.user.edit', ['user_id' => $user->id]) }}"
                                               class="me-1">
                                                <button class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            </a>
                                            <form
                                                action="{{ route('dashboard.user.delete', ['user_id' => $user->id]) }}"
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
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
