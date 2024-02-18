<?php


namespace App\Services\Interfaces;


use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

interface GenreServiceInterface
{
    public function createGenreForMovie(Movie $movie, array $genres);
    public function getMoviesByGenreName(string $genreName);
    public function getAllGenres(): Collection;
    public function getGenreByName(string $genreName);
}
