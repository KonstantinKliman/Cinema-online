<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
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
}
