<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\EditMovieRequest;
use App\Http\Requests\Application\MovieSearchRequest;
use App\Http\Requests\Application\CreateMovieRequest;
use App\Http\Requests\Application\SortMovieRequest;
use App\Services\Interfaces\GenreServiceInterface;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\RatingsServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class MovieController extends Controller
{

    private MovieServiceInterface $movieService;
    private RatingsServiceInterface $ratingsService;
    private GenreServiceInterface $genreService;

    public function __construct(MovieServiceInterface $movieService, RatingsServiceInterface $ratingsService, GenreServiceInterface $genreService)
    {
        $this->movieService = $movieService;
        $this->ratingsService = $ratingsService;
        $this->genreService = $genreService;
    }

    public function showMovieCreateForm(): View
    {
        return view('add-movie-form', ['genres' => $this->genreService->getAllGenres(), 'movie' => null]);
    }

    public function createMovie(CreateMovieRequest $request): RedirectResponse
    {
        ;
        return redirect()->back()->with($this->movieService->createMovie($request));
    }

    public function showMoviePage(Request $request, $movieId): View
    {
        return view('movie', [
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
        return view('search-result-page',
            [
                'movies' => $this->movieService->searchMovie($request->validated('query')),
                'request_query' => $request->input('query'),
            ]);
    }

    public function deleteMovie($movieId)
    {
        $this->movieService->delete($movieId);
        return redirect('/');
    }

    public function showEditMovieForm($movieId): View
    {
        return view('edit-movie-form', [
            'movie' => $this->movieService->getMovieItem($movieId),
            'genres' => $this->genreService->getAllGenres(),
        ]);
    }

    public function editMovie($movieId, EditMovieRequest $request)
    {
        $this->movieService->edit($movieId, $request);
        return redirect('/movie/' . $movieId);
    }

    public function publishMovie($movieId): RedirectResponse
    {
        $this->movieService->publish($movieId);
        return redirect()->back();
    }

    public function sort(SortMovieRequest $request)
    {
        return view('home', [
            'movies' => $this->movieService->sort($request->validated('sort')),
            'genres' => $this->genreService->getAllGenres(),
        ]);
    }
}
