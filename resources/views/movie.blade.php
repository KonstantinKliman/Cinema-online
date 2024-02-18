@extends('layouts.main')

@section('title', $movie->title)

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush

@section('main')
    <x-container>
        <div class="row">
            <div class="col-2 d-flex justify-content-start">
                <img src="{{ asset($movie->poster_file_path) }}" alt="" class="img-fluid rounded-3"
                     style="width: 300px; height: 400px">
            </div>
            <div class="col-10 text-start">
                <p><strong>Title</strong> : {{ $movie->title }}</p>
                <p><strong>Year</strong> : {{ $movie->release_year }}</p>
                <p><strong>Production studio</strong> : {{ $movie->production_studio }}</p>
                <p><strong>Country</strong> : {{ $movie->country }}</p>
                <p>
                    <strong>Genre</strong> :
                    @foreach($movie->genres as $genre)

                        <a href="{{ route('genre.page', ['genre_name' => $genre->name]) }}"
                           class="link">
                            {{ ucfirst($genre->name) }}</a>
                        @if(!$loop->last)
                            ,
                        @endif
                    @endforeach
                </p>
                <p class="text-break"><strong>Description</strong> : {{ $movie->description }}</p>
                <p><strong>Cinema-online rating</strong> : {{ $movie->rating }}</p>
                @if($persons)
                    <hr>
                    @foreach($persons as $key => $personItem)
                        <div class="d-flex flex-column w-100 mb-3">
                        <p class="m-0"><strong>{{ ucfirst($key) . 's:'}}</strong></p>
                        @foreach($personItem as $person)
                            <a class="link" href="{{ route('person-page', ['person_url' => $person->person_url]) }}"> {{ $person->full_name }}</a>
                        @endforeach
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-end">
                <div class="admin-btn ms-1">
                    <form action="{{ route('movie.delete', ['movie_id' => $movie->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger editContent p-2" type="submit">
                            <i class="bi bi-trash"></i>
                            Delete
                        </button>
                    </form>
                </div>
                <div class="admin-btn ms-1">
                    <a class="btn btn-outline-success editContent p-2" href="{{ route('edit-movie.page', ['movie_id' => $movie->id]) }}">
                        <i class="bi bi-pencil"></i>
                        Edit
                    </a>
                </div>
                <div class="admin-btn ms-1">
                    <form action="{{ route('publishMovie.action', ['movie_id' => $movie->id]) }}" method="post">
                        @csrf
                        @if(!$movie->is_published)
                            <button class="btn btn-outline-light editContent p-2" type="submit">
                                <i class="bi bi-eye"></i>
                                Publish
                            </button>
                        @else
                            <button class="btn btn-outline-secondary editContent p-2" type="submit">
                                <i class="bi bi-eye-slash"></i>
                                Hide
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </x-container>
    <div class="accordion mx-1 mb-3" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header bg-light-subtle">
                <button class="accordion-button bg-light-subtle text-light" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Watch online {{ $movie->title }}
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body d-flex justify-content-center">
                    <video class="object-fit-fill" controls>
                        <source src="{{ asset($movie->movie_file_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>
    </div>
    <x-header>
        {{__('Your rating')}}
    </x-header>
    <div class="row border rounded-3 p-3 mx-1 my-3 bg-light-subtle">
        @if(auth()->check())
            <div class="row d-flex justify-content-center">
                <form action="{{ route('createRating.action', ['movie_id' => $movie->id]) }}" method="post"
                      class="d-flex flex-column w-25">
                    @csrf
                    <select class="col-4 bg-dark px-1 m-1 ms-0 form-select @error('rating') is-invalid @enderror"
                            aria-label="Default select example"
                            name="rating">
                        <option selected disabled>Rating</option>
                        @for($i = 1; $i < 6; $i++)
                            <option value="{{ $i }}" {{ $userRating == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                    <button type="submit" class="btn btn-outline-light my-1">
                        {{__('Rate film')}}
                    </button>
                    @error('rating')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </form>
            </div>
        @else
            <div class="col d-flex justify-content-center align-items-center">
                <p class="m-0">
                    To rate film please
                    <a href="{{ route('register.page') }}" class="text-decoration-none text-light">
                        <strong>register</strong>
                    </a> or
                    <a href="{{ route('login.page') }}" class="text-decoration-none text-light">
                        <strong>login</strong>
                    </a>
                </p>
            </div>
        @endif
    </div>
    <x-header>
        {{__('Comments')}}
    </x-header>
    <div class="row border rounded-3 p-3 mx-1 my-3 bg-light-subtle">
        @foreach($movie->comments as $comment)
            <div class="row d-flex justify-content-center border-bottom px-0 py-3 m-0">
                <div class="col-1">
                    <img src="{{ asset($comment->user->profile->avatar) }}" alt="" class="img-fluid rounded-circle">
                </div>
                <div class="col-11 d-flex justify-content-between">
                    <div class="comment">
                        <h5 class="username">{{ $comment->user->name }}</h5>
                        <p class="content">{{ $comment->content }}</p>
                    </div>
                    @if($user->id == $comment->user->id)
                    <div class="icons">
                        <form action="{{ route('deleteComment.action', ['comment_id' => $comment->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-light editContent p-0" type="submit">
                                <i class="bi bi-x-lg mx-1"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach
        <div class="row rounded-3 p-3 mx-1 my-3 bg-light-subtle">
            @if(auth()->check())
                <form action="{{ route('createComment.action', ['movie_id' => $movie->id]) }}" method="post">
                    @csrf
                    <textarea name="content" id="" cols="30" rows="10" class="w-100 p-2 bg-dark"
                              placeholder="Leave your comment here"></textarea>
                    <button type="submit" class="btn btn-outline-light w-100 my-1">Submit</button>
                </form>
            @else
                <div class="col d-flex justify-content-center align-items-center">
                    <p class="m-0">
                        To leave comments please
                        <a href="{{ route('register.page') }}" class="text-decoration-none text-light">
                            <strong>register</strong>
                        </a> or
                        <a href="{{ route('login.page') }}" class="text-decoration-none text-light">
                            <strong>login</strong>
                        </a>
                    </p>
                </div>
            @endif
        </div>
@endsection
