<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\GenreServiceInterface;
use Illuminate\View\View;

class GenreController extends Controller
{

    private GenreServiceInterface $genreService;

    public function __construct(GenreServiceInterface $genreService)
    {
        $this->genreService = $genreService;
    }

    public function showGenrePage($genreName): View
    {
        return view('genre-movies', [
            'genre' => $this->genreService->getGenreByName($genreName),
            'movies' => $this->genreService->getMoviesByGenreName($genreName),
        ]);
    }


    public function getGenresForHeader()
    {
        $genres = $this->genreService->getAllGenres();
        return $genres;
    }
}
