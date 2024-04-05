@extends('layouts.admin')

@section('title', 'Cinema-online movies')

@section('main')
    <div class="row">
        <div class="col">
            <x-header>
                Reviews
            </x-header>
        </div>
    </div>
    <div class="row d-flex justify-content-center">
        <div class="col d-flex justify-content-center align-items-center mb-3">
            <a href="{{ route('admin.review.create') }}">
                <button class="btn btn-outline-light">
                    Create review
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
                    <th>User</th>
                    <th>Title</th>
                    <th>Review</th>
                    <th>Type</th>
                    <th>Published</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reviews as $index => $review)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><a href="{{ route('admin.user.show', ['user_id' => $review->user->id]) }}" class="link text-light m-0">{{ $review->user->name }}</a></td>
                        <td><a href="{{ route('admin.review.show', ['review_id' => $review->id]) }}" class="link text-light m-0">{{ $review->title }}</a></td>
                        <td>{{ mb_strimwidth($review->review, 0, 50, '...') }}</td>
                        <td>
                            @foreach($review->getReviewType() as $typeIndex => $type)
                                @if($typeIndex == $review->type)
                                    <p class="{{$type}}-review">{{ ucfirst($type) }}</p>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @if($review->is_published)
                                <i class="bi bi-check-lg text-success"></i>
                            @else
                                <i class="bi bi-x-lg text-danger"></i>
                            @endif</td>
                        <td>
                            <div class="d-flex">
                                <form action="{{ route('admin.review.publish', ['review_id' => $review->id]) }}" method="post">
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
                                <a href="{{ route('admin.review.edit', ['review_id' => $review->id]) }}" class="me-1">
                                    <button class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                </a>
                                <form action="{{ route('admin.review.delete', ['review_id' => $review->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" type="submit">
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
