<?php


namespace App\Services\Interfaces;


use App\Http\Requests\Admin\EditGenreRequest;
use App\Http\Requests\Application\CreateGenreRequest;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

interface GenreServiceInterface
{
    public function createGenreForMovie(Movie $movie, array $genres);

    public function getMoviesByGenre(Genre $genre);

    public function getAllGenres(): Collection;

    public function detach(int $genreId, int $movieId);

    public function create(CreateGenreRequest $request);

    public function edit(EditGenreRequest $request, Genre $genre): string;

    public function delete(Genre $genre): void;

}
