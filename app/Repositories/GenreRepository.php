<?php


namespace App\Repositories;


use App\Models\Genre;
use App\Models\Movie;
use App\Repositories\Interfaces\GenreRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GenreRepository implements GenreRepositoryInterface
{
    public function create(Movie $movie, array $genres)
    {
        return $movie->genres()->attach($genres);
    }

    public function findByGenreName(string $genreName)
    {
        return Genre::where('name', $genreName)->first();
    }

    public function all(): Collection
    {
        return Genre::all();
    }
}
