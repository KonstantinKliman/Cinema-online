@extends('layouts.main')

@section('title', 'Cinema-online')

@push('js')
    <script src="{{ asset('assets/js/script.js') }}"></script>
@endpush

@section('main')
    <div class="row my-3">
        <div class="col-2">
            <a class="btn btn-outline-light" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
               aria-controls="offcanvasExample">
                <i class="bi bi-funnel"></i>
                Filter
            </a>
        </div>
        <div class="col-8">
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
        <div class="col-2 d-flex justify-content-end align-items-center">
            <p class="m-0 me-2">Sort by </p>
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
    <div class="d-flex justify-content-center my-3">
        <a href="{{ route('create-movie-form.page') }}" class="btn btn-outline-light mx-3">Add movie</a>
        <a href="{{ route('create-person-form.page') }}" class="btn btn-outline-light mx-3">Add person</a>
    </div>
    @component('components.offcanvas-filter', ['genres' => $genres, 'filterData' => $filterData])
    @endcomponent
    <div class="row my-3">
        @foreach($movies as $movie)
            <div class="col-2 my-3">
                @component('components.movie-card', ['movie' => $movie])
                @endcomponent
            </div>
        @endforeach
    </div>
@endsection
