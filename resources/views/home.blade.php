@extends('layouts.main')

@section('title', 'Cinema-online')

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let sortSelect = document.getElementById('sortSelect');

            sortSelect.addEventListener('change', function () {
                document.getElementById('sortForm').submit();
            });

            let currentSort = new URL(window.location.href).searchParams.get('sort');
            if (currentSort) {
                sortSelect.value = currentSort;
            }
        });
    </script>
@endpush

@section('main')
    <div class="row my-3">
        <div class="col">
            <form method="get" action="{{ route('movie.search') }}">
                <div class="d-flex justify-content-center">
                    <input class="form-control me-2 w-25" placeholder="Search" aria-label="Search" name="query">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="bi bi-search"></i>
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-center my-3">
        <a href="{{ route('create-movie-form.page') }}" class="btn btn-outline-light mx-3">Add movie</a>
        <a href="{{ route('create-person-form.page') }}" class="btn btn-outline-light mx-3">Add person</a>
    </div>
    <div class="row">
        <div class="col-6">
            <a class="btn btn-outline-light" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                <i class="bi bi-funnel"></i>
                Filter
            </a>
        </div>
        <div class="col-6 d-flex justify-content-end align-items-center">
            <p class="m-0 me-2">Sort by  </p>
            <form id="sortForm" action="{{ route('sort') }}" method="get">
                <select id="sortSelect" class="form-select" aria-label="Default select example" name="sort">
                    <option value="desc">Descending</option>
                    <option value="asc">Ascending</option>
                    <option value="newest_upload">Newest upload</option>
                    <option value="oldest_upload">Oldest upload</option>
                    <option value="best_rating">Best rating</option>
                    <option value="worst_rating">Worst rating</option>
                    <option value="oldest_release_year">Oldest release year</option>
                    <option value="newest_release_year">Newest release year</option>
                </select>
            </form>
        </div>
    </div>
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
            <x-header class="offcanvas-title" id="offcanvasExampleLabel">Filter</x-header>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('movie.filter') }}" method="get" class="d-flex flex-column justify-content-between h-100 w-100">
                <div class="helper">
                    <div class="helper--year my-2">
                        <h5 class="text-center m-0 py-2 bg-light-subtle rounded-3 mb-2">Year:</h5>
                        <div class="w-100 d-flex justify-content-between">
                            <input class="w-25" type="number" name="min_rating" placeholder="From" min="0" max="5" step="1">
                            <input class="w-25" type="number" name="max_rating" placeholder="To" min="0" max="5" step="1">
                        </div>
                    </div>
                    <div class="helper--genre my-2">
                        <h5 class="text-center m-0 py-2 bg-light-subtle rounded-3">Genre:</h5>
                        <div class="form-check-inline p-0 mt-2" >
                            @foreach($genres as $genre)
                                <input type="checkbox" class="btn-check mb-1" name="genres[]" value="{{ $genre->id }}" id="{{ $genre->id }}" autocomplete="off">
                                <label class="btn mb-1" for="{{ $genre->id }}">{{ ucfirst($genre->name) }}</label>
                            @endforeach
                        </div>
                    </div>
                    <div class="helper--rating my-2">
                        <h5 class="text-center m-0 py-2 bg-light-subtle rounded-3 mb-2">Cinema-online rating:</h5>
                        <div class="w-100 d-flex justify-content-between">
                            <input class="w-25" type="number" name="min_rating" placeholder="From" min="0" max="5" step="1">
                            <input class="w-25" type="number" name="max_rating" placeholder="To" min="0" max="5" step="1">
                        </div>
                    </div>
                    <div class="helper--rating my-2">
                        <h5 class="text-center m-0 py-2 bg-light-subtle rounded-3 mb-2">Country</h5>
                        @foreach($movies as $movie)
                            <input type="checkbox" class="btn-check mb-1" name="country[]" value="{{ $movie->country }}" id="{{ $movie->country }}" autocomplete="off">
                            <label class="btn mb-1" for="{{ $movie->country }}">{{ $movie->country }}</label>
                        @endforeach
                    </div>
                </div>
                <button class="btn btn-outline-light" type="submit">Accept</button>
            </form>
        </div>
    </div>
    <div class="row my-3">
        @foreach($movies as $movie)
            <div class="col-2 my-3">
                @component('components.movie-card', ['movie' => $movie])
                @endcomponent
            </div>
        @endforeach
    </div>
@endsection
