<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Role;
use App\Services\Interfaces\GenreServiceInterface;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\View\View;

class PagesController extends Controller
{

    private MovieServiceInterface $movieService;
    private GenreServiceInterface $genreService;

    public function __construct(MovieServiceInterface $movieService, GenreServiceInterface $genreService)
    {
        $this->movieService = $movieService;
        $this->genreService = $genreService;
    }

    public function showHomePage(): View
    {
        return view('home', [
            'movies' => $this->movieService->paginate(10),
            'genres' => $this->genreService->getAllGenres(),
            'filterData' => $this->movieService->getFilterData()
        ]);
    }
}
