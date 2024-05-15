<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\EditMovieRequest;
use App\Http\Requests\Application\FilterMovieRequest;
use App\Http\Requests\Application\MovieSearchRequest;
use App\Http\Requests\Application\CreateMovieRequest;
use App\Http\Requests\Application\SortMovieRequest;
use App\Services\Interfaces\GenreServiceInterface;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\RatingServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MovieController extends Controller
{

    private MovieServiceInterface $movieService;

    public function __construct(MovieServiceInterface $movieService)
    {
        $this->movieService = $movieService;
    }

    public function showMoviePage(Request $request, $movieId): View
    {
        return view('movie.main', [
            'movie' => $this->movieService->getMovieItem($movieId),
            'user' => $request->user(),
            'rating' => $this->movieService->getUserRatingOnMovie($request->user()->id, $movieId),
            'person' => $this->movieService->getPersonOnMovie($movieId, $request),
        ]);
    }

    public function searchMovie(MovieSearchRequest $request): View //
    {
        return view('movie.search-result',
            [
                'movies' => $this->movieService->searchMovie($request->validated('query')),
                'request_query' => $request->input('query'),
            ]);
    }

    public function delete($movieId): RedirectResponse //
    {
        $this->movieService->delete((int)$movieId);
        return redirect()->route('dashboard.movie.index');
    }

    public function publish($movieId): RedirectResponse //
    {
        $this->movieService->publish($movieId);
        return redirect()->back();
    }

    public function sort(SortMovieRequest $request): View //
    {
        return view('movie.main', [
            'movies' => $this->movieService->sort($request->validated('sort')),
            'genres' => $this->movieService->getAllGenres(),
            'filterData' => $this->movieService->getFilterData(),
        ]);
    }

    public function filter(FilterMovieRequest $request): View //
    {
        return view('movie.search-result', [
            'movies' => $this->movieService->filter($request),
            'genres' => $this->movieService->getAllGenres(),
            'filterData' => $this->movieService->getFilterData(),
        ]);
    }

    public function streamMovie($movieId): BinaryFileResponse //
    {
        return response()->file($this->movieService->getMovieFilePath($movieId), [
            'Content-Type' => 'video/mp4',
            'Accept-Ranges' => 'bytes',
        ]);
    }

    public function index(): View //
    {
        return view('dashboard.movie.index', ['movies' => $this->movieService->all()]);
    }

    public function create(): View //
    {
        return view('dashboard.movie.create', ['genres' => $this->movieService->getAllGenres()]);
    }

    public function store(CreateMovieRequest $request): RedirectResponse //
    {
        return redirect()->back()->with($this->movieService->createMovie($request));
    }

    public function adminShow(int $movieId, Request $request): View
    {
        return view('dashboard.movie.show', [
            'movie' => $this->movieService->getMovieItem($movieId),
            'person' => $this->movieService->getPersonOnMovie($movieId, $request),
        ]);
    }

    public function edit(int $movieId): View
    {
        return view('dashboard.movie.edit', [
            'movie' => $this->movieService->getMovieItem($movieId),
            'genres' => $this->movieService->getAllGenres(),
        ]);
    }

    public function update(int $movieId, EditMovieRequest $request): RedirectResponse
    {
        $this->movieService->edit($movieId, $request);
        return redirect()->route('dashboard.movie.show', ['movie_id' => $movieId]);
    }
}
