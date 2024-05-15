@extends('layouts.dashboard')

@section('title', 'Cinema-online movies')

@section('main')
    <div class="row">
        <div class="col">
            <h3 class="mb-3 text-center">
                Reviews
            </h3>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col d-flex justify-content-center align-items-center mb-3">
            <a href="{{ route('dashboard.review.create') }}">
                <button class="btn btn-outline-light">
                    Create review
                </button>
            </a>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div class="accordion accordion-flush border" id="accordionFlushExample">
                @foreach($reviews as $index => $review)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#panelsStayOpen-{{ $index }}" aria-expanded="false" aria-controls="panelsStayOpen-{{ $index }}">
                                {{ $index + 1 . '. ' . $review->title }}
                                @if(!$review->is_published)
                                    <span class="badge text-bg-secondary ms-2">Not published</span>
                                @endif
                            </button>
                        </h2>
                        <div id="panelsStayOpen-{{ $index }}" class="accordion-collapse collapse">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-8 col-lg-10">
                                        <p>
                                            <strong>User:</strong>
                                            <a href="{{ route('dashboard.user.show', ['user_id' => $review->user->id]) }}"
                                               class="link text-light m-0">{{ $review->user->name }}</a>
                                        </p>
                                        <p>
                                            <strong>Type:</strong>
                                            {{ $review->type->name }}
                                        </p>
                                        <p>
                                            <strong>Title:</strong>
                                            {{ $review->title }}
                                        </p>
                                    </div>
                                    <div class="col-4 col-lg-2 d-flex justify-content-end">
                                        <form action="{{ route('dashboard.review.publish', ['review_id' => $review->id]) }}"
                                              method="post">
                                            @csrf
                                            @if($review->is_published)
                                                <button class="btn btn-sm me-1 btn-outline-secondary" type="submit">
                                                    <i class="bi bi-eye-slash"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-sm me-1 btn-outline-light" type="submit">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            @endif
                                        </form>
                                        <a href="{{ route('dashboard.review.edit', ['review_id' => $review->id]) }}"
                                           class="me-1">
                                            <button class="btn btn-sm btn-outline-success">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </a>
                                        <form action="{{ route('dashboard.review.delete', ['review_id' => $review->id]) }}"
                                              method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="col-12">
                                        <p>
                                            <strong>Review:</strong>
                                            {{ $review->review }}
                                        </p>
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
