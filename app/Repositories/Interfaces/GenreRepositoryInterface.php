<?php


namespace App\Repositories\Interfaces;


use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

interface GenreRepositoryInterface
{
    public function attach(Movie $movie, array $genres);

    public function all(): Collection;

    public function detach(Movie $movie, int $genreId);

    public function create(array $data);

    public function update(array $data, Genre $genre);

    public function delete(Genre $genre): void;
}
