@extends('layouts.main')

@section('title', $movie->title)

@section('main')
    <h1 class="text-center my-3">{{ $movie->title }}</h1>
    <div class="row mt-3 border rounded-3 p-3 mx-1 mb-3 bg-light-subtle">
        <div class="col-2 d-flex justify-content-start">
            <img src="{{ asset($movie->poster_file_path) }}" alt="" class="img-fluid rounded-3"
                 style="width: 300px; height: 400px">
        </div>
        <div class="col-10 text-start">
            <p><strong>Title</strong> : {{ $movie->title }}</p>
            <p><strong>Description</strong> : {{ $movie->description }}</p>
        </div>
    </div>
{{--    mt-3 border rounded-3 p-3 bg-light-subtle--}}
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
    <div class="mx-1 my-3">
        <h1 class="text-center">Comments</h1>
    </div>
@endsection
