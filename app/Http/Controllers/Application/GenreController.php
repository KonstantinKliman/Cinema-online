<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\EditGenreRequest;
use App\Http\Requests\Application\CreateGenreRequest;
use App\Models\Genre;
use App\Services\Interfaces\GenreServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use PhpParser\Node\Expr\BinaryOp\Greater;

class GenreController extends Controller
{

    private GenreServiceInterface $genreService;

    public function __construct(GenreServiceInterface $genreService)
    {
        $this->genreService = $genreService;
    }

    public function showGenrePage(Genre $genre): View
    {
        return view('genre.main', [
            'genre' => $genre,
            'movies' => $this->genreService->getMoviesByGenre($genre),
        ]);
    }

    public function index(): View
    {
        return view('dashboard.genres.index', ['genres' => $this->genreService->getAllGenres()]);
    }

    public function adminShow(Genre $genre): View
    {
        return view('dashboard.genres.show', [
            'genre' => $genre,
            'movies' => $this->genreService->getMoviesByGenre($genre),
        ]);
    }

    public function edit(Genre $genre): View
    {
        return view('dashboard.genres.edit', ['genre' => $genre]);
    }

    public function update(EditGenreRequest $request, Genre $genre): RedirectResponse
    {
        return redirect()->route('dashboard.genre.edit', $this->genreService->edit($request, $genre));
    }

    public function create(): View
    {
        return view('dashboard.genres.create');
    }

    public function store(CreateGenreRequest $request): RedirectResponse
    {
        $this->genreService->create($request);
        return redirect()->back();
    }

    public function detach($genreId, $movieId): RedirectResponse
    {
        $this->genreService->detach($genreId, $movieId);
        return redirect()->back();
    }

    public function delete(Genre $genre): RedirectResponse
    {
        $this->genreService->delete($genre);
        return redirect()->back();
    }
}
