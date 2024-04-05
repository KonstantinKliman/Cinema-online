<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\GenreServiceInterface;
use App\Services\Interfaces\MovieServiceInterface;
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

    public function index(): View
    {
        return view('index', [
            'movies' => $this->movieService->paginate(10),
            'genres' => $this->genreService->getAllGenres(),
            'filterData' => $this->movieService->getFilterData()
        ]);
    }

    public function adminIndex(): View
    {
        return view('admin.index');
    }
}
