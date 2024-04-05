@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
@endpush
<div class="card text-bg-dark">
    <img src="{{ asset($movie->poster_file_path) }}" class="card-img" alt="posterFilePath">
    <div class="card-img-overlay d-flex justify-content-between flex-column">
        <div class="card-info">
            <h5 class="card-title">{{ $movie->title }}</h5>
            <p class="card-text text-truncate h-auto">{{ $movie->description }}</p>
        </div>
        <a class="btn btn-outline-light btn-watch-now" href="{{ route('movie.page', ['movie_id' => $movie->id]) }}">Watch now</a>
    </div>
</div>
