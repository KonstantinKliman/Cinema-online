<?php


namespace App\Services;


use App\Http\Requests\Application\UploadMovieRequest;
use App\Models\Movie;

class MovieService
{
    private function isMovieExists(string $requestMovieTitle): bool
    {
        $movie = Movie::where('title', $requestMovieTitle)->first();

        return $movie !== null && $movie->title == $requestMovieTitle;
    }


    public function createMovie(UploadMovieRequest $request): array
    {
        if (!$this->isMovieExists($request->validated()['title'])) {
            $movie = new Movie();
            $movie->user_id = auth()->user()->id;
            $movie->title = $request->validated()['title'];
            $movie->description = $request->validated()['description'];
            $movie->movie_file_path = 'storage/' . $request->file('movie_file_path')->store('movies/' . $request->validated()['title']);
            $movie->poster_file_path = 'storage/' . $request->file('poster_file_path')->store('movies/' . $request->validated()['title']);
            $movie->save();
            return ['create_movie_success' => 'Movie "' . $request->validated()['title'] . '" uploaded.'];
        }
        return ['create_movie_error' => 'Movie "' . $request->validated()['title'] . '" already exists.'];
    }
}
