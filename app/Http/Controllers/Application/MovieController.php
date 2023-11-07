<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\UploadMovieRequest;
use App\Models\Movie;
use App\Services\MovieService;

class MovieController extends Controller
{

    private MovieService $movieService;

    public function __construct(MovieService $movieService)
    {
        $this->movieService = $movieService;
    }

    public function showMovieCreateForm()
    {
        return view('add-movie-form');
    }

    public function createMovie(UploadMovieRequest $request)
    {
        $message = $this->movieService->createMovie($request);
        return redirect()->back()->with($message);
    }

    public function showMoviePage($movieId)
    {
        return view('movie', ['movie' => Movie::where('id', $movieId)->first()]);
    }
}
