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
    private RatingServiceInterface $ratingsService;
    private GenreServiceInterface $genreService;

    public function __construct(MovieServiceInterface $movieService, RatingServiceInterface $ratingsService, GenreServiceInterface $genreService)
    {
        $this->movieService = $movieService;
        $this->ratingsService = $ratingsService;
        $this->genreService = $genreService;
    }

    public function showMovieCreateForm(): View
    {
        return view('movie.add', ['genres' => $this->genreService->getAllGenres(), 'movie' => null]);
    }

    public function createMovie(CreateMovieRequest $request): RedirectResponse
    {
        return redirect()->back()->with($this->movieService->createMovie($request));
    }

    public function showMoviePage(Request $request, $movieId): View
    {
        return view('movie.main', [
            'movie' => $this->movieService->getMovieItem($movieId),
            'user' => $request->user(),
            'userRating' => $request->user()?->id
                ? $this->ratingsService->getUserRatingOnMovie($request->user()->id, $movieId)
                : null,
            'persons' => $this->movieService->getPersonOnMovie($movieId, $request),
        ]);
    }

    public function searchMovie(MovieSearchRequest $request): View
    {
        return view('movie.search-result',
            [
                'movies' => $this->movieService->searchMovie($request->validated('query')),
                'request_query' => $request->input('query'),
            ]);
    }

    public function deleteMovie($movieId): RedirectResponse
    {
        $this->movieService->delete((int)$movieId);
        return redirect('/');
    }

    public function showEditMovieForm($movieId): View
    {
        return view('movie.edit', [
            'movie' => $this->movieService->getMovieItem($movieId),
            'genres' => $this->genreService->getAllGenres(),
        ]);
    }

    public function editMovie($movieId, EditMovieRequest $request): RedirectResponse
    {
        $this->movieService->edit($movieId, $request);
        return redirect('/movie/' . $movieId);
    }

    public function publishMovie($movieId): RedirectResponse
    {
        $this->movieService->publish($movieId);
        return redirect()->back();
    }

    public function sort(SortMovieRequest $request): View
    {
        return view('movie.main', [
            'movies' => $this->movieService->sort($request->validated('sort')),
            'genres' => $this->genreService->getAllGenres(),
            'filterData' => $this->movieService->getFilterData(),
        ]);
    }

    public function filter(FilterMovieRequest $request): View
    {
        return view('movie.search-result', [
            'movies' => $this->movieService->filter($request),
            'genres' => $this->genreService->getAllGenres(),
            'filterData' => $this->movieService->getFilterData(),
        ]);
    }

    public function streamMovie($movieId): BinaryFileResponse
    {
        return response()->file($this->movieService->getMovieFilePath($movieId), [
            'Content-Type' => 'video/mp4',
            'Accept-Ranges' => 'bytes',
        ]);
    }
}
