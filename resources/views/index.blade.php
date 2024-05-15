@extends('layouts.main')

@section('title', 'Cinema-online')

@push('js')
    <script src="{{ asset('assets/js/script.js') }}"></script>
@endpush

@section('main')
    <div class="row my-3 d-flex justify-content-between">
        <div class="col-lg-3 col-6">
            <a class="btn btn-outline-light d-md-inline-flex align-items-center" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
               aria-controls="offcanvasExample">
                <i class="bi bi-funnel d-none d-lg-block me-lg-2"></i>
                Filter
            </a>
        </div>
        <div class="col-lg-9 col-6 d-flex justify-content-end align-items-center">
            <div class="h-auto"><p class="text-center me-2 mb-0 d-none d-lg-block me-lg-2">Sort by </p></div>
            <div class="h-100">
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
    </div>
    @component('components.offcanvas-filter', ['genres' => $genres, 'filterData' => $filterData])
    @endcomponent
    <div class="row my-3">
        @foreach($movies as $movie)
            <div class="col-sm-4 col-md-3 col-lg-2 my-3">
                @component('components.movie-card', ['movie' => $movie])
                @endcomponent
            </div>
        @endforeach
    </div>
@endsection
