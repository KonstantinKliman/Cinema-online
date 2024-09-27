@extends('layouts.dashboard')

@section('title', 'Person role')

@section('main')
    <div class="row">
        <div class="col d-flex align-items-center flex-column">
            <h3 class="mb-3">Role for persons</h3>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col d-flex justify-content-center align-items-center mb-3">
            <a href="{{ route('dashboard.person.role.create') }}">
                <button class="btn btn-outline-light me-1">
                    Create person role
                </button>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="accordion accordion-flush border" id="accordionFlushExample">
                @foreach($roles as $index => $role)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-{{ $index }}" aria-expanded="false" aria-controls="panelsStayOpen-{{ $index }}">
                                {{ $index + 1 . '. ' . $role->name }}
                            </button>
                        </h2>
                        <div id="panelsStayOpen-{{ $index }}" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-12 col-lg-11 d-flex align-items-center">
                                        <div class="d-flex flex-column">
                                            <p class="m-0">Name: {{ $role->name }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-1 d-flex justify-content-center justify-content-lg-end">
                                        <div class="d-flex">
                                            <a href="{{ route('dashboard.role.edit', ['role_id' => $role->id]) }}" class="me-1">
                                                <button class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            </a>
                                            <form action="{{ route('dashboard.role.delete', ['role_id' => $role->id]) }}"
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
