<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditGenreRequest;
use App\Http\Requests\Application\CreateGenreRequest;
use App\Models\Genre;
use App\Services\Interfaces\GenreServiceInterface;
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

    public function index()
    {
        return view('admin.genres.index', ['genres' => $this->genreService->getAllGenres()]);
    }

    public function adminShow(Genre $genre)
    {
        return view('admin.genres.show', [
            'genre' => $genre,
            'movies' => $this->genreService->getMoviesByGenre($genre),
        ]);
    }

    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', ['genre' => $genre]);
    }

    public function update(EditGenreRequest $request, Genre $genre)
    {
        $slug = $this->genreService->edit($request, $genre);
        return redirect()->route('admin.genre.edit', $slug);
    }

    public function create()
    {
        return view('admin.genres.create');
    }

    public function store(CreateGenreRequest $request)
    {
        $this->genreService->create($request);
        return redirect()->back();
    }

    public function detach($genreId, $movieId)
    {
        $this->genreService->detach($genreId, $movieId);
        return redirect()->back();
    }

    public function delete(Genre $genre)
    {
        $this->genreService->delete($genre);
        return redirect()->back();
    }
}
